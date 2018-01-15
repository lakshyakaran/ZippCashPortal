<?php

class user{

	public $user_logged_in = false;

	public $current_user_id = null;

	public $current_user_details = null;

	function __construct(){
		date_default_timezone_set('America/New_York');
		if( isset( $_SESSION['loggedIn'] ) ):
			if( isset( $_SESSION['current_user_id'] ) && $_SESSION['current_user_id'] != null ):
				$this->current_user_id = $_SESSION['current_user_id'];
			endif;
		endif;
	}

	function is_logged_in(){
		if( isset( $_SESSION['loggedIn'] ) ):
			if( isset( $_SESSION['currentUserID'] ) && $_SESSION['currentUserID'] != null ):
				return true;
			endif;
		endif;

		return false;
	}

	function set_user_logged_in($user_id){
		global $db;
		global $apl;
		global $post_data;

		$account_details = $this->get_user_account_details($user_id);
		if($account_details['success'] == true){
			$this->current_user_details = $account_details['data'];
			$this->current_user_id = $account_details['data']->user_id;
			return true;
		}

		return false;
	}

	function get_user_id_from_login_id($login_id){
		global $apl;
		global $db;

		$query = "select * from ".$apl->user_table." where login_id = '".$login_id."' limit 1";
		$results = $db->get_results($query);

		if(count($results)){
			return $results[0]->user_id;
		}

		return false;
	}

	function startSession(){
		global $db;
		global $apl;
		global $post_data;

		$error = false;
		$error_message = array();

		if(  !empty( $post_data ) ){

			$userDetails = $this->get_user_data_by_id( $post_data->userID );

			if ($userDetails){
				$_SESSION['loggedIn'] = true;
				$_SESSION['currentUserID'] = $userDetails->userID;
				$output['success'] = true;
				$output['data'] = $userDetails;
				echo json_encode( $output );
				die();
			}
		}

		$output['success'] = false;
		echo json_encode( $output );
		die();
	}

	function get_user_data( $user_id ){
		global $apl;
		global $db;

		$user_data = $db->get_results( "select * from ".$apl->user_table." where user_id = '".$user_id."' limit 1" );
		if( !empty( $user_data ) ){
			return $user_data[0];
		}

		return false;
	}

	function checkReferral(){
		global $db;
		global $apl;
		global $post_data;

		$error = false;
		$error_message = array();

		if( empty( $post_data->referral_id ) ):
			$error = true;
			$error_message[] = "Invalid referral ID.";
		endif;

		if( !$error ){
			$user_data = $db->get_results( "select * from ".$apl->user_table." where slug = '".$post_data->referral_id."' limit 1" );
			if(!empty($user_data)){
				$output['success'] = true;
				$output['data'] = $user_data;
			}else{
				$output['success'] = false;
				$output['error'] = 'The specified referral ID is invalid.';
			}
			echo json_encode( $output );
			die();
		}else{
			$output['success'] = false;
			$output['data'] = $error_message[0];
			echo json_encode( $output );
			die();
		}
	}

	function sendVerificationCode(){
		global $db;
		global $apl;
		global $post_data;

		$error = false;
		$error_message = array();

		if(  !empty( $post_data ) ){
			if( empty( $post_data->country_code ) ):
				$error = true;
				$error_message[] = "Please select your country.";
			endif;
			if( empty( $post_data->country_name ) ):
				$error = true;
				$error_message[] = "Missing Data.";
			endif;
			if( empty( $post_data->first_name ) ):
				$error = true;
				$error_message[] = "Please enter your first name.";
			endif;
			if( empty( $post_data->last_name ) ):
				$error = true;
				$error_message[] = "Please enter your last name.";
			endif;
			// if( empty( $post_data->email ) ){
			// 	$error = true;
			// 	$error_message[] = "Please enter your email.";
			// }else{
			// 	if($this->is_email_registered($post_data->email)){
			// 		if($this->is_email_verified($post_data->email)){
			// 			$error = true;
			// 			$error_message[] = "The email address is already registered.";
			// 		}
			// 	}
			// }
			if( empty( $post_data->phone ) ){
				$error = true;
				$error_message[] = "Tanpri antre nimewo telefòn ou.";
			}else{
				if($this->is_phone_registered($post_data->phone)){
					if($this->is_phone_verified($post_data->phone)){
						$error = true;
						$error_message[] = "The phone number is already registered.";
					}
				}
			}
			if( empty( $post_data->password ) ):
				$error = true;
				$error_message[] = "Tanpri antre modpas ou.";
			endif;
			if( empty( $post_data->dob ) ):
				$error = true;
				$error_message[] = "Please enter date of birth.";
			endif;
			if( !empty( $post_data->phone ) ):
				if( strlen( $post_data->phone ) < 6 ):
					$error = true;
					$error_message[] = "Nimewo Telefòn sa pa kòrèk";
				endif;
			endif;

			if( !$error ){
				$wallet_balance = null;
				$user_data['first_name'] = $post_data->first_name;
				$user_data['last_name'] = $post_data->last_name;
				// $user_data['email'] = $post_data->email;
				$user_data['phone'] = $post_data->phone;
				$user_data['country_code'] = $post_data->country_code;
				$user_data['country_name'] = $post_data->country_name;
				$user_data['dob'] = $post_data->dob;
				$user_data['password'] = md5($post_data->password);
				$user_data['verification_code'] = $apl->get_random_number(4);

				$user_data['user_type'] = 'individual';

				if( !empty( $post_data->referral_id ) ):
					$user_data['referral_id'] = $post_data->referral_id;
					$wallet_balance = 2;
				endif;

				if( $this->checkRegistered( 'boolean' ) ){
					$update_data['verification_code'] = $apl->get_random_number(4);
					$condition = array(
						'phone' => $user_data['phone'],
						'country_code' => $user_data['country_code']
					);
					if( $db->update( $apl->user_table, $update_data, $condition ) ){
						$text = $update_data['verification_code'] . ' is the verication code for registering at zippcash. Please do not share it with anyone for security purposes';
						$phone = str_replace("+", "", $user_data['phone']);
						$res = $this->sendText($text, $phone);
						$output['success'] = true;
						echo json_encode( $output );
						die();
					}else{
						$error = true;
						$output['success'] = false;
						$output['data'] = "An error occured! Please try again later" . mysql_error();
						echo json_encode( $output );
						die();
					}
				}else{
					if( $db->insert( $apl->user_table, $user_data ) ){
						$output['success'] = true;
						$user_id = $db->insert_id;
						if($user_data['user_type'] == 'individual'){
							$login_id = 'ZIPP'.$user_id;
						}else{
							$login_id = 'ZIPP'.$user_id;
						}
						$update_data = array(
							'status' => 'active',
							'login_id' => $login_id
						);
						$condition = array(
							'user_id' => $user_id
						);
						$db->update($apl->user_table, $update_data, $condition);
						if(!$this->create_user_wallet($user_id, $wallet_balance)){
							$output['success'] = false;
							$output['error'] = 'Unable to create wallet';
						}
						$text = ($user_data['verification_code'] . ' is the verication code for registering at zippcash. Please do not share it with anyone for security purposes');
						$phone = str_replace("+", "", $user_data['phone']);
						$this->sendText($text, $phone);
						echo json_encode( $output );
						die();
					}else{
						$error = true;
						$output['success'] = false;
						$output['data'] = "An error occured! Please try again later" . mysql_error();
						echo json_encode( $output );
						die();
					}
				}

			}else{
				$output['success'] = false;
				$output['data'] = $error_message[0];
				echo json_encode( $output );
				die();
			}
		}
	}

	function sendText($message, $phone){
		global $auth_id;
		global $auth_token;

	    $src = '15752151435';

	    $url = 'https://api.plivo.com/v1/Account/'.$auth_id.'/Message/';
	    
	    $data = array("src" => "$src", "dst" => "$phone", "text" => "$message");
	    
	    $data_string = json_encode($data);
	    
	    $ch=curl_init($url);
	    
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	    curl_setopt($ch, CURLOPT_HEADER, true);
	    curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
	    curl_setopt($ch, CURLOPT_USERPWD, $auth_id . ":" . $auth_token);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	    
	    $response = @curl_exec( $ch );
	    
	    @curl_close($ch);
	}

	function verifyVerificationCode(){
		global $JWT;
		global $apl;
		global $db;
		global $post_data;

		$error = false;
		$error_message = array();

		$verification_code = $post_data->verification_code;
		$phone = $post_data->phone;
		$country_code = $post_data->country_code;

		if ( !empty( $verification_code )  && !empty( $phone ) ){
			$results = $db->get_results( "select * from ".$apl->user_table." where phone = '".$phone."' and country_code = '".$country_code."' and verification_code = '".$verification_code."'");

			if(count($results) > 0){
				$login_id = $results[0]->login_id;
				$user_type = $results[0]->user_type;
				$token = array(
					"login_id" => $login_id,
					"user_type" => $user_type
				);
				$jwt = $JWT::encode($token, SECRET_KEY);

				$update_data['verification_code'] = '1111';
				$update_data['token'] = $jwt;
				$update_data['phone_verified'] = 'yes';
				$update_data['slug'] = str_replace(" ", "-", strtolower(trim($results[0]->first_name)));
				$exists = $this->get_one_value("select count(user_id) from ".$apl->user_table." where slug = '".$update_data['slug']."'");
				if($exists > 0){
					$update_data['slug'] = $update_data['slug'].$exists;
				}
				$condition = array(
					'phone' => $phone
				);
				$db->update( $apl->user_table, $update_data, $condition );
				$output['success'] = true;
				$output['data'] = $results[0];
				$output['updated'] = $update_data;
				$output['token'] = $jwt;
				echo json_encode( $output );
				die();
			}else{
				$output['success'] = false;
				$output['data'] = "Kòd Verifikasyon ou antre a pa kòrèk" . mysql_error();
				echo json_encode( $output );
				die();
			}
		}else {
			$output['success'] = false;
			$output['data'] = "Something went wrong.  Try again later";
			echo json_encode( $output );
			die();
		}
	}

	function reportProblem(){
		global $JWT;
		global $apl;
		global $db;
		global $post_data;

		$error = false;
		$error_message = array();

		$insert_data = array();
		$insert_data['user_id'] = $post_data->user_id;
		$insert_data['issue_type'] = $post_data->issue_type;
		$insert_data['issue_details'] = $post_data->issue_details;
		$insert_data['status'] = 'Active';

		if($insert_data['issue_details'] == null){
			$error = true;
			$error_message[] = "Invalid issue";
		}

		if(!$error){
			$message = '';
			$db->insert($apl->issue_table, $insert_data);
			if($this->current_user_details->user_type == "store"){
				$message .= $this->current_user_details->store_name . " reported an issue/suggestion";
			}else{
				$message .= $this->current_user_details->first_name . " " . $this->current_user_details->last_name . " reported an issue/suggestion";
			}

			$message .= '<br>' . $insert_data['issue_details'];
			$message .= '<br> Reported by user id: ' . $insert_data['user_id'];
			$subject = $insert_data['issue_type'];

			$header = "From:help@zippcash.com \r\n";
			$header .= "MIME-Version: 1.0\r\n";
			$header .= "Content-type: text/html\r\n";


			mail("zippcashapp@gmail.com", $subject, $message, $header);

			$output['success'] = true;
			$output['data'] = "Issue/Suggestion reported successfully";
			echo json_encode( $output );
			die();
		}else{
			$output['success'] = false;
			$output['data'] = $error_message[0];
			echo json_encode( $output );
			die();
		}
	}


	function sendTempVerificationCode(){
		global $db;
		global $apl;
		global $post_data;

		$error = false;
		$error_message = array();

		if(  !empty( $post_data ) ){
			// if( empty( $post_data->country_code ) ):
			// 	$error = true;
			// 	$error_message[] = "Please select your country.";
			// endif;
			// if( empty( $post_data->country_name ) ):
			// 	$error = true;
			// 	$error_message[] = "Missing Data.";
			// endif;
			// if( empty( $post_data->first_name ) ):
			// 	$error = true;
			// 	$error_message[] = "Please enter your first name.";
			// endif;
			// if( empty( $post_data->last_name ) ):
			// 	$error = true;
			// 	$error_message[] = "Please enter your last name.";
			// endif;
			// if( empty( $post_data->email ) ){
			// 	$error = true;
			// 	$error_message[] = "Please enter your email.";
			// }else{
			// 	if($this->is_email_registered($post_data->email)){
			// 		if($this->is_email_verified($post_data->email)){
			// 			$error = true;
			// 			$error_message[] = "The email address is already registered.";
			// 		}
			// 	}
			// }
			if( empty( $post_data->phone ) ){
				$error = true;
				$error_message[] = "Tanpri antre nimewo telefòn ou.";
			}else{
				if(!$this->is_phone_registered($post_data->phone) || !$this->is_phone_verified($post_data->phone)){
					$error = true;
					$error_message[] = "The phone number entered does not exists.";
				}else{
					$user_data['phone'] = $post_data->phone;
				}
			}
			if( !empty( $post_data->phone ) ){
				if( strlen( $post_data->phone ) < 6 ){
					$error = true;
					$error_message[] = "Nimewo Telefòn sa pa kòrèk";
				}
			}

			if( !$error ){
				// $user_data['first_name'] = $post_data->first_name;
				// $user_data['last_name'] = $post_data->last_name;
				// $user_data['email'] = $post_data->email;
				// $user_data['phone'] = $post_data->phone;
				// $user_data['country_code'] = $post_data->country_code;
				// $user_data['country_name'] = $post_data->country_name;
				// $user_data['password'] = md5($post_data->password);
				// $user_data['temp_verification_code'] = '1776';
				$user_data['temp_verification_code'] = $apl->get_random_number(4);
				$condition = array(
					'phone' => $user_data['phone'],
				);
				if( $db->update( $apl->user_table, $user_data, $condition ) ){
					$text = $user_data['temp_verification_code'] . ' is the verication code to reset password at zippcash. Please do not share it with anyone for security purposes';
					$phone = str_replace("+", "", $user_data['phone']);
					$res = $this->sendText($text, $phone);
					$output['success'] = true;
					echo json_encode( $output );
					die();
				}else{
					$error = true;
					$output['success'] = false;
					$output['data'] = "An error occured! Please try again later" . mysql_error();
					echo json_encode( $output );
					die();
				}
			}else{
				$output['success'] = false;
				$output['data'] = $error_message[0];
				echo json_encode( $output );
				die();
			}
		}
	}


	function verifyTempVerificationCode(){
		global $JWT;
		global $apl;
		global $db;
		global $post_data;

		$error = false;
		$error_message = array();

		$temp_verification_code = $post_data->temp_verification_code;
		$phone = $post_data->phone;

		if ( !empty( $temp_verification_code )  && !empty( $phone ) ){
			$results = $db->get_results( "select * from ".$apl->user_table." where phone = '".$phone."' and temp_verification_code = '".$temp_verification_code."'");

			if(count($results) > 0){
				$output['success'] = true;
				echo json_encode( $output );
				die();
			}else{
				$output['success'] = false;
				$output['data'] = "Kòd Verifikasyon ou antre a pa kòrèk" . mysql_error();
				echo json_encode( $output );
				die();
			}
		}else {
			$output['success'] = false;
			$output['data'] = "Something went wrong.  Try again later";
			echo json_encode( $output );
			die();
		}
	}

	function updatePassword(){
		global $JWT;
		global $apl;
		global $db;
		global $post_data;

		$error = false;
		$error_message = array();

		$temp_verification_code = $post_data->temp_verification_code;
		$phone = $post_data->phone;
		$password = $post_data->password;

		if ( !empty( $temp_verification_code )  && !empty( $phone ) && !empty( $password ) ){
			$updateData['password'] = md5($password);
			$updateData['temp_verification_code'] = NULL;
			$condition['temp_verification_code'] = $temp_verification_code;
			$condition['phone'] = $phone;

			if($db->update($apl->user_table, $updateData, $condition)){
				$output['success'] = true;
				$output['data'] = 'pwofil ou ajou avèk siksè.';
				echo json_encode($output);die;
			}
		}else {
			$output['success'] = false;
			$output['data'] = "Something went wrong.  Try again later";
			echo json_encode( $output );
			die();
		}
	}

	function changePassword(){
		global $JWT;
		global $apl;
		global $db;
		global $post_data;

		$error = false;
		$error_message = array();

		$current_password = $post_data->current_password;
		$phone = $post_data->phone;
		$password = $post_data->password;

		if ( !empty( $temp_verification_code )  && !empty( $phone ) && !empty( $password ) ){
			$updateData['password'] = md5($password);
			$condition['password'] = $current_password;
			$condition['phone'] = $phone;

			if($db->update($apl->user_table, $updateData, $condition)){
				$output['success'] = true;
				$output['data'] = 'pwofil ou ajou avèk siksè.';
				echo json_encode($output);die;
			}
		}else {
			$output['success'] = false;
			$output['data'] = "Something went wrong.  Try again later";
			echo json_encode( $output );
			die();
		}
	}

	function verifyUpdatedVerificationCode(){
		global $JWT;
		global $apl;
		global $db;
		global $post_data;

		$output['success'] = false;

		$verification_code = $post_data->verification_code;

		if($this->current_user_id == $post_data->user_id){
			$results = $db->get_results("select * from $apl->user_table where user_id = '".$this->current_user_id."' and verification_code = '".$verification_code."'");
			if(count($results)){
				if($results[0]->verification_code == 1111){
					$updateData['verification_code'] = '1776';
				}else{
					$updateData['verification_code'] = '1111';
				}
				$updateData['phone'] = $results[0]->new_phone;

				$condition['user_id'] = $this->current_user_id;
				if($db->update($apl->user_table, $updateData, $condition)){
					$output['success'] = true;
					$output['data'] = 'pwofil ou ajou avèk siksè.';
					echo json_encode($output);die;
				}
			}else{
				$output['data'] = 'Kòd Verifikasyon ou antre a pa kòrèk.';
				echo json_encode($output);die;
			}
		}else{
			$output['data'] = 'Envalid Itilizatè.';
			echo json_encode($output);die;
		}
	}

	function authenticateUser(){
		global $JWT;
		global $apl;
		global $db;
		global $post_data;
		$error = false;
		$output['data'] = null;

		if(empty($post_data->email)){
			$error = true;
			$output['data'] = "Tanpri antre adrès imel ou";
		}
		if(empty($post_data->password)){
			$error = true;
			$output['data'] = "Tanpri antre modpas ou";
		}

		if($error == false){
			$results = $db->get_results("select * from $apl->user_table where phone = '".$post_data->email."' and password = '".md5($post_data->password)."' and phone_verified = 'yes'");
			if(count($results)){
				if($results[0]->status === 'active'){
					$login_id = $results[0]->login_id;
					$user_type = $results[0]->user_type;
					$token = array(
						"login_id" => $login_id,
						"user_type" => $user_type
					);
					$jwt = $JWT::encode($token, SECRET_KEY);

					$error = false;
					$output['token'] = $jwt;
					$output['data'] = $results[0];
				}else{
					$error = true;
					$output['data'] = "Your account has been blocked. Please contact support.";					
				}
			}else{
				$error = true;
				$output['data'] = "Non itilizatè a pa valab oswa modpas. Eseye ankò";
			}
		}

		$output['success'] = !$error;
		echo json_encode($output);
		die;
	}

	function updateProfilePic(){
		global $apl;
		global $db;
		global $post_data;

		$condition['user_id'] = $this->current_user_id;
		$updateData['profile_pic'] = $post_data->profile_pic;

		$db->update($apl->user_table, $updateData, $condition);
		$output['success'] = true;
		echo json_encode( $output );
		die;
	}

	function updatePasscode(){
		global $apl;
		global $db;
		global $post_data;

		$condition['user_id'] = $this->current_user_id;
		$updateData['passcode'] = $post_data->passcode;
		$updateData['is_locked'] = false;

		$db->update($apl->user_table, $updateData, $condition);
		$output['success'] = true;
		echo json_encode( $output );
		die;
	}

	function getUnreadMessageCount(){
		global $apl;
		global $db;
		global $post_data;

		$condition['user_id'] = $this->current_user_id;

		$results = $db->get_results('select * from '.$apl->user_messages_table.' where to_user_id = "'.$this->current_user_id.'" and status = "unread" ');

		
		$output['success'] = true;
		$output['unreadMessageCount'] = count($results);
		echo json_encode( $output );
		die;
	}

	function getUserMessages(){
		global $apl;
		global $db;
		global $post_data;

		$condition['user_id'] = $this->current_user_id;

		$results = $db->get_results('select * from '.$apl->user_messages_table.' where to_user_id = "'.$this->current_user_id.'" and status = "unread" ');

		
		$output['success'] = true;
		$output['userMessages'] = $results;
		echo json_encode( $output );
		die;
	}

	function verifyPasscode(){
		global $apl;
		global $db;
		global $post_data;
		$error = false;
		$output['data'] = null;
		$output['redirect'] = false;

		if(empty($post_data->passcode)){
			$error = true;
			$output['data'] = "Tanpri antre modpas ou";
		}

		if($this->current_user_details->is_locked){
			$error = true;
			$output['data'] = "Your account has been locked due to three incorrect attempts.";
			$output['redirect'] = true;
		}else{
			if($post_data->passcodeAttempt){
				if($post_data->passcodeAttempt >= 3){
					$condition['user_id'] = $this->current_user_id;
					$updateData['is_locked'] = true;

					$db->update($apl->user_table, $updateData, $condition);

					$error = true;
					$output['data'] = "Your account has been locked due to three incorrect attempts.";
					$output['redirect'] = true;
				}
			}
		}


		if($error == false){
			$results = $db->get_results("select * from $apl->user_table where user_id = '".$this->current_user_id."' and passcode = '".$post_data->passcode."' and phone_verified = 'yes'");
			if(count($results)){
				
			}else{
				$error = true;
				$output['data'] = "Pa janm pataje modpas sa ak lòt moun.";
				$output['query'] = "select * from $apl->user_table where user_id = '".$this->current_user_id."' and passcode = '".$post_data->passcode."' and phone_verified = 'yes'";
			}
		}

		$output['success'] = !$error;
		echo json_encode($output);
		die;
	}

	function verifyDOB(){
		global $apl;
		global $db;
		global $post_data;

		$error = false;
		$output['data'] = null;
		$output['redirect'] = false;
		$output['success'] = false;

		if(!$post_data->dob){
			$error = true;
			$output['data'] = "Invalid date of birth";
		}

		if(!$error){
			$results = $db->get_results("select * from ".$apl->user_table." where dob = '".$post_data->dob."' and status = 'active'");

			if(count($results) > 0){
				$output['success'] = true;
				$output['data'] = "Provided date of birth is correct";
			}else{
				$output['data'] = "Invalid date of birth";
			}
		}

		echo json_encode($output);
		die;
	}

	function getLotteryList(){
		global $apl;
		global $db;
		global $post_data;

		$error = false;
		$error_message = array();
		$no_of_results = 10;
		if(isset($post_data->count)){
			$start = $post_data->count * $no_of_results;
		}
		$query = "select * from $apl->lottery_table where status != 'active' order by lottery_id desc limit ".$start.", ".$no_of_results."";
		$results = $db->get_results($query);

		$output['success'] = false;
		$output['data'] = null;
		$output['error'] = "Pa gen lotri.";

		$output['success'] = true;
		$output['data'] = $results;

		echo json_encode($output);
		die;
	}

	function getLotteryDetails(){
		global $apl;
		global $db;
		global $post_data;

		$error = false;
		$error_message = array();
		$lottery_id = $post_data->lottery_id;
		$user_id = $post_data->user_id;

		if($this->user_exists_by_id($user_id)){
			$query = "select * from $apl->lottery_table as lt, $apl->lottery_result_table as lrt where lt.lottery_id = '".$lottery_id."' and lt.lottery_id = lrt.lottery_id";
			$results = $db->get_results($query);

			$output['success'] = false;
			$output['data'] = null;
			$output['error'] = null;

			if(count($results)){
				$output['success'] = true;
				$output['data'] = $results[0];
				$output['data']->user_tickets = $this->get_user_tickets_by_lottery($lottery_id, $user_id);
				$output['error'] = null;
			}else{
				$output['success'] = false;
				$output['data'] = null;
				$output['error'] = "Specified lottery with id ".$lottery_id." not found.";
			}
		}else{
			$error_message[] = "Envalid Itilizatè";
		}
		echo json_encode($output);
		die;
	}

	function getNextLottery(){
		global $apl;
		global $db;
		global $post_data;

		$error = false;
		$error_message = array();

		$query = "select * from $apl->lottery_table where status != 'inactive' order by lottery_id desc limit 1";
		$results = $db->get_results($query);

		$output['success'] = false;
		$output['data'] = null;
		$output['error'] = "Pa gen lotri kap vini kounye a.";

		if(count($results)){
			$lottery_details = $results[0];
			$lottery_date_time = new DateTime($lottery_details->lottery_date_time);
			$current_date_time = new DateTime(date('Y-m-d H:i:s'));
			$countdown_time = $lottery_date_time->getTimestamp() - $current_date_time->getTimestamp();
			$output['success'] = true;
			$output['data'] = $results[0];
			$output['countdown_time'] = $countdown_time;
			$output['error'] = null;
		}
		echo json_encode($output);
		die;
	}

	function getLastLottery(){
		global $apl;
		global $db;
		global $post_data;

		$error = false;
		$error_message = array();

		$output['success'] = false;
		$output['data'] = null;
		$output['error'] = "Pa gen lotri kap vini kounye a.";

		$query = "select * from $apl->lottery_table where status = 'inactive' and lottery_name = 'Maten' order by lottery_id desc limit 1";
		$results = $db->get_results($query);


		if(count($results)){
			$lottery_details[] = $this->get_lottery_details($results[0]->lottery_id);
		}
		
		$query = "select * from $apl->lottery_table where status = 'inactive' and lottery_name = 'Aswè' order by lottery_id desc limit 1";
		$results = $db->get_results($query);


		if(count($results)){
			$lottery_details[] = $this->get_lottery_details($results[0]->lottery_id);
		}



		$output['success'] = true;
		$output['data'] = $lottery_details;
		// print_r($output);
		echo json_encode($output);
		die;
	}

	function searchUser(){
		global $apl;
		global $db;
		global $post_data;

		$error_message = null;
		$output['success'] = false;

		$user_list = $db->get_results("select * from $apl->user_table where login_id = '".$post_data->login_id."' or phone = '".$post_data->login_id."'");
		if(count($user_list) > 0){
			if($user_list[0]->user_id == $this->current_user_id){
				$output['data'] = 'ID oswa nimewo telefòn nan pa ka pou ou.';
			}else{
				$output['success'] = true;
				$output['data'] = $user_list[0];
			}
		}else{
			$output['data'] = 'ID oswa nimewo telefòn ou konpoze a pa egziste.';
		}

		echo json_encode($output);
		die;
	}

	function transferCredit(){
		global $apl;
		global $db;
		global $post_data;

		$error_message = null;
		$output['success'] = false;

		$amount_to_transfer = $post_data->amount;
		$receiver_login_id = $post_data->receiver_login_id;

		$sender_details = $this->get_user_account_details($this->current_user_id)['data'];
		$receiver_details = $this->get_user_account_details($this->get_user_id_from_login_id($receiver_login_id));

		if($receiver_details['success'] != false){
			$receiver_details = $receiver_details['data'];
			if($amount_to_transfer <= $sender_details->available_balance){
				$this->make_transaction($sender_details->user_id, $receiver_details->user_id, 'debit', 'credit_transfer', $amount_to_transfer);
				$this->make_transaction($receiver_details->user_id, $sender_details->user_id, 'credit', 'credit_transfer', $amount_to_transfer);
				$output['success'] = true;
				$output['data'] = "lajan an transfere avèk siksè.";
			}else{
				$output['data'] = "Envalid Itilizatè. Kantite lajan an pa ka transfere.";
			}
		}else{
			$output['data'] = "Envalid Itilizatè. Kantite lajan an pa ka transfere.";
		}

		echo json_encode($output);
		die;
	}

	function get_user_account_details($user_id){
		global $apl;
		global $db;
		global $post_data;

		$error_message = null;
		$output['success'] = false;

		$return_data = new stdClass();


		$user_details = $this->get_user_data($user_id);
		if($user_details == false){
			$error = true;
			$error_message = "No details found for store with id " . $user_id;
		}else{
			$query = "select * from ".$apl->user_wallet_table." as uwt, ".$apl->user_table." as ut where uwt.user_id = '".$user_id."' and uwt.user_id = ut.user_id";
			$result = $db->get_results($query);

			$return_data = $result[0];
			$return_data->currency = "Gourde";
			$output['success'] = true;
		}

		if($output['success'] == true){
			$output['data'] = $return_data;
		}else{
			$output['data'] = $message;
		}

		return $output;
	}

	function getCurrentUserBalance(){
		global $db;
		global $apl;
		global $post_data;

		$output = $this->get_user_account_details($this->current_user_id);

		echo json_encode($output);
		die;
	}

	function getRecentTransaction(){
		global $db;
		global $apl;
		global $post_data;
		$output['success'] = false;

		$transactions = $this->get_transactions($this->current_user_id, 1);
		if($transactions != false){
			foreach ($transactions as $key => $transaction) {
				if($transaction->transaction_name == "lottery_ticket_purchase"){
					$transactions[$key]->transaction_summary = "Kantite lajan ki debite pou achte tikè lotri.";
				}
				if($transaction->transaction_name == "deposit_transfer"){
					$transactions[$key]->transaction_summary = "Kantite lajan kredite pou depo lajan kach.";
				}
				if($transaction->transaction_name == "withdraw_transfer"){
					$transactions[$key]->transaction_summary = "Kantite lajan debite pou retrè sa.";
				}
				if($transaction->transaction_name == "account_recharge"){
					$transactions[$key]->transaction_summary = "Kantite lajan ki rechaje sou kont la.";
				}
				if($transaction->transaction_name == "credit_transfer"){
					if($transaction->transaction_type == "credit"){
						$transactions[$key]->transaction_summary = "lajan transfere de " . $transaction->first_name . " " . $transaction->last_name;
					}
					if($transaction->transaction_type == "debit"){
						$transactions[$key]->transaction_summary = "lajan transfere pou " . $transaction->first_name . " " . $transaction->last_name;
					}
				}
			}
			$output['success'] = true;
			$output['data'] = $transactions;
		}else{
			$output['data'] = 'Pa gen tranzaksyon';
		}

		echo json_encode($output);
		die;
	}

	function get_transactions($account_holder_id, $page = 1){
		global $db;
		global $apl;

		$start = ($page - 1) * 10;
		$limit = 10;

		$query = "select * from $apl->transaction_details_table as tdt, $apl->user_table as ut where tdt.account_holder_id = '".$account_holder_id."' and tdt.refrence_account_id = ut.user_id order by transaction_id desc limit ".$start.", ".$limit."";
		$results = $db->get_results($query);

		if(count($results)){
			return $results;
		}

		return false;
	}

	function addTicketDetails(){
		global $apl;
		global $db;
		global $post_data;

		$error = false;
		$error_message = array();
		$output['success'] = false;
		$output['redirect'] = false;
		$user_ticket = array();

		$user_ticket['user_id'] = $post_data->user_id;
		$user_ticket['lottery_id'] = $post_data->lottery_id;
		$user_ticket['purchased_on'] = date('Y-m-d H:i:s');
		$user_ticket['paid_on'] = date('Y-m-d H:i:s');
		$user_ticket['payment_status'] = 'paid';
		$user_ticket['purchased_by'] = 'user';
		$user_ticket['purchased_by_id'] = $this->current_user_id;
		$user_ticket['total_amount'] = 0;

		if($this->current_user_details->is_locked){
			$error = true;
			$output['redirect'] = true;
			$error_message[] = "Your account is locked. Please retrieve your passcode.";			
		}

		foreach($post_data->tickets as $key => $ticket){
			$post_data->tickets[$key]->number = strtolower($post_data->tickets[$key]->number);
			if(!preg_match('/^[0-9]{2}(([0-9]{1,3})|(x([0-9]{2})))?$/', $ticket->number)){
				$error = true;
				$error_message[] = "Invalid ticket number";
				break;
			}
			$user_ticket['total_amount'] += $ticket->amount;
		}

		if(!$error){
			if($this->current_user_id == $post_data->user_id){
				if($user_ticket['total_amount'] > 0){

					$this->make_transaction($user_ticket['user_id'], 0, 'debit', 'lottery_ticket_purchase', $user_ticket['total_amount']);
					$this->make_transaction(0, $user_ticket['user_id'], 'credit', 'lottery_ticket_purchase', $user_ticket['total_amount']);

					$db->insert($apl->user_ticket_table, $user_ticket);
					$ticket_id = $db->insert_id;
					if($ticket_id != null){
						$output['success'] = true;
						$output['data'] = new stdClass();
						$output['data']->ticket_id = $ticket_id;
						$output['data']->user_id = $post_data->user_id;
						$output['data']->total_amount = $user_ticket['total_amount'];

						foreach($post_data->tickets as $key => $ticket){
							$ticket_details = array();
							$ticket_details['user_id'] = $post_data->user_id;
							$ticket_details['ticket_id'] = $ticket_id;
							$ticket_details['ticket_number'] = $ticket->number;
							$ticket_details['ticket_amount'] = $ticket->amount;

							$db->insert($apl->ticket_details_table, $ticket_details);
						}
					}else{
						$error_message[] = "Unable to add ticket to database";
					}
				}else{
					$error_message[] = "kantite lajan ou rantre a pa valab";
				}
			}else{
				$error_message[] = "Envalid Itilizatè";
			}
		}

		$output['error'] = $error_message;

		echo json_encode($output);
		die;

	}

	function updateTicketDetails(){
		global $apl;
		global $db;
		global $post_data;

		$error_message = array();
		$output['success'] = false;

		if($this->user_exists_by_id($post_data->user_id)){
			$payment_data = array(
				'ticket_id' => $post_data->ticket_id,
				'total_amount' => $post_data->total_amount,
				'payment_type' => 'incoming',
				'payment_mode' => 'paypal_email',
				'payment_state' => $post_data->payment_response->state,
				'payment_id' => $post_data->payment_response->id,
				'payment_create_time' => $post_data->payment_response->create_time,
				'payment_intent' => $post_data->payment_response->intent,
				'client_platform' => $post_data->payment_client->platform,
				'client_paypal_sdk_version' => $post_data->payment_client->paypal_sdk_version,
				'client_product_name' => $post_data->payment_client->product_name,
				'client_environment' => $post_data->payment_client->environment,
				'payment_response_type' => $post_data->response_type
			);
			if($db->insert($apl->payment_details_table, $payment_data)){
				$update_data = array(
					'payment_status' => $post_data->payment_status,
					'paid_on' => date('Y-m-d H:i:s'),
					'payment_transaction_id' => $db->insert_id
				);
				$condition = array(
					'user_id' => $post_data->user_id,
					'ticket_id' => $post_data->ticket_id
				);
				if($db->update($apl->user_ticket_table, $update_data, $condition)){
					$output['success'] = true;
				}else{
					$error_message[] = "An error occured. Please try again later";
				}
			}else{
				$error_message[] = "An error occured. Please try again later";
			}
		}else{
			$error_message[] = "Envalid Itilizatè";
		}

		$output['error'] = $error_message;

		echo json_encode($output);
		die;

	}

	function getTicketList(){
		global $apl;
		global $db;
		global $post_data;

		$error = false;
		$error_message = array();
		$no_of_results = 10;
		if(isset($post_data->count)){
			$start = $post_data->count * $no_of_results;
		}
		$query = "select * from $apl->user_ticket_table where payment_status != 'null' order by ticket_id desc limit ".$start.", ".$no_of_results."";
		$results = $db->get_results($query);

		$output['error'] = "Pa gen tikè.";

		$output['success'] = true;
		$output['data'] = $results;

		echo json_encode($output);
		die;
	}

	function getTicketDetails(){
		global $apl;
		global $db;
		global $post_data;

		$error = false;
		$error_message = array();
		$ticket_id = $post_data->ticket_id;
		$user_id = $post_data->user_id;

		if($this->user_exists_by_id($user_id)){
			$query = "select * from $apl->user_ticket_table as ut, $apl->lottery_table as lt, $apl->lottery_result_table as lrt where ut.ticket_id = '".$ticket_id."' and ut.user_id = '".$user_id."' and lt.lottery_id = ut.lottery_id and lt.lottery_id = lrt.lottery_id";
			$results = $db->get_results($query);

			$output['success'] = false;
			$output['data'] = null;
			$output['error'] = null;

			if(count($results)){
				$ticket_details = $results[0];
				$ticket_details->number_list = $this->get_ticket_numbers($ticket_id, $user_id);
				$output['success'] = true;
				$output['data'] = $ticket_details;
				$output['error'] = null;
			}else{
				$output['success'] = false;
				$output['data'] = null;
				$output['error'] = "Ce ticket n'a pas été trouvé";
			}
		}else{
			$error_message[] = "Envalid Itilizatè";
		}
		echo json_encode($output);
		die;
	}

	function get_user_tickets_by_lottery($lottery_id, $user_id){
		global $apl;
		global $db;
		global $post_data;

		$error_message = array();
		$output['success'] = false;

		if($this->user_exists_by_id($user_id)){
			$query = "select * from ".$apl->user_ticket_table." where user_id = '".$user_id."' and lottery_id = '".$lottery_id."' and payment_status = 'paid'";
			$results = $db->get_results($query);
			if(count($results)){
				return $results;
			}else{
				return null;
			}
		}else{
			return null;
		}

		return null;

	}

	function create_user_wallet($user_id, $initial_balance = null){
		global $db;
		global $apl;

		if($user_id != null && $user_id != 0 ){
			if($initial_balance == null){
				$initial_balance = 0;
			}
			$wallet_data = array(
				'user_id' => $user_id,
				'available_balance' => $initial_balance,
				'wallet_type' => 'Free',
				'wallet_status' => 'Active'
			);
			if($db->insert($apl->user_wallet_table, $wallet_data)){
				return true;
			}else{
				echo mysql_error();
			}
		}

		return false;
	}

	function get_ticket_list_by_lottery($lottery_id){
		global $apl;
		global $db;
		global $post_data;

		$error_message = array();
		$output['success'] = false;

		$query = "select * from ".$apl->user_ticket_table." where lottery_id = '".$lottery_id."' and payment_status = 'paid'";
		$results = $db->get_results($query);
		if(count($results)){
			return $results;
		}else{
			return null;
		}

		return null;

	}

	function get_ticket_numbers($ticket_id, $user_id){
		global $apl;
		global $db;
		global $post_data;

		$error_message = array();
		$output['success'] = false;

		if($this->user_exists_by_id($user_id)){
			$query = "select * from ".$apl->ticket_details_table." where user_id = '".$user_id."' and ticket_id = '".$ticket_id."'";
			$results = $db->get_results($query);
			if(count($results)){
				return $results;
			}else{
				return null;
			}
		}else{
			return null;
		}

		return null;
	}

	function get_ticket_numbers_by_ticket_id($ticket_id){
		global $apl;
		global $db;

		$query = "select * from ".$apl->ticket_details_table." where ticket_id = '".$ticket_id."'";
		$results = $db->get_results($query);
		if(count($results)){
			return $results;
		}

		return null;
	}

	function get_lottery_details($lottery_id){
		global $apl;
		global $db;

		$query = "select * from $apl->lottery_table as lt, $apl->lottery_result_table as lrt where lt.lottery_id = '".$lottery_id."' and lt.lottery_id = lrt.lottery_id";
		$results = $db->get_results($query);

		if(count($results)){
			return $results[0];
		}
		return null;
	}

	function is_valid_email($email){
		if( strpos($email, "@") AND strpos($email, ".") ){
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	function is_email_registered( $email ){
		global $apl;
		global $db;

		$result = $db->get_results( "select * from ".$apl->user_table." where email = '".$email."' " );

		if( count( $result ) > 0 )
		return true;
		else
		return false;
	}

	function is_email_verified( $email ){
		global $apl;
		global $db;

		$result = $db->get_results( "select * from ".$apl->user_table." where email = '".$email."' and email_verified = 'yes'" );

		if( count( $result ) > 0 )
		return true;
		else
		return false;
	}

	function is_phone_registered( $phone ){
		global $apl;
		global $db;

		$result = $db->get_results( "select * from ".$apl->user_table." where phone = '".$phone."' " );

		if( count( $result ) > 0 )
			return true;
		else
			return false;
	}

	function is_phone_verified( $phone ){
		global $apl;
		global $db;

		$result = $db->get_results( "select * from ".$apl->user_table." where phone = '".$phone."' and phone_verified = 'yes' " );

		if( count( $result ) > 0 )
			return true;
		else
			return false;
	}

	function make_transaction($account_holder_id, $refrence_account_id, $transaction_type, $transaction_name, $amount){
		global $db;
		global $apl;

		if($amount == null){
			return false;
		}
		if($transaction_type == null){
			return false;
		}
		if($transaction_name == null){
			return false;
		}

		if($transaction_type == "credit"){
			$previous_balance = $this->get_user_balance($account_holder_id);
			if(!$previous_balance){
				return false;
			}
			$current_balance = $previous_balance + $amount;
		}elseif ($transaction_type == "debit") {
			$previous_balance = $this->get_user_balance($account_holder_id);
			if(!$previous_balance){
				return false;
			}
			$current_balance = $previous_balance - $amount;
		}

		$transaction_data = array(
			'account_holder_id' => $account_holder_id,
			'refrence_account_id'	 => $refrence_account_id,
			'previous_balance' => $previous_balance,
			'current_balance' => $current_balance,
			'transaction_type' => $transaction_type,
			'transaction_name' => $transaction_name,
			'transaction_amount' => $amount,
			'initiated_by' => 'bank',
			'initiated_by_id' => $this->current_user_id,
			'transaction_status' => 'complete'
		);

		if($db->insert($apl->transaction_details_table, $transaction_data)){
			$this->update_wallet($account_holder_id, $current_balance);
			return true;
		}

		return false;
	}

	function get_user_balance($user_id){
		global $db;
		global $apl;

		$query = "select * from ".$apl->user_wallet_table." where user_id = '".$user_id."'";
		$results = $db->get_results($query);
		if(count($results)){
			return $results[0]->available_balance;
		}

		return false;
	}

	function update_wallet($user_id, $current_balance){
		global $db;
		global $apl;

		if(!is_numeric($current_balance)){
			return false;
		}

		if($user_id == 0 || $this->user_exists($user_id)){
			$update_wallet_data = array(
				'available_balance' => $current_balance
			);
			$condition = array(
				'user_id' => $user_id
			);
			if($db->update($apl->user_wallet_table, $update_wallet_data, $condition)){
				return true;
			}
		}
		return false;
	}

	function checkRegistered( $return_type = 'json'){
		global $apl;
		global $db;
		global $post_data;

		if( empty( $post_data->phone ) || empty( $post_data->country_code ) ):
			$output['registered'] = false;
			echo json_encode( $output );
			die;
		endif;
		$phone = $post_data->phone;
		$country_code = $post_data->country_code;

		$result = $db->get_results( "select * from ".$apl->user_table." where country_code = '".$country_code."' and phone = '".$phone."'" );

		if( count( $result ) > 0 )
		$output['registered'] = true;
		else
		$output['registered'] = false;

		if( $return_type == 'json' ) {
			echo json_encode( $output );
		}else {
			return $output['registered'];
		}
		die;
	}

	function user_exists_by_id( $user_id ){
		global $apl;
		global $db;

		if($user_id){
			$result = $db->get_results( "select * from ".$apl->user_table." where user_id = '".$user_id."' and status = 'active'" );
			if( count($result) > 0 ){
				return true;
			}
		}

		return false;
	}

	function user_exists( $user_id ){
		global $apl;
		global $db;

		if($user_id){
			$result = $db->get_results( "select * from ".$apl->user_table." where user_id = '".$user_id."'" );
			if( count($result) > 0 ){
				return true;
			}
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
					$error_message[] = "Modpas la pa konpatib.";
				endif;
				if( strlen( $password ) < 6 ):
					$error = true;
					$error_message[] = "Modpas ou paka pipiti ke 6 lèt e pi plis ke 20 lèt ou ka mete nimewo ladanl tou..";
				endif;
				if( strlen( $password ) > 20 ):
					$error = true;
					$error_message[] = "Modpas ou paka pipiti ke 6 lèt e pi plis ke 20 lèt ou ka mete nimewo ladanl tou..";
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
					$output['data'] = "<div class = 'updated'>Modpas ou ajou avèk siksè</div>";
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

	function getUserDetails(){
		global $apl;
		global $db;
		global $user;
		global $post_data;

		$UserId = $post_data->UserId;

		if( $this->user_exists_by_id($UserId) ){
			$user_details = $this->get_user_data_by_id( $UserId );
			$output['success'] = true;
			$output['data'] = $user_details;
			echo json_encode( $output );
			die;
		}
		$output['success'] = false;
		$output['data'] = ' The user doesnot exist';
		echo json_encode( $output );
		die;
	}

	function updateUserDetails(){
		global $apl;
		global $db;
		global $user;
		global $post_data;
		$output['success'] = false;

		if($this->current_user_id == $post_data->user_id){
			$condition['user_id'] = $this->current_user_id;
			if($this->current_user_details->email != $post_data->email){
				if($this->is_email_verified($post_data->email)){
					$output['data'] = "Imèl id sa egziste deja.";
					echo json_encode($output); die;
				}else{
					$output['email_verification'] = true;
					$updateData['verification_code'] = $apl->get_random_number(4);
					$updateData['new_email'] = $post_data->email;
				}
			}
			if($this->current_user_details->phone != $this->current_user_details->country_code.$post_data->phone){
				if($this->is_phone_verified($post_data->phone)){
					$output['data'] = "Nimewo telefòn sa egziste deja.";
					echo json_encode($output); die;
				}else{
					$output['phone_verification'] = true;
					if(!isset($updateData['verification_code'])){
						$updateData['verification_code'] = $apl->get_random_number(4);
					}
					$updateData['new_phone'] = $this->current_user_details->country_code . $post_data->phone;
				}
			}
			$updateData['first_name'] = $post_data->first_name;
			$updateData['last_name'] = $post_data->last_name;
			if(isset($post_data->basic_info)){
				$updateData['basic_info'] = $post_data->basic_info;
			}

			$db->update($apl->user_table, $updateData, $condition);
			
			if($output['phone_verification']){
				$text = $updateData['verification_code'] . ' is the verication code for updating phone number at zippcash. Please do not share it with anyone for security purposes';
				$phone = str_replace("+", "", $updateData['new_phone']);
				$res = $this->sendText($text, $phone);
			}

			$output['data'] = "pwofil ou ajou avèk siksè.";
			$output['success'] = true;
		}else{
			$output['data'] = "Envalid Itilizatè.";
			echo json_encode($output); die;
		}

		echo json_encode($output); die;
	}

	function getUserDetailsById(){
		global $apl;
		global $db;
		global $user;
		global $post_data;

		$UserId = $post_data->UserId;

		if( $this->user_exists_by_id($UserId) ){
			$user_details = $this->get_user_data_by_id( $UserId );
			$output['success'] = true;
			$output['data'] = $user_details[0];
			echo json_encode( $output );
			die;
		}
		$output['success'] = false;
		$output['data'] = ' The user doesnot exist';
		echo json_encode( $output );
		die;
	}

	function upload_profile_pic(){
		global $apl;
		global $db;
		global $post_data;

		$fileName = $_FILES[ "file"][ "name"];
		$fileTmpLoc = $_FILES[ "file"][ "tmp_name"];
		$fileType = $_FILES[ "file"][ "type"];
		$fileSize = $_FILES[ "file"][ "size"];
		$fileErrorMsg = $_FILES[ "file"][ "error"];
		$fileArray = explode( ".", $fileName );
		$fileExtension = end( $fileArray );

		if ( !$fileTmpLoc ) {
			echo "<div class = 'error'>ERROR: Please browse for a file before clicking the upload button.</div>";
			die();
		}
		$now = new DateTime();

		$file_new_name = $now->getTimestamp().'.'.$fileExtension;

		$file_new_location = $apl->site_path . "media/images/" . $file_new_name;

		$file_url = $apl->site_url . "media/images/" . $file_new_name;

		if( move_uploaded_file( $fileTmpLoc, $file_new_location ) ){
			$output['success'] = true;
			$output['data'] = $file_new_name;
		} else {
			$output['success'] = false;
		}
		echo json_encode( $output );
		die();
	}

	function get_one_value( $query ) {
		global $JWT;
		global $apl;
		global $db;
		global $post_data;

	    $result = $db->get_results($query);
	    return count($result);
	}

	function logout(){
		session_destroy();
	}

}
