<?php
/**
 * Created by PhpStorm.
 * User: jelugb1
 * Date: 9/23/2016
 * Time: 11:19 AM
 */

require_once(realpath(__DIR__ . '/../../api/vendor/autoload.php'));
require_once(realpath(__DIR__ . '/../../api/classes/conf/config.php'));

$church_id = filter_var($_POST['ChurchID'], FILTER_SANITIZE_NUMBER_INT);
$q = new ParishQuery();
$data =  $q->findByChurchId($church_id);
$html ="<select required id=\"parish\" class=\"form-control select2\">";
//$html ="<select  id=\"parish\" class=\"selectpicker\" data-live-search=\"true\"  data-style=\"btn-white\">";
foreach ($data as $parish) {
	$html .= "<option value =".$parish->getValue().">". $parish->getChurch()->getShortName().' , '.$parish->getName().' , '.$parish->getCity()."</option>";
}
$html .="</select>";
echo $html;
