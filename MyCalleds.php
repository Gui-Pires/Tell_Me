<?php
include('user.php');
require('connect.php');
$id = $_SESSION['id'];
$_SESSION['pg'] = "MyCalleds.php";
$users = mysqli_query($con, "Call vPerfil_user('$id');");
$user = mysqli_fetch_array($users);
?>
<div class="container">
	<div class="row">
		<div class="col s12 m12 l12">
			<h2>Meus Chamados</h2>
		</div>
	</div>
<?php
if($user['Qtde_chamados']>0){ ?>
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
			$chamados = mysqli_query($con, "Call vChamado_user('$id')");
			while($chamado = mysqli_fetch_array($chamados)){
				echo "<tr>";
				echo "<td>
				<a href='confirma.php?idChamado=$chamado[id_cha]'>".$chamado['titulo']."</a>
				</td>";
				echo "<td>".$user['email']."</td>";
				if($chamado['progresso']=="Em Análise"){
					echo "<td><b>".$chamado['progresso']."</b></td>";
				}else{
					echo "<td>".$chamado['progresso']."</td>";
				}
				echo "<td>".$chamado['DtChamado']."</td>";
				echo "</tr>";
			}?>
			</tbody>
		</table>
	<?php
	}else{
		echo "<p>Você não realizou nenhum chamado!</p>";
	}
?>
</div>