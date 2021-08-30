<?php 
	include 'config.php';
	include 'classes/PHPMailer.php';	
	include 'classes/SMTP.php';	
	include 'classes/Exception.php';
	include 'classes/Users.php';
	include 'classes/Verify.php';
	include 'classes/Database.php';
	
   	//autoload
	spl_autoload_register(function($class){
		require_once "classes/{$class}.php";
	});

	$userObj   = new Users;
	$verifyObj = new Verify;
  	//session
	session_start();
	
 ?>