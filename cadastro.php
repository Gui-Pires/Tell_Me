<?php
include('index.php');
?>
<div class="container">
	<div class="row">
		<div class="col s11 m10 l10 push-m1 push-l1 center-align">
			<h2>Cadastro</h2>
		</div>
		<div class="col s1 m1 l1 pull-m1 pull-l1 right">
			<a href="<?php echo $_SESSION['pg']; ?>" class="btn blue menu right" style="margin-top: 50px;">Voltar</a>
		</div>
	</div>
	<form method="post">
		<div class="row">
			<div class="input-field col s12 m8 l6 push-m3 push-l3">
				<label class="active" for="nome">Nome</label>
				<input type="text" name="nome" id="nome" class="validate" required>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12 m8 l6 push-m3 push-l3">
				<label class="active" for="email">Email</label>
				<input type="text" name="email" id="email" class="validate" required>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12 m8 l6 push-m3 push-l3">
				<label class="active" for="senha">Senha</label>
				<input type="password" name="senha" id="senha" class="validate" required>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12 m4 l3 push-m3 push-l3">
				<select name="departamento" id="dep" class="browser-default">
					<option selected disabled>Departamento</option>
					<option value="Administração">Administração</option>
					<option value="Contabilidade">Contabilidade</option>
					<option value="Marketing">Marketing</option>
					<option value="RH">RH</option>
					<option value="Tester">Tester</option>
					<option value="TI">TI</option>
				</select>
			</div>
			<div class="input-field col s12 m4 l3 push-m3 push-l3">
				<select name="permissao" id="per" class="browser-default">
					<option selected disabled>Nível de Permissão</option>
					<option value="1">Usuário</option>
					<option value="2">Técnico</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col s12 m8 l6 push-m3 push-l3 center">
				<input type="submit" name="Cadastrar" value="Cadastrar" class="btn blue">
			</div>
		</div>
	</form>
</div>
<?php
if(isset($_POST['Cadastrar'])){
	require('connect.php');
	extract($_POST);
	if($nome==null || $email==null || $senha==null || @$permissao==null || @$departamento==null){
		echo "<script>M.toast({html: 'Preencha todos os campos!', classes: 'rounded'})</script>";
	}else if(strlen($senha)<6){
		echo "<script>M.toast({html: 'A senha deve ter no mínimo 6 caracteres!', classes: 'rounded'})</script>";
	}else{
		$SenhaHash = md5($senha);
		date_default_timezone_set("America/Sao_Paulo");
		$data = date('Y/m/d');
		if(mysqli_query($con, "Call Cad_user('$nome', '$email', '$SenhaHash', '$data', '$departamento', '$permissao')")){
			$_SESSION['msg'] = "Usuário cadastrado";
			header("Location: lista_user.php");
		}else{
			echo "<script>M.toast({html: 'Email já existe!', classes: 'rounded'})</script>";
		}
	}
}
?>
