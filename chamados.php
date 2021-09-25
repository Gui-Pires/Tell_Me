<?php
include('main.php');
$_SESSION['pg'] = "chamados.php";
$_SESSION['att'] = "chamados.php";
?>
<div class="container">
	<h2 class="center">Todos os Chamados</h2>
    <div class="row">
        <div class="col s6 m6 l4">
            <h5>Em Lista</h5>
            <ul>
                <li><p><a href="aberto.php">Abertos</a></p></li>
                <li><p><a href="analise.php">Em Análise</a></p></li>
                <li><p><a href="concluido.php">Concluidos</a></p></li>
            </ul>
        </div>
        <div class="col s6 m6 l4">
            <h5>Outros</h5>
            <ul>
                <li><p><a href="Filtros.php">Filtros</a></p></li>
                <li><p><a href="BuscaID.php">Código</a></p></li>
            </ul>
        </div>
    </div>
</div>
<?php
include('footer.html');
?>