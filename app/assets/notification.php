<?php
function get_mail_details($id, $opt)
{
    // Open the database connection
    $db = new UserLoginQuery();
    $array = $db->findPk($id)->toArray();
    return $array;
}

function get_receiver($look_up)
{
    $db = new UserLoginQuery();
    $array = $db->where('UserLogin.Value IN ?',$look_up)->find()->toArray();
    return $array;
}

function get_params()
{
    $db = new SettingsQuery();
    $array = $db->where('Settings.Name LIKE ?','notification_%')->find();
    $notification = array();
    // For each entry in the array
    foreach ($array as $value) {
        $notification[$value['name']] = $value['value'];
    }
    return $notification;
}

function send_mails($to,&$sent, $subject, $body){
    require_once(realpath(__DIR__ . '/mail.php'));
    foreach($to as $user){
        if (!in_array($user['Email'], $sent)){
            send_email($user['Email'],$user['Email'], $subject, $body);
            array_push($sent, $user['Email']);
        }

    }
}

function url(){
    return sprintf(
        "%s://%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME'],
        $_SERVER['REQUEST_URI']
    );
}

function mail_notify($id, $type){
    $body = '';
    $item = get_mail_details($id, 'User');
    $to = get_receiver($id);

    $subject = ($type == 'edit')? 'Churchlify - Your User Profile has been Updated ':'Churchlify - New User Profile Created ' ;
    $body .= ($type == 'edit')? 'Hello,<br>Your user profile has been updated,  ':'Hello,<br>A new profile has just been created for you,  ' ;
    $body .= vsprintf("Please find details below:<br><br>
        Login / Email: %s<br>Password: As specified during registration
        <br><br>Regards,<br>-Churchlify", $item);

    $sent = array();
    send_mails($to,$sent, $subject, $body);
}

function push_notify_ios($cert, $to, $message){
    $passphrase = 'S0mething.';
    $ctx = stream_context_create();
    stream_context_set_option($ctx, 'ssl', 'local_cert', $cert); // Pem file to generated // openssl pkcs12 -in pushcert.p12 -out pushcert.pem -nodes -clcerts // .p12 private key generated from Apple Developer Account
    stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
    $fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx); // production
// $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx); // developement
    echo "<p>Connection Open</p>";
    if(!$fp){
        echo "<p>Failed to connect!<br />Error Number: " . $err . " <br />Code: " . $errstr . "</p>";
        return;
    } else {
        echo "<p>Sending notification!</p>";
    }
    $body['aps'] = array('alert' => $message,'sound' => 'default','extra1'=>'10','extra2'=>'value');
    $payload = json_encode($body);
    $msg = chr(0) . pack('n', 32) . pack('H*', $to) . pack('n', strlen($payload)) . $payload;
//var_dump($msg)
    $result = fwrite($fp, $msg, strlen($msg));
    $res = (!$result) ? false : true;
//if (!$result)
//    echo '<p>Message not delivered ' . PHP_EOL . '!</p>';
//else
//    echo '<p>Message successfully delivered ' . PHP_EOL . '!</p>';
    fclose($fp);
    return $res;
}

function push_notify($api_key, $to, $title, $subtitle, $message){
// prep the bundle
    if($subtitle ==""){
        $msg = array
        (
            'body' 	=> $message,
            'title'		=> $title,
            'vibrate'	=> 1,
            'sound'		=> 1
        );
    }else{
        $msg = array
        (
            'body' 	=> $message,
            'title'		=> $title,
//		'subtitle'	=> 'Reference Number: '. $ref_number,
            'subtitle'	=> $subtitle,
            'vibrate'	=> 1,
            'sound'		=> 1
        );
    }

    $fields = array
    (
        'registration_ids' 	=> $to,
        'data'	=> $msg
    );

    $headers = array
    (
        'Authorization: key=' . $api_key,
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
    $result = curl_exec($ch );
    curl_close( $ch );
    return $result;
}

function display_notification()
{
    $notification = get_params();
    //error_log(print_r($notification,true),3,'notification.txt');
    echo "<form name=\"get_risks_by\" method=\"post\" action=\"\" validate>\n";
    echo "<div class='row-fluid'>";
    echo "<div class='col-lg-4'>";
    echo "<header class=\"panel-heading\">When To Notify</header class=\"panel-heading\">";
    echo "<div class=\"checkbox\"><label><input name=\"when_risk_new\" type=\"checkbox\"" . ($notification['notification_when_risk_new'] ? " checked " : "") . "/>Notify on New Risk</label></div>";
    echo "<div class=\"checkbox\"><label><input name=\"when_risk_update\" type=\"checkbox\"" . ($notification['notification_when_risk_update'] ? " checked " : "") . "/>Notify on Risk Update</label></div>";
    echo "<div class=\"checkbox\"><label><input name=\"when_mitigation_new\" type=\"checkbox\"" . ($notification['notification_when_mitigation_new'] ? " checked " : "") . "/>Notify on New Mitigation</label></div>";
    echo "<div class=\"checkbox\"><label><input name=\"when_mitigation_update\" type=\"checkbox\"" . ($notification['notification_when_mitigation_update'] ? " checked " : "") . "/>Notify on Mitigation Update</label></div>";
    echo "<div class=\"checkbox\"><label><input name=\"when_risk_review\" type=\"checkbox\"" . ($notification['notification_when_risk_review'] ? " checked " : "") . "/>Notify on Risk Review</label></div>";
    echo "<div class=\"checkbox\"><label><input name=\"when_risk_close\" type=\"checkbox\"" . ($notification['notification_when_risk_close'] ? " checked " : "") . "/>Notify on Risk Close</label></div>";
    echo "</div>";
    echo "<div class='col-lg-4'>";
    echo "<header class=\"panel-heading\">Who To Notify</header>";
    echo "<div class=\"checkbox\"><label><input name=\"who_submitter\" type=\"checkbox\"" . ($notification['notification_who_submitter'] ? " checked " : "") . " />Notify Submitter</label></div>";
    echo "<div class=\"checkbox\"><label><input name=\"who_owner\" type=\"checkbox\"" . ($notification['notification_who_owner'] ? " checked " : "") . " />Notify Owner</label></div>";
    echo "<div class=\"checkbox\"><label><input name=\"who_manager\" type=\"checkbox\"" . ($notification['notification_who_manager'] ? " checked " : "") . " />Notify Owner's Manager</label></div>";
    echo "<div class=\"checkbox\"><label><input name=\"who_team\" type=\"checkbox\"" . ($notification['notification_who_team'] ? " checked " : "") . " />Notify Department</label></div>";
    echo "</div>";
    echo "<div class='col-lg-4'>";
    echo "<header class=\"panel-heading\">How To Notify</header>";
    echo "<div class=\"checkbox\"><label><input name=\"how_verbose\" type=\"checkbox\"" . ($notification['notification_how_verbose'] ? " checked " : "") . " />verbose Email</label></div>";
    echo "<div class=\"checkbox\"><label><input name=\"how_url\" type=\"text\" class =\"form-control span12\" value='" . $notification['notification_how_url'] . "' placeholder='EasyRisk URL' required/></label></div>";
    echo "<div class=\"checkbox\"><label><input name=\"how_name\" type=\"text\" class =\"form-control span12\" value='" . $notification['notification_how_name'] . "' placeholder='From Name' required/></label></div>";
    echo "<div class=\"checkbox\"><label><input name=\"how_email\" type=\"text\" class =\"form-control span12\" value='" . $notification['notification_how_email'] . "' placeholder='From Email' required/></label></div>";
    echo "</div>";
    echo "</div>";
    echo "<button name=\"submit\" type=\"submit\" class=\"btn btn-primary\">Submit</button>";
    echo "</form>\n";
}

function update_notification_config()
{
    error_log(print_r($_POST, true), 3, 'note.txt');
    $expected_fields = array('when_risk_new', 'when_risk_update', 'when_mitigation_new', 'when_mitigation_update', 'when_risk_review',
        'when_risk_close', 'who_submitter', 'who_owner', 'who_manager', 'who_team', 'how_verbose', 'how_url', 'how_name', 'how_email');
    // Open the database connection
    $db = db_open();
    foreach ($expected_fields as $key => $value) {
        $db_value = array_key_exists($value, $_POST) ? ($_POST[$value] === 'on' ? 1 : $_POST[$value]) : 0;
        $stmt = $db->prepare("UPDATE `settings` SET value=:value WHERE name='notification_$value'");
        $stmt->bindParam(":value", $db_value, PDO::PARAM_STR, 200);
        $stmt->execute();
    }


}

//New Review
function notify_new_review($id)
{
    $params = get_params();
    $risk = get_mail_details($id,'review');
    $body = '';
    $body .= vsprintf("Hello,<br>A new management review has just been submitted, Please find details below:<br><br>
        Risk: %s<br>Review: %s<br>Next step: %s<br>Comments: %s<br>Reviewer: %s<br><br>Regards,<br>easyRisk",$risk);
    $subject = 'New Management Review: '.$risk['risk'] ;
    $sent = array();

    if($params['notification_who_submitter'] == true){
        $to = get_receiver($_SESSION['uid']);
        send_mails($to,$sent, $subject, $body);
    }
    if($params['notification_who_owner'] == true){

        $to = get_receiver($risk['owner_id']);
        send_mails($to,$sent, $subject, $body);
    }
    if($params['notification_who_manager'] == true){
        $to = get_receiver($risk['manager_id']);
        send_mails($to,$sent, $subject, $body);
    }
    if($params['notification_who_team'] == true){
        $to = get_receiver($risk['team_id'], true);
        send_mails($to,$sent, $subject, $body);
    }
}







