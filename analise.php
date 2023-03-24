<?php
include('index.php');
$_SESSION['pg'] = $_SESSION['att'];
?>
<div class="container">
	<div class="row">
		<div class="col s11 m11 l11">
			<h2>Chamados Em Análise</h2>
		</div>
		<div class="col s1 m1 l1 pull-m1 pull-l1 right">
			<a href="<?php echo $_SESSION['pg']; ?>" class="btn blue menu right" style="margin-top: 50px;">Voltar</a>
			<?php $_SESSION['pg'] = "analise.php" ?>
		</div>
	<div class="divider"></div>
	<table class="highlight">
		<thead>
			<tr>
				<th>Título</th>
				<th>Email</th>
				<th>Progresso</th>
				<th>Data Chamado</th>
				<th>Prioridade</th>
				<th>Prazo</th>
			</tr>
		</thead>
		<tbody>
			<?php
			require('connect.php');
			$chamados = mysqli_query($con, "Call vChamado_analise()");
			while($chamado = mysqli_fetch_array($chamados)){
				echo "<tr>";
				echo "<td>
				<a href='atualiza.php?idChamado=$chamado[id_cha]'>".$chamado['titulo']."</a>
				</td>";
				echo "<td>".$chamado['email']."</td>";
				echo "<td>".$chamado['progresso']."</td>";
				echo "<td>".$chamado['DtChamado']."</td>";
				echo "<td>".$chamado['prioridade']."</td>";
				echo "<td>".$chamado['prazo']."</td>";
				echo "</tr>";
			}
			?>
		</tbody>
	</table>
</div>
