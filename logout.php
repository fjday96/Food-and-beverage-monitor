<?php
session_start();
$logout_success = false;
if(isset($_SESSION["user_email"])) {
	session_unset();
	session_destroy(); 
}
header('Location: login.php');
?>
