<?php
/**
 * Created by PhpStorm.
 * User: jelugb1
 * Date: 9/20/2016
 * Time: 12:45 PM
 */
require_once(realpath(__DIR__ . '/../../api/vendor/autoload.php'));
require_once(realpath(__DIR__ . '/../../api/classes/conf/config.php'));
require_once(realpath(__DIR__ . '/../assets/notification.php'));
//require_once '..\api\vendor\autoload.php'; // Loads the library
use Twilio\Rest\Client;
use Twilio\Exceptions\TwilioException;
//use PayPal\Api\Amount;
//use PayPal\Api\Details;
//use PayPal\Api\FundingInstrument;
//use PayPal\Api\Item;
//use PayPal\Api\ItemList;
//use PayPal\Api\Payer;
//use PayPal\Api\Payment;
//use PayPal\Api\PaymentCard;
//use PayPal\Api\Transaction;
use Stripe\Stripe;

use Propel\Runtime\Propel;
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */

// Session last activity timeout (Default: 3600 = 1h)
define('LAST_ACTIVITY_TIMEOUT', '3600');

// Session renegotiation timeout (Default: 600 = 10m)
define('SESSION_RENEG_TIMEOUT', '600');

// Use database for sessions
define('USE_DATABASE_FOR_SESSIONS', 'true');

// Enable Content Security Policy (This has broken Chrome in the past)
define('CSP_ENABLED', 'false');

// Set the default language (Can be overridden per user)
// Options: bp, en, es
define('LANG_DEFAULT', 'en');

// Set the default Timezone
// List of supported timezones here: http://www.php.net/manual/en/timezones.php
date_default_timezone_set('America/Chicago');

// Turn on debugging
define('DEBUG', 'false');

function call_api($method,$end_point,$data,$in_house = false){
	$service_url = ($in_house) ?'http://localhost/church/api/'.$end_point:$end_point;
	$ch = curl_init($service_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	/**************************
	 * Man in the middle starts
	 ***************************/
	switch($method){
		case 'POST':
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			break;
		case 'PUT':
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
			break;
		case 'DELETE':
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

			break;
		default:
	}
	/**************************
	 * Man in the middle ends
	 ***************************/
	$response = curl_exec($ch);
	return $response;
}

/**************************************
 * FUNCTION: COMMA SEPARATED K->V IN ARRAY *
 **************************************/

function get_settings_array($settings){
	$temp = explode (',',$settings);
	$pairs= array();
	foreach ($temp as $pair) {
		list ($k,$v) = explode (':',$pair);
		$pairs[$k] = $v;
	}

	return $pairs;
}


/***********************
 * FUNCTION: WRITE LOG *
 ***********************/
function write_log($risk_id, $user_id, $message)
{
	// Subtract 1000 from id
	$risk_id = $risk_id - 1000;

	// If the user_id value is not set
	if (!isset($user_id))
	{
		$user_id = 0;
	}
	$message = try_encrypt($message);
	// Open the database connection

	$db = new AuditLog();
	$db->setUserId($user_id);
	$db->setParishId($risk_id);
	$db->setMessage($message);
	$db->save();
}

function get_role_id($role){
	$user_role = RolesQuery::create()->findByName($role)->getFirst();
	return $user_role->getValue();
}

/*********************************
 * FUNCTION: CALL STRIPE PAYMENT *
 *********************************/

function doStripeCustomer($email,$token,$params,$plan){

	try{
		\Stripe\Stripe::setApiKey($params['secretkey']);
		$customer = \Stripe\Customer::create(array(
			"email" => $email,
			"card" => $token,
			"description" => 'Churchlify subscription for '.$plan.' Plan'
		));
		//$customer->subscriptions->create(array('plan' => $plan));
		return $customer;

	}catch(\Stripe\Exception $e){
		error_log(print_r($e,true),3,"error.txt");
		return $e;
	}
}


/*********************************
 * FUNCTION: CALL STRIPE PAYMENT *
 *********************************/

function doStripeSubscribe($customer, $plan,$user_id,$params){

	try{
		\Stripe\Stripe::setApiKey($params['secretkey']);
		$subscribe = \Stripe\Subscription::create(array(
			'customer' => $customer,
			'plan' => $plan,
			'metadata' => array("customer_id" => $customer, "user_id" => $user_id, "plan" => $plan)
		));

		return $subscribe;

	}catch(\Stripe\Exception $e){
		error_log(print_r($e,true),3,"error.txt");
	}
}


/*******************************
 * FUNCTION: CREATE SUBSCRIPTION*
 *******************************/
function create_subscription($email,$pass, $parish,$plan_id,$token,$params){
	$res = new stdClass();
	$role = get_role_id('User');
	$item = UserPlanQuery::create()->findPk($plan_id);
	$res->value = 0;
	$res->msg ='Unknown Error: Please try again later!';
	// get the PDO connection object from Propel
	$con = Propel::getConnection(\Map\UserLoginTableMap::DATABASE_NAME);
	//$toAccount   = AccountQuery::create()->findPk($toAccountNumber, $con);
	$con->beginTransaction();

	try {
		$login = new UserLogin();
		if (!user_exist($email)) {
			// Verify that it is a valid username format
			if (valid_username($email)) {
				$hash  = generateHash($pass);
				$login->setEmail($email);
				$login->setParishId($parish);
				$login->setPassword($hash);
				$login->setEnabled(1);
				$login->setRoleId($role);
				// Create new user
				$insert = $login->save($con);
				if($insert){
					$user_id = $login->getValue();
					//User created now process payment
					$customer = doStripeCustomer($email,$token,$params,$item->getName());
					if($customer){
						error_log(print_r($customer,true),3,"customer.txt");
						$subscribe = doStripeSubscribe($customer->id,$item->getName(),$user_id,$params);
						if($subscribe){
							$payment = new UserPayment();
							$payment->setStatus($subscribe->status);
							$payment->setUserId($user_id);
							$payment->setDescription($customer->description);
							$payment->setReference($subscribe->id);
							$payment->setLog(json_encode($subscribe->metadata->__toArray()));
							$pay_insert = $payment->save($con);
							if($pay_insert){
								$quota = array("sms"=>0,"mms"=>0,"push"=>0,"devotions"=>0,"events"=>0,"letter"=>0);
								$subscription = new UserSubscription();
								$subscription->setStatus(1);
								$subscription->setUserId($user_id);
								$subscription->setPlanId($plan_id);
								$subscription->setParishId($parish);
								$subscription->setPayId($payment->getValue());
								$subscription->setCustomerRef($customer->id);
								$subscription->setStartDate(DateTime::createFromFormat('U',$subscribe->current_period_start));
								$subscription->setEndDate(DateTime::createFromFormat('U',$subscribe->current_period_end));
								$subscription->setMileage(json_encode($quota));
								$sub_insert = $subscription->save($con);
								if($sub_insert){
									$res->msg ="Congratulations!, your profile has been created.";
									$con->commit();
									$alert_item = array($subscribe->id,$customer->description,$item->getName(),$item->getCost(),$subscribe->status);
									notify_subscriber($email,$alert_item,$parish);
									// name, (ref,desc,total,status),parish
								}else{
									$res->msg ="There was an error completing your profile, Please contact the administrator";
									$con->rollback();
								}
							}else {
								$res->msg ="There was an error creating your profile, Please contact the administrator";
								$con->rollback();
							}
						}else{
							// Error with Subscription
							$res->msg ="There was a problem subscribing you to this plan, your card has not been charged.";
							$con->rollback();
						}


					}	else {
						$res->msg ="There was a problem with your payment, your card has not been charged.";
						$con->rollback();
					}
					//create customer and save customer id with user id
					//Add subscription to user

				}else{
					$res->msg ="There was a problem creating your user profile, please check your details and try again.";
					$con->rollback();
				}
//				$insert_json = json_decode($insert);
//				$res->value = (isset($insert_json->value) && $insert_json->value > 0) ? $insert_json->value : 0;
//				$res->msg = (isset($insert_json->value) && $insert_json->value > 0) ? "Your user profile was successful created.":'Database Error: Could not create profile';
				//$con->commit();
			}
			else {
				$res->msg ="An invalid username was specified.  Please try again with a different username.";
				$con->rollback();
			}
		}else{
			$res->msg = "The username already exists.  Please try again with a different username.";
			$con->rollback();
		} //


	} catch (Exception $e) {
		$con->rollback();
		$res->msg = $e->getMessage();
	}
	return $res;
//$user = create_login_profile($email,$pass, $parish,$role);
}


/**********************************
 * FUNCTION: SUBSCRIBER NOTIFICATION *
 **********************************/
function notify_subscriber($email,$item,$parish){// name, (ref,desc,total,status),parish
	$body = '';
	$parish_db = ParishQuery::create()->findPk($parish);
	$subject= $item[4]. ': Your Churchlify '.$item[2].' Subscription for '.$parish_db->getName();
	$body .=  'Hello '. $email.',';
	$body .= vsprintf("<br><br>Please find subscriprion details below:<br><br>
        Subscription Reference: %s<br>Description: %s<br>Plan: %s Plan<br>
		Total: USD %s<br>Status: %s<br><br>Regards,<br>-Churchlify", $item);
	$a = array($email, $email, $subject, $body);
	send_email($email, $email, $subject, $body);
}


function get_notify_message($module, $uid){
	$user = UserProfileQuery::create()->findPk($uid);
	$msg = 'Dear Church Admin, <br> Your mobile app user '.$user->getFname(). ' '.$user->getLname()
	.' attempted using the '.$module.' function on the mobile app <br> and is requesting you to make'
	.'efforts towards  enabling tis feature. <br> Kindly let us know if we can assist in helping you enable this feature'
	.'<br><br>Kind regards,<br>Churchlify Team,<br>hello@churchlify.com';
	return $msg;
}

function get_notify_emails($pid){
	$parish = ParishQuery::create()->findPk($pid);
	$subscribers = UserSubscriptionQuery::create()->findByParishId($pid);
	$emails = array();
	$emails[0]['name'] = $parish->getName();
	$emails[0]['email'] = $parish->getEmail();
	$i = 1;
	foreach($subscibers as $sub){
		$emails[$i]['name'] = $sub->getUserLogin()->getEmail();
		$emails[$i]['email'] = $sub->getUserLogin()->getEmail();
		$i++;
	}
	return $emails;
	
}

/*******************************
 * FUNCTION: CREATE NEW LOGIN *
 *******************************/
function create_login_profile($email,$pass, $parish,$role){
	$res = new stdClass();
	$res->value = 0;
	$res->msg ='Unknown Error: Please try again later!';
	if (!user_exist($email)) {
		// Verify that it is a valid username format
		if (valid_username($email)) {
			$hash  = generateHash($pass);
			// Create new user
			$data=array(
				'Email' => $email,
				'ParishId' => $parish,
				'Password' => $hash,
				'RoleId' => $role,
				'Enabled' => 1
			);
			$insert = call_api('POST','login/new',$data,true);
			$insert_json = json_decode($insert);
			$res->value = (isset($insert_json->value) && $insert_json->value > 0) ? $insert_json->value : 0;
			$res->msg = (isset($insert_json->value) && $insert_json->value > 0) ? "Your user profile was successful created.":'Database Error: Could not create profile';
		}
		else {
			$res->msg ="An invalid username was specified.  Please try again with a different username.";
		}
	}else{
		$res->msg = "The username already exists.  Please try again with a different username.";
	} //
	return $res;
}


/*******************************
 * FUNCTION: UPDATE LAST LOGIN *
 *******************************/
function update_last_login($user_id)
{
	// Get current datetime for last_update
	$current_datetime = date('Y-m-d H:i:s');

	// Open the database connection
	$db = new UserLoginQuery();
	$user = $db->findPk($user_id);
	if(is_object($user)){
		$user->setLastLogin($current_datetime);
		$submit =  $user->save();
	}
	return true;
}

/***********************************
 * FUNCTION: SEND SMS TO RECIPIRNT *
 ***********************************/

function sendSMS($to,$msg)
{
	$sid = "AC773338ab5d62998f605a2df6768da416";
	$token = "d34d3dea512e082f17347226b94a43ce";
	$client = new Client($sid, $token);
	try{
		$client->messages->create(
			$to,
			array(
				'from' => "4804184020",
				'body' => $msg
			)
		);
		return true;
	} catch (TwilioException $e) {
		error_log( $e->getCode() . ' : ' . $e->getMessage(),3,"twilio.txt" );
		return false;
	}
}

/***********************************
 * FUNCTION: SEND MMS TO RECIPIRNT *
 ***********************************/

function sendMMS($to,$msg,$url)
{
	$sid = "AC773338ab5d62998f605a2df6768da416";
	$token = "d34d3dea512e082f17347226b94a43ce";
	$client = new Client($sid, $token);
	try{
		$client->messages->create(
			$to,
			array(
				'from' => "4804184020",
				'body' => $msg,
				'mediaUrl' => $url
			)
		);
		return true;
	} catch (TwilioException $e) {
		error_log( $e->getCode() . ' : ' . $e->getMessage(),3,"twilio.txt" );
		return false;
	}

}

/**************************************
 * FUNCTION: GET LETTER AND RECIPIENT *
 **************************************/

function queue_letters($job_id){
	$done = 0;
	$balance = get_user_mileage($_SESSION['uid'],'letter');
	$my_plan = get_user_plan($_SESSION['uid']);
	$job = JobQueueQuery::create()->findPk($job_id);
	$dbs = new UserProfileQuery();
	$group_id = $job->getRecipientsId();
	$msg = $job->getLetters();
	$parish_id =$_SESSION['parish_id'];
	$news_tos = ($group_id > 0) ? $dbs->filterByParishId($parish_id)->usePushRegisterQuery()->filterByGroupId($group_id)->filterByEnabled(1)->endUse()->select(array('value'))->find()->toArray(): $dbs->filterByParishId($parish_id)->select(array('value'))->find()->toArray();

	foreach ($news_tos as $news_to) {
		//$letter = get_user_letter($news_to, $message);
		if($done < $balance && $my_plan->getUserPlan()->getName() !== 'Free'){
			$user = UserProfileQuery::create()->findOneByValue($news_to);
			$string = replace_placeholders($msg->getLetter(),$news_to);
			$queue_db = new LetterQueue();
			$queue_db->setStatus("new");
			$queue_db->setFromEmail($msg->getSenderEmail());
			$queue_db->setFromName($msg->getSenderName());
			$queue_db->setJobId($job_id);
			$queue_db->setToEmail($user->getEmail());
			$queue_db->setSubject($msg->getSubject());
			$queue_db->setMessage($string);
			$queue_db ->save();
			$done++;
		}



	}
	return $done;
}

function replace_placeholders($str,$user_id){
	$user = UserProfileQuery::create()->findOneByValue($user_id);
	$variables = array(
		"first_name" => $user->getFname(),
		"last_name" => $user->getLname(),
		"phone" => $user->getPhone(),
		"email" => $user->getEmail(),
		"birthday" => $user->getDob(),
		"anniversary" => $user->getWedding(),
		"address" => $user->getAddress(),
		"city" => $user->getCity(),
		"state" => $user->getState(),
		"zip" => $user->getZip(),
		"todays_date" => date("F d Y")
	);

	foreach($variables as $key => $value){
		$str = str_replace('{{'.strtoupper($key).'}}', $value,$str );
	}
	return $str;
}

/****************************
 * FUNCTION: SEND WELCOME LETTER *
 ****************************/
function send_welcome_letter($parish,$user,$login){
	$res = new stdClass();
	$res->value = 0;
	$res->msg = 'An unknown error has occured';
	//$res = json_encode(array('value'=>0,'msg'=>'An unknown error has occured'));
	if(check_user_mileage($login,'letter',1)){
		$letter = LettersQuery::create()->filterByTypeId(1)->filterByPublished(1)->findOneByParishId($parish);
		if(!is_null($letter)){
			$msg = replace_placeholders($letter->getLetter(),$user);
			$recipient = UserProfileQuery::create()->findPk($user);
			if (filter_var($recipient->getEmail(), FILTER_VALIDATE_EMAIL)) {
				$my_letter = array(
					'FromEmail'=>$letter->getSenderEmail(),
					'FromName'=>$letter->getSenderName(),
					'ToEmail'=>$recipient->getEmail(),
					'ToName'=> $name = $recipient->getFname().' '.$recipient->getLname(),
					'Subject'=>$letter->getSubject(),
					'Message'=>$msg,
				);
				$sender = send_custom_email($my_letter);
				if($sender->status){
					$res->value = 1;
					$res->msg = "Welcome letter has been sent to ".$recipient->getFname().' '.$recipient->getLname();
				}else{
					$res->msg = $sender->status_msg;//"An error occured while trying to send out the welcome letter, please try again later";
				}
			}else{
				$res->msg ="This member does not have a valid email address, please correct and retry later";
			}

		}else{
			$res->msg ='You have not yet created a welcome letter for this parish, Please create a welcome letter and try again';
		}
	}else{
	$res->msg ='You do not have enough credit(s) to fulfill this action, please upgrade your plan';
	}
	return $res;
}

/****************************
 * FUNCTION: VALID PASSWORD *
 ****************************/
function valid_password($password, $repeat_password)
{
	// Check that the two passwords are the same
	if ($password == $repeat_password)
	{
		// If the password policy is enabled
		if (get_setting('pass_policy_enabled') == 1)
		{
			// If the password policy requirements are being met
			if (check_valid_min_chars($password) && check_valid_alpha($password) && check_valid_upper($password) && check_valid_lower($password) && check_valid_digits($password) && check_valid_specials($password))
			{
				// Return 1
				return 1;
			}
			// Otherwise, return 101
			else return 101;
		}
		// Otherwise, return 1
		else return 1;
	}
	// Otherwise, return 100
	else return 100;
}



/*****************************
 * FUNCTION: WRITE DEBUG LOG *
 *****************************/
function write_debug_log($value)
{
	// If DEBUG is enabled
	if (DEBUG == "true")
	{
		// Log file to write to
		$log_file = "/tmp/debug_log";

		// Write to the error log
		$return = error_log(date('c')." ".$value."\n", 3, $log_file);
	}
}


/***********************************
 * FUNCTION: CHECK VALID MIN CHARS *
 ***********************************/
function check_valid_min_chars($password)
{
	// If the password length is >= the minimum characters
	if (strlen($password) >= get_setting('pass_policy_min_chars'))
	{
		// Return true
		return true;
	}
	// Otherwise, return false
	else return false;
}

/*******************************
 * FUNCTION: CHECK VALID ALPHA *
 *******************************/
function check_valid_alpha($password)
{
	// If alpha checking is enabled
	if (get_setting('pass_policy_alpha_required') == 1)
	{
		// If the password contains an alpha character
		if (preg_match('/[A-Za-z]+/', $password))
		{
			// Return true
			return true;
		}
		// Otherwise, return false
		else return false;
	}
	// Otherwise, return true
	else return true;
}

/*******************************
 * FUNCTION: CHECK VALID UPPER *
 *******************************/
function check_valid_upper($password)
{
	// If upper checking is enabled
	if (get_setting('pass_policy_upper_required') == 1)
	{
		// If the password contains an upper character
		if (preg_match('/[A-Z]+/', $password))
		{
			// Return true
			return true;
		}
		// Otherwise, return false
		else return false;
	}
	// Otherwise, return true
	else return true;
}

/*******************************
 * FUNCTION: CHECK VALID LOWER *
 *******************************/
function check_valid_lower($password)
{
	// If lower checking is enabled
	if (get_setting('pass_policy_lower_required') == 1)
	{
		// If the password contains an lower character
		if (preg_match('/[a-z]+/', $password))
		{
			// Return true
			return true;
		}
		// Otherwise, return false
		else return false;
	}
	// Otherwise, return true
	else return true;
}

/********************************
 * FUNCTION: CHECK VALID DIGITS *
 ********************************/
function check_valid_digits($password)
{
	// If digit checking is enabled
	if (get_setting('pass_policy_digits_required') == 1)
	{
		// If the password contains a digit
		if (preg_match("/[0-9]+/", $password))
		{
			// Return true
			return true;
		}
		// Otherwise, return false
		else return false;
	}
	// Otherwise, return true
	else return true;
}

/**********************************
 * FUNCTION: CHECK VALID SPECIALS *
 **********************************/
function check_valid_specials($password)
{
	// If special checking is enabled
	if (get_setting('pass_policy_special_required') == 1)
	{
		// If the password contains a special
		if (preg_match("/[^A-Za-z0-9]+/", $password))
		{
			// Return true
			return true;
		}
		// Otherwise, return false
		else return false;
	}
	// Otherwise, return true
	else return true;
}

/*************************
 * FUNCTION: GET SETTING *
 *************************/
function get_setting($setting)
{
	// Open the database connection
	$db = new SettingsQuery();
	$array = $db->findByName($setting)->toArray();
	// If the array isn't empty
	if (!empty($array))
	{
		// Set the value to the array value
		$value = $array[0]['Value'];
	}
	else $value = false;

	return $value;
}

/************************
 * FUNCTION: USER EXIST *
 ************************/
function user_exist($user)
{
	// Open the database connection
	$db = new UserLoginQuery();
	$array = $db->findByEmail($user)->toArray();
	// If the array is empty
	if (empty($array))
	{
		$return = false;
	}
	else $return = true;

	return $return;
}

/****************************
 * FUNCTION: VALID USERNAME *
 ****************************/
function valid_username($username)
{
	// If the username is not blank
	if ($username != "")
	{
		// Return true
		return true;
	}
	// Otherwise, return false
	else return false;
}

/************************************
 * FUNCTION: PASSWORD ERROR MESSAGE *
 ************************************/
function password_error_message($error_code)
{
	// Check the error code
	switch($error_code)
	{
		case 100:
			return "The new password entered does not match the confirm password entered.  Please try again.";
		case 101:
			return "The password entered does not adhere to the password policy.  Please try again.";
		default:
			return "There was an error with the password provided.  Please try again.";
	}
}



function try_encrypt($value)
{
	// If the encryption extra is enabled
//	if (encryption_extra())
//	{
//		// Load the extra
//		require_once(realpath(__DIR__ . '/../extras/encryption/index.php'));
//
//		// Encrypt the value
//		$encrypted_value = encrypt($_SESSION['encrypted_pass'], $value);
//
//		// Return the encrypted value
//		return $encrypted_value;
//	}
	// Otherwise return the value
	//else
	return $value;
}

/**********************************
 * FUNCTION: IS VALID RESET TOKEN *
 **********************************/
function get_permissions($role)
{
	// Open the database connection
	$con = Propel::getConnection();
	$sql = "SELECT m.value, m.name, r.name role, r.value role_id FROM `menu` m  CROSS JOIN `roles` r LEFT JOIN `menu_roles` mr ON r.value= mr.role_id WHERE r.value = 1";
	$stmt = $con->prepare($sql);
	if($stmt->execute()) $array = $stmt->fetchAll();

	if (!empty($array))
	{
		return $array;
	}
}

/**********************************
 * FUNCTION: GENERATE MENU USING USER ROLE *
 **********************************/
function generate_menu()
{
	$role = $_SESSION['role_id'];
	// Open the database connection
	$db = new MenuQuery();
	$parents = $db->useMenuRolesQuery()->orderByMenuId()->filterByRoleId($role)->filterByAccess(1)->endUse()->filterByParent(0)->find()->toArray();
	$menu ='';
	foreach ($parents as $k => $v){
		$children = get_children($v['Value']);
		$icon = get_icon($v['Value']);
		$menu .= "<li class='has_sub'>
					<a href='javascript:void(0);' class='waves-effect'><i class='$icon'></i> <span> $v[Name] </span> <span class='menu-arrow'></span> </a>
								";
		if($children) {
			$menu .= '<ul class=\"list-unstyled\">';
			foreach ($children as $k => $v){
				$menu .= "<li><a href='$v[Link].php'>$v[Name]</a></li>";
			}
			$menu .= '</ul>';
		}
		$menu .= "</li>";
	}

	return $menu;
}

/**********************************
 * FUNCTION: GET SUB-MENUS*
 **********************************/

function get_children($parent)
{
	$role = $_SESSION['role_id'];
	// Open the database connection
	$db = new MenuQuery();
	$children = $db->useMenuRolesQuery()->orderByMenuId()->filterByRoleId($role)
		->filterByAccess(1)->endUse()->filterByParent($parent)->find()->toArray();
	return $children;
}

/**********************************
 * FUNCTION: GET PARENT MENU ICON *
 **********************************/
function get_icon($id)
{
	switch ($id){
		case 1:
			$icon = 'ti-eye';
			break;
		case 2:
			$icon = 'ti-settings';
			break;
		case 3:
			$icon = 'ti-menu';
			break;
		case 4:
			$icon = 'ti-credit-card';
			break;
		case 5:
			$icon = 'ti-comment';
			break;
		case 6:
			$icon = 'ti-pulse';
			break;
		default:
			$icon = 'ti-widget';
	}
	return $icon;

}

/*************************************************
 * FUNCTION: CREATE PUSH REGISTER DEFAULT ENTRIES *
 *************************************************/
function initializePushRegister($id, $parish, $isUser){

	$arrayDb = $isUser ? EconnectQuery::create()->select(array('value'))->findByParishId($parish)->toArray(): UserProfileQuery::create()->select(array('value'))->findByParishId($parish)->toArray();
	foreach ($arrayDb as $v){
		$check = $isUser ? PushRegisterQuery::create()->filterByUserId($id)->filterByGroupId($v)->find():
			PushRegisterQuery::create()->filterByUserId($v)->filterByGroupId($id)->find();
		if (!empty($check->toArray()) ){
			$check->delete();
		}
		$data = new PushRegister();
		if($isUser){

			$data->setUserId($id);
			$data->setGroupId($v);
		}else{
			$data->setUserId($v);
			$data->setGroupId($id);
		}
		$data->setEnabled(false);
		$data->save();
	}
}


/*************************************************
 * FUNCTION: SEND PUSH NOTIFICATIONS *
 *************************************************/
function send_push($to,$title,$message){
	$api_key ="AAAAxkNzCco:APA91bGY2teaKjfLbgQCEQFS5rtDjyfQG2YQHNNDqgTrEiQ-8j0Ql9kByD0djwLs6Ma6GWU5FtWZFdCpLhsN2PcOsk7iDsYgqU_8sVTc7hq5E5I8RR1Qdgb9inc6pkcbLLrnV-hDVb2U";
	return push_notify($api_key,$to,$title,"",$message);

}

function send_push_ios($to,$message){
	$cert ="assets/ios/churchlify_dev_cert.pem";
	$count = 0;
	foreach ($to as $user){
		$send = push_notify_ios($cert,$user,$message);
		if ($send) $count++;
	}
	return json_encode(array('total' => sizeof($to), 'success'=>$count));

}

/**************************************
 * FUNCTION: STRING TO KEY VALUE PAIR ARRAY *
 **************************************/

function get_pair_array($settings){
	$temp = explode (',',$settings);
	$pairs= array();
	foreach ($temp as $pair) {
		list ($k,$v) = explode (':',$pair);
		$pairs[$k] = $v;
	}

	return $pairs;
}

/**************************************
 * FUNCTION: Find User Plan *
 **************************************/

function get_user_dashboard($user){
	$my_plan = UserSubscriptionQuery::create()->orderByValue('asc')->filterByStatus(1)->findOneByUserId($_SESSION['uid']);
	$res = new stdClass();
	if($my_plan){
		$plan_quota = json_decode($my_plan->getUserPlan()->getParams());
		$my_usage = json_decode($my_plan->getMileage()) ;
		$res->plan  = $my_plan->getUserPlan()->getName();
		$res->sms  = $plan_quota->sms - $my_usage->sms;
		$res->mms  = $plan_quota->mms - $my_usage->mms;
		$res->push  = $plan_quota->push - $my_usage->push;

	}else{
		$res = json_encode(['sms'=>0,'mms'=>0,'push'=>0, 'plan'=>'No Active Plan']);
	}
	$user_data = ($my_plan) ? json_decode($my_plan->getMileage()) : json_encode(['sms'=>0,'mms'=>0,'push'=>0]);

	return $res ;
}

/**************************************
 * FUNCTION: Find User Plan *
 **************************************/

function get_user_plan($user){
	$my_plan = UserSubscriptionQuery::create()->orderByValue('desc')->filterByStatus(1)->findOneByUserId($user);
	//$my_plan->getUserPlan()->getName();
	return $my_plan ;
}

/**************************************
 * FUNCTION: Get  User Quota Balance*
 **************************************/

function get_user_mileage($user,$opt){
	$my_data = UserSubscriptionQuery::create()->orderByValue('desc')->filterByStatus(1)->findOneByUserId($user);
	$mileage = 0;
	if(!is_null($my_data)){
	$plan_data = UserPlanQuery::create()->findPk($my_data->getPlanId());
	$my_usage = json_decode($my_data->getMileage());
	$plan_quota = json_decode($plan_data->getParams());
	switch($opt){
		case 'sms':
			$mileage = $plan_quota->sms - $my_usage->sms;
			break;
		case 'mms':
			$mileage = $plan_quota->mms - $my_usage->mms;
			break;
		case 'devotions':
			$mileage = $plan_quota->devotions - $my_usage->devotions;
			break;
		case 'events':
			$mileage = $plan_quota->events - $my_usage->events;
			break;
		case 'push':
			$mileage = $plan_quota->push - $my_usage->push;
			break;
		case 'letter':
			$mileage = $plan_quota->letter - $my_usage->letter;
			break;
		default:
			$mileage = 0;
	}
	}
	return $mileage;
}

function update_user_mileage($user,$opt,$count){
	$my_data = UserSubscriptionQuery::create()->orderByValue('desc')->filterByStatus(1)->findOneByUserId($user);
	$my_usage = json_decode($my_data->getMileage());
	switch($opt){
		case 'sms':
			$my_usage->sms = $my_usage->sms + $count;
			break;
		case 'mms':
			$my_usage->mms = $my_usage->mms + $count;
			break;
		case 'devotions':
			$my_usage->devotions = $my_usage->devotions + $count;
			break;
		case 'events':
			$my_usage->events = $my_usage->events + $count;
			break;
		case 'push':
			$my_usage->push = $my_usage->push + $count;
			break;
		case 'letter':
			$my_usage->letter = $my_usage->letter + $count;
			break;
		default:
			break;
	}
	$my_data->setMileage(json_encode($my_usage));

	return $my_data->save();
}

function check_user_mileage($user,$opt,$req){
	$my_data = UserSubscriptionQuery::create()->orderByValue('desc')->filterByStatus(1)->findOneByUserId($user);
	$plan_data = UserPlanQuery::create()->findPk($my_data->getPlanId());
	$my_usage = json_decode($my_data->getMileage());
	$plan_quota = json_decode($plan_data->getParams());
	switch($opt){
		case 'sms':
			$res = (($plan_quota->sms - $my_usage->sms) >= $req) ? true:false;
			break;
		case 'mms':
			$res = (($plan_quota->mms - $my_usage->mms) >= $req) ? true:false;
			break;
		case 'devotions':
			$res = (($plan_quota->devotions - $my_usage->devotions) >= $req) ? true:false;
			break;
		case 'events':
			$res = (($plan_quota->events - $my_usage->events) >= $req) ? true:false;
			break;
		case 'push':
			$res = (($plan_quota->push - $my_usage->push) >= $req) ? true:false;
			break;
		case 'letter':
			$res = (($plan_quota->letter - $my_usage->letter) >= $req) ? true:false;
			break;
		default:
			$res = false;
	}
	return $res;
}


