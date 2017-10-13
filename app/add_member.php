<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */

// Include required functions file
require_once(realpath(__DIR__ . '/../api/vendor/autoload.php'));
require_once(realpath(__DIR__ . '/../api/classes/conf/config.php'));
require_once(realpath(__DIR__ . '/assets/functions.php'));
require_once(realpath(__DIR__ . '/assets/authenticate.php'));
require_once(realpath(__DIR__ . '/assets/session_manager.php'));
// Include Zend Escaper for HTML Output Encoding
require_once(realpath(__DIR__ . '/../api/vendor/zendframework/zend-escaper/src/Escaper.php'));
$escaper = new Zend\Escaper\Escaper('utf-8');

// Add various security headers
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
$alert = false;
// If we want to enable the Content Security Policy (CSP) - This may break Chrome
if (CSP_ENABLED == "true")
{
	// Add the Content-Security-Policy header
	header("Content-Security-Policy: default-src 'self'; script-src 'unsafe-inline'; style-src 'unsafe-inline'");
}

// Session handler is database
if (USE_DATABASE_FOR_SESSIONS == "true")
{
	$sh = SessionManager::instance();
}
// Start the session
session_set_cookie_params(0, '/', '', isset($_SERVER["HTTPS"]), true);
session_check();

// Check for session timeout or renegotiation
// If the login form was posted

if (!isset($_SESSION["access"]) || $_SESSION["access"] != "granted")
{
	header("Location: login.php");
	exit(0);
}

$db_type = new MediaTypeQuery();
$types = $db_type->orderByValue('DESC')->find();

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
		
		<link href="assets/plugins/bootstrap-sweetalert/sweet-alert.css" rel="stylesheet" type="text/css">
		<link href="assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
		<link href="assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
		<link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
		<link href="assets/plugins/clockpicker/css/bootstrap-clockpicker.min.css" rel="stylesheet">
		<link href="assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
		
		<link href="assets/plugins/jsgrid/css/jsgrid.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/plugins/jsgrid/css/jsgrid-theme.min.css" rel="stylesheet" type="text/css" />
		
		
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
	
	
	<body class="fixed-left">
	
	<!-- Begin page -->
	<div id="wrapper">
		
		<!-- Top Bar Start -->
		<div class="topbar">
			
			<!-- LOGO -->
			<div class="topbar-left">
				<div class="text-center">
					<a href="index.html" class="logo"><i class="icon-magnet icon-c-logo"></i><span>Churchlify</span></a>
					<!-- Image Logo here -->
					<!--<a href="index.html" class="logo">-->
					<!--<i class="icon-c-logo"> <img src="assets/images/logo_sm.png" height="42"/> </i>-->
					<!--<span><img src="assets/images/logo_light.png" height="20"/></span>-->
					<!--</a>-->
				</div>
			</div>
			
			<!-- Button mobile view to collapse sidebar menu -->
			<div class="navbar navbar-default" role="navigation">
				<div class="container">
					<div class="">
						<div class="pull-left">
							<button class="button-menu-mobile open-left waves-effect waves-light">
								<i class="md md-menu"></i>
							</button>
							<span class="clearfix"></span>
						</div>
						
						
						<form role="search" class="navbar-left app-search pull-left hidden-xs">
							<input type="text" placeholder="Search..." class="form-control">
							<a href=""><i class="fa fa-search"></i></a>
						</form>
						
						
						<ul class="nav navbar-nav navbar-right pull-right">
							
							<li class="hidden-xs">
								<a href="#" id="btn-fullscreen" class="waves-effect waves-light"><i class="icon-size-fullscreen"></i></a>
							</li>
							<li class="dropdown top-menu-item-xs">
								<a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true"><img src="assets/images/users/avatar-1.jpg" alt="user-img" class="img-circle"> </a>
								<ul class="dropdown-menu">
									<li><a href="javascript:void(0)"><i class="ti-user m-r-10 text-custom"></i> Profile</a></li>
									<!--                                        <li><a href="javascript:void(0)"><i class="ti-settings m-r-10 text-custom"></i> Settings</a></li>-->
									<!--                                        <li><a href="javascript:void(0)"><i class="ti-lock m-r-10 text-custom"></i> Lock screen</a></li>-->
									<li class="divider"></li>
									<li><a href="logout.php"><i class="ti-power-off m-r-10 text-danger"></i> Logout</a></li>
								</ul>
							</li>
						</ul>
					</div>
					<!--/.nav-collapse -->
				</div>
			</div>
		</div>
		<!-- Top Bar End -->
		
		
		<!-- ========== Left Sidebar Start ========== -->

		<div class="left side-menu">
			<div class="sidebar-inner slimscrollleft">
				<!--- Divider -->
				<div id="sidebar-menu">
					<ul>
						<li class="text-muted menu-title">Dashboard</li>
						<?php echo generate_menu();?>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<!-- Left Sidebar End -->
		
		
		
		<!-- ============================================================== -->
		<!-- Start right Content here -->
		<!-- ============================================================== -->
		<div class="content-page">
			<!-- Start content -->
			<div class="content">
				<div class="container">
					
					<!-- Page-Title -->
					<div class="row">
						<div class="col-sm-12">
							
							<h4 class="page-title">Add Members</h4>
							<ol class="breadcrumb">
								<li><a href="index.php">Home</a></li>
								<li class="active">Add Members</li>
							</ol>
						</div>
					</div>
					
					<div class="row">
						<div id="dataForm" style="display: none" class="col-sm-12">
							<div class="card-box">
								<h4 class="m-t-0 header-title">Add New Member</h4>
								<p class="text-muted font-13 m-b-30">
									Please fill in details below to save / update information.
								</p>
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<div class="checkbox checkbox-primary">
											<input name="welcome"  id="welcome" type="checkbox">
											<label for="checkbox2">
												Click here to send welcome letter to this member
											</label>
										</div>
									</div>
								</div>
								<div id="form-message"></div>
								<form class="form-horizontal" action="#" data-parsley-validate novalidate method="post">
									<div class="form-group">
										<label for="Fname" class="col-md-2 control-label">First Name*</label>
										<div class="col-md-10">
											<input type="text" required
												   name="Fname" parsley-trigger="change" placeholder="Enter Member's First Name"
												   class="form-control" id="Fname">
										</div>
									</div>
									<div class="form-group">
										<label for="Lname" class="col-md-2 control-label">Last Name*</label>
										<div class="col-md-10">
											<input type="text" required
												   name="Lname" parsley-trigger="change" placeholder="Enter Member's Last Name"
												   class="form-control" id="Lname">
										</div>
									</div>
									<div class="form-group">
										<label for="Phone" class="col-md-2 control-label">Phone*</label>
										<div class="col-md-10">
											<input type="text" required
												   name="Phone" parsley-trigger="change" placeholder="Enter Phone Number"
												   class="form-control" id="Phone">
										</div>
									</div>
									<div class="form-group">
										<label for="Email" class="col-md-2 control-label">Email*</label>
										<div class="col-md-10">
											<input type="text" id="Email" name="Email" parsley-trigger="change"
												    placeholder="Enter Email Address" class="form-control">
										</div>
									</div>
									<div class="form-group">
										<label for="Dob" class="col-md-2 control-label">Date of Birth*</label>
										<div class="col-md-10">
											<div class="input-group">
												<input type="text" required class="form-control" placeholder="mm/dd/yyyy" id="datepicker-autoclose"  name="Dob">
												<span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
											<div class="checkbox checkbox-primary">
												<input name="Married"  id="Married" type="checkbox">
												<label for="checkbox2">
													Click here if member is married
												</label>
											</div>
										</div>
									</div>
									<div class="form-group" id="married_div" style="display: none">
										<label for="Wedding" class="col-md-2 control-label">Wedding Anniversary*</label>
										<div class="col-md-10">
											<div class="input-group">
												<input type="text" required class="form-control" placeholder="mm/dd/yyyy" id="datepicker" name="Wedding">
												<span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Address</label>
										<div class="col-md-10">
											<textarea id="Address" name="Address" class="form-control"></textarea>
										</div>
									</div>

									<div class="form-group">
										<label for="City" class="col-md-2 control-label">City*</label>
										<div class="col-md-10">
											<input type="text" required
												   name="City" parsley-trigger="change" placeholder="Enter City Name"
												   class="form-control" id="City">
										</div>
									</div>
									<div class="form-group">
										<label for="State" class="col-md-2 control-label">State*</label>
										<div class="col-md-10">
											<input type="text" required id="State" name="State" parsley-trigger="change"
												   placeholder="Enter State" class="form-control">
										</div>
									</div>
									<div class="form-group">
										<label for="Zip" class="col-md-2 control-label">Zip Code*</label>
										<div class="col-md-10">
											<input type="text" required
												   name="Zip" parsley-trigger="change" placeholder="Enter Zip Code"
												   class="form-control" id="Zip">
										</div>
									</div>
									<input type="text" id="MemberId" class="hidden">

									<div class="form-group text-right m-b-0">
										<button id="save" class="btn btn-primary waves-effect waves-light" type="button">
											Submit
										</button>
										<button id="cancel" type="reset" class="btn btn-default waves-effect waves-light m-l-5">
											Cancel
										</button>
									</div>

								</form>

							</div>
						</div>








						<div id="dataGrid" class="col-xs-12">
							<div class="row">
								<div class="col-sm-6">
									<div class="m-b-30">
										<button id="addToTable" class="btn btn-default waves-effect waves-light">Add New Member<i class="fa fa-plus"></i></button>
									</div>
								</div>
							</div>
							<div class="card-box">
								<div id="jsGrid"></div>
								<input type="text" class="hidden" value="<?php echo $_SESSION['parish_id']?>" id="parishId">
								<input type="text" class="hidden" value="<?php echo $_SESSION['uid']?>" id="uid">
								<input type="text" class="hidden" value="<?php echo $_SESSION['token']?>" id="token">
								<div id="dialog" title="Image Full Size View">
									<img id="imagePreview" />
								</div>
							</div>
						</div>
					</div>
				
				
				</div> <!-- container -->
			
			</div> <!-- content -->
			
			<footer class="footer">
				© 2016. All rights reserved.
			</footer>
		
		</div>
		<!-- ============================================================== -->
		<!-- End Right content here -->
		<!-- ============================================================== -->
	
	
	</div>
	<!-- END wrapper -->
	
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
	<script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
	<!-- JSGrid jQuery  -->
	<script src="assets/plugins/moment/moment.js"></script>
	<script src="assets/plugins/timepicker/bootstrap-timepicker.js"></script>
	<script src="assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
	<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
	<script src="assets/plugins/clockpicker/js/bootstrap-clockpicker.min.js"></script>
	<script src="assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
	
	
	<!-- jsgris table js -->
	<script src="assets/plugins/jsgrid/js/jsgrid.min.js"></script>
	<script src="assets/pages/jquery.jsgrid.addmember.init.js"></script>
	
	<script src="assets/js/jquery.core.js"></script>
	<script src="assets/js/jquery.app.js"></script>
	<script src="assets/pages/jquery.form-pickers.init.js"></script>
	
	
	<script type="text/javascript" src="assets/plugins/parsleyjs/parsley.min.js"></script>
	<script src="assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js" type="text/javascript"></script>
	<!-- Sweet-Alert  -->
	<script src="assets/plugins/bootstrap-sweetalert/sweet-alert.min.js"></script>
	<script src="assets/pages/jquery.sweet-alert.init.js"></script>
	<script>
		$(document).ready(function(){
			$("#Married").change(function(){
				var Married = $(this).is(':checked');
				if (Married) {$("#married_div").show()}else{$("#married_div").hide()};
				console.log(Married);

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