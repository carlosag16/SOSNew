<?php
  function array_to_json_canvasJS($array){
    $i=0;
    $dataPoints = array();
    foreach ($array as $key => $value) {
      $dataPoints[$i] = array("y" => $value, "label" => $key);
      $i++;
    }
    return $dataPoints;
  }
?>
