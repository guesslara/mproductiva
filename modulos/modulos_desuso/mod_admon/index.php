<script type="text/javascript" src="../../clases/jquery-1.3.2.min.js" ></script>
<script type="text/javascript"  src="js/funciones.js" ></script>
<style type="text/css">
<!--
html,document,body{ position:absolute;height:100%; width:100%; margin:0px; font-family:Verdana, Geneva, sans-serif; overflow:hidden; background:#999;}
a {font-size: 10px;color: #09F;}
a:visited {color: #09F;}
a:hover {color: #0CF;}
a:active {color: #09F;}
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
                            <!--<li class="fuente12"><a href="javascript:manttoSistema('sitio_desactivado_Req')">Mantenimiento Requisiciones</a></li>-->
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
<div id="cargando" style=" display:none;position: absolute; left: 0; top: 0; width: 100%; height: 100%; background: url(../../img/desv.png) repeat;">
	<div id="msgCargador"><div style="padding:6px;">&nbsp;<img src="../../img/cargador.gif" border="0" /></div></div>
</div>