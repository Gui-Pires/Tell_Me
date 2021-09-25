<?php
session_start();
require('connect.php');
$id = null;
if(isset($_GET['idChamado'])){
	$id = $_GET['idChamado'];
	if(mysqli_query($con, "Delete from chamados where id_cha='$id'")){
		$_SESSION['msg'] = "Chamado Deletado!";
		echo "Chamado Deletado!";
	}
}
