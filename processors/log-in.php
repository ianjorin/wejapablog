<?php 

ob_start();
session_start();
require_once('../config/constants.php');
require_once('../functions.php');
require_once('../classes/picture.class.php');
require_once('../pdo_connection.php');
require_once('../classes/user.class.php');

$user = New User;
$signup = $user->login();



?>