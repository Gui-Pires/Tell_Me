<?php
@session_start();
if(!isset($_SESSION['login'])){
	header("Location: login.php");
}
if($_SESSION['permissao']==1){
	include('header.html');		 //Links e scripts
	include('banner_main.html'); //Banner principal
	include('subBanner_user.php');	 //subBanner após login feito (Índice)
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
