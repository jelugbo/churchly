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
    
    if (!empty($_POST['ChurchId'])){
        $db = ChurchQuery::create()->findPk($_POST['ChurchId']);
    } else{
        $db = new Church();
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
    $res = $db->save();

    $alert = $res ? "success" : "info";
    $alert_message = $res ? "Information update successful": "Oops, Information not saved";
}
if (!isset($_SESSION["access"]) || $_SESSION["access"] != "granted")
{
    header("Location: login.php");
    exit(0);
}

$obj_church = ChurchQuery::create()->find()->toArray();

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
                            
                            <h4 class="page-title">Parishes</h4>
                            <ol class="breadcrumb">
                                <li><a href="index.php">Home</a></li>
                                <li class="active">Parishes</li>
                            </ol>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="card-box">
                                <div id="jsGrid"></div>
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
    <script src="assets/pages/jquery.jsgrid.parishes.init.js"></script>
    
    <script src="assets/js/jquery.core.js"></script>
    <script src="assets/js/jquery.app.js"></script>
    
    
    <script type="text/javascript" src="assets/plugins/parsleyjs/parsley.min.js"></script>
    <script src="assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js" type="text/javascript"></script>
    <!-- Sweet-Alert  -->
    <script src="assets/plugins/bootstrap-sweetalert/sweet-alert.min.js"></script>
    <script src="assets/pages/jquery.sweet-alert.init.js"></script>

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