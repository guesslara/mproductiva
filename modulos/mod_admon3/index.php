<?
	session_start();
	session_regenerate_id(true);
	include("../../includes/txtApp.php");
	include("../../clases/regLog.php");
	$objLog=new regLog();
	$objLog->consulta($_SESSION[$txtApp['session']['loginUsuario']],date("Y-m-d"),date("H:i:s"),$_SERVER['REMOTE_ADDR'],"ADMINISTRACION",$_SESSION[$txtApp['session']['origenSistemaUsuario']]);
	if(!isset($_SESSION[$txtApp['session']['idUsuario']])){
		echo "<script type='text/javascript'> alert('Su sesion ha terminado por inactividad'); window.location.href='../mod_login/index.php'; </script>";
		exit;
	}
?>
<script type="text/javascript" src="../../clases/jquery-1.3.2.min.js" ></script>
<script type="text/javascript"  src="js/funciones.js" ></script>
<script type="text/javascript">
	$(document).ready(function(){
		redimensionarAdmin();
	});
	function redimensionarAdmin(){
		anchoDoc=$("#contenedorAdmin").width();
		anchoDoc=parseInt(anchoDoc)-270;
		$("#detalleUsuarios").css("width",anchoDoc);
		//document.getElementById("detalleUsuarios").style.width=anchoDoc+"px";
	}
	window.onresize=redimensionarAdmin;
</script>
<style type="text/css">
<!--
html,document,body{ position:absolute;height:100%; width:100%; margin:0px; font-family:Verdana, Geneva, sans-serif; overflow:hidden; background:#999;}
a {
	font-size: 10px;
	color: #09F;
}
a:visited {
	color: #09F;
}
a:hover {
	color: #0CF;
}
a:active {
	color: #09F;
}
li{margin-bottom:7px;}
#contenedor{ margin:3px;height:100%; width:100%; overflow:hidden; margin:0px; border:1px solid #000;}
#menuLateral{width:15%; height:99%; border:1px solid #000; background:#F0F0F0; float:left; overflow:auto;}
#menuArbol{height:99.5%; width:99%; overflow:auto;}
#contenidoApp{float:left; width:84%; height:99%; }
body{font-family:Verdana, Geneva, sans-serif; font-size:11px;}
#msgCargador{border:1px solid #CCC;background-color:#FFF;height:50px;width:50px;position:absolute;left:50%;top:50%;margin-left:-25px;margin-top:-25px;z-index:4;}
#msgListaUsuarios{border:#000 solid thin;background-color:#999;height:500px;width:800px;position:absolute;left:50%;top:50%;margin-left:-400px;margin-top:-250px;z-index:3;}
#msgModificaUsuarios{border:#000 solid thin;background-color:#999;height:400px;width:800px;position:absolute;left:50%;top:50%;margin-left:-400px;margin-top:-200px;z-index:3;}
#msgResetPass{border:#000 solid thin;background-color:#999;height:200px;width:400px;position:absolute;left:50%;top:50%;margin-left:-200px;margin-top:-100px;z-index:3;}
#msgNipUsuario{border:#000 solid thin;background-color:#999;height:200px;width:400px;position:absolute;left:50%;top:50%;margin-left:-200px;margin-top:-100px;z-index:3;}
.mantenimiento{border:#000 solid thin;background-color:#999;height:200px;width:400px;position:absolute;left:50%;top:50%;margin-left:-200px;margin-top:-100px;z-index:3;}
.fuente12{ font-size:12px;}
#tituloOpcion{ font-weight:bold;}
-->
</style>
<!--
<div id="contenedor">
    <div id="menuLateral">
    	<div id="menuArbol">
        <h4>Administraci&oacute;n:</h4>
            <ul>
                <li id="tituloOpcion" class="fuente12">Usuarios:</li>
                <ul>
                    <li class="fuente12"><a href="javascript:nuevoUsuario()">Agregar Usuario</a></li>
                    <li class="fuente12"><a href="javascript:consultarUsuarios('act','nombre')">Usuarios Activos</a></li>
                    <li class="fuente12"><a href="javascript:consultarUsuarios('ina','nombre')">Usuarios Inactivos</a></li>  
                    </ul>
                     <li id="tituloOpcion" class="fuente12"><a href="javascript:Buscador()" class="fuente12" style=" color:#000; text-decoration:none;">Buscar Usuario</a></li>
                <input type="text" name="txtBuscar" id="txtBuscar" onkeyup="Buscador()" style="width:150px; font-size:14px; color:#000;"  /><br />
                <input type="radio" name="rdbBusqueda" id="rdbBusqueda" value="nombre" checked="checked" />
						Por Nombre <input type="radio" name="rdbBusqueda" id="rdbBusqueda" value="usuario" />Por usuario   
                             
                </ul>
                <ul>
                <li id="tituloOpcion" class="fuente12">Grupos</li>
                <ul>
                
                    <li class="fuente12"><a href="javascript:addGrupo()">Agregar Grupo</a></li>
                    <li class="fuente12"><a href="javascript:consultaGrupos()">Consultar Grupos</a></li>
                    <li class="fuente12"><a href="javascript:nuevaFuncionalidad()">A&ntilde;adir Funcionalidades</a></li>
                </ul>
                <li id="tituloOpcion" class="fuente12">Configuraci&oacute;n</li>
                        <ul>
                            <li class="fuente12"><a href="javascript:manttoSistema('sitio_desactivado')">Mantenimiento</a></li>
                            
                            <li class="fuente12"><a href="javascript:controlCambios()">Actualizaciones</a></li>
                                <ul>
                                    <li class="fuente12"><a href="javascript:consultaAct()">Listar Actualizaciones</a></li>	
                                </ul>
                                </ul>
                                <li id="tituloOpcion" class="fuente12">Cat&aacute;logos</li>
                <ul>
                	<li  class="fuente12"><a href="javascript:nuevoProceso()">Cat. Procesos</a></li>
						<ul>
							<li class="fuente12"><a href="javascript:consulta()">Listar Procesos</a></li>
						</ul>
                    <li class="fuente12"><a href="javascript:nuevoModelo()">Cat. Modelo</a></li>
						<ul>
							<li class="fuente12"><a href="javascript:consultaModelo()">Listar Modelo</a></li>
						</ul>
                    <li class="fuente12"><a href="javascript:nuevafalla()">Cat. Fallas</a></li>
						<ul>
							<li class="fuente12"><a href="javascript:consultafalla()">Listar Fallas</a></li>
						</ul>
                </ul>
        </ul>
            </ul>
        </div>
    </div>
    <div id="contenidoApp">    	
		<div id="detalleUsuarios" style="width:99.8%; height:99.8%; background:#FFF; border:1px solid #000; overflow:auto;">

		</div>
        <div id="consultaUsuarios"></div>
        <div id="modificaUsuario"></div>
        <div id="nip"></div>
        <div id="resetPass"></div>
        <div id="eliminaUsuario"></div>
        <div id="addGrupo"></div>
        
	</div>
</div>
-->
<div id="contenedorAdmin" style="position: absolute;width: 99.5%;height: 98.5%;background: #CCC;border: 1px solid #000;margin: 2px;">
	<div id="contenedorIzquierdoAdmin" style="position: relative;float: left;width: 250px;height: 99%;background: #F0F0F0;margin: 2px;border: 1px solid #666;overflow: auto;">
		<div style="height: 20px;padding: 5px;background: #e1e1e1;font-weight: bold;text-align: center;">Administraci&oacute;n</div>
		<div style="height: 150px;padding: 5px;background: #fff;font-weight: bold;text-align: left;border: 1px solid #666;">Usuarios:
			<div style="height: 15px;padding: 3px;"><a href="javascript:nuevoUsuario()">Agregar Usuario</a></div>
			<div style="height: 15px;padding: 3px;"><a href="javascript:consultarUsuarios('act','nombre')">Usuarios Activos</a></div>
			<div style="height: 15px;padding: 3px;"><a href="javascript:consultarUsuarios('ina','nombre')">Usuarios Inactivos</a></div>
			Buscar Usuario:
			<input type="text" name="txtBuscar" id="txtBuscar" onkeyup="Buscador()" style="width:150px; font-size:14px; color:#000;"  /><br />
			<input type="radio" name="rdbBusqueda" id="rdbBusqueda" value="nombre" checked="checked" />Por Nombre
			<input type="radio" name="rdbBusqueda" id="rdbBusqueda" value="usuario" />Por usuario
		</div>
		<div style="height: 125px;padding: 5px;background: #fff;font-weight: bold;text-align: left;margin-top: 5px;border: 1px solid #666;">Grupos:
			<div style="height: 15px;padding: 3px;margin-top: 5px;"><a href="javascript:addGrupo()">Agregar Grupo</a></div>
			<div style="height: 15px;padding: 3px;margin-left: 10px;"><a href="javascript:consultaGrupos()">Consultar Grupos</a></div>
			<!--<div style="height: 15px;padding: 3px;"><a href="javascript:nuevaFuncionalidad()">Agregar Men&uacute;</a></div>
			<div style="height: 15px;padding: 3px;margin-left: 10px;"><a href="javascript:agregarSubMenu()">Men&uacute;s:</a></div>-->
			<div style="height: 15px;padding: 3px;"><a href="javascript:mostrarOpcionesMenu()">Men&uacute;s:</a></div>
			<div style="height: 15px;padding: 3px;"><a href="javascript:verModulos()">Ver Modulos:</a></div>
		</div>
		<div style="height:120px;padding: 5px;background: #fff;font-weight: bold;text-align: left;margin-top: 5px;border: 1px solid #666;">Configuraci&oacute;n:
			<div style="height: 15px;padding: 3px;margin-top: 5px;"><a href="javascript:manttoSistema('sitio_desactivado')">Mantenimiento del Sistema</a></div>
                        <div style="height: 15px;padding: 3px;"><a href="javascript:controlCambios()">Agregar Actualizaciones</a></div>
                        <div style="height: 15px;padding: 3px;margin-left: 10px;"><a href="javascript:consultaAct()">Listar Actualizaciones</a></div>
			<div style="height: 15px;padding: 3px;"><a href="javascript:agregarConfiguracion()">Agregar Configuracion</a></div>
			<div style="height: 15px;padding: 3px;margin-left: 10px;"><a href="javascript:configuracionesGlobales()">Configuraciones globales</a></div>			
		</div>
                <!--<div style="height: 150px;padding: 5px;background: #fff;font-weight: bold;text-align: left;margin-top: 5px;border: 1px solid #666;">Cat&aacute;logos
			<div style="height: 15px;padding: 3px;margin-top: 5px;"><a href="javascript:nuevoProceso()">Cat. Procesos</a></div>
			<div style="height: 15px;padding: 3px;margin-left: 10px;"><a href="javascript:consulta()">Listar Procesos</a></div>
			<div style="height: 15px;padding: 3px;"><a href="javascript:nuevoModelo()">Cat. Modelo</a></div>
			<div style="height: 15px;padding: 3px;margin-left: 10px;"><a href="javascript:consultaModelo()">Listar Modelo</a></div>
			<div style="height: 15px;padding: 3px;"><a href="javascript:nuevafalla()">Cat. Fallas</a></div>
			<div style="height: 15px;padding: 3px;margin-left: 10px;"><a href="javascript:consultafalla()">Listar Fallas</a></div>
		</div>-->
	</div>
	<div id="detalleUsuarios" style="position: relative;float: left;height: 99%;background: #FFF;margin: 2px;border: 1px solid #666;overflow: auto;"></div>
	<div id="consultaUsuarios"></div>
        <div id="modificaUsuario"></div>
        <div id="nip"></div>
        <div id="resetPass"></div>
        <div id="eliminaUsuario"></div>
        <div id="addGrupo"></div>
</div>
<div id="cargando" style=" display:none;position: absolute; left: 0; top: 0; width: 100%; height: 100%; background: url(../../img/desv.png) repeat;">
	<div id="msgCargador"><div style="padding:6px;">&nbsp;<img src="../../img/cargador.gif" border="0" /></div></div>
</div>