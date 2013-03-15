<?      
	/*session_start();
	session_regenerate_id(true);
	include("../../includes/txtApp.php");
	include("../../clases/regLog.php");
	$objLog=new regLog();
	$objLog->consulta($_SESSION[$txtApp['session']['loginUsuario']],date("Y-m-d"),date("H:i:s"),$_SERVER['REMOTE_ADDR'],"REGISTRO",$_SESSION[$txtApp['session']['origenSistemaUsuario']]);
	if(!isset($_SESSION[$txtApp['session']['idUsuario']])){
		echo "<script type='text/javascript'> alert('Su sesion ha terminado por inactividad'); window.location.href='../mod_login/index.php'; </script>";
		exit;
	}*/
?>
<script type="text/javascript" src="js/funciones.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<!--se incluyen los recursos para el grid-->
<script type="text/javascript" src="../../recursos/grid/grid.js"></script>
<link rel="stylesheet" type="text/css" href="../../recursos/grid/grid.css" />
<!--fin inclusion grid-->
<!--calendario-->
<link rel="stylesheet" type="text/css" media="all"  href="js/calendar-green.css"  title="win2k-cold-1" />
<!-- librería principal del calendario -->
<script type="text/javascript" src="js/calendar.js"></script>
<!-- librería para cargar el lenguaje deseado -->
<script type="text/javascript" src="js/calendar-es.js"></script>
<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
<script type="text/javascript" src="js/calendar-setup.js"></script>
<!--fin calendario-->
<link rel="stylesheet" type="text/css" media="all" href="css/estilos.css" />  
<script type="text/javascript">
	$(document).ready(function(){
		redimensionar();
		captura_actividad();
		abrir('buscarEmpleado','N/A')
	});	
	function redimensionar(){
		var altoDiv=$("#contenedorEnsamble3").height();
		var anchoDiv=$("#contenedorEnsamble3").width();
		var altoCuerpo=altoDiv-52;
		$("#muestraasignaciones").css("height",(altoCuerpo-10)+"px");
		$("#ventanaEnsambleContenido2").css("height",altoCuerpo+"px");
		$("#muestraasignaciones").css("width",(anchoDiv-10)+"px");
		$("#ventanaEnsambleContenido2").css("width",(anchoDiv-200)+"px");
		//$("#infoEnsamble3").css("height",(altoCuerpo-10)+"px");
		
	}	
	window.onresize=redimensionar;	
</script>
<!--<div id="cargadorEmpaque" class="cargadorEmpaque">Cargando...</div>-->
<input type="hidden" name="txtProcesoEmpaque" id="txtProcesoEmpaque" value="<?=$proceso;?>" />
<input type="hidden" name="txtIdUsuarioEmpaque" id="txtIdUsuarioEmpaque" value="<?=$_SESSION['id_usuario_nx'];?>" />
<div id="contenedorEnsamble">
	<div id="contenedorEnsamble3">
		<div id="barraOpcionesEnsamble">
			<div class="opcionesEnsamble" onclick="captura_actividad();" title="">Captura_Actividad</div>
			<div class="opcionesEnsamble" onclick="consultaRegistros();" title="">Consultar Registros</div>
			<div class="opcionesEnsamble" onclick="modificar();" title="">Modificar Registros</div>
		<!--<div id="cargadorEmpaque" style="float:right;width:200px;height:20px;padding:5px;background:#FFF;border:1px solid #CCC;font-size:13px;text-align:right;"></div>-->
		</div>
		<!--abrir('transparenciaGeneral1');-->		
		<!--<div id="infoEnsamble3"></div>-->
	<div id="muestraasignaciones" style="  float: left;width:880px; height: 790px;margin: 5px; border: 1px solid #CCC;background: #FFF; overflow: auto" >
		
	</div>
    </div>
    </div>
</div>
</div>
<div id="divMensajeCaptura" class="ventanaDialogo" style="display: none;" onclick="limpiarse();">
	<div id="barraTitulo1VentanaDialogoValidacion" class="barraTitulo1VentanaDialogoValidacion">Asignaci&oacute;n</div>
	<div id="listadoinEmpaqueValidacion" style="border:1px solid #CCC; margin:4px; font-size:10px;height:90%; overflow:auto;"></div>
</div>
<div id="buscarEmpleado" style="border:1px solid #000;background-color:#FFF;height:508px;width:900px;left: 50%;top: 50%;margin-left: -450px;margin-top: -254px;position:absolute;;/*sombra*/-webkit-box-shadow:10px 10px 5px #CCC;-moz-box-shadow:10px 10px 5px #CCC;filter: shadow(color=#CCC, direction=135,strength=2); display: none;"  >
	<div id="barraTituloBuscar" class="barraTitulo1VentanaDialogoValidacion">Seleccionar...<div id="btnCerrarVentanaDialogo"><a href="#" onclick="cerrarVentana('buscarEmpleado');" title="Cerrar Ventana"><img src="../../img/close.gif" border="0" /></a></div></div>
	<div id="listadoResultados" style="border:1px solid #CCC; margin:4px; font-size:10px;height:92%; overflow:hidden;">
		<br>
		<br>
		<center>
		<input type="hidden" name="txtOpcionBusqueda" id="txtOpcionBusqueda">
		<form>
		Buscar:<input type="text" name="buscar"  id="buscar" onkeypress="buscarEmpleado();"></i>
		 <input type="button" name="buscar" id="buscar"value="buscar" onclick="">
		</form></center>
		<div id="ListarEmpleados" style="border: 0px solid #ff0000;background:#fff; height: 87%;width: 99%;font-size:12px;margin:3px;overflow: auto;"></div>		
	</div>
</div>