<?	
	/*include("includes/conf_inicial.php");	
	$sitioActivo=verificaMantto();
	if($sitioActivo[0]=="No"){*/
		header('Location:modulos/mod_login/index.php');
		exit;
	/*}else{
		mensaje($sitioActivo[1]);
	}*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>...::Inicio::...</title>
<style type="text/css">
<!--
body{font-family:Verdana, Geneva, sans-serif; font-size:14px; margin:15px; padding:20px;}
#msgMantenimiento{border:#000 solid thin;background-color:#999;height:250px;width:800px;position:absolute;left:50%;top:50%;margin-left:-400px;margin-top:-125px;z-index:3;}
-->
</style>
</head>

<body>
<?php
	function mensaje($comentario){
		echo "<div id='msgMantenimiento'><div style='height:20px; color:#FFFFFF; background:#000000; font-size:12px;'><div style='float:left;'>IQe Sisco Nextel Refurbish</div></div><div style='margin:4px; background:#FFFFFF; overflow:auto; height:220px;'><br /><span style='margin-left:10px;'><img src='img/alert.png' border='0' />&nbsp;$comentario</span></div></div>";
	}
?>
</body>
</html>