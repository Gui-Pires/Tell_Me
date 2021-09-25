<?php
include('main.php');
require('connect.php');
$_SESSION['pg'] = $_SESSION['att'];
$id = $_GET['pUser'];
$users = mysqli_query($con, "Call vPerfil_user('$id');");
$user = mysqli_fetch_array($users);
$per = "Técnico";
if($user['permissao']==1){
	$per = "Usuário";
}
?>
<script>
function confirmar(id){
	opcao = confirm('Deseja excluir este usuário?');
	if(opcao == true){
		$.ajax({
			url: 'excluir_user.php?pUser='+id,
			success: function(data) {
			console.log(data);
			alert(data);
			location.href="lista_user.php";
	  		}
		});
	}
}
</script>
<div class="container">
	<div class="row">
		<div class="col s8 m8 l8">
			<h2>Dados do usuário</h2>
		</div>
		<div class="col s4 m4 l4 pull-m1 pull-l1 right">
			<a href="<?php echo $_SESSION['pg']; ?>" class="btn blue menu right" style="margin-top: 50px;">Voltar</a>
			<?php $_SESSION['pg'] = "vPerfil.php?pUser=$id" ?>
		</div>
	</div>
	<div class="divider"></div>
	<div class="row">
		<div class="col s6 m4 l4">
			<p>Nome: <?php echo $user['nome']; ?></p>
		</div>
		<div class="col s6 m4 l4">
			<p>Email: <?php echo $user['email']; ?></p>
		</div>
		<div class="col s6 m4 l4">
			<p>Data de Cadastro: <?php echo $user['DtCad']; ?></p>
		</div>
	</div>
	<div class="row">
		<div class="col s6 m4 l4">
			<p>Departamento: <?php echo $user['departamento']; ?></p>
		</div>
		<div class="col s6 m4 l4">
			<p>Permissao: <?php echo $per; ?></p>
		</div>
		<div class="col s6 m4 l4">
			<p>N° chamados: <?php echo $user['Qtde_chamados']; ?></p>
		</div>
	</div>
	<div class="row">
		<div class="col s12 m12 l12">
			<a onclick="confirmar(<?php echo $id; ?>)" class="btn menu red" style="margin-top: 50px;">Excluir</a>
			<a href="alterar.php?pUser=<?php echo $id; ?>" class="btn menu blue" style="margin-top: 50px;">Alterar</a>
		</div>
	</div>
	<?php
	if($user['Qtde_chamados']>0): ?>
		<table class="highlight">
			<thead>
				<tr>
					<th>Título</th>
					<th>Email</th>
					<th>Progresso</th>
					<th>Data Chamado</th>
				</tr>
			</thead>
			<tbody>
			<?php
			require('connect.php');
			$link = "";
			$chamados = mysqli_query($con, "Call vChamado_user('$id')");
			while($chamado = mysqli_fetch_array($chamados)){
				if($chamado['progresso']=="Aberto"){
					$link = "responder";
				}else if($chamado['progresso']=="Em Análise"){
					$link = "atualiza";
				}else{
					$link = "consulta";
				}
				echo "<tr>";
				echo "<td>
				<a href='$link.php?idChamado=$chamado[id_cha]'>".$chamado['titulo']."</a>
				</td>";
				echo "<td>".$user['email']."</td>";
				echo "<td>".$chamado['progresso']."</td>";
				echo "<td>".$chamado['DtChamado']."</td>";
				echo "</tr>";
			}?>
			</tbody>
		</table>
	<?php
	endif;
	?>
</div>