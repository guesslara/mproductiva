<?
	/*
	 *
	*/
	session_start();	
	class modeloEnsamble{
		private $cantidadNumeroStatus;
		private $nc=0;
		private $nF=0;

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
	public function creaTabla($noEmpleado,$fechaini,$fechafin,$mlxj){
		$minlaborables=$mlxj;
		$id_empleado=$noEmpleado;
		$fecha_inicio=date($fechaini);
		$fecha_fin=date($fechafin);
		$fecha1 = explode('-',$fecha_inicio);
		$fecha_inicio1 = mktime(0,0,0,$fecha1[1],$fecha1[2],$fecha1[0]);
		$fecha = explode('-',$fecha_fin);
		$fecha_fin1 = mktime(23,59,59,$fecha[1],$fecha[2],$fecha[0]);
		$filas=round(abs(($fecha_fin1-$fecha_inicio1)/(60 * 60 * 24)));
		for($q=0;$q<$filas;$q++)
			$date[$q][0]=date("Y-m-d", mktime(0,0,0,$fecha1[1],$fecha1[2]+$q,$fecha1[0]));
		$cont=1;$poper=0;$sumaH=0;$sumaV=0;$operador=array();$x=1;$scrap=array();$mas=array();$menos=array();
		$tresmas=array();
		$CabezaAct="SELECT SAT_ACTIVIDAD.id_actividad, SAT_ACTIVIDAD.nom_actividad
				FROM ASIG_ACT
				INNER JOIN SAT_ACTIVIDAD ON ASIG_ACT.id_actividad = SAT_ACTIVIDAD.id_actividad
				WHERE id_empleado = '".$id_empleado."'";
		$resResp=mysql_query($CabezaAct,$this->conectarBd());
		$stat=array();$au=1;$act=0;$propio=1;
		$columnas=array();$txs=array();
		$columnas['']=array('Fecha');
		while($rowResp=mysql_fetch_array($resResp)){
			$CabezaStatus="SELECT SAT_STATUS.nom_status, ACTIVIDAD_STATUS.operador, ACTIVIDAD_STATUS.tiempo
				FROM ACTIVIDAD_STATUS
				INNER JOIN SAT_STATUS ON ACTIVIDAD_STATUS.id_status = SAT_STATUS.id_status
				WHERE ACTIVIDAD_STATUS.id_actividad = '".$rowResp['id_actividad']."'";
			$resResp2=mysql_query($CabezaStatus,$this->conectarBd());
			$numsta=mysql_num_rows($resResp2);
			while($rowResp2=mysql_fetch_array($resResp2)){
				if($rowResp2['tiempo']!=0){
					if($rowResp2['nom_status']=="SCRAP"){
						//echo $rowResp2['nom_status'];
						array_push($scrap, $propio);
					}else{
						if($rowResp2['operador']=="+"){
							//echo $rowResp2['operador'];
							array_push($mas, $propio);
						}else{
							//echo $rowResp2['operador'];
							array_push($menos, $propio);
						}
					}
					//echo"--$propio--<br />";
					$stat['status'.$au]=$rowResp2['nom_status'];
					$txs[$propio]=$rowResp2['tiempo'];$propio++;
					$operador[$au-1]=$rowResp2['operador'];$au++;
				}
			}
			$datos="SELECT fecha, detalle_captura_registro.status
			FROM (
				detalle_captura_registro
				INNER JOIN SAT_ACTIVIDAD ON detalle_captura_registro.id_actividad = SAT_ACTIVIDAD.id_actividad
			)
			INNER JOIN SAT_PROCESO ON SAT_ACTIVIDAD.id_proceso = SAT_PROCESO.id_proceso
			WHERE fecha
			BETWEEN '".$fecha_inicio."'
			AND '".$fecha_fin."'
			AND no_empleado = '".$id_empleado."'
			AND detalle_captura_registro.id_actividad = '".$rowResp['id_actividad']."'";
			$Mandadatos=mysql_query($datos,$this->conectarBd());
			while($ResDatos2=mysql_fetch_array($Mandadatos)){
				if($act<1){
					for($yy=0;$yy<$filas;$yy++){
						if($ResDatos2['fecha']==$date[$yy][0]){
							$x=1;
							$ca=explode(",",$ResDatos2['status']);
							for($t=0;$t<count($ca);$t++){
								if($ca[$t] != "*"){
									$date[$yy][$x]=$operador[$poper].$ca[$t];
									$x++;$poper++;
								}
							}
							$aux=$x;$poper=0;
						}
					}
				}else{
					
					for($yy=0;$yy<$filas;$yy++){
						if($ResDatos2['fecha']==$date[$yy][0]){
							$x=$aux;
							$ca=explode(",",$ResDatos2['status']);
							for($t=0;$t<count($ca);$t++){
								if($ca[$t] != "*"){
									$date[$yy][$x]=$operador[$poper].$ca[$t];
									$x++;$poper++;
								}
							}
							$poper=0;
						}
					}
				}
			}
			$columnas[$rowResp['nom_actividad']]=$stat;
			$stat=array();$au=1;$act++;$operador=array();
			$aux=$x;
		}
		$tresmas['Tiempo x Status']=$txs;
		//$tresmas['Tiempo x Status (min)']=array();
		$tresmas['cant. x Jornada']=array();$cadtxs="";
		for($k=0;$k<=count($txs);$k++){
			if($tresmas['Tiempo x Status'][$k]!=null){
				$tresmas['cant. x Jornada'][$k]=round($minlaborables/$tresmas['Tiempo x Status'][$k],2);
				$cadtxs=$cadtxs.",".$tresmas['Tiempo x Status'][$k];
			}
		}
		$cont=0;$i=0;$si=0;
		foreach($columnas as $nombre => $valor){
			$colspan[$i]=count($columnas[$nombre]);
			$i++;
		}$i=0;$cadtodo="";$ttxs=array();
		//echo"AKAKAKA $propio<pre>";
		/*print_r($tresmas);
		echo"</pre>";*/
		?>
		<table id="mytabla" class="tablita" cellspacing="1" cellpadding="1" border="1" style="font-size: 10px;margin: 5px; text-align: center;">
			<tr class="cabezas">
				<?foreach($columnas as $nombre => $valor){?>
				<td colspan="<?=$colspan[$i]?>">
					<?print $nombre;?>
				</td>
				<?$i++;}?>
			</tr>
			
			<?foreach($tresmas as $nombre => $valor){?>
			<tr class="cabezitas">
				<?for($k=0;$k<$propio;$k++){?>
				<td>
					<?
					if($k==0){
						echo $nombre;
					}else{
						echo $tresmas[$nombre][$k];
					}
					?>
				</td>
				<?}if($nombre=="cant. x Jornada"){?>
				<td rowspan="2">Total</td>
				<td rowspan="2">P</td>
				<td rowspan="2">C</td>
				<?}?>
			</tr>	
		<?}?>
			<tr>
				<?$cont=0;foreach($columnas as $nombre => $valor){
					foreach($valor as $status){
						?><td <?if($cont==0){echo"class='cabezitas'";}else{echo"class='cabezas'";}?>><?=$status;$cont++;?></td><?
					}
				}?>
			</tr>
		<?for($j=0;$j<$filas;$j++){?>
			<tr class="enlace">
			<?for($k=0;$k<($cont+3);$k++){?>
				<td>
					<?if($date[$j][$k]==null && $k<$cont){
						echo($date[$j][$k]=0);
					}else{
						echo$date[$j][$k];
					}
					$cadtodo=$cadtodo."".$date[$j][$k].",";
					if($k>=$cont){
						echo"<input type='text' id='".$j."res".$k."' name='".$j."res".$k."' readonly='' value='' style='width: 60px;' />";
					}
					?>
				</td>
			<?}
			$cadtodo=substr($cadtodo, 0, -2);
			$cadtodo=$cadtodo."*";
			$sumaH=0;?>
			</tr>
		<?}
		$cadctxs="";$smas=0;$smenos=0;$sscrap=0;$masttxs=0;
		for($k=1;$k<$cont;$k++){
			for($j=0;$j<$filas;$j++){
				$sumaV+=$date[$j][$k];
			}
			$sumaVA[$k]=$sumaV;
			$cadctxs=$cadctxs.",".$sumaV;
			$ttxs[$k]=($sumaVA[$k]*$tresmas['Tiempo x Status'][$k])/60;
			
			for($o=0;$o<count($mas);$o++){
				if($k==$mas[$o]){
					$smas+=$sumaVA[$k];
					$masttxs+=$ttxs[$k];
				}
			}
			for($o=0;$o<count($menos);$o++){
				if($k==$menos[$o]){
					$smenos+=$sumaVA[$k];
					$menosttxs+=$ttxs[$k];
				}
			}
			for($o=0;$o<count($scrap);$o++){
				if($k==$scrap[$o]){
					$sscrap+=$sumaVA[$k];
					$scrapttxs+=$ttxs[$k];
				}
			}
			$sumaV=0;
		}
		?>
			<input type="hidden" name="txtbx61" id="txtbx61" value="<?=$smas;?>">
			<input type="hidden" name="txtbz61" id="txtbz61" value="<?=$smenos;?>">
			<input type="hidden" name="txtby61" id="txtby61" value="<?=$sscrap;?>">
			<input type="hidden" name="txtbx62" id="txtbx62" value="<?=$masttxs;?>">
			<input type="hidden" name="txtbz62" id="txtbz62" value="<?=$menosttxs;?>">
			<input type="hidden" name="txtby62" id="txtby62" value="<?=$scrapttxs;?>">
			<tr class="enlace">
				<td>Cantidad Total x Status</td>
				<?for($k=1;$k<$cont;$k++){?>
					<td id="res-<?=$k;?>">
						<?=$sumaVA[$k];?>
					</td>
				<?}?>				
			</tr>
			<tr class="enlace">
				<td>Tiempo Total x Status</td>
				<?for($k=1;$k<$cont;$k++){?>
					<td>
						<?=round($ttxs[$k],2);?>
					</td>
				<?}?>	
			</tr>
			<tr class="enlace">
				<td colspan="<?=$cont?>">Suma del Total</td>
				<td><input type='text' id='tdlt' name='tdlt' readonly="" value='' style='width: 60px;' /></td>
			</tr>
			<tr class="enlace">
				<td colspan="<?=$cont?>">Totales del Rango</td>
				<td><input type='text' id='cont' name='cont' readonly="" value='' style='width: 60px;' /></td>
				<td><input type='text' id='sump' name='sump' readonly="" value='' style='width: 60px;' /></td>
				<td><input type='text' id='sumc' name='sumc' readonly="" value='' style='width: 60px;' /></td>
			</tr>
		</table>
		<input type="button" value="calcular" onclick="cambioAj('<?=$cadtxs?>','<?=$cadctxs?>','<?=$cadtodo?>','<?=$grups?>');" />
		<?
	}
		public function armaDetalleMatriz($noEmpleado,$fecha1,$fecha2,$idActividad){
			echo "<br>Consulta 1 ".$sqlD="SELECT SAT_ACTIVIDAD.id_actividad, SAT_ACTIVIDAD.nom_actividad, SAT_PROCESO.id_proceso, SAT_PROCESO.nom_proceso, SAT_PROYECTO.id_proyecto, SAT_PROYECTO.nom_proyecto
			FROM (SAT_ACTIVIDAD INNER JOIN SAT_PROCESO ON SAT_ACTIVIDAD.id_proceso = SAT_PROCESO.id_proceso) INNER JOIN SAT_PROYECTO ON SAT_PROCESO.id_proyecto = SAT_PROYECTO.id_proyecto WHERE id_actividad ='".$idActividad."'";
			$resD=mysql_query($sqlD,$this->conectarBd());
			$rowD=mysql_fetch_array($resD);			
			//consulta para los procesos
			echo "<br>Consulta 2 ".$sqlP="SELECT id_proceso,nom_proceso,id_proyecto FROM SAT_PROCESO WHERE id_proyecto='".$rowD["id_proyecto"]."'";
			$resP=mysql_query($sqlP,$this->conectarBd());			
			$nroProc=mysql_num_rows($resP);//numero de procesos
			$anchoTabla=($nroProc*180)+800;//se calcula en ancho de la tabla
			//consulta con los detalles de las capturas de las actividades
			echo "<br> Consulta 3 ".$sqlDR="SELECT * FROM `detalle_captura_registro` WHERE fecha BETWEEN '".$fecha1."' AND '".$fecha2."' AND no_empleado = '".$noEmpleado."' AND id_actividad='".$idActividad."' ORDER BY fecha";
			echo "<br>Consulta 4 ".$sqlDR="SELECT id, no_empleado, detalle_captura_registro.id_actividad, nom_actividad, detalle_captura_registro.status, fecha, hora, SAT_PROCESO.id_proceso, nom_proceso
			FROM (detalle_captura_registro INNER JOIN SAT_ACTIVIDAD ON detalle_captura_registro.id_actividad = SAT_ACTIVIDAD.id_actividad) INNER JOIN SAT_PROCESO ON SAT_ACTIVIDAD.id_proceso = SAT_PROCESO.id_proceso
			WHERE fecha BETWEEN '".$fecha1."' AND '".$fecha2."' AND no_empleado = '".$noEmpleado."' AND detalle_captura_registro.id_actividad = '".$idActividad."'";
			$resDR=mysql_query($sqlDR,$this->conectarBd());
			echo "<br> Consulta 5 ".$sqlStatusCuenta="SELECT *
			FROM ACTIVIDAD_STATUS INNER JOIN SAT_STATUS ON ACTIVIDAD_STATUS.id_status = SAT_STATUS.id_status
			WHERE id_actividad = '".$idActividad."'";
			$resStatusCuenta=mysql_query($sqlStatusCuenta,$this->conectarBd());
			$resStatusCuenta1=mysql_query($sqlStatusCuenta,$this->conectarBd());
			$resStatusCuenta2=mysql_query($sqlStatusCuenta,$this->conectarBd());
			$resStatusCuenta3=mysql_query($sqlStatusCuenta,$this->conectarBd());
			
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
			<input type="button" value="Ver Matriz" onclick="calcularDatosMatriz()" style="width: 120px;height: 25px;padding: 5px;">
			<table border="0" cellpadding="1" cellspacing="1" width="<?=$anchoTabla?>" style="font-size: 10px;border: 1px solid #CCC;background:#f0f0f0;">
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td style="border: 1px solid #CCC;">&Aacute;rea</td>
					<td style="text-align: center;background: #5882FA;color: #FFF;font-weight: bold;" colspan="<?=$nroProc;?>"><?=$rowD["nom_proyecto"];?></td>
<?
				while($rowStatusCuenta=mysql_fetch_array($resStatusCuenta)){
?>
					<td rowspan="6" style="border: 1px solid #000;background: #CCC;text-align: center;font-weight: bold;"><?=$rowStatusCuenta["nom_status"];?>&nbsp;</td>
<?
				}
				while($rowStatusCuenta1=mysql_fetch_array($resStatusCuenta1)){
?>
					<td rowspan="6" style="border: 1px solid #000;background: #CCC;text-align: center;font-weight: bold;"><?=$rowStatusCuenta1["nom_status"];?>&nbsp;</td>
<?
				}
?>

					<td rowspan="6" style="border: 1px solid #000;background: #CCC;text-align: center;font-weight: bold;">Total&nbsp;</td>
					<td rowspan="6" style="border: 1px solid #000;background: #CCC;text-align: center;font-weight: bold;">P&nbsp;</td>
					<td rowspan="6" style="border: 1px solid #000;background: #CCC;text-align: center;font-weight: bold;">C&nbsp;</td>
					<td rowspan="6">&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td width="150" style="border: 1px solid #CCC;">Cantidad por Jornada</td>
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
								echo "<input type='text' name='".$cantidadJornada."' id='".$cantidadJornada."' value='' style='width:50px;text-align:center;background: #FFF;color: #000;border: 1px solid #CCC;' />";
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
					<td style="border: 1px solid #CCC;">Actividad</td>
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
					<td style="border: 1px solid #CCC;">Tiempo X Status</td>
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
					<td style="border: 1px solid #CCC;">Tiempo X Status (min)</td>
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
					<td style="border: 1px solid #CCC;">D&iacute;as</td>
					<td style="border: 1px solid #CCC;">Status / Fecha</td>
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
			$arrayTotalS=array(0,0,0);

			while($rowDR=mysql_fetch_array($resDR)){
				$fechaB=explode("-",$rowDR['fecha']);						
				$diaSeg=date("w",mktime(0,0,0,$fechaB[1],$fechaB[2],$fechaB[0]));
				$mesSeg=date("n",mktime(0,0,0,$fechaB[1],$fechaB[2],$fechaB[0]));
				$dias= array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","S&aacute;bado");
				$meses= array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");//<?=$rowBitacora["descripcion"].$rowBitacora["f_registro"];>
				
?>
				<tr>
					<td>&nbsp;</td>
					<td style="text-align: left;border-bottom: 1px solid #666;"><? echo $dias[$diaSeg];?></td>
					<td style="text-align: center;border-bottom: 1px solid #666;"><? echo $rowDR["fecha"];?></td>
<?
				$nC=0;
				for($i=0;$i<$nroProc;$i++){
					
					if($arrayIds[$i]==$rowDR["id_proceso"]){//si el id de los arrays es igual al proceso se escriben los valores
						$arrayValorStatusDetalle=$rowDR["status"];//se prepara la info de los status
						$arrayValorStatusDetalle=explode(",",$arrayValorStatusDetalle);
						$this->cantidadNumeroStatus=count($arrayValorStatusDetalle);						
?>
					<td style="text-align: center;border-bottom: 1px solid #666;">
<?
						for($l=0;$l<count($arrayValorStatusDetalle);$l++){
							$cajaMatriz="cajaMatriz_".$n."_".$nC;
							
							$nombreDatosDetalle="caja_"."proceso_".$arrayIds[$i]."_".$n."_".$l;
?>
						<!--<input type="text" name="<?=$nombreDatosDetalle;?>" id="<?=$nombreDatosDetalle;?>" value="<? echo $arrayValorStatusDetalle[$l];?>" style='width:50px;font-size: 10px;text-align:center;background: #FFF;color: #000;'>-->
						<input type="text" name="<?=$cajaMatriz;?>" id="<?=$cajaMatriz;?>" value="<? echo $arrayValorStatusDetalle[$l];?>" style='width:50px;font-size: 10px;text-align:center;background: #FFF;color: #000;border: 1px solid #CCC;'>
						
<?
							$arrayTotalS[$l]=$arrayTotalS[$l]+$arrayValorStatusDetalle[$l];
							$nC+=1;
						}
?>
					</td>
<?
					}else{
?>
					<td style="text-align: center;border-bottom: 1px solid #666;">
<?
						for($l=0;$l<count($arrayValorStatusDetalle);$l++){
							$cajaMatriz="cajaMatriz_".$n."_".$nC;
							
?>
						<input type="text" name="<?=$cajaMatriz;?>" id="<?=$cajaMatriz;?>" value="0" style='width:50px;font-size: 10px;text-align:center;background: #FFF;color: #000;border: 1px solid #CCC;'>
<?
							$nC+=1;
						}
?>
					</td>
<?
					}
				}
				/*Se mandan los valores hacia las columnas*/
				$this->nc=$nC;
				/*Fin de la escritura de valores de columnas*/
				
				//columnas adicionales
				$sqlStatusCuenta="SELECT *
				FROM ACTIVIDAD_STATUS INNER JOIN SAT_STATUS ON ACTIVIDAD_STATUS.id_status = SAT_STATUS.id_status
				WHERE id_actividad = '".$idActividad."'";
				$resColumnasAd=mysql_query($sqlStatusCuenta,$this->conectarBd());
				$resColumnasAd1=mysql_query($sqlStatusCuenta,$this->conectarBd());
				/*********************************************/
				$sqlCantStatus="SELECT status
					FROM `detalle_captura_registro`
					WHERE fecha = '".$rowDR["fecha"]."' AND no_empleado = '".$noEmpleado."' AND id_actividad = '".$idActividad."' ORDER BY fecha";
				$resCantStatus=mysql_query($sqlCantStatus,$this->conectarBd());
				$rowCantStatus=mysql_fetch_array($resCantStatus);
				$cantStatus=$rowCantStatus["status"];
				$cantStatus=explode(",",$cantStatus);
				$s=0;
				while($rowStatusCuenta2=mysql_fetch_array($resColumnasAd)){
					
?>
					<td><input type="text" name="" id="" style="width: 60px;text-align: center;font-size: 10px;" value="<?=$cantStatus[$s];?>"></td>
<?
					$s+=1;
				}
				$z=0;
				while($rowStatusCuenta3=mysql_fetch_array($resColumnasAd1)){
					$nombreCajaResultStatusMulti="statusTotalMulti_".$n."_".$z;
?>
					<td><input type="text" name="<?=$nombreCajaResultStatusMulti;?>" id="<?=$nombreCajaResultStatusMulti;?>" style="width: 60px;" value="0"></td>
<?
					$z+=1;
				}
?>
					
					<td><input type="text" name="" id="" style="width: 60px;"></td>
					<td><input type="text" name="" id="" style="width: 60px;"></td>
					<td><input type="text" name="" id="" style="width: 60px;"></td>
					
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
				$aa=0;
				for($i=0;$i<$nroProc;$i++){					
?>
					<td style="text-align: center;">
<?
						for($l=0;$l<count($arrayValorStatusDetalle);$l++){
							//$nombreDatosDetalleTotal="cantidadTotalxStatus_".$i."_".$l;
							$nombreDatosDetalleTotal="cantidadTotalxStatus_".$aa;
?>
						<!--<input type="text" name="<=$nombreDatosDetalleTotal;?>" id="<=$nombreDatosDetalleTotal;?>" value="<=$arrayTotalS[$l]?>" style='width:50px;font-size: 10px;text-align:center;'>-->
						<input type="text" name="<?=$nombreDatosDetalleTotal;?>" id="<?=$nombreDatosDetalleTotal;?>" style='width:50px;font-size: 10px;text-align:center;background: #FFF;color: #000;border: 1px solid #CCC;'>
<?
						$aa+=1;
						}
?>
					</td>
<?					
				}
				//columnas adicionales
				$sqlStatusCuenta="SELECT *
				FROM ACTIVIDAD_STATUS INNER JOIN SAT_STATUS ON ACTIVIDAD_STATUS.id_status = SAT_STATUS.id_status
				WHERE id_actividad = '".$idActividad."'";
				$resColumnasTot=mysql_query($sqlStatusCuenta,$this->conectarBd());
				while($rowColumnasTot=mysql_fetch_array($resColumnasTot)){
?>
					<td><input type="text" name="" id="" style="width: 60px;"></td>
<?
				}
?>					
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>Tiempo Total por Status</td>
<?
				$aa=0;
				for($i=0;$i<$nroProc;$i++){
?>
					<td style="text-align: center;">
<?
						for($l=0;$l<count($arrayValorStatusDetalle);$l++){
							$nombreDatosDetalleTotal="cajaTiempoTotalXStatus".$aa;
?>
						<input type="text" name="<?=$nombreDatosDetalleTotal;?>" id="<?=$nombreDatosDetalleTotal;?>" value="0" style='width:50px;font-size: 10px;text-align:center;background: #FFF;color: #000;border: 1px solid #CCC;'>
<?
							$aa+=1;
						}
?>
					</td>
<?
				}
				//columnas adicionales
				$sqlStatusCuenta="SELECT *
				FROM ACTIVIDAD_STATUS INNER JOIN SAT_STATUS ON ACTIVIDAD_STATUS.id_status = SAT_STATUS.id_status
				WHERE id_actividad = '".$idActividad."'";
				$resColumnasTot1=mysql_query($sqlStatusCuenta,$this->conectarBd());
				while($rowColumnasTot1=mysql_fetch_array($resColumnasTot1)){
?>
					<td><input type="text" name="" id="" style="width: 60px;"></td>
<?
				}
?>					
				</tr>
			</table><br><br>			
			<input type="hidden" name="hdnArrayTiempoStatus" id="hdnArrayTiempoStatus" value="<?=$tiempoPorStatusActividad;?>">
			<input type="hidden" name="hdnCantidadElementos" id="hdnCantidadElementos" value="<?=$nroProc?>">
			<input type="hidden" name="hdnCantidadStatusTiempo" id="hdnCantidadStatusTiempo" value="<?=$cantidadStatusActividad?>">
			<input type="hidden" name="hdnContadoStatusPorMin" id="hdnContadoStatusPorMin" value="<?=$n;?>">
			<input type="hidden" name="hdnCantidadNumeroStatus" id="hdnCantidadNumeroStatus" value="<?=$this->cantidadNumeroStatus;?>">
			<input type="hidden" name="hdnNumeroColumnas" id="hdnNumeroColumnas" value="<?=$this->nc;?>">
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
				//echo "<br>".
				$sqlCapMes="SELECT * FROM CAP_MES WHERE no_empleado='".$noEmpleado."' AND mes='".$fecha1x[1]."'";
				$resCapMes=@mysql_query($sqlCapMes,$this->conectarBd())or die(mysql_error());
				if(mysql_num_rows($resCapMes)==0){
					echo "<div style='border-top:2px solid blue;border-bottom:2px solid blue;background:skyblue;height:20px;padding:8px;color:#000;font-weight:bold;'>No existen datos configurados para el mes seleccionado.</div>";
				}else{					
					try{
						$rowCapMes=mysql_fetch_array($resCapMes);				
						
						$meses=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
						//se empiezan a hacer los calculos
						$diasLaboradorAdmin=$rowCapMes["dias_lab"]-$rowCapMes["dias_li"]+($rowCapMes["tiem_ex"]/$rowCapMes["jorna_lab"]);
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
					<input type="hidden" name="txtHlabxMes" id="txtHlabxMes" value="<?=$horasLaboradasMes;?>">
					<input type="hidden" name="txtHdnFecha2" id="txtHdnFecha2" value="<?=$fecha2;?>">
					<input type="hidden" name="txtHdnMes" id="txtHdnMes" value="<?=$meses[$fecha1x[1]-1];?>">
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
							<td>&nbsp;<? echo round($diasLaboradorAdmin,2); ?></td>
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
							<td>&nbsp;<input type="text" id="cumpli" name="cumpli" readonly="" value="" style="width: 60px;" /></td>
						</tr>
						<tr>
							<td style="background: yellow;color: #000;">TE (Hrs)</td>
							<td>&nbsp;<input type="text" id="te" name="te" readonly="" value="" style="width: 60px;" /></td>
						</tr>
						<tr>
							<td style="background: yellow;color: #000;">Productividad por Dia</td>
							<td>&nbsp;<input type="text" id="pxd" name="pxd" readonly="" value="" style="width: 60px;" /></td>
						</tr>
						<tr>
							<td style="background: yellow;color: #000;">Productividad por Mes</td>
							<td>&nbsp;<input type="text" id="pxm" name="pxm" readonly="" value="" style="width: 60px;" /></td>
						</tr>
						<tr>
							<td style="background: yellow;color: #000;">Rendimiento</td>
							<td>&nbsp;<input type="text" id="rendi" name="rendi" readonly="" value="" style="width: 60px;" /></td>
						</tr>
						<tr>
							<td style="background: yellow;color: #000;">% de Scrap en el Mes</td>
							<td>&nbsp;<input type="text" id="scrapxr" name="scrapxr" readonly="" value="" style="width: 60px;" /></td>
						</tr>
						<tr>
							<td style="background: yellow;color: #000;">% de Rechazo en el Mes</td>
							<td>&nbsp;<input type="text" id="rechazoxr" name="rechazoxr" readonly="" value="" style="width: 60px;" /></td>
						</tr>
					</table>
<?
					//se buscan las actividades relacionadas al usuario
					//echo "<br>".
					$sqlAct="SELECT * FROM ASIG_ACT INNER JOIN SAT_ACTIVIDAD ON ASIG_ACT.id_actividad = SAT_ACTIVIDAD.id_actividad WHERE ASIG_ACT.id_empleado = '".$noEmpleado."' AND SAT_ACTIVIDAD.status='Activo'";
					$resAct=mysql_query($sqlAct,$this->conectarBd());
				
					if(mysql_num_rows($resAct)==0){
						echo "No hay Actividades Relacionadas al Usuario";
					}else{
						$nombreCombo="cboActividadMatriz".$tabMatrizDetalle;
?>
					<div style="height: 20px;padding: 5px;background: #f0f0f0;border: 1px solid #CCC;">
						<input type="button" value="Ver Matriz" onclick="crear();" />
					</div>
					<div id="tabMatrizDetalle2" style="border: 1px solid #CCC;margin: 5px;"></div>
			
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
	//$objP->armaDetalleMatriz();
?>