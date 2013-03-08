<?
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
			<fieldset>
				<legend style="width:auto; height: auto">DETALLES ITEM:</legend>
				<table border=1>
					<tr>
						<th>Num. Parte:</th>
						<td>NP</td>
						<td rowspan='3'>TAT</td>						
					</tr>
					<tr>
						<th>Num. Lote:</th>
						<td>#</td>
					</tr>
					<tr>
						<th>Modelo:</th>
						<td>mod</td>
					</tr>
					<?if($idProyecto==2){?>
					<tr>
						<th>Code Type:</th>
						<td>code type:</td>
					</tr>
					<tr>
						<th>Flow Tag</th>
						<td>FT</td>
					</tr>
					<?}
					else{}?>
					<th>Observaciones:</th>
					<td colspan=3><textarea>obser</textarea></td>
				</table>
			</fieldset>
			<?
		}

	}//fin de la clase
?>
