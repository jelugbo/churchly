<?php

require 'vendor/autoload.php';
require_once 'classes/conf/config.php';
$specialPath = getenv('JWT_Token');
//password_hash()
$id ='45ulhum5s9hlb6lk9935cv2fr3';
$db = new SessionsQuery();
$array = $db->findOneById($id);
echo '<pre>'.print_r($array->toArray(),true).'</pre>';
exit;
//$file = fopen("churches_no_fax.csv","r");
$a = 0;
$b = 0;
$state = 'california';
$city = 'sacramento';
$db = new ParishQuery();
//$array = $db->filterByState($state)->findByCity($city)->toArray();
$array = $db->where('parish.value < ?',5)->find()->toArray();
if($array)echo '<pre>'.print_r($array,true).'</pre>';

//while(! feof($file))
//{
//	$b++;
//	$parish = fgetcsv($file);
//	$data = new Parish();
//	$data->setChurchId($parish[0]);
//	$data->setName($parish[1]);
//	$data->setAddress($parish[2]);
//	$data->setCity($parish[3]);
//	$data->setState($parish[4]);
//	$data->setZip($parish[5]);
//	$data->setCountry($parish[6]);
//	$data->setPhone($parish[7]);
//	$data->setEmail($parish[8]);
//	$data->setOverseer($parish[10]);
//
//	$submit =  $data->save();
//	if($submit) $a++;
//	//print_r($parish);
//}
//echo 'Total records id '.$b. ' And inserted record is '.$a;
//fclose($file);
?>