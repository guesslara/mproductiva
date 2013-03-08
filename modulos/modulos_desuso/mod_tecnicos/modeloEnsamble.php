<?
	/*
	 *modeloEnsamble:  Clase del modulo mod_tecnicos realiza las asignaciones y re-Asignaciones para cada uno de los Items,
	 ademas de poder dar de alta y/o baja a los tecnicos involucrados en el proyecto
	 *Autor: Rocio Manuel Aguilar
	 *Fecha:29/Nov/2012
	 __________________________________________________________________________
	*/
	session_start();
	include("../../clases/funcionesComunes.php");
	include("../../clases/cargaInicial.php");
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

		public function mostrarLotesProyecto($idProyecto,$opt){
			//print_r($idProyecto);
			$objCargaInicial=new verificaCargaInicial();
			$con="SELECT * FROM lote WHERE id_proyecto='".$idProyecto."'";
			$cons=mysql_query($con,$this->conectarBd());
			$name_pro=$objCargaInicial->dameNombreProyecto($idProyecto);
			if(mysql_num_rows($cons)==0){
				echo"No hay registros que mostrar";
			}else{
?>		 
				<h3 align="center">Linea <?=$name_pro;?></h3>
				<br><table border="1" align="center" style="font-size: 12px;">
				<tr>
				    <th colspan="8" align="left"><?=$opt?></th>
				</tr>				
				<tr>
				    <th colspan="8">LOTES</th>
				</tr>
				<tr>
				    <th># Lote</th>
				    <? if ($idProyecto==1){
				    ?>
				    <th>Pre-Alerta</th>
				    <?	
				    }
				     if ($idProyecto==2){
				    ?>
				    <th>Num PO</th>
				    <?
				    }
				    ?>
				    <th>No. Item</th>
				    <th>Fecha Registro</th>
				    <th>Status</th>
				    <th>TAT</th>
		
				</tr>
<?
				while($row=mysql_fetch_array($cons)){
				$fechaB=explode("-",$row['fecha_tat']);						
				$diaSeg=date("w",mktime(0,0,0,$fechaB[1],$fechaB[2],$fechaB[0]));
				$mesSeg=date("n",mktime(0,0,0,$fechaB[1],$fechaB[2],$fechaB[0]));
				$dias= array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","S&aacute;bado");
				$meses= array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
?>
				<tr>
					<?if($opt=="Inicio"){?>
					 <td><a href="#" onclick="consultaDetalleLote('<?=$row['id_lote'];?>','<?=$idProyecto;?>','<?=$row['numero_items'];?>','Inicio')" title="Lote <?=$row['id_lote']?>"><?=$row['id_lote'];?></a></td>
					<?}?>
					<?if($opt=="Asigna"){?>
					 <td><a href="#" onclick="consultaDetalleLote('<?=$row['id_lote'];?>','<?=$idProyecto;?>','<?=$row['numero_items'];?>','Asigna')" title="Lote <?=$row['id_lote']?>"><?=$row['id_lote'];?></a></td>
					<?}?>
					<?if($opt=="Re-Asigna"){?>
					 <td><a href="#" onclick="consultaDetalleLote('<?=$row['id_lote'];?>','<?=$idProyecto;?>','<?=$row['numero_items'];?>','Re-Asigna')" title="Lote <?=$row['id_lote']?>"><?=$row['id_lote'];?></a></td>
					<?}?>
				    <td><?=$row['num_po'];?></td>
				    <td><?=$row['numero_items'];?></td>
				    <td><?=$row['fecha_reg'];?></td>
				    <td><?=$row['status'];?></td>
				    <td>El <?=$dias[$diaSeg]." ".$fechaB[2]." de ".$meses[$mesSeg-1]." de ".$fechaB[0]." a las ".$row['hora_reg']. " se liberar&aacute";?> </td>
				</tr>
<?
				}
				echo "</table>";
			}
		}//fin function mostrarLotesProyecto
		public function consultaDetalleLote($id_lote,$id_proyecto,$noItem,$opt){
			
			if($opt=="Inicio"){
			$Reg_lote="SELECT * from detalle_lote where id_lote=$id_lote";
			}
			if($opt=="Re-Asigna"){
			$Reg_lote="SELECT * from detalle_lote where id_lote=$id_lote and id_tecnico!=0";
			}
			if($opt=="Asigna"){
			$Reg_lote="SELECT * from detalle_lote where id_lote=$id_lote and id_tecnico=0";
			}
			//print_r($Reg_lote);
			//exit;
			$reg_loteCon=mysql_query($Reg_lote,$this->conectarBd());
			if(mysql_num_rows($reg_loteCon)==0){
				if($opt=="Asigna"){
					?><script type="text/javascript">clean2();alert("Actualmente todos los items estan asignados o bien el lote se encuentra vacio")</script><?
				}
				if($opt=="Inicio"||$opt=="Re-Asigna"){
					?><script type="text/javascript">clean2();alert("No hay Elementos que mostrar o los Items han sido asignados")</script><?
				}
			}
			else{
?>
			    <br><br><h3>Lote <?=$id_lote?></h3>
			    <table border="1" align="center">
				<tr>
                                        <th colspan=9>Detalle del lote #<?=$id_lote?></th>
				</tr>
				<tr>
					<th>#</th>
					<th>Num parte</th>
					<th>Modelo</th>
					<th>Code Type</th>
					<?if($id_proyecto==2){?>
						<th>Flow Tag</th>
					<?}
					else{}?>
					<th>Num Serie</th>
					<th>Fecha</th>
					<th>Hora</th>
					<th>T&eacute;cnico</th>
				</tr>
<?
				$i=1;
				while ($row=mysql_fetch_array($reg_loteCon)){
					$DATE=date('Y-m-d');
					$HOUR=date('G:i:s');
?>
				<tr>
					<td align="center"><?=$i?></td>
					<?$i++;?>
					<td align="center"><?=$row['Numparte']?></td>
					<td align="center"><?=$row['modelo']?></td>
					<td align="center"><?=$row['codeType']?></td>
					<?if($id_proyecto==2){?>
						<td align="center"><?=$row['flowTag']?></td>
					<?}
					else{}?>
					<td align="center"><?=$row['numSerie']?></td>
					<td align="center"><?=$row['fecha_registro']?></td>
					<td align="center"><?=$row['hora_registro']?></td>
					<?
					$queryName="Select * from userdbcontroloperaciones where ID='".$row['id_tecnico']."'";
					$playQuery=mysql_query($queryName,$this->conectarBd());
					$rowName=mysql_fetch_array($playQuery);
					$nameAc=$rowName['nombre']." ".$rowName['apaterno'];
					if($opt=="Inicio"){
					?>
						<td>
							<input type="text" style="width:auto;height:20px;background-color:transparent;color:black;font-size:10pt; font-family:Verdana;text-align:center; border: hidden"  name="tecnico" id="tecnico" value="<?=$nameAc?>" readonly>
						</td>
					<?
					}
					if($opt=="Asigna"){
					?>
					
					<td align="center">
							<select name="tecnico" id="tecnico" onchange = "guardalo(this,'<?=$id_proyecto;?>',<?=$row['id_partes'];?>,'<?=$opt?>')">

							?><option value="">Selecciona Tecnico</option>
							<?
							$queryTecnicos="Select * from userdbcontroloperaciones where grupo2=2 and activo=1";
							$playQueryTecnicos=mysql_query($queryTecnicos,$this->conectarBd());
							while($rowTecnicos=mysql_fetch_array($playQueryTecnicos)){
								$name=$rowTecnicos['nombre']." ".$rowTecnicos['apaterno'];
							?><option value="<?=$rowTecnicos['ID']?>"><?=$name;?></option><?
							}
						?>
						</select>
					</td>
					<?}
					if($opt=="Re-Asigna"){
					?>
					
					<td align="center">
						<select name="tecnico" id="tecnico" onchange = "guardalo(this,'<?=$id_proyecto;?>',<?=$row['id_partes'];?>,'<?=$opt?>')">

							?><option value="<?=$row['id_tecnico']?>"><?=$nameAc?></option>
							<?
							$queryTecnicos="Select * from userdbcontroloperaciones where grupo2=2 and activo=1";
							$playQueryTecnicos=mysql_query($queryTecnicos,$this->conectarBd());
							while($rowTecnicos=mysql_fetch_array($playQueryTecnicos)){
								$name=$rowTecnicos['nombre']." ".$rowTecnicos['apaterno'];
								
							?><option value="<?=$rowTecnicos['ID']?>"><?=$name;?></option><?
							}
						?>
						</select>
					</td>
					<?}?>
				</tr>
<?
				}
			  ?></table><?
			}
		}//fin de consulta
		
		public function guardaTec($id_tecnico,$id_proyecto,$idPartes,$opt){
			$insertaTec="UPDATE detalle_lote SET id_tecnico=$id_tecnico, status='Asignado' WHERE id_partes=$idPartes";
			$ejecutaUp=mysql_query($insertaTec,$this->conectarBd());
			 if(!$ejecutaUp){
				?><script type="text/javascript">clean2();alert("No se pudo asignar tecnico intente de nuevo")</script><?
			 }
			 else{
				?><script type="text/javascript">clean2(); mostrarLotes(<?=$id_proyecto;?>,<?=$opt?>); </script><?
				
				
			 }
		}
		public function AB(){
			$tec="Select * from userdbcontroloperaciones where grupo2=2";
			$ejecTec=mysql_query($tec,$this->conectarBd());
			?><br><br>
				<h3 align="center">Altas y Bajas de Tecnicos</h3>
			<br><table border=1 align="center">
				<tr align="center">
					<th colspan=5>Seleccione 1=Activado 0=Desactivado</th>
				</tr>
				<tr align="center">
					<th>#</th>
					<th>Usuario</th>
					<th>Nombre</th>
					<th>A. Paterno</th>
					<th>Activo</td>
				</tr><?
			$i=1;
			while($rowTec=mysql_fetch_array($ejecTec)){
				?>

				<tr align="center">
					<td><?=$i;?></td>
					<td><?=$rowTec['usuario'];?></td>
					<td><?=$rowTec['nombre'];?></td>
					<td><?=$rowTec['apaterno'];?></td>
					<td>
						<select name="status" id="status" onchange = "changeStatus(this,<?=$rowTec['ID'];?>)">
						<option value="<?=$rowTec['activo']?>"><?=$rowTec['activo']?></option>
						<option value="1">1</option>
						<option value="0">0</option>
						</select>
					</td>
				</tr>
				<?
				$i++;
			}
			?></table><?
		}
		public function status($status,$ID){
			$act="UPDATE userdbcontroloperaciones SET activo=$status where ID=$ID";
			$act1=mysql_query($act,$this->conectarBd());
			 if(!$act1){
				echo"No se puede actualizar el status";
			 }
			 else{
				?><script type="text/javascript">clean2(); AB(); </script><?
			 }
			
		}
		
	}//fin de la clase
?>
