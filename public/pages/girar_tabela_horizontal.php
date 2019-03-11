<?php 
    function gerar_tabela(array $header,array $columns,$result) {
        echo "<thead style=\"margin-top: 1%;\">";
        for($i=0;$i<Count($header);$i++) {
            if($header[$i] == 'Compareceu') { if($_SESSION['concluidos']==1){echo "<th>Compareceu</th>"; }}
            else {
                echo "<th>{$header[$i]}</th>";
            }            
        }
        echo "</thead>";
        
        
        //$header=array('    ','Matrícula','Nome','E-mail','Telefone','Data','Horário','Servidor','Curso/Programa','Criado','Compareceu');
        
        //$columns=array('agd_id','agd_matricula','agd_nome','agd_email','agd_telefone','agd_data','hor_id','ser_id','agd_curso_programa','agd_criada','agd_nao_compareceu');
        
        echo "<tbody>";
        $ids = ['ser_id' => ['ser_servidores','ser_nome'], 'hor_id' => ['hor_horarios','hor_valor']];
        while($dados = mysqli_fetch_array($result)){
            echo "<tr>";
            for($i=0;$i<Count($columns);$i++) {
                switch($columns[$i]) {

                    case $columns[0]:
                        echo '<td><input type="checkbox" value="'.$dados[$columns[0]].'" name="list_check[]" onclick="change_h2_name('.$dados[$columns[$i]].')" id="'.$dados[$columns[$i]].'"></td>';
                        break;

                    case ((preg_match("/id$/", $columns[$i]) ? true : false) and $columns[$i] != 'agd_id'):
                        echo "<td>".DBReadOne($ids[$columns[$i]][0],$ids[$columns[$i]][1],"WHERE {$columns[$i]} = {$dados[$columns[$i]]}")."</td>";
                        break;

                    case 'agd_data':
                    case 'agd_criada':
                        echo "<td>".date('d/m/Y', strtotime($dados[$columns[$i]]))."</td>";
                        break;

                    case 'agd_nao_compareceu':
                        if($_SESSION['concluidos']==1){ if($dados['agd_nao_compareceu'] == 0){ echo "<td>Sim</td>";} else {echo "<td>Não</td>";}}
                        break;

                    default:
                        echo "<td>{$dados[$columns[$i]]}</td>"; 
                        break;
                }
            }
            echo "</tr>";
        }
    
        echo "</tbody>";
    }
?>