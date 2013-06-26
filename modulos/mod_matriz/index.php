<?      
	/*session_start();
	session_regenerate_id(true);
	include("../../includes/txtApp.php");
	include("../../clases/regLog.php");
	$objLog=new regLog();
	$objLog->consulta($_SESSION[$txtApp['session']['loginUsuario']],date("Y-m-d"),date("H:i:s"),$_SERVER['REMOTE_ADDR'],"ASIGNACIONES",$_SESSION[$txtApp['session']['origenSistemaUsuario']]);
	if(!isset($_SESSION[$txtApp['session']['idUsuario']])){
		echo "<script type='text/javascript'> alert('Su sesion ha terminado por inactividad'); window.location.href='../mod_login/index.php'; </script>";
		exit;
	}*/
?>
<link rel="stylesheet" type="text/css" href="css/estilosEmpaque.css" />
<script type="text/javascript" src="js/funcionesEnsamble.js"></script>
<script type="text/javascript" src="../../clases/jquery-1.3.2.min.js"></script>
<!--Inclusion de los tabs-->
<script type="text/javascript" src="../../recursos/tabs/js/tabs.js"></script>
<link rel="stylesheet" type="text/css" href="../../recursos/tabs/css/tabs.css" />
<!--Fin inclusion de los tabs-->
<!--calendario-->
<link rel="stylesheet" type="text/css" media="all"  href="js/calendar-green.css"  title="win2k-cold-1" />
<!-- librería principal del calendario -->
<script type="text/javascript" src="js/calendar.js"></script>
<!-- librería para cargar el lenguaje deseado -->
<script type="text/javascript" src="js/calendar-es.js"></script>
<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
<script type="text/javascript" src="js/calendar-setup.js"></script>
<!--fin calendario-->
<script type="text/javascript">
	$(document).ready(function(){
		redimensionar();
		
		$("#left").click(function(){			
		  $("#contenedorTabs").animate({"left": "+=100px"}, "fast");
		  verificaMovIzq();	  
		  posicionReal = $("#contenedorTabs").offset();
		  alert(posicionReal.left);
		});
	
		$("#right").click(function(){
		  $("#contenedorTabs").animate({"left": "-=100px"}, "fast");
		  verificaMovDer();  
		});
	});
	
	function redimensionar(){
		var altoDiv=$("#contenedorEnsamble3").height();
		var anchoDiv=$("#contenedorEnsamble3").width();
		var altoCuerpo=altoDiv-52;		
		$("#infoEnsamble3").css("height",(altoCuerpo-15)+"px");
	}
	
	window.onresize=redimensionar;

	document.onkeypress=function(elEvento){
		var evento=elEvento || window.event;
		var codigo=evento.charCode || evento.keyCode;
		var caracter=String.fromCharCode(codigo);
		if(codigo==27){
			cerrarVentanaValidacion();
		}
	}
//setInterval("procesarDatosGrid()",5000);
</script>
<!--<div id="cargadorEmpaque" class="cargadorEmpaque">Cargando...</div>-->
<input type="hidden" name="txtProcesoEmpaque" id="txtProcesoEmpaque" value="<?=$proceso;?>" />
<input type="hidden" name="txtProcesoEmpaqueEnvio" id="txtProcesoEmpaqueEnvio" value="<?=$proceso1;?>" />
<input type="hidden" name="txtIdUsuarioEmpaque" id="txtIdUsuarioEmpaque" value="<?=$_SESSION['id_usuario_nx'];?>" />
<div id="contenedorEnsamble">
	<div id="contenedorEnsamble3">
		<div id="barraOpcionesEnsamble">
			<table border="0" cellpadding="1" cellspacing="1" width="99.7%" style="font-size: 10px;margin: 4px;background: #FFF;">
				<tr>
					<td>
						#: <input type="text" readonly="readonly" style="width: 65px;" name="txtBNoEmpleado" id="txtBNoEmpleado">
						<input type="button" value="..." onclick="abrir('buscarEmpleado','busqueda')" >
						Fecha 1&nbsp;<input type="text" name="busquedaRegistro1" id="busquedaRegistro1" style="width: 150px;" >
						<input type="button" id="lanzadorB1"  value="..." />
						<!-- script que define y configura el calendario-->
						<script type="text/javascript">
						    Calendar.setup({
							inputField     :    "busquedaRegistro1",      // id del campo de texto
							ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
							button         :    "lanzadorB1"   // el id del botón que lanzará el calendario
						    });
						</script>&nbsp;y&nbsp;
						Fecha 2&nbsp;<input type="text" name="busquedaRegistro2" id="busquedaRegistro2" style="width: 150px;" >
						<input type="button" id="lanzadorB2"  value="..." />
						<!-- script que define y configura el calendario-->
						<script type="text/javascript">
						    Calendar.setup({
							inputField     :    "busquedaRegistro2",      // id del campo de texto
							ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
							button         :    "lanzadorB2"   // el id del botón que lanzará el calendario
						    });
						</script>&nbsp;&nbsp;&nbsp;
						<input type="button" value="Buscar..." onclick="buscarDatosMatriz();" />
					</td>
				</tr>
				<tr>
					<td>
						Nombre:&nbsp;<span id="nombreCompletoABuscar" style="width: 250px;height: 25px;font-size: 12px;">Nombre del Empleado</span>
					</td>
				</tr>				
			</table>
			<!--<div class="opcionesEnsamble" onclick="nuevaEntrega()" title="Capturar Equipo OK">Nueva Captura</div>			
			<div class="opcionesEnsambleFinalizar" onclick="generarVentana()" title="Finalizar Entregas">Finalizar Entregas</div>-->
			<!--<div id="cargadorEmpaque" style="float:right;width:600px;height:20px;padding:5px;background:#FFF;border:1px solid #CCC;font-size:13px;text-align:right;"></div>-->
		</div>
		<div id="infoEnsamble3">
			<!--Area de los tabs-->
			<div id="contenedor">
				<div id="contenedorTabs" class="contenedorTabs">
				    <div id="tab1" class="bordeDiv"><a href="javascript:void(0)" onclick="mostrarTab('1','contentTab1')" class="enlacesTabs">Resultados</a> <div class="btnCerrar" onclick="cierraTab('tab1')">&nbsp;</div></div>
				</div>
			</div>    
			<input type="button" id="left" class="botonesDesp" value="<" />
			<input type="button" id="right" class="botonesDesp" value=">" />
			<div class="separador"></div>
			<div id="contenedorContenidos">
			</div>
			    <div id="contenidoTab">
			    <div id="contentTab1" class="contenidoTabs">
				<p align="center" style="margin-top: 150px;font-size: 15px;">Introduzca los Datos de B&uacute;squeda en la parte Posterior</p>
			    </div>
			</div>
			<!--Fin Area de los tabs-->
		</div>
	</div>
</div>
<div id="ventanaDialogo" class="ventanaDialogo" style="display:none;">
	<div id="barraTitulo1" style="height: 15px;padding: 5px;background: #000;color: #FFF;font-size: 12px;">Opciones...<div id="btnCerrar" style="float: right;"><a href="#" onclick="cerrarVentana('ventanaDialogo')" title="Cerrar Ventana Dialogo"><img src="../../img/close.gif" border="0" /></a></div></div>
	<div id="msgVentanaDialogo" class="msgVentanaDialogo" style="border: 0px solid #FF0000;width: 99.5%;height: 272px;overflow: auto;"></div>
</div>
<div id="buscarEmpleado" style="border:1px solid #000;background-color:#FFF;height:300px;width:600px;left: 50%;top: 50%;margin-left: -300px;margin-top: -150px;position:absolute; display: none;"  >
	<div id="barraTituloBuscar" class="barraTitulo1VentanaDialogoValidacion">Seleccionar...<div id="btnCerrarVentanaDialogo"><a href="#" onclick="cerrarVentana('buscarEmpleado');" title="Cerrar Ventana"><img src="../../img/close.gif" border="0" /></a></div></div>
	<div id="listadoResultados" style="border:1px solid #CCC; margin:4px; font-size:10px;height:87%; overflow:hidden;"><br><br>
		<center>
		<input type="hidden" name="txtOpcionBusqueda" id="txtOpcionBusqueda">
		<form>
		Buscar:<input type="text" name="buscar"  id="buscar" onkeyup="buscarEmpleado();"></i>
		 <input type="button" name="buscar" id="buscar"value="buscar" onclick="">
		</form></center>
		<div id="ListarEmpleados" style="border: 0px solid #ff0000;background:#fff; height: 75.8%;width: 99%;font-size:12px;margin:3px;overflow: auto;"></div>		
	</div>
</div>

<div id="transparenciaGeneral" style="display:none;">	
		<div id="capturaCaja" class="ventanaDialogo">
    		<div id="barraTitulo1VentanaDialogo">Captura de Equipos</div><br />
		<div></div>
		</div>
	</div>
</div>

<div id="formularioOpciones" class="transparenciaGeneral" style="display:none;">	
	<div id="capturaCaja" class="ventanaDialogoCapturaFinal">
    		<div id="barraTitulo1VentanaDialogoCapturaFinal">Formulario</div>
			<div id="contenidoFormularioOpciones" style="border: 0px solid #ff0000;height: 368px;width:598px;overflow: auto;"></div>
		</div>
	</div>
</div>

<div id="formularioOpciones2" class="transparenciaGeneral" style="display:none;">	
	<div id="capturaCaja" class="ventanaDialogoCapturaFinal" style="z-index: 200;">
    		<div id="barraTitulo1VentanaDialogoCapturaFinal">Formulario 2</div>
			<div id="contenidoFormularioOpciones2" style="border: 0px solid #ff0000;height: 368px;width:598px;overflow: auto;"></div>
		</div>
	</div>
</div>


<div id="transparenciaGeneral1" class="transparenciaGeneral" style="display:none;">
	<div id="divListadoCapturaValidacion" class="ventanaDialogo">
		<div id="barraTitulo1VentanaDialogoValidacion" class="barraTitulo1VentanaDialogoValidacion">Informaci&oacute;n de la Captura<div id="btnCerrarVentanaDialogo"><a href="#" onclick="cerrarVentanaValidacion()" title="Cerrar Ventana"><img src="../../img/close.gif" border="0" /></a></div></div>
		<div id="listadoEmpaqueValidacion" style="border:1px solid #CCC; margin:4px; font-size:10px;height:93%; overflow:auto;"></div>
	</div>
</div>	
<div id="divVerificacionEquipoValidacion" class="ventanaDialogoVerificacionEquipoValidacion" style="display:none;">
	<div id="barraTitulo1VentanaDialogoValidacion" class="barraTitulo1VentanaDialogoValidacion">Informaci&oacute;n <input type="hidden" name="txtVentanaValidacion" id="txtVentanaValidacionID" value=""><div id="btnCerrarVentanaDialogo"><a href="#" onclick="ventanaDialogoVerificacionEquipoValidado()" title="Cerrar Ventana"><img src="../../img/close.gif" border="0" /></a></div></div>
	<div id="listadoEmpaqueVerificacionValidacion" style="border:1px solid #CCC; margin:4px; font-size:10px;height:93%; overflow:auto;"></div>
</div>
<div id="divVerificacionEquipoEntregas" class="ventanaDialogoVerificacionEquipoEntregas" style="display:none;">
	<div id="barraTitulo1VentanaDialogoValidacion" class="barraTitulo1VentanaDialogoValidacion">Informaci&oacute;n <input type="hidden" name="txtVentanaValidacion" id="txtVentanaValidacionID" value=""><div id="btnCerrarVentanaDialogo"><a href="#" onclick="ventanaDialogoVerificacionEquipoEntrega()" title="Cerrar Ventana"><img src="../../img/close.gif" border="0" /></a></div></div>
	<div id="listadoEmpaqueVerificacionValidacionEntregas" style="border:1px solid #CCC; margin:4px; font-size:10px;height:90%; overflow:auto;"></div>
</div>
<div id="divVerificacionEquipoEnviado" class="ventanaDialogoVerificacionEquipoEnviado" style="display:none;">
		<div id="barraTitulo1VentanaDialogoValidacion" class="barraTitulo1VentanaDialogoValidacion">Informaci&oacute;n<div id="btnCerrarVentanaDialogo"><a href="#" onclick="ventanaDialogoVerificacionEquipoEnviado()" title="Cerrar Ventana"><img src="../../img/close.gif" border="0" /></a></div></div>
		<div id="listadoEmpaqueVerificacionEnviado" style="border:1px solid #CCC; margin:4px; font-size:10px;height:93%; overflow:auto;"></div>
	</div>
<div id="notificaciones" style=" display:none; text-align:center;position:absolute; width:300px; height:35px;z-index:1000;background:#F5F6CE; color:#000; left:40%; top:100px; padding:10px;"></div>
<div id="cargadorGeneral" class="transparenciaGeneral" style="display: none;">
	<div id="cargador" style=" display:block; text-align:center;position:absolute; width:150px; height:35px;z-index:1000;background:#FFF; color:#000; left:40%; top:300px; padding:10px;"><img src="../../img/cargador.gif" border="0"></div>
</div>
<div id="transparenciaGeneral10" class="transparenciaGeneral" style="display:none;">
	<div id="divListadoCapturaFinalizacion" class="ventanaDialogoFinalizacion">
		<div id="barraTitulo1VentanaDialogoValidacion" class="barraTitulo1VentanaDialogoValidacion">Informaci&oacute;n de la Captura<div id="btnCerrarVentanaDialogo"><a href="#" onclick="cerrarVentanaFinalizacion1()" title="Cerrar Ventana"><img src="../../img/close.gif" border="0" /></a></div></div>
		<div id="listadoEmpaqueFinalizacion" style="border:1px solid #CCC; margin:4px; font-size:10px;height:87%; overflow:auto;"></div>
	</div>
</div>
<div id="opcionFormFlex" style="display:none;position: absolute; left: 0; top: 0; width: 100%; height: 100%; background: url(../../img/desv.png) repeat;">
	<div id="msgFlexCaptura">
		<div id="advertencia">Advertencia...</div>
		<div style="height:118px;width:99.5%;padding:5px;text-align:center;font-size:12px;">
			<br><br>¿Desea capturar los Equipos con Flex Nuevo?<br><br>		
			<input type="button" id="btnFormFlexSi" value="S&iacute;" onclick="colocaValorFlex('nuevo')">
			<input type="button" id="btnFormFlexNo" value="No" onclick="colocaValorFlex('procesado')">	
		</div>
	</div>
</div>

<!--<div id="contenido1" style="float: left;border:1px solid #e1e1e1;background:#fff; height:95%;width:32%;font-size:12px;margin:3px;">
	<div class="tituloDivNuevo">Proyectos <div style="float: right;margin-right: 3px;margin-top: 3px;">Nuevo Proyecto</div></div>
	<div id="contenido11" style="overflow: auto;"></div>
</div>
<div id="contenido2" style="float: left;border:1px solid #e1e1e1;background:#fff; height:95%;width:32%;font-size:12px;margin:3px;">
	<div class="tituloDivNuevo">Procesos</div>
	<div id="contenido12" style="overflow: auto;"></div>
</div>
<div id="contenido3" style="float: left;border:1px solid #e1e1e1;background:#fff; height:95%;width:32%;font-size:12px;margin:3px;">
	<div class="tituloDivNuevo">Actividades</div>
	<div id="contenido13" style="overflow: auto;"></div>
</div>-->			

<?
include ("../../includes/pie.php");
?>