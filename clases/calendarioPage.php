<?php
    class calendarioPage{    
    
        private function UltimoDia($anho,$mes){ 
	   if (((fmod($anho,4)==0) and (fmod($anho,100)!=0)) or (fmod($anho,400)==0)) { 
		$dias_febrero = 29; 
	   } else { 
		   $dias_febrero = 28; 
	   } 
	   if(($mes==1) || ($mes==3) || ($mes==5) || ($mes==7) || ($mes==8) || ($mes==10) || ($mes==12)){
		   $dias_mes="31";
	   }else if(($mes==4) ||($mes==6) ||($mes==9) ||($mes==11)){
		   $dias_mes="30";
	   }else if($mes==2){
		   $dias_mes=$dias_febrero;
	   }
	   return $dias_mes;
	}

	public function calendarizacion($mes,$anio,$diaActual){		
	    $mes=$mes;//date("m");
	    //año de la fecha
	    $anio=$anio;
	    //total de dias en el mes
	    $totalDias=$this->UltimoDia($anio,$mes);
	    $numeroDia=date("w", mktime (0,0,0,$mes,1,$anio));//mes dia año
	    $diaFecha=date("j", mktime (0,0,0,$mes,1,$anio));//mes dia año
	    $dia=1;
	    /*for($i=0;$i<6;$i++){
		for($j=0;$j<7;$j++){
                    if($numeroDia==$j){
                        echo date("j", mktime (0,0,0,$mes,$dia,$anio));
			$numeroDia+=1;
			$dia+=1;
                    }else{
			echo "x";
                    }
		}
		$numeroDia=0;
		echo "<br>";
            }
            $dia=1;*/
	    $meses=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
?>
		<table width="95%" border="0" cellspacing="0" cellpadding="1" style="font-size:10px; margin-left:5px; margin-top:5px; margin-right:5px;">                    
                    <tr>
                        <td colspan="7">Seleccione los dias laborables</td>
                    </tr>
                    <tr>
                        <td colspan="7" style="font-size:16px; text-align:center;"><?=$meses[$mes-1]." ".date("Y");?></td>
                    </tr>
                    <tr>
	  		<td width="14%" style="border:1px solid #999; background:#ccc; text-align:center; height:40px;">Domingo</td>
			<td width="14%" style="border:1px solid #999; background:#ccc; text-align:center; height:40px;">Lunes</td>
                        <td width="14%" style="border:1px solid #999; background:#ccc; text-align:center; height:40px;">Martes</td>
                        <td width="14%" style="border:1px solid #999; background:#ccc; text-align:center; height:40px;">Miercoles</td>
                        <td width="14%" style="border:1px solid #999; background:#ccc; text-align:center; height:40px;">Jueves</td>
                        <td width="14%" style="border:1px solid #999; background:#ccc; text-align:center; height:40px;">Viernes</td>
                        <td width="14%" style="border:1px solid #999; background:#ccc; text-align:center; height:40px;">S&aacute;bado</td>
	  	    </tr>
<?
			//se hace el recorrido por las semanas
			for($i=0;$i<6;$i++){
?>
			<tr>
<?				
				//se hace el recorrido por los dias de la semana
				for($j=0;$j<7;$j++){
				    if($numeroDia==$j){
					$diaMes=date("j", mktime (0,0,0,$mes,$dia,$anio));
					($diaMes==$diaActual) ? $clase="diaCalendarioActual" : $clase="diaCalendario";
						
?>						
			    <td valign="middle" style="height:20px; text-align:center;border: 1px solid #CCC;">
                        	<div class="<?=$clase;?>"><?=$diaMes;?><input type="checkbox" value="<?=$diaMes;?>"></div>
                            </td>
<?
						$numeroDia+=1;
						$dia+=1;
					}else{
?>
					<td><div class="diaCalendario">&nbsp;</div></td>
<?						
					}
					//se detiene el proceso en caso que sea igual al numero de dias
					if($diaMes==$totalDias)
						break;
				}
				$numeroDia=0;                                
?>
			 </tr>
<?
			//se detiene el proceso en caso que sea igual al numero de dias
						if($diaMes==$totalDias)
							break;
                        }
			$dia=1;			
			
?>
        	</tr>
        </table>    
<?
	}
        
        
        
        
    }
?>