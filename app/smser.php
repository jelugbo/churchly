<?php
// Get the PHP helper library from twilio.com/docs/php/install
// Include required functions file
require_once(realpath(__DIR__ . '/../api/vendor/autoload.php'));
require_once(realpath(__DIR__ . '/../api/classes/conf/config.php'));
require_once(realpath(__DIR__ . '/assets/functions.php'));
require_once '..\api\vendor\autoload.php'; // Loads the library
//use Twilio\Rest\Client;

//$sid = "AC773338ab5d62998f605a2df6768da416";
//$token = "d34d3dea512e082f17347226b94a43ce";
//$client = new Client($sid, $token);
error_log(print_r($_POST,true),3,'postdata.txt');

if (isset($_POST['post_data']))
{
	$dbs = new UserProfileQuery();
	$sms_from = "4804184020";
	$group_id = $_POST['to'];
	$parish_id = $_SESSION["parish_id"];
	$message = $_POST['message'];
	$is_mms = $_POST['isMMS'];
	$media_url = isset( $_POST['isMMS'])? $_POST['media'] :'';
	//$sms_tos = ($group_id > 0) ?$dbs->usePushRegisterQuery()->filterByParishId(parish_id)->filterByGroupId($group_id)->filterByEnabled(1)->endUse()->select(array('phone'))->find()->toArray(): $dbs->usePushRegisterQuery()->filterByParishId($parish_id)->filterByEnabled(1)->endUse()->select(array('phone'))->find()->toArray();
	$sms_tos = explode(",",$group_id);
	$res = 0;
	foreach ($sms_tos as $sms_to)
	{
		$sender = isset( $_POST['isMMS'])? SendMMS($sms_to,$message,$media_url):SendSMS($sms_to,$message);
		$res++;
	}

	$alert = $res > 0 ? "success" : "info";
	$alert_message = $res > 0 ? $res." message(s) are on their way": "Oops, something went wrong";
}
if (isset($_POST['post_data']))
{
	error_log('inside the loop',3,'postdata.txt');

	$sms_from = "4804184020";
	$smsto = $_POST['to'];
	$message = $_POST['message'];
	//$media_url = $_POST['media'];
	$sms_tos = explode(",", $smsto);
	//error_log($message,3,'postdata.txt')
	$res = 0;
	foreach ($sms_tos as $sms_to)
	{
		$sender = isset( $_POST['isMMS'])? SendMMS($sms_to,$message,$media_url):SendSMS($sms_to,$message);
		$res++;

	}


	$alert = $res > 0 ? "success" : "info";
	$alert_message = $res > 0 ? $res." message(s) are on their way": "Oops, something went wrong";
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

	<title>Churchlify - QuickSend</title>

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
			<h3 class="text-center"> <strong class="text-custom">One Click</strong> SMS / MMS</h3>
		</div>

		<div class="panel-body">
			<form class="form-horizontal m-t-20" action="#" method="post">

				<div class="form-group ">
					<div class="col-xs-12">
						<h5><b>Recipients</b></h5>
						<textarea id="to" name="to" class="form-control" rows="2" placeholder="List of phone numbers separated by comma"></textarea>
					</div>
				</div>
				<div class="form-group ">
					<div class="col-xs-12">
						<h5><b>Message</b></h5>
						<textarea name="message" id="message" class="form-control" maxlength="160" rows="2" placeholder="Message length limited to 160 characters."></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-12">
						<div class="checkbox checkbox-primary">
							<input name="isMMS"  id="isMMS" type="checkbox">
							<label for="isMMS">
								Click here to add a media for MMS
							</label>
						</div>
					</div>
				</div>

				<div class="form-group " style="display: none" id="media_div" name="media_div">
					<div class="col-xs-12">
						<input class="form-control" type="text" placeholder="Enter Media URL" id="media" name="media">
					</div>
				</div>

				<!--						<div class="form-group ">-->
				<!--							<div class="col-xs-12">-->
				<!--								<input class="form-control" type="text" required="" placeholder="Media URL" id="media" name="media">-->
				<!--							</div>-->
				<!--						</div>-->


				<div class="form-group text-center m-t-40">
					<div class="col-xs-12">
						<button class="btn btn-info btn-block text-uppercase waves-effect waves-light" type="submit" name="post_data">
							Send Message
						</button>
					</div>
				</div>

			</form>

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

<script src="assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
<script>
	$('textarea#textarea').maxlength({
		alwaysShow: true
	});
	$('textarea#message').maxlength({
		alwaysShow: true
	});
</script>

<script type="text/javascript">
	$(document).ready(function () {
		$("#isMMS").change(function(){
			var isMMS = $(this).is(':checked');
			if (isMMS) {$("#media_div").show()}else{$("#media_div").hide()};
		});
		$('form').parsley();
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
</body>
</html>