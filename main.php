<?php
session_start();
if(!isset($_SESSION['login'])){
	header("Location: login.php");
}
if($_SESSION['permissao']==2){
	include('header.html');		 //Links e scripts
	include('banner_main.html'); //Banner principal
	include('subBanner.php');	 //subBanner após login feito (Índice)
	include('varrer.php');      //Varredura de chamados antigos automática
}else{
	header("Location: login.php");
}
if(isset($_SESSION['msg'])){
	if($_SESSION['msg']!=null || $_SESSION['msg']!=""){
		$msg = $_SESSION['msg'];
		echo "<script>M.toast({html: '$msg', classes: 'rounded'})</script>";
		$_SESSION['msg'] = "";
	}
}
?>