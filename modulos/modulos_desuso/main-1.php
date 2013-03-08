<?
	session_start();
	include("../clases/claseFuncionesRecibo.php");
	$objRecibo=new funcionesRecibo();
	$contenidoDir=$objRecibo->leerDirectorioUsuario();	
	if($contenidoDir==0){
		//echo "cargar configuracion para el asistente";
		header("Location: mod_asist/index.php?".$SID."");
		exit;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
<!--
body{background:#CCC; margin:0px;}
-->
</style>
<title>IQe Sisco Usuario: <?=$_SESSION['nombre']." ".$_SESSION['apellido'];?> - - Ingenier&iacute;a Nextel Refurbish</title>
</head>
<frameset rows="67,*,15" cols="*" framespacing="1" frameborder="yes" border="1" ID="framesetOuter">
  <frame src="superior.php?<?=$SID?>" name="ToolBar" id="ToolBar" frameborder="0" scrolling="No" noresize="noresize" marginwidth="0" marginheight="0">
  <frame src="contenido.php?<?=$SID?>" name="contenido" id="Files" application="" frameborder="0" scrolling="Auto" marginwidth="0" marginheight="0">  
  <frame src="informacion.php" name="Resume" id="Resume" frameborder="0" scrolling="No" noresize="noresize" marginwidth="0" marginheight="0">
</frameset><noframes></noframes>
</html>