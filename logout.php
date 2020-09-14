<?php
ob_start();
session_start();
require_once('../config/constants.php');
require_once('../functions.php');
require_once('../classes/user.class.php');

$user = new User;
$user->securityLogout();
go('index');
 ?>