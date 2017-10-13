<?php
/**
 * Created by PhpStorm.
 * User: jelugb1
 * Date: 9/20/2016
 * Time: 12:45 PM
 */
require_once(realpath(__DIR__ . '/../../api/vendor/autoload.php'));
require_once(realpath(__DIR__ . '/../../api/classes/conf/config.php'));
require_once '..\api\vendor\autoload.php'; // Loads the library
use Twilio\Rest\Client;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentCard;
use PayPal\Api\Transaction;
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
	$calls = $client->messages->create(
		$to,
		array(
			'from' => "4804184020",
			'body' => $msg
		)
	);
	return true;
}

/***********************************
 * FUNCTION: SEND MMS TO RECIPIRNT *
 ***********************************/

function sendMMS($to,$msg,$url)
{
	$sid = "AC773338ab5d62998f605a2df6768da416";
	$token = "d34d3dea512e082f17347226b94a43ce";
	$client = new Client($sid, $token);
        $calls = $client->messages->create(
            $to,
            array(
                'from' => "4804184020",
                'body' => $msg,
                'mediaUrl' => $url
            )
        );
	return true;
}

/**************************************
 * FUNCTION: GET LETTER AND RECIPIENT *
 **************************************/

function get_user_letter($user_id,$letter_id){

	$user = UserProfileQuery::create()->findOneByValue($user_id);
	$msg = LettersQuery::create()->findOneByValue($letter_id);

	$variables = array(
		"first_name"=>$user->getFname(),
		"last_name"=>$user->getLname(),
		"phone"=>$user->getPhone(),
		"email"=>$user->getEmail(),
		"birthday"=>$user->getDob(),
		"anniversary"=>$user->getWedding(),
		"address"=>$user->getAddress(),
		"city"=>$user->getCity(),
		"state"=>$user->getState(),
		"zip"=>$user->getZip(),
		"date"=> date("F d Y")
	);
	$string = $msg->getLetter();

	foreach($variables as $key => $value){
		$string = str_replace('{{'.strtoupper($key).'}}', $value,$string );
	}
	$letter = array(
		"from_email" => $msg->getSenderEmail(),
		"from_name" => $msg->getSenderName(),
		"subject" => $msg->getSubject(),
		"to" => $user->getEmail(),
		"letter" => $string
	);

	return $letter;

}
