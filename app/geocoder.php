<?php
/**
 * Created by PhpStorm.
 * User: jelugb1
 * Date: 11/11/2016
 * Time: 9:46 AM
 */
require '../api/vendor/autoload.php';
require_once '../api/classes/conf/config.php';

$db = ParishQuery::create()->where('Parish.Lat = ?',0)->find();
$array = $db->toArray();
$total = sizeof($array);
$count = 0;
foreach ($array as $obj){
	$fullAddress = $obj['Address'].', '.$obj['City'].', '.$obj['State'].', '.$obj['Zip'].', '.$obj['Country'];
	$data = geocode($fullAddress);
	if($data){
		$parish = ParishQuery::create()->findPk( $obj['Value']);
		$parish->setLat($data[0]);
		$parish->setLng($data[1]);
		$parish->setFormattedAddress($data[2]);
		$parish->save();
        $count++;
	}

}
echo $count . ' of '. $total . ' Addresses successfully updated';
function geocode($address){
	// url encode the address
	$address = urlencode($address);
	// google map geocode api url
	$url = "https://maps.google.com/maps/api/geocode/json?address={$address}";
	$resp_json = file_get_contents($url);
	// decode the json
	$resp = json_decode($resp_json, true);
	// response status will be 'OK', if able to geocode given address
	if($resp['status']=='OK'){

		// get the important data
		$lati = $resp['results'][0]['geometry']['location']['lat'];
		$longi = $resp['results'][0]['geometry']['location']['lng'];
		$formatted_address = $resp['results'][0]['formatted_address'];

		// verify if data is complete
		if($lati && $longi && $formatted_address){

			// put the data in the array
			$data_arr = array();

			array_push(
				$data_arr,
				$lati,
				$longi,
				$formatted_address
			);

			return $data_arr;

		}else{
			return false;
		}

	}else{
		return false;
	}
}