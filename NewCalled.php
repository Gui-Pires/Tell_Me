<?php
include('user.php');
?>
<div class="container s12">
	<div class="row">
		<div class="col s12 m12 l12 center-align">
    		<h2>Novo Chamado</h2>
		</div>
	</div>
	<form method="post">
		<div class="row">
		    <div class="input-field col s12 m6 l6 push-m3 push-l3">
		        <input type="text" name="titulo" id="titulo" data-length="30">
		        <label for="titulo">Título</label>
		    </div>
		</div>
		<div class="row">
		    <div class="input-field col s12 m6 l6 push-m3 push-l3">
		        <textarea name="descricao" id="descricao" class="materialize-textarea space-1" data-length="250"></textarea>
		        <label for="descricao">Descrição</label>
		    </div>
		</div>
	    <div class="col s12 m12 l12 center-align">
			<input type="submit" name="chamar" value="Enviar" class="btn blue">
	    </div>
	</form>
</div>
<?php
require('connect.php');
extract($_POST);
if(isset($_POST['chamar'])){
	if ($titulo==null || $descricao==null) {
		echo "<script>M.toast({html: 'Preencha todos os campos!', classes: 'rounded'})</script>";
	}else{
		date_default_timezone_set("America/Sao_Paulo");
		$data = date("Y/m/d h:i:s");
		$id = $_SESSION['id'];
		if (mysqli_query($con, "Call Inc_chamado('$id', '$titulo', '$descricao', '$data')")) {
			if(mysqli_query($con, "Call AltChamado_user('$id')")){
				$_SESSION['msg'] = "Chamado Feito!";
				header("Location: NewCalled.php");
			}
		}
	}
}
?>