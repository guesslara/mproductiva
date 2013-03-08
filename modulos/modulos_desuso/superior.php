<?
	session_start();
	/*if(!session_is_registered('usuarios_nextel')){
		echo "<center><strong>Su sesi&oacute;n ha caducado, ingrese de nueva cuenta al sistema.</strong><br><br></center>";
		exit;
	}*/
	include("../includes/config.inc.php");
	include("../includes/conectarbase.php");
	$sql_usuarioX="select sexo from userdbnextel where id='".$_SESSION['id_usuario']."'";
	$result_usuarioX=mysql_db_query($db,$sql_usuarioX);
	$fila_usuarioX=mysql_fetch_array($result_usuarioX);
	if($fila_usuarioX['sexo']=="M"){
		$img="../img/User-male-32.png";
	}else if($fila_usuarioX['sexo']=="F"){
		$img="../img/User-female-32.png";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../css/superior.css" />
<link type="text/css" href="../clases/jquery-ui/css/smoothness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
<style type="text/css">
<!--
html,body{margin:0px; font-family:Verdana, Geneva, sans-serif; overflow:hidden; background:#FFF;}
.optHabilitado{background-color:#FFF;}
.barraMenu{height:25px; width:100%; overflow:hidden;border:1px solid #999; background:#CCC; font-size:10px;font: bold 10px/1.5em Verdana;}
.botonesBarraIzq{float:left;width:80px; height:20px; margin-top:2px; border:1px solid #999; margin-left:1px; text-align:center; cursor:pointer;}
.botonesBarraIzq:hover{ background:#FFF;}
.barraTitulo{height:20px; background:#000; color:#FFF; font-size:10px; bold 10px/1.5em Verdana;}
.barraHerramientas{height:20px; width:100%; overflow:hidden;border:1px solid #CCC; background:#CCC; font-size:10px;font: bold 10px/1.5em Verdana;}
.textoBarraTitulo{float:left;}
.btnCerrarApp{float:right;}
-->
</style>
<title>Documento sin título</title>
<script type="text/javascript" src="../clases/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../clases/jquery.hotkeys-0.7.9.min.js"></script>
<script type="text/javascript" src="../clases/jquery-ui/js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript">
	$(function(){
		// Dialog			
		$('#dialog').dialog({
			autoOpen: false,
			width: 600,
			buttons: {
				"Ok": function() { 
				$(this).dialog("close"); 
			}, 
				"Cancel": function() { 
				$(this).dialog("close"); 
			}			
			},
			modal:true
		});
				
		// Dialog Link
		$('#dialog_link').click(function(){
			$('#dialog').dialog('open');
			return false;
		});
	});
	
	$(document).bind('keydown', 'f1',function (evt){jQuery('#_f1').addClass('dirty'); return false; });
    $(document).bind('keydown', 'f2',function (evt){jQuery('#_f2').addClass('dirty'); return false; });
    $(document).bind('keydown', 'f3',function (evt){jQuery('#_f3').addClass('dirty'); return false; });
    $(document).bind('keydown', 'f4',function (evt){jQuery('#_f4').addClass('dirty'); return false; });
    $(document).bind('keydown', 'f5',function (evt){jQuery('#_f5').addClass('dirty'); return false; });
    $(document).bind('keydown', 'f6',function (evt){jQuery('#_f6').addClass('dirty'); return false; });
    $(document).bind('keydown', 'f7',function (evt){jQuery('#_f7').addClass('dirty'); return false; });
	
	function encima(elemento,opcion){
		if(opcion != 1){
			document.getElementById(elemento).style.backgroundColor="#FFF";
		}else{
			document.getElementById(elemento).style.backgroundColor="FF0000";
			document.getElementById(elemento).style.color="#FFF";
		}
	}
	function fuera(elemento,opcion){
		if(opcion != 1){
			document.getElementById(elemento).style.backgroundColor="#CCC";
		}else{
			document.getElementById(elemento).style.backgroundColor="#FFF";
			document.getElementById(elemento).style.color="#000";
		}
	}
	//window.parent.frames[0].location="nueva_url.html" 
	function abrirVentana(modulo){
		switch(modulo){
			case "recibo":
				window.parent.frames[1].location="mod_recibo/index.php?<?=$SID;?>";
			break;
			case "desensamble":
				window.parent.frames[1].location="mod_des/index.php?<?=$SID;?>";
			break;
			case "configuracion":
				window.parent.frames[1].location="mod_conf/index.php?<?=$SID;?>";
			break;
		}			
	}
</script>
</head>

<body>
<!-- CSS Tabs -->
<!--<div id="tabsB">
	<ul>    
    <li id="Inicio"><a href="mod_inicio/index.php?<?=$SID;?>" target="contenido" onclick="verificaClick('Inicio')"><span>Inicio</span></a></li>
    <li id="Recibo"><a href="mod_recibo/index.php?<?=$SID;?>" target="contenido" onclick="verificaClick('Recibo')"><span>Recibo</span></a></li>
    <li id="Desensamble"><a href="mod_des/index.php?<?=$SID;?>" target="contenido" onclick="verificaClick('Desensamble')"><span>Desensamble</span></a></li>
    <li id="Ensamble"><a href="mod_des/index.php?<?=$SID;?>" target="contenido" onclick="verificaClick('Ensamble')"><span>Ensamble</span></a></li>
    <li id="Calidad"><a href="mod_des/index.php?<?=$SID;?>" target="contenido" onclick="verificaClick('Calidad')"><span>Calidad</span></a></li>
    <li id="Despacho"><a href="mod_des/index.php?<?=$SID;?>" target="contenido" onclick="verificaClick('Despacho')"><span>Despacho</span></a></li>    
    <li id="Forecast"><a href="mod_forecast/index.php?<?=$SID;?>" target="contenido" onclick="verificaClick('Forecast')"><span>Planificador</span></a></li>
    <li id="Configuracion"><a href="mod_conf/index.php?<?=$SID;?>" target="contenido" onclick="verificaClick('Configuracion')"><span>Configuración</span></a></li>
    <li id="Salir"><a href="cerrar_sesion.php?<?=$SID;?>" title="Finalizar Sesión" target="_parent"><span><strong>Cerrar Sesi&oacute;n</strong></span></a></li>
	</ul>
</div>-->
<div class="barraTitulo">
    <div class="textoBarraTitulo">IQe. Sisco Ingenier&iacute;a Nextel - Refurbish</div>
    <div class="btnCerrarApp"><a href="#" id="dialog_link" title="Cerrar Sesi&oacute;n" target="_parent"><img src="../img/tb_close.gif" border="0" /></a></div>
</div>
<div class="barraMenu">
    <div id="inicio" class="botonesBarraIzq">Inicio</div>
    <div id="recibo" class="botonesBarraIzq" onclick="abrirVentana('recibo')">Recibo</div>
    <div id="desensamble" class="botonesBarraIzq" onclick="abrirVentana('desensamble')">Desensamble</div>
    <div id="ensamble" class="botonesBarraIzq">Ensamble</div>
    <div id="calidad" class="botonesBarraIzq">Calidad</div>
    <div id="despacho" class="botonesBarraIzq">Despacho</div>
    <div id="planificador" class="botonesBarraIzq">Planificador</div>
    <div id="configuracion" class="botonesBarraIzq" onclick="abrirVentana('configuracion')">Configuraci&oacute;n</div>        
</div>
<div class="barraHerramientas"></div>
<!-- ui-dialog -->
		<div id="dialog" title="Dialog Title">
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
		</div>
</body>
</html>