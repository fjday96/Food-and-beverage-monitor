<?php
	if(isset($_POST['email_submit'])) {
		$email_to = "jpedler@deakin.edu.au";

		$email = "jpedler@deakin.edu.au";
		$message = $_POST['message'];

		$email_subject = "Food & Beverage Scraper Account";

		$message = '<html><body>';
		$message .= '<img src="Media/Images/logo.png">';
		$message .= '<h1 style="color:#111;">Verify your account on Food & Beverage Scraper.</h1>';
		$message .= '<p style="color:#333;font-size:18px;">If you recently created an account on Food & Beverage Scraper, click the link below to activate: <br>
		www.foodandbeveragescraper.com.blablabla</p>';
		$message .= '<p style="color:#333;font-size:18px;">If this wasn\'t you, click the following link to delete the account registration: <br>
		www.foodandbeveragescraper.com.blablabla</p>';
		$message .= '</body></html>';
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= 'From: '.$email."\r\n".
		'Reply-To: '.$email."\r\n" .
		'X-Mailer: PHP/' . phpversion();

		mail($email_to, $email_subject, $message, $headers);

		$_SESSION["formstate"] = "sent";

		header("Location: send_email_test.php");
}
?>