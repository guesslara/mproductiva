<?php
    session_start();
    class modeloEnsamble2{
        
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
        
        public function verificarEquiposMarcados($idValidaciones){
	    //se extraen las entregas relacionadas
	    $sql="SELECT * FROM empaque_validaciones WHERE id='".$idValidaciones."'";
	    $res=mysql_query($sql,$this->conectarBd());
	    if(mysql_num_rows($res)==0){
		echo "Error al extraer las entregas";
	    }else{
		echo "&nbsp;&nbsp;<a href='#' onclick='verificaEquiposMarcados(\"".$idValidaciones."\")' title='Verificar Marcacion de Equipos Enviados' style='color:blue; font-size:10px;text-decoration: none;'>Validar Marcacion de Equipos Enviados</a><br><br>";
		$row=mysql_fetch_array($res);
		$entregas=explode(",",$row["id_entregas"]);
		for($i=0;$i<count($entregas);$i++){
		    $sqlEntregas="SELECT id,concepto FROM entregas_nextel WHERE id_entrega_interna='".$entregas[$i]."'";
		    $resEntregas=mysql_query($sqlEntregas,$this->conectarBd());
		    if(mysql_num_rows($resEntregas)==0){
			echo "<br>Error al mostrar los items de la entrega";
		    }else{
			while($rowEntregas=mysql_fetch_array($resEntregas)){			    
			    echo "<div style='height:15px;padding:5px;width:500px;border:1px solid #CCC;background:#F0F0F0;margin-left:10px;'>Entrega : ".$rowEntregas["concepto"]." WIP: </div>";
			    $sqlEntregasItems="SELECT id_radio FROM entregas_nextel_items WHERE id_entrega='".$rowEntregas["id"]."'";
			    $resEntregasItems=mysql_query($sqlEntregasItems,$this->conectarBd());
			    if(mysql_num_rows($resEntregasItems)==0){
				echo "No existen items relacionados con la entrega";
			    }else{
				$j=0;
				while($rowEntregasItems=mysql_fetch_array($resEntregasItems)){
				    //echo "<br>".$rowEntregasItems["id_radio"];
				    $j+=1;				    
				    $sqlEquipos="SELECT imei,serial,sim,status,statusProceso FROM equipos WHERE id_radio='".$rowEntregasItems["id_radio"]."'";
				    $resEquipos=mysql_query($sqlEquipos,$this->conectarBd());
				    if(mysql_num_rows($resEquipos)==0){
					echo "Error el item de la entrega no existe";
				    }else{
					$rowEquipos=mysql_fetch_array($resEquipos);
					if($rowEquipos["status"]=="ENVIADO"){
					    $fondo="#D9FFB3";
					}else if($rowEquipos["status"]=="WIP"){
					    $fondo="red";
					}
					echo "<div style='background:".$fondo.";width:480px;font-size:12px;margin-left:15px;height:10px;padding:5px;'>".$j." -- ".$rowEquipos["imei"]." -- ".$rowEquipos["status"]."</div>";
				    }
				}
			    }
			}
		    }
		}
	    }
	}
	
	public function mostrarInformacionEntregas($idEntrega){
            $sqlEntrega="SELECT * FROM entregas_nextel INNER JOIN cat_destinos ON entregas_nextel.destino = cat_destinos.id WHERE entregas_nextel.id = '".$idEntrega."'";
            $resEntrega=mysql_query($sqlEntrega,$this->conectarBd());
            if(mysql_num_rows($resEntrega)==0){
                echo "<br>No se encontro la informaci&oacute;n.<br>";
            }else{
?>
                <table border="0" cellpading="1" cellspacing="1" width="96%" style="margin-left: 5px;font-size: 12px;">
		    <tr>
			<td width="10%" style="height:25px; text-align:center; border-bottom:1px solid #CCC;font-weight:bold; border:1px solid #CCC; background:#e6e6e6;">Entrega</td>
			<td width="10%" style="height:25px; text-align:center; border-bottom:1px solid #CCC;font-weight:bold; border:1px solid #CCC; background:#e6e6e6;">OCA</td>
                        <td width="10%" style="height:25px; text-align:center; border-bottom:1px solid #CCC;font-weight:bold; border:1px solid #CCC; background:#e6e6e6;">Fecha</td>
			<td width="30%" style="height:25px; text-align:center; border-bottom:1px solid #CCC;font-weight:bold; border:1px solid #CCC; background:#e6e6e6;">Destino</td>
			<td width="10%" style="height:25px; text-align:center; border-bottom:1px solid #CCC;font-weight:bold; border:1px solid #CCC; background:#e6e6e6;">Cantidad</td>									
			<td width="40%" style="height:25px; text-align:center; border-bottom:1px solid #CCC;font-weight:bold; border:1px solid #CCC; background:#e6e6e6;">Acciones</td>
		    </tr>
<?
                while($rowEntregaporEntrega=mysql_fetch_array($resEntrega)){
		    $sqlItems="SELECT imei, serial, sim, numeroCajaFinal FROM entregas_nextel_items INNER JOIN equipos ON entregas_nextel_items.id_radio = equipos.id_radio WHERE entregas_nextel_items.id_entrega = '".$idEntrega."'";
		    $resItems=mysql_query($sqlItems,$this->conectarBd());
?>
                    <tr class="resultadosEntregas" style="background: #A9BCF5;">
			<td style="text-align: center;height:15px;padding:5px;text-align:center;border-bottom:1px solid #666;border-left:1px solid #666;"><?=$rowEntregaporEntrega["concepto"];?></td>
                        <td style="text-align: center;height:15px;padding:5px;text-align:center;border-bottom:1px solid #666;border-left:1px solid #666;"><?=$rowEntregaporEntrega["po"];?></td>
			<td style="text-align: center;height:15px;padding:5px;text-align:center;border-bottom:1px solid #666;border-left:1px solid #666;"><?=$rowEntregaporEntrega["fecha"];?></td>
			<td style="text-align: center;height:15px;padding:5px;text-align:center;border-bottom:1px solid #666;border-left:1px solid #666;"><?=$rowEntregaporEntrega["destino"];?></td>
			<td style="text-align: center;height:15px;padding:5px;text-align:center;border-bottom:1px solid #666;border-left:1px solid #666;"><?=$rowEntregaporEntrega["cantidad"];?></td>									
			<td style="text-align: center;height:15px;padding:5px;text-align:center;border-bottom:1px solid #666;border-left:1px solid #666;">			    
			    <a href="impresionSalida.php?n=<?=$rowEntregaporEntrega["id"];?>" target="_blank" style="color:#FFF;text-decoration: none;" title="Imprimir Salida"><img src="../../img/print-icon.png" border="0"></a> |
			    <a href="exportarSalida.php?n=<?=$rowEntregaporEntrega["id"];?>" target="_blank" style="color:#FFF;text-decoration: none;" title="Exportar Salida a Excel"><img src="../../img/excel_export.png" border="0"></a> |			    
			    <a href="#" onclick="marcarEquiposEnviados('<?=$rowEntregaporEntrega["id"];?>','<?=$rowEntregaporEntrega["concepto"];?>')" title="Finalizar Entrega"><img src="../../img/select.png" border="0" height="16" width="16"></a>
			</td>
		    </tr>
		    <tr>
			<td colspan="6">
			    <table border="0" cellpadding="0" cellspacing="0" style="margin-top: 10px;font-size: 12px;border: 1px solid #CCC;">
				<tr>
				    <td style="height:25px; text-align:center; border-bottom:1px solid #CCC;font-weight:bold; border:1px solid #CCC; background:#e6e6e6;">#</td>
				    <td style="height:25px; text-align:center; border-bottom:1px solid #CCC;font-weight:bold; border:1px solid #CCC; background:#e6e6e6;">Imei</td>
				    <td style="height:25px; text-align:center; border-bottom:1px solid #CCC;font-weight:bold; border:1px solid #CCC; background:#e6e6e6;">Serie</td>
				    <td style="height:25px; text-align:center; border-bottom:1px solid #CCC;font-weight:bold; border:1px solid #CCC; background:#e6e6e6;">Sim</td>
				    <td style="height:25px; text-align:center; border-bottom:1px solid #CCC;font-weight:bold; border:1px solid #CCC; background:#e6e6e6;">Caja</td>
				</tr>
<?
			if(mysql_num_rows($resItems)==0){
			    echo "<tr><td colspan='5'>( 0 ) items por mostrar.</td></tr>";
			}else{
			    $i=1; $color="#F0F0F0";
			    while($rowItems=mysql_fetch_array($resItems)){
?>
				<tr>
				    <td style="background: <?=$color;?>;height: 15px;padding: 5px;border-bottom: 1px solid #CCC;border-right: 1px solid #CCC;"><?=$i;?></td>
				    <td style="background: <?=$color;?>;height: 15px;padding: 5px;border-bottom: 1px solid #CCC;border-right: 1px solid #CCC;"><?=$rowItems["imei"];?></td>
				    <td style="background: <?=$color;?>;height: 15px;padding: 5px;border-bottom: 1px solid #CCC;border-right: 1px solid #CCC;"><?=$rowItems["serial"];?></td>
				    <td style="background: <?=$color;?>;height: 15px;padding: 5px;border-bottom: 1px solid #CCC;border-right: 1px solid #CCC;"><?=$rowItems["sim"];?></td>
				    <td style="background: <?=$color;?>;height: 15px;padding: 5px;border-bottom: 1px solid #CCC;"><?=$rowItems["numeroCajaFinal"];?></td>
				</tr>
<?
				($color=="#F0F0F0") ? $color="#FFF" : $color="#F0F0F0";
				$i+=1;
			    }
			}
?>
			    </table>
			</td>
		    </tr>
<?
                }
?>
                </table><br><br>
<?
            }
        }
    }
?>