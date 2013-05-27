<?
	/*
	 *No me interesa con quien estuviste en el pasado. Solo quiero ser tu presente y que juntos formemos el futuro.
	*/
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
		
		public function conectar_cat_personal(){
			require("../../includes/config.inc.php");
			$conexion=@mysql_connect($host,$usuario,$pass) or die ("no se pudo conectar al servidor<br>".mysql_error());
			if(!$conexion){
				echo "Error al conectarse al servidor";	
			}else{
				@mysql_select_db('iqe_rrhh_2010') or die ("No se puede conectar a la base de datos<br>".mysql_error());
			}				
    			return $conexion;
		}
		
		public function armaDetalleMatriz($noEmpleado,$fecha1,$fecha2,$idActividad){
			echo "<br>".$sqlD="SELECT SAT_ACTIVIDAD.id_actividad, SAT_ACTIVIDAD.nom_actividad, SAT_PROCESO.id_proceso, SAT_PROCESO.nom_proceso, SAT_PROYECTO.id_proyecto, SAT_PROYECTO.nom_proyecto
			FROM (SAT_ACTIVIDAD INNER JOIN SAT_PROCESO ON SAT_ACTIVIDAD.id_proceso = SAT_PROCESO.id_proceso) INNER JOIN SAT_PROYECTO ON SAT_PROCESO.id_proyecto = SAT_PROYECTO.id_proyecto WHERE id_actividad ='".$idActividad."'";
			$resD=mysql_query($sqlD,$this->conectarBd());
			$rowD=mysql_fetch_array($resD);			
			//consulta para los procesos
			echo "<br>".$sqlP="SELECT id_proceso,nom_proceso,id_proyecto FROM SAT_PROCESO WHERE id_proyecto='".$rowD["id_proyecto"]."'";
			$resP=mysql_query($sqlP,$this->conectarBd());			
			$nroProc=mysql_num_rows($resP);//numero de procesos
			$anchoTabla=($nroProc*180)+400;//se calcula en ancho de la tabla
			//consulta con los detalles de las capturas de las actividades
			echo "<br>".$sqlDR="SELECT * FROM `detalle_captura_registro` WHERE fecha BETWEEN '".$fecha1."' AND '".$fecha2."' AND no_empleado = '".$noEmpleado."' AND id_actividad='".$idActividad."' ORDER BY fecha";
			echo "<br>".$sqlDR="SELECT id, no_empleado, detalle_captura_registro.id_actividad, nom_actividad, detalle_captura_registro.status, fecha, hora, SAT_PROCESO.id_proceso, nom_proceso
			FROM (detalle_captura_registro INNER JOIN SAT_ACTIVIDAD ON detalle_captura_registro.id_actividad = SAT_ACTIVIDAD.id_actividad) INNER JOIN SAT_PROCESO ON SAT_ACTIVIDAD.id_proceso = SAT_PROCESO.id_proceso
			WHERE fecha BETWEEN '".$fecha1."' AND '".$fecha2."' AND no_empleado = '".$noEmpleado."' AND detalle_captura_registro.id_actividad = '".$idActividad."'";
			$resDR=mysql_query($sqlDR,$this->conectarBd());
			
			$arrayIds=array();//array para los ids de los procesos
			$nombresProcesos=array();//array para guardar los nombres de los procesos
			$nombreActividades=array();//array para los nombres de las actividades
			$nombresStatus=array();
			$tiempoActividades=array();//tiempo de las actividades
			$tiempoPorStatusActividad="";//array con el tiempo de los status
			$cantidadStatusActividad="";
			$i=0;			
			//se consultan los procesos
			while($rowP=mysql_fetch_array($resP)){
				$arrayIds[$i]=$rowP["id_proceso"];//se almacenan en el array de ids
				$nombresProcesos[$i]=$rowP["nom_proceso"];//se almacenan los nombres de los procesos
				$i+=1;
			}
			
?>
			<input type="button" value="Calcular Matriz" onclick="calcularDatosMatriz()" style="width: 120px;height: 25px;padding: 5px;">
			<table border="1" cellpadding="1" cellspacing="1" width="<?=$anchoTabla?>" style="font-size: 10px;">
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&Aacute;rea</td>
					<td style="text-align: center;background: #5882FA;color: #FFF;font-weight: bold;" colspan="<?=$nroProc;?>"><?=$rowD["nom_proyecto"];?></td>
					<td rowspan="6">&nbsp;</td>
					<td rowspan="6">&nbsp;</td>
					<td rowspan="6">&nbsp;</td>
					<td rowspan="6">&nbsp;</td>
					<td rowspan="6">&nbsp;</td>
					<td rowspan="6">&nbsp;</td>
					<td rowspan="6">&nbsp;</td>
					<td rowspan="6">&nbsp;</td>
					<td rowspan="6">&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td width="150">Cantidad por Jornada</td>
<?
			$m=0;
			for($i=0;$i<$nroProc;$i++){
?>
					<td width="300" style="text-align:center;background: #5882FA;color: #FFF;font-weight: bold;">
						
<?
			
				$sqlA="SELECT * FROM SAT_ACTIVIDAD WHERE id_proceso='".$arrayIds[$i]."'";
				$resA=mysql_query($sqlA,$this->conectarBd());
				if(mysql_num_rows($resA)==0){
					echo "( 0 )";
				}else{
					while($rowA=mysql_fetch_array($resA)){						
						$sqlAS="SELECT nom_actividad,id_proceso,id_producto,tiempo,nom_status
						FROM (SAT_ACTIVIDAD INNER JOIN ACTIVIDAD_STATUS ON SAT_ACTIVIDAD.id_actividad=ACTIVIDAD_STATUS.id_actividad) INNER JOIN SAT_STATUS ON ACTIVIDAD_STATUS.id_status=SAT_STATUS.id_status
						WHERE SAT_ACTIVIDAD.id_actividad='".$rowA["id_actividad"]."'";
						$resAS=mysql_query($sqlAS,$this->conectarBd());
						if(mysql_num_rows($resAS)==0){
							echo "( 0 )";
						}else{
							$k=0;
							while($rowAS=mysql_fetch_array($resAS)){
								$cantidadJornada="cantidadJornada".$m;
								echo "<input type='text' name='".$cantidadJornada."' id='".$cantidadJornada."' value='' style='width:50px;' />";
								$k+=1;
								$m+=1;
							}							
						}
					}
				}
			
?>						
					</td>
<?
			}
?>					
				</tr>
				<tr>
					<td width="190" style="background: yellow;color: #000;">Ajuste al Tiempo x Status</td>
					<td width="50;"><input type="text" name="ajusteAlTiempoPorStatus" id="ajusteAlTiempoPorStatus" value="0" style="width: 35px;text-align: center;">%</td>
					<td>Actividad</td>
<?
			foreach($nombresProcesos as $nombreProceso){
			
			
?>
					<td style="text-align: center;background: #5882FA;color: #FFF;font-weight: bold;"><? echo $nombreProceso;?></td>
<?
			}
			
?>					
				</tr>
				<tr>
					<td width="190px" style="background: yellow;color: #000;">Ajuste a la Capacidad de Producci&oacute;n</td>
					<td width="50px"><input type="text" name="ajusteCapacidadProduccion" id="ajusteCapacidadProduccion" value="" style="width: 35px;text-align: center;">%</td>
					<td>Tiempo X Status</td>
<?
			for($i=0;$i<$nroProc;$i++){
?>
					<td width="auto" style="text-align:center;">						
<?
			
				$sqlA="SELECT * FROM SAT_ACTIVIDAD WHERE id_proceso='".$arrayIds[$i]."'";
				$resA=mysql_query($sqlA,$this->conectarBd());
				if(mysql_num_rows($resA)==0){
					echo "( 0 )";
				}else{
					while($rowA=mysql_fetch_array($resA)){						
						$sqlAS="SELECT nom_actividad,id_proceso,id_producto,tiempo,nom_status
						FROM (SAT_ACTIVIDAD INNER JOIN ACTIVIDAD_STATUS ON SAT_ACTIVIDAD.id_actividad=ACTIVIDAD_STATUS.id_actividad) INNER JOIN SAT_STATUS ON ACTIVIDAD_STATUS.id_status=SAT_STATUS.id_status
						WHERE SAT_ACTIVIDAD.id_actividad='".$rowA["id_actividad"]."'";
						$resAS=mysql_query($sqlAS,$this->conectarBd());
						if(mysql_num_rows($resAS)==0){
							echo "( 0 )";
						}else{
							$j=0;
							while($rowAS=mysql_fetch_array($resAS)){																								
								if($tiempoPorStatusActividad==""){
									$tiempoPorStatusActividad=$rowAS["tiempo"];
								}else{
									$tiempoPorStatusActividad=$tiempoPorStatusActividad.",".$rowAS["tiempo"];
								}
								if($cantidadStatusActividad==""){
									//echo "<script type='text/javascript'>alert('".$j."');</script>";
									$cantidadStatusActividad=$cantidadStatusActividad.$j;
								}else{
									$cantidadStatusActividad=$cantidadStatusActividad.",".$j;
								}
								$ajusteCapacidad="ajusteCapacidad".$j.$i;
								echo "<input type='text' name='".$ajusteCapacidad."' id='".$ajusteCapacidad."' value='".$rowAS["tiempo"]."' style='width:50px;' />";
								$j+=1;
							}
							$cantidadStatusActividad=$cantidadStatusActividad."|";
						}
					}
				}
			
?>						
					</td>
<?
			}
?>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>Tiempo X Status (min)</td>
<?
			$n=0;
			for($i=0;$i<$nroProc;$i++){
?>
					<td width="auto" style="text-align:center;">
<?
			
				$sqlA="SELECT * FROM SAT_ACTIVIDAD WHERE id_proceso='".$arrayIds[$i]."'";
				$resA=mysql_query($sqlA,$this->conectarBd());
				if(mysql_num_rows($resA)==0){
					echo "( 0 )";
				}else{
					while($rowA=mysql_fetch_array($resA)){						
						$sqlAS="SELECT nom_actividad,id_proceso,id_producto,tiempo,nom_status
						FROM (SAT_ACTIVIDAD INNER JOIN ACTIVIDAD_STATUS ON SAT_ACTIVIDAD.id_actividad=ACTIVIDAD_STATUS.id_actividad) INNER JOIN SAT_STATUS ON ACTIVIDAD_STATUS.id_status=SAT_STATUS.id_status
						WHERE SAT_ACTIVIDAD.id_actividad='".$rowA["id_actividad"]."'";
						$resAS=mysql_query($sqlAS,$this->conectarBd());
						if(mysql_num_rows($resAS)==0){
							echo "( 0 )";
						}else{
							$k=0;
							while($rowAS=mysql_fetch_array($resAS)){
								$tiempoPorStatus="tiempoXStatusMin".$n;
								echo "<input type='text' name='".$tiempoPorStatus."' id='".$tiempoPorStatus."' value='' style='width:50px;' />";
								$k+=1;
								$n+=1;
							}							
						}
					}
				}
			
?>						
					</td>
<?
			}
?>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>D&iacute;as</td>
					<td>Status / Fecha</td>
<?
			for($i=0;$i<$nroProc;$i++){
?>
					<td width="auto" style="text-align:center;">						
<?
			
				$sqlA="SELECT * FROM SAT_ACTIVIDAD WHERE id_proceso='".$arrayIds[$i]."'";
				$resA=mysql_query($sqlA,$this->conectarBd());
				if(mysql_num_rows($resA)==0){
					echo "( 0 )";
				}else{
					while($rowA=mysql_fetch_array($resA)){						
						$sqlAS="SELECT nom_actividad,id_proceso,id_producto,tiempo,nom_status
						FROM (SAT_ACTIVIDAD INNER JOIN ACTIVIDAD_STATUS ON SAT_ACTIVIDAD.id_actividad=ACTIVIDAD_STATUS.id_actividad) INNER JOIN SAT_STATUS ON ACTIVIDAD_STATUS.id_status=SAT_STATUS.id_status
						WHERE SAT_ACTIVIDAD.id_actividad='".$rowA["id_actividad"]."'";
						$resAS=mysql_query($sqlAS,$this->conectarBd());
						if(mysql_num_rows($resAS)==0){
							echo "( 0 )";
						}else{
							$k=0;
							while($rowAS=mysql_fetch_array($resAS)){								
								echo "<input type='text' name='' id='' value='".$nombresStatus[$i]=$rowAS["nom_status"]."' style='width:50px;text-align:center;' />";
								$k+=1;
							}							
						}
					}
				}
			
?>						
					</td>
<?
			}
?>
				</tr>
<?
			$n=0;//contador renglones
			while($rowDR=mysql_fetch_array($resDR)){
				$fechaB=explode("-",$rowDR['fecha']);						
				$diaSeg=date("w",mktime(0,0,0,$fechaB[1],$fechaB[2],$fechaB[0]));
				$mesSeg=date("n",mktime(0,0,0,$fechaB[1],$fechaB[2],$fechaB[0]));
				$dias= array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","S&aacute;bado");
				$meses= array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");//<?=$rowBitacora["descripcion"].$rowBitacora["f_registro"];>
?>
				<tr>
					<td>&nbsp;</td>
					<td style="text-align: left;"><? echo $dias[$diaSeg];?></td>
					<td style="text-align: center;"><? echo $rowDR["fecha"];?></td>
<?
				$arrayTotalS=array(0,0,0);
				for($i=0;$i<$nroProc;$i++){				
					if($arrayIds[$i]==$rowDR["id_proceso"]){//si el id de los arrays es igual al proceso se escriben los valores
						$arrayValorStatusDetalle=$rowDR["status"];//se prepara la info de los status
						$arrayValorStatusDetalle=explode(",",$arrayValorStatusDetalle);
						
?>
					<td style="text-align: center;">
<?
						for($l=0;$l<count($arrayValorStatusDetalle);$l++){
							$nombreDatosDetalle="caja_"."proceso_".$arrayIds[$i]."_".$n."_".$l;
?>
						<input type="text" name="<?=$nombreDatosDetalle;?>" id="<?=$nombreDatosDetalle;?>" value="<? echo $arrayValorStatusDetalle[$l];?>" style='width:50px;font-size: 10px;text-align:center;'>
						
<?
							$arrayTotalS[$l]=$arrayTotalS[$l]+$arrayValorStatusDetalle[$l];
						}
?>
					</td>
<?
					}else{
?>
					<td>&nbsp;</td>
<?
					}
				}
?>
				</tr>
<?
				$n+=1;
			}
?>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>Cantidad Total por Status</td>
<?
				for($i=0;$i<$nroProc;$i++){					
?>
					<td style="text-align: center;">
<?
						for($l=0;$l<count($arrayValorStatusDetalle);$l++){
							$nombreDatosDetalleTotal="caja_"."proceso_total_".$arrayIds[$i]."_".$n."_".$l;
?>
						<input type="text" name="<?=$nombreDatosDetalleTotal;?>" id="<?=$nombreDatosDetalleTotal;?>" value="<?=$arrayTotalS[$l]?>" style='width:50px;font-size: 10px;text-align:center;'>
<?
						}
?>
					</td>
<?					
				}
?>					
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>Tiempo Total por Status</td>
<?
				for($i=0;$i<$nroProc;$i++){
?>
					<td>&nbsp;</td>
<?
				}
?>					
				</tr>
			</table><br><br>			
			<input type="hidden" name="hdnArrayTiempoStatus" id="hdnArrayTiempoStatus" value="<?=$tiempoPorStatusActividad;?>">
			<input type="hidden" name="hdnCantidadElementos" id="hdnCantidadElementos" value="<?=$nroProc?>">
			<input type="hidden" name="hdnCantidadStatusTiempo" id="hdnCantidadStatusTiempo" value="<?=$cantidadStatusActividad?>">
			<input type="hidden" name="hdnContadoStatusPorMin" id="hdnContadoStatusPorMin" value="<?=$n;?>">
<?
			
			
		}
		
		
		
		
		
		public function armarMatriz($noEmpleado,$fecha1,$fecha2,$tab){
			$fecha1x=explode("-",$fecha1);
			$fecha2x=explode("-",$fecha2);
			if($fecha1x[1] != $fecha2x[1]){
				echo "Verifique que las fechas concuerden con el mes a Buscar";
			}else{
				$tabMatrizDetalle="tabMatrizDetalle".$tab;
				//se buscan los datos del empleado en la tabla CAPTURA-MES
				echo "<br>".$sqlCapMes="SELECT * FROM CAP_MES WHERE no_empleado='".$noEmpleado."' AND mes='".$fecha1x[1]."'";
				$resCapMes=@mysql_query($sqlCapMes,$this->conectarBd())or die(mysql_error());
				if(mysql_num_rows($resCapMes)==0){
					echo "<div style='border-top:2px solid blue;border-bottom:2px solid blue;background:skyblue;height:20px;padding:8px;color:#000;font-weight:bold;'>No existen datos configurados para el mes seleccionado.</div>";
				}else{					
					try{
						$rowCapMes=mysql_fetch_array($resCapMes);				
						
						$meses=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
						//se empiezan a hacer los calculos
						$diasLaboradorAdmin=$rowCapMes["dias_lab"]-$rowCapMes["dias_li"]+($rowCapMes["tiem_ex"]/$rowCapMes["dias_lab"]);
						//$diasLaboradosOper=
						$minutosLaborablesxJornada=(($rowCapMes["jorna_lab"] * 60) * $rowCapMes["meta_pro"]) / 100;
						$horasLaboradasMes=$rowCapMes["jorna_lab"] * ( $rowCapMes["dias_lab"] + ( $rowCapMes["tiem_ex"] / $rowCapMes["jorna_lab"] ) - $rowCapMes["dias_li"] );
						$horasLaboradasMesProd= $horasLaboradasMes * $rowCapMes["meta_pro"];
					}catch(Exception $e){
						echo "<br>Error en el Sistema: ".$e.getMessage();
					}
					$hdnNoEmpleado="txtHdnNoEmpleado".$tabMatrizDetalle;
?>
					<input type="hidden" name="<?=$hdnNoEmpleado;?>" id="<?=$hdnNoEmpleado;?>" value="<?=$noEmpleado;?>">
					<input type="hidden" name="txtHdnFecha1" id="txtHdnFecha1" value="<?=$fecha1;?>">
					<input type="hidden" name="txtHdnFecha2" id="txtHdnFecha2" value="<?=$fecha2;?>">
					<input type="hidden" name="txtHdnMes" id="txtHdnMes" value="<?=$meses[$fecha1x[1]-1];?>"_
					<input type="hidden" name="txtHdnJornadaLaboral" id="txtHdnJornadaLaboral" value="<?=$rowCapMes["jorna_lab"];?>">
					<input type="hidden" name="txtHdnDiasLaborables" id="txtHdnDiasLaborables" value="<?=$rowCapMes["dias_lab"];?>">
					<input type="hidden" name="txtHdnDiasLicencia" id="txtHdnDiasLicencia" value="<?=$rowCapMes["dias_li"];?>">
					<input type="hidden" name="txtHdnTiempoExtra" id="txtHdnTiempoExtra" value="<?=$rowCapMes["tiem_ex"];?>">
					<input type="hidden" name="txtHdnMetaProd" id="txtHdnMetaProd" value="<?=$rowCapMes["meta_pro"];?>">
			
					<table border="1" cellpadding="1" cellspacing="1" width="300" style="font-size: 10px;margin: 5px;">
						<tr>
							<td width="230" style="background: #7DC24B;">Mes</td>
							<td width="70"><? echo $meses[$fecha1x[1]-1]; ?></td>
						</tr>
						<tr>
							<td>Jornada Laboral</td>
							<td>&nbsp;<? echo $rowCapMes["jorna_lab"];?></td>
						</tr>
						<tr>
							<td style="background: #7DC24B;">Dias Laborables</td>
							<td>&nbsp;<? echo $rowCapMes["dias_lab"]; ?></td>
						</tr>
						<tr>
							<td style="background: #7DC24B;">Dias con Licencia</td>
							<td>&nbsp;<? echo $rowCapMes["dias_li"]; ?></td>
						</tr>
						<tr>
							<td style="background: #7DC24B;">TE (Hrs)</td>
							<td>&nbsp;<? echo $rowCapMes["tiem_ex"]; ?></td>
						</tr>
						<tr>
							<td style="background: #7DC24B;">Meta Productiva</td>
							<td>&nbsp;<? echo $rowCapMes["meta_pro"]; ?></td>
						</tr>
						<tr>
							<td>Dias Laborados (Admin)</td>
							<td>&nbsp;<? echo $diasLaboradorAdmin; ?></td>
						</tr>
						<tr>
							<td>Dias Laborados Operativamente</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>Minutos Laborables por Jornada (min)</td>
							<td>&nbsp;<? echo $minutosLaborablesxJornada; ?><input type="hidden" name="hdnMinutosLaborablesJornada" id="hdnMinutosLaborablesJornada" value="<?=$minutosLaborablesxJornada?>"></td>
						</tr>
						<tr>
							<td>Horas Laboradas en el Mes al 100 % de Productividad</td>
							<td>&nbsp;<? echo $horasLaboradasMes; ?></td>
						</tr>
						<tr>
							<td>Horas Laboradas en el Mes al % de Productividad</td>
							<td>&nbsp;<? echo $horasLaboradasMesProd; ?></td>
						</tr>
						<tr>
							<td style="background: yellow;color: #000;">Cumplimiento</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td style="background: yellow;color: #000;">TE (Hrs)</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td style="background: yellow;color: #000;">Productividad por Dia</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td style="background: yellow;color: #000;">Productividad por Mes</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td style="background: yellow;color: #000;">Rendimiento</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td style="background: yellow;color: #000;">% de Scrap en el Mes</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td style="background: yellow;color: #000;">% de Rechazo en el Mes</td>
							<td>&nbsp;</td>
						</tr>
					</table>
<?
					//se buscan las actividades relacionadas al usuario
					echo "<br>".$sqlAct="SELECT * FROM ASIG_ACT INNER JOIN SAT_ACTIVIDAD ON ASIG_ACT.id_actividad = SAT_ACTIVIDAD.id_actividad WHERE ASIG_ACT.id_empleado = '".$noEmpleado."' AND SAT_ACTIVIDAD.status='Activo'";
					$resAct=mysql_query($sqlAct,$this->conectarBd());
				
					if(mysql_num_rows($resAct)==0){
						echo "No hay Actividades Relacionadas al Usuario";
					}else{
						$nombreCombo="cboActividadMatriz".$tabMatrizDetalle;
?>
					<div style="height: 20px;padding: 5px;background: #f0f0f0;border: 1px solid #CCC;">
						&nbsp;&nbsp;Seleccione la Actividad:<select name="<?=$nombreCombo;?>" id="<?=$nombreCombo;?>" onchange="cargarCapturasMatriz('<?=$tabMatrizDetalle;?>')">
						<option value="">Selecciona:</option>
<?
						while($rowAct=mysql_fetch_array($resAct)){
?>
						<option value="<?=$rowAct["id_actividad"];?>"><?=$rowAct["nom_actividad"];?></option>
<?
						}
?>
						</select>
					</div>
					<div id="<?=$tabMatrizDetalle;?>" style="border: 1px solid #ff0000;margin: 5px;"></div>
			
<?
					}
				}
			}
		}
		
		public function buscarempleado($empleado,$opcionB){
			$sqlListado=" SELECT nombres,a_paterno,a_materno,no_empleado FROM cat_personal  WHERE nombres LIKE '%".$empleado."%' AND activo='1'";			
			$resListado=mysql_query($sqlListado,$this->conectar_cat_personal()) or die(mysql_error());
			if(mysql_num_rows($resListado)==0){
?>
			<script type="text/javascript">
			    alert("Error: el empleado que busco, no tiene registro de mes. Favor de configurar datos")
			</script>
<?
			}else{
     
?>
			<table align="center" BORDER="0" CELLPADDING="0" width="90%" CELLSPACING="0" style="font-size: 12px;">
				<tr>
					<td colspan="8"><center><strong>EMPLEADOS</strong></center></td>
				</tr>
				<tr>
				    <td class="cabeceraTitulosTabla"><strong>N° Empleado</strong></td>
				    <td class="cabeceraTitulosTabla"><strong>Nombres</strong></td>
				    <td class="cabeceraTitulosTabla"><strong>Apellido Paterno</strong></td>
				    <td class="cabeceraTitulosTabla"><strong>Apellido Materno</strong></td>																																	    
				</tr>
<?          
				while($rowListado=mysql_fetch_array($resListado)){
?>
				<tr>  
				    <td class="resultadosTablaBusqueda">
<?
				if($opcionB!="N/A"){
?>
				<a href="#" onclick="ponerDAtosEmpleado2('<?=$rowListado["no_empleado"];?>','<?=$rowListado["nombres"];?>','<?=$rowListado["a_paterno"];?>','<?=$rowListado["a_materno"];?>'),cerrarVentana('buscarEmpleado')" ><?=$rowListado["no_empleado"];?></a>
<?
				}else{
?>
				<a href="#" onclick="insertarempleado('<?=$rowListado["no_empleado"];?>','<?=$rowListado["nombres"];?>','<?=$rowListado["a_paterno"];?>','<?=$rowListado["a_materno"];?>'),cerrarVentana('buscarEmpleado')" ><?=$rowListado["no_empleado"];?></a>
<?
				}
?>
					</td>
					<td class="resultadosTablaBusqueda"><?=$rowListado["nombres"];?></td>
					<td class="resultadosTablaBusqueda"><?=$rowListado["a_paterno"]?></td>
					<td class="resultadosTablaBusqueda"><?=$rowListado["a_materno"];?></td>
				</tr>  
<?
				}
?>
			</table>
<?
			}
		}
	}//fin de la clase
	//$objP=new modeloEnsamble();
	//$objP->prueba();
?>