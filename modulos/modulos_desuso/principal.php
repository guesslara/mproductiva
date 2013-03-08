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
<link rel="stylesheet" type="text/css" href="../css/menuTab.css" />
<script type="text/javascript" src="../js/principal.js"></script>
<script type="text/javascript" src="../clases/jquery.js"></script>
<script type="text/javascript" src="mod_forecast/js/funciones.js"></script>
</head>

<body onload="inicio()" onresize="inicio()">
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="tablaContenedor">
    <tr>
    <td>
<div id="tabsB">
	<ul>
    <!-- CSS Tabs -->
    <li><a href="prueba.htm"><span>Inicio</span></a></li>
    <li><a href="recibo.htm"><span>Recibo</span></a></li>
    <li><a href="des.htm"><span>Desensamble</span></a></li>
    <li><a href="ens.htm"><span>Ensamble</span></a></li>
    <li><a href="cal.htm"><span>Calidad</span></a></li>
    <li><a href="emp.htm"><span>Empaque</span></a></li>
    <li><a href="conf.htm"><span>Configuración</span></a></li>
    <li><a href="javascript:planificador()"><span>Planificador</span></a></li>
	</ul>
</div>
	</td>
    </tr>
    <tr>
    <td>
<div id="contenedorNx" style=" border:1px solid #000;z-index:1; overflow:auto; position:relative; height:99%; width:99%;">
<table width="497" border="0">
  <tr>
    <td width="62"><img src="../img/images.jpeg" width="50" height="50" longdesc="informacion" /></td>
    <td width="419">Haga Clic en la Tarea que desea Revisar</td>					
  </tr>
</table>
</div>
	</td>
    </tr>
    <tr>
    	<td><hr color="#990000" /></td>
    </tr>
</table>    
</body>
</html>