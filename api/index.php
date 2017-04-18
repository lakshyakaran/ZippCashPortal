<?php
ini_set('display_errors', true );
header('Access-Control-Allow-Origin: *');
session_start();

require_once('vendor/autoload.php');
require_once "config.php";
require_once "load.php";

use \Firebase\JWT\JWT;

$db = new db( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);

$apl = new aplController();

$user = new user();

$apl->set_template_path();

$post_data = json_decode(file_get_contents("php://input"));

foreach ($_GET as $key => $value ){
	@$post_data->$key = $value;
}

if ( isset( $post_data->controller ) ){
	$controller = $post_data->controller;
}
if ( isset( $post_data->action ) ){
	$action = $post_data->action;
}

$JWT = new JWT;

if( isset( $controller ) && isset( $action ) ){
	if( class_exists( $controller ) && method_exists( $controller, $action ) ){
		if( $action != 'sendVerificationCode' && $action != 'verifyVerificationCode' && $action != 'authenticateUser'){
			if(!isset($post_data->token)){
				$output['success'] = false;
				$output['data'] = "Invalid token.";
				echo json_encode( $output );
				die();
			}else{
				$receivedToken = $post_data->token;
				try {
					$decodedToken = JWT::decode($receivedToken, SECRET_KEY, array('HS256'));
					$user_id = $user->get_user_id_from_login_id($decodedToken->login_id);
					if($user->user_exists_by_id($user_id)){
						if($user->set_user_logged_in($user_id)){
							global $$controller;
							$$controller->$action();
						}else{
							$output['success'] = false;
							$output['data'] = "You are not loggedIn";
							echo json_encode( $output );
							die();
						}
					}else{
						$output['success'] = false;
						$output['data'] = "You are not loggedIn";
						echo json_encode( $output );
						die();
					}
				} catch (Exception $e) {
					echo 'Caught exception: ',  $e->getMessage(), "\n";
				}
			}
			$key = 'haxth@tfuck';
			$token = array(
				"login_id" => 'ZIPP1015',
				"user_type" => 'individual'
			);
			$jwt = JWT::encode($token, $key);
			$decoded = JWT::decode($jwt, $key, array('HS256'));
			print_r($jwt);
		}else{
			global $$controller;
			$$controller->$action();
		}
	}else{
		$output['success'] = false;
		$output['data'] = "Controller and/or action not found";
		echo json_encode( $output );
		die();
	}
}else{
	$output['success'] = false;
	$output['data'] = "Controller and/or action not found";
	echo json_encode( $output );
	die();
}
