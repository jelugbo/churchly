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
$db = new RolesQuery();
$db2 = new MenuQuery();
$menus = $db2->find();
$roles = $db->find();
// If the login form was posted
if (isset($_POST['post_data']))
{

	//$alert_message =  "Information update successful";
}
if (!isset($_SESSION["access"]) || $_SESSION["access"] != "granted")
{
	header("Location: login.php");
	exit(0);
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

		<link href="assets/plugins/bootstrap-sweetalert/sweet-alert.css" rel="stylesheet" type="text/css">
		<link href="assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" />
		<link href="assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" />
		<link href="assets/plugins/multiselect/css/multi-select.css"  rel="stylesheet" type="text/css" />
		<link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
		<link href="assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />


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
							<h4 class="page-title">Permissions</h4>
							<ol class="breadcrumb">
								<li><a href="index.php">Home</a></li>
								<li class="active">Permissions</li>
							</ol>
						</div>
					</div>
					<div class="row">
						<div class="form-group ">
							<div class="col-xs-4">
								<select required name="RoleId" id="RoleId" class="selectpicker" data-live-search="true"  data-style="btn-white">
									<option value="0">--Select Role--</option>
									<?php
									foreach ($roles as $role) {
										echo '<option value='.$role->getValue().'>'. $role->getName()."</option>";
									}
									?>
								</select>

							</div>
							<div class="col-xs-4 pull-right">
								<div class="m-b-30">
									<button id="update" class="btn btn-default waves-effect waves-light">Update Permissions <i class="fa fa-arrow-circle-up"></i></button>
								</div>

							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<div class="card-box">
								<table id="datatable-buttons" class="table table-striped table-bordered">
									<thead>
									<th style='display: none'>Menu ID</th>
									<th>Menu Name</th>
									<th>Enable Access?</th>
									</thead>
									<tbody id="menu_roles">
									<?php foreach ($menus as $menu){
										echo " <tr>
										<td style='display: none'> <input id='MenuId' type='text' value='".$menu->getValue()."'></td>
										<td>".$menu->getName()."</td>
										<td><input type='checkbox' id='".$menu->getValue()."'></td>
										</tr>";
									}
									?>
									</tbody>
								</table>

								<input type="text" class="hidden" value="<?php echo $_SESSION['parish_id']?>" id="parishId">
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
	<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>


	<!-- jsgris table js -->
	<script src="assets/plugins/jsgrid/js/jsgrid.min.js"></script>
	<script src="assets/pages/jquery.jsgrid.menuroles.init.js"></script>

	<script src="assets/js/jquery.core.js"></script>
	<script src="assets/js/jquery.app.js"></script>


	<script type="text/javascript" src="assets/plugins/parsleyjs/parsley.min.js"></script>
	<script src="assets/plugins/switchery/js/switchery.min.js"></script>
	<script type="text/javascript" src="assets/plugins/multiselect/js/jquery.multi-select.js"></script>
	<script type="text/javascript" src="assets/plugins/jquery-quicksearch/jquery.quicksearch.js"></script>
	<script src="assets/plugins/select2/js/select2.min.js" type="text/javascript"></script>
	<script src="assets/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
	<script src="assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js" type="text/javascript"></script>
	<script src="assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
	<script src="assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>

	<!-- Sweet-Alert  -->
	<script src="assets/plugins/bootstrap-sweetalert/sweet-alert.min.js"></script>
	<script src="assets/pages/jquery.sweet-alert.init.js"></script>
	<script>
		$(document).ready(function(){

			function loadData(role_id){
				if (role_id < 1){
					var chk = $("input[type='checkbox']");
					$.each(chk,function(i,item) {
						$('#' + chk[i].id).prop('checked', false).prop('name', 0);
					});
					return;
				}
				$.ajax({
					type: "GET",
					url: "../api/menuroles/"+role_id,
					data: "RoleId="+role_id,
					success: function(menus) {
						var chk = $("input[type='checkbox']");
						if($.isArray(menus) == false){
							$.each(chk,function(i,item) {
								$('#' + chk[i].id).prop('checked', false).prop('name', 0);
							});
							return;
						}
						$.each(chk,function(i,item) {

							var menu = menus.filter(function(item){ return item.MenuId == chk[i].id});
							(menu.length > 0) ? $('#'+ chk[i].id).prop('checked', menu[0].Access).prop('name', menu[0].Value): $('#'+ chk[i].id).prop('checked', false).prop('name', 0);
					});
			}

		});

		}

		$("#update").click(function(){
			var updated =[];
			var menu_ids =[];
			var role_id = $("select#RoleId option:selected").attr('value');
			console.log(role_id);
			if (role_id < 1)return;
			var count = $("#menu_roles  > tr").length;
			$("#menu_roles  > tr").each(function(i){
				var menu_id = $(this).find("input#MenuId").val();
				var mr_id = $(this).find("input[type='checkbox']").prop('name');
				var access = $(this).find("input[type='checkbox']").is(':checked');
				access = access;
				var item = JSON.parse('{"Value":'+mr_id+',"RoleId":'+role_id+',"MenuId":'+menu_id+',"Access":'+access+'}');
				var method = (mr_id > 0) ? "PUT":"POST"
				var post_url = (mr_id > 0) ? "../api/menurole/"+mr_id : "../api/menurole/new"
				console.log(item);
				$.ajax({
					type: method,
					url: post_url,
					headers: {"authorization":"Bearer "+token},
					data: item
				}).done(function(res) {
					menu_ids.push(menu_id.toString());
					if(res.value > 0) updated[menu_id] = res.value;
				});
				console.log(i);
				if (i+1 === count) {
					loadData(role_id);
					(updated.length < 1 )?  swal("Update Item!", "Nothing was updated", "warning"): swal("Update Item!", "Item successfully updated", "success");

				}

			});

			!updated?  swal("Update Item!", "Nothing was updated", "warning"): swal("Update Item!", "Item successfully updated", "success");


		});

		$("select#RoleId").change(function(){
			var role_id = $("select#RoleId option:selected").attr('value');
			loadData(role_id)
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