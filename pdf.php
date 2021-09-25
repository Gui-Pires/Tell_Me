<?php
require 'dompdf/autoload.inc.php';
Dompdf\Autoloader::register();
use Dompdf\Dompdf;
$dompdf = new Dompdf();
require('connect.php');
$a = 1;		//Variável para condição (Não usar require novamente)
$li	= 0;	//Contador de linhas
$cAbertos = 0;
$cAnalise = 0;
$cConcluidos = 0;
$pro = array("Aberto"=>0, "Em Análise"=>0, "Concluido"=>0);
$departamento = array("Administração"=>$pro, "Contabilidade"=>$pro,
	"Marketing"=>$pro, "RH"=>$pro, "Tester"=>$pro, "TI"=>$pro);
require('connect.php');
$datas = mysqli_query($con, "Select * from conf_rel");
$data = mysqli_fetch_array($datas);
$data2 = $data['ult_varre'];
$dia = date("d", strtotime($data['ult_varre']));
$dataCha = date("Y-m-$dia", strtotime("-1 month"));
$today = date("d/m/Y");
$chamados = mysqli_query($con, "Call Sel_All()");
while($chamado = mysqli_fetch_array($chamados)){
	if($chamado['progresso']=='Aberto'){
		$cAbertos++;
		$departamento[$chamado['departamento']]['Aberto']++;
	}else if($chamado['progresso']=='Em Análise'){
		$cAnalise++;
		$departamento[$chamado['departamento']]['Em Análise']++;
	}else{
		$cConcluidos++;
		$departamento[$chamado['departamento']]['Concluido']++;
	}
}//while
$element = "";
foreach ($departamento as $key => $v) {
	$sm = 0;
	$element .= "<tr>";
	$element .= "<td>".$key."</td>";
	foreach ($v as $key2 => $v2) {
		$sm += $v2;
	}
	$element .= "<td>".$sm."</td>";
	$element .= "</tr>";
}
$elementA = "";
foreach ($departamento as $key => $v) {
	$elementA .= "<tr>";
	$elementA .= "<td>".$key."</td>";
	$elementA .= "<td>".$departamento[$key]["Aberto"]."</td>";
	$elementA .= "</tr>";
}
$elementB = "";
foreach ($departamento as $key => $v) {
	$elementB .= "<tr>";
	$elementB .= "<td>".$key."</td>";
	$elementB .= "<td>".$departamento[$key]["Em Análise"]."</td>";
	$elementB .= "</tr>";
}
$elementC = "";
foreach ($departamento as $key => $v) {
	$elementC .= "<tr>";
	$elementC .= "<td>".$key."</td>";
	$elementC .= "<td>".$departamento[$key]["Concluido"]."</td>";
	$elementC .= "</tr>";
}
$sPro = $cAbertos+$cAnalise+$cConcluidos;
$pAb = round($cAbertos/$sPro*100, 1);
$pAn = round($cAnalise/$sPro*100, 1);
$pCo = round($cConcluidos/$sPro*100, 1);
$sm = 0;
//$dompdf->set_base_path("materialize/css/materialize.css");
$dompdf->loadHtml('
	<head>
		<meta charset="UTF-8">
		<title>Relatório - Tell Me</title>
		<link rel="sortcut icon" href="img/icon2.png" type="image/x-icon">
		<link rel="stylesheet" href="libs/css/estilo.css">
		<link rel="stylesheet" href="materialize/css/materialize.css">
		<link rel="stylesheet" href="materialize/css/materialize.min.css">
	</head>
	<h2 class="center-align" style="margin-top:-20px;">Relatório Tell Me</h2>
	<p>Data relatório:'.$today.'</p>
	<div class="divider"></div>
	<h4>Visão Geral</h4>
	<div class="divider"></div>
	<p>Todos Chamados desde:<b> '.$dataCha.'</b></p>
	<p>Última Varredura:<b> '.$data2.'</b></p>
	<p>Total de Chamados: '.$sPro.'</p>
	<p>Aberto(s): '.$cAbertos.' - '.$pAb.'%</p>
	<div class="progress" style="width: 40%">
	    <div class="determinate red" style="width:'.$pAb.'%"></div>
	</div>
	<p>Em Análise: '.$cAnalise.' - '.$pAn.'%</p>
	<div class="progress" style="width: 40%">
	    <div class="determinate yellow" style="width:'.$pAn.'%"></div>
	</div>
	<p>Concluido(s): '.$cConcluidos.' - '.$pCo.'%</p>
	<div class="progress" style="width: 40%">
	    <div class="determinate green" style="width:'.$pCo.'%"></div>
	</div>
	<table class="highlight">
		<thead>
			<tr>
				<th>Departamento</th>
				<th>Quantidade</th>
			</tr>
		</thead>
		<tbody>
			'.$element.'
		</tbody>
	</table>
	<div style="height: 20px;; width: 100%;"></div>
	<h4>Chamados Abertos</h4>
	<div class="divider"></div>
	<p>'.$cAbertos.' Chamado(s) aberto(s) - '.$pAb.'%</p>
	<div class="progress" style="width: 40%">
	    <div class="determinate red" style="width:'.$pAb.'%"></div>
	</div>
	<div class="divider"></div>
	<table class="highlight">
		<thead>
			<tr>
				<th>Departamento</th>
				<th>Quantidade</th>
			</tr>
		</thead>
		<tbody>
			'.$elementA.'
		</tbody>
	</table>
	<div style="height: 350px; width: 100%;"></div>
	<h4>Chamados Em análise</h4>
	<div class="divider"></div>
	<p>'.$cAnalise.' Chamado(s) em análise - '.$pAn.'%</p>
	<div class="progress" style="width: 40%">
	    <div class="determinate yellow" style="width:'.$pAn.'%"></div>
	</div>
	<div class="divider"></div>
	<table class="highlight">
		<thead>
			<tr>
				<th>Departamento</th>
				<th>Quantidade</th>
			</tr>
		</thead>
		<tbody>
			'.$elementB.'
		</tbody>
	</table>
	<div style="height: 350px; width: 100%;"></div>
	<h4>Chamados Concluídos</h4>
	<div class="divider"></div>
	<p>'.$cConcluidos.' Chamado(s) Concluídos</p>
	<p>'.$pCo.'%</p>
	<div class="progress" style="width: 40%">
	    <div class="determinate green" style="width:'.$pCo.'%"></div>
	</div>
	<div class="divider"></div>
	<table class="highlight">
		<thead>
			<tr>
				<th>Departamento</th>
				<th>Quantidade</th>
			</tr>
		</thead>
		<tbody>
			'.$elementC.'
		</tbody>
	</table>');
$dompdf->setPaper('A4');
$dompdf->render();
$dompdf->stream("Relatório_Chamados", ["Attachment" => false]);
