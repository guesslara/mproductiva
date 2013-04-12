<?
	session_start();
	class modeloEnsamble{

		private function conectarBd(){
			require("../../includes/config.inc.php");
			$link=mysql_connect($host,$usuario,$pass);
			if($link==false){
				echo "Error en la conexion a la base de datos";
			}else{
				mysql_select_db($db);
				return $link;
			}				
		}
		
		public function conectar(){
			require("../../includes/config.inc.php");
			$conexion=@mysql_connect($host,$usuario,$pass) or die ("no se pudo conectar al servidor<br>".mysql_error());
			if(!$conexion){
				echo "Error al conectarse al servidor";	
			}else{
				@mysql_select_db('iqe_rrhh_2010') or die ("No se puede conectar a la base de datos<br>".mysql_error());
			}				
    			return $conexion;
		}
		
		public function actualizaListadoProductos(){
			$sqlProducto="SELECT * FROM SAT_PRODUCTO";
			$resProducto=mysql_query($sqlProducto,$this->conectarBd());
			if(mysql_num_rows($resProducto)==0){
			    echo "No hay productos Capturados";
			}else{
?>
				<select name="cboProductoActividad" id="cboProductoActividad">						       
				     <option value="">Selecciona</option>
<?
				while($rowProducto=mysql_fetch_array($resProducto)){
?>
				     <option value="<?=$rowProducto["id_producto"];?>"><?=$rowProducto["nom_producto"]." ".$rowProducto["modelo"];?></option>  
<?
				}
?>
				</select>
<?
			}
		}
		
		public function guardarProducto($nombreProd,$modeloProd){
			$sqlProd="INSERT INTO SAT_PRODUCTO (nom_producto,modelo) VALUES ('".$nombreProd."','".$modeloProd."')";
			$resProd=mysql_query($sqlProd,$this->conectarBd());
			if($resProd){
				echo "<script type='text/javascript'> alert('Producto Guardado'); cerrarVentana('formularioOpciones2'); actualizarListadoProductos();</script>";
			}else{
				echo "<script type='text/javascript'> alert('Error al Guardar la informacion del Producto'); </script>";
			}
		}
		
		public function formNuevoProducto(){
?>
			<br><table border="0" align="center" cellpadding="1" cellspacing="1" width="500" style="font-size: 10px;">
				<tr>
					<td colspan="2" style="background: #666;color: #FFF;height: 15px;padding: 5px;">Nuevo Producto</td>
				</tr>
				<tr>
					<td width="50">Nombre del Producto</td>
					<td width="50"><input type="text" name="txtNomProducto" id="txtNomProducto"></td>
				</tr>
				<tr>
					<td>Modelo</td>
					<td><input type="text" name="txtModeloProducto" id="txtModeloProducto"></td>
				</tr>
				<tr>
					<td colspan="2"><hr style="background: #CCC;"></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: right;"><input type="button" value="Cancelar" onclick="cerrarVentana('formularioOpciones2')"><input type="button" onclick="guardarProducto()" value="Guardar Producto"></td>
				</tr>
			</table>
<?
		}
		
		public function actualizarStatusActividad($valores){
			//2,6|5,7
			$arrayClaves=explode("|",$valores);			
			for($i=0;$i<count($arrayClaves);$i++){
				$arrayClaves2=explode(",",$arrayClaves[$i]);				
				//se arma la consulta
				$sqlActAct="UPDATE ACTIVIDAD_STATUS SET tiempo='".$arrayClaves2[0]."' WHERE id_act_status='".$arrayClaves2[1]."'";
				$resActAct=mysql_query($sqlActAct,$this->conectarBd());
				if($resActAct){
					echo "<br>&nbsp;&nbsp;Actualizacion Realizada";
				}else{
					echo "<br>&nbsp;&nbsp;Error al Actualizar el Registro";
				}
			}
			echo "<br><br><div style='text-align:center;height:15px;padding:5px;'>Presione el boton Cerrar Ventana para Finalizar la Actualizaci&oacute;n</div><br><br>";
			echo "<div style='text-align:center;height:15px;padding:5px;'><a href='#' onclick=\"cerrarVentana('formularioOpciones')\" title='Cerrar ventana'>Cerrar Ventana</a></div>";
		}
		
		public function mostrarFormMetrica($ultimoId){
			$sqlNAct="SELECT * FROM SAT_ACTIVIDAD WHERE id_actividad='".$ultimoId."'";
			$resNAct=mysql_query($sqlNAct,$this->conectarBd());
			$rowNAct=mysql_fetch_array($resNAct);
			$sqlStatus="SELECT * FROM ACTIVIDAD_STATUS INNER JOIN SAT_STATUS ON ACTIVIDAD_STATUS.id_status = SAT_STATUS.id_status WHERE id_actividad='".$ultimoId."'";
			$resStatus=mysql_query($sqlStatus,$this->conectarBd());
			if(mysql_num_rows($resStatus)==0){
				echo "No existe Informacion a mostrar";
			}else{
?>
			<table border="0" cellpadding="1" cellspacing="1" width="580" style="margin: 5px;font-size: 10px;">
				<tr>
					<td colspan="3" style="background: #666;color: #FFF;font-weight: bold;height: 15px;padding: 5px;">M&eacute;trica - &nbsp;<?=$rowNAct["nom_actividad"];?></td>
				</tr>
				<tr>
					<td colspan="3">
						<div style="height: 15px;padding: 5px;background: #CCC;font-weight: bold;">NOTA: El tiempo de la metrica debe ser expresado en minutos</div>
					</td>
				</tr>
				<tr>
					<td rowspan="2" style="text-align: left;border: 1px solid #CCC;background: #f0f0f0;">Status</td>
					<td colspan="2" style="text-align: center;border: 1px solid #CCC;background: #f0f0f0;">M&eacute;trica</td>					
				</tr>
				<tr>
					<td style="text-align: center;border: 1px solid #CCC;background: #f0f0f0;">Pz</td>
					<td style="text-align: center;border: 1px solid #CCC;background: #f0f0f0;">Tiempo</td>
				</tr>
<?
			$i=0;
			while($rowMetricas=mysql_fetch_array($resStatus)){
				$nombreStatus="status".$i;
				$nombreStatus1="txtStatus".$i;
				$nombreIdStatus="txtIdStatus".$i;
?>
				<tr>
					<td width="280" style="text-align: left;border-bottom: 1px solid #CCC;">&nbsp;<?=$rowMetricas["nom_status"]?><input type="hidden" name="<?=$nombreIdStatus;?>" id="<?=$nombreIdStatus;?>" value="<?=$rowMetricas["id_act_status"];?>"></td>
					<td width="100" style="text-align: center;border-bottom: 1px solid #CCC;"><input type="text" name="<?=$nombreStatus;?>" id="<?=$nombreStatus;?>" value="1 PZ" style="text-align: center;width: 50px;"></td>
					<td width="100" style="text-align: center;border-bottom: 1px solid #CCC;"><input type="text" name="<?=$nombreStatus1;?>" id="<?=$nombreStatus1;?>" value="" style="text-align: center;width: 50px;"></td>
				</tr>
<?
				$i+=1;
			}
?>
				<tr>
					<td colspan="3"><hr style="background: #666;"><input type="hidden" id="hdnContadorResp" name="hdnContadorResp" value="<?=$i;?>"></td>
				</tr>
				<tr>
					<td colspan="3" style="text-align: right;"><input type="button" value="Guardar Datos" onclick="guardarDatosExtraActividad()"></td>
				</tr>
			</table>
<?
			}
		}
		
		public function actualizarStatus(){
			$sqlActStatus="SELECT * FROM SAT_STATUS WHERE status='Activo'";
			$resActstatus=mysql_query($sqlActStatus,$this->conectarBd());
			if(mysql_num_rows($resActstatus)==0){
				echo "No hay status Capturados";
			}else{
				$i=0;
				while($rowStatus=mysql_fetch_array($resActstatus)){
					$id="cboStatus".$i;
?>
					<input type="checkbox" name="cboStatus" id="<?=$id;?>" value="<?=$rowStatus["id_status"];?>"><label for="<?=$id;?>"><?=$rowStatus["nom_status"];?></label><br>
<?
					$i+=1;
				}
			}
		}
		
		public function guardarNuevoStatus($status){
			$sqlStatus="INSERT INTO SAT_STATUS (nom_status,status) VALUES ('".strtoupper($status)."','Activo')";
			$resStatus=mysql_query($sqlStatus,$this->conectarBd());
			if($resStatus){
				echo "<script type='text/javascript'> alert('Status Guardado'); actualizarStatus(); </script>";
			}else{
				echo "<script type='text/javascript'> alert('Error al Guardar el Status'); </script>";
			}
		}
		
		public function eliminarResponsable($no_empleado,$origen,$idOrigen,$idOrigen1){
			if($origen=="proyecto"){
				$sqlElimina="DELETE FROM ASIG_PRO WHERE id_empleado='".$no_empleado."' AND id_proyecto='".$idOrigen."'";
				$resElimina=mysql_query($sqlElimina,$this->conectarBd());
				if($resElimina){
					echo "<script type='text/javascript'> alert('Registro Eliminado'); listarProyectos(); </script>";
				}else{
					echo "<script type='text/javascript'> alert('Error al eliminar el Registro'); </script>";
				}
			}else if($origen=="proceso"){
				$sqlElimina="DELETE FROM ASIG_PROC WHERE id_empleado='".$no_empleado."' AND id_proceso='".$idOrigen1."'";
				$resElimina=mysql_query($sqlElimina,$this->conectarBd());
				if($resElimina){
					echo "<script type='text/javascript'> alert('Registro Eliminado'); listarProcesos('".$idOrigen."'); </script>";
				}else{
					echo "<script type='text/javascript'> alert('Error al eliminar el Registro'); </script>";
				}
			}else if($origen=="actividad"){
				$sqlElimina="DELETE FROM ASIG_ACT WHERE id_empleado='".$no_empleado."' AND id_actividad='".$idOrigen1."'";
				$resElimina=mysql_query($sqlElimina,$this->conectarBd());
				if($resElimina){
					echo "<script type='text/javascript'> alert('Registro Eliminado'); listarActividades('".$idOrigen."'); </script>";
				}else{
					echo "<script type='text/javascript'> alert('Error al eliminar el Registro'); </script>";
				}
			}
			
		}
		
		public function guardarAsignacion($tabla,$idEmpleado,$accionForm,$valorForm,$parametroOpcional){
			//echo "<br>".$tabla;
			if($tabla=="ASIG_PROC"){
				 $sqlAsig="INSERT INTO ".$tabla."(id_empleado,status,fecha_asig,hora_asig,id_proceso) VALUES ('".$idEmpleado."','Activo','".date("Y-m-d")."','".date("H:i:s")."','".$valorForm."')";
				 $resAsig=mysql_query($sqlAsig,$this->conectarBd());
				 if($resAsig){
					echo "<br>Registro Guardado";
					echo "<script type='text/javascript'> alert('Asignacion guardada'); cerrarVentana('ventanaDialogo'); listarProcesos('".$parametroOpcional."');</script>";
				 }else{
					    echo "<br>Error al Guardar la Asignacion";
				 }
			}else if($tabla=="ASIG_ACT"){
				 $sqlAsig="INSERT INTO ".$tabla."(id_empleado,status,fecha_asig,hora_asig,id_actividad) VALUES ('".$idEmpleado."','Activo','".date("Y-m-d")."','".date("H:i:s")."','".$valorForm."')";
				 $resAsig=mysql_query($sqlAsig,$this->conectarBd());
				 if($resAsig){
					echo "<br>Registro Guardado"; //listarActividades(idProceso)
					echo "<script type='text/javascript'> alert('Asignacion guardada'); cerrarVentana('ventanaDialogo'); listarActividades('".$parametroOpcional."');</script>";
				 }else{
					    echo "<br>Error al Guardar la Asignacion";
				 }
			}else if($tabla=="ASIG_PRO"){
				 $sqlAsig="INSERT INTO ".$tabla."(id_empleado,status,fecha_asig,hora_asig,id_proyecto) VALUES ('".$idEmpleado."','Activo','".date("Y-m-d")."','".date("H:i:s")."','".$valorForm."')";
				 $resAsig=mysql_query($sqlAsig,$this->conectarBd());
				 if($resAsig){
					echo "<br>Registro Guardado";
					echo "<script type='text/javascript'> alert('Asignacion guardada'); cerrarVentana('ventanaDialogo'); listarProyectos();</script>";
				 }else{
					    echo "<br>Error al Guardar la Asignacion";
				 }
			}
			echo "<br>".$sqlAsig;
		      //echo "<script type='text/javascript'> cerrarVentana('ventanaDialogo') </script>";
		}
		
		public function formAsignacion($accion,$idAccion,$valor,$parametroOpcional){
			$origi=ucwords($idAccion);
			if($idAccion=="proyecto"){
				$sqlProyectos="SELECT * FROM SAT_PROYECTO WHERE status='Activo' AND id_proyecto='".$valor."'";
				$resProyectos=mysql_query($sqlProyectos,$this->conectarBd());
				$rowProyectos=mysql_fetch_array($resProyectos);
			}
?>
			<FORM id="asig" >
				<input type="hidden" name="hdnAccion" id="hdnAccion" value="<?=$idAccion;?>">
				<input type="hidden" name="hdnValor" id="hdnValor" value="<?=$valor;?>">
				<input type="hidden" name="hdnParametroOpcional" id="hdnParametroOpcional" value="<?=$parametroOpcional;?>">
				<div style="border: 1px solid #CCC;background: #f0f0f0;height: 15px;padding: 5px;font-size: 12px;font-weight: bold;">Asignar Responsable a <?=$origi." ".$rowProyectos["nom_proyecto"];?></div><br><br>
					<table align="center" style="font-size: 12px;">			     
						<tr>
							<td colspan="2">Responsable (s)</td>
							<td><!--<a href="#" onclick="anadeR()" style="color:blue;">A&ntilde;adir Responsable</a>--></td>
						</tr>
						<tr>
							<td colspan="3"><hr style="background: #999;"></td>
						</tr>
						<tr>
							<td>Id Empleado:</td>
							<td><input type="text" name="resP0" id="resP0" readonly="" class="<?=$clase_obligaria?>"></td>
							<td> <a href="#" onclick="abrir('buscar');" style="color:blue;"> Buscar</a></td>
						</tr>			 
						<tr>
							<td>Nombre:</td>
							<td><input type="text" style="size: auto;" name="nresP0" id="nresP0" readonly="" value="" class="<?=$clase_obligaria?>"></td>
							<td>&nbsp;</td>
						</tr>				 
						</tr>
							<td colspan="3"><div id="otroR_0"></div>				
						</tr>		 
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							   <td colspan="3"><hr style="background: #999;"/></td>
						</tr>
						<tr>
							<td colspan="3" style="text-align: right;">
						       <input type="button" onclick="cerrarVentana('ventanaDialogo')" name="Cancelar" value="Cancelar" />
<?
			 $name=strtolower(str_replace("SAT_","",$contado));
			 $name1="id_".$name;
			 if($idAccion=="proyecto"){
				 $ti="ASIG_PRO";
?>
					    <input type="button" name="Guardar" value="Guardar" onclick="VALIDAR('<?=$ti?>')"> </h5>
<?
			 }
			 if($idAccion=="proceso"){
				 $ti="ASIG_PROC";
?>
					    <input type="button" name="Guardar" value="Guardar" onclick="VALIDAR('<?=$ti?>')"> </h5>
<?
			 }
			 if($idAccion=="actividad"){
				 $ti="ASIG_ACT";
			 //print_r($ti);
			 //exit;
?>
					    <input type="button" name="Guardar" value="Guardar" onclick="VALIDAR('<?=$ti?>');"> </h5>
<?
			 }
			 
?>      
					    </td>
				 </tr>
		    </table>	       
		    </FORM>
		<div id="resultadoGuardado"></div>
<?
	  
     }

		public function consultarempleado($tecla){
			$esta="SELECT * FROM cat_personal  WHERE nombres LIKE '".$tecla."%'  ";
			$estaeje=mysql_query($esta,$this->conectar()) or die(mysql_error());
?>
			<table align="center" BORDER="0" CELLPADDING="0" CELLSPACING="0" style="font-size: 12px;">
				<tr>
					<td colspan="15"><center><strong>EMPLEADOS</strong></center></td>
				</tr>
				<tr>
					<td class="cabeceraTitulosTabla">N° Empleado</td>
					<td class="cabeceraTitulosTabla">Nombre</td>
					<td class="cabeceraTitulosTabla">Apellido Paterno</td>
					<td class="cabeceraTitulosTabla">Apellido Materno</td>	 
			       </tr>
<?         
			while($fi=mysql_fetch_array($estaeje)){     
				$noempleado=$fi["no_empleado"];
				$nombres=$fi["nombres"];
				$apaterno=$fi["a_paterno"];
				$amaterno=$fi["a_materno"];
				$pais=$fi["pais"];
				//$mandar="controladorasig.php?action=recibodatos&no_empleado=".$noempleado."";
				$mandar="controladorasig.php?action=recibodatos&no_empleado=".$noempleado."";
?>
				<tr>  
					<td class="resultadosTablaBusqueda1"><a href="#" style="color: blue;" onclick="insertarEmpleado('<?=$noempleado;?>','<?=$nombres;?>','<?=$apaterno;?>','<?=$amaterno?>')" ><?=$noempleado;?></a></td>
					<td class="resultadosTablaBusqueda1"><?=$nombres;?></font></td>
					<td class="resultadosTablaBusqueda1"><?=$apaterno;?></td>
					<td class="resultadosTablaBusqueda1"><?=$amaterno;?></td>
				</tr>  
	  <script type="text/javascript">
		    function seguro(){
		    	
		    if(!confirm("esta seguro que desea eliminar el campo")){
			history.go(-1)
			return ""
		    }
		    }
		    
		    
		    
		  </script>
     <?
     }
     ?>
			</table>
     <?

		}
		
		public function guardarActividad($id_proceso,$nombre,$descripcion,$id_producto,$status){
			$sql="INSERT INTO SAT_ACTIVIDAD (nom_actividad,id_proceso,id_producto,status,descripcion) VALUES ('".$nombre."','".$id_proceso."','".$id_producto."','Activo','".$descripcion."')";
			$res=mysql_query($sql,$this->conectarBd());
			$status=explode(",",$status);						
			if($res){
				//se recupera el ultimo id insertado en la actividad				
				$ultimoId=mysql_query("select last_insert_id() AS ultimoId",$this->conectarBd());
				$rowUltimoId=mysql_fetch_array($ultimoId);								
				for($i=0;$i<count($status);$i++){
					$sqlActStatus="INSERT INTO ACTIVIDAD_STATUS (id_actividad,id_status) VALUES ('".$rowUltimoId["ultimoId"]."','".$status[$i]."')";//se ejecuta la consulta sql
					$resActStatus=mysql_query($sqlActStatus,$this->conectarBd());
					echo "<script type='text/javascript'> mostrarFormMetrica('".$rowUltimoId["ultimoId"]."'); </script>";//se manda llamar al siguiente formulario
					if($resActStatus==false){
						echo "<script type='text/javascript'> alert('Ocurrio un error al guardar el status con la Actividad');</script>";	
					}
				}
				echo "<script type='text/javascript'> alert('Actividad Guardada'); listarActividades('".$id_proceso."');</script>";	
			}else{
				echo "<script type='text/javascript'> alert('Error al Guardar al Proceso'); </script>";	
			}
			
		}
		
		public function nuevaActividad($id_proceso){
			$sqlProducto="SELECT * FROM SAT_PRODUCTO";
			$resProducto=mysql_query($sqlProducto,$this->conectarBd());
			$sqlStatus="SELECT * FROM SAT_STATUS";
			$resStatus=mysql_query($sqlStatus,$this->conectarBd());
?>
				<form name="frmNuevaActividad" id="frmNuevaActividad">
				<input type="hidden" name="hdnProcesoActividad" id="hdnProcesoActividad" value="<?=$id_proceso?>">
				<table border="0" align="center" cellpadding="1" cellspacing="1" width="540" style="font-size: 12px;border: 1px solid #666;">
					<tr>
						<td colspan="2" style="height: 15px;padding: 5px;background: #666;color: #FFF;">Nueva Actividad</td>						
					</tr>
					<tr>
						<td>Nombre</td>
						<td><input type="text" name="txtNombreAct" id="txtNombreAct"></td>
					</tr>					
					<tr>						
						<td>Producto</td>
						<td><div id="divProductoS" style="float: left;">
<?
				 if(mysql_num_rows($resProducto)==0){
					    echo "No hay productos Capturados";
				 }else{
?>
					    <select name="cboProductoActividad" id="cboProductoActividad" style="width: 233px;">						       
						     <option value="">Selecciona</option>
<?
					    while($rowProducto=mysql_fetch_array($resProducto)){
?>
						     <option value="<?=$rowProducto["id_producto"];?>"><?=$rowProducto["nom_producto"]." ".$rowProducto["modelo"];?></option>  
<?
					    }
?>
					    </select>
<?
				 }
?>							
						</div>&nbsp;<div style="float: left;margin-top: 3px;margin-left: 5px;">[ <a href="#" onclick="agregaProducto()" title="Agregra Producto" style="color: blue;">Nuevo Producto</a> ]</div>
						</td>						
					</tr>					
					<tr>
						<td>Descripci&oacute;n</td>
						<td><textarea rows="3" cols="30" name="txtDescAct" id="txtDescAct"></textarea></td>
					</tr>					
					<tr>
						<td colspan="2"><hr style="background: #666;"</td>							
					</tr>
					<tr>
						<td colspan="2">Seleccione los status relacionados a la actividad&nbsp;[ <a href="#" onclick="agregarStatus()" title="Agregar Status" style="color: blue;">Nuevo Status</a>]</td>
					</tr>
					<tr>
						<td colspan="2">
							<div id="statusExistentes" style="border: 1px solid #CCC;height: 100px;overflow: auto;background: #FFF;font-size: 10px;">
<?
					if(mysql_num_rows($resStatus)==0){
						echo "No hay status Capturados";
					}else{
						$i=0;
						while($rowStatus=mysql_fetch_array($resStatus)){
							$id="cboStatus".$i;
?>
							<input type="checkbox" name="cboStatus" id="<?=$id;?>" value="<?=$rowStatus["id_status"];?>"><label for="<?=$id;?>"><?=$rowStatus["nom_status"];?></label><br>
<?
							$i+=1;
						}
					}
?>
							</div>
						</td>
					</tr>
					<tr>
							<td colspan="2"><hr style="background: #666;"</td>
					</tr>
					<tr>
							<td colspan="2" style="text-align: right">
									<input type="button" onclick="cancelarCapturaActividad()" value="Cancelar">
									<input type="button" onclick="guardarActividad()" value="Siguiente">
							</td>
					</tr>
					<tr>
							<td>&nbsp;</td>
					</tr>
				</table></form>
<?
		}
		
		public function guardarProceso($id_proyecto,$nombre,$descripcion){
			$sql="INSERT INTO SAT_PROCESO (nom_proceso,status,id_proyecto,descripcion) VALUES ('".$nombre."','Activo','".$id_proyecto."','".$descripcion."')";
			$res=mysql_query($sql,$this->conectarBd());
			if($res){
				echo "<script type='text/javascript'> alert('Proceso Guardado'); $('#formularioOpciones').hide(); listarProcesos('".$id_proyecto."');</script>";	
			}else{
				echo "<script type='text/javascript'> alert('Error al Guardar al Proceso'); </script>";	
			}
		}
		
		public function nuevoProceso($id_proyecto){
?>
			<br><br><input type="hidden" name="hdnProcesoProyecto" id="hdnProcesoProyecto" value="<?=$id_proyecto?>">
			<table border="0" align="center" cellpadding="1" cellspacing="1" width="450" style="font-size: 12px;border: 1px solid #666;">
				<tr>
					<td style="height: 15px;padding: 5px;background: #666;color: #FFF;">Nuevo Proceso</td>
				</tr>
				<tr>
					<td>Nombre</td>
				</tr>
				<tr>
					<td><input type="text" name="txtNombreProc" id="txtNombreProc"></td>
				</tr>
				<tr>
					<td>Descripci&oacute;n</td>
				</tr>
				<tr>
					<td><textarea rows="3" cols="30" name="txtDescProc" id="txtDescProc"></textarea></td>
				</tr>
				<tr>
					<td><hr style="background: #666;"</td>
				</tr>
				<tr>
					<td style="text-align: right">
						<input type="button" onclick="cancelarCapturaProceso()" value="Cancelar">
						<input type="button" onclick="guardarProceso()" value="Guardar Proceso">
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
			</table>
<?
		}
		
		private function dameNombreEmpleado($no_empleado,$origen,$idOrigen,$idOrigen1){
			$sqlResp1="SELECT * FROM cat_personal WHERE no_empleado='".$no_empleado."'";//se construye la 2 consulta
			$resResp1=mysql_query($sqlResp1,$this->conectar());
			$rowResp1=mysql_fetch_array($resResp1);
			echo "<div class='divNombre'><a href='#' onclick=\"eliminaResponsable('".$no_empleado."','".$origen."','".$idOrigen."','".$idOrigen1."')\"><img src='../../img/icon_delete.gif' border='0' /></a>&nbsp;".$rowResp1["nombres"]." ".$rowResp1["a_paterno"]." ".$rowResp1["a_materno"]."</div>";
		}	
		
		public function listarActividades($id_proceso){
			$sqlProc="SELECT * FROM SAT_PROCESO WHERE id_proceso='".$id_proceso."'";
			$resProc=mysql_query($sqlProc,$this->conectarBd());
			$rowProc=mysql_fetch_array($resProc);
			$status="Activo";
?>
			<div id="barraA" style="height: 36px;background: #666;padding: 3px;">
				<div class="opcionesEnsamble" onclick="nuevaActividad('<?=$id_proceso;?>')" title="Nuevo">Nueva Actividad</div>				
			</div>
			<input type="hidden" name="hdntxtAccion" id="hdntxtAccion" value="actividades">
			<input type="hidden" name="hdntxtValor" id="hdntxtValor" value="<?=$id_proceso;?>">
			<div style="clear: both;"></div>
			<div style="height: 15px;padding: 5px;font-size: 12px;text-align: left;margin-bottom: 5px;">Actividades del Proceso: <strong><?=$rowProc["nom_proceso"];?></strong></div>
			<div id="nuevaActividad" style="border: 1px solid #CCC;margin: 3px;background: #f0f0f0;margin-bottom: 10px;"></div>
			
<?
			//echo $sqlConsult="SELECT * FROM SAT_ACTIVIDAD where id_proceso='".$id_proceso."' AND status='".$status."'";
			$sqlConsult="SELECT * FROM SAT_ACTIVIDAD INNER JOIN SAT_PRODUCTO ON SAT_ACTIVIDAD.id_producto = SAT_PRODUCTO.id_producto WHERE id_proceso = '".$id_proceso."' AND STATUS = '".$status."'";
			$resulta=@mysql_query($sqlConsult,$this->conectarBd()) or die(mysql_error());
			if(mysql_num_rows($resulta)==0){
				   echo "<br>( 0 ) Registros encontrados.<br>";
			}else{
				$color="#EEEEEE";
				while($row = mysql_fetch_array($resulta)){
					$sqlResp="SELECT * FROM ASIG_ACT WHERE id_actividad='".$row["id_actividad"]."' AND status='Activo'";					
					$resResp=mysql_query($sqlResp,$this->conectarBd());
					$sqlResp1="SELECT * FROM ACTIVIDAD_STATUS INNER JOIN SAT_STATUS ON ACTIVIDAD_STATUS.id_status = SAT_STATUS.id_status WHERE id_actividad='".$row["id_actividad"]."'";
					$resResp1=mysql_query($sqlResp1,$this->conectarBd());
?>
					<div class="resultadosAvisos" style="margin: 3px;height: auto; background: <?=$color?>;" title="" onclick="ver();">
						<table border="0" cellpadding="1" cellspacing="1" width="98%" style="font-size: 10px;">
							<tr>
								<td width="10%">Actividad:</td>
								<td width="88%"><?=substr($row["nom_actividad"],0,30)."..."; ?></td>
							</tr>
							<tr>
								<td>Descripcion:</td>
								<td><?=$row["descripcion"];?></td>
							</tr>
							<tr>
								<td>Producto</td>
								<td><?=$row["nom_producto"];?></td>
							</tr>
							<tr>
								<td>Status</td>
								<td>
<?
						if(mysql_num_rows($resResp1)==0){
							echo "<br>No existen Status Asociados";
						}else{
							while($rowResp1=mysql_fetch_array($resResp1)){
								echo "<strong>".$rowResp1["nom_status"]."</strong><br>";
							}
						}
?>
								</td>
							</tr>
							<tr>
								<td colspan="2">Responsable(s):&nbsp;[ <a href="#" onclick="nuevaAsignacion('SAT_ACTIVIDAD','actividad','<?=$row["id_actividad"]?>','<?=$id_proceso;?>')" style="color:blue;text-decoration: none;" title="Responsable">Agregar Operario</a> ]</td>
							</tr>
							<tr>
								<td colspan="2">
<?
					if(mysql_num_rows($resResp)==0){
						echo "<span style='color:red;'>Personal no Asignado</span>";
					}else{
						echo "<div style='background:#FFF;height:100px;width:100%;border:1px solid #CCC;overflow-y: auto;'>";
						while($rowResp=mysql_fetch_array($resResp)){
							$this->dameNombreEmpleado($rowResp["id_empleado"],'actividad',$id_proceso,$row["id_actividad"]);						       
						}
						echo "</div>";
					}
?>  
								</td>
							</tr>
						</table>
					</div>			   
<?php	
					($color=="#EEEEEE") ? $color="#FFFFFF" : $color="#EEEEEE";
				}
			}
		}
		
		public function listarProcesos($id_proyecto){
			$status="Activo";
			$sqlP="SELECT * FROM SAT_PROYECTO WHERE id_proyecto='".$id_proyecto."'";//se extrae el nombre del proyecto
			$resP=mysql_query($sqlP,$this->conectarBd());
			$rowP=mysql_fetch_array($resP);
			$sqlConsult="SELECT * FROM SAT_PROCESO where id_proyecto='".$id_proyecto."' AND status='".$status."'";
			$resulta=@mysql_query($sqlConsult,$this->conectarBd()) or die(mysql_error());
?>
			<div id="barraA" style="height: 36px;background: #666;padding: 3px;">
				<div class="opcionesEnsamble" onclick="nuevoProceso('<?=$id_proyecto;?>')" title="Nuevo">Nuevo Proceso</div>				
			</div>
			<div style="height: 15px;padding: 5px;font-size: 12px;text-align: left;margin-bottom: 5px;">Procesos del proyecto: <strong><?=$rowP["nom_proyecto"];?></strong></div>
			<input type="hidden" name="hdntxtAccion" id="hdntxtAccion" value="procesos">
			<input type="hidden" name="hdntxtValor" id="hdntxtValor" value="<?=$id_proyecto;?>">
			<div style="clear: both;"></div>				
			<div id="nuevoProceso" style="border: 1px solid #CCC;margin: 3px;background: #f0f0f0;margin-bottom: 10px;"></div>	
<?
			if(mysql_num_rows($resulta)==0){
				echo "<br>( 0 ) Registros encontrados.<br>";
			}else{
				$color="#FFF";
				while($row = mysql_fetch_array($resulta)){
					$sqlResp="SELECT * FROM ASIG_PROC WHERE id_proceso='".$row["id_proceso"]."' AND status='Activo'";
					$resResp=mysql_query($sqlResp,$this->conectarBd());
?>
					<div class="resultadosAvisos" style="height: auto;margin: 3px; background: <?=$color?>;" title="Ver Actividades del Proceso" onclick="listarActividades(<?=$row['id_proceso']?>);">
						<table border="0" cellpadding="1" cellspacing="1" width="98%" style="font-size: 10px;">
							<tr>
								<td width="10%">Proceso:</td>
								<td width="88%"><?=substr($row["nom_proceso"],0,30)."..."; ?></td>
							</tr>
							<tr>
								<td>Descripcion:</td>
								<td><?=substr($row["descripcion"],0,30)."..."; ?></td>
							</tr>
							<tr>
								<td colspan="2">Responsable(s):&nbsp;[ <a href="#" onclick="nuevaAsignacion('SAT_PROCESO','proceso','<?=$row["id_proceso"]?>','<?=$id_proyecto;?>')" style="color:blue;text-decoration: none;" title="Responsable">Agregar Suprevisor</a> ]</td>
							</tr>
							<tr>
								<td colspan="2">
<?
							  if(mysql_num_rows($resResp)==0){
							      echo "<span style='color:red;'>Responsable no Asignado</span>";
							  }else{
								  while($rowResp=mysql_fetch_array($resResp)){
									 $this->dameNombreEmpleado($rowResp["id_empleado"],'proceso',$id_proyecto,$row["id_proceso"]);						       
								  }
							  }
?>  
								</td>
							</tr>
						</table>
					</div>			   
<?php	
					($color=="#FFF") ? $color="#EEEEEE" : $color="#FFF";
				}	      
			}			
		}
		
		public function listarProyectos(){
			$sqlConsult="SELECT * FROM SAT_PROYECTO INNER JOIN SAT_PAIS ON SAT_PROYECTO.id_pais = SAT_PAIS.id_pais WHERE SAT_PROYECTO.status = 'Activo' ORDER BY id_proyecto DESC";
			$resulta=@mysql_query($sqlConsult,$this->conectarBd()) or die(mysql_error());
			if(mysql_num_rows($resulta)==0){
				   echo "<br>( 0 ) Registros encontrados.<br>";
			}else{
				  $color="#FFF";
			
				while($row = mysql_fetch_array($resulta)){
					$sqlResp="SELECT * FROM ASIG_PRO WHERE id_proyecto='".$row["id_proyecto"]."' AND status='Activo'";
					$resResp=mysql_query($sqlResp,$this->conectarBd());				
?>
		      <div class="resultadosAvisos" style="height: auto;width: 98.5%;margin: 2px; background: <?=$color?>;" title="Ver Procesos del Proyecto" onclick="listarProcesos('<?=$row["id_proyecto"]?>')">
				 <table border="0" cellpadding="1" cellspacing="1" width="98%" style="font-size: 10px;">
					    <tr>
						       <td width="10%" style="font-size: 12px;font-weight: bold;">Proyecto:</td>
						       <td width="88%" style="font-size: 12px;font-weight: bold;"><?=$row["nom_proyecto"];?></td>
					    </tr>
					    <tr>
						       <td>Descripci&oacute;n:</td>
						       <td><?=substr($row["descripcion"],0,40)."..."; ?></td>
					    </tr>
					    <tr>
						       <td>Fecha:</td>
						       <td><?=$row["fecha_inicio"];?></td>
					    </tr>
					    <tr>
						       <td>Pa&iacute;s:</td>
						       <td><?=$row["nom_pais"];?></td>
					    </tr>
					    <tr>
						       <td colspan="2">Responsable(s):&nbsp;[ <a href="#" onclick="nuevaAsignacion('SAT_PROYECTO','proyecto','<?=$row["id_proyecto"]?>')" style="color:blue;text-decoration: none;" title="Responsable">Agregar Lider de Proyecto</a> ]</td>
					    </tr>
					    <tr>
						       <td colspan="2">
<?
				if(mysql_num_rows($resResp)==0){
					echo "<span style='color:red;'>Responsable no Asignado</span>";
				}else{
					while($rowResp=mysql_fetch_array($resResp)){
						$this->dameNombreEmpleado($rowResp["id_empleado"],'proyecto',$row["id_proyecto"],'N/A');						       
					}
				}
?>  
						       </td>
					    </tr>
				</table>
		      </div>			   
<?php	
			($color=="#FFF") ? $color="#EEEEEE" : $color="#FFF";}
		      
			} 
		}
		
	}//fin de la clase
	//$objP=new modeloEnsamble();
	//$objP->prueba();
?>