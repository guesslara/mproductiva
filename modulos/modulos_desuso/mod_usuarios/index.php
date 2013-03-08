<script type="text/javascript" src="js/usuarios.js"></script>
<style type="text/css">
<!--
body{font-family:Verdana, Geneva, sans-serif; margin:0px;}
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
li{margin-bottom:3px;}
-->
</style>

<div style="margin:5px 2px 5px 5px; background:#FFF; border:1px solid #CCC; font-size:10px; height:98%; width:19%; float:left;">
    <div style="padding:2px;">
    <h4>Administraci&oacute;n</h4>
    <ul>
    	<li class="fuente12">Usuarios:</li>
        <ul>
        	<li class="fuente12"><a href="javascript:nuevoUsuario()">Agregar Usuario</a></li>
            <li class="fuente12"><a href="javascript:consultarUsuarios('act')">Usuarios Activos</a></li>
            <li class="fuente12"><a href="javascript:consultarUsuarios('ina')">Usuarios Inactivos</a></li>            
        </ul>
        <li class="fuente12">Grupos</li>
        <ul>
        	<li class="fuente12"><a href="javascript:addGrupo()">Agregar Grupo</a></li>
            <li class="fuente12"><a href="javascript:consultaGrupos()">Consultar Grupos</a></li>
        </ul>
    </ul>
    </div>
</div>
<div id="detalleUsuarios" style="margin:5px 2px 5px 5px; background:#FFF; border:1px solid #CCC; font-size:14px; height:98%; width:77%; float:left; overflow:auto;"></div>
	<div id="consultaUsuarios"></div>
    <div id="modificaUsuario"></div>
    <div id="nip"></div>
    <div id="resetPass"></div>
    <div id="eliminaUsuario"></div>
    <div id="addGrupo"></div>
<div id="cargando" style=" display:none;position: absolute; left: 0; top: 0; width: 100%; height: 100%; background: url(../img/desv.png) repeat">
	<div id="msgCargador"><div style="padding:15px;">Cargando, informaci&oacute;n&nbsp;<img src="../img/cargador.gif" border="0" /></div></div>
</div>    