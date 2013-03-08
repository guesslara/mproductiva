<?
	/*
	 *modeloEnsamble:Clase del modulo mod_DYR que realiza las consultas e inserciones de los diagnosticos de
	  fallas y reparaciones de los items de cada uno de los técnicos, asi mismo mostrando los detalles necesarios para ambas funciones
	 *Autor: Rocio Manuel Aguilar
	 *Fecha:
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
		public function diagnostica($idProyecto,$idUser,$opt){
			if($opt=="Diagnosticar"){
				$sel="SELECT * FROM detalle_lote WHERE id_tecnico=$idUser and id_proyecto=$idProyecto and status='Asignado'";
			}
			if($opt=="Reparar"){
				$sel="SELECT * FROM detalle_lote WHERE id_tecnico=$idUser and id_proyecto=$idProyecto and status='Diagnosticado'";
			}
			//print_r($sel);
			//exit;
			$exeSel=mysql_query($sel,$this->conectarBd());
			$noCol=mysql_num_rows($exeSel);
			if($noCol==0){
				?><script type="text/javascript">alert("POR EL MOMENTO NINGUN ITEM TE HA SIDO ASIGNADO");</script><?
			}
			else{
?>
				<table border=1 align="center">
					<tr>
						<th colspan="4" align="left" style="font-size: 10px"><?=$opt?></th>
					</tr>
					<tr>
						<th colspan="4" align="center">Items Asignados</th>
					</tr>
					<tr>
						<th>#<br>Asignado</th>
						<th>#<br>Lote</th>
						<th>#<br>Parte</th>
						<th>Fecha<br>Registro</th>
					</tr>
<?
				$i=1;
				while($rowAsi=mysql_fetch_array($exeSel)){
?>					<tr align="center">
						<td><a href="#" onclick="formDia('<?=$idProyecto;?>','<?=$idUser;?>','<?=$rowAsi['id_partes']?>')" title="Formato Diagnostica"><?=$i;?></a></td>
						<td><?=$rowAsi['id_lote'];?></td>
						<td><?=$rowAsi['Numparte'];?></td>
						<td><?=$rowAsi['fecha_registro']?></td>
					</tr>
<?
					$i++;
				}
?>
				
				</table>
<?
			}			
		}
		public function formDia($idProyecto,$idUser,$idParte){
			?>
			<br>
			<br>
				<?
				$conDeta="select * from detalle_lote where id_partes=$idParte";
				$exeConDe=mysql_query($conDeta,$this->conectarBd());
				$rowDeta=mysql_fetch_array($exeConDe);
				?>
			<fieldset>
				<legend style="width:auto; height: auto">DETALLES ITEM:</legend>
				<table border=0>
					<tr>
						<th align="left">Num. Parte:</th>
						<td><?=$rowDeta['Numparte'];?></td>
						<td rowspan='3' align="center" style="background: red;">TAT <br><?=$rowDeta['fecha_registro'];?></td>						
					</tr>
					<tr>
						<th align="left">Num. Serie:</th>
						<td><?=$rowDeta['numSerie'];?></td>
					</tr>
					<tr>
						<th align="left">Num. Lote:</th>
						<td><?=$rowDeta['id_lote'];?></td>
					</tr>
					<tr>
						<th align="left">Modelo:</th>
						<td><?=$rowDeta['modelo'];?></td>
					</tr>
					<?if($idProyecto==2){?>
					<tr>
						<th align="left">Code Type:</th>
						<td><?=$rowDeta['codeType'];?></td>
					</tr>
					<tr>
						<th align="left">Flow Tag</th>
						<td><?=$rowDeta['flowTag'];?></td>
					</tr>
					<?}
					else{}?>
					<th align="left">Observaciones:</th>
					<td colspan=3><textarea><?=$rowDeta['observaciones_asginacion'];?></textarea></td>
				</table>
			</fieldset>
			
			<br>
			<fieldset>
				<legend>DIAGNOSTICO ITEM:</legend>
				<table><form>
					<tr>
						<td>Fabricante:</td>
						<td>
							<select name="fabricante">
								<option value="0">Selecciona fabricante:</option>
								<?
								$conFab="select * from CAT_fabricante";
								$execonFab=mysql_query($conFab,$this->conectarBd());
								while($rowFab=mysql_fetch_array($execonFab)){
									?><option value="<?=$rowFab['id_fabricante'];?>"><?=$rowFab['nombre_fabricante'];?></option><?
								}
		
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Falla(s) encontrada(s):</td>
						<td>
							<?$div="ventanaDialogo1";
							$opt="fallas";
							?>
							<textarea name="fallas" id="fallas" ></textarea> <input type="button" name="catFallas" id="catFallas" value="..." onclick="abreVentana('<?=$div;?>','<?=$opt;?>','<?=$idParte;?>','<?=$idProyecto;?>')">
						</td>
					</tr>
					<tr>
						<th>Status</th>
						<td></td>
					</tr>
				</form></table>
			</fieldset>
			<?
		}
		function fallas($idParte,$idProyecto){
			$conFallas="SELECT * from CAT_fallas where id_fallas=1";
			$exeFallas=mysql_query($conFallas,$this->conectarBd());
			$rowFallas=mysql_fetch_array($exeFallas);
			$proyectos=explode(",",$rowFallas['id_proyecto']);
			//for($i=0;$i<)
			print_r($proyectos);
			
		?>
			<!--<table>
				<tr>
					<th></th>
				</tr>
			</table>-->
		<?
			
			
		}

	}//fin de la clase
?>
