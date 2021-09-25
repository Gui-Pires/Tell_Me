<?php
include('main.php');
$_SESSION['pg'] = "relatorio.php";
$_SESSION['att'] = "relatorio.php";
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
$dia = date("d", strtotime($data['ult_varre']));
$dateCha = date("Y-m-$dia", strtotime("-1 month"));
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
$sPro = $cAbertos+$cAnalise+$cConcluidos;
$pAb = round($cAbertos/$sPro*100, 1);
$pAn = round($cAnalise/$sPro*100, 1);
$pCo = round($cConcluidos/$sPro*100, 1);
$sm = 0;
?>
<div class="container">
	<div class="row">
		<div class="col s6 m6 l6">
			<h2>Relatório</h2>
		</div>
		<div class="col s5 m5 l5 pull-m1 pull-l1 right">
			<a href="pdf.php" class="btn menu blue" style="margin-top: 50px;" target="_blank">Gerar PDF</a>
			<a href="configuracao.php" class="btn menu blue" style="margin-top: 50px;">Configurações</a>
		</div>
	</div>
	<div class="divider"></div>
	<div class="row">
		<div class="col s12 m12 l12">
			<h4>Visão Geral</h4>
		</div>
	</div>
	<div class="divider"></div>
	<div class="row">
		<div class="col s6 m6 l6">
			<p>Total de Chamados: <?php echo $sPro; ?></p>
		</div>
		<div class="col s6 m6 l6 right-align">
			<p>Todos os Chamados desde:<b> <?php echo $dateCha; ?></b></p>
			<p>Última Varredura:<b> <?php echo $data['ult_varre']; ?></b></p>
		</div>
	</div>
	<div class="row">
		<div class="col s6 m4 l4">
			<p class="left">Aberto(s): <?php echo $cAbertos; ?></p>
			<p class="right"><?php echo $pAb; ?>%</p>
			<div class="progress">
			    <div class="determinate red" style="width: <?php echo $pAb; ?>%"></div>
			</div>
		</div>
		<div class="col s6 m4 l4">
			<p class="left">Em Análise: <?php echo $cAnalise; ?></p>
			<p class="right"><?php echo $pAn; ?>%</p>
			<div class="progress">
			    <div class="determinate yellow" style="width: <?php echo $pAn; ?>%"></div>
			</div>
		</div>
		<div class="col s6 m4 l4">
			<p class="left">Concluido(s): <?php echo $cConcluidos; ?></p>
			<p class="right"><?php echo $pCo; ?>%</p>
			<div class="progress">
			    <div class="determinate green" style="width: <?php echo $pCo; ?>%"></div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class='col s12 m12 l12'>
			<ul class="collapsible">
				<li>
					<div class="collapsible-header"><p>Departamentos</p></div>
					<div class="collapsible-body">
						<table class="highlight">
							<thead>
								<tr>
									<th>Departamento</th>
									<th>Quantidade</th>
								</tr>
							</thead>
							<tbody>
							<?php
							foreach ($departamento as $key => $v) {
								$sm = 0;
								echo "<tr>";
								echo "<td>".$key."</td>";
								foreach ($v as $key2 => $v2) {
									$sm += $v2;
								}
								echo "<td>".$sm."</td>";
								echo "</tr>";
							}
							?>
							</tbody>
						</table>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<div class="row">
		<div class="col s12 m12 l12">
			<h4>Chamados Abertos</h4>
		</div>
	</div>
	<div class="divider"></div>
	<div class="row">
		<div class="col s4 m4 l4">
			<p><?php echo $cAbertos; ?> Chamado(s) aberto(s)</p>
			<p><?php echo $pAb; ?>%</p>
			<div class="progress">
			    <div class="determinate red" style="width: <?php echo $pAb; ?>%"></div>
			</div>
		</div>
	</div>
	<div class="divider"></div>
	<div class="row">
		<div class='col s12 m12 l12'>
			<ul class="collapsible">
				<li>
					<div class="collapsible-header"><p>Departamentos</p></div>
					<div class="collapsible-body">
						<table class="highlight">
							<thead>
								<tr>
									<th>Departamento</th>
									<th>Quantidade</th>
								</tr>
							</thead>
							<tbody>
							<?php
							foreach ($departamento as $key => $v) {
								echo "<tr>";
								echo "<td>".$key."</td>";
								echo "<td>".$departamento[$key]['Aberto']."</td>";
								echo "</tr>";
							}
							?>
							</tbody>
						</table>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<div class="row">
		<div class="col s12 m12 l12">
			<h5>Chamados Em análise</h5>
		</div>
	</div>
	<div class="divider"></div>
	<div class="row">
		<div class="col s4 m4 l4">
			<p><?php echo $cAnalise; ?> Chamado(s) em análise</p>
			<p><?php echo $pAn; ?>%</p>
			<div class="progress">
			    <div class="determinate yellow" style="width: <?php echo $pAn; ?>%"></div>
			</div>
		</div>
	</div>
	<div class="divider"></div>
	<div class="row">
		<div class='col s12 m12 l12'>
			<ul class="collapsible">
				<li>
					<div class="collapsible-header"><p>Departamentos</p></div>
					<div class="collapsible-body">
						<table class="highlight">
							<thead>
								<tr>
									<th>Departamento</th>
									<th>Quantidade</th>
								</tr>
							</thead>
							<tbody>
							<?php
							foreach ($departamento as $key => $v) {
								echo "<tr>";
								echo "<td>".$key."</td>";
								echo "<td>".$departamento[$key]['Em Análise']."</td>";
								echo "</tr>";
							}
							?>
							</tbody>
						</table>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<div class="row">
		<div class="col s12 m12 l12">
			<h5>Chamados Concluídos</h5>
		</div>
	</div>
	<div class="divider"></div>
	<div class="row">
		<div class="col s4 m4 l4">
			<p><?php echo $cConcluidos; ?> Chamado(s) em análise</p>
			<p><?php echo $pCo; ?>%</p>
			<div class="progress">
			    <div class="determinate green" style="width: <?php echo $pCo; ?>%"></div>
			</div>
		</div>
	</div>
	<div class="divider"></div>
	<div class="row">
		<div class='col s12 m12 l12'>
			<ul class="collapsible">
				<li>
					<div class="collapsible-header"><p>Departamentos</p></div>
					<div class="collapsible-body">
						<table class="highlight">
							<thead>
								<tr>
									<th>Departamento</th>
									<th>Quantidade</th>
								</tr>
							</thead>
							<tbody>
							<?php
							foreach ($departamento as $key => $v) {
								echo "<tr>";
								echo "<td>".$key."</td>";
								echo "<td>".$departamento[$key]['Concluido']."</td>";
								echo "</tr>";
							}
							?>
							</tbody>
						</table>
					</div>
				</li>				
			</ul>
		</div>
	</div>
</div>