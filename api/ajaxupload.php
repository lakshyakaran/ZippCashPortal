<?php
header('Access-Control-Allow-Origin: *');
session_start();

require_once "config.php";
require_once "load.php";

$db = new db( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);

$apl = new aplController();

$user = new user();

$action = $_POST['action'];

if( isset( $_POST['controller'] ) && isset( $_POST['action'] ) ):
	if( class_exists( $_POST['controller'] ) && method_exists( $_POST['controller'], $_POST['action'] ) ):
		global $$_POST['controller'];
		$$_POST['controller']->$_POST['action']();
	endif;
else:
	$output['success'] = false;
	$output['data'] = "Controller and/or action not found";
	echo json_encode( $output );
	die();
endif;
