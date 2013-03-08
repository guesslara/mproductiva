<?
	session_start();
	//echo $_SESSION['nombre']." ".$_SESSION['apellido'];
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
<title>IQe Sisco Usuario: <?=$_SESSION['nombre']." ".$_SESSION['apellido'];?> - - Ingenier&iacute;a Nextel Refurbish</title>
<link rel="icon" href="../img/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon" />
</head>
<frameset rows="68,*" cols="*" framespacing="0" border="0" frameborder="0">                  
  <frame name="control" src="superior.php?<?=$SID?>" scrolling="no" noresize="noresize">
  <frame name="contenido" target="contenido" src="contenido.php?<?=$SID?>" >  
</frameset><noframes>
  <p>Esta página utiliza marcos, pero su explorador no las admite.</p>
  </noframes>
</html>