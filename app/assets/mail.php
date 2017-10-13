<?php

/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */

// Include required configuration files
require_once(realpath(__DIR__ . '/../../api/vendor/autoload.php'));
require_once(realpath(__DIR__ . '/../../api/classes/conf/config.php'));

// Include Zend Escaper for HTML Output Encoding
require_once(realpath(__DIR__ . '/../../api/vendor/zendframework/zend-escaper/src/Escaper.php'));
$escaper = new Zend\Escaper\Escaper('utf-8');

/*******************************
 * FUNCTION: GET MAIL SETTINGS *
 *******************************/
function get_mail_settings()
{
	// Open the database connection
	$db = new SettingsQuery();
	$array = $db->where('Settings.Name LIKE ?','phpmailer_%')->find()->toArray();
	// For each entry in the array
	$mail= array();
	foreach ($array as $value)
	{
		$mail[$value['Name']] = $value['Value'];
	}

	return $mail;
}

/**********************************
 * FUNCTION: UPDATE MAIL SETTINGS *
 **********************************/
function update_mail_settings($transport, $from_email, $from_name, $replyto_email, $replyto_name, $host, $smtpauth, $username, $password, $encryption, $port)
{
	// Open the database connection
	$db = db_open();

	// If the transport is sendmail or smtp
	if ($transport == "sendmail" || $transport == "smtp")
	{
		// Update the transport
		$stmt = $db->prepare("UPDATE `settings` SET value=:value WHERE name='phpmailer_transport'");
		$stmt->bindParam(":value", $transport, PDO::PARAM_STR, 200);
		$stmt->execute();
	}

	// Update the from_email
	$stmt = $db->prepare("UPDATE `settings` SET value=:value WHERE name='phpmailer_from_email'");
	$stmt->bindParam(":value", $from_email, PDO::PARAM_STR, 200);
	$stmt->execute();

	// Update the from_name
	$stmt = $db->prepare("UPDATE `settings` SET value=:value WHERE name='phpmailer_from_name'");
	$stmt->bindParam(":value", $from_name, PDO::PARAM_STR, 200);
	$stmt->execute();

	// Update the replyto_email
	$stmt = $db->prepare("UPDATE `settings` SET value=:value WHERE name='phpmailer_replyto_email'");
	$stmt->bindParam(":value", $replyto_email, PDO::PARAM_STR, 200);
	$stmt->execute();

	// Update the replyto_name
	$stmt = $db->prepare("UPDATE `settings` SET value=:value WHERE name='phpmailer_replyto_name'");
	$stmt->bindParam(":value", $replyto_name, PDO::PARAM_STR, 200);
	$stmt->execute();

	// Update the host
	$stmt = $db->prepare("UPDATE `settings` SET value=:value WHERE name='phpmailer_host'");
	$stmt->bindParam(":value", $host, PDO::PARAM_STR, 200);
	$stmt->execute();

	// If the SMTP Authentication is either true or false
	if ($smtpauth == "true" || $smtpauth == "false")
	{
		// Update the smtp authentication
		$stmt = $db->prepare("UPDATE `settings` SET value=:value WHERE name='phpmailer_smtpauth'");
		$stmt->bindParam(":value", $smtpauth, PDO::PARAM_STR, 200);
		$stmt->execute();
	}

	// Update the username
	$stmt = $db->prepare("UPDATE `settings` SET value=:value WHERE name='phpmailer_username'");
	$stmt->bindParam(":value", $username, PDO::PARAM_STR, 200);
	$stmt->execute();

	// If the password is not empty
	if ($password != "")
	{
		// Update the value
		$stmt = $db->prepare("UPDATE `settings` SET value=:value WHERE name='phpmailer_password'");
		$stmt->bindParam(":value", $password, PDO::PARAM_STR, 200);
		$stmt->execute();
	}

	// If the encryption is none or tls or ssl
	if ($encryption == "none" || $encryption == "tls" || $encryption == "ssl")
	{
		// Update the encryption
		$stmt = $db->prepare("UPDATE `settings` SET value=:value WHERE name='phpmailer_smtpsecure'");
		$stmt->bindParam(":value", $encryption, PDO::PARAM_STR, 200);
		$stmt->execute();
	}

	// If the port is an integer value
	if (is_numeric($port))
	{
		// Update the port
		$stmt = $db->prepare("UPDATE `settings` SET value=:value WHERE name='phpmailer_port'");
		$stmt->bindParam(":value", $port, PDO::PARAM_STR, 200);
		$stmt->execute();
	}

	// Close the database connection
	db_close($db);
}

/************************
 * FUNCTION: SEND EMAIL *
 ************************/
function send_email($name, $email, $subject, $body)
{
	// Get the mail settings
	$mail = get_mail_settings();
	$transport = $mail['phpmailer_transport'];
	$from_email = $mail['phpmailer_from_email'];
	$from_name = $mail['phpmailer_from_name'];
	$replyto_email = $mail['phpmailer_replyto_email'];
	$replyto_name = $mail['phpmailer_replyto_name'];
	$host = $mail['phpmailer_host'];
	$smtpauth = $mail['phpmailer_smtpauth'];
	$username = $mail['phpmailer_username'];
	$password = $mail['phpmailer_password'];
	$encryption = $mail['phpmailer_smtpsecure'];
	$port = $mail['phpmailer_port'];

	// Load the PHPMailer library
	require_once(realpath(__DIR__ . '/../../api/vendor/PHPMailer/PHPMailer/PHPMailerAutoload.php'));

	// Create a new PHPMailer instance
	$mail = new PHPMailer;

	// Set who the message is to be sent from
	$mail->setFrom($from_email, $from_name);

	// Set an alternative reply-to address
	$mail->addReplyTo($replyto_email, $replyto_name);

	// Add a recipient
	$mail->addAddress($email, $name);

	// Add a CC
	// $mail->addCC('cc@example.com');

	// Add a BCC
	// $mail->addBCC('bcc@example.com');

	// Set the subject line
	$mail->Subject = $subject;

	// Set the email format to HTML
	$mail->isHTML(true);

	// Message body in HTML
	$mail->Body = $body;

	// Message body in plain text for non-HTML mail clients
	//$mail->AltBody = 'This is a plain-text message body';

	// Read an HTML message body from an external file, convert referenced images to embedded
	// convert HTML into basic plain-text alternative body
	// $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));

	// Attach an image file
	// $mail->addAttachment('images/phpmailer_mini.png');
	// Add attachments with an optional name
	// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');

	// If the transport is sendmail
	if ($transport == "sendmail")
	{
		// Set PHPMailer to use the sendmail transport
		$mail->isSendmail();
	}
	// If the transport is smtp
	else if ($transport == "smtp")
	{
		// Set PHPMailer to use the smtp transport
		$mail->isSMTP();

		// Specify the main SMTP server
		// Could be a semi-colon separated list
		$mail->Host = $host;

		// TCP port to connect to
		$mail->Port = $port;

		// If SMTP authentication is enabled
		if ($smtpauth == "true")
		{
			// Enable SMTP authentication
			$mail->SMTPAuth = true;

			// SMTP username
			$mail->Username = $username;

			// SMTP password
			$mail->Password = $password;

			// If the encryption is tls
			if ($encryption == "tls")
			{
				// Enable TLS encryption
				$mail->SMTPSecure = 'tls';
			}
			// Otherwise, if the encryption is ssl
			else if ($encryption == "ssl")
			{
				// Enable SSL encryption
				$mail->SMTPSecure = 'ssl';
			}else if ($encryption == "none")
            {
                // Enable SSL encryption
                $mail->SMTPSecure = false;
                $mail->SMTPAutoTLS = false;
            }


		}
	}

	
		// Send the message, check for errors
	$res = new stdClass();
	$res->status = false;
	if (!$mail->send())
	{
		// Log any errors to the debug log
		$res->status_msg = $mail->ErrorInfo;
		error_log($mail->ErrorInfo.'\n\r',3,'custom_mail.log');
		error_log(print_r($mail,true),3,'custom_mail.log');
		write_debug_log("Mailer Error: " . $mail->ErrorInfo);
	}else{
		$res->status = true;
		$res->status_msg = "Email successfully sent";
		sleep(1);
		error_log(print_r($mail,true),3,'mail.log');
	}
	// Send the message, check for errors
	/*$res = false;
	if (!$mail->send())
	{
		// Log any errors to the debug log
		error_log($mail->ErrorInfo.'\n\r',3,'mail.log');
		error_log(print_r($mail,true),3,'mail.log');
		write_debug_log("Mailer Error: " . $mail->ErrorInfo);
	}else{
        $res = true;
		error_log(print_r($mail,true),3,'mail.log');
	}*/
	return $res;
}


/************************
 * FUNCTION: SEND EMAIL *
 ************************/
function send_custom_email($custom)
{
	// Get the mail settings
	$mail = get_mail_settings();
	$transport = $mail['phpmailer_transport'];
	$from_email = $mail['phpmailer_from_email'];
	$from_name = $custom['FromName'];
	$replyto_email = $custom['FromEmail'];
	$replyto_name = $custom['FromName'];
	$host = $mail['phpmailer_host'];
	$smtpauth = $mail['phpmailer_smtpauth'];
	$username = $mail['phpmailer_username'];
	$password = $mail['phpmailer_password'];
	$encryption = $mail['phpmailer_smtpsecure'];
	$port = $mail['phpmailer_port'];

	// Load the PHPMailer library
	require_once(realpath(__DIR__ . '/../../api/vendor/PHPMailer/PHPMailer/PHPMailerAutoload.php'));

	// Create a new PHPMailer instance
	$mail = new PHPMailer;

	// Set who the message is to be sent from
	$mail->setFrom($from_email, $from_name);

	// Set an alternative reply-to address
	$mail->addReplyTo($replyto_email, $replyto_name);

	// Add a recipient
	$mail->addAddress($custom['ToEmail'], $custom['ToName']);

	// Add a CC
	// $mail->addCC('cc@example.com');

	// Add a BCC
	// $mail->addBCC('bcc@example.com');

	// Set the subject line
	$mail->Subject = $custom['Subject'];

	// Set the email format to HTML
	$mail->isHTML(true);

	// Message body in HTML
	$mail->Body = $custom['Message'];

	// Message body in plain text for non-HTML mail clients
	//$mail->AltBody = 'This is a plain-text message body';

	// Read an HTML message body from an external file, convert referenced images to embedded
	// convert HTML into basic plain-text alternative body
	// $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));

	// Attach an image file
	// $mail->addAttachment('images/phpmailer_mini.png');
	// Add attachments with an optional name
	// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');

	// If the transport is sendmail
	if ($transport == "sendmail")
	{
		// Set PHPMailer to use the sendmail transport
		$mail->isSendmail();
	}
	// If the transport is smtp
	else if ($transport == "smtp")
	{
		// Set PHPMailer to use the smtp transport
		$mail->isSMTP();

		// Specify the main SMTP server
		// Could be a semi-colon separated list
		$mail->Host = $host;

		// TCP port to connect to
		$mail->Port = $port;

		// If SMTP authentication is enabled
		if ($smtpauth == "true")
		{
			// Enable SMTP authentication
			$mail->SMTPAuth = true;

			// SMTP username
			$mail->Username = $username;

			// SMTP password
			$mail->Password = $password;

			// If the encryption is tls
			if ($encryption == "tls")
			{
				// Enable TLS encryption
				$mail->SMTPSecure = 'tls';
			}
			// Otherwise, if the encryption is ssl
			else if ($encryption == "ssl")
			{
				// Enable SSL encryption
				$mail->SMTPSecure = 'ssl';
			}else if ($encryption == "none")
			{
				// Enable SSL encryption
				$mail->SMTPSecure = false;
				$mail->SMTPAutoTLS = false;
			}


		}
	}

	// Send the message, check for errors
	$res = new stdClass();
	$res->status = false;
	if (!$mail->send())
	{
		// Log any errors to the debug log
		$res->status_msg = $mail->ErrorInfo;
		error_log($mail->ErrorInfo.'\n\r',3,'custom_mail.log');
		error_log(print_r($mail,true),3,'custom_mail.log');
		write_debug_log("Mailer Error: " . $mail->ErrorInfo);
	}else{
		$res->status = true;
		$res->status_msg = "Email successfully sent";
		sleep(1);
		error_log(print_r($mail,true),3,'mail.log');
	}
	return $res;
}

?>
