<?
	session_start();
	include("../../clases/funcionesComunes.php");
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
		public function panel($id_proyecto){
			$consul="select * from lote where id_proyecto='".$id_proyecto."'";
			//print_r($consul);
			//exit;
			$con=mysql_query($consul,$this->conectarBd());
			if(mysql_num_rows($con)==0){
				echo"No hay proyectos que mostrar";
			}else{
?>				<br><table border="1" align="center" style="font-size: 12px;">
				<tr>
				    <th colspan="9">PANEL</th>
				</tr>
				<tr>
				    <th># Lote</th>
				    <th>Fecha Registro</th>
				    <th>No. Items</th>
				    <th>Reparaci&oacute;n</th>
				    <th>Scrap</th>
				    <th>Irreparables</th>
				    <th>Pendientes</th>
				    <th>Valores</th>
				    <th>Avance</th>
		
				</tr>
<?
				while($row=mysql_fetch_array($con)){
	?>
				<tr>
				    <td><?=$row['id_lote'];?></td>
				    <td><?=$row['fecha_reg'];?></td>
				    <td><?=$row['numero_items'];?></td>
				    <td>
<?
					$rep="select count(*) as REP from detalle_lote where status='Reparado' and id_lote=".$row['id_lote'];
					$rep1=mysql_query($rep,$this->conectarBd());
					$rowRep=mysql_fetch_array($rep1);
					$REP=$rowRep['REP'];
?>
					<?=$REP;?>
				    </td>
				    <td>
<?
					$scrap="select count(*) as SCRAP from detalle_lote where status='Scrap' and id_lote=".$row['id_lote'];
					$scrap1=mysql_query($scrap,$this->conectarBd());
					$rowScrap=mysql_fetch_array($scrap1);
					$SCRAP=$rowScrap['SCRAP'];
?>					<?=$SCRAP;?>
				    </td>
				    <td>
<?
					$irre="select count(*) as IRRE from detalle_lote where status='Irreparables' and id_lote=".$row['id_lote'];
					$irre1=mysql_query($irre,$this->conectarBd());
					$rowIrre=mysql_fetch_array($irre1);
					$IRRE=$rowIrre['IRRE'];
					?>
					<?=$IRRE;?>
				    </td>
				    <td>
<?
					$pend="select count(*) as PEND from detalle_lote where status='Pendiente' and id_lote=".$row['id_lote'];
					$pend1=mysql_query($pend,$this->conectarBd());
					$rowPend=mysql_fetch_array($pend1);
					$PEND=$rowPend['PEND'];
?>
					<?=$PEND;?>
				    </td>
				    <td><?=($REP+$SCRAP+$IRRE+$PEND);?></td>
				    <td align="center">
					<?
					$total=$row['numero_items'];
					$porcentaje=((4+0+0)*100)/$total;
					//$porcentaje=(($REP+$IRRE+$SCRAP)*100)/$total;
					
					?>
					<div style="float: left;left: 55px;top: -12px;width:100px;overflow: hidden;height: 16px;background: #000;">
					<div style="background:#89FF8F;height: 16px;width: <?=$porcentaje;?>px;"></div></div>
					<div style="float: right;width:100px;overflow: hidden;height: 20px;"><?=$porcentaje;?> %</div>
				    </td>
				</tr>
<?
				}
				echo "</table>";
			}
		}//fin function mostrarLotesProyecto
		
	}//fin de la clase
?>
