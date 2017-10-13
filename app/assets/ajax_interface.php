<?php
/**
 * Created by PhpStorm.
 * User: jelug
 * Date: 10/6/2017
 * Time: 8:54 PM
 */
require_once(realpath(__DIR__ . '/functions.php'));
require_once(realpath(__DIR__ . '/mail.php'));
    header('Content-Type: application/json');

    $aResult = array();

    if( !isset($_POST['function']) ) { $aResult['error'] = 'No function name!'; }

    if( !isset($_POST['arguments']) ) { $aResult['error'] = 'No function arguments!'; }

    if( !isset($aResult['error']) ) {

        switch($_POST['function']) {
            case 'check_mileage':
                if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 2) ) {
                    $aResult['error'] = 'Error in arguments!';
                }else {
                    $aResult['result'] = check_user_mileage($_POST['arguments'][0],$_POST['arguments'][1], 1);
                }
                break;
            case 'get_mileage':
                if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 2) ) {
                    $aResult['error'] = 'Error in arguments!';
                }else {
                    $aResult['result'] = get_user_mileage($_POST['arguments'][0],$_POST['arguments'][1]);
                }
                break;
            case 'update_mileage':
                if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 2) ) {
                    $aResult['error'] = 'Error in arguments!';
                }else {
                    $aResult['result'] = update_user_mileage($_POST['arguments'][0],$_POST['arguments'][1], 1);
                }
                break;
            case 'welcome':
                if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 3) ) {
                    $aResult['error'] = 'Error in arguments!';
                }else {
                    $aResult['result'] = send_welcome_letter($_POST['arguments'][0],$_POST['arguments'][1], $_POST['arguments'][2]);
                }
                break;
            case 'feedback':
			//send_email($name, $email, $subject, $body)
                if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 4) ) {
                    $aResult['error'] = 'Error in arguments!';
                }else {
					$body = str_replace("\n","<br>",$_POST['arguments'][3]);
                    $aResult['result'] = send_email($_POST['arguments'][0],$_POST['arguments'][1], $_POST['arguments'][2], $body);
                }
                break;
            default:
                $aResult['error'] = 'Function not found '.$_POST['function'].'!';
                break;
        }

    }

    echo json_encode($aResult);

?>