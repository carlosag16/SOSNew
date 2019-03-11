<?php
    require "../../bootstrap.php";
    session_start();
    foreach($_POST as $key=>$value) {
        var_dump($key,$value);
        if($key == 'giro_tabela') { if($_SESSION[$key] == 'vertical'){$_SESSION[$key] = 'horizontal';} else {$_SESSION[$key] = 'vertical';}
        } else {  if($_SESSION[$key] == 1){$_SESSION[$key] = 0;} else {$_SESSION[$key] = 1;} }
    }

    return header("location:".CAM_ADMIN);
?>