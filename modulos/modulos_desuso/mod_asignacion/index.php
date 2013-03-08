<?      /*
	session_start();
	include("../../includes/cabecera.php");
	$proceso="";	
	if(!isset($_SESSION['id_usuario_nx'])){
		echo "<script type='text/javascript'> alert('Su sesion ha terminado por inactividad'); window.location.href='../mod_login/index.php'; </script>";
		exit;
	}else{
		if($proceso != ""){			
			$sqlProc="SELECT * FROM cat_procesos WHERE descripcion='".$proceso."'";
			$resProc=mysql_query($sqlProc,conectarBd());
			$rowProc=mysql_fetch_array($resProc);
			$proceso=$rowProc['id_proc'];
		}
	}	
	function conectarBd(){
		require("../../includes/config.inc.php");
		$link=mysql_connect($host,$usuario,$pass);
		if($link==false){
			echo "Error en la conexion a la base de datos";
		}else{
			mysql_select_db($db);
			return $link;
		}	 case consultar:
         $obj->listarProyectos($_POST['status']);
    break;			
	}*/
		/*$prefijo="SAT_";
		$excepciones_tablas=array("");
	        $excepciones_campos=array("");
		$largo_prefijo=strlen($prefijo);
		//print($prefijo);
		//exit;
		//print_r($largo_prefijo);
		$matriz_tablas=array(); 
		//MOSTRAMOS TODAS LAS TABLAS  
		$Sql ="SHOW TABLES";
		$link=mysql_connect('localhost','desarrollo','desarrollo');
		if($link==false){
			echo "Error en la conexion a la base de datos";
		}
		else{
		        mysql_select_db(desarrollo_pruebas);//$db
			//return $link;
			//echo "conectado";
			if ($result = mysql_query($Sql,$link)){
				while($Rs = mysql_fetch_array($result)) {  
				//echo "<br>";	print_r($Rs);
			
				       if (substr($Rs[0],0,$largo_prefijo)==$prefijo){
				 	// Agrego la tabla al arreglo.
					array_push($matriz_tablas,$Rs[0]);
				        }
				
			        }
		        }
			else{
			echo "<br>Error SQL [".mysql_error($link)."].";
			exit;
		        }
		}*/
		
		
		
		
		
		
?>
<script type="text/javascript" src="js/funcionesEnsamble.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<!--se incluyen los recursos para el grid-->
<script type="text/javascript" src="../../recursos/grid/grid.js"></script>
<link rel="stylesheet" type="text/css" href="../../recursos/grid/grid.css" />
<!--fin inclusion grid-->
<link rel="stylesheet" type="text/css" media="all" href="js/calendar-green.css"  title="win2k-cold-1" />
<link rel="stylesheet" type="text/css" media="all" href="css/estilos.css" />  
<script type="text/javascript">
	$(document).ready(function(){
		redimensionar();
		ajaxApp('listadoEmpaque','controladorasig.php','action=listar&status=Activo','POST');
	});	
	function redimensionar(){
		var altoDiv=$("#contenedorEnsamble3").height();
		var anchoDiv=$("#contenedorEnsamble3").width();
		var altoCuerpo=altoDiv-52;
		$("#muestraasignaciones").css("height",(altoCuerpo-10)+"px");
		$("#ventanaEnsambleContenido2").css("height",altoCuerpo+"px");
		$("#muestraasignaciones").css("width",(anchoDiv-259)+"px");
		$("#ventanaEnsambleContenido2").css("width",(anchoDiv-200)+"px");
		$("#infoEnsamble3").css("height",(altoCuerpo-10)+"px");
		//$("#muestraasig").css("width",(anchoDiv-900)+"px");
	}	
	window.onresize=redimensionar;	
</script>
<!--<div id="cargadorEmpaque" class="cargadorEmpaque">Cargando...</div>-->
<input type="hidden" name="txtProcesoEmpaque" id="txtProcesoEmpaque" value="<?=$proceso;?>" />
<input type="hidden" name="txtIdUsuarioEmpaque" id="txtIdUsuarioEmpaque" value="<?=$_SESSION['id_usuario_nx'];?>" />
<div id="contenedorEnsamble">
	<div id="contenedorEnsamble3">
		<div id="barraOpcionesEnsamble">
			<div class="opcionesEnsamble" onclick="nuevo('SAT_PROYECTO','proyecto','N/A')" title="">Asignacion Proyecto</div>
			<!--<div class="opcionesEnsamble" onclick="abrir('FiltroMostrar');" title="">Listar Asignaciones</div>
			<div class="opcionesEnsamble" onclick="abrir('FiltroDos')" title="">Modificar Asignacion</div>
		<!--<div id="cargadorEmpaque" style="float:right;width:200px;height:20px;padding:5px;background:#FFF;border:1px solid #CCC;font-size:13px;text-align:right;"></div>-->
		</div>
		<!--abrir('transparenciaGeneral1');-->
		
		<div id="infoEnsamble3">
			<div id="listadoEmpaque" style="border:1px solid #e1e1e1;background:#fff; height:99%;width:97%;font-size:12px;margin:3px;overflow: hidden;"></div>
			<!--<div id="infoCapturaFlex" style="border:1px solid #e1e1e1;background:#fff; height:100px;width:180px;font-size:12px;text-align:left;margin:0 auto 0 auto;"></div>
			<div id="infoEquiposIng" style="border:1px solid #e1e1e1;background:#fff; height:220px;width:180px;font-size:20px;text-align:center;margin:0 auto 0 auto;"></div>
			<input type="hidden" id="txtOpcionFlex" name="txtOpcionFlex" value="" />
		<br>
			<br>
				<br>
		<div id="FiltroMostrar"  style=" margin: 14px; position: absolute; display: none; width: 200px; height: 100px; border: 1px solid #000;" >
			 <br>
	  
		<form name="selects" id="selects">
		<table>
		<tr>
		<td><select name="opciones">
		<option value="se">Seleccione una opcion </option>
		<option value="Proyectos">Proyectos</option>
		<option value="Procesos">Procesos</option>
		 <option value="Actividades">Actividades</option>
	  
		</select>
		</td>
		</tr>
		<tr>
		<td><input type="button" name="consultar"  value="consultar" onclick="siconsultar();" ></td>    
		</tr>
	  
		</table>
		 </form>
		<div id="FiltroDos" style=" margin: 14px; position: absolute; display: none; width: 200px; height: 100px; border: 1px solid #000;">
	<form name="selects1" id="selects1">
		<table>
		<tr>
		<td><select name="opciones">
		<option value="se">Seleccione una opcion </option>
		<option value="Proyectos">Proyectos</option>
		<option value="Procesos">Procesos</option>
		 <option value="Actividades">Actividades</option>
	  
		</select>
		</td>
		</tr>
		<tr>
		<td><input type="button" name="consultar"  value="consultar" onclick="simodificar();" ></td>    
		</tr>
	  
		</table>
		 </form>
	</div>
			-->
			
		</div>
	
		<div id="muestraasig" style="float: left;width:350px; height: 92%; margin: 5px auto; border: 1px solid #CCC; overflow: hidden" >
			<div id="Procesos" style="width: 100%; height: 100%; background: #fff;"></div>
		</div>
		<div id="muestraO" style="float: left;margin: 5px;width:350px; height: 92%; border: 1px solid #CCC; overflow: hidden" >
			<div id="Actividades" style="width: 100%; height: 100%; background: #FFFFFF;"></div>
		</div>
	</div>
</div>
<div id="ventanaDialogo" class="ventanaDialogo" style="display:none;">
	<div id="barraTitulo1" style="height: 15px;padding: 5px;background: #000;color: #FFF;font-size: 12px;">Opciones...<div id="btnCerrar" style="float: right;"><a href="#" onclick="cerrarVentana('ventanaDialogo')" title="Cerrar Ventana Dialogo"><img src="../../img/close.gif" border="0" /></a></div></div>
	<div id="msgVentanaDialogo" class="msgVentanaDialogo" style="border: 0px solid #FF0000;width: 99.5%;height: 94%;overflow: auto;"></div>
</div>		
	
	<div id="divMensajeCaptura" class="ventanaDialogo" style="display: none;" onclick="limpiarse();">
	<div id="barraTitulo1VentanaDialogoValidacion" class="barraTitulo1VentanaDialogoValidacion">Asignaci&oacute;n</div>
	<div id="listadoinEmpaqueValidacion" style="border:1px solid #CCC; margin:4px; font-size:10px;height:90%; overflow:auto;">
		
	<form name="check" id="check">	
	<table align="center">
	
	
	<?
	$prefijo="SAT_";
	//print_r($prefijo);
	//exit;
	?>
	
	
	<tr>
	<td> <input type="checkbox" name="Proyecto"  id="Proyecto" value="SAT_PROYECTO"> <label for id="Proyecto">Proyecto</label></td>
	</tr>
	<tr>
	<td><input type="checkbox"  name="Proceso" id="Proceso" value="SAT_PROCESO"><label for id="Proceso">Proceso</label></td>	
	</tr>
	<tr>
	<td><input type="checkbox" name="Actividad" id="Actividad" value="SAT_ACTIVIDAD"><label for id="Actividad">Actividad</label></td>
	</tr>
	
	
	<tr>
	<td align="left"><input type="button" name="" id="" value="Enviar" onclick="enviotab('<?=$prefijo;?>'),limpiar('listadoEmpaqueValidacion'),cerrarVentana('divMensajeCaptura')"></td>	
	</tr>
	</table>
	</form>		
		</div>
	</div>

<div id="buscar" style="border:1px solid #000;background-color:#FFF;position: absolute;height: 450px;width: 700px;left: 50%;top: 50%;margin-left: -350px;margin-top: -225px;z-index:2;/*sombra*/-webkit-box-shadow:10px 10px 5px #CCC;-moz-box-shadow:10px 10px 5px #CCC;filter: shadow(color=#CCC, direction=135,strength=2); display: none;"  >
<div id="barraTituloBuscar" class="barraTitulo1VentanaDialogoValidacion">Buscar<div id="btnCerrarVentanaDialogo"><a href="#" onclick="cerrarVentana('buscar');" title="Cerrar Ventana"><img src="../../img/close.gif" border="0" /></a></div></div>
	<div id="listadoResultados" style="border:1px solid #CCC; margin:4px; font-size:10px;height:91.5%; overflow:hidden;">
		<br>
		<br>
		<center>
		<form>
		Buscar:<input type="text"name="si"  id="si" onkeyup="buscarE();"></i>
		 <input type="button" name="buscar" id="buscar"value="buscar" onclick="">
		</form></center>
		<div id="ListarEmpleados" style="border: 0px solid #ff0000;background:#fff; height: 85%;width: 99%;font-size:12px;margin:3px;overflow: auto;"></div>
	</div>
	
</div>




 

<?