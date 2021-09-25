<?php
if($_SESSION['varrer']>0){
	require('connect.php');
	$dias = mysqli_query($con, "Select * From conf_rel where id=1");
	$dia = mysqli_fetch_array($dias);
	if($dia['ativo']==1){
		date_default_timezone_set("America/Sao_Paulo");
		$dataAtt = date("Y-m-d");
		if($dataAtt!=$dia['ult_varre']){
			$mdia = $dia['dia'];
			$diaAtt = date("d");
			if($mdia==$diaAtt){
				$dataVar = date("Y-m-$mdia", strtotime("-1 month"));
				if (mysqli_query($con, "Call Varredura('$dataVar')")){
					if(mysqli_query($con, "Update conf_rel set ult_varre='$dataAtt'")) {
						$_SESSION['msg'] = "Varredura mensal feita!";
						$_SESSION['varrer'] = 0;
					}
				}
			}
		}else{
			//$_SESSION['msg'] = "N/A varredura";
			$_SESSION['varrer'] = 0;
		}
	}
}
?>