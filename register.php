<?php
	//Redirect if not logged in
	session_start();

	if(isset($_SESSION["user_email"])) {
		header('Location: index.php');
	}

	//The following code is the SERVER SIDE VALIDATION (important for security reasons)
	//If the user's input is valid, it will be entered in the database and the user will be redirected to a registration success page
	//If not, incorrectly filled out fields will have an error message displayed
	$email_input = $first_name_input = $last_name_input = $password_input = $repeat_password_input = "";
	$email_input_error = $first_name_input_error = $last_name_input_error = $password_input_error = $repeat_password_input_error = "";

	//Prevent xxs issues
	//function test_input($data) {
	//	$data = trim($data);
	//	$data = stripslashes($data);
	//	$data = htmlspecialchars($data);
	//	return $data;
	//}
	
	//If this page is loaded with POST variables to be validated the following functions runs
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$email_input = $_POST["email_input"];
		$first_name_input = $_POST["first_name_input"];
		$last_name_input = $_POST["last_name_input"];
		$password_input = $_POST["password_input"];
		$repeat_password_input = $_POST["repeat_password_input"];
		
		//Assume true, becomes false as soon as one field is invalid
		$valid = true;
		
		//Login to the database 
		include 'dblogin.php';
		
		//Create and execute the SQL statement using paramterised statement with oci_bind_by_name (stops SQL injection)
		$querystring = "SELECT * FROM accountsdb WHERE email=:email_input"; 
		$stmt = oci_parse($connect, $querystring);
		oci_bind_by_name($stmt, ':email_input', $email_input); 
		oci_execute($stmt);
		
		//Get the number of rows, if its greater than 0 the email is already in use
		//oci_fetch_assoc($stmt);
		$num_rows = oci_num_rows($stmt);
		
		//Close connection
		oci_free_statement($stmt);
		oci_close($connect);
		
		
		//Email validation
		if($email_input == "") {
			$email_input_error = "Email can't be left empty.";
			$valid = false;
		} else if(strlen($email_input) > 40) {
			$email_input_error = "Email must not exceed 40 characters.";
			$valid = false;
			//This part is commented out because it doesn't work on Deakin because the PHP version is too old.
			//It should be uncommented and used when possible 
		//} else if(!filter_var($email_input, FILTER_VALIDATE_EMAIL)) {
		//	$email_input_error = "Email is not a valid format.";
		//	$valid = false;
		} else if(substr($email_input, -14) != "@deakin.edu.au") {
			$email_input_error = "Email is not a Deakin email.";
			$valid = false;
		} else if($num_rows > 0) {
			$email_input_error = "Email is already in use.";
			$valid = false;
		}
		
		//First name validation
		if($first_name_input == "") {
			$first_name_input_error = "First name can't be left empty.";
			$valid = false;
		} else if(strlen($first_name_input) > 25) {
			$first_name_input_error = "First name must not exceed 25 characters.";
			$valid = false;
		} else if(ctype_alpha($first_name_input) == false) {
			$first_name_input_error = "First name should consist only of letters.";
			$valid = false;
		}
		
		//Last name validation
		if($last_name_input == "") {
			$last_name_input_error = "Last name can't be left empty.";
			$valid = false;
		} else if(strlen($last_name_input) > 25) {
			$last_name_input_error = "Last name must not exceed 25 characters.";
			$valid = false;
		} else if(ctype_alpha($last_name_input) == false) {
			$last_name_input_error = "Last name should consist only of letters.";
			$valid = false;
		}
		
		//Password validation
		if($password_input == "") {
			$password_input_error = "Password can't be left empty.";
			$valid = false;
		} else if(strlen($password_input) > 25) {
			$password_input_error = "Password must not exceed 25 characters.";
			$valid = false;
		} else if(strlen($password_input) < 8) {
			$password_input_error = "Password must be at least 8 characters.";
			$valid = false;
		} 
		
		//Repeat Password validation
		if($repeat_password_input != $password_input) {
			$repeat_password_input_error = "Repeated password is not equal to password.";
			$valid = false;
		}
		
		//If when the user clicks submit all the fields are valid, the following runs
		if($valid) {
			
			$salt_hash = hash(sha256, uniqid(mt_rand()));
			$passhash = hash(sha256, $salt_hash.$password_input);
			$verify_hash = hash(md5, uniqid(mt_rand()));
			
			
			
			//Login to the database 
			$dbuser = "jpedler"; 
			$dbpass = "databasePassword";
			$db = "SSID"; 
			$connect = oci_connect($dbuser, $dbpass, $db);

			//Check connection
			if ($connect->connect_error) {
				die("Connection failed: " . $connect->connect_error);
			} 

			//Create and execute the SQL statement using paramterised statement with oci_bind_by_name (stops SQL injection)
			$querystring = "INSERT INTO accountsdb (email, firstname, lastname, passhash, salt, admin, emailVeri, veriHash) VALUES (:email_bv, :firstname_bv, :lastname_bv, :passhash_bv, :salt_bv, 'f', 'f', :verifyhash_bv)"; 
			$stmt = oci_parse($connect, $querystring);
			oci_bind_by_name($stmt, ':email_bv', $email_input);
			oci_bind_by_name($stmt, ':firstname_bv', $first_name_input); 
			oci_bind_by_name($stmt, ':lastname_bv', $last_name_input); 
			oci_bind_by_name($stmt, ':passhash_bv', $passhash); 
			oci_bind_by_name($stmt, ':salt_bv', $salt_hash); 
			oci_bind_by_name($stmt, ':verifyhash_bv', $verify_hash); 
			oci_execute($stmt);

			//Close connection
			oci_free_statement($stmt);
			oci_close($connect);

			$email_from = "jpedler@deakin.edu.au";
			$message = $_POST['message'];

			$email_subject = "Food & Beverage Scraper Account Activation";

			$message = '<html><body>';
			$message .= '<img src="Media/Images/logo.png">';
			$message .= '<h1 style="color:#111;">Verify your account on Food & Beverage Scraper.</h1>';
			$message .= '<p style="color:#333;font-size:18px;">To '.$first_name_input.' '.$last_name_input.'.</p>';
			$message .= '<p style="color:#333;font-size:18px;">If you recently created an account on Food & Beverage Scraper, click the link below to activate:</p>';
			$message .= '<p style="color:#333;font-size:18px;">http://www.deakin.edu.au/~jpedler/foodandbeveragescraper/verify_email.php?hash='.$verify_hash.'&email='.urlencode($email_input).'&action=verify</p>';
			$message .= '<p style="color:#333;font-size:18px;">If this wasn\'t you, click the following link to delete the account registration:</p>';
			$message .= '<p style="color:#333;font-size:18px;">http://www.deakin.edu.au/~jpedler/foodandbeveragescraper/verify_email.php?hash='.$verify_hash.'&email='.urlencode($email_input).'&action=deny</p>';
			$message .= '<p style="color:#333;font-size:18px;">Deakin\'s Food & Beverage Scraper.</p>';
			$message .= '</body></html>';

			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
			$headers .= 'From: '.$email_from."\r\n".
			'Reply-To: '.$email."\r\n" .
			'X-Mailer: PHP/' . phpversion();

			mail($email_input, $email_subject, $message, $headers);
			
			header('Location: registration_status.php?status=success');
			exit();
		}
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="styles.css">
<script src="javascript.js" type="text/javascript"></script>
<link rel="icon" type="image/png" href="Media/Images/favicon.png">
<title>Register</title>
<style>
	body {
		background-color: #EEE;
		padding: 0;
		margin: 0;
		color: #222;
		
	}
	h1 {
		display: inline-block;
	}
	h3 {
		
		font-size: 20px;
		margin-top: -25px;
		color: #2A2A2A;
	}
	#login_box {
		width: 300px;
		margin: 0 auto;
		height: 100%;
	}
	.outer {
		display: table;
		position: absolute;
		height: 100%;
		width: 100%;
	}

	.middle {
		display: table-cell;
		vertical-align: middle;
	}

	.inner {
		margin-left: auto;
		margin-right: auto;
		width: 400px;
	}
	.login_text {
		width: 100%;
		border: solid thin #444;
		outline: 0;
		font-size: 18px;
		font-family: OpenSans;
		padding-left: 2px;
	}
	#submit_button {
		background-color: #5C94CF;
		border: 0;
		outline: 0;
		padding: 10px;
		font-family: OpenSans, sans-serif;
		font-size: 16px;
		margin-top: 10px;
		cursor: pointer;
	}
	#submit_button:hover {
		background-color: #A4CDE1;	
	}
	form a {
		color: #222;
		text-decoration: none;
	}
	form a:hover {
		color: #222;
		text-decoration: underline;
	}
	.input_error_message {
		height: 20px;
		color: #DB383B;
		margin-top: 1px;
	}

	input {
		-webkit-appearance: none;
		-webkit-border-radius:0; 
	}

	/*Changes to CSS when screen width is 870px or more*/
	@media only screen and (max-width: 500px) {
		#login_box {
			width: 200px;
		}
		.inner {
			width: 300px;
		}
	}
</style>

<script>
	//The following is used for AJAX validation, needed for client side validation
	var asyncRequest;

	function validate_input(input, field) {
		try
		{
			asyncRequest = new XMLHttpRequest();
			
			if(field == "email") {
				asyncRequest.onreadystatechange = emailStateChange;
			} else if(field == "first_name") {
				asyncRequest.onreadystatechange = firstNameStateChange;
			} else if(field == "last_name") {
				asyncRequest.onreadystatechange = lastNameStateChange;
			} else if(field == "password") {
				asyncRequest.onreadystatechange = passwordStateChange;
			} else if(field == "repeat_password") {
				asyncRequest.onreadystatechange = repeatPasswordStateChange;
			}		
			asyncRequest.open('POST', 'validate.php', true);
			asyncRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			asyncRequest.send(field + "=" + input);

		}

		catch (exception)
		{
			alert('AJAX request failed.');
		}

	}

	function emailStateChange() {
		if(asyncRequest.readyState == 4 && asyncRequest.status == 200) {
			document.getElementById("email_error").innerHTML = "";
			if(asyncRequest.responseText != "") {
				document.getElementById("email_error").innerHTML = asyncRequest.responseText;
			} 
		}
	}
	function firstNameStateChange() {
		if(asyncRequest.readyState == 4 && asyncRequest.status == 200) {
			document.getElementById("first_name_error").innerHTML = "";
			if(asyncRequest.responseText != "") {
				document.getElementById("first_name_error").innerHTML = asyncRequest.responseText;
			} 
		}
	}
	function lastNameStateChange() {
		if(asyncRequest.readyState == 4 && asyncRequest.status == 200) {
			document.getElementById("last_name_error").innerHTML = "";
			if(asyncRequest.responseText != "") {
				document.getElementById("last_name_error").innerHTML = asyncRequest.responseText;
			} 
		}
	}
	function passwordStateChange() {
		if(asyncRequest.readyState == 4 && asyncRequest.status == 200) {
			document.getElementById("password_error").innerHTML = "";
			if(asyncRequest.responseText != "") {
				document.getElementById("password_error").innerHTML = asyncRequest.responseText;
			} 
		}
	}
	function validate_repeat_password(repeat, password) {
		if(repeat != password) {
			document.getElementById("repeat_password_error").innerHTML = "Repeated password is not equal to password.";
		} else {
			document.getElementById("repeat_password_error").innerHTML = "";
		}
	}
	
</script>
</head>

<body>
<div class="outer">
	<div class="middle">
		<div class="inner">
			<h1>Register</h1>
			<h3>Deakin's Food &amp; Beverage Scraper</h3> 
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
				Email
				<input class="login_text" type="text" name="email_input" onkeyup="validate_input(this.value, 'email')" autocomplete="off" value="<?php echo $email_input; ?>"/>
				<div class="input_error_message" id="email_error"><?php echo $email_input_error; ?></div>
				First name
				<input class="login_text" type="text" name="first_name_input" onkeyup="validate_input(this.value, 'first_name')" autocomplete="off" value="<?php echo $first_name_input; ?>"/>
				<div class="input_error_message" id="first_name_error"><?php echo $first_name_input_error; ?></div>
				Last name
				<input class="login_text" type="text" name="last_name_input" onkeyup="validate_input(this.value, 'last_name')" autocomplete="off" value="<?php echo $last_name_input; ?>"/>
				<div class="input_error_message" id="last_name_error" ><?php echo $last_name_input_error; ?></div>
				Password
				<input class="login_text" type="password" name="password_input" onkeyup="validate_input(this.value, 'password'); validate_repeat_password(this.value, document.getElementsByName('repeat_password_input')[0].value)" autocomplete="off" value="<?php echo $password_input; ?>"/>
				<div class="input_error_message" id="password_error"><?php echo $password_input_error; ?></div>
				Repeat Password
				<input class="login_text" type="password" name="repeat_password_input" onkeyup="validate_repeat_password(this.value, document.getElementsByName('password_input')[0].value)" autocomplete="off" value="<?php echo $repeat_password_input; ?>"/>
				<div class="input_error_message" id="repeat_password_error"><?php echo $repeat_password_input_error; ?></div>
				<input onMouseEnter="submiterrormessage()" onMouseLeave="removesubmiterrormessage()" id="submit_button" type="submit" value="Submit" /> <br>
				<a href="login.php">Return to login.</a>
			</form>
		</div>
	</div>
</div>
</body>
</html>