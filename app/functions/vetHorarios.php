
<?php
    require_once("../../bootstrap.php");
    require_once("bdq.php");
    $existe         = false; //Serve para saber se há horários disponíveis.
    $data           = $_POST['calendar']; //Recebe a data que vem da função a qual é ativada pela mudança no datepicker. (scriptAgendamento.js)
    $horarios       = array(); //Recebe todos os horários.
    $linha          = array(); //Recebe todos os agendamentos ativos. Para que os horários não sejam disponibilizados.
    $desabilitar    = false;

    $i = 0; //Serve para adicionar o X no vetor. Esse X serve para não colocar esses horários disponíveis.

    //Leitura ao Banco de Dados dos Horários.
    $horarios = DBRead("hor_horarios","hor_valor");
    //Fim da Leitura

    //Leitura ao Banco de Dados da Agenda. Pra conferir se tem repetido.
    $linha = DBRead("agd_agendamentos","hor_id","WHERE agd_data = \"$data\" AND agd_cancelado = 0");
    //Fim da Leitura

    //Leitura ao Banco de Dados dos horários em que os bibliotecários estão atuando.
    $ser_horarios = array_unique(DBRead("ser_servidores__hor_horarios","hor_id"));
    //Fim da Leitura

    $horariosDesabilitados = DBRead("dd_dias_desabilitados","hor_id","WHERE dd_data = \"$data\"");
    /*Para desabilitar horários, basta receber o dia e a hora. E criar um vetor só com a hora e criar um for para retirar os horário. Similar ao for abaixo.*/

    if($linha != null){
        $ser_horarios = array_diff($ser_horarios,$linha);
    }

    if($horariosDesabilitados != null){
        $ser_horarios = array_diff($ser_horarios,$horariosDesabilitados);
    }

    if(Count($ser_horarios) == 0){
        $desabilitar = true;
    }
    sort($ser_horarios);
    //exit();
    /*
    var_dump($linha);
    echo "<br>";
    var_dump($ser_horarios);
    echo "<br>";
    var_dump($horarios);
    echo "<br>";
    exit();*/

    //Função para pegar horario atual e mostrar apenas os horários posteriores.
    /*for($j = 0; $j<Count($horarios);$j++){
        $hora1 = DateTime::createFromFormat('H:i', $horarios[$j]);
        if($hora1 <=date("H:i"))
        $check_hora[$linha[$j]-1] = "X";
    }*/
    //$hora1 = DateTime::createFromFormat('H:i:s', '12:04:32');

    //Saber se tem horários Disponíveis, se sim, faz mostrar na tela.
    if(!$desabilitar){
      echo ' <div class="">  <label style="margin-left:-20px; margin-top:10px;"> Escolha um dos horários abaixo</label> </div>';
        foreach($ser_horarios as $key=>$value){
                $existe = true;

                echo "<div class = \"timebox\" id=\"timebox".($value)."\" onclick=\"check(".($value).");\">";
                echo $horarios[$value-1];
                echo "</div>";
                echo "<input type=\"radio\" name=\"hour\" value =\"".($value)."\" id =\"hora".($value)."\" style=\" display: none;\" checked>";

                echo "  <script>$(\".timebox\").css(\"background-color\",\"aliceblue\");
                        $(\"#timebox\"+".($value).");
                        </script>";

        }
    }

    //Para restaurar a escolha do horário do usuário
    if(isset($_SESSION['var_hour'])){
        $var_hour = $_SESSION['var_hour'];
        echo "  <input type=\"radio\" name=\"hour\" value =\"".$var_hour."\" id =\"hora".$var_hour."\" style=\" display: none;\" checked>";

        echo "  <script>
                    $(\".timebox\").css(\"background-color\",\"aliceblue\");
                    $(\"#timebox\"+".$var_hour.");
                </script>";
    }

//    echo date("H:i", strtotime($horarios[0]) + 90*60);

//    $nomes = DBRead("agd_agendamentos","agd_nome");

    if(!$existe && !$desabilitar){
        echo "<br> <p>";
        echo "Não há horários disponíveis.";
        echo "</p>";
    }
    if($desabilitar) {
        echo "<br> <p>";
        echo "Este dia foi desabilitado. Por favor, escolha outro.";
        echo "</p>";
    }
    /*foreach($check_hora as $key => $values){
        echo " ".$key;
        echo $values;
    }*/
?>
