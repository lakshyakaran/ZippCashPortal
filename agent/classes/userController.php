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
				$user_data = $this->get_admin_data( $_SESSION['current_user_id'] );
				if( !empty( $user_data ) ):
					$this->current_user_name = $user_data->first_name . "&nbsp;" . $user_data->last_name;
					$this->current_user_id = $user_data->admin_id;
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

	function get_active_user_count(){
		global $apl;
		global $db;

		$user_list = $db->get_results( "select count(user_id) as active_user_count from ".$apl->user_table." where user_type = 'individual' status = 'Active'" );

		if( !empty( $user_list ) )
		return $user_list->active_user_count;
		else
		return 0;
	}

	function get_active_store_count(){
		global $apl;
		global $db;

		$user_list = $db->get_results( "select count(user_id) as active_user_count from ".$apl->user_table." where user_type = 'store' status = 'Active'" );

		if( !empty( $user_list ) )
		return $user_list->active_user_count;
		else
		return 0;
	}

	function get_zippcash_account_details(){
		global $apl;
		global $db;

		$return_data = new stdClass();

		$query = "select sum(available_balance) as total_asset from ".$apl->user_wallet_table."";
		$result = $db->get_results($query);
		$return_data->total_asset = $result[0]->total_asset;

		$query = "select available_balance from ".$apl->user_wallet_table." where user_id = '0'";
		$result = $db->get_results($query);
		$return_data->available_balance = $result[0]->available_balance;

		$return_data->login_id = "xxx-xxxxx";
		$return_data->wallet_id = "xxx-xxxxx";
		$return_data->name = "ZippCash Account";
		$return_data->currency = "Gourde";

		return $return_data;
	}

	function get_user_list(){
		global $apl;
		global $db;

		$user_list = $db->get_results( "select * from ".$apl->user_table." where user_type = 'individual'" );

		if( !empty( $user_list ) )
		return $user_list;
		else
		return false;
	}

	function get_store_list(){
		global $apl;
		global $db;

		$user_list = $db->get_results( "select * from ".$apl->user_table." where user_type = 'store' and added_by = 'store' and added_by_id = '".$this->current_user_id."' " );

		if( !empty( $user_list ) )
		return $user_list;
		else
		return false;
	}

	function get_user_data( $user_id ){
		global $apl;
		global $db;

		$user_data = $db->get_results( "select * from ".$apl->user_table." where user_id = '".$user_id."' limit 1" );

		if( !empty( $user_data ) )
		return $user_data[0];
		else
		return false;
	}

	function get_admin_data( $user_id ){
		global $apl;
		global $db;

		$user_data = $db->get_results( "select * from ".$apl->admin_table." where admin_id = '".$user_id."' limit 1" );

		if( !empty( $user_data ) )
		return $user_data[0];
		else
		return false;
	}

	function isEmailRegistered(){
		$error = false;
		$error_message = '';
		if(isset($_POST['email'])){
			if($_POST['email'] != null){
				if($this->is_email_registered($_POST['email'])){
					$error = true;
					$error_message = "The email ID already exists";
				}
			}else {
				$error = true;
				$error_message = "Please enter the email";
			}
		}else{
			$error = true;
			$error_message = "Please enter the email";
		}

		$output['success'] = !$error;
		$output['data'] = $error_message;
		echo json_encode($output);
		die;
	}

	function isPhoneRegistered(){
		$error = false;
		$error_message = '';
		if(isset($_POST['phone'])){
			if($_POST['phone'] != null){
				if($this->is_phone_registered($_POST['phone'])){
					$error = true;
					$error_message = "The phone number already exists";
				}
			}else {
				$error = true;
				$error_message = "Please enter the phone number";
			}
		}else{
			$error = true;
			$error_message = "Please enter the phone number";
		}

		$output['success'] = !$error;
		$output['data'] = $error_message;
		echo json_encode($output);
		die;
	}

	function addUser(){
		global $db;
		global $apl;
		$error = false;
		$error_message = array();

		if(isset($_POST['user_type'])){
			if($_POST['user_type'] != null){
				$user_data['user_type'] = $_POST['user_type'];
			}else {
				$user_data['user_type'] = 'individual';
			}
		}else{
			$user_data['user_type'] = 'individual';
		}

		if($user_data['user_type'] == 'individual'){
			if(isset($_POST['first_name'])){
				if($_POST['first_name'] != null){
					$user_data['first_name'] = $_POST['first_name'];
				}else {
					$error = true;
					$error_message[] = "Please enter the first name";
				}
			}else{
				$error = true;
				$error_message[] = "Invalid first name";
			}
			if(isset($_POST['last_name'])){
				if($_POST['last_name'] != null){
					$user_data['last_name'] = $_POST['last_name'];
				}else {
					$error = true;
					$error_message[] = "Please enter the last name";
				}
			}else{
				$error = true;
				$error_message[] = "Invalid last name";
			}
		}else{
			if(isset($_POST['store_name'])){
				if($_POST['store_name'] != null){
					$user_data['store_name'] = $_POST['store_name'];
				}else {
					$error = true;
					$error_message[] = "Please enter the store name";
				}
				$user_data['added_by'] = "store";
				$user_data['added_by_id'] = $this->current_user_id;
			}else{
				$error = true;
				$error_message[] = "Invalid store name";
			}
		}
		if(isset($_POST['email'])){
			if($_POST['email'] != null){
				if($this->is_email_registered($_POST['email'])){
					$error = true;
					$error_message[] = "The email ID already exists";
				}else{
					$user_data['email'] = $_POST['email'];
				}
			}else {
				$error = true;
				$error_message[] = "Please enter the email";
			}
		}else{
			$error = true;
			$error_message[] = "Invalid email";
		}
		if(isset($_POST['phone'])){
			if($_POST['phone'] != null){
				if($this->is_phone_registered($_POST['phone'])){
					$error = true;
					$error_message[] = "The phone number already exists";
				}else{
					$user_data['phone'] = $_POST['phone'];
				}
			}else {
				$error = true;
				$error_message[] = "Please enter the phone number";
			}
		}else{
			$error = true;
			$error_message[] = "Invalid phone number";
		}
		if(isset($_POST['country'])){
			if($_POST['country'] != null){
				$user_data['country_name'] = $_POST['country'];
			}else {
				$error = true;
				$error_message[] = "Please enter the country";
			}
		}else{
			$error = true;
			$error_message[] = "Invalid country";
		}

		if(isset($_POST['address'])){
			if($_POST['address'] != null){
				$user_data['address'] = $_POST['address'];
			}
		}
		if(isset($_POST['address_2'])){
			if($_POST['address_2'] != null){
				$user_data['address_2'] = $_POST['address_2'];
			}
		}
		if(isset($_POST['city'])){
			if($_POST['city'] != null){
				$user_data['city'] = $_POST['city'];
			}
		}
		if(isset($_POST['state'])){
			if($_POST['state'] != null){
				$user_data['state'] = $_POST['state'];
			}
		}
		if(isset($_POST['postal_code'])){
			if($_POST['postal_code'] != null){
				$user_data['postal_code'] = $_POST['postal_code'];
			}
		}
		if(isset($_POST['landmark'])){
			if($_POST['landmark'] != null){
				$user_data['landmark'] = $_POST['landmark'];
			}
		}

		if(!$error){
			$user_data['status'] = "Active";
			// $user_data['email_verification_code'] = $apl->get_random_number( 10 );
			$user_data['verification_code'] = $apl->get_random_number( 4 );
			$password = $apl->get_random_number( 6 );
			$user_data['password'] = md5($password);

			if( $db->insert( $apl->user_table, $user_data ) ){
				$user_id = $db->insert_id;
				if($user_data['user_type'] == 'individual'){
					$login_id = 'USR-'.$user_id;
				}else{
					$login_id = 'STR-'.$user_id;
				}
				$update_data = array(
					'login_id' => $login_id
				);
				$condition = array(
					'user_id' => $user_id
				);
				$db->update($apl->user_table, $update_data, $condition);
				if(!$this->create_user_wallet($user_id)){
					$output['error'] = 'Unable to create wallet';
				}
				
				$receiver_number = $user_data['phone'];
			    # SMS sender ID.
			    $src = 'ZippCash';
			    
			    # SMS destination number
			    $dst = $receiver_number;
			    
			    # SMS text
			    $text = 'Welcome to zippcash. Your login id is ' . $login_id . ' and password is ' . $password;

			    $url = 'https://api.plivo.com/v1/Account/'.$auth_id.'/Message/';
			    
			    $data = array("src" => "$src", "dst" => "$dst", "text" => "$text");
			    
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


				$output['success'] = true;
				$output['data'] = 'Registration successful';
				$output['login_id'] = $login_id;
				echo json_encode( $output );
				die();
			}else{
				$error = true;
				$error_message[] = "An error occured! Please try again later. " . mysql_error();
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
		}else{
			$output['success'] = false;
			$output['data'] = '';
			$output['data'] .= '<div class = "error">';
			foreach( $error_message as $value ):
				$output['data'] .= '<p>'.$value.'</p>';
			endforeach;
			$output['data'] .= '</div>';
			echo json_encode( $output );
			die();
		}
	}

	function getUserDetailsByLoginId(){
		global $db;
		global $apl;
		$error = false;
		$error_message = '';

		if(isset($_POST['login_id'])){
			if($_POST['login_id'] != null){
				$login_id = $_POST['login_id'];
			}else{
				$error = true;
				$error_message = "Invalid Login ID";
			}
		}else{
			$error = true;
			$error_message = "Invalid Login ID";
		}

		if(!$error){
			$user_id = $this->get_user_id_from_login_id($login_id);
			$query = "select * from $apl->user_table as ut, $apl->user_wallet_table as uwt where ut.user_id = '".$user_id."' and ut.user_id = uwt.user_id";
			$results = $db->get_results($query);
			if(count($results)){
				if($results[0]->user_type == "individual"){
					$name = ucfirst($results[0]->first_name) . "&nbsp;&nbsp;" . ucfirst($results[0]->last_name);
				}else{
					$name = ucfirst($results[0]->store_name);
				}
				$output['success'] = true;
				$output['data'] = "";
				$output['data'] .=
				'<div class = "form-horizontal form-label-left">'.
				'<div class="form-group">'.
				'<label class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>'.
				'<div class="col-md-9 col-sm-9 col-xs-12">'.
				'<p style = "padding-top:8px;">'.$name.'</p>'.
				'</div>'.
				'</div>'.
				'<div class="form-group">'.
				'<label class="control-label col-md-3 col-sm-3 col-xs-12">User Type</label>'.
				'<div class="col-md-9 col-sm-9 col-xs-12">'.
				'<p style = "padding-top:8px;">'.ucfirst($results[0]->user_type).'</p>'.
				'</div>'.
				'</div>'.
				'<div class="form-group">'.
				'<label class="control-label col-md-3 col-sm-3 col-xs-12">Email ID</label>'.
				'<div class="col-md-9 col-sm-9 col-xs-12">'.
				'<p style = "padding-top:8px;">'.$results[0]->email.'</p>'.
				'</div>'.
				'</div>'.
				'<div class="form-group">'.
				'<label class="control-label col-md-3 col-sm-3 col-xs-12">Phone NUmber</label>'.
				'<div class="col-md-9 col-sm-9 col-xs-12">'.
				'<p style = "padding-top:8px;">'.$results[0]->phone.'</p>'.
				'</div>'.
				'</div>'.
				'<div class="form-group">'.
				'<label class="control-label col-md-3 col-sm-3 col-xs-12">Balance</label>'.
				'<div class="col-md-9 col-sm-9 col-xs-12">'.
				'<p style = "padding-top:8px;">'.$results[0]->available_balance.'</p>'.
				'</div>'.
				'</div>'.
				'</div>';
			}else {
				$error = true;
				$error_message = "User with specified ID not found";
			}
		}

		if($error){
			$output['success'] = false;
			$output['data'] = $error_message;
		}

		echo json_encode($output);
		die;
	}

	function addCredit(){
		global $db;
		global $apl;
		$error = false;
		$message = true;

		if(isset($_POST['login_id'])){
			if($_POST['login_id'] != null){
				$user_id = $this->get_user_id_from_login_id($_POST['login_id']);
				if(!$user_id){
					$error = true;
					$message = "Invalid user";
				}
			}else {
				$error = true;
				$message = "Invalid user";
			}
		}else{
			$error = true;
			$message = "Invalid user";
		}
		if(isset($_POST['credit_amount'])){
			if($_POST['credit_amount'] != null && $_POST['credit_amount'] > 0 && is_numeric($_POST['credit_amount'])){
				$credit_amount = $_POST['credit_amount'];
			}else{
				$error = true;
				$message = "Invalid credit amount";
			}
		}else{
			$error = true;
			$message = "Invalid credit amount";
		}

		if(!$error){
			if($this->add_user_credit($user_id, $credit_amount)){
				$output['success'] = true;
				$output['data'] = "The user account has been credit with Gourde " . $credit_amount;
			}else{
				$error = true;
				$message = "Error occured! Unable to add credit to user." . mysql_error();
			}
		}

		if($error){
			$output['success'] = false;
			$output['data'] = $message;
		}

		echo json_encode($output);
		die;
	}

	function withdrawCredit(){
		global $db;
		global $apl;
		$error = false;
		$message = true;

		if(isset($_POST['login_id'])){
			if($_POST['login_id'] != null){
				$user_id = $this->get_user_id_from_login_id($_POST['login_id']);
				if(!$user_id){
					$error = true;
					$message = "Invalid user";
				}
			}else {
				$error = true;
				$message = "Invalid user";
			}
		}else{
			$error = true;
			$message = "Invalid user";
		}
		if(isset($_POST['debit_amount'])){
			if($_POST['debit_amount'] != null && $_POST['debit_amount'] > 0 && is_numeric($_POST['debit_amount'])){
				if($this->get_user_balance($user_id) < $_POST['debit_amount']){
					$error = true;
					$message = "Insufficient funds";
				}else{
					$debit_amount = $_POST['debit_amount'];
				}
			}else{
				$error = true;
				$message = "Invalid withdrawal amount";
			}
		}else{
			$error = true;
			$message = "Invalid withdrawal amount";
		}

		if(!$error){
			if($this->withdraw_user_credit($user_id, $debit_amount)){
				$output['success'] = true;
				$output['data'] = "The user account has been debited with Gourde " . $debit_amount;
			}else{
				$error = true;
				$message = "Error occured! Unable to withdraw credit for user." . mysql_error();
			}
		}

		if($error){
			$output['success'] = false;
			$output['data'] = $message;
		}

		echo json_encode($output);
		die;
	}

	function get_user_id_from_login_id($login_id){
		global $apl;
		global $db;

		$query = "select user_id from ".$apl->user_table." where login_id = '".$login_id."' limit 1";
		$results = $db->get_results($query);
		if(count($results)){
			return $results[0]->user_id;
		}

		return false;
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

	function get_recent_transaction($account_holder_id, $transaction_name, $limit){
		global $db;
		global $apl;

		$query = "select * from $apl->transaction_details_table as tdt, $apl->user_table as ut where tdt.account_holder_id = '".$account_holder_id."' and tdt.transaction_name = '".$transaction_name."' and tdt.refrence_account_id = ut.user_id order by transaction_id desc limit ".$limit."";
		$results = $db->get_results($query);

		if(count($results)){
			return $results;
		}

		return false;
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

	function add_user_credit($user_id, $credit_amount){
		global $db;
		global $apl;

		if($user_id == null || $user_id == 0){
			return false;
		}
		if($credit_amount == null || $credit_amount == 0){
			return false;
		}

		if($this->user_exists($user_id)){
			// First add the funds to ZippCash account. This will be one transaction.
			if($this->make_transaction(0, $user_id, 'credit', 'cash_deposit', $credit_amount)){
				//Update transfer of credit from ZippCash to user account. This will be two transaction. ZippCash account "Debit" Transaction and User account "Credit" Transaction
				if($this->make_transaction(0, $user_id, 'debit', 'deposit_transfer', $credit_amount) && $this->make_transaction($user_id, 0, 'credit', 'deposit_transfer', $credit_amount)){
					return true;
				}
			}
		}

		return false;
	}

	function withdraw_user_credit($user_id, $debit_amount){
		global $db;
		global $apl;

		if($user_id == null || $user_id == 0){
			return false;
		}
		if($debit_amount == null || $debit_amount == 0){
			return false;
		}
		if($this->get_user_balance($user_id) < $debit_amount){
			return false;
		}

		if($this->user_exists($user_id)){
			// First add the funds to ZippCash account. This will be one transaction.
			if($this->make_transaction(0, $user_id, 'credit', 'withdraw_transfer', $debit_amount) && $this->make_transaction($user_id, 0, 'debit', 'withdraw_transfer', $debit_amount)){
				//Update transfer of credit from ZippCash to user account. This will be two transaction. ZippCash account "Debit" Transaction and User account "Credit" Transaction
				if($this->make_transaction(0, $user_id, 'debit', 'cash_withdraw', $debit_amount)){
					return true;
				}
			}
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

	function is_phone_registered( $phone ){
		global $apl;
		global $db;

		$result = $db->get_results( "select * from ".$apl->user_table." where phone = '".$phone."' " );

		if( count( $result ) > 0 )
			return true;
		else
			return false;
	}

	function authenticate_user(){
		global $apl;
		global $db;
		$error = false;

		if(isset($_POST['agent_phone'])){
			$agent_phone = $_POST['agent_phone'];
		}else{
			$error = true;
			$message = "Please enter login ID";
		}

		if(isset($_POST['password'])){
			$password = $_POST['password'];
		}else{
			$error = true;
			$message = "Please enter the password";
		}

		if(!$error){
			$result = $db->get_results( "select * from ".$apl->agent_table." where agent_phone = '".$agent_phone."' and password = '".md5($password)."' and status = 'Active' limit 1", OBJECT );

			if( count( $result ) > 0 ){
				$bank_data = $result[0];
				$this->current_user_id = $bank_data->agent_id;
				$_SESSION['loggedIn'] = true;
				$_SESSION['current_user_id'] = $this->current_user_id;
				$output['success'] = true;
				$output['data'] = 'Login Successful';
				echo json_encode( $output );
				die();
			}else{
				$error = true;
				$error_message[] = "Login ID and/or password is incorrect";
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
		}else{
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
		}
		die();
	}

	function user_exists( $user_id ){
		global $apl;
		global $db;

		$result = $db->get_results( "select * from ".$apl->user_table." where user_id = '".$user_id."' limit 1" );

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
						'admin_id'	=>	$user_id
					);
					$data_array = array(
						'passwodr'	=>	md5( $password )
					);
					$db->update( $apl->admin_table, $data_array, $condition );
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
						'admin_id'	=>	$user_id
					);
					$db->update( $apl->admin_table, $user_data, $condition );
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

	function verify_emai( $verification_code ){
		global $apl;
		global $db;
		$user_id = $this->current_user_id;

		$results = $db->get_results( "select * from ".$apl->admin_table." where admin_id = '".$user_id."' and email_verification_code = '".$verification_code."' ");

		if(count($results) > 0){
			$update_data = array(
				'email_verified'	=>	true
			);
			$condition = array(
				'id'	=>	$user_id
			);

			$db->update( $apl->admin_table, $update_data, $condition );

			header("location:".$apl->site_url."?verified=true");
		} else {
			header("location:".$apl->site_url."?verified=false");
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
