<?php
session_start();
if(isset($_SESSION['login'])){
	unset($_SESSION['login']);
	session_destroy();
}
include('header.html');
include('banner_main.html');
?>
<div class="container">
	<div class="row">
		<div class="col s12 m6 l6 push-m3 push-l3 center">
			<h1>Login</h1>
		</div>
	</div>
	<form method="post">
		<div class="row">
			<div class="input-field col s12 m6 l6 push-m3 push-l3">
				<label class="active" for="email">Email</label>
				<input type="text" name="email" id="email" class="validate" required>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12 m6 l6 push-m3 push-l3">
				<label class="active" for="senha">Senha</label>
				<input type="password" name="senha" id="senha" class="validate" required>
			</div>
		</div>
		<div class="row">
			<div class="col s12 m6 l6 push-m3 push-l3 center">
				<input type="submit" name="Entrar" value="Entrar" class="btn blue" required>
			</div>
		</div>
	</form>
</div>
<?php
if (isset($_POST['Entrar'])) {
	require("connect.php");
	extract($_POST);
	$SenhaHash = md5($senha);
	$vEmail=false;
	$vSenha=false;
	$nome = "";
	$permissao = null;
	$id = null;
	$users = mysqli_query($con, "Call Sel_user()");
	while($user = mysqli_fetch_array($users)){
		if($email==$user['email']){
			$nome = $user['nome'];
			$vEmail = true;
			if($SenhaHash==$user['senha']){
				$permissao = $user['permissao'];
				$id = $user['id_user'];
				$vSenha = true;
			}
		}
	}
	if($vEmail==true){
		if($vSenha==true){
			session_start();
			$_SESSION['id'] = $id;
			$_SESSION['nome'] = $nome;
			$_SESSION['login'] = $email;
			$_SESSION['permissao'] = $permissao;
			$_SESSION['pg'] = "login.php";
			$_SESSION['varrer'] = 1;
			if ($_SESSION['permissao']==1) {
				header("Location: MyCalleds.php");
			}else{
				header("Location: chamados.php");
			}
			exit;
		}else{
			echo "<script>M.toast({html: 'Senha incorreta!', classes: 'rounded'})</script>";
		}
	}else{
		echo "<script>M.toast({html: 'Email inválido!', classes: 'rounded'})</script>";
	}
}
include('footer.html');
?>