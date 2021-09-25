<?php
include('main.php');
$_SESSION['pg'] = $_SESSION['att'];
?>
<div class="container">
	<div class="row">
		<div class="col s11 m11 l11">
			<h2>Busca por Filtros</h2>
		</div>
		<div class="col s1 m1 l1 pull-m1 pull-l1 right">
			<a href="<?php echo $_SESSION['pg']; ?>" class="btn blue menu right" style="margin-top: 50px;">Voltar</a>
			<?php $_SESSION['pg'] = "Filtros.php" ?>
		</div>
	</div>
	<form method="post">
		<div class="row">
			<div class="input-field col s2 m2 l2">
				<select name="departamento" class="browser-default">
					<option selected disabled>Departamento</option>
					<option value="Administração">Administração</option>
					<option value="Contabilidade">Contabilidade</option>
					<option value="Marketing">Marketing</option>
					<option value="RH">RH</option>
					<option value="Tester">Tester</option>
					<option value="TI">TI</option>
				</select>
			</div>
			<div class="input-field col s2 m2 l2">
				<select name="progresso" class="browser-default">
					<option selected disabled>Progresso</option>
					<option value="Aberto">Aberto</option>
					<option value="Em Análise">Em Análise</option>
					<option value="Concluido">Concluido</option>
				</select>
			</div>
			<div class="input-field col s2 m2 l2">
				<select name="prioridade" class="browser-default">
					<option selected disabled>Prioridade</option>
					<option value="Baixa">Baixa</option>
					<option value="Média">Média</option>
					<option value="Alta">Alta</option>
				</select>
			</div>
			<div class="input-field col s2 m2 l2">
				<input type="submit" name="Pesquisar" value="Buscar" class="btn blue">
			</div>
		</div>
	</form>
	<div class="divider"></div>
	<?php
	if(isset($_POST['Pesquisar'])){
		extract($_POST);
		require('connect.php');
		if(@$progresso=="Aberto" && @$prioridade!=null){
			echo "<script>M.toast({html: 'Chamados abertos não tem Prioridade!', classes: 'rounded'})</script>";
			exit();
		}
		$a = "blue-text";
		$b = "blue-text";
		$c = "blue-text";
		if(@$departamento==null){
			$departamento = "%%";
			$a = "black-text";
		}
		if(@$progresso==null){
			$progresso = "%%";
			$b = "black-text";
		}
		if(@$prioridade==null){
			$prioridade = "%%";
			$c = "black-text";
		}
		$li = 0;
		?>
		<table class="highlight">
			<thead>
				<tr>
					<th>Título</th>
					<th>Email</th>
					<th class="<?php echo $a; ?>">Departamento</th>
					<th class="<?php echo $b; ?>">Progresso</th>
					<th class="<?php echo $c; ?>">Prioridade</th>
					<th>Data Chamado</th>
				</tr>
			</thead>
			<tbody>
		<?php
		$link = "";
		$chamados = mysqli_query($con, "Call vFiltros('$departamento', '$progresso', '$prioridade')");
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
			echo "<td>".$chamado['email']."</td>";
			echo "<td>".$chamado['departamento']."</td>";
			echo "<td>".$chamado['progresso']."</td>";
			echo "<td>".$chamado['prioridade']."</td>";
			echo "<td>".$chamado['DtChamado']."</td>";
			echo "</tr>";
			$li++;
		}?>
			</tbody>
		</table>
		<?php
		echo "<script>M.toast({html: '$li chamado(s) encontrado(s)!', classes: 'rounded'})</script>";
	}
	?>
</div>