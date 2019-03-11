<?php
    include_once("custom.php");
    include_once("caminhos_conf.php");

    session_start();
    session_destroy();
    //redirect('contato');

  echo "<script> window.location.href='".CAM_RAIZ."?page=login' </script>";  
?>