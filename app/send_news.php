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
if (CSP_ENABLED == "true") {
    // Add the Content-Security-Policy header
    header("Content-Security-Policy: default-src 'self'; script-src 'unsafe-inline'; style-src 'unsafe-inline'");
}

// Session handler is database
if (USE_DATABASE_FOR_SESSIONS == "true") {
    $sh = SessionManager::instance();
}
// Start the session
session_set_cookie_params(0, '/', '', isset($_SERVER["HTTPS"]), true);
session_check();

// Check for session timeout or renegotiation
if (!isset($_SESSION["access"]) || $_SESSION["access"] != "granted") {
    header("Location: login.php");
    exit(0);
}
// If the login form was posted
$balance = get_user_mileage($_SESSION['uid'],'letter');
$my_plan = get_user_plan($_SESSION['uid']);
if (isset($_POST['post_data'])){
    if($balance > 0 && $my_plan->getUserPlan()->getName() !== 'Free'){
        $dbs = new UserProfileQuery();
        $group_id = $_POST['to'];
        $parish_id = $_SESSION["parish_id"];
        $message = $_POST['message'];
        $when= $_POST['when'];
        $job = new JobQueue();
        $job->setLetterId($message);
        $job->setRecipientsId($group_id);
        $job->setScheduledTime($when);
        $job->setStatus("pending");
        $job->setJobType("letter");
        $job->save();
        $job_id = $job->getValue();
        $res = queue_letters($job_id);
        $alert = $res > 0 ? "success" : "info";
        $alert_message = $res > 0 ? $res." Message(s) are on their way": "Oops, something went wrong";
    }else{
        $alert = "info";
        $alert_message =  "Oops, you do not have credit to fulfill this action, Please upgrade your plan ";
    }
}


//
$date =  date('Y-m-d H:i');
$db = new EconnectQuery();
$roles = $db->findByParishId($_SESSION["parish_id"]);
$db2 = new LettersQuery();
$letters = $db2->findByParishId($_SESSION["parish_id"]);
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

        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/core.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/components.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/pages.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css"/>

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
                                <a href="#" id="btn-fullscreen" class="waves-effect waves-light"><i
                                        class="icon-size-fullscreen"></i></a>
                            </li>
                            <li class="dropdown top-menu-item-xs">
                                <a href="" class="dropdown-toggle profile waves-effect waves-light"
                                   data-toggle="dropdown" aria-expanded="true"><img
                                        src="assets/images/users/avatar-1.jpg" alt="user-img" class="img-circle"> </a>
                                <ul class="dropdown-menu">
                                    <li><a href="javascript:void(0)"><i class="ti-user m-r-10 text-custom"></i> Profile</a>
                                    </li>
                                    <!--                                        <li><a href="javascript:void(0)"><i class="ti-settings m-r-10 text-custom"></i> Settings</a></li>-->
                                    <!--                                        <li><a href="javascript:void(0)"><i class="ti-lock m-r-10 text-custom"></i> Lock screen</a></li>-->
                                    <li class="divider"></li>
                                    <li><a href="logout.php"><i class="ti-power-off m-r-10 text-danger"></i> Logout</a>
                                    </li>
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

                            <h4 class="page-title">One Click Newsletter</h4>
                            <ol class="breadcrumb">
                                <li><a href="index.php">Home</a></li>
                                <li class="active">One Click Newsletter</li>
                            </ol>
                        </div>
                    </div>

                    <div class="wrapper-page">
                        <div class=" card-box">
                            <div class="panel-heading">
                                <h3 class="text-center"> <strong class="text-custom">One Click</strong> Newsletter</h3>
                                <h4 class="text-center"> Available Credits: <strong class="text-custom"> <?php echo $balance; ?> Newsletter </strong> units</h4>
                            </div>

                            <div class="panel-body">
                                <form class="form-horizontal m-t-20" action="#" method="post">
                                    <div class="form-group ">
                                        <div class="col-xs-12">
                                            <h5><b>Select Recipients</b></h5>
                                            <select required name="to" id="to" class="selectpicker" data-live-search="true"  data-style="btn-white">
                                                <option value="0">All Members</option>
                                                <?php
                                                foreach ($roles as $role) {
                                                    echo '<option value='.$role->getValue().'>'. $role->getName()."</option>";
                                                }
                                                ?>
                                            </select>

                                        </div>

                                    </div>
                                    <div class="form-group ">
                                        <div class="col-xs-12">
                                            <h5><b>Select Newsletter</b></h5>
                                            <select required name="message" id="message" class="selectpicker" data-live-search="true"  data-style="btn-white">
                                                <!--                                                <option value="0">All Members</option>-->
                                                <?php
                                                foreach ($letters as $letter) {
                                                    echo '<option value='.$letter->getValue().'>'. $letter->getName()."</option>";
                                                }
                                                ?>
                                            </select>

                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <h5><b>Schedule Date</b></h5>
                                            <!--                                            <a href="#" id="scheduled" data-type="datetime" data-pk="1" data-title="Schedule date and time" class="editable">--><?php //echo $date ?><!--</a>-->

                                            <div class='input-group date' id='schedule'>
                                                <input type='text' class="form-control" required name="when"/>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group text-center m-t-40">
                                        <div class="col-xs-12">
                                            <button class="btn btn-info btn-block text-uppercase waves-effect waves-light" type="submit" name="post_data">
                                                Schedule Now
                                            </button>
                                        </div>
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
    <script src="assets/plugins/switchery/js/switchery.min.js"></script>
    <script type="text/javascript" src="assets/plugins/multiselect/js/jquery.multi-select.js"></script>
    <script type="text/javascript" src="assets/plugins/jquery-quicksearch/jquery.quicksearch.js"></script>
    <script src="assets/plugins/select2/js/select2.min.js" type="text/javascript"></script>
    <script src="assets/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>

    <!-- Sweet-Alert  -->
    <script src="assets/plugins/sweetalert/sweetalert.min.js"></script>
    <link href="assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">

    <!-- XEditable Plugin -->
    <script src="assets/plugins/moment/moment.js"></script>
    <script type="text/javascript" src="assets/plugins/x-editable/js/bootstrap-editable.min.js"></script>
    <script type="text/javascript" src="assets/pages/jquery.xeditable.js"></script>
    <script src="assets/plugins/bootstrap-datetimepicker/collapse.js"></script>
    <script src="assets/plugins/bootstrap-datetimepicker/transition.js"></script>

    <script src="assets/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.js"></script>


    <script type="text/javascript">
        $(document).ready(function () {

            $('#schedule').datetimepicker({
                autoclose: true,
                todayBtn: true,
                currentDate: new Date()
            });

            $("#isMMS").change(function(){
                var isMMS = $(this).is(':checked');
                if (isMMS) {$("#media_div").show()}else{$("#media_div").hide()};
            });
            $('form').parsley();
        });
    </script>



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