<?php
/**
 * Created by PhpStorm.
 * User: jelug
 * Date: 10/10/2017
 * Time: 7:30 AM
 * Process Letter:
-Triggered by cron
- Get the next 10 letters that is new
iterate letters{
- update job status to pending
- send custom email [remember to add ToName, Count, LastStatusMessage]
- update letter->setStatus count last_status_msg
- check if job has no new letter and update status to completed
}

 */
require_once(realpath(__DIR__ . '/mail.php'));
require_once(realpath(__DIR__ . '/functions.php'));
require_once(realpath(__DIR__ . '/../../api/vendor/autoload.php'));
require_once(realpath(__DIR__ . '/../../api/classes/conf/config.php'));

$letters = LetterQueueQuery::create()->filterByStatus('new')->orderByValue('asc')->limit(500)->find();
$job_ids = array();
foreach ($letters as $letter){
    if(!in_array($letter->getJobId(),$job_ids))array_push($job_ids,$letter->getJobId());
    $sender = send_custom_email($letter->toArray());
    $status = ($sender->status) ? 'completed':'failed';
    $letter->setCount($letter->getCount() + 1);
    $letter->setLastStatusMsg($sender->status_msg);
    $letter->setStatus($status);
    $letter->save();
}

foreach($job_ids as $job_id){
    $pending_letter = LetterQueueQuery::create()->filterByStatus('new')->findByJobId($job_id);
    $failed_letter = LetterQueueQuery::create()->filterByStatus('failed')->findByJobId($job_id);
    if(is_null($pending_letter) && is_null($failed_letter)) update_job_status($job_id,'completed');
}

function update_job_status($id, $status){
    $job = JobQueueQuery::create()->findPk($id);
    $job->setStatus($status);
    $job->save();
}