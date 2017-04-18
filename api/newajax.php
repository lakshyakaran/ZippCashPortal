<?php
header('Access-Control-Allow-Origin: *');
session_start();

require_once "config.php";
require_once "load.php";

$db = new db( DB_USER, DB_PASSWORD, DB_NAME);

$apl = new aplController();

$user = new user();

$apl->set_template_path();

$post = new post();

$post_data = json_decode(file_get_contents("php://input"));

$action = $post_data->action;
print_r ( $_SESSION);
if ( isset( $post_data->controller ) ){
	$controller = $post_data->controller;
}

if( !$user->is_logged_in() ){
	if( $action != "sendVerificationCode" && $action != "verifyVerificationCode" && $action != "checkRegistered"){
		$output['success'] = false;
		$output['data'] = "Authentication Failed";
		echo json_encode( $output );
		die();
	}
}


if( isset( $controller ) && isset( $action ) ):
	if( class_exists( $controller ) && method_exists( $controller, $action ) ):
		global $$controller;
		$$controller->$action();
	else:
		$output['success'] = false;
		$output['data'] = "Controller and/or action not found";
		echo json_encode( $output );
		die();
	endif;
endif;
