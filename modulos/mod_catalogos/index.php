<?      
	session_start();
	include("../../includes/cabecera.php");
	include("../../includes/txtApp.php");
	include("../../clases/regLog.php");
	$objLog=new regLog();
	$objLog->consulta($_SESSION[$txtApp['session']['loginUsuario']],date("Y-m-d"),date("H:i:s"),$_SERVER['REMOTE_ADDR'],"CATALOGOS",$_SESSION[$txtApp['session']['origenSistemaUsuario']]);
	if(!isset($_SESSION[$txtApp['session']['idUsuario']])){
		echo "<script type='text/javascript'> alert('Su sesion ha terminado por inactividad'); window.location.href='../mod_login/index.php'; </script>";
		exit;
	}		
?>
<script type="text/javascript" src="js/funcionesEnsamble.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<!--se incluyen los recursos para el grid-->
<script type="text/javascript" src="../../recursos/grid/grid.js"></script>
<link rel="stylesheet" type="text/css" href="../../recursos/grid/grid.css" />
<!--fin inclusion grid-->
<link rel="stylesheet" type="text/css" media="all" href="js/calendar-green.css"  title="win2k-cold-1" />
<link rel="stylesheet" type="text/css" media="all" href="css/estilos.css" />  
<script type="text/javascript" src="js/calendar.js"></script><!-- librería principal del calendario -->  
<script type="text/javascript" src="js/calendar-es.js"></script><!-- librería para cargar el lenguaje deseado -->   
<script type="text/javascript" src="js/calendar-setup.js"></script><!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
<script type="text/javascript">
	$(document).ready(function(){
		redimensionar();
		catalogos();
	});	
	function redimensionar(){
		var altoDiv=$("#contenedorEnsamble3").height();
		var anchoDiv=$("#contenedorEnsamble3").width();
		var altoCuerpo=altoDiv-52;
		$("#mostrar").css("height",(altoCuerpo-8)+"px");
		$("#ventanaEnsambleContenido2").css("height",altoCuerpo+"px");
		$("#mostrar").css("width",(anchoDiv-430)+"px");
		$("#ventanaEnsambleContenido2").css("width",(anchoDiv-200)+"px");
		$("#infoEnsamble3").css("height",(altoCuerpo-8)+"px");
		
	}	
	window.onresize=redimensionar;	
</script>
<!--<div id="cargadorEmpaque" class="cargadorEmpaque">Cargando...</div>-->
<input type="hidden" name="txtProcesoEmpaque" id="txtProcesoEmpaque" value="<?=$proceso;?>" />
<input type="hidden" name="txtIdUsuarioExoxoutich091289mpaque" id="txtIdUsuarioEmpaque" value="<?=$_SESSION['id_usuario_nx'];?>" />
<div id="contenedorEnsamble">
	<div id="contenedorEnsamble3">
		<div id="barraOpcionesEnsamble">
			<div class="opcionesEnsamble" onclick="catalogos();" title="">Cat&aacute;logos del Sistema</div>
			<!--<div id="cargadorEmpaque" style="float:right;width:200px;height:20px;padding:5px;background:#FFF;border:1px solid #CCC;font-size:13px;text-align:right;"></div>-->
		</div>
		<div id="infoEnsamble3">			
			<!--<div id="listadoEmpaque" style="border:1px solid #e1e1e1;background:#fff; height:99%;width:97%;font-size:12px;margin:3px;overflow: auto;"></div>
			<div id="infoCapturaFlex" style="border:1px solid #e1e1e1;background:#fff; height:100px;width:180px;font-size:12px;text-align:left;margin:0 auto 0 auto;"></div>
			<div id="infoEquiposIng" style="border:1px solid #e1e1e1;background:#fff; height:220px;width:180px;font-size:20px;text-align:center;margin:0 auto 0 auto;"></div>
			<input type="hidden" id="txtOpcionFlex" name="txtOpcionFlex" value="" />-->
		
	        </div>
		<!--<div id="detalleEmpaque" class="ventanaEnsambleContenido"></div>
		<div id="ventanaEnsambleContenido2" class="ventanaEnsambleContenido" style="display:none;"></div>
		<div style="clear:both;"></div>
		<!--<div id="barraInferiorEnsamble">			
			<div id="erroresCaptura"></div>
			<div id="opcionCancelar"><input type="button" onclick="cancelarCaptura()" value="Cancelar" style=" width:100px; height:30px;padding:5px;background:#FF0000;color:#FFF;border:1px solid #FF0000;font-weight:bold;" /></div>
	</div>-->
	<div id="mostrar" style=" position: relative; float: left; margin: 5px; border: 1px solid#CCC;background: #FFF; overflow: auto" >
		
	</div>
	<!--<div id="mostrar" style=" border:1px solid #CCC;background:#fff; height: 620px;width:900px;">
	</div>-->
</div>
	</div>
<?
//include ("../../includes/pie.php");
?>