<?php

$conn = mysqli_connect('localhost', 'root', '', 'zet_db');

if(!$conn){
    die('unable to connect');
}

define('DB_HOST', 'localhost');
	define('DB_NAME', 'zet_db');
	define('DB_USER', 'root');
	define('DB_PASS', '');
	define('BASE_URL', 'http://localhost/zentt/');	

    //SMTP
	define("M_HOST", 'smtp.gmail.com');
	define("M_USERNAME", 'Your Email ID');
	define("M_PASSWORD", 'Your Email IDs password');
	define("M_SMTPSECURE", 'ssl');
	define("M_PORT", "465");

?>

<?php 

?>