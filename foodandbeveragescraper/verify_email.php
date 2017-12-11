<?php
	if(isset($_GET['hash']) && isset($_GET['action']) && isset($_GET['email'])) {

		$hash = $_GET['hash'];
		$action = $_GET['action'];
		$email = urldecode($_GET['email']);

		include 'dblogin.php';

		//Create and execute the SQL statement using paramterised statement with oci_bind_by_name (stops SQL injection)
		$querystring = "SELECT * FROM accountsdb WHERE email=:email AND veriHash=:veri_hash AND emailVeri='f'"; 
		$stmt = oci_parse($connect, $querystring);
		oci_bind_by_name($stmt, ':email', $email); 
		oci_bind_by_name($stmt, ':veri_hash', $hash); 
		oci_execute($stmt);

		//Get the number of rows, if its greater than 0 the email is already in use
		oci_fetch_assoc($stmt);
		$num_rows = oci_num_rows($stmt);
		oci_free_statement($stmt);

		if($num_rows == 1) {
			if($action == "verify") {
				$querystring = "UPDATE accountsdb SET emailVeri='t' WHERE email=:email AND veriHash=:veri_hash"; 
				$stmt = oci_parse($connect, $querystring);
				oci_bind_by_name($stmt, ':email', $email); 
				oci_bind_by_name($stmt, ':veri_hash', $hash); 
				oci_execute($stmt);
				
				//Close connection
				oci_free_statement($stmt);
				oci_close($connect);

				header('Location: verify_email_status.php?status=success');
				exit();
				
			} else if($action == "deny") {
				$querystring = "DELETE FROM accountsdb WHERE email=:email AND veriHash=:veri_hash"; 
				$stmt = oci_parse($connect, $querystring);
				oci_bind_by_name($stmt, ':email', $email); 
				oci_bind_by_name($stmt, ':veri_hash', $hash); 
				oci_execute($stmt);
				
				//Close connection
				oci_free_statement($stmt);
				oci_close($connect);

				header('Location: verify_email_status.php?status=removed');
				exit();
			} else {
				header('Location: verify_email_status.php?status=fail');
				exit();
			}
		} else {
			header('Location: verify_email_status.php?status=fail');
			exit();
		}
	} else {
		header('Location: verify_email_status.php?status=fail');
		exit();
	}
?>
