<?php
include('user.php');
require('connect.php');
$id = $_GET['idChamado'];
$chamados = mysqli_query($con, "Call vFiltro_id('$id')");
$chamado = mysqli_fetch_array($chamados);
?>
<script>
function confirmar(id){
	opcao = confirm('Deseja excluir este chamado?');
	if(opcao == true){
		$.ajax({
			url: 'excluir.php?idChamado='+id,
			success: function(data) {
			console.log(data);
			alert(data);
			location.href="MyCalleds.php";
	  		}
		});
	}
}
</script>
<div class="container">
	<div class="row">
		<div class="col s11 m11 l11">
			<h2>Confirmar Chamado</h2>
		</div>
		<div class="col s1 m1 l1 pull-m1 pull-l1 right">
			<a href="<?php echo $_SESSION['pg']; ?>" class="btn blue menu right" style="margin-top: 50px;">Voltar</a>
		</div>
	</div>
	<div class="divider"></div>
	<div class="row">
		<div class="col s6 m4 l4">
			<p>Email: <?php echo $chamado['email']; ?></p>
		</div>
		<div class="col s6 m4 l4">
			<p>Título: <?php echo $chamado['titulo']; ?></p>
		</div>
		<div class="col s6 m4 l4">
			<p><b>Data Chamado: <?php echo $chamado['DtChamado']; ?></b></p>
		</div>
	</div>
	<div class="row">
		<div class="col s6 m4 l4">
			<p>Departamento: <?php echo $chamado['departamento']; ?></p>
		</div>
		<div class="col s6 m4 l4">
			<p>Progresso: <?php echo $chamado['progresso']; ?></p>
		</div>
		<div class="col s6 m4 l4">
			<p><b>Prazo: <?php echo $chamado['prazo']; ?></b></p>
		</div>
	</div>
	<div class="row">
		<div class="col s6 m8 l8">
			<blockquote style="border-color: #2196f3;">
				<p>Descrição</p>
				<p><?php echo $chamado['descricao']; ?></p>
			</blockquote>
		</div>
		<div class="col s6 m4 l4">
			<p>Prioridade: <?php echo $chamado['prioridade']; ?></p>
		</div>
	</div>
	<?php
	if ($chamado['progresso']!="Concluido"){
	    if($chamado['progresso']=="Em Análise"){
	    ?>
		<div class="row">
			<div class="col s12 m6 l6">
				<h5>Encerrar Chamado</h5>
				<p><b>Confirme após o técnico ter realizado a manutenção!</b></p>
			</div>
		</div>
		<form method="post">
		    <div class="row">
		        <div class="input-field col s6 m3 l3">
		            <select class="browser-default" name="progresso">
		                <option disabled selected>Concluir Chamado</option>
		                <option value="Concluido">Confirmar</option>
		            </select>
		        </div>
		        <div class="input-field col s3 m3 l3">
		            <input type="submit" class="btn blue" name="Enviar" value="Enviar" title="Enviar">
		        </div>
		    </div>
	    </form>
		<?php
		} else {
		?>
	    <div class="row">
	    	<div class="input-field col s6 m3 l3">
	    		<a class="btn red" onclick="confirmar(<?php echo $id; ?>)">Cancelar</a>
	    	</div>
	    </div>
	<?php
		}
    } else{
    	echo "<p>Chamado concluido!</p>";
    }
    ?>
<?php
if(isset($_POST['Enviar'])){
	extract($_POST);
	if(@$progresso==null){
		echo "<script>M.toast({html: 'Preencha todos os campos!', classes: 'rounded'})</script>";
	}else{
		require('connect.php');
		if (mysqli_query($con, "Call AltChamado_atu('$id', '$progresso')")) {
			$_SESSION['msg'] = "Chamado Concluido!";
			header("Location: MyCalleds.php");
		}else{
			echo "<script>M.toast({html: 'Falha no evio!', classes: 'rounded'})</script>";
		}
	}
}
?>
</div>