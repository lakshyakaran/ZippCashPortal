<?php
ini_set('display_errors', true);
session_start();
ob_start();
require_once "config.php";
require_once "load.php";

$db = new db( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);

$apl = new aplController();

$user = new user();

$lottery = new lottery();

$apl->process_url();

$apl->set_template_path();

$apl->load_template();

ob_flush();
