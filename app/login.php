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
$specialPath = getenv('JWT_Token');
// If the login form was posted
if (isset($_POST['post_data'])) {
    $user = $_POST['Email'];
    $pass = $_POST['Password'];

    // If the user is valid
    if (is_valid_user($user, $pass)) {
        // Grant the user access
        grant_access();

        // Redirect to the reports index
        header("Location: index.php");
    } // If the user is not a valid user
    else {
        //  header("Location: index.php");
        $_SESSION["access"] = "denied";
//        $alert = $res ? "success" : "info";
//        $alert_message = $res ? "Information update successful": "Oops, Information not saved";
        $alert = "error";
        $alert_message = "Invalid username or password.";
    }

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
                <h3 class="text-center"> Sign In to <strong class="text-custom">Churchlify</strong> </h3>
            </div>
                <div id="form-message"></div>

            <div class="panel-body">
            <form class="form-horizontal m-t-20" action="" method="post">
                
                <div class="form-group ">
                    <div class="col-xs-12">
                        <input name="Email" class="form-control" type="text" required="" placeholder="Email Address">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <input name="Password" class="form-control" type="password" required="" placeholder="Password">
                    </div>
                </div>

<!--                <div class="form-group ">-->
<!--                    <div class="col-xs-12">-->
<!--                        <div class="checkbox checkbox-primary">-->
<!--                            <input id="checkbox-signup" type="checkbox">-->
<!--                            <label for="checkbox-signup">-->
<!--                                Remember me-->
<!--                            </label>-->
<!--                        </div>-->
<!--                        -->
<!--                    </div>-->
<!--                </div>-->
<!--                -->
                <div class="form-group text-center m-t-40">
                    <div class="col-xs-12">
                        <button name="post_data" class="btn btn-pink btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                    </div>
                </div>

                <div class="form-group m-t-30 m-b-0">
                    <div class="col-sm-12">
                        <a href="recoverpw.php" class="text-dark"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                    </div>
                </div>
            </form> 
            
            </div>   
            </div>                              
                <div class="row">
            	<div class="col-sm-12 text-center">
            		<p>Don't have an account? <a href="signup.php" class="text-primary m-l-5"><b>Sign Up / Claim Church</b></a></p>
                        
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

if (isset($_POST['post_data'])) {
    echo "
            <script type=\"text/javascript\">
           swal(\"Oops\", \"$alert_message\", \"$alert\");
            </script>
        ";
}
?>