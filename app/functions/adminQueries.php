<?php

// pegar o mes atual
$mes_num = array('01','02','03','04','05','06','07','08','09','10','11','12');
$mes_str = array('Janeiro','Feveriero','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
$mes_str_short = array('JAN','FEV','MAR','ABR','MAI','JUN','JUL','AGO','SET','OUT','NOV','DEZ');
$mes = array_combine($mes_num,$mes_str);
$mes_short = array_combine($mes_num, $mes_str_short);
$ano_atual = Date('Y');
$mes_atual = Date('m');
// echo $curr_mes;

// query para pegar quantidade de agendamentos que comapreceram e não compareceram no mês atual
$nao_compareceu = DBReadOne("agd_agendamentos","COUNT(*)", "WHERE agd_concluido = 1 AND agd_nao_compareceu = 1 AND agd_data LIKE '%".$ano_atual."-".$mes_atual."%';");
$compareceu = DBReadOne("agd_agendamentos","COUNT(*)", "WHERE agd_concluido = 1 AND agd_nao_compareceu = 0 AND agd_data LIKE '%".$ano_atual."-".$mes_atual."%';");
$total_comparceu_nao_compareceu = array($nao_compareceu,$compareceu);
$perc_compareceu = percent($compareceu,$total_comparceu_nao_compareceu);
$perc_nao_compareceu = percent($nao_compareceu,$total_comparceu_nao_compareceu);

/**
* Query para pegar quantidade de agendamentos neste mes dos cancelados, realizados e total
*/
$total_agendamentos = DBReadOne("agd_agendamentos","COUNT(*)", "WHERE agd_data LIKE '%".$ano_atual."-".$mes_atual."%';");
$total_agendamentos_cancelados = DBReadOne("agd_agendamentos","COUNT(*)", "WHERE agd_cancelado = 1 AND agd_data LIKE '%".$ano_atual."-".$mes_atual."%';");
$total_agendamentos_realizados = DBReadOne("agd_agendamentos","COUNT(*)", "WHERE agd_cancelado = 0 AND agd_nao_compareceu = 0 AND agd_concluido = 1 AND agd_data LIKE '%".$ano_atual."-".$mes_atual."%';");

/**
* query para pegar quantidade de agendamentos dos ultimos seis meses
*/
$agd_mes_ano = Date('Y-m');
// $lista_mes = array (mes = > quantidade_de_agendamentos)
$lista_mes = array();
for ($i=0; $i < 6; $i++){
  $quantidade_agd = DBReadOne("agd_agendamentos","COUNT(*)", "WHERE agd_data like '%".$agd_mes_ano."%' ;");
  $index_data = (string) date('M Y',strtotime($agd_mes_ano));
  $lista_mes[$index_data] = $quantidade_agd;
  $agd_mes_ano = (string) date('Y-m', strtotime("-1 month",strtotime($agd_mes_ano)));
}

/**
* Query para gerar resultados do percentual de crecimento deste mes com relação ao mês anterior
*/
$agd_mes_ano = Date('Y-m');
$mes_anterior = (string) date('Y-m', strtotime("-1 month",strtotime($agd_mes_ano)));
$qtd_agd_mes_anterior = DBReadOne("agd_agendamentos","COUNT(*)", "WHERE agd_data like '%".$mes_anterior."%' ;");
$qtd_agd_mes_atual = DBReadOne("agd_agendamentos","COUNT(*)", "WHERE agd_data like '%".$agd_mes_ano."%' ;");
$percentual_crescimento = (($qtd_agd_mes_atual - $qtd_agd_mes_anterior)/$qtd_agd_mes_anterior)*100;
$percentual_crescimento = number_format($percentual_crescimento,1);

/**
* Query para pegar quantidade de agendamentos de cada mês desde o primeiro mês do ano atual
*/
$agd_meses = array();
$mesAtual = (int)$mes_atual;
$i=0;
for ($mes_count = 1; $mes_count <= $mesAtual; $mes_count ++) {
	// necessário pois o campo de mes no banco de dados esta no formato com zero na frente da unidade de mes, ex: 01, 02, ...
	$mes_count = $mes_count > 9 ? $mes_count : '0'.$mes_count;
	$agd_meses[$i] = DBReadOne("agd_agendamentos","COUNT(*)", "WHERE agd_data like '%".$ano_atual."-".$mes_count ."%' ;");
	$mes_count = (int)$mes_count ;
  $i++;
}
$media_agd_meses = array_sum($agd_meses)/count($agd_meses);

/**
* Query para principais dúvidass
*/
$prin_duvidas = DBRead("prin_principais_duvidas__agd_agendamentos","prin_id");
$nome_duvida = DBRead("prin_principais_duvidas","prin_duvida");
$id_duvida = DBRead("prin_principais_duvidas","prin_id");
$duvidas = array_combine($id_duvida,$nome_duvida);
$countDuv = array_fill_keys($duvidas, 0); // countDuv[["duvida1"]=>0, ["duvida2"]=>0, ["duvida3"]=>0 ....] inicializando o contador com valor zero, os indices são os ids das duvidas armazenadas no banco de dados

// percorre o $prin_duvidas[] e se o id for igual ao  id do $duvidas, então essa respectiva duvida é incrementada em $countDuv:
// countDuv[["duvida1"]=>3, ["duvida2"]=>2, ["duvida3"]=>4 ....]
for ($i=0; $i < count($prin_duvidas); $i++) {
  if(array_key_exists($prin_duvidas[$i], $duvidas)){
    $countDuv[$duvidas[$prin_duvidas[$i]]] += 1;
  }
}
arsort($countDuv); // ordena em ordem decrescente
$dataPointsDuvidas = array_to_json_canvasJS($countDuv); // convert array associativo para o formato json própio para o CanvasJS


/**
* Query para cursos que mais agendaram
*/
$cursos = Array();
$agd_id_fk = DBRead("prin_principais_duvidas__agd_agendamentos","agd_id"); // ids que tiveram duvidas, um id pode aparecer mais de uma vez aqui
$agd_id_pk = DBRead("agd_agendamentos","agd_id"); // ids dos agendamentos
for ($i=0; $i < count($agd_id_fk); $i++) {
  if(in_array($agd_id_fk[$i],$agd_id_pk)){
    $curso = DBReadOne("agd_agendamentos","agd_curso_programa"," WHERE agd_id = $agd_id_fk[$i]"); // pega o nome do curso na tabela de agendamentos de aacordo com o dado ID
    $cursos[$i]=$curso;
  }
}
$num_duvidas_por_curso = array_count_values($cursos);
uasort($num_duvidas_por_curso, "cmp");
$dataPointsCursos = array_to_json_canvasJS($num_duvidas_por_curso); // convert array associativo para o formato json própio para o CanvasJS

/**
* Query de atendimentos por servidor
*/
$nomes = DBRead('ser_servidores','ser_nome');
// leitura do banco de dados:
$quantidades = DBRead('ser_servidores','ser_contador');
$servidores = array_combine($nomes, $quantidades); // combina os dois vetores colocando o nome como key e a quantidade como value
arsort($servidores); // ordena em ordem decrescente
$dataPointsServidores = array_to_json_canvasJS($servidores); // convert array associativo para o formato json própio para o CanvasJS
?>





<script type="text/javascript">
/*
configurações dos charts
*/
window.onload = function () {
// chart dos graficos de colunas da demanda dos ultimos 6 meses
var chart = new CanvasJS.Chart("agd_mensal",
  {
    animationEnabled: true,
    theme: "dark2", // "light1", "light2", "dark1", "dark2"
    backgroundColor: "transparent",
    title: {
      text: "Demanda dos últimos meses"
    },
    axisX: {
      color:'transparent'
    },
    data: [
      {
        type: "column",
        color: '#fff',
        toolTipContent: "<b>{label}</b>: {y} agendamentos",
        dataPoints: [
          <?php
            foreach ($lista_mes as $mes_ref => $qtd) {
              echo '{ label: "'.$mes_ref.'", y: '.$qtd.' },';
            }
           ?>
        ]
      }
    ]
  }
);
chart.render();

//chart de alunos que compareceram e não compareceram
CanvasJS.addColorSet("whiteShades",
[//colorSet Array
  "#FFF",
  "#FEBA9E"
]);
var chart2 = new CanvasJS.Chart("compareceu_vs_naocompareceu",
  {
    colorSet: "whiteShades",
    animationEnabled: true,
    theme: "dark2", // "light1", "light2", "dark1", "dark2"
    backgroundColor: "transparent",
    title:{
      text: "Resultado dos agendamentos concluídos"
    },
    data: [
      {
        type: "doughnut",
        // startAngle: 60,
        toolTipContent: "#percent%",
        dataPoints: [
          {  y: <?php echo number_format($perc_compareceu,1) ?>, indexLabel: "#percent% Compareceu" },
          {  y: <?php echo number_format($perc_nao_compareceu,1) ?>, indexLabel: "#percent% Não compareceu" }
        ]
      }
    ]
  }
);

chart2.render();
$('.canvasjs-chart-credit').hide();

/**
* chart pie para as duvidas mais frequentes dos agendamentos
*/

// Tons de vermelho para que o Pie Chart fique de acordo com o tema do Dashboard
CanvasJS.addColorSet("RedShades",
[//colorSet Array
  "#F34336",
  "#FF0000",
  "#ff5232",
  "#ff7b5a",
  "#ff9e81",
  "#ffbfaa",
  "#ffdfd4",
  "#FF3B1F",
  "#ee3a1f",
  "#B489AC",
  "#FF2E16",
  "#D07684",
  "#E4605E",
  "#dd5035",
  "#ca6048",
  "#b56d5b",
  "#9d776d",
  "#808080",
  "#899AD5",
  "#FF1D0B",
  "#df0000",
  "#ea0000",
  "#2d1106",
   "#d11507",
  "#a51b0b",
  "#7a1b0c",
  "#52170b"
]);
var prin_duvidas = new CanvasJS.Chart("prin_duvidas",
  {
    colorSet: "RedShades",
    animationEnabled: true,
    title: {
      text: "PRINCIPAIS DÚVIDAS"
    },
    legend: {
      reversed: true,
      verticalAlign: "bottom",
      horizontalAlign: "center"
    },
    data: [{
      type: "pie",
      startAngle: 240,
      yValueFormatString: "##0.00\"%\"",
      // indexLabel: false,
      dataPoints: <?php  echo json_encode($dataPointsDuvidas, JSON_NUMERIC_CHECK); ?>
    }]
  }
);
prin_duvidas.render();
$('.canvasjs-chart-credit').hide();

// chart dos cursos que mais agendaram
var cursos_mais_agd = new CanvasJS.Chart("cursos_mais_agd",
  {
    colorSet: "RedShades",
    animationEnabled: true,
    title: {
      text: "CURSOS QUE MAIS AGENDARAM"
    },
    legend: {
      reversed: true,
      verticalAlign: "bottom",
      horizontalAlign: "center"
    },
    data: [{
      type: "pie",
      startAngle: 240,
      yValueFormatString: "##0.00\"%\"",
      // indexLabel: false,
      dataPoints: <?php  echo json_encode($dataPointsCursos, JSON_NUMERIC_CHECK); ?>
    }]
  }
);
cursos_mais_agd.render();

// limpar texto de credito ao canvasjs
$('.canvasjs-chart-credit').hide();

// chart dos servidores que mais receberam agendamentos
var servidores_mais_agd = new CanvasJS.Chart("servidores_mais_agd",
  {
    colorSet: "RedShades",
    animationEnabled: true,
    title: {
      text: "SOLICITAÇÃO POR SERVIDOR"
    },
    legend: {
      reversed: true,
      verticalAlign: "bottom",
      horizontalAlign: "center"
    },
    data: [{
      type: "pie",
      startAngle: 240,
      yValueFormatString: "##0.00\"%\"",
      // indexLabel: false,
      dataPoints: <?php  echo json_encode($dataPointsServidores, JSON_NUMERIC_CHECK); ?>
    }]
  }
);
servidores_mais_agd.render();
// limpar texto de credito ao canvasjs
$('.canvasjs-chart-credit').hide();
}
</script>
