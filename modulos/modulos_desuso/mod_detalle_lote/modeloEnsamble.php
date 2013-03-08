<?
	/*
	 *modeloEnsamble:clase que realiza la inserción, modificación y consulta tanto de lotes como del detalle de los Items ingresados en cada uno de los lotes
	 *Autor: Rocio Manuel Aguilar
	 *Fecha:20/Nov/2012
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

		public function mostrarLotesProyecto($idProyecto){
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
				    <td><a href="#" onclick="consultaDetalleLote('<?=$row['id_lote'];?>','<?=$idProyecto;?>','<?=$row['numero_items'];?>')" title="Lote <?=$row['id_lote']?>"><?=$row['id_lote'];?></a></td>
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
		public function consultaDetalleLote($id_lote,$id_proyecto,$noItem){
			?><form><input type="hidden" name="id_lote" id="id_lote" value="<?=$id_lote;?>"><input type="hidden" name="id_proyecto" id="id_proyecto" value="<?=$id_proyecto;?>"><input type="hidden" name="noItem" id="noItem" value="<?=$noItem;?>"></form><?
			?>| <a href="#" onclick="consulta('document.getElementsBy(hidden)')">Consultar</a>  |  <a href="#" onclick="formAgrega('document.getElementsBy(hidden)')">Agregar</a>  |  <a href="#" onclick="consultaModifica('document.getElementsBy(hidden)')">Modificar</a>  |<?
			$Reg_lote="SELECT * from detalle_lote where id_lote=$id_lote";
			$reg_loteCon=mysql_query($Reg_lote,$this->conectarBd());
			if(mysql_num_rows($reg_loteCon)==0){
			    echo "<br><br>Este lote se encuentra vacio";
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
					<?if($id_proyecto==2){?>
					<th>Code Type</th>
					<?}else{}if($id_proyecto==2){?>
						<th>Flow Tag</th>
					<?}
					else{}?>
						<th>Num Serie</th>
					<th>Fecha</th>
					<th>Hora</th>
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
					<?if($id_proyecto==2){?>
					<td align="center"><?=$row['codeType']?></td>
					<?}
					else{}
					if($id_proyecto==2){?>
						<td align="center"><?=$row['flowTag']?></td>
					<?}
					else{}?>
					<td align="center"><?=$row['numSerie']?></td>
					<td align="center"><?=$row['fecha_registro']?></td>
					<td align="center"><?=$row['hora_registro']?></td>
				</tr>
<?
				}
			  ?></table><?
			}
		}//fin de consulta
		public function formAgrega($id_lote,$id_proyecto,$noItem){
    			$DATE=date('Y-m-d');
			$HOUR=date('G:i:s');
			?><form><input type="hidden" name="id_lote" id="id_lote" value="<?=$id_lote;?>"><input type="hidden" name="id_proyecto" id="id_proyecto" value="<?=$id_proyecto;?>"><input type="hidden" name="noItem" id="noItem" value="<?=$noItem;?>"></form><?
			?>|<a href="#" onclick="consulta('document.getElementsBy(hidden)')">Consultar</a>  |  <a href="#" onclick="formAgrega('document.getElementsBy(hidden)')">Agregar</a>  |  <a href="#" onclick="consultaModifica('document.getElementsBy(hidden)')">Modificar</a>  |<?
			?><br><br><h3>Lote <?=$id_lote?></h3>
				<table align="center"><form name="agrega" id="agrega">
					<tr>
						<th colspan=2  align="center">Detalle del lote #<?=$id_lote?></th>
					</tr>
					<tr>
						<th colspan=2 align="right"><input type="text" style="width:80px;height:20px;background-color:transparent;color:black;font-size:10pt; font-family:Verdana;text-align:center; border: hidden" name="date" id="date" value="<?=$DATE?>" readonly>  <input type="text" style="width:80px;height:20px;background-color:transparent;color:black;font-size:10pt; font-family:Verdana;text-align:center; border: hidden"  name="hour" id="hour" value="<?=$HOUR?>" readonly></th>
					</tr>
					<tr>	
						<th  align="left">Num parte</th>
						<td><input type="text"name="noParte" id="noParte" onkeyup="this.value = this.value.replace (/[^aA-zZ\^0-9]/, ''); " ></td>
					</tr>
					<tr>
						<th  align="left">Modelo</th>
						<td><input type="text" name="modelo" id="modelo" onkeyup="this.value = this.value.replace (/[^aA-zZ\^0-9]/, ''); " ></td>		    
					</tr>
					<?if($id_proyecto==2){?>
					<tr>
						<th  align="left">Code Type</th>
						<td><input type="text" name="codeType" id="codeType" onkeyup="this.value = this.value.replace (/[]/, ''); "></td>		    
					</tr>
					<?}
					else{}
					if($id_proyecto==2){?>
					<tr>
						<th  align="left">Flow Tag</th>
						<td><input type="text" name="flowTag" id="flowTag" ></td>
					</tr>
					<?}
					else {}?>
					<tr>
						<th  align="left">Num Serie</th>
						<td><input type="text" name="numSerie" id="numSerie" onkeyup="this.value = this.value.replace (/[]/, ''); "></td>	    
					</tr>
					<tr>
						<th align="left">Descripci&oacute;n</th>
						<td><textarea name="desc" id="desc" maxlength="100" ></textarea></td>
					</tr>
					<tr>
						<td colspan=2 align="right"><input type="button" name="envia" id="envia" value="Guardar" onclick="agregar('document.getElementsBy(hidden)')"><input type="reset" name="reset" id="reset" value="Borrar"></td>
					</tr>
				</table></form><?
		}
		public function agregar($noParte,$modelo,$codeType,$flowTag,$numSerie,$fechaReg,$horaReg,$desc,$id_lote,$id_proyecto,$noItem){
			?><form><input type="hidden" name="id_lote" id="id_lote" value="<?=$id_lote;?>"><input type="hidden" name="id_proyecto" id="id_proyecto" value="<?=$id_proyecto;?>"><input type="hidden" name="noItem" id="noItem" value="<?=$noItem;?>"></form><?
			$conPrueba="SELECT * from detalle_lote where id_lote=$id_lote";
	
			$conPrueba2=mysql_query($conPrueba,$this->conectarBd());
			$a=mysql_num_rows($conPrueba2);
				if($a < $noItem){
					$add="INSERT INTO detalle_lote (Numparte,modelo,codeType,flowTag,numSerie,descripcion,id_lote,fecha_registro,hora_registro,id_proyecto) VALUES ('".$noParte."','".$modelo."','".$codeType."','".$flowTag."','".$numSerie."','".$desc."','".$id_lote."','".$fechaReg."','".$horaReg."','".$id_proyecto."')";
					$una=mysql_query($add,$this->conectarBd());
					if(!$una){
						echo "<br>El Item no ha podido ser agregado";
					}
					else{
						echo "<br>El Item ha sido agregado satisfactoriamente";
						?><script type="text/javascript">consultaX('document.getElementsBy(hidden)'); formAgrega('document.getElementsBy(hidden)'); </script><?
					}
				}
				if($a>$noItem|| $a==$noItem){
					?><script type="text/javascript">alert("Ha sobrepasado los Items verifique los datos"); consulta('document.getElementsBy(hidden)');</script>"<?
				}
		}// fin de agregar
		public function consultaModifica($id_lote,$id_proyecto,$noItem){
			?><form><input type="hidden" name="id_lote" id="id_lote" value="<?=$id_lote;?>"><input type="hidden" name="id_proyecto" id="id_proyecto" value="<?=$id_proyecto;?>"><input type="hidden" name="noItem" id="noItem" value="<?=$noItem;?>"></form><?
			?>|<a href="#" onclick="consulta('document.getElementsBy(hidden)')">Consultar</a>  |  <a href="#" onclick="formAgrega('document.getElementsBy(hidden)')">Agregar</a>  |  <a href="#" onclick="consultaModifica('document.getElementsBy(hidden)')">Modificar</a>  |<?
			$Reg_lote="SELECT * from detalle_lote where id_lote=$id_lote";
			$reg_loteCon=mysql_query($Reg_lote,$this->conectarBd());
			if(mysql_num_rows($reg_loteCon)==0){
				echo "<br><br>A&uacute;n no hay Items agregados";
			}	
			else{
?>
				<br><br><h3>Lote <?=$id_lote?></h3><br><br>
				<table border="1" align="center" >
					<tr>
						<th colspan="10">Detalle del lote #<?=$id_lote?></th>
					</tr>
					<tr>
						<th>#</th>
						<th>Num parte</th>
						<th>Modelo</th>
						<?if($id_proyecto==2){?>
						<th>Code Type</th>
						<?} else{}
						if($id_proyecto==2){?>
						<th>Flow Tag</th>
						<?}
						else{}?>
						<th>Num Serie</th>
						<th>Fecha</th>
						<th>Hora</th>
						<th>Modificar</th>
					</tr>
<?
					$i=1;
					while ($row=mysql_fetch_array($reg_loteCon)){
					   ?>
					<tr>
					       <td><?=$i?></td>
					       <?$i++;?>
					       <td><?=$row['Numparte']?></td>
					       <td><?=$row['modelo']?></td>
						<?if($id_proyecto==2){?>
					       <td><?=$row['codeType']?></td>
					       <?}
					       else{}
					       if($id_proyecto==2){?>
					       <td><?=$row['flowTag']?></td>
					       <?}
					       else {}?>
					       <td><?=$row['numSerie']?></td>
					       <td><?=$row['fecha_registro']?></td>
					       <td><?=$row['hora_registro']?></td>
					       <?$idParte=$row['id_partes']?>
					       <td><a href="#" onclick="Modificar('<?=$idParte;?>','document.getElementsBy(hidden)')" title="Modifica Parte <?=$i-1?>">Modificar</a></td>
					</tr>
<?
					}
				?></table><?
			} 
		}//fin consultaModifica
		
		public function formModifica($id_lote,$id_proyecto,$noItem,$idParte){
			?><form><input type="hidden" name="id_lote" id="id_lote" value="<?=$id_lote;?>"><input type="hidden" name="id_proyecto" id="id_proyecto" value="<?=$id_proyecto;?>"><input type="hidden" name="noItem" id="noItem" value="<?=$noItem;?>"></form><?
			?>|<a href="#" onclick="consulta('document.getElementsBy(hidden)')">Consultar</a>  |  <a href="#" onclick="formAgrega('document.getElementsBy(hidden)')">Agregar</a>  |  <a href="#" onclick="consultaModifica('document.getElementsBy(hidden)')">Modificar</a>  |<?
			$Item="SELECT * FROM detalle_lote where id_lote=$id_lote and id_partes=$idParte";
			$ItemC=mysql_query($Item,$this->conectarBd());
			$row=mysql_fetch_array($ItemC);
			$HOUR=date('G:i:s');
?>
			<br><br><h3>Lote <?=$id_lote?></h3>
			<table align="center"><form>
				<tr>	
					<th  align="left">Num parte</th>
					<td><input type="text"name="noParte" id="noParte" value="<?=$row['Numparte']?>"onkeyup="this.value = this.value.replace (/[^aA-zZ\^0-9]/, ''); "></td>
				</tr>
				<tr>
					<th  align="left">Modelo</th>
					<td><input type="text" name="modelo" id="modelo" value="<?=$row['modelo']?>"onkeyup="this.value = this.value.replace (/[^aA-zZ\^0-9]/, ''); "></td>		    
				</tr>
			<?if($id_proyecto==2){?>
				<tr>
					<th  align="left">Code Type</th>
					<td><input type="text" name="codeType" id="codeType" value="<?=$row['codeType']?>"onkeyup="this.value = this.value.replace (/[^aA-zZ\^0-9]/, ''); "></td>		    
				</tr>
			<?}
			else {}
			if($id_proyecto==2){?>
				<tr>
					<th  align="left">Flow Tag</th>
					<td><input type="text" name="flowTag" id="flowTag" value="<?=$row['flowTag']?>"></td>
				</tr>
			<?}
			else {}?>
				<tr>
					<th  align="left">Num Serie</th>
					<td><input type="text" name="numSerie" id="numSerie" value="<?=$row['numSerie']?>"onkeyup="this.value = this.value.replace (/[^aA-zZ\^0-9 ]/, ''); "></td>	    
				</tr>
				<tr>
					<th  align="left">Fecha</th>
					<td><input type="text" name="date" id="date" value="<?=$row['fecha_registro']?>"><input type="button" id="lanzador1" value="..." />
						<!-- script que define y configura el calendario-->
						<script type="text/javascript">
								Calendar.setup({
								inputField     :    "date",      // id del campo de texto
								ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
								button         :    "lanzador1"   // el id del botón que lanzará el calendario
								});
						</script></td>    
				</tr>
				<tr>
					<th  align="left">Hora</th>
					<td><input type="text" name="hour" id="hour" value="<?=$row['hora_registro']?>" readonly></td>
				</tr>
				<tr>
					<th align="left">Descripci&oacute;n</th>
					<td><textarea name="desc" id="desc" maxlength="100" value="descripcion"></textarea></td>
				</tr>
					<input type="hidden" name="idParte" id="idParte" value="<?=$idParte?>">
					<input type="hidden" name="id_lote" id="id_lote" value="<?=$id_lote;?>">
					<input type="hidden" name="id_proyecto" id="id_proyecto" value="<?=$id_proyecto;?>">
					<input type="hidden" name="noItem" id="noItem" value="<?=$noItem;?>">
			    
				<tr>
					<td colspan=2 align="right"><input type="button" name="envia" id="envia" value="Guardar" onclick="modifica('document.getElementsBy(hidden)')"></td>
				</tr>
			</table></form><?
		}//fin formModifica
		
		public function modifica($noParte,$modelo,$codeType,$flowTag,$numSerie,$fechaReg,$horaReg,$desc,$id_lote,$id_proyecto,$idParte,$noItem){   
			?>
			<form><input type="hidden" name="id_lote" id="id_lote" value="<?=$id_lote;?>"><input type="hidden" name="id_proyecto" id="id_proyecto" value="<?=$id_proyecto;?>"><input type="hidden" name="noItem" id="noItem" value="<?=$noItem;?>">
<?
			$mod="UPDATE detalle_lote SET Numparte='".$noParte."',modelo='".$modelo."',codeType='".$codeType."',flowTag='".$flowTag."',numSerie='".$numSerie."',descripcion='".$desc."',fecha_registro='".$fechaReg."' WHERE id_lote='".$id_lote."' and id_partes='".$idParte."'";
			$una=mysql_query($mod,$this->conectarBd());
				if(!$una){
					echo "<br>El Item no ha sido modificado";
				}
				else{
					echo "<br>El Item ha sido modificado satisfactoriamente";
					?><script type="text/javascript">consultaX('document.getElementsBy(hidden)'); </script><?
				}
		}//fin modifica
		public function consultaLotes($id_proyecto){
			$objCargaInicial=new verificaCargaInicial();
			$con="SELECT * FROM lote WHERE id_proyecto='".$id_proyecto."'";
			/*print_r($con);
			exit;*/
			$cons=mysql_query($con,$this->conectarBd());
			$name_pro=$objCargaInicial->dameNombreProyecto($id_proyecto);
			if(mysql_num_rows($cons)==0){
				echo"No hay registros que mostrar";
			}else{
?>		 
				<h3 align="center">Linea <?=$name_pro;?></h3>
				<br><table border="1" align="center" style="font-size: 12px;">
				<tr>
				    <th colspan="8">LOTES</th>
				</tr>
				<tr>
				    <th># Lote</th>
				    <? if ($id_proyecto==1){
				    ?>
				    <th>Pre-Alerta</th>
				    <?	
				    }
				    if ($id_proyecto==2){
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
				    <td><?=$row['id_lote'];?></a></td>
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
		}//fin function consultaLotes
		public function formLotes($id_proyecto,$idUsuario){
			$DATE=date('Y-m-d');
			$HOUR=date('G:i:s');
			$pru="select nombre_proyecto from proyecto where id_proyecto='".$id_proyecto."'";
			$pru2=mysql_query($pru,$this->conectarBd());
			$rowPro=mysql_fetch_array($pru2);
			$proj=$rowPro['nombre_proyecto'];
			$tatPro="tat".$proj;
			$con1="select valor from configuracionglobal where nombreConf='$tatPro'";
			$ejecon1=mysql_query($con1,$this->conectarBd());
			$row=mysql_fetch_array($ejecon1);
			$valor=$row['valor'];
			$no_day=explode("|",$valor);
			$total=count($no_day);
?>
			<form name="lote" id="lote" method="POST">
			<table align="center">
				<input type="hidden" name="idUsuario" id="idUsuario" value="<?=$idUsuario;?>">
				<input type="hidden" name="id_proyecto" id="id_proyecto" value="<?=$id_proyecto;?>">
				<tr align="center">
					<th colspan="2" style="size: 30px;  ">Lote</th>
				</tr>
				<tr>
					<th colspan=2 align="right"><input type="text" style="width:80px;height:20px;background-color:transparent;color:black;font-size:10pt; font-family:Verdana;text-align:center; border: hidden" name="fechaReg" id="fechaReg" value="<?=$DATE?>" readonly>  <input type="text" style="width:80px;height:20px;background-color:transparent;color:black;font-size:10pt; font-family:Verdana;text-align:center; border: hidden"  name="horaReg" id="horaReg" value="<?=$HOUR?>" readonly></th>
				</tr>
				<?if($id_proyecto==1){
				?><tr>
					<th align="left"># Pre-Alerta</th>
					<td><input type="text" name="noPO" id="noPO"></td>
				</tr>
<?
				}?>
				<?if($id_proyecto==2){
?>				<tr>
					<th align="left"># PO</th>
					<td><input type="text" name="noPO" id="noPO" onkeyup="this.value = this.value.replace (/[^0-9]/, ''); "></td>
				</tr>
<?
				}?>
				<tr>
					<th align="left">Numero de ITEMS</th>
					<td><input type="text" name="noItem" id="noItem" onkeyup="this.value = this.value.replace (/[^0-9]/, ''); "></td>
				</tr>
            			<tr>
					<th align="left">TAT</th>
					<td><select name="diasTAT" id="diasTAT">
<?
						for($i=0;$i<$total;$i++){
						    ?><option value="<?=$no_day["$i"];?>"><?=$no_day["$i"];?></option> 
						    <?
						}
?>
					</select></td>
				</tr>
				<tr>
					<th align="left">Observaciones</th>
					<td><textarea row="5" cols="20" maxlength="200" name="observaciones" id="observaciones"></textarea></td>
				</tr>
				<tr>
					<th rowspan="2" colspan="2">
						<input type="button" name="addLote" id="addLote" value="Agregar" onclick="agregarLotes('document.getElementsBy(hidden)')">
						<input type="reset" name="res" id="res" value="Borrar">
					</th>
				</tr>
			</table></form><?
		}// fin funcion formLote
		public function agregarLote($noPO,$noItem,$fechaReg,$horaReg,$diasTAT,$observaciones,$idUsuario,$id_proyecto){
			$noPO = strtoupper($noPO);
			$Noday=$diasTAT;
			$suma="+".$Noday." day";
			$nuevafecha = strtotime ( $suma , strtotime ( $fechaReg ) ) ;
			$fecha_final = date ( 'Y-m-j' , $nuevafecha );
			$add="INSERT INTO lote (numero_items,fecha_reg,hora_reg,id_usuario,fecha_tat,num_po,observaciones,id_proyecto) VALUES ('".$noItem."','".$fechaReg."','".$horaReg."','".$idUsuario."','".$fecha_final."','".$noPO."','".$observaciones."','".$id_proyecto."')";
			$una=mysql_query($add,$this->conectarBd());
				if(!$una){
				    echo "<br>El Lote no ha sido agregado";
				}
				else{
				   echo "<br>El lote ha sido agregado satisfactoriamente";
				    ?><script type="text/javascript">clean2(); mostrarLotes(<?=$id_proyecto;?>) </script><?
	    			}
		}
		public function consultaModificaLotes($id_proyecto,$id_usuario){
			$con="SELECT * FROM lote WHERE id_proyecto='".$id_proyecto."'";
			$cons=mysql_query($con,$this->conectarBd());
			if(mysql_num_rows($cons)==0){
				    echo"No hay registros que mostrar";
			}
			else{
?>
				<br><br><table border="1" align="center">
				<tr>
					<th colspan="8">LOTES</th>
				</tr>
				<tr>
					<th># Lote</th>
					<?if ($id_proyecto==1){?>
					<th>Pre-alerta</th>
					<?}
					if($id_proyecto==2){?>
					<th>No. PO</th>
					<?}?>
					<th>No. Item</th>
					<th>Fecha Registro</th>
					<th>Status</th>
					<th>TAT</th>
					<th>Modifica</th>
				</tr>
<?
				while($row=mysql_fetch_array($cons)){
					$fechaB=explode("-",$row['fecha_tat']);						
					$diaSeg=date("w",mktime(0,0,0,$fechaB[1],$fechaB[2],$fechaB[0]));
					$mesSeg=date("n",mktime(0,0,0,$fechaB[1],$fechaB[2],$fechaB[0]));
					$dias= array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","S&aacute;bado");
					$meses= array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
					$idLote=$row['id_lote'];
?>
					<tr>
						<td><?=$row['id_lote'];?></td>
						<td><?=$row['num_po'];?></td>
						<td><?=$row['numero_items'];?></td>
						<td><?=$row['fecha_reg'];?></td>
						<td><?=$row['status'];?></td>
						<td>El <?=$dias[$diaSeg]." ".$fechaB[2]." de ".$meses[$mesSeg-1]." de ".$fechaB[0]." a las ".$row['hora_reg'];?> </td>
						<td><a href="#" onclick="formModificaLote(<?=$idLote;?>,<?=$id_proyecto;?>,<?=$id_usuario?>)">Modifica</a> </td>
					</tr>
<?
				}
?>
				</table>
<?
			}
		}
		public function formModificaLote($idLote,$id_proyecto,$id_usuario){
			$pru="select nombre_proyecto from proyecto where id_proyecto='".$id_proyecto."'";
			$pru2=mysql_query($pru,$this->conectarBd());
			$rowPro=mysql_fetch_array($pru2);
			$proj=$rowPro['nombre_proyecto'];
			$tatPro="tat".$proj;
			$con1="select valor from configuracionglobal where nombreConf='$tatPro'";
			$ejecon1=mysql_query($con1,$this->conectarBd());
			$row=mysql_fetch_array($ejecon1);
			$valor=$row['valor'];
			$no_day=explode("|",$valor);
			$total=count($no_day);
			$cons="Select * from lote where id_lote=$idLote";
			$cons1=mysql_query($cons,$this->conectarBd());
?>
			<form name="Modlote" id="Modlote" method="POST">
			<table align="center">
				<tr align="center">
					<th colspan="2" style="size: 30px;  ">Editando lote <?=$idLote;?></th>
				</tr>
<?
				while($row=mysql_fetch_array($cons1)){
					$fechatat=$row['fecha_tat'];
					$fechare=$row['fecha_reg'];
					$diasConvert= (strtotime($fechare)-strtotime($fechatat))/86400;
					$dias=abs($diasConvert);
					$dias1=floor($dias);		
?>
					<tr>
						<?if ($id_proyecto==1){?>
						<th align="left">Pre-alerta</th>
						<td><input type="text" name="nuPo" id="nuPo" value="<?=$row['num_po']?>"></td>
						<?}
						if($id_proyecto==2){?>
						<th align="left">No. PO</th>
						<td><input type="text" name="nuPo" id="nuPo" value="<?=$row['num_po']?>" onkeyup="this.value = this.value.replace (/[^0-9 ]/, ''); " ></td>
<?						}?>
						
					</tr>	
					<tr>
						<th align="left">Numero de ITEMS</th>
						<td><input type="text" name="noItem" id="noItem" value="<?=$row['numero_items']?>"onkeyup="this.value = this.value.replace (/[^0-9 ]/, ''); " 	></td>
					</tr>
					<tr>
						<th align="left">Fecha de registro</th>
						<td><input type="text" name="fechaReg" id="fechaReg" value="<?=$row['fecha_reg']?>"><input type="button" id="lanzador1" value="..." />
									    <!-- script que define y configura el calendario-->
									    <script type="text/javascript">
										    Calendar.setup({
											    inputField     :    "fechaReg",      // id del campo de texto
											    ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
											    button         :    "lanzador1"   // el id del botón que lanzará el calendario
										    });
									    </script>
						</td>
					</tr>
					<tr>
						<th align="left">Hora de registro</th>
						<td><input type="text" name="horaReg" id="horaReg" value="<?=$row['hora_reg']?>" readonly></td>
					</tr>
            				<tr>
						<th align="left">TAT</th>
						<td><select name="diasTAT" id="diasTAT">
						    <option value="<?=$dias1;?>"><?=$dias1;?></option>
<?
							for($i=0;$i<$total;$i++){
							    ?><option value="<?=$no_day["$i"];?>"><?=$no_day["$i"];?></option> 
							    <?
							}
?>	
						</select></td>
					</tr>
					<tr>
						<th align="left">Observaciones</th>
						<td><textarea row="5" cols="20" maxlength="200" name="observaciones" id="observaciones" value="<?=$row['observaciones']?>"></textarea></td>
					</tr>
					<tr>
<?	
				}
?>
						<th rowspan="2" colspan="2">
						<input type="button" name="addLote" id="addLote" value="Modifica" onclick="modificaLote('<?=$idLote?>','<?=$id_proyecto?>','<?=$id_usuario?>')">
						<input type="reset" name="res" id="res" value="Borrar">
					</th>
					</tr>
        
			</table> </form><?
   
	    	}
		public function modificaLote($noPO,$noItem,$fechaReg,$horaReg,$diasTAT,$observaciones,$idLote,$id_proyecto,$id_usuario){
			$noPO = strtoupper($noPO);
			//echo gettype($noItem);
			//exit;
			$Noday=$diasTAT;
			$suma="+".$Noday." day";
			$nuevafecha = strtotime ( $suma , strtotime ( $fechaReg ) ) ;
			$fecha_final = date ( 'Y-m-j' , $nuevafecha );
			//gUARDAR ORIGINAL EN LOTE_CAMBIOS
			$consultaLActual="SELECT * from lote WHERE id_lote=$idLote";
			$DATE=date('Y-m-d');
			$HOUR=date('G:i:s');
			$ejecutaConsultaActual=mysql_query($consultaLActual,$this->conectarBd());
			$rowActual=mysql_fetch_array($ejecutaConsultaActual);
			$PREchange= "INSERT INTO lote_cambios(id_lote,numero_items,fecha_reg,hora_reg,id_usuario,status,fecha_tat,num_po,observaciones,id_pro,fecha_cambio,hora_cambio,usuario_cambio) VALUES ('".$rowActual['id_lote']."','".$rowActual['numero_items']."','".$rowActual['fecha_reg']."','".$rowActual['hora_reg']."','".$rowActual['id_usuario']."','".$row['status']."','".$rowActual['fecha_tat']."','".$rowActual['num_po']."','".$rowActual['observaciones']."','".$rowActual['id_proyecto']."','".$DATE."','".$HOUR."','".$id_usuario."')";

			//FIN DEL GUARDADO ORIGINAL
			$mod="UPDATE lote SET num_po='".$noPO."', numero_items='".$noItem."', fecha_reg='".$fechaReg."',hora_reg='".$horaReg."', fecha_tat='".$fecha_final."',observaciones='".$observaciones."' WHERE id_lote='".$idLote."'";
			$una=mysql_query($mod,$this->conectarBD());
				if(!$una){
				    echo "<br>El Lote no ha sido modificado";
				}
				else{
				   //$ejecutaPREchange=mysql_query($PREchange,$this->conectarBd());
				   echo "<br>El lote ha sido modificado satisfactoriamente";
				$ejecutaPREchange=mysql_query($PREchange,$this->conectarBd());
				?><script type="text/javascript">clean2(); mostrarLotes(<?=$id_proyecto;?>); </script><?
	    			}
		}
	}//fin de la clase
?>
