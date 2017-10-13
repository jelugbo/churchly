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
if (!isset($_SESSION["access"]) || $_SESSION["access"] != "granted")
{
	header("Location: login.php");
	exit(0);
}

$has_letter = check_user_mileage($_SESSION['uid'],'letter',1);
$my_plan = get_user_plan($_SESSION['uid']);

if(!$has_letter ){
	$alert = "info";
	$alert_message = "You do not have access to this module, Please upgrade your plan";
	//header('Location: index.php');
}

if (isset($_POST['Letter'])) {
	if($my_plan->getUserPlan()->getName() !== 'Free') {
		$msg = htmlentities(htmlspecialchars($_POST['Letter']));
		$db = new Letters();
		if (($_POST['LetterId'] > 0)) $db = LettersQuery::create()->findPk($_POST['LetterId']);
		$db->setParishId($_SESSION["parish_id"]);
		$db->setTypeId(1);
		$db->setName($_POST['Name']);
		$db->setSenderName($_POST['SenderName']);
		$db->setSenderEmail($_POST['SenderEmail']);
		$db->setSubject($_POST['Subject']);
		$db->setLetter($msg);
		$db->setPublished(1);
		$res = $db->save();

		$alert = $res ? "success" : "info";
		$alert_message = $res ? "Information update successful" : "Oops, Information not saved";
	}else{
		$alert = "info";
		$alert_message =  "Oops, you do not have credit to fulfill this action, Please upgrade your plan ";
	}
}


$letterdb = new LettersQuery();
$letter = $letterdb->filterByTypeId(1)->findOneByParishId($_SESSION["parish_id"]);
$message = ($letter) ? $letter->getLetter():'Hello';
$msg = html_entity_decode(htmlspecialchars_decode($message))

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
		<link href="assets/plugins/summernote/summernote.css" rel="stylesheet" />
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
							<h4 class="page-title">Welcome Letter</h4>
							<ol class="breadcrumb">
								<li><a href="index.php">Home</a></li>
								<li class="active">Welcome Letter</li>
							</ol>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-12">
							<div class="card-box">
								<h4 class="m-t-0 header-title">Welcome Letter</h4>
								<p class="text-muted font-13 m-b-30">
									Please fill in details below to save / update your welcome letter.
								</p>
								<div id="form-message"></div>
								<form class="form-horizontal" action="#" data-parsley-validate novalidate method="post" id="letter-form">
									<div class="form-group" style="display: none">
										<label for="Name" class="col-md-2 control-label">Name*</label>
										<div class="col-md-10">
											<input type="text" name="Name" parsley-trigger="change" value="Welcome Letter"
												   class="form-control" id="Topic">
										</div>
									</div>
									<div class="form-group">
										<label for="SenderName" class="col-md-2 control-label">Sender's Name*</label>
										<div class="col-md-10">
											<input type="text" required name="SenderName" parsley-trigger="change"
												   placeholder="Enter Sender's Name" class="form-control" id="SenderName"
												   value="<?php echo is_null($letter) ? '' : $letter->getSenderName(); ?>" >
										</div>
									</div>
									<div class="form-group">
										<label for="SenderEmail" class="col-md-2 control-label">Sender's Email*</label>
										<div class="col-md-10">
											<input type="text" required name="SenderEmail" parsley-trigger="change"
												   placeholder="Enter Sender's Email Address" class="form-control" id="SenderEmail"
												   value="<?php echo is_null($letter) ? '' : $letter->getSenderEmail(); ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="Subject" class="col-md-2 control-label">Subject*</label>
										<div class="col-md-10">
											<input type="text" required name="Subject" parsley-trigger="change"
												    placeholder="Enter Email Subject" class="form-control" id="Subject"
												   value="<?php echo is_null($letter) ? '' : $letter->getSubject(); ?>">
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<div class="card-box">
												<h4 class="m-b-30 m-t-0 header-title"><b>Letter Editor</b></h4>
												<div class="summernote">
													<?php echo $msg ?>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group" style="display: none">
										<label class="col-md-2 control-label">Letter</label>
										<div class="col-md-10">
											<textarea id="Letter" name="Letter" class="form-control"><?php echo $msg; ?></textarea>
										</div>
									</div>

									<input type="text" name="LetterId" id="LetterId" class="hidden" value="<?php echo is_null($letter) ? 0 : $letter->getValue(); ?>">
									<input type="text" name="TypeId" id="TypeId" class="hidden" value="1">

									<div class="form-group text-right m-b-0">
										<button id="post_data" class="btn btn-primary waves-effect waves-light" type="submit" name="post_data">
											Submit
										</button>
									</div>

								</form>

							</div>
						</div>


								<input type="text" class="hidden" value="<?php echo $_SESSION['parish_id']?>" id="parishId">
								<input type="text" class="hidden" value="<?php echo $_SESSION['token']?>" id="token">


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
	
	<script src="assets/js/jquery.core.js"></script>
	<script src="assets/js/jquery.app.js"></script>
	<script src="assets/pages/jquery.form-pickers.init.js"></script>
	
	
	<script type="text/javascript" src="assets/plugins/parsleyjs/parsley.min.js"></script>
	<script src="assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js" type="text/javascript"></script>
	<!-- Sweet-Alert  -->
	<script src="assets/plugins/bootstrap-sweetalert/sweet-alert.min.js"></script>
	<script src="assets/pages/jquery.sweet-alert.init.js"></script>
	<!--form validation init-->
	<script src="assets/plugins/summernote/summernote.min.js"></script>

	<script>

		$(document).ready(function(){

			// Watch for a form submission:
			$("#letter-form").submit(function(event) {
				console.log("Inside");
				$('#post_data').attr('disabled', 'disabled');
				var f = $("#letter-form");
				var token = $('.summernote').summernote('code');
				f.append('<textarea id="Letter" name="Letter" class="form-control">'+token+'</textarea>');
				f.get(0).submit();
			}); // form submission

			$('.summernote').summernote({
				height: 350,                 // set editor height
				minHeight: null,             // set minimum height of editor
				maxHeight: null,             // set maximum height of editor
				focus: false,                 // set focus to editable area after initializing summernote
				callbacks: {
					onChange: function(){
						$('#Letter').html($('.summernote').summernote('code'));
						console.log("Changing Summer Note");
					}
				}
			});

			function postForm(){
				$('#Letter').html($('.summernote').summernote('code'));
			}
		});
	</script>
	<!-- Sweet-Alert  -->
	<script src="assets/plugins/sweetalert/sweetalert.min.js"></script>
	<link href="assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
	</body>
	</html>

<?php
if (isset($_POST['Letter']) || isset($alert_message)) {
	echo "
            <script type=\"text/javascript\">
            var p = '<div  class=\"alert alert-$alert\">$alert_message</div>' ;
            var a = document.getElementById(\"form-message\");
            a.innerHTML = a.innerHTML+p
            </script>
        ";
	echo "
            <script type=\"text/javascript\">
           swal(\"$alert\", \"$alert_message\", \"$alert\");
            </script>
        ";
}
?>