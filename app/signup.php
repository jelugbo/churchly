<?php

require_once(realpath(__DIR__ . '/../api/vendor/autoload.php'));
require_once(realpath(__DIR__ . '/../api/classes/conf/config.php'));
require_once(realpath(__DIR__ . '/assets/functions.php'));
require_once(realpath(__DIR__ . '/assets/authenticate.php'));
require_once(realpath(__DIR__ . '/assets/notification.php'));
//use Propel\Runtime\Propel;

// Open the database connection

if ( isset($_POST['stripeToken'])){
	$params = get_settings_array($_POST['settings']);
	$payment = create_subscription($_POST['Email'],$_POST['Password'],$_POST['ParishId'],$_POST['plan'],$_POST['stripeToken'],$params);
	$alert = ( $payment->value > 0) ? "success" :  "danger";
	$alert_message = $payment->msg;
}
$plan_id = isset($_GET["plan"]) ? $_GET["plan"] : 0;
$db_plan = new UserPlanQuery();
$plans = $db_plan->find();
//if (isset($_POST['post_data'])) {
//	// Check the password
//	$error_code = valid_password($_POST['Password'], $_POST['Password2']);
//	// If the password is valid
//	if ($error_code == 1) {
//		$user = create_login_profile($_POST['Email'],$_POST['Password'],$_POST['ParishId'],$_POST['IsAdmin']);
//		$alert = ( $user->value > 0) ? "success" :  "danger";
//		$alert_message = $user->msg;
//	} // Otherewise, an invalid password was specified
//	else {
//		$alert = "danger";
//		$alert_message = password_error_message($error_code);
//	}
//}

?>

	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
		<meta name="author" content="Coderthemes">

		<link rel="shortcut icon" href="assets/images/favicon_1.ico">

		<title>Churchlify - Admin Dashboard</title>

		<!-- Plugins css-->
		<link href="assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" />
		<link href="assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" />
		<link href="assets/plugins/multiselect/css/multi-select.css"  rel="stylesheet" type="text/css" />
		<link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
		<link href="assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />

		<!--Form Wizard-->
		<link rel="stylesheet" type="text/css" href="assets/plugins/jquery.steps/css/jquery.steps.css" />



		<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/core.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/components.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />

		<!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->

		<script src="assets/js/modernizr.min.js"></script>
		<script src="/hellopay/assets/cardjs/js/card-js.js"></script>
	</head>
	<body>

	<div class="account-pages"></div>
	<div class="clearfix"></div>
	<div class="wrapper-page">
		<div class=" card-box">
			<div class="panel-heading">
				<h3 class="text-center"> Sign Up to <strong class="text-custom">Churchlify</strong> </h3>
			</div>
			<div class='col-md-12 p-b-10'>
				<div class='form-control btn btn-info'>
					<span class='pull-left'>Total</span>
					<span class='total'>0.00</span>
				</div>
				<div id="payment-errors" style="text-align: center;color: RED;font-weight: bold;"><?php echo $alert_message?></div>
			</div>
			<div id="form-message"></div>

			<div class="panel-body">
				<form class="form-horizontal m-t-20" action="" method="post" id="payment-form">
					<div>
						<h3>Details</h3>
						<section>

							<div class="form-group ">
								<div class="col-xs-12">
									<input name="Email" class="form-control" type="email" required="" placeholder="Email">
								</div>
							</div>

							<div class="form-group">
								<div class="col-xs-12">
									<input id="Password" name="Password" class="form-control" type="password" required="" placeholder="Password">
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<input name="Password2" class="form-control" type="password" required="" placeholder="Confirm Password">
								</div>
							</div>

							<div class="form-group ">
								<div class="col-xs-12">
									<select required name="plan" id="PlanId" class="selectpicker" data-live-search="true"  data-style="btn-white">
										<option>--Select Plan--</option>
										<?php foreach ($plans as $plan) { ?>
											<option value="<?php echo $plan->getValue();?>" <?php if($plan->getValue() == $plan_id)echo "selected";?>><?php echo $plan->getName().' - $'.$plan->getCost();?></option>
										<?php } ?>
									</select>

								</div>
							</div>

							<div class="form-group ">
								<div class="col-xs-12">
									<label>Select Your Parish</label>
									<select required name="ParishId" id="ParishId"  class="form-control select2"></select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<div class="checkbox checkbox-primary">
										<input required name="Terms" id="checkbox-signup" type="checkbox" checked="checked">
										<label for="checkbox-signup">I accept <a href="#">Terms and Conditions</a></label>
									</div>
								</div>
							</div>
						</section>
						<h3>Payment</h3>
						<section>
							<div class="form-container" id="payDiv">
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
									<input type="text" name="card_type" class="card-type hidden">
									<input type="text" value="publishablekey:pk_test_TE52FJmzlnUFbukuBSzDo1mQ,secretkey:sk_test_rcSCdWedT8NYHnNqXGtX1zfk" id="settings" name="settings" class="hidden">
								</div>
							</div>


						</section>

				</form>

			</div>
		</div>

		<div class="row">
			<div class="col-sm-12 text-center">
				<p>
					Already have account?<a href="login.php" class="text-primary m-l-5"><b>Sign In</b></a>
				</p>
			</div>
		</div>

	</div>

	<script>
		var resizefunc = [];
	</script>

	<!-- jQuery  -->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/detect.js"></script>
	<script src="assets/js/fastclick.js"></script>
	<script src="assets/js/jquery.slimscroll.js"></script>
	<script src="assets/js/jquery.blockUI.js"></script>
	<script src="assets/js/waves.js"></script>
	<script src="assets/js/wow.min.js"></script>
	<script src="assets/js/jquery.nicescroll.js"></script>
	<script src="assets/js/jquery.scrollTo.min.js"></script>


	<script src="assets/js/jquery.core.js"></script>
	<script src="assets/js/jquery.app.js"></script>

	<script src="assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.min.js"></script>
	<script src="assets/plugins/switchery/js/switchery.min.js"></script>
	<script type="text/javascript" src="assets/plugins/multiselect/js/jquery.multi-select.js"></script>
	<script type="text/javascript" src="assets/plugins/jquery-quicksearch/jquery.quicksearch.js"></script>
	<script src="assets/plugins/select2/js/select2.min.js" type="text/javascript"></script>
	<script src="assets/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
	<script src="assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js" type="text/javascript"></script>
	<script src="assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
	<script src="assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>

	<script type="text/javascript" src="assets/plugins/autocomplete/jquery.mockjax.js"></script>
	<script type="text/javascript" src="assets/plugins/autocomplete/jquery.autocomplete.min.js"></script>
	<script type="text/javascript" src="assets/plugins/autocomplete/countries.js"></script>
	<!--		<script type="text/javascript" src="assets/pages/autocomplete.js"></script>-->

	<script type="text/javascript" src="assets/pages/jquery.form-advanced.init.js"></script>



	<script src="assets/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js" type="text/javascript"></script>
	<script src="assets/plugins/autoNumeric/autoNumeric.js" type="text/javascript"></script>

	<!--Form Wizard-->
	<script src="assets/plugins/jquery.steps/js/jquery.steps.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="assets/plugins/jquery-validation/js/jquery.validate.min.js"></script>

	<!--wizard initialization-->
	<script src="assets/pages/jquery.wizard-init.js" type="text/javascript"></script>
	<script src='/hellopay/assets/js/card.js'></script>
	<script src='/hellopay/assets/js/jquery.card.js'></script>
	<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
	<script src="/hellopay/assets/js/stripe.js"></script>

	<script type="text/javascript">

		jQuery(function($) {
			$('.autonumber').autoNumeric('init');
		});
	</script>

	<script>
		$(document).ready(function(){
			var tot = $("select#PlanId option:selected").text().split("-")[1].trim();
			$("span.total").text(tot);
			$("select#PlanId").change(function(){
				var tot = $("select#PlanId option:selected").text().split("-")[1].trim();
				$("span.total").text(tot);
			});
			$("#ParishId").html( "" );
			$.ajax({
				type: "POST",
				url: "assets/fetch_parishes.php",
				data: "ChurchID="+1,
				beforeSend: function () {
					$('#ParishId').html('<img src="loader.gif" alt="" width="24" height="24">');

				},
				success: function(html) {
					$("#ParishId").html( html );
				}

			});
		});
	</script>

	</body>
	</html>

<?php

if (isset($_POST['post_data'])) {
	echo "
            <script type=\"text/javascript\">
            var p = '<div  class=\"alert alert-$alert\">$alert_message</div>' ;
            var a = document.getElementById(\"form-message\");
            a.innerHTML = a.innerHTML+p
            </script>
        ";
}
?>