<?php
/**
 * Created by PhpStorm.
 * User: jelug
 * Date: 8/17/2017
 * Time: 2:20 PM
 */

$a = array(19,16,11,54, 52, 26, 27,9, 51,38,39,35);
findNumber($a, 54);

function findNumber($arr, $k) {
    $count = 0;
    for($i = 0; $i < sizeof($arr); $i++){
        if($arr[$i] === $k) $count++;
    }
    echo ($count > 0) ? "Yes":"No";
}

$biggest_drop = 0;

for ($i=0;$i<sizeof($a);$i++){
    for ($j=$i+1;$j<(sizeof($a)-$i);$j++){
        if ($a[$j] <= $a[$i]  ){
            $drop = $a[$i];
            $current_drop = $a[$i] - $a[$j];
            if($biggest_drop < $current_drop){
                $biggest_drop = $current_drop;
            }
        }
    }

}
echo  'Biggest Drop is '. $biggest_drop;