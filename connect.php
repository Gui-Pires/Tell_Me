<?php
//$con=mysqli_connect('localhost','root','');
if(!$con=mysqli_connect('localhost','root','')){
	echo"<p>Erro ao se conectar com o banco de dados!</p>";
}
if(!$db=mysqli_select_db($con,'bd_blacktec')){
	echo "<p>Erro ao se conectar com a base de dados!</p>";
}

mysqli_query($con,"SET NAMES utf8");

?>