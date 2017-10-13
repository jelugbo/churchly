<?php
/**
 * Created by PhpStorm.
 * User: jelug
 * Date: 6/24/2017
 * Time: 1:55 PM
 */
// Include required functions file
require_once(realpath(__DIR__ . '/../api/vendor/autoload.php'));
require_once(realpath(__DIR__ . '/../api/classes/conf/config.php'));
require_once(realpath(__DIR__ . '/assets/common.php'));
//require_once(realpath(__DIR__ . '/assets/functions.php'));

$alert = false;
$showAlert = false;
$alert_message="";
$parish_id = isset($_GET["p"]) ? $_GET["p"] : 0;
$donor_id = isset($_GET["d"]) ? $_GET["d"]:0 ;
if ((isset($_POST['post_data']) || isset($_POST['stripeToken'])) && ($_POST['method'] > 0))
{
    $method = $_POST['method'];
    $parish = $_POST['parish'];
    $donor = $_POST['donor'];
    $token = isset($_POST['stripeToken']) ? $_POST['stripeToken']: "";
    $a = $_POST['items'];
    $b = $_POST['amount'];
    $total = $_POST['total'];
    $item_data = array();
    foreach($a as $k=>$v){
        $item_data[$k]['item'] = $v;
        $item_data[$k]['amount'] = $b[$k];
    }
    $card_details = array(
        'first_name' => $_POST['last-name'],
        'last_name' => $_POST['first-name'],
        'number' => str_replace(' ','',$_POST['number']),
        'month' => substr($_POST['expiry'],0,2),
        'year' => '20'.substr($_POST['expiry'],-2),
        'cvv' => $_POST['cvc'],
        'type' => $_POST['card_type'],
    );
    $params = get_settings_array($_POST['settings']);
    $res = isset($_POST['stripeToken']) ? doStripe($item_data,$token,$total,$params):doPayPal($item_data,$card_details,$total,$params);
    error_log(print_r($res,true),3,"pay.txt");

    if (isset($res->state) || isset($res->status)){
        log_response($res,$donor,$parish,$method,false);
    }else{
        $failed_card = isset($card_details['number'])? substr($card_details->number,-4) : '0000';
        $fail_response = create_fail_response($total*100,$item_data,$failed_card);
        log_response($fail_response,$donor,$parish,$method,true);
    }
    //$status = (($res->status == "succeeded") || ($res->state == "approved"))? $res->status : $res->state;
    $alert = (($res->status == "succeeded") || ($res->state == "approved")) ? "success" : "info";
    $alert_message = (($res->status == "succeeded") || ($res->state == "approved")) ? "Payment successful": "Oops, payment failed";
}

$db = GiveParishMethodsQuery::create()->filterByEnabled(1)->findOneByParishId($parish_id);
if(is_null($db)){
    $showAlert = true;
    $alert = "error";
    $alert_message = "This Church / Parish do not have payment set up yet, Please contact the church administrator";
}else {

    $settings = $db->getSettings();
    $church = $db->getParish()->getName();
    $logo = (is_null($db->getParish()->getLogo() ) || empty($db->getParish()->getLogo()))?'../app/assets/img/rccglogo2.png':'../app/'.$db->getParish()->getLogo();
    $method = strtolower($db->getGiveMethods()->getName());
    $parish_method_id = $db->getPrimaryKey();
}



?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <link rel="shortcut icon" href="../app/assets/images/favicon_1.ico">

    <title>Churchlify - Admin Dashboard</title>

    <link href="../app/assets/plugins/bootstrap-sweetalert/sweet-alert.css" rel="stylesheet" type="text/css">
    <link href="../app/assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" />
    <link href="../app/assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" />
    <link href="../app/assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="../app/assets/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
    <link href="../app/assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />

    <link href="../app/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="../app/assets/css/core.css" rel="stylesheet" type="text/css"/>
    <link href="../app/assets/css/components.css" rel="stylesheet" type="text/css"/>
    <link href="../app/assets/css/icons.css" rel="stylesheet" type="text/css"/>
    <link href="../app/assets/css/pages.css" rel="stylesheet" type="text/css"/>
    <link href="../app/assets/css/responsive.css" rel="stylesheet" type="text/css"/>
    <link href="../app/assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <!--    <link href="../app/assets/css/style.css" rel="stylesheet" type="text/css"/>-->

    <link href="../app/assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script src="../app/assets/js/modernizr.min.js"></script>
    <script src="assets/cardjs/js/card-js.js"></script>

</head>


<body class="fixed-left">
<div class='col-md-12 p-20'>
    <div class='form-control btn btn-info'>
        <span class='pull-left'>Total</span>
        <span>$</span><span class='total'>0.00</span>
    </div>
    <div>
        <img style="margin: auto; display: block; width: 100px;height: 100px; padding-top: 10px" src="<?php echo $logo; ?>">
        <h3 style="text-align: center"><?php echo $church; ?></h3>
    </div>
    <div id="payment-errors" style="text-align: center;color: RED;font-weight: bold;"><?php echo $alert_message?></div>
</div>
<div class='form-row'>
    <div class=" controls row p-20">
        <form role="form" autocomplete="off"   method="post" action="#" id="payment-form">
            <div id="itemDiv">
                <div class="bigger row">
                    <div class="entry ">
                        <div class="col-xs-12">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <input name="items[]" placeholder="Item" class="form-control items" style="float: left; width: 60%;" title="Prefix" type="text">
                                    <input name="amount[]" placeholder="Amount" class="form-control amount" style="float: left; width: 40%;" type="text">
                                    <span class="input-group-btn">
                            <button class="btn btn-success btn-add" type="button">
                        <span class="glyphicon glyphicon-plus"></span>
                    </button>
                            </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="form-group p-20">
                    <button id="proceed" class="btn btn-block btn-primary waves-effect waves-light" type="button">
                        Proceed to Payment
                    </button>
                </div>
            </div>
            <?php if ($method == 'paypal'){
                echo '
            <div class="form-container"   style="display: none" id="payDiv">
                <div class="card-wrapper"></div>
                <div class="p-20">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input id="column-left" required type="text" name="first-name" placeholder="First Name" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input id="column-right" required type="text" name="last-name" placeholder="Surname" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input id="input-field" required type="text" name="number" placeholder="Card Number" class="card-number form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6">
                            <input id="column-left" required type="text" name="expiry" placeholder="MM / YY" class="card-expiry form-control"/>
                        </div>
                        <div class="col-xs-6">
                            <input id="column-right" required type="text" name="cvc" placeholder="CCV" class="card-cvc form-control"/>
                        </div>
                    </div>
                    <input type="text" value="'.$parish_id.'" name="parish" class="hidden">
                    <input type="text" value="'.$donor_id.'" name="donor" class="hidden">
                    <input type="text" name="card_type" class="card-type hidden">
                    <input type="text" value="'.$parish_method_id.'" name="method" class="hidden">
                    <input type="text" value="'.$settings.'" id="settings" name="settings" class="hidden">
                    <input type="text"  name="total"  id="total" class="hidden">
                </div>
                <div class="form-group text-right p-30">
                    <div class="col-xs-6">
                        <button id="save" name="post_data" class="btn  btn-block btn-primary waves-effect waves-light" type="submit">
                            Pay Now
                        </button>
                    </div>
                    <div class="col-xs-6">
                        <button id="goback" type="reset" class="btn btn-block btn-default waves-effect waves-light m-l-5">
                            Go Back
                        </button>
                    </div>

                </div>
            </div>
            ';
            }else{
                echo '
            <div class="form-container"   style="display: none" id="payDiv">
                <div class="card-wrapper"></div>
                <div class="p-20">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input id="column-left" type="text" name="first-name"  placeholder="First Name" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input id="column-right" type="text" name="last-name"  placeholder="Surname" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input id="input-field" type="text" placeholder="Card Number" class="card-number form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6">
                            <input id="column-left" type="text" placeholder="MM / YY" class="card-expiry form-control"/>
                        </div>
                        <div class="col-xs-6">
                            <input id="column-right" type="text" placeholder="CCV" class="card-cvc form-control"/>
                        </div>
                    </div>
                     <input type="text" value="'.$parish_id.'" name="parish" class="hidden">
                    <input type="text" value="'.$donor_id.'" name="donor" class="hidden">
                    <input type="text" name="card_type" class="card-type hidden">
                    <input type="text" value="'.$parish_method_id.'" name="method" class="hidden">
                    <input type="text" value="'.$settings.'" id="settings" name="settings" class="hidden">
                    <input type="text"  name="total"  id="total" class="hidden">
                </div>
                <div class="form-group text-right p-30">
                    <div class="col-xs-6">
                        <button id="save" name="post_data" class="btn  btn-block btn-primary waves-effect waves-light" type="submit">
                            Pay Now
                        </button>
                    </div>
                    <div class="col-xs-6">
                        <button id="goback" type="reset" class="btn btn-block btn-default waves-effect waves-light m-l-5">
                            Go Back
                        </button>
                    </div>

                </div>
            </div>
            ';
            }
            ?>
        </form>
    </div>



    <!-- jQuery  -->
    <script src="../app/assets/js/jquery.min.js"></script>
    <script src="../app/assets/js/bootstrap.min.js"></script>
    <script src="../app/assets/js/detect.js"></script>
    <script src="../app/assets/js/fastclick.js"></script>
    <script src="../app/assets/js/jquery.slimscroll.js"></script>
    <script src="../app/assets/js/jquery.blockUI.js"></script>
    <script src="../app/assets/js/waves.js"></script>
    <script src="../app/assets/js/wow.min.js"></script>
    <script src="../app/assets/js/jquery.nicescroll.js"></script>
    <script src="../app/assets/js/jquery.scrollTo.min.js"></script>
    <script src="../app/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src='assets/js/card.js'></script>
    <script src='assets/js/jquery.card.js'></script>
    <!-- Sweet-Alert  -->
    <script src="../app/assets/plugins/sweetalert/sweetalert.min.js"></script>
    <link href="../app/assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <?php
    if ($method == 'stripe') {
        echo '
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script src="assets/js/stripe.js"></script>';
    }else{
        echo '<script src="assets/js/payment.js"></script>';
    }
    if (isset($_POST['post_data']) || isset($_POST['stripeToken']) || $showAlert){
        echo "
            <script type=\"text/javascript\">
           swal(\"$alert\", \"$alert_message\", \"$alert\");
            </script>
        ";
    }
    ?>

    <!--    <script src="../app/assets/js/index.js"></script>-->


</body>