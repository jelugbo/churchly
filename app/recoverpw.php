<?php
require_once(realpath(__DIR__ . '/assets/functions.php'));
require_once(realpath(__DIR__ . '/assets/authenticate.php'));
require_once(realpath(__DIR__ . '/assets/session_manager.php'));

// Include Zend Escaper for HTML Output Encoding
require_once(realpath(__DIR__ . '/../api/vendor/zendframework/zend-escaper/src/Escaper.php'));
$escaper = new Zend\Escaper\Escaper('utf-8');

// Add various security headers
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");

// If we want to enable the Content Security Policy (CSP) - This may break Chrome
if (CSP_ENABLED == "true") {
	// Add the Content-Security-Policy header
	header("Content-Security-Policy: default-src 'self'; script-src 'unsafe-inline'; style-src 'unsafe-inline'");
}

// Session handler is database
if (USE_DATABASE_FOR_SESSIONS == "true") {
	$sh = SessionManager::instance();
	//session_set_save_handler('open', 'close', 'read', 'write', 'destroy', 'gc');
}

// Start session
session_set_cookie_params(0, '/', '', isset($_SERVER["HTTPS"]), true);

// Default is no alert
$alert = false;
// If the login form was posted
if (isset($_POST['post_data'])) {
	$user = $_POST['User'];
	$token = $_POST['Token'];
	$password= $_POST['Password'];
	$repeat_password = $_POST['Password2'];

	// If a password reset was submitted
	if (password_reset_by_token($user, $token, $password, $repeat_password)) {
		$alert = "success";
		$alert_message = "Your password has been reset successfully.";
	} else {
		$alert = "info";
		$alert_message = "There was a problem with your password reset request.  Please try again.";
	}

}
if (isset($_POST['send_email'])) {
	$user = $_POST['UserReset'];
	// Try to generate a password reset token
	password_reset_by_username($user);
	// Send an alert message
	$alert = "success";
	$alert_message = "If the user exists in the system, then a password reset e-mail should be on its way.";
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
		<link href="assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
		<link href="assets/plugins/bootstrap-sweetalert/sweet-alert.css" rel="stylesheet" type="text/css">
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
					<h3 class="text-center"> Request Reset </h3>
				</div>

				<div class="panel-body">
					<form method="post" action="#" role="form" class="text-center">
						<div class="alert alert-info alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
								×
							</button>
							Enter your <b>Email</b> and instructions will be sent to you!
						</div>
						<div id="form-message"></div>
						<div class="form-group m-b-0">
							<div class="input-group">
								<input name="UserReset" type="email" class="form-control" placeholder="Enter Email" required="">
								<span class="input-group-btn">
									<button  name="send_email" type="submit" class="btn btn-pink w-sm waves-effect waves-light">
										Reset
									</button> 
								</span>
							</div>
						</div>

					</form>
					<div class="clearfix"></div>
					<div class="separator">
						<form method="post" name="password_reset" action="">
							<div class="panel-heading">
								<h3 class="text-center"> Reset Password </h3>
							</div>
							<div class="form-group">
								<input type="email" name="User" class="form-control" placeholder="Username" required/>
							</div>
							<div class="form-group">
								<input type="text" name="Token" class="form-control" placeholder="Token" required/>
							</div>
							<div class="form-group">
								<input type="password" name="Password" class="form-control" placeholder="New Password"
								       required/>
							</div>
							<div class="form-group">
								<input type="password" name="Password2" class="form-control"
								       placeholder="Repeat Password" required/>
							</div>
							<div class="form-group text-center m-t-40">
								<button type="submit" name="post_data" class="btn btn-default submit">Submit
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
		<!-- Sweet-Alert  -->
		<script src="assets/plugins/sweetalert/sweetalert.min.js"></script>
		<link href="assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
	</body>
</html>
<?php
if (isset($_POST['post_data']) || isset($_POST['send_email'])) {
	echo "
            <script type=\"text/javascript\">
           swal(\"$alert\", \"$alert_message\", \"$alert\");
            </script>
        ";
}
?>