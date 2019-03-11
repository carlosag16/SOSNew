<?php
    /*
    $servername = "localhost";
    $username   = "lucivaldo";
    $password   = "suporte";
    $bdname     = "agd_agenda";

    $conn = mysqli_connect($servername, $username, $password, $bdname);
    */

    define('AGD_SERVIDOR','localhost');
    define('AGD_USUARIO','user_agd');
    define('AGD_SENHA','bCQoZscbJDOQvAMY');
    define('AGD_BDNAME','agd_agenda');
    define('AGD_PREFIX','agd_');    

    //Fecha Conexão com o BD
    function DBClose ($conn) {
        @mysqli_close($conn) or die(mysqli_error($conn));
    }
    //Conecta BD
    function DBConnect() {
        $conn = mysqli_connect(AGD_SERVIDOR,AGD_USUARIO,AGD_SENHA,AGD_BDNAME) or die(mysqli_connect_error());
        $conn->query("
           SET NAMES utf8 
        ");
        mysqli_set_charset($conn,"utf8") or die(mysqli_error());
        return $conn;
    }
    
    //Protege de Injections
    function DBEscape($dados){
        $conn = DBConnect();
        
        if(!is_array($dados)){
            $dados = mysqli_real_escape_string($conn,$dados);
        } else {
            $arr = $dados;
            
            foreach($arr as $key => $value){
                $key   = mysqli_real_escape_string($conn,$key);
                $value = mysqli_real_escape_string($conn,$value);
                
                $dados[$key] = $value;
            }
        }
        
        DBClose($conn);
        
        return $dados;
    }
    
    //Executa Querys
    function DBExecute($query) {
        $conn   = DBConnect();
        $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
        
        DBClose($conn);
        
        return $result;
    }

    //Lê o Banco de Dados
    function DBRead($table, $fields = '*', $params = null){
        $data = array();
        $params = ($params) ? " $params" : null;
        
        $query  = "SELECT $fields FROM $table$params";
        $result = DBExecute($query);
        
        if(is_array($fields)){
            for($k = 0; $k<count($fields);$k++){
                if(mysqli_num_rows($result)){
                    while ($row = mysqli_fetch_assoc($result)){
                        $data[$fields[$k]][] = $row["$fields[$k]"]; 
                }
                    return $data;
                }
            }
            
        } else {
            if(mysqli_num_rows($result)){
                while ($row = mysqli_fetch_assoc($result)){
                    $data[] = $row["$fields"]; 
            }
                return $data;
            }
        }
        
    }
    function DBReadOne($table, $fields, $params){
        
        $read = DBRead($table, $fields, $params);
        return $read[0];
    }
    ?>