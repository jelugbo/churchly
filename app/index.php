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
//session_start('churchlify');

//require_once(realpath(__DIR__ . '/helpers/csrf-magic/csrf-magic.php'));
// Check for session timeout or renegotiation
session_check();

// Check if access is authorized
if (!isset($_SESSION["access"]) || $_SESSION["access"] != "granted")
{
    header("Location: login.php");
    exit(0);
}

$user_data = get_user_dashboard($_SESSION['uid']);

//$docmails = ($_SESSION["role_id"] != 5 && $_SESSION["role_id"] != 3) ? get_document_all($_REQUEST['opt']): get_document_by_mda_id($_SESSION["mda_id"],$_REQUEST['opt'],true);

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

        <!--Morris Chart CSS -->
		<link rel="stylesheet" href="assets/plugins/morris/morris.css">

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
                                <li class="dropdown top-menu-item-xs">
                                    <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                                        <i class="icon-bell"></i> <span class="badge badge-xs badge-danger">3</span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-lg">
                                        <li class="notifi-title"><span class="label label-default pull-right">New 3</span>Notification</li>
                                        <li class="list-group slimscroll-noti notification-list">
                                           <!-- list item-->
                                           <a href="javascript:void(0);" class="list-group-item">
                                              <div class="media">
                                                 <div class="pull-left p-r-10">
                                                    <em class="fa fa-diamond noti-primary"></em>
                                                 </div>
                                                 <div class="media-body">
                                                    <h5 class="media-heading">A new order has been placed A new order has been placed</h5>
                                                    <p class="m-0">
                                                        <small>There are new settings available</small>
                                                    </p>
                                                 </div>
                                              </div>
                                           </a>

                                           <!-- list item-->
                                           <a href="javascript:void(0);" class="list-group-item">
                                              <div class="media">
                                                 <div class="pull-left p-r-10">
                                                    <em class="fa fa-cog noti-warning"></em>
                                                 </div>
                                                 <div class="media-body">
                                                    <h5 class="media-heading">New settings</h5>
                                                    <p class="m-0">
                                                        <small>There are new settings available</small>
                                                    </p>
                                                 </div>
                                              </div>
                                           </a>

                                           <!-- list item-->
                                           <a href="javascript:void(0);" class="list-group-item">
                                              <div class="media">
                                                 <div class="pull-left p-r-10">
                                                    <em class="fa fa-bell-o noti-custom"></em>
                                                 </div>
                                                 <div class="media-body">
                                                    <h5 class="media-heading">Updates</h5>
                                                    <p class="m-0">
                                                        <small>There are <span class="text-primary font-600">2</span> new updates available</small>
                                                    </p>
                                                 </div>
                                              </div>
                                           </a>

                                           <!-- list item-->
                                           <a href="javascript:void(0);" class="list-group-item">
                                              <div class="media">
                                                 <div class="pull-left p-r-10">
                                                    <em class="fa fa-user-plus noti-pink"></em>
                                                 </div>
                                                 <div class="media-body">
                                                    <h5 class="media-heading">New user registered</h5>
                                                    <p class="m-0">
                                                        <small>You have 10 unread messages</small>
                                                    </p>
                                                 </div>
                                              </div>
                                           </a>

                                            <!-- list item-->
                                           <a href="javascript:void(0);" class="list-group-item">
                                              <div class="media">
                                                 <div class="pull-left p-r-10">
                                                    <em class="fa fa-diamond noti-primary"></em>
                                                 </div>
                                                 <div class="media-body">
                                                    <h5 class="media-heading">A new order has been placed A new order has been placed</h5>
                                                    <p class="m-0">
                                                        <small>There are new settings available</small>
                                                    </p>
                                                 </div>
                                              </div>
                                           </a>

                                           <!-- list item-->
                                           <a href="javascript:void(0);" class="list-group-item">
                                              <div class="media">
                                                 <div class="pull-left p-r-10">
                                                    <em class="fa fa-cog noti-warning"></em>
                                                 </div>
                                                 <div class="media-body">
                                                    <h5 class="media-heading">New settings</h5>
                                                    <p class="m-0">
                                                        <small>There are new settings available</small>
                                                    </p>
                                                 </div>
                                              </div>
                                           </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="list-group-item text-right">
                                                <small class="font-600">See all notifications</small>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="hidden-xs">
                                    <a href="#" id="btn-fullscreen" class="waves-effect waves-light"><i class="icon-size-fullscreen"></i></a>
                                </li>
<!--                                <li class="hidden-xs">-->
<!--                                    <a href="#" class="right-bar-toggle waves-effect waves-light"><i class="icon-settings"></i></a>-->
<!--                                </li>-->
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
<!--                                <div class="btn-group pull-right m-t-15">-->
<!--                                    <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Settings <span class="m-l-5"><i class="fa fa-cog"></i></span></button>-->
<!--                                    <ul class="dropdown-menu drop-menu-right" role="menu">-->
<!--                                        <li><a href="#">Action</a></li>-->
<!--                                        <li><a href="#">Another action</a></li>-->
<!--                                        <li><a href="#">Something else here</a></li>-->
<!--                                        <li class="divider"></li>-->
<!--                                        <li><a href="#">Separated link</a></li>-->
<!--                                    </ul>-->
<!--                                </div>-->

                                <h4 class="page-title">Dashboard</h4>
                                <p class="text-muted page-title-alt">Welcome to Churchlify admin panel !</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box fadeInDown animated">
                                    <div class="bg-icon bg-icon-primary pull-left">
                                        <i class="md md-wallet-membership text-primary"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b><?php if(isset($user_data->plan))echo $user_data->plan; ?></b></h3>
                                        <p class="text-muted">Subscription Plan</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-pink pull-left">
                                        <i class="md md-sms text-pink"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b class="counter"><?php if(isset($user_data->sms))echo $user_data->sms; ?></b></h3>
                                        <p class="text-muted">SMS Balance</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-info pull-left">
                                        <i class="md md-mms text-info"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b class="counter"><?php if(isset($user_data->mms))echo $user_data->mms; ?></b></h3>
                                        <p class="text-muted">MMS Balance</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-success pull-left">
                                        <i class="md md-notifications-on text-success"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b class="counter"><?php if(isset($user_data->push))echo $user_data->push; ?></b></h3>
                                        <p class="text-muted">Push Notify Balance</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
						
						<div class="row"> 
                                <ul class="nav nav-tabs tabs tabs-top">
                                    <li class="active tab">
                                        <a href="#setup-21" data-toggle="tab" aria-expanded="false"> 
                                            <span class="visible-xs"><i class="fa fa-home"></i></span> 
                                            <span class="hidden-xs">Setup</span> 
                                        </a> 
                                    </li> 
                                    <li class="tab"> 
                                        <a href="#view-21" data-toggle="tab" aria-expanded="false"> 
                                            <span class="visible-xs"><i class="fa fa-user"></i></span> 
                                            <span class="hidden-xs">View</span> 
                                        </a> 
                                    </li> 
                                    <li class="tab"> 
                                        <a href="#payment-21" data-toggle="tab" aria-expanded="true"> 
                                            <span class="visible-xs"><i class="fa fa-envelope-o"></i></span> 
                                            <span class="hidden-xs">Payment</span> 
                                        </a> 
                                    </li> 
                                    <li class="tab"> 
                                        <a href="#push-21" data-toggle="tab" aria-expanded="false"> 
                                            <span class="visible-xs"><i class="fa fa-cog"></i></span> 
                                            <span class="hidden-xs">Push Notification</span> 
                                        </a> 
                                    </li>
                                    <li class="tab"> 
                                        <a href="#social-21" data-toggle="tab" aria-expanded="false"> 
                                            <span class="visible-xs"><i class="fa fa-cog"></i></span> 
                                            <span class="hidden-xs">Social Connect</span> 
                                        </a> 
                                    </li> 
                                    <li class="tab"> 
                                        <a href="#utilities-21" data-toggle="tab" aria-expanded="false"> 
                                            <span class="visible-xs"><i class="fa fa-cog"></i></span> 
                                            <span class="hidden-xs">Utilities</span> 
                                        </a> 
                                    </li> 									
                                </ul> 
                                <div class="tab-content"> 
                                    <div class="tab-pane active" id="setup-21"> 
                                        <p>In order to get started, you need to set up your church information for use on the churchlify mobile App. The set up has six modules to help you get started.</p> 
                                        
						<div class="row">
							<div class="col-lg-4">
								<div class="panel panel-color panel-success">
									<div class="panel-heading">
										<h3 class="panel-title">1. Church Profile</h3>
									</div>
									<div class="panel-body">
										<p>
											You can update basic information about your church using this module. Information such as address, Logo, phone number and church email address.
										</p>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="panel panel-color panel-custom">
									<div class="panel-heading">
										<h3 class="panel-title">2. About Us</h3>
									</div>
									<div class="panel-body">
										<p>
											This section can be used to update what mobile App user sees on the About Us Section. You can put a brief information about the church.
										</p>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="panel panel-color panel-primary">
									<div class="panel-heading">
										<h3 class="panel-title">3. Ministries</h3>
									</div>
									<div class="panel-body">
										<p>
											 If your church provides daily devotions to members, you can enter details about the devotion here by setting the following details:
										</p>
										<ul>
										<li>Devotion Date: Date you want the devotion to be visible (only one devotion can be visible per day)</li>
										<li>Topic: The title of your daily devotion</li>
										<li>Bible Verse: Bible passage to support your daily devotion message</li>
										<li>Media URL: You can add a media (video / audio) to your daily devotion, we currently support (youtube, vimeo, dailymotion and soundcloud)</li>
										<li>Message: Brief message about the daily devotion</li>
										</ul>
									</div>
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-lg-4">
								<div class="panel panel-color panel-danger">
									<div class="panel-heading">
										<h3 class="panel-title">4. Events</h3>
									</div>
									<div class="panel-body">
										<p>
											 The events section allows you to create upcoming events such as service times, bible study times etc. The mobile app user will be able to see the events, add event to their calendar and share them with friends. You will be required to provide the following details:

										</p>
										<ul>
										<li>Event name: Date you want the devotion to be visible (only one devotion can be visible per day)</li>
										<li>Venue: Venue of the event</li>
										<li>Start Date: Date the event will be starting</li>
										<li>End Date: Date the event will be ending</li>
										<li>Start Time: Time the event will be starting</li>
										<li>End Time: Time the event will be ending</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="panel panel-color panel-warning">
									<div class="panel-heading">
										<h3 class="panel-title">5. Daily Devotions</h3>
									</div>
									<div class="panel-body">
										<p>
											 If your church provides daily devotions to members, you can enter details about the devotion here by setting the following details:
										</p>
										<ul>
										<li>Devotion Date: Date you want the devotion to be visible (only one devotion can be visible per day)</li>
										<li>Topic: The title of your daily devotion</li>
										<li>Bible Verse: Bible passage to support your daily devotion message</li>
										<li>Media URL: You can add a media (video / audio) to your daily devotion, we currently support (youtube, vimeo, dailymotion and soundcloud)</li>
										<li>Message: Brief message about the daily devotion</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="panel panel-color panel-pink">
									<div class="panel-heading">
										<h3 class="panel-title">6. Media</h3>
									</div>
									<div class="panel-body">
										<p>
											 In the media section, you can share video and podcast of events such as sermons, worship service etc. for your mobile app users to view / share with friends. You will be required to enter the following details:
										</p>
										<ul>
										<li> Title: A brief title for the media you are sharing</li>
										<li> Category: Specifying if the media is a podcast or a video</li>
										<li> Type: You can aselect the type / source of your media, we currently support (youtube, vimeo, dailymotion and soundcloud)</li>
										<li> URL: The URL / Link to the media you are sharing</li>
										</ul>
									</div>
								</div>
							</div>

						</div>
                                    </div> 
                                    <div class="tab-pane" id="view-21">
                                        <p>The view module gives you access to retrieve form request informations such as testimonials, prayer request or a schedule for one on one meeting with the pastor.</p> 
                                        
                                    </div> 
                                    <div class="tab-pane" id="payment-21">
                                        <p>The payment module gives you access to donation informations. Setting up your payment gateway details is also done here, Churchlify payment module currently supports both Stripe and PayPal payment gateways</p> 
                                    </div> 
                                    <div class="tab-pane" id="push-21">
                                        <p>The push notification module allows you to send notifications to all your members using the mobile app. You can also create groups for members to join. Sending push notifications can be targeted at groups or all members using the mobile app</p>

                                    </div> 
									<div class="tab-pane" id="social-21">
                                        <p>The social connect allow you to set up credentials for both facebook page and twitter handle, all you need to put is your twitter handle or facebook page ID and your members can read post on your twitter handle/ facebook page</p> 
                                    </div> 
									<div class="tab-pane" id="utilities-21">
                                        <p>The utilities module give you access to a variety of tools such as tools to add a new member, send newsletter to existing members, send SMS/MMS to existing members and create newsletter / welcome letter.</p> 
                                    </div> 
                                </div> 
                            </div> 
                        <!-- end row -->



                        </div>
                        <!-- end row -->


                    </div> <!-- container -->

                </div> <!-- content -->

                <footer class="footer text-right">
                    © 2016. All rights reserved.
                </footer>

            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


            <!-- Right Sidebar -->
            <div class="side-bar right-bar nicescroll">
                <h4 class="text-center">Chat</h4>
                <div class="contact-list nicescroll">
                    <ul class="list-group contacts-list">
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="assets/images/users/avatar-1.jpg" alt="">
                                </div>
                                <span class="name">Chadengle</span>
                                <i class="fa fa-circle online"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="assets/images/users/avatar-2.jpg" alt="">
                                </div>
                                <span class="name">Tomaslau</span>
                                <i class="fa fa-circle online"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="assets/images/users/avatar-3.jpg" alt="">
                                </div>
                                <span class="name">Stillnotdavid</span>
                                <i class="fa fa-circle online"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="assets/images/users/avatar-4.jpg" alt="">
                                </div>
                                <span class="name">Kurafire</span>
                                <i class="fa fa-circle online"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="assets/images/users/avatar-5.jpg" alt="">
                                </div>
                                <span class="name">Shahedk</span>
                                <i class="fa fa-circle away"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="assets/images/users/avatar-6.jpg" alt="">
                                </div>
                                <span class="name">Adhamdannaway</span>
                                <i class="fa fa-circle away"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="assets/images/users/avatar-7.jpg" alt="">
                                </div>
                                <span class="name">Ok</span>
                                <i class="fa fa-circle away"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="assets/images/users/avatar-8.jpg" alt="">
                                </div>
                                <span class="name">Arashasghari</span>
                                <i class="fa fa-circle offline"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="assets/images/users/avatar-9.jpg" alt="">
                                </div>
                                <span class="name">Joshaustin</span>
                                <i class="fa fa-circle offline"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="assets/images/users/avatar-10.jpg" alt="">
                                </div>
                                <span class="name">Sortino</span>
                                <i class="fa fa-circle offline"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /Right-bar -->

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

        <script src="assets/plugins/peity/jquery.peity.min.js"></script>

        <!-- jQuery  -->
        <script src="assets/plugins/waypoints/lib/jquery.waypoints.js"></script>
        <script src="assets/plugins/counterup/jquery.counterup.min.js"></script>



        <script src="assets/plugins/morris/morris.min.js"></script>
        <script src="assets/plugins/raphael/raphael-min.js"></script>

        <script src="assets/plugins/jquery-knob/jquery.knob.js"></script>

        <script src="assets/pages/jquery.dashboard.js"></script>

        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>

        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('.counter').counterUp({
                    delay: 100,
                    time: 1200
                });

                $(".knob").knob();

            });
        </script>




    </body>
</html>