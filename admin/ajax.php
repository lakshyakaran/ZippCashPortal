<?php
session_start();

require_once "config.php";
require_once "load.php";

require 'vendor/autoload.php';

use Plivo\RestAPI;

$auth_id = "MAOTUYN2NJM2M3MGJKNG";

$auth_token = "MDMyYjg5MWIxOWIyMzk5ZjA1MDM1ODIwZWE3MTZh";

// $plivo = new RestAPI($auth_id, $auth_token);

$db = new db( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);

$apl = new aplController();

$user = new user();

$apl->set_template_path();

$lottery = new lottery();

if( !$user->is_logged_in() ){
	if( $_POST['action'] != "authenticate_user"){
		die();
	}
}

if( isset( $_POST['controller'] ) && isset( $_POST['action'] ) ):
	if( class_exists( $_POST['controller'] ) && method_exists( $_POST['controller'], $_POST['action'] ) ):
		global $$_POST['controller'];
		$$_POST['controller']->$_POST['action']();
	else:
		$output['data'] = "Controller ".$_POST['controller']." and/or action ".$_POST['action']." not found.";
	endif;
else:
	$output['data'] = "Controller and/or action not set.";
endif;

$output['success'] = false;
echo json_encode($output);
die;
