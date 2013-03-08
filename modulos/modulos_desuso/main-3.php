<?
	session_start();
	if(!isset($_SESSION['id_usuario_n'])){				
		header("Location: cerrar_sesion.php?<?=$SID;?>");
		exit;
	}
	include("../clases/permisosUsuario.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="../css/main.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="../css/main.css" />
<title>Escritorio: Ing. Nextel Refurbish. Usuario:<?=$_SESSION['nombre_n']." ".$_SESSION['apellido_n'];?></title>
<script type="text/javascript" src="../clases/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/funcionesMain.js"></script>
<style type="text/css">
html,body,document{margin:1px; height:100%; font-size:10px; background:#999;}
#contenedorPrincipal1{height:99%; width:99.5%; background:#999; border:1px solid #000;}
#menuBar1{/*height:3.5%;*/ height:30px; background:#CCC; border-bottom:1px solid #999; font-size:10px; font-weight:bold;}
#barraHerramientas1{/*height:2.5%;*/ height:25px; background:#CCC;}
#contenedorVentana1{background:#FFF; border:1px solid #000; overflow:auto; height:95%;}
#barraEstado1{height:15px; background:#000;}
</style>
</head>

<body>
<div id="contenedorPrincipal1">
	<div id="menuBar1">
<?
		//modificacion para cargar el perfil del usuario en el menu		
		$objPermisos = new permisosUsuario();	
		$elementosMenu=$objPermisos->construyeMenu($_SESSION['id_usuario_n']);
		for($i=0;$i<count($elementosMenu);$i++){
?>
			<script type="text/javascript"> verificarScriptsApp('<?=$elementosMenu[$i];?>'); </script>
<?		
		}
?>
        <!--boton de Cerrar-->      
        <div class="btnCerrarApp"><a href="cerrar_sesion.php?<?=$SID;?>" id="" title="Cerrar Sesion" ><img src="../img/tb_close.gif" border="0" /></a></div> 		
	</div>
    <!--<div id="barraHerramientas1"></div>-->
    	
    <div id="contenedorVentana1">
	<iframe id="detalleDirsMarcadores" name="detalleDirsMarcadores" style="width:99.5%; height:96%; background:#FFF; border:1px solid #FFF; overflow:auto;">
                <p>Your browser does not support iframes.</p>
        </iframe>
    </div>
    <div id="barraEstado1"></div>
</div>
</body>
</html>