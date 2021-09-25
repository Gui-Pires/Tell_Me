<?php
session_start();
require('connect.php');
$id = null;
if(isset($_GET['pUser'])){
	$id = $_GET['pUser'];
	if(mysqli_query($con, "Delete from user where id_user='$id'")){
		$_SESSION['msg'] = "Usuário Deletado!";
		echo "Usuário Deletado!";
	}
}
