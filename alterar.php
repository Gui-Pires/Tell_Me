<?php
include('main.php');
$id = $_GET['pUser'];
require('connect.php');
$users = mysqli_query($con, "Call vPerfil_user('$id')");
$user = mysqli_fetch_array($users);
?>
<div class="container">
	<div class="row">
		<div class="col s11 m10 l10 push-m1 push-l1 center-align">
			<h2>Alterar</h2>
		</div>
		<div class="col s1 m1 l1 pull-m1 pull-l1 right">
			<a href="<?php echo $_SESSION['pg']; ?>" class="btn blue menu right" style="margin-top: 50px;">Voltar</a>
		</div>
	</div>
	<form method="post">
		<div class="row">
			<div class="input-field col s12 m8 l6 push-m3 push-l3">
				<label class="active" for="nome">Nome</label>
				<input type="text" name="nome" id="nome" class="validate" 
				value="<?php echo $user['nome']; ?>" required>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12 m8 l6 push-m3 push-l3">
				<label class="active" for="email">Email</label>
				<input type="text" name="email" id="email" class="validate" 
				value="<?php echo $user['email']; ?>" required>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12 m8 l6 push-m3 push-l3">
				<label class="active" for="senha">Senha</label>
				<input type="password" name="senha" id="senha" class="validate"
				value="<?php echo $user['senha']; ?>" required>
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
				<input type="submit" name="Alterar" value="Alterar" class="btn blue">
			</div>
		</div>
	</form>
</div>
<?php
if(isset($_POST['Alterar'])){
	require('connect.php');
	extract($_POST);
	if(strlen($senha)<6){
		echo "<script>M.toast({html: 'A senha deve ter no mínimo 6 caracteres!', classes: 'rounded'})</script>";
		exit();
	}
	if(@$departamento==null){
		$departamento = $user['departamento'];
	}
	if(@$permissao==null){
		$permissao = $user['permissao'];
	}
	$senhaHash = md5($senha);
	if(mysqli_query($con, "Update user SET nome='$nome', email='$email', senha='$senhaHash',
		departamento='$departamento', permissao='$permissao' Where id_user='$id'")){
		$_SESSION['msg'] = "Usuário Alterado!";
		header("Location: $_SESSION[pg]");
	}
}
?>