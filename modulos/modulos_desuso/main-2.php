<?
	session_start();
	include("../clases/permisosUsuario.php");
	include("../clases/cargaInicial.php");
	include("../clases/cargaActualizaciones.php");
	include("../includes/txtApp.php");
	if(!isset($txtApp['session']['idUsuario'])){				
		header("Location: cerrar_sesion.php?<?=$SID;?>");
		exit;
	}	
	$objCargaInicial=new verificaCargaInicial();
	$objActualizaciones= new verificaActualizaciones();
	$objActualizaciones->verificaActualizacionesSistema();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="../css/main.css" rel="stylesheet" />
<link type="text/css" href="../clases/menu/estilosMenu.css" rel="stylesheet" />
<title><?=$txtApp['login']['tituloAppPrincipal'];?></title>
<script type="text/javascript" src="../clases/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/funcionesMain.js"></script>
<script type="text/javascript">	
	$(document).ready(function (){
		altoDoc=$(document).height();		
		contenedorPrincipal();
	});

	ClosingVar =true
	//window.onbeforeunload = ExitCheck;
	function ExitCheck(){  
		///control de cerrar la ventana///
	 	if(ClosingVar == true){
			ExitCheck = false
			return "Si decide continuar, se pueden perder los cambios que no haya Guardado.";
	  	}
	}	
	setInterval(vMantto,10000)
	window.onresize=contenedorPrincipal;
function contenedorPrincipal(){
	var altoDoc=$(document).height();
	//alert(altoDoc);
	document.getElementById("contenedorPrincipal").style.height=(altoDoc-10)+"px";
	document.getElementById("contenedorVentana").style.height=(altoDoc-80)+"px";
}
function abrirEstadistica(){
	$("#contenedorEstadistica").css("height","150px");
}
</script>
</head>

<body>
<div id="contenedorPrincipal" class="contenedorPrincipal">
    <div id="menu" class="barraMenu">
<?
		//modificacion para cargar el perfil del usuario en el menu		
		$objPermisos = new permisosUsuario();	
		$elementosMenu=$objPermisos->construyeMenu($_SESSION[$txtApp['session']['idUsuario']]);
?>
		<!--boton de Cerrar-->
		<div class="btnCerrarApp">
			<a href="cerrar_sesion.php?<?=$SID;?>" id="" title="Cerrar Sesion" ><img src="../img/tb_close.gif" border="0" /></a>
		</div>        
    </div>
    <!--<div class="barraMenu2"></div>-->
    <div style="position:absolute; height:23px; width:370px; background:#CCC; z-index:5; right:8px; font-weight:bold; border:1px solid #666; padding:4px;">
    	<a href="mod_consultas/multiconsulta2.php" target="_blank" title="Ir a la MulConsulta" style="color:blue;font-weight:bold;text-decoration:none;">Multiconsulta</a> | Buscar:
	<a href="#" onclick="mostrarFiltros()" title="Filtrar B&uacute;squeda" style="text-decoration:none;"><div style="border:1px solid #CCC;  width:27px; height:20px; background:#f0f0f0;float:right;text-align:center;"><img src="../img/Filtro.png" border="0" /></a></div>
		<div id="filtrosBusqueda" onmouseup="cerrarFiltros()" style="position:absolute;width:80px;height:80px;border:1px solid #000;background:#F0F0F0;right:4px;text-align:left;top:25px;z-index:80;display:none;">
			<div style="background:#FFF;padding:3px;">Filtro:</div><hr>
			<input id="filtroImei" name="filtroBusqueda" type="radio" value="imei" checked="checked"><label for="filtroImei">Imei</label><br>
			<input id="filtroSerie" name="filtroBusqueda" type="radio" value="serial"><label for="filtroSerie">Serial</label><br>
		</div>
		<input type="text" name="txtBusquedaImeiPrincipal" id="txtBusquedaImeiPrincipal" onkeypress="verificaTeclaImeiBusquedaPrincipal(event)" style="width:190px;" />
		<div id="divBusquedaPrincipal" style="position:absolute;right:0px;top:30px;width:700px;height:550px;background:#424242;border:1px solid #000; display:none; font-weight:normal;">
			<div id="divResultadosBusquedaPrincipal" style="background:#FFF;width:98.5%; height:94%;margin:5px;overflow:auto;">&nbsp;</div>
			<div style="text-align:center;"><input type="button" value="Cerrar Ventana" onclick="cerrarBusquedaPrincipal()" /></div>
		</div>
    </div>     
    <!--contenido de la ventana-->
    <!--<div id="contenedorVentana" class="contenedorVentana"></div>-->
<?	
	$objCargaInicial->verificaPassword($_SESSION[$txtApp['session']['cambiarPassUsuario']]);
?>    
    <iframe id="contenedorVentana" name="contenedorVentana"  style="/*background:#999;*/background: #FFF; width:99.5%; overflow:auto;border: 1px solid #ff0000;"></iframe>
    <!--<div id="contenedorEstadistica" style="position:absolute; height:32px; top:65px; width:300px; background:#FFF; z-index:6; right:8px; font-weight:bold; border:1px solid #666; padding:4px;">
	<div id="id" style="padding:5px; width:96%; height:20px;background:#CCC;color:#000;font-weight:bold; margin:0px;border:1px solid #000;">
		<a href="#" onclick="abrirEstadistica()">Ver estadistica</a>
	</div>
    </div>-->
    <!--fin del contenido de la ventana-->
    <!--<div id="barraEstado" class="barraEstado">
    	<div id="tituloBarraEstado" class="tituloBarraEstado">Modulo Actual - Carga Inicial / Usuario: <a href="../modulos/mod_profile/index.php?<?=$SID;?>" style="color:#000;text-decoration:none;" title="Ver Perfil" target="contenedorVentana"><?=$_SESSION['nombre_nx']." ".$_SESSION['apellido_nx'];?></a></div>
    	<div id="cargadorApp" class="cargadorApp">Listo</div>
    </div>-->
    <div id="barraestado2" style="position: absolute;padding: 4px;bottom: 3px;height: 30px;width: 98.7%;border: 1px solid #000;background: #CCC;">
	<div style="position:absolute;width: 300px;height: 28px;padding: 5px;border: 0px solid #000;">
		<div style="float: left;height: 20px;width: 40px;border: 1px solid #000;"></div>
		<div style="float: left;font-weight: bold;height: 20px;margin-left: 2px;width: 253px;border: 1px solid #f0f0f0;">Conectado como: <a href="../modulos/mod_profile/index.php?<?=$SID;?>" style="color:#000;text-decoration:none;" title="Ver Perfil" target="contenedorVentana"><?=$_SESSION['nombre_nx']." ".$_SESSION['apellido_nx'];?></a></div>
	</div>
	<div id="contenedorBug" style="position:absolute; height:26px; width:120px; z-index:2000; right:4px; font-weight:bold; border:0px solid #666; padding:4px;bottom:0px;">
		<div id="id" style="padding:2px;width:93%; height:20px;background:#FFF;color:#000;font-weight:bold; margin:0px;border:1px solid #000;text-align:center;">
			<a href="#" onclick="abrirFormBug()" title="Reportar Bug" style="color:blue;">Reportar Problema</a>
		</div>
		<div id="frmContenedorBug" style="position:absolute;width:400px;height:270px;right:0px;border:1px solid #000;background:#f0f0f0;bottom:34px;display:none;font-size: 10px;">
			<div id="divFormularioBug" style="background:#FFF;border:1px solid #CCC;margin:2px;width:98%;height:98%;overflow:auto;font-size: 10px;"></div>
		</div>
	</div>
	<div id="listadoActualizacionesApp" style="position: absolute;text-align: left;font-weight: bold;border: 0px solid #000;background: #FFF;height: 15px;padding: 3px;width: 120px;right: 270px;margin-top: 5px;">
		Actualizaciones <strong><span style="color:#red;font-weight: bold;">4</span></strong>
	</div>
	<div id="cargadorApp" style="position: absolute;text-align: right;font-weight: bold;border: 1px solid #000;background: #CCC;height: 15px;padding: 3px;width: 120px;right: 134px;margin-top: 5px;">
		Listo
	</div>
    </div>
    <div id="verificaMantto"></div>
</div>
<!--div para la ventana flotante-->
<div id="divVentanaFlotanteFuncional" class="ventanaDialogo" style="display:none;">
	<div id="barraTituloVentanaFlotanteFuncional" class="barraTitulo1VentanaDialogoValidacion">B&uacute;squeda de equipos<div id="btnCerrarVentanaDialogo"><a href="#" onclick="cerrarVentanaValidacion()" title="Cerrar Ventana"><img src="../img/close.gif" border="0" /></a></div></div>
	<div id="divContenidoVentanaFlotanteFuncional" style="border:1px solid #CCC; margin:4px; font-size:10px;height:93%; overflow:auto;"></div>
</div>
<!--fin div ventana flotante-->
</body>
</html>
