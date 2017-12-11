<?php
session_start();

//If post variables are set, checks to see if user's login details are correct
if(isset($_POST['email_login'])) {
	$email = $_POST['email_login'];
	$password = $_POST['password_login'];
	
	include 'dblogin.php';
	
	$querystring = "SELECT * FROM accountsdb WHERE email=:email_bv AND emailVeri='t'"; 
	$stmt = oci_parse($connect, $querystring);
	oci_bind_by_name($stmt, ':email_bv', $email);
	oci_execute($stmt);
	
	while(oci_fetch_array($stmt))  {
		$emaildb = oci_result($stmt,"EMAIL");
		$firstnamedv = oci_result($stmt,"FIRSTNAME");
		$lastnamedb = oci_result($stmt,"LASTNAME");
		$admindb = oci_result($stmt,"ADMIN");
		$salthashdb = oci_result($stmt,"SALT");
		$passhashdb = oci_result($stmt,"PASSHASH");
	}
	
	$num_rows = oci_num_rows($stmt);
	oci_fetch_assoc($stmt);
	
	if($num_rows > 0) {
		$passhash = hash(sha256, $salthashdb.$password);
		if($passhash == $passhashdb) {
			$_SESSION['user_email'] = $emaildb;
			$_SESSION['first_name'] = $firstnamedv;
			$_SESSION['last_name'] = $lastnamedb;
			$_SESSION['admin'] = $admindb;
			header('Location: index.php');
			exit();
		} else {
			header('Location: login.php?status=fail');
			exit();
		}
	} else {
		header('Location: login.php?status=fail');
		exit();
	}
		
		 
	} 
	
	oci_close($connect);
	

header('Location: login.php?status=fail');
exit();

?>