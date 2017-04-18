<?php

class user{
	
	public $current_user_role = null;
	
	public $current_user_name = null;
	
	public $current_user_id = null;
	
	public $current_user_gender = '';
	
	public $email_verified = false;
	
	public $phone_verified = false;
	
	function __construct(){
		if( isset( $_SESSION['loggedIn'] ) ):
			if( isset( $_SESSION['current_user_id'] ) && $_SESSION['current_user_id'] != null ):
				$user_data = $this->get_user_data( $_SESSION['current_user_id'] );
				if( !empty( $user_data ) ):
					$this->current_user_role = $user_data->role;
					$this->current_user_name = $user_data->first_name . "&nbsp;" . $user_data->last_name;
					$this->current_user_id = $user_data->id;
					$this->current_user_gender = $user_data->gender;
					$this->email_verified = $user_data->email_verified;
					$this->phone_verified = $user_data->phone_verified;
				endif;
			endif;
		endif;
	}
	
	function is_logged_in(){
		if( isset( $_SESSION['loggedIn'] ) ):
			if( isset( $_SESSION['current_user_id'] ) && $_SESSION['current_user_id'] != null ):
				return true;
			endif;
		endif;
		
		return false;
	}
	
	function get_user_data( $user_id ){
		global $apl;
		global $db;
		
		$user_data = $db->get_results( "select * from ".$apl->user_table." where id = '".$user_id."' limit 1" );
		
		if( !empty( $user_data ) )
			return $user_data[0];
		else
			return false;
	}
	
	function add_user(){
		global $db;
		global $apl;
		$error = false;
		$error_message = array();
		
		if( isset( $_POST['submit'] ) ):
			$user_data['dialing_code'] = $_POST['dialing_code'];
			$user_data['phone_number'] = $_POST['phone_number'];
			
			if( empty( $user_data['dialing_code'] ) ):
				$error = true;
				$error_message[] = "Please select your country.";
			endif;
			if( empty( $user_data['phone_number'] ) ):
				$error = true;
				$error_message[] = "Please enter your phone number.";
			endif;
			if( strlen( $user_data['phone_number'] ) < 9 ):
				$error = true;
				$error_message[] = "Phone Number is incorrect";
			endif;
			
			if( !$error ):
				$user_data['verification_code'] = '3223'; //$apl->get_random_number( 4 );
				
				if( $this->phone_number_exists( $user_data['dialing_code'], $user_data['phone_number'] ) ){
					$update_data['verification_code'] = $user_data['verification_code'];
					$condition = array(
						'dialing_code' => $user_data['dialing_code'],
						'phone_number' => $user_data['phone_number']
					);
					if( true ):
						$output['success'] = true;
						echo json_encode( $output );
						die();
					else:
						$error = true;
						$output['success'] = false;
						$output['data'] = "An error occured! Please try again later" . mysql_error();
						echo json_encode( $output );
						die();
					endif;
				}else{
					if( $db->insert( $apl->user_table, $user_data ) ):
						$output['success'] = true;
						echo json_encode( $output );
						die();
					else:
						$error = true;
						$output['success'] = false;
						$output['data'] = "An error occured! Please try again later" . mysql_error();
						echo json_encode( $output );
						die();
					endif;
				}
			else:
				$output['success'] = false;
				$output['data'] = $error_message[0];
				echo json_encode( $output );
				die();
			endif;
		endif;
	}
	
	function sync_contacts(){
		global $apl;
		global $db;
		
		$registered_list = array();
$contact_list = $_POST['contact_list'];

$contact_list_formated = array();
$contact_list_array = array();
foreach( $contact_list as $key => $contact ){
	$contact_list_formated[$key] = $contact[0];
	$contact_list_formated[$key] = str_replace(' ', '', $contact_list_formated[$key]);
	$contact_list_formated[$key] = str_replace("-", "", $contact_list_formated[$key]);
	$contact_list_formated[$key] = ltrim($contact_list_formated[$key], '0');
	$contact_list_formated[$key] = substr($contact_list_formated[$key], -10);
	$contact_list[$key][0] = $contact_list_formated[$key];
	$contact_list_formated[$key] = "'".$contact_list_formated[$key]."'";
}
		$contact_list_formated = implode(',',$contact_list_formated);
		$result = $db->get_results("select * from ".$apl->user_table." where phone_number in (".$contact_list_formated.")");
		
		$return_data = array();
		$i = 0;
		foreach( $result as $key => $contactData ){
			foreach( $contact_list as $newKey => $contact ){
				if( $contact[0] == $contactData->phone_number ){
					$return_data[$i]['phone_number'] = $contact[0];
					$return_data[$i]['name'] = $contact[1];
					$return_data[$i]['profile_photo'] = $contactData->profile_photo;
					$return_data[$i]['profile_status'] = $contactData->status;
					$i++;
					break;
				}
			}
		}
		
		$output['success'] = true;
		$output['data'] = $return_data;
		echo json_encode( $output );
		die();
	}

	function send_message(){
		global $apl;
		global $db;

		$error = false;
		$error_message = array();
		
		if( isset( $_POST['submit'] ) ):
			$chat_data['sender_id'] = $_POST['sender_id'];
			$chat_data['receiver_id'] = $_POST['receiver_id'];
			$chat_data['message_type'] = $_POST['message_type'];
			$chat_data['message_content'] = $_POST['message_content'];
			
			if( empty( $chat_data['sender_id'] ) ):
				$error = true;
				$error_message[] = "Invalid Sender.";
			endif;
			if( empty( $chat_data['receiver_id'] ) ):
				$error = true;
				$error_message[] = "Invalid Receiver";
			endif;
			if( empty( $chat_data['message_content'] ) ):
				$error = true;
				$error_message[] = "Empty Message";
			endif;
			
			if( !$error ):
				if( $db->insert( $apl->messages_table, $chat_data ) ):
					$output['success'] = true;
					echo json_encode( $output );
					die();
				else:
					$error = true;
					$output['success'] = false;
					$output['data'] = "An error occured! Please try again later" . mysql_error();
					echo json_encode( $output );
					die();
				endif;
			else:
				$output['success'] = false;
				$output['data'] = $error_message[0];
				echo json_encode( $output );
				die();
			endif;
		endif;
	}

	function update_peer(){
		global $apl;
		global $db;

		$error = false;
		$error_message = array();
		
		if( isset( $_POST['submit'] ) ):
			$condition['phone_number'] = $_POST['user_id'];
			$peer_data['peer_id'] = $_POST['peer_id'];
			
			if( empty( $condition['phone_number'] ) ):
				$error = true;
				$error_message[] = "Invalid User.";
			endif;
			if( empty( $peer_data['peer_id'] ) ):
				$error = true;
				$error_message[] = "Invalid Peer";
			endif;
			
			if( !$error ):
				if( $db->update( $apl->user_table, $peer_data, $condition ) ):
					$output['success'] = true;
					echo json_encode( $output );
					die();
				else:
					$error = true;
					$output['success'] = false;
					$output['data'] = "An error occured! Please try again later" . mysql_error();
					echo json_encode( $output );
					die();
				endif;
			else:
				$output['success'] = false;
				$output['data'] = $error_message[0];
				echo json_encode( $output );
				die();
			endif;
		endif;
	}
	
	function get_conversation(){
		global $apl;
		global $db;
		
		if( isset( $_POST['submit'] ) ){
			$current_user = $_POST['current_user'];

			$update_data = array(
				'status'	=>	'Delivered'
			);
			$condition = array(
				'receiver_id'	=>	$current_user
			);
			
			//$db->update( $apl->messages_table, $update_data, $condition );
			$results = $db->get_results("SELECT MAX(id), sender_id, receiver_id FROM ".$apl->messages_table." WHERE sender_id='$current_user' OR receiver_id = '$current_user' Group By (if(sender_id > receiver_id,  sender_id, receiver_id)), (if(sender_id > receiver_id,  receiver_id, sender_id)) Order BY MAX(id) DESC");

			$conversations = array();
			foreach( $results as $key => $result ){
				$conversations[$key] = $result;
				$conversations[$key]->conversation = $this->get_messages( $result->sender_id, $result->receiver_id );
			}

			$output['success'] = true;
			$output['data'] = $conversations;
			echo json_encode( $output );
			die();
		}
	}

	
	function get_messages( $sender_id, $receiver_id, $page = null){
		global $apl;
		global $db;
		
		if( $page == null ){
			$page = 0;
		}
		if( $sender_id == '' || $receiver_id == '' ){
			return false;
		}
		$start = $page * 50;
		$results = $db->get_results("SELECT * FROM ".$apl->messages_table." WHERE (sender_id='$sender_id' AND receiver_id = '$receiver_id') OR (sender_id='$receiver_id' AND receiver_id = '$sender_id') Order BY date_time ASC LIMIT $start, 50");
		
		return $results;
	}

	function is_valid_email($email){
		if( strpos($email, "@") AND strpos($email, ".") ){
			return TRUE;
		}
		else {
			return FALSE;
		}
	}
	
	function phone_number_exists( $dialing_code, $phone_number ){
		global $apl;
		global $db;
		
		$result = $db->get_results( "select * from ".$apl->user_table." where dialing_code = '".$dialing_code."' and phone_number = '".$phone_number."'" );
		
		if( count( $result ) > 0 )
			return true;
		else
			return false;
	}
	
	function authenticate_user(){
		global $apl;
		global $db;
		$error = false;
		
		if( isset( $_POST['submit'] ) ):
			$email = $_POST['email'];
			$password = $_POST['password'];

			if( empty( $email ) ):
				$error = true;
				$error_message[] = "Email is required";
			endif;
			if( empty( $password ) ):
				$error = true;
				$error_message[] = "Password is required";
			endif;
			
			if( !$error ):
				$result = $db->get_results( "select * from ".$apl->user_table." where email = '".$email."' and password = '".md5($password)."' limit 1", OBJECT );
				
				if( count( $result ) > 0 ){
					$user_data = $result[0];
//					$this->current_user_role = $user_data->role;
					$this->current_user_name = $user_data->first_name . "&nbsp;" . $user_data->last_name;
					$this->current_user_id = $user_data->id;
					$_SESSION['loggedIn'] = true;
					$_SESSION['current_user_id'] = $this->current_user_id;
					$output['success'] = true;
					$output['data'] = '';
					echo json_encode( $output );
					die();
				}else{
					$error = true;
					$error_message[] = "Username and/or password is incorrect";
					$output['success'] = false;
					$output['data'] = '';
					$output['data'] .= '<div class = "error">
					<ul>';
					foreach( $error_message as $value ):
						$output['data'] .= '<li>'.$value.'</li>';
					endforeach;
					$output['data'] .= '</ul>
					</div>';
					echo json_encode( $output );
					die();
				}			
			else:
				$error = true;
				$output['success'] = false;
				$output['data'] = '';
				$output['data'] .= '<div class = "error">
				<ul>';
				foreach( $error_message as $value ):
					$output['data'] .= '<li>'.$value.'</li>';
				endforeach;
				$output['data'] .= '</ul>
				</div>';
				echo json_encode( $output );
				die();
			endif;
		else:
			$output['success'] = false;
			$output['data'] = 'Form not posted';
			echo json_encode( $output );
			die();
		endif;
	}
	
	function user_exists( $user_id ){
		global $apl;
		global $db;
		
		$result = $db->get_results( "select * from ".$apl->user_table." where id = '".$user_id."' limit 1" );
		
		if( count($result) > 0 )
			return true;
		
		return false;
	}
	
	function display_profile_edit_form(){
		global $apl;
		global $db;
		global $post;
		
		$user_id = $this->current_user_id;
		
		if( $this->user_exists( $user_id ) ){
			$user_details = $this->get_user_data( $user_id );
			$form = '';
			$form .= '<p class = "save_profile_button"><input type = "button" name = "save_profile_info" id = "save_profile_info" value = "Update" class = "button"></p>';
			$form .= '<p><label>First Name</label><input type = "text" name = "first_name" value = "'.$user_details->first_name.'"></p>';
			$form .= '<p><label>Last Name</label><input type = "text" name = "last_name" value = "'.$user_details->last_name.'"></p>';
			if( $user_details->gender == "Male" )
				$form .= '<p><label>Gender</label><select name = "gender"><option seleted>Male</option><option>Female</option></select></p>';
			else
				$form .= '<p><label>Gender</label><select name = "gender"><option>Male</option><option selected>Female</option></select></p>';
			$form .= '<p><label>D.O.B ( yyyy-mm-dd )</label><input type = "text" name = "dob" value = "'.$user_details->dob.'"></p>';
			$form .= '<p><label>Phone Number</label><input type = "text" name = "phone_number" value = "'.$user_details->phone_number.'"></p>';
			$form .= '<p><label>Address</label><textarea id = "address" name = "address">'.$user_details->address.'</textarea></p>';
			$form .= '<p class = "save_profile_button"><input type = "button" name = "save_profile_info" id = "save_profile_info" value = "Update" class = "button"></p>';
			
			$output['data'] = $form;
			echo json_encode( $output );
		}
		
		return false;
	}
	
	function display_settings_edit_form(){
		echo $this->get_settings_edit_form();
	}
	
	function get_settings_edit_form(){
		global $apl;
		global $db;
		global $post;
		
		$user_id = $this->current_user_id;
		
		if( $this->user_exists( $user_id ) ){
			$user_details = $this->get_user_data( $user_id );
			$form = '';
			$form .= '<p><label>New Password</label><input type = "password" name = "password" value = ""></p>';
			$form .= '<p><label>Re-type Password</label><input type = "password" name = "re_password" value = ""></p>';
			$form .= '<p class = "save_settings_button"><input type = "submit" name = "save_settings" id = "save_settings" value = "Update" class = "button"></p>';
			
			$output['data'] = $form;
			return json_encode( $output );
		}
		
		return false;
	}
	
	function update_password(){
		global $apl;
		global $db;
		
		$user_id = $this->current_user_id;
		if( $this->user_exists( $user_id ) ){
			$error = false;
			$error_message = array();
			
			if( isset( $_POST['submit'] ) ):
				$user_data = array();
				$password  = $_POST['password'];
				$re_password  = $_POST['re_password'];
				
				if( empty($password ) || empty( $re_password )):
					$error = true;
					$error_message[] = "Both fields are required";
				endif;
				if( $password != $re_password ):
					$error = true;
					$error_message[] = "Password did not match.";
				endif;
				if( strlen( $password ) < 6 ):
					$error = true;
					$error_message[] = "Password should be of minimum 6 characters.";
				endif;
				if( strlen( $password ) > 20 ):
					$error = true;
					$error_message[] = "Password should be of maximum 20 characters.";
				endif;
				
				if( !$error ):
					$condition = array(
						'id'	=>	$user_id
					);
					$data_array = array(
						'passwodr'	=>	md5( $password )
					);
					$db->update( $apl->user_table, $data_array, $condition );
					$output['success'] = true;
					$output['data'] = "<div class = 'updated'>Your password has been updated successfully</div>";
					echo json_encode( $output );
					die();
				else:
					$output['success'] = false;
					$output['data'] = '';
					$output['data'] .= '<div class = "error">
					<ul>';
					foreach( $error_message as $value ):
						$output['data'] .= '<li>'.$value.'</li>';
					endforeach;
					$output['data'] .= '</ul>
					</div>';
					echo json_encode( $output );
					die();
				endif;
			endif;
		}
	}
	
	function get_profile_info(){
		global $apl;
		global $db;
		
		$user_id = $this->current_user_id;
		
		if( $this->user_exists($user_id) ){
			$user_details = $this->get_user_data( $user_id );
			
			$profile_info = '';
			$profile_info .= '<p class = "edit_info_button"><input type = "button" name = "edit_profile_info" id = "edit_profile_info" value = "Edit" class = "button"></p>';
			$profile_info .= '<p><label>First Name</label><span>'.$user_details->first_name.'</span></p>';
			$profile_info .= '<p><label>Last Name</label><span>'.$user_details->last_name.'</span></p>';
			$profile_info .= '<p><label>Gender</label><span>'.$user_details->gender.'</span></p>';
			$profile_info .= '<p><label>D.O.B.</label><span>'.$user_details->dob.'</span></p>';
			$profile_info .= '<p><label>Email</label><span>'.$user_details->email.'</span></p>';
			$profile_info .= '<p><label>Phone Number</label><span>'.$user_details->phone_number.'</span></p>';
			$profile_info .= '<p><label>Address</label><span>'.$user_details->address.'</span></p>';
			$profile_info .= '<div class = "clear"></div><br>';
			
			$output['data'] = $profile_info;
			return json_encode( $output );
		}
		
	}
	
	function display_profile_info(){
		echo $this->get_profile_info();
	}
	
	function update_user_info(){
		global $apl;
		global $db;
		
		$user_id = $this->current_user_id;
		if( $this->user_exists( $user_id ) ){
			$error = false;
			$error_message = array();
			
			if( isset( $_POST['submit'] ) ):
				$user_data = array();
				$user_data['first_name'] = $_POST['first_name'];
				$user_data['last_name'] = $_POST['last_name'];
				$user_data['gender'] = $_POST['gender'];
				$user_data['dob'] = $_POST['dob'];
				$user_data['phone_number'] = $_POST['phone_number'];
				$user_data['address'] = $_POST['address'];
				
				if( empty( $user_data['first_name'] ) ):
					$error = true;
					$error_message[] = "First Name is required";
				endif;
				if( empty( $user_data['last_name'] ) ):
					$error = true;
					$error_message[] = "Last Name is required";
				endif;
				if( empty( $user_data['phone_number'] ) ):
					$error = true;
					$error_message[] = "Phone Number is required";
				endif;
				if( strlen( $user_data['phone_number'] ) < 10 ):
					$error = true;
					$error_message[] = "Phone Number is incorrect";
				endif;
				if( strlen( $user_data['phone_number'] ) > 10 ):
					$error = true;
					$error_message[] = "Phone Number must be entered without country code.";
				endif;
				
				if( !$error ):
					$condition = array(
						'id'	=>	$user_id
					);
					$db->update( $apl->user_table, $user_data, $condition );
					$output['success'] = true;
					echo json_encode( $output );
					die();
				else:
					$output['success'] = false;
					$output['data'] = '';
					$output['data'] .= '<div class = "error">
					<ul>';
					foreach( $error_message as $value ):
						$output['data'] .= '<li>'.$value.'</li>';
					endforeach;
					$output['data'] .= '</ul>
					</div>';
					echo json_encode( $output );
					die();
				endif;
			endif;
		}
	}
	
	function verify_phone_number(){
		global $apl;
		global $db;
		$error = false;
		$error_message = array();
		
		$verification_code = $_POST['verification_code'];
		$dialing_code = $_POST['dialing_code'];
		$phone_number = $_POST['phone_number'];
		
		$results = $db->get_results( "select * from ".$apl->user_table." where dialing_code = '".$dialing_code."' and phone_number = '".$phone_number."' and verification_code = '".$verification_code."'");
			
		if(count($results) > 0){
			$output['success'] = true;
			echo json_encode( $output );
			die();
		}else{
			$output['success'] = false;
			$output['data'] = "Verification code is incorrect";
			echo json_encode( $output );
			die();
		}
	}
	
	function logout(){
		session_destroy();
	}
	
	function is_admin(){
		if( $this->current_user_role == "admin" )
			return true;
		else
			return false;
	}
}

