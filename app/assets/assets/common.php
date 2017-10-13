<?php
/**
 * Created by PhpStorm.
 * User: jelug
 * Date: 6/24/2017
 * Time: 1:56 PM
 */
require_once(realpath(__DIR__ . '/../../api/vendor/autoload.php'));
require_once(realpath(__DIR__ . '/../../api/classes/conf/config.php'));
//require_once '..\..\api\vendor\autoload.php'; // Loads the library
require_once(realpath(__DIR__ . '/../../app/assets/mail.php'));
use PayPal\Api\Amount;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentCard;
use PayPal\Api\Transaction;
use Stripe\Stripe;

/**********************************
 * FUNCTION: LOG DONATION RESPONSE *
 **********************************/

function log_response($res,$donor,$parish,$method){
    $currency = ($method > 1) ? $res->currency : $res->transactions[0]->amount->currency;
    $desc = ($method > 1) ? $res->description : $res->transactions[0]->description;
    $card = ($method > 1) ? $res->source->last4 : substr($res->payer->funding_instruments[0]->credit_card->number, -4);
    $amount = ($method > 1) ? ($res->amount / 100) : $res->transactions[0]->amount->total;
    $ref = $res->id;
    $status = ($method > 1) ? $res->status : $res->state;
    $give = new Give();
    $give->setCurrency($currency);
    $give->setProfileId($donor);
    $give->setCardId($card);
    $give->setMethodId($method);
    $give->setParishId($parish);
    $give->setDescription($desc);
    $give->setTotal($amount);
    $give->setTxnRef($ref);
    $give->setTxnStatus($status);
    $give->save();
    $give_id = $give->getValue();

    //Log into give split using the Id and Item data
    $temp = explode ('||',$desc);
    foreach ($temp as $value){
        $data = explode ('::',$value);
        $gives = new GiveSplit();
        $gives->setGiveId($give_id);
        $gives->setItem($data[0]);
        $gives->setAmount($data[1]);
        $gives->save();
    }

    notify_payer($ref,$desc,$amount,$status,$donor,$parish);
}


/**********************************
 * FUNCTION: PAYMENT NOTIFICATION *
 **********************************/
function notify_payer($id,$desc,$total,$state,$donor,$parish){
    $body = '';
    $parish_db = ParishQuery::create()->findPk($parish);
    $user_db = UserProfileQuery::create()->findPk($donor);
    $name = $user_db->getFname().' '.$user_db->getFname();
    $email = $user_db->getEmail();
    $status = (($state == "succeeded") || ($state == "approved")) ? "Failed" : "Successful";
    $subject= $status. ': Your Donation to '.$parish_db->getName();
    $item = array($id,$desc,$total,$status);
    $body .=  'Hello '. $name.',';
    $body .= vsprintf("Please find payment details below:<br><br>
        Payment Reference: %s<br>Description: %s<br>Total: USD %s<br>Status: %s
        <br><br>Regards,<br>-Churchlify", $item);
    send_email($name, $email, $subject, $body);
}


/**************************************
 * FUNCTION: GATEWAY SETTING IN ARRAY *
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

/**************************************
 * FUNCTION: ITEM / ITEM LIST FOR PAYPAL*
 **************************************/
function get_paypal_itemlist($itemdata){
    $items = array();
    foreach($itemdata as $key=>$val){ // Loop though one array
        $item = new Item();
        $item->setName($val['item'])
            ->setDescription($val['item'].'::'.$val['amount'])
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($val['amount']);
        array_push($items,$item);
    }
    $itemList = new ItemList();
    $itemList->setItems($items);
    return $itemList;
}

/**********************************
 * FUNCTION: PAYPAL PAYER OBJECT  *
 **********************************/
function get_paypal_payer($card){
    $cards = new PaymentCard();
    $cards->setType($card['type'])
        ->setBillingCountry('US')
        ->setNumber($card['number'])
        ->setExpireMonth($card['month'])
        ->setExpireYear($card['year'])
        ->setCvv2($card['cvv'])
        ->setFirstName($card['first_name'])
        ->setLastName($card['last_name']);

    $fi = new FundingInstrument();
    $fi->setPaymentCard($cards);
    $payer = new Payer();
    $payer->setPaymentMethod("credit_card")
        ->setFundingInstruments(array($fi));
    return $payer;
}

/**************************************
 * FUNCTION: PAYPAL TRANSACTION OBJECT *
 **************************************/
function get_papal_txn($total,$itemdata,$itemlist){
    $amount = new Amount();
    $amount->setCurrency("USD")
        ->setTotal($total);
    $description = get_description($itemdata);
    $txn = new Transaction();
    $txn->setAmount($amount)
        ->setItemList($itemlist)
        ->setDescription($description)
        ->setInvoiceNumber(uniqid());
    return $txn;
}

/**************************************
 * FUNCTION: FORMAT PAYMENT DESCRIPTION *
 **************************************/
function get_description($item){
    $description = "";
    foreach($item as $key=>$val){ // Loop though one array
        if ($key > 0) $description .='||';
        $description .= $val['item'].'::'.$val['amount'];
    }
    return $description;
}

/***********************************
 * FUNCTION: CREATE PAYPAL CONTEXT *
 ***********************************/

function createPayPalContext($params){

    $apiContext = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
            $params['clientid'],     // ClientID
            $params['clientsecret']      // ClientSecret
        )
    );
    return $apiContext;
}

/*********************************
 * FUNCTION: CALL PAYPAL PAYMENT *
 *********************************/
function doPayPal($itemdata, $card,$total, $settings){

    $itemList = get_paypal_itemlist($itemdata);
    $txn = get_papal_txn($total, $itemdata, $itemList);
    $payer = get_paypal_payer($card);

    $payment = new Payment();
    $payment ->setIntent("sale")
        ->setPayer($payer)
        ->setTransactions(array($txn));

    $apiContext = createPayPalContext($settings);

    $request = clone $payment;
    $payment->create($apiContext);
//    try {
//        $payment->create($apiContext);
//    } catch (Exception $ex) {
//        ResultPrinter::printError('Create Payment Using Credit Card. If 500 Exception, try creating a new Credit Card using <a href="https://www.paypal-knowledge.com/infocenter/index?page=content&widgetview=true&id=FAQ1413">Step 4, on this link</a>, and using it.', 'Payment', null, $request, $ex);
//        exit(1);
//    }
//    ResultPrinter::printResult('Create Payment Using Credit Card', 'Payment', $payment->getId(), $request, $payment);

    return $payment;

}

/*********************************
 * FUNCTION: CALL STRIPE PAYMENT *
 *********************************/

function doStripe($itemdata, $token,$total, $params){

    try{
        \Stripe\Stripe::setApiKey($params['secretkey']);
        $charge = \Stripe\Charge::create(array(
            "amount" => $total * 100,
            "currency" => "usd",
            "source" => $token,
            "description" => get_description($itemdata)
        ));

        return $charge;

    }catch(\Stripe\Error\Card $e){
        error_log(print_r($e,true),3,"error.txt");
    }
}
