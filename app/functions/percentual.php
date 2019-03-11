<?php
/**
* @param $value valor de um campo no vetor
* @param $array vetor do qual $value faz parte
*/
function percent ($value,$array){
  $total = 0;
  foreach ($array as $key => $v) {
    $total += $v;
  }
  $y = $value * 100;
  return ($y/$total);
}
?>
