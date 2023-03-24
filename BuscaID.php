<?php
include('index.php');
$_SESSION['pg'] = $_SESSION['att'];
?>
<div class="container">
	<div class="row">
		<div class="col s11 m11 l11">
			<h2>Código</h2>
		</div>
		<div class="col s1 m1 l1 pull-m1 pull-l1 right">
			<a href="<?php echo $_SESSION['pg']; ?>" class="btn blue menu right" style="margin-top: 50px;">Voltar</a>
			<?php $_SESSION['pg'] = "BuscaID.php"; ?>
		</div>
	</div>
	<div class="divider"></div>
	<form method="post">
		<div class="row">
			<div class="input-field col s6 m4 l3">
				<input type="number" name="id" autofocus required>
				<label for="id">Código do Chamado</label>
			</div>
			<div class="col s3 m3 l3">
				<input type="submit" name="Buscar" value="Buscar" class="btn menu blue">
			</div>
		</div>
	</form>
	<?php
	if(isset($_POST['Buscar'])){
		extract($_POST);
		require('connect.php');
		$chamados = mysqli_query($con, "Call vFiltro_id('$id')");
		if(!@$chamado = mysqli_fetch_array($chamados)){
			echo "<script>M.toast({html: 'Não há chamado com este ID!', classes: 'rounded'})</script>";
			exit();
		}
		$link = "";
		if(isset($chamado['id_cha'])){
			if($chamado['progresso']=="Aberto"){
				$link = "responder";
			}else if($chamado['progresso']=="Em Análise"){
				$link = "atualiza";
			}else{
				$link = "consulta";
			}
		?>
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
			echo "<tr>";
			echo "<td>
			<a href='$link.php?idChamado=$chamado[id_cha]'>".$chamado['titulo']."</a>
			</td>";
			echo "<td>".$chamado['email']."</td>";
			echo "<td>".$chamado['progresso']."</td>";
			echo "<td>".$chamado['DtChamado']."</td>";
			echo "</tr>";
			?>
		</tbody>
	</table>
	<?php
		}else{
			echo "<script>M.toast({html: 'Não há chamado com este ID!', classes: 'rounded'})</script>";
		}
	}
	?>
</div>
