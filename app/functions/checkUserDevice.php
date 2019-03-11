
<?php
//função para verificar se o dispositivo que o usuário está acessando é mobile ou desktop
function checkUserDevice(){
  $iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
  $ipad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
  $android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
  $palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
  $berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
  $ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
  $WindowsPhone = strpos($_SERVER['HTTP_USER_AGENT'],"Windows Phone");
  $symbian =  strpos($_SERVER['HTTP_USER_AGENT'],"Symbian");
  if ($WindowsPhone || $iphone || $ipad || $android || $palmpre || $ipod || $berry || $symbian == true) {
      return true;
  }
  return false;

}

?>
