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
if (isset($_POST['post_data']))
{
	
	if (!empty($_POST['ParishId'])){
		$db = ParishQuery::create()->findPk($_POST['ParishId']);
	} else{
		$db = new Parish();
	}
	$db->setChurchId($_POST['ChurchId']);
	$db->setName($_POST['Parish']);
	$db->setAddress($_POST['Address']);
	$db->setCity($_POST['City']);
	$db->setState($_POST['State']);
	$db->setZip($_POST['Zip']);
	//$db->setCountry($_POST['Country']);
	$db->setPhone($_POST['Phone']);
	$db->setEmail($_POST['Email']);
	$db->setLogo($_POST['Logo']);
	$db->setOverseer($_POST['Overseer']);
	$db->save();
	
	$alert = $res ? "success" : "info";
	$alert_message = $res ? "Information update successful": "Oops, Information not saved";
}
if (!isset($_SESSION["access"]) || $_SESSION["access"] != "granted")
{
	header("Location: login.php");
	exit(0);
}

$obj_parish = ParishQuery::create()->findPk($_SESSION['parish_id']);
$obj_about = $obj_parish->getAbouts()->getFirst();
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
		
		<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/core.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/components.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
		
		<link href="assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">

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

							<h4 class="page-title">Church Profile Details</h4>
							<ol class="breadcrumb">
								<li><a href="index.php">Home</a></li>
								<li class="active">Church Profile</li>
							</ol>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4 col-lg-3">
							<div class="profile-detail card-box">
								<div>
									<span id="preview"><img src="<?php echo is_null($obj_parish->getLogo())? 'assets/images/no_image.png' : $obj_parish->getLogo()?>" class="img-circle" alt="profile-image"></span>

									<ul class="list-inline status-list m-t-20">

									</ul>
									<button type="button" id="changeLogo" class="btn btn-primary btn-rounded">Change Logo</button>
									<input type="file" size="45" name="imageFile" id="imageFile" class="hidden" accept="image/*">
									<hr>

									<div class="text-left">
										<p class="text-muted font-13"><strong>Parish Name :</strong> <span class="m-l-15"><?php echo $obj_parish->getName()?></span></p>

										<p class="text-muted font-13"><strong>Phone :</strong><span class="m-l-15"><?php echo $obj_parish->getPhone()?></span></p>

										<p class="text-muted font-13"><strong>Email :</strong> <span class="m-l-15"><?php echo $obj_parish->getEmail()?></span></p>

										<p class="text-muted font-13"><strong>Location :</strong> <span class="m-l-15">USA</span></p>

									</div>
								</div>

							</div>
						</div>
						<div class="col-lg-9 col-md-8">
							<div class="card-box">
								<h4 class="m-t-0 header-title">Church Profile</h4>
								<p class="text-muted font-13 m-b-30">
									Please fill in details below to update your information.
								</p>
								<div id="form-message"></div>
								<form class="form-horizontal" action="#" data-parsley-validate novalidate method="post" enctype="multipart/form-data">
									<div class="form-group">
										<label class="control-label col-md-2">Parish Name*</label>
										<div class="col-md-10">
											<input type="text" value="<?php echo $obj_parish->getName()?>" name="Parish" parsley-trigger="change"  placeholder="Enter Parish name" class="form-control" readonly>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2">Pastor-In-Charge*</label>
										<div class="col-md-10">
											<input type="text" value="<?php echo $obj_parish->getOverseer()?>" name="Overseer" parsley-trigger="change" placeholder="Enter Pastor's name" class="form-control" >
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2">Address*</label>
										<div class="col-md-10">
											<textarea name="Address" required class="form-control"><?php echo  $obj_parish->getAddress() ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2">City*</label>
										<div class="col-md-10">
											<input type="text" value="<?php echo $obj_parish->getCity()?>" name="City" parsley-trigger="change" placeholder="Enter City" class="form-control" >
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2">State*</label>
										<div class="col-md-10">
											<input type="text" value="<?php echo $obj_parish->getState()?>" name="State" parsley-trigger="change" placeholder="Enter State" class="form-control" >
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2">Zip*</label>
										<div class="col-md-10">
											<input type="text" value="<?php echo $obj_parish->getZip()?>" name="Zip" parsley-trigger="change" placeholder="Enter Parish name" class="form-control" >
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2">Phone*</label>
										<div class="col-md-10">
											<input type="text" value="<?php echo $obj_parish->getPhone()?>" name="Phone" parsley-trigger="change" placeholder="Enter Parish name" class="form-control" >
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2">Email*</label>
										<div class="col-md-10">
											<input type="email" value="<?php echo $obj_parish->getEmail()?>" name="Email" parsley-trigger="change" placeholder="Enter Parish name" class="form-control" >
										</div>
									</div>

									<!--												<div class="form-group">-->
									<!--													<label class="col-sm-3 control-label">About Us</label>-->
									<!--													<textarea name="About" required class="form-control">--><?php //echo is_object($obj_about) ? $obj_about->getAbout():'' ?><!--</textarea>-->
									<!--												</div>-->
									<?php if(!is_object($obj_about)){?>
										<input type="text" name="new" class="hidden">
									<?php }?>
									<input type="text" value="<?php echo is_null($obj_parish->getChurchId())? '': $obj_parish->getChurchId()?>" name="ChurchId" class="hidden">
									<input type="text" value="<?php echo is_null($obj_parish->getValue())? '' : $obj_parish->getValue()?>" name="ParishId" class="hidden">
									<input type="text" id="Logo" name="Logo" value="<?php echo $obj_parish->getLogo()?>" class="hidden">
									<div class="form-group text-right m-b-0">
										<button name ="post_data" class="btn btn-primary waves-effect waves-light" type="submit">
											Update
										</button>
										<!--											<button type="reset" class="btn btn-default waves-effect waves-light m-l-5">-->
										<!--												Cancel-->
										<!--											</button>-->
									</div>

								</form>
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


	<script src="assets/js/jquery.core.js"></script>
	<script src="assets/js/jquery.app.js"></script>


	<script type="text/javascript" src="assets/plugins/parsleyjs/parsley.min.js"></script>
	<script src="assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js" type="text/javascript"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$('form').parsley();
		});
		$('#changeLogo').click(function() {
			$('#imageFile').click();
		});
		$(document).ready(function () {
			$('#imageFile').on('change',(function() {
				/*e.preventDefault();*/
				var file_data = $('#imageFile').prop('files')[0];
				var form_data = new FormData();
				form_data.append('file', file_data);
				file_size = file_data.size / 1024;
				if (file_size > 50) {

					alert('The size of this file is larger than 50 KB, please resize and try again');
					return false;
				}
				//console.log(file_data);
				$.ajax({
					url: "upload.php",
					type: "POST",
					data:  form_data,
					contentType: false,
					cache: false,
					processData:false,
					beforeSend : function()
					{
						//$("#preview").fadeOut();
						$("#err").fadeOut();
					},
					success: function(data)
					{
						if(data=='invalid file')
						{
							// invalid file format.
							$("#err").html("Invalid File !").fadeIn();
						}
						else
						{
							// view uploaded file.
							$("#preview").html(data).fadeIn();
							$("#Logo").val($(data).attr("src"));
							console.log($(data).attr("src"));
							//$("#form")[0].reset();
						}
					},
					error: function(e)
					{
						$("#err").html(e).fadeIn();
					}
				});
			}));
		});
	</script>
	
	<!-- Sweet-Alert  -->
	<script src="assets/plugins/sweetalert/sweetalert.min.js"></script>
	<link href="assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
	</body>
	</html>

<?php

if (isset($_POST['post_data'])) {
	echo "
            <script type=\"text/javascript\">
           swal(\"$alert\", \"$alert_message\", \"$alert\");
            </script>
        ";
}
?>