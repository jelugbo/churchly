<?php
/**
 * Created by PhpStorm.
 * User: jelugb1
 * Date: 9/20/2016
 * Time: 9:53 PM
 */

require_once(realpath(__DIR__ . '/../../api/vendor/autoload.php'));
require_once(realpath(__DIR__ . '/../../api/classes/conf/config.php'));
require_once(realpath(__DIR__ . '/functions.php'));

use Propel\Runtime\Propel;
use Firebase\JWT\JWT;
/***************************
 * FUNCTION: GENERATE HASH *
 ***************************/
function generateHash($password)
{
	// The crypt function can take a while so we increase the max execution time
	set_time_limit(120);
	$hash  = password_hash(base64_encode(hash('sha384',$password,true)),PASSWORD_DEFAULT);
	return $hash;
}

/***************************
 * FUNCTION: IS VALID USER *
 ***************************/
function is_valid_user($user, $pass, $upgrade = false)
{
	// Open the database connection
	$db = new UserLoginQuery();
	$array = $db->where('user_login.enabled = ?',1)->findOneByEmail($user);
	if(!$array) return false;
	// Default set valid_simplerisk, valid_ad, and valid_saml to false
	$valid_user = is_valid_login($user, $pass);

	// If either the SAML, AD, or SimpleRisk user are valid
	if ($valid_user)
	{
		// Set the user permissions
		set_user_permissions($user, $pass);

		return true;
	}
	else return false;
}

/**********************************
 * FUNCTION: ENCODE JWT DATA *
 **********************************/
function jwt_encode($user){
	//JWT
	$tokenId    = base64_encode(mcrypt_create_iv(32));
	$secret = getenv('JWT_Token');
	$issuedAt = time();
	$notBefore = $issuedAt + 1;
	$future = new DateTime("now +2 hours");
	$serverName ="www.churchlify.go";
	/*
* Create the token as an array
*/
	$token = [
		'iat'  => $issuedAt,         // Issued at: time when the token was generated
		'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
		'iss'  => $serverName,       // Issuer
		'nbf'  => $notBefore,        // Not before
		"exp" => $future->getTimeStamp(), //Expires in two hours
		'data' => [                  // Data related to the signer user
			'uid'   => $user->getValue(), // userid from the users table
			'user' => $user->getEmail(), // User name
			'role_id'   => $user->getRoleId(), // userid from the users table
			'parish_id' => $user->getParishId(), // User name
		]
	];


	$jwt = JWT::encode($token, $secret,'HS512');
	return $jwt;
}

/**********************************
 * FUNCTION: DECODE JWT DATA *
 **********************************/

function jwt_decode($jwt){
	$secret = getenv('JWT_Token');
	$decoded = JWT::decode($jwt, $secret, array('HS512'));
	return $decoded;
}

/**********************************
 * FUNCTION: SET USER PERMISSIONS *
 **********************************/
function set_user_permissions($user, $pass)
{
	// Open the database connection
	$db = new UserLoginQuery();
	$array = $db->findOneByEmail($user);
	// Set the minimal session values
	$_SESSION['uid'] = $array->getValue();
	$_SESSION['user'] = $array->getEmail();
	$_SESSION['role_id'] = $array->getRoleId();
	$_SESSION['parish_id'] = $array->getParishId();
	$_SESSION['token'] = jwt_encode($array);

}

/**************************
 * FUNCTION: GRANT ACCESS *
 **************************/
function grant_access()
{
	$_SESSION["access"] = "granted";

	// Update the last login
	update_last_login($_SESSION['uid']);

	// Audit log
	$item_id = 1000;
	$message = "Username \"" . $_SESSION['user'] . "\" logged in successfully.";
	write_log($item_id, $_SESSION['uid'], $message);
}

/**************************************
 * FUNCTION: IS VALID SIMPLERISK USER *
 **************************************/
function is_valid_login($user, $pass)
{
	// Open the database connection
	$db = new UserLoginQuery();

	// Store the list in the array
	$array = $db->findOneByEmail($user);

	// Get the stored password
	$storedPassword = $array->getPassword();
	$hash  = base64_encode(hash('sha384',$pass,true));

	// If the passwords are equal
	if (password_verify($hash,$storedPassword))
	{
		return true;
	}
	else return false;
}


/****************************
 * FUNCTION: GENERATE TOKEN *
 ****************************/
function generate_token($size)
{
	$token = "";
	$values = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));

	for ($i = 0; $i < $size; $i++)
	{
		$token .= $values[array_rand($values)];
	}

	return $token;
}

/****************************************
 * FUNCTION: PASSWORD RESET BY USERNAME *
 ****************************************/
function password_reset_by_username($username)
{
	$db = new UserLoginQuery();
	$array = $db->findOneByEmail($username);
	$userid = $array->getValue();
	// Check if the username exists
	if ($userid > 0)
	{
		password_reset_by_userid($userid);

		return true;
	}
	else return false;
}

/**************************************
 * FUNCTION: PASSWORD RESET BY USERID *
 **************************************/
function password_reset_by_userid($userid)
{

	// Generate a 20 character reset token
	$token = generate_token(20);

	// Open the database connection
	$db = new UserLoginQuery();
	$array = $db->findPk($userid);

	$username = $array->getEmail();
	$email = $array->getEmail();

	$db = new PasswordReset();
	$db->setUsername($username);
	$db->setToken($token);
	$db->save();
	// Send the reset e-mail
	send_reset_email($username, ' User ', $email, $token);

	// If this was submitted by an unauthenticated user
	if (!isset($_SESSION['uid']))
	{
		$user = "Unauthenticated";
		$uid = 0;
	}
	// Otherwise, set the user and uid
	else
	{
		$user = $_SESSION['user'];
		$uid = $_SESSION['uid'];
	}

	// Audit log
	$risk_id = 1000;
	$message = "A password reset request was submitted for user \"" . $username . "\" by the user.";
	write_log($risk_id, $uid, $message);
}

/******************************
 * FUNCTION: SEND RESET EMAIL *
 ******************************/
function send_reset_email($username, $name, $email, $token)
{
	$to = $email;
	$subject = "[CHURCHLIFY] Password Reset Token";

	// To send HTML mail, the Content-type header must be set
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=UTF-8\r\n";

	// Additional headers
	$headers .= "From: CHURCHLIFY <noreply@churchlify.com>\r\n";
	$headers .= "Reply-To: CHURCHLIFY <noreply@churchlify.com>\r\n";
	$headers .= "X-Mailer: PHP/" . phpversion();

	// Create the full HTML message
	$body = "<html><body>\n";
	$body .= "<p>Hello " . $name.",</p>\n";
	$body .= "<p>A request was submitted to reset your Churchlify password.</p>\n";
	$body .= "<b>Username:</b>&nbsp;&nbsp;".$username."<br/>\n";
	$body .= "<b>Reset Token:</b>&nbsp;&nbsp;".$token."<br/>\n";
	$body .= "<p>You may now use the \"<u>Forgot your password</u>\" link on Churchlify log in page to reset your password.</p>";
	$body .= "<p>This is an automated message and responses will be ignored or rejected.</p>\n";
	$body .= "</body></html>\n";
	//mail($to, $subject, $body, $headers);

	// Require the mail functions
	require_once(realpath(__DIR__ . '/mail.php'));

	// Send the e-mail
	send_email($name, $email, $subject, $body);
}

/*************************************
 * FUNCTION: PASSWORD RESET BY TOKEN *
 *************************************/
function password_reset_by_token($username, $token, $password, $repeat_password)
{
	$db = new UserLoginQuery();
	$array = $db->findOneByEmail($username);
	$user_id = $array->getValue();

	// Check the password
	$error_code = valid_password($password, $repeat_password);

	// If the password is valid
	if ($error_code == 1)
	{
		// If the username exists
		if ($user_id > 0)
		{
			// If the reset token is valid
			if (is_valid_reset_token($username, $token))
			{
				// Open the database connection
				$db = new UserLoginQuery();
				$user = $db->findPk($user_id);
				// Create the new password hash
				$hash  = generateHash($password);
				if(is_object($user)){
					$user->setPassword($hash);
					$user->save();
				}
				return true;
			}
		}
		else return false;
	}
	else return false;
}

/**********************************
 * FUNCTION: IS VALID RESET TOKEN *
 **********************************/
function is_valid_reset_token($username, $token)
{
	// Open the database connection
	$con = Propel::getConnection();
	$sql = "DELETE FROM password_reset WHERE timestamp < DATE_SUB(NOW(), INTERVAL 15 MINUTE)";
	$stmt = $con->prepare($sql);
	$stmt->execute();
	$db = new PasswordResetQuery();
	// Increment the attempts for the username
	$array = $db->findOneByUsername($username);

	// If there is not a match for the username and token
	if (empty($array))
	{
		return false;
	}
	else
	{
		$array->setAttempts($array->getAttempts() + 1);
		$array->save();
		// Search for a valid token
		$array = $db->filterByUsername($username)->findOneByToken($token)->toArray();
		$attempts = $array['Attempts'];
		// Remove the matching token
		$array = $db->findOneByToken($token);
		$array->delete();
		// Matching token has been attempted <= 5 times
		if ($attempts < 5)
		{
			return true;
		}
		// Matching token has been attempted > 5 times
		else return false;
	}
}

/***************************
 * FUNCTION: SESSION CHECK *
 ***************************/
function session_check()
{
	// Perform session garbage collection
	sess_gc(1440);

	// Last request was more $last_activity
	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > LAST_ACTIVITY_TIMEOUT))
	{
		// unset $_SESSION variable for the run-time
		session_unset();

		// destroy session data in storage
		session_destroy();

		// Return false
		return false;
	}
	// update last activity time stamp
	$_SESSION['LAST_ACTIVITY'] = time();

	// If the session created value has not been set
	if (!isset($_SESSION['CREATED']))
	{
		// Set it with the current time
		$_SESSION['CREATED'] = time();
	}
	// Otherwise check if it was created more than $created
	else if (time() - $_SESSION['CREATED'] > SESSION_RENEG_TIMEOUT)
	{
		// change session ID for the current session an invalidate old session ID
		session_regenerate_id(true);

		// update creation time
		$_SESSION['CREATED'] = time();
	}

	// Return true
	return true;
}

/****************************************
 * FUNCTION: SESSION GARBAGE COLLECTION *
 ****************************************/
function sess_gc($sess_maxlifetime)
{
	$old = time() - $sess_maxlifetime;
	$current_time = time();
	$session = SessionsQuery::create()->where('Sessions.Access < ?', $old)->find();
	//$session->delete();
	return true;
}

/********************
 * FUNCTION: LOGOUT *
 ********************/
function logout()
{
	// Get the session username and uid
	$username = $_SESSION['user'];
	$uid = $_SESSION['uid'];

	// Audit log
	$risk_id = 1000;
	$message = "Username \"" . $username . "\" logged out successfully.";
	write_log($risk_id, $uid, $message);

	// Deny access
	$_SESSION["access"] = "denied";

	// Reset the session data
	$_SESSION = array();

	// Send a Set-Cookie to invalidate the session cookie
	if (ini_get("session.use_cookies"))
	{
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], isset($params['httponly']));
	}

	// Destroy the session
	session_destroy();
}
