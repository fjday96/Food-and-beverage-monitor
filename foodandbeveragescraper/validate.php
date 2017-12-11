<?php
if(isset($_REQUEST['email']))
{
	//Login to the database 
	include 'dblogin.php';

	//Create and execute the SQL statement using paramterised statement with oci_bind_by_name (stops SQL injection)
	$querystring = "SELECT * FROM accountsdb WHERE email=:email_input"; 
	$stmt = oci_parse($connect, $querystring);
	oci_bind_by_name($stmt, ':email_input', $_REQUEST['email']); 
	oci_execute($stmt);

	//Get the number of rows, if its greater than 0 the email is already in use
	oci_fetch_assoc($stmt);
	$num_rows = oci_num_rows($stmt);
	
	if($_REQUEST['email'] == "") {
		echo "Email can't be left empty.";
	} else if(strlen($_REQUEST['email']) > 40) {
		echo "Email must not exceed 40 characters.";
	} else if (substr($_REQUEST['email'], -14) != "@deakin.edu.au") {
		echo "Email is not a Deakin email.";
	} else if ($num_rows > 0) {
		echo "Email is already in use.";
	} else {
		echo "";
	}
	
	//Close connection
	oci_free_statement($stmt);
	oci_close($connect); 
}

//First name validation
if(isset($_REQUEST['first_name']))
{
	if($_REQUEST['first_name'] == "") {
		echo "First name can't be left empty.";
	} else if(strlen($_REQUEST['first_name']) > 25) {
		echo "First name must not exceed 25 characters.";
	} else if(ctype_alpha($_REQUEST['first_name']) == false) {
		echo "First name should consist only of letters.";
		$valid = false;
	}
}

//Last name validation
if(isset($_REQUEST['last_name']))
{
	if($_REQUEST['last_name'] == "") {
		echo "First name can't be left empty.";
	} else if(strlen($_REQUEST['last_name']) > 25) {
		echo "First name must not exceed 25 characters.";
	} else if(ctype_alpha($_REQUEST['last_name']) == false) {
		echo "First name should consist only of letters.";
		$valid = false;
	}
}

//Password validation
if(isset($_REQUEST['password']))
{
	if($_REQUEST['password'] == "") {
		echo "Password can't be left empty.";
	} else if(strlen($_REQUEST['password']) > 25) {
		echo "Password must not exceed 25 characters.";
	} else if(strlen($_REQUEST['password']) < 8) {
		echo "Password must be at least 8 characters.";
	}
}

//Repeat password validation
if(isset($_REQUEST['repeat_password']))
{
	if($_REQUEST['password'] != $_REQUEST['repeat_password']) {
		echo "Repeated password is not equal to password.";
	}
}
?>