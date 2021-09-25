<?php
include('main.php');
require('connect.php');
$id = $_GET['idChamado'];
$chamados = mysqli_query($con, "Call vFiltro_id('$id')");
$chamado = mysqli_fetch_array($chamados);
date_default_timezone_set("America/Sao_Paulo");
$data = date("Y-m-d");
?>
<div class="container">
	<div class="row">
		<div class="col s11 m11 l11">
			<h2>Consultar Chamado</h2>
		</div>
		<div class="col s1 m1 l1 pull-m1 pull-l1 right">
			<a href="<?php echo $_SESSION['pg']; ?>" class="btn blue menu right" style="margin-top: 50px;">Voltar</a>
		</div>
	</div>
	<div class="divider"></div>
	<div class="row">
		<div class="col s6 m4 l4">
			<p>Código: <?php echo $chamado['id_cha']; ?></p>
		</div>
		<div class="col s6 m4 l4">
			<p>Título: <?php echo $chamado['titulo']; ?></p>
		</div>
		<div class="col s12 m4 l4">
			<p><b>Data Chamado: <?php echo $chamado['DtChamado']; ?></b></p>
		</div>
	</div>
	<div class="row">
		<div class="col s6 m4 l4">
			<p>Email: <?php echo $chamado['email']; ?></p>
		</div>
		<div class="col s6 m4 l4">
			<p>Departamento: <?php echo $chamado['departamento']; ?></p>
		</div>
		<div class="col s6 m4 l4">
			<p><b>Prazo: <?php echo $chamado['prazo']; ?></b></p>
		</div>
	</div>
	<div class="row">
		<div class="col s6 m4 l4">
			<p>Progresso: <?php echo $chamado['progresso']; ?></p>
		</div>
		<div class="col s6 m4 l4">
			<p>Prioridade: <?php echo $chamado['prioridade']; ?></p>
		</div>
	</div>
	<div class="row">
		<div class="col s6 m8 l8">
			<blockquote style="border-color: #2196f3;">
				<p>Descrição</p>
				<p><?php echo $chamado['descricao']; ?></p>
			</blockquote>
		</div>
	</div>
</div>