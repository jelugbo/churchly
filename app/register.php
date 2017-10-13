<?php

require_once(realpath(__DIR__ . '/../api/vendor/autoload.php'));
require_once(realpath(__DIR__ . '/../api/classes/conf/config.php'));
require_once(realpath(__DIR__ . '/assets/functions.php'));
require_once(realpath(__DIR__ . '/assets/authenticate.php'));
require_once(realpath(__DIR__ . '/assets/notification.php'));
//use Propel\Runtime\Propel;

// Open the database connection

$db2 = new ChurchQuery();
$churches = $db2->find();
if (isset($_POST['post_data'])) {
	// Check the password
	$error_code = valid_password($_POST['Password'], $_POST['Password2']);
	// If the password is valid
	if ($error_code == 1) {
	    $user = create_login_profile($_POST['Email'],$_POST['Password'],$_POST['ParishId'],$_POST['IsAdmin']);
        $alert = ( $user->value > 0) ? "success" :  "danger";
        $alert_message = $user->msg;
	} // Otherewise, an invalid password was specified
	else {
		$alert = "danger";
		$alert_message = password_error_message($error_code);
	}

    // Verify that the user does not exist
//		if (!user_exist($_POST['Email'])) {
//			// Verify that it is a valid username format
//			if (valid_username($_POST['Email'])) {
//				$hash  = generateHash($_POST['Password']);
//				// Create new user
//				$data=array(
//					'Email' => $_POST['Email'],
//					'ParishId' => $_POST['ParishId'],
//					'Password' => $hash,
//					'RoleId' => (isset($_POST['IsAdmin'])) ? 2: 3,
//					'Enabled' => (isset($_POST['IsAdmin'])) ? 0: 1
//				);
//				$insert = call_api('POST','login/new',$data,true);
//				$res = json_decode($insert);
//				if (isset($res->value) && $res->value > 0) {
//					//ToDo: No need sending details, just send welcome Message
//					//mail_notify($res->value , 'user');
//					$alert = "success";
//					$alert_message = "Your user registration was successful.";
//				}else{
//					$alert = "danger";
//					$alert_message = "An error occured while creating user.";
//				}
//			} // Otherwise, an invalid username was specified
//			else {
//				$alert = "danger";
//				$alert_message = "An invalid username was specified.  Please try again with a different username.";
//			}
//		} // Otherwise, the user already exists
//		else {
//			$alert = "danger";
//			$alert_message = "The username already exists.  Please try again with a different username.";
//		}
}

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

	</head>
	<body>

		<div class="account-pages"></div>
		<div class="clearfix"></div>
		<div class="wrapper-page">
			<div class=" card-box">
				<div class="panel-heading">
					<h3 class="text-center"> Sign Up to <strong class="text-custom">Churchlify</strong> </h3>
				</div>
				<div id="form-message"></div>

				<div class="panel-body">
					<form class="form-horizontal m-t-20" action="" method="post">
<!--						<div class="form-group ">-->
<!--							<div class="col-xs-12">-->
<!--								<input name="Fname" class="form-control" type="text" required="" placeholder="First Name">-->
<!--							</div>-->
<!--						</div>-->
<!--						<div class="form-group ">-->
<!--							<div class="col-xs-12">-->
<!--								<input name="Lname" class="form-control" type="text" required="" placeholder="Last Name">-->
<!--							</div>-->
<!--						</div>-->


						<div class="form-group ">
							<div class="col-xs-12">
								<input name="Email" class="form-control" type="email" required="" placeholder="Email">
							</div>
						</div>

<!--						<div class="form-group">-->
<!--							<div class="col-xs-12">-->
<!--							<label>Phone</label>-->
<!--							<input name="Phone" type="text" placeholder="" data-mask="(999) 999-9999" class="form-control">-->
<!--								</div>-->
<!--						</div>-->

						<div class="form-group">
							<div class="col-xs-12">
								<input name="Password" class="form-control" type="password" required="" placeholder="Password">
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12">
								<input name="Password2" class="form-control" type="password" required="" placeholder="Confirm Password">
							</div>
						</div>

						<div class="form-group ">
							<div class="col-xs-12">
								<select required name="ChurchId" id="ChurchId" class="selectpicker" data-live-search="true"  data-style="btn-white">
									<option>--Select Church--</option>
									<?php
									foreach ($churches as $church) {
										echo '<option value='.$church->getValue().'>'. $church->getShortName().' , '.$church->getName()."</option>";
									}
									?>
								</select>

							</div>
						</div>

						<div class="form-group ">
							<div class="col-xs-12">
								<label>Select Parish</label>
								<select required name="ParishId" id="ParishId"  class="form-control select2"></select>
<!--								<select   id="parish" class="selectpicker" data-live-search="true"  data-style="btn-white">	</select>-->
							</div>
						</div>

<!--						<div class="form-group">-->
<!--								<div class="col-xs-12">-->
<!--								<div class="checkbox checkbox-primary">-->
<!--									<input name="IsAdmin" id="checkbox-signup" type="checkbox">-->
<!--									<label for="checkbox-signup">Check here if you are <a href="#">claiming this parish as an administrator</a></label>-->
<!--								</div>-->
<!--							</div>-->
<!--						</div>-->

						<div class="form-group">
							<div class="col-xs-12">
								<div class="checkbox checkbox-primary">
									<input required name="Terms" id="checkbox-signup" type="checkbox" checked="checked">
									<label for="checkbox-signup">I accept <a href="#">Terms and Conditions</a></label>
								</div>
							</div>
						</div>

						<div class="form-group text-center m-t-40">
							<div class="col-xs-12">
								<button name="post_data" class="btn btn-pink btn-block text-uppercase waves-effect waves-light" type="submit">
									Register
								</button>
							</div>
						</div>

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

		<script type="text/javascript">

			jQuery(function($) {
				$('.autonumber').autoNumeric('init');
			});
		</script>
		
		<script>
			$(document).ready(function(){
				$("select#ChurchId").change(function(){

					var church_id = $("select#ChurchId option:selected").attr('value');
					$("#ParishId").html( "" );
					if (church_id.length > 0 ) {
						console.log(church_id);
					$.ajax({
						type: "POST",
						url: "assets/fetch_parishes.php",
						data: "ChurchID="+church_id,
						beforeSend: function () {
							$('#ParishId').html('<img src="loader.gif" alt="" width="24" height="24">');

						},
						success: function(html) {
								$("#ParishId").html( html );
							}

					});

					}

					console.log('done');
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