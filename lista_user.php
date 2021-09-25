<?php
include('main.php');
$_SESSION['pg'] = "lista_user.php";
$_SESSION['att'] = "lista_user.php";
?>
<div class="container">
	<div class="row">
		<div class="col s10 m10 l10">
			<h2>Usuários no sistema</h2>
		</div>
		<div class="col s2 m2 l2 pull-m1 pull-l1">
			<a href="cadastro.php" class="btn blue menu right" style="margin-top: 50px;">Cadastrar</a>
		</div>
	</div>
	<div class="divider"></div>
	<table class="highlight">
		<thead>
			<tr>
				<th>Email</th>
				<th>Departamento</th>
				<th>Data de Cadastro</th>
				<th>N° de Chamados</th>
			</tr>
		</thead>
		<tbody>
			<?php
			require('connect.php');
			$logins = mysqli_query($con, "Call Sel_user()");
			while($login = mysqli_fetch_array($logins)){
				echo "<tr>";
				echo "<td><a href='vPerfil.php?pUser=$login[id_user]'>".$login['email']."</a></td>";
				echo "<td>".$login['departamento']."</td>";
				echo "<td>".$login['DtCad']."</td>";
				echo "<td>".$login['Qtde_chamados']."</td>";
				echo "</tr>";
			}
			?>
		</tbody>
	</table>
</div>