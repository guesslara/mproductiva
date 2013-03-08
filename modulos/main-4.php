<?php
    session_start();
    session_regenerate_id(true);    
    if($_SERVER['HTTP_REFERER']==""){
	header("Location: mod_login/index.php");
	exit;
    }    
    include("../clases/permisosUsuario.php");
    include("../clases/cargaInicial.php");
    include("../clases/cargaActualizaciones.php");
    include("../clases/funcionesGUI.php");
    include("../includes/txtApp.php");
    if($_SESSION[$txtApp['session']['idUsuario']] != true){
	$_SESSION=array();
	session_unset();
	session_destroy();
	$parametros_cookies = session_get_cookie_params();
	setcookie(session_name(),0,1,$parametros_cookies["path"]);
	header("Location: mod_login/index.php");
	exit;
    }
    if(!isset($_SESSION[$txtApp['session']['idUsuario']])){
	header("Location: cerrar_sesion.php?<?=$SID;?>");
	exit;
    }    
    $objFuncionesGUI=new funcionesInterfazPrincipal();
    $objActualizaciones= new verificaActualizaciones();
    $objCargaInicial=new verificaCargaInicial();
    $objPermisos = new permisosUsuario();    
    $numeroActualizaciones=$objFuncionesGUI->buscaActualizacionesNuevas();
    $objActualizaciones->verificaActualizacionesSistema();
    $objCargaInicial->verificaPassword($_SESSION[$txtApp['session']['cambiarPassUsuario']]);
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
		contenedorPrincipal();
	});
	ClosingVar =true
	//window.onbeforeunload = ExitCheck;
	function ExitCheck(){  
		///control de cerrar la ventana///
	 	if(ClosingVar == true){
			ExitCheck = false
			return "<?=$txtApp['mensajeError']['salirApp'];?>";
	  	}
	}	
	setInterval(vMantto,10000);
        setInterval(vActNuevas,10000);
	window.onresize=contenedorPrincipal;
        function contenedorPrincipal(){
            var altoDoc=$("#contenedorAppMain").height();
            document.getElementById("contenedorVentanaMDI").style.height=(altoDoc-97)+"px";
        }
	var fullscreenElement = document.fullScreenElement || document.mozFullScreenElement || document.webkitFullScreenElement;
	var fullscreenEnabled = document.fullScreenEnabled || document.mozScreenEnabled || document.webkitScreenEnabled;
	
	// Encuentra el método correcto, llama al elemento correcto
	function launchFullScreen(element) {
	  if(element.requestFullScreen) {
	    element.requestFullScreen();
	  } else if(element.mozRequestFullScreen) {
	    element.mozRequestFullScreen();
	  } else if(element.webkitRequestFullScreen) {
	    element.webkitRequestFullScreen();
	  }
	}

	function cancelFullscreen() {
	  if(document.cancelFullScreen) {
	    document.cancelFullScreen();
	  } else if(document.mozCancelFullScreen) {
	    document.mozCancelFullScreen();
	  } else if(document.webkitCancelFullScreen) {
	    document.webkitCancelFullScreen();
	  }
	}
	
	cancelFullscreen();
	function cambiarModo(){
	    launchFullScreen(document.documentElement);
	}
	
	function verificaSesion(){
	    ajaxApp("verificaMantto","verificarSesion.php","","POST");
	}
</script>
</head>
<style type="text/css">
#contenedorAppMain{position: absolute;height: 99%;width: 99.6%;border: 1px solid #000;background: #CCC;margin: 2px;}
#barraHerramientasUsuario{position: relative;height: 30px;padding: 5px;background: #000;color: #FFF;border: 1px solid #000;}
.estiloMensajeModulo{float: left;border: 0px solid #ff0000;font-size: 14px;margin-top: 5px;}
.iconoUsuarioApp{float: right;height: 32.5px; width: 32px;border: 0px solid red;margin-top: -4px;}
.iconoUsuarioAppCerrar{float: right;height: 32.5px; width: 32px;border: 0px solid red;margin-top: -4px;text-align: center;}
.datosUsuarioAppPrincipal{float: right;border: 0px solid #ff0000;height: 18px;padding: 8px;font-size: 12px;margin-top: -4px;}
#datosUsuarioAppPrincipal{position: relative;border: 0px solid blue; width: 99.8%; height: 50%;}
.contenedorVentanaMDIApp{background: #FFF; width:99.8%; height: 99.3%; overflow:auto;border: 0px solid #ff0000;z-index: }
#barraestado2{position: absolute;padding: 4px;bottom: 1px;height: 20px;width: 99.2%;border: 1px solid #000;background: #666;}
#contenedorBug{position:absolute; height:26px; width:120px; z-index:2000; right:4px; font-weight:bold; border:0px solid #666; padding:4px;bottom:0px;}
.estiloDivContenedor{padding:4px;width:93%; height:16px;background:#FFF;color:#000;font-weight:bold; margin:4px;border:1px solid #000;text-align:center;}
#frmContenedorBug{position:absolute;width:400px;height:270px;right:0px;border:1px solid #000;background:#f0f0f0;bottom:34px;display:none;font-size: 10px;}
#divFormularioBug{background:#FFF;border:1px solid #CCC;margin:2px;width:98%;height:98%;overflow:auto;font-size: 10px;}
#listadoActualizacionesApp{position: absolute;text-align: left;font-weight: bold;border: 0px solid #000;background: #FFF;height: 15px;padding: 3px;width: 120px;right: 257px;margin-top: 0px;}
.estiloCargadorApp{position: absolute;text-align: right;font-weight: bold;border: 1px solid #000;background: #CCC;height: 15px;padding: 3px;width: 120px;right: 126px;margin-top: -1px;}
.estiloTextoActualizaciones{color:#red;font-weight: bold;}
.estiloPantallaCompleta{position: absolute;width: 150px;margin-top: -2px;}
.estiloPantallaCompleta:hover{border: 1px solid #CCC;cursor: pointer;}
.estiloDivIzqPCompleta{float: left;}
.estiloDivDerPCompleta{margin-top: 5px;margin-left: 4px;font-weight: bold;float: left;}
</style>
<body>
    <div id="contenedorAppMain">
        <div id="barraHerramientasUsuario">
            <div class="estiloMensajeModulo"><? echo $txtApp['appPrincipal']['msgModulo'];?></div>            
            <div class="iconoUsuarioAppCerrar"><a href="cerrar_sesion.php?<?=$SID;?>" id="" title="<?=$txtApp['appPrincipal']['cerrarSesion'];?>" ><img src="../img/shutdown1.png" border="0" width="35" height="36" /></a></div>
            <div class="iconoUsuarioApp">&nbsp;</div>
            <div class="datosUsuarioAppPrincipal"><?=$_SESSION[$txtApp['session']['nombreUsuario']]." ".$_SESSION[$txtApp['session']['apellidoUsuario']];?></div>
        </div>
        <div id="menu" class="barraMenu" style="z-index: 50;height: 25px;">
<?          $objPermisos->construyeMenuNuevo($_SESSION[$txtApp['session']['idUsuario']]);?>            
        </div>
        <div id="contenedorVentanaMDI">
            <iframe id="contenedorVentana" name="contenedorVentana" class="contenedorVentanaMDIApp"></iframe>
        </div>
        <div id="barraestado2">
	    <div onclick="cambiarModo()" class="estiloPantallaCompleta"><div class="estiloDivIzqPCompleta"><img src="../img/ampliar.jpg" border="0" width="32" height="25"></div><div class="estiloDivDerPCompleta">Pantalla Completa</div></div>
            <div id="contenedorBug">
		<div id="id" class="estiloDivContenedor">
			<a href="#" onclick="abrirFormBug()" title="<?=$txtApp['appPrincipal']['msgReportarError'];?>" style="color:blue;text-decoration: none;"><?=$txtApp['appPrincipal']['msgReportarError'];?></a>
		</div>
		<div id="frmContenedorBug"><div id="divFormularioBug"></div></div>
            </div>
            <div id="listadoActualizacionesApp"><a href="mod_controlCambios/index.php" target="_blank" style="color: blue;text-decoration: none;"><?=$txtApp['appPrincipal']['msgActualizaciones'];?> <strong><span id="numeroActualizacionesActuales" class="estiloTextoActualizaciones"><?=$numeroActualizaciones;?></span></a></strong></div>
            <div id="cargadorApp" class="estiloCargadorApp"><?=$txtApp['appPrincipal']['msgBarraCarga'];?></div>
        </div>
	<div id="verificaMantto"></div>
    </div>
<script type="text/javascript">
    setInterval(verificaSesion,1320000);//1140000
</script>   
</body>
</html>