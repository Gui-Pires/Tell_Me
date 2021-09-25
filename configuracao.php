<?php
include('main.php');
require('connect.php');
$consulta = mysqli_query($con, "Select * from conf_rel");
$dia = mysqli_fetch_array($consulta);
?>
<div class="container">
	<div class="row">
		<div class="col s10 m10 l10">
			<h2>Configurações</h2>
		</div>
		<div class="col s2 m2 l2 pull-m1 pull-l1 right">
			<a href="<?php echo $_SESSION['pg']; ?>" class="btn menu blue" style="margin-top: 50px;">Voltar</a>
		</div>
	</div>
	<div class="divider"></div>
	<div class="row">
		<div class="col s12 m6 l6 justify">
			<h5>Limpeza de Dados</h5>
			<p>Todo dia <b><?php echo $dia['dia']; ?></b> de cada mês, é feito uma varredura dos chamados. Você pode alterar o dia da varredura.</p>
			<p>Ex: </p>
			<p>Hoje - 10/05/2020.</p>
			<p>Varredura: 10/04/2020 e datas anteriores.</p>
			<p><b>Somente em chamados CONCLUIDOS</b></p>
		</div>
	</div>
	<form method="post">
		<div class="row">
			<div class="input-field col s6 m3 l3">
				<label for="data">Alterar Dia</label>
				<input type="number" name="data" min="1" max="30" required>
			</div>
			<div class="input-field col s3 m3 l3">
				<input type="submit" name="Dia" value="Alterar" class="btn blue">
			</div>
		</div>
	</form>
	<?php
	$button = "Ativar";
	$cor = "green";
	if($dia['ativo']==1){
		$button = "Desativar";
		$cor = "red";
	}
	?>
	<form method="post">
		<div class="row">
			<div class="col s6 m3 l3">
				<p><?php echo $button; ?> Varredura</p>
			</div>
			<div class="input-field col s3 m3 l3">
				<input type="submit" name="<?php echo $button; ?>" value="<?php echo $button; ?>" class="btn <?php echo $cor; ?>">
			</div>
		</div>
	</form>
	<?php
	if (isset($_POST['Dia'])) {
		require('connect.php');
		extract($_POST);
		if($data==null){
			echo "<script>M.toast({html: 'Preencha o campo!', classes: 'rounded'})</script>";
			exit();
		}
		if (mysqli_query($con, "Update conf_rel set dia=$data")) {
			$_SESSION['msg'] = "Alterado!";
			$_SESSION['varrer'] = 0;
			header("Location: configuracao.php");
		}
	}
	if (isset($_POST['Desativar'])) {
		require('connect.php');
		extract($_POST);
		if (mysqli_query($con, "Update conf_rel set ativo=0")) {
			$_SESSION['msg'] = "Varredura Desativada!";
			header("Location: configuracao.php");
		}
	}
	if (isset($_POST['Ativar'])) {
		require('connect.php');
		extract($_POST);
		if (mysqli_query($con, "Update conf_rel set ativo=1")) {
			$_SESSION['msg'] = "Varredura Ativada!";
			header("Location: configuracao.php");
		}
	}
	?>
</div>