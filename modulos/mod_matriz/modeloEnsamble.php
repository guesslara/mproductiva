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
		
		public function armarMatriz($noEmpleado,$fecha1,$fecha2){
			$fecha1x=explode("-",$fecha1);
			$fecha2x=explode("-",$fecha2);
			if($fecha1x[1] != $fecha2x[1]){
				echo "Verifique que las fechas concuerden con el mes a Buscar";
			}else{
				//se buscan los datos del empleado en la tabla CAPTURA-MES
				echo "<br>".$sqlCapMes="SELECT * FROM CAP_MES WHERE no_empleado='".$noEmpleado."' AND mes='".$fecha1x[1]."'";
				$resCapMes=mysql_query($sqlCapMes,$this->conectarBd());
				$rowCapMes=mysql_fetch_array($resCapMes);
				$meses=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			}
			
?>
			<table border="1" cellpadding="1" cellspacing="1" width="300" style="font-size: 10px;margin: 5px;">
				<tr>
					<td width="230">Mes</td>
					<td width="70"><? echo $meses[$fecha1x[1]-1]; ?></td>
				</tr>
				<tr>
					<td>Jornada Laboral</td>
					<td><? echo $rowCapMes["jorna_lab"];?></td>
				</tr>
				<tr>
					<td>Dias Laborables</td>
					<td><? echo $rowCapMes["dias_lab"]; ?></td>
				</tr>
				<tr>
					<td>Dias con Licencia</td>
					<td><? echo $rowCapMes["dias_li"]; ?></td>
				</tr>
				<tr>
					<td>TE (Hrs)</td>
					<td><? echo $rowCapMes["tiem_ex"]; ?></td>
				</tr>
				<tr>
					<td>Meta Productiva</td>
					<td><? echo $rowCapMes["meta_pro"]; ?></td>
				</tr>
				<tr>
					<td>Dias Laborados (Admin)</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>Dias Laborados Operativamente</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>Minutos Laborables por Jornada (min)</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>Horas Laboradas en el Mes al 100 % de Productividad</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>Horas Laboradas en el Mes al % de Productividad</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>Cumplimiento</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>TE (Hrs)</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>Productividad por Dia</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>Productividad por Mes</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>Rendimiento</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>% de Scrap en el Mes</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>% de Rechazo en el Mes</td>
					<td>&nbsp;</td>
				</tr>
			</table>
<?
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