<?
class diario {
    
    
    public function conectar_matriz(){
	$link=mysql_connect('localhost','root','xampp');
	if($link==false){
	    echo "Error en la conexion a la base de datos";
	}else{
	    mysql_select_db('2013_matriz_productiva');
	    return $link;
	}    
    }
    public function conectar_cat_personal(){
        $conexion=@mysql_connect('localhost','root','xampp') or die ("no se pudo conectar al servidor<br>".mysql_error());
	if(!$conexion){
	    echo "Error al conectarse al servidor";	
    	}else{
	    @mysql_select_db('iqe_rrhh_2010') or die ("No se puede conectar a la base de datos<br>".mysql_error());
    	}
    	return $conexion;
    }
    
    private function dameNombreEmpleado($noEmpleado){
	$sqlE="SELECT * FROM cat_personal WHERE no_empleado='".$noEmpleado."'";
	$resE=mysql_query($sqlE,$this->conectar_cat_personal());
	$rowE=mysql_fetch_array($resE);
	return $rowE["nombres"]." ".$rowE["a_paterno"]." ".$rowE["a_materno"];
    }
    
    private function dameNombreActividad($idActividad){
	$sqlA="SELECT * FROM SAT_ACTIVIDAD WHERE id_actividad='".$idActividad."'";
	$resA=mysql_query($sqlA,$this->conectar_matriz());
	if(mysql_num_rows($resA)==0){
	    echo "Error en la aplicacion";
	}else{
	    while($rowA=mysql_fetch_array($resA)){
		echo "<p style='font-weight:bold;text-align:left;height:15px;padding:5px;background:#CCC;border:1px solid #E1E1E1;'>Actividad - ".$rowA["nom_actividad"]."</p>";
	    }
	}
    }
    
    public function formBusquedaRegistro(){
?>
	<table border="0" cellpadding="1" cellspacing="1" width="600" style="font-size: 10px;margin: 10px;">
	    <tr>
		<td colspan="2">Buscar Registros</td>
	    </tr>
	    <tr>
		<td width="100" class="cabeceraTitulosTabla">No Empleado</td>
		<td width="500"><input type="text" readonly="readonly" name="txtBNoEmpleado" id="txtBNoEmpleado"><input type="button" value="Buscar" onclick="abrir('buscarEmpleado','busqueda')" ></td>
	    </tr>
	    <tr>
		<td width="100" class="cabeceraTitulosTabla">Nombre</td>
		<td><span id="nombreBCompleto"></span></td>
	    </tr>
	    <tr>
		<td class="cabeceraTitulosTabla">Fecha</td>
		<td>
		<input type="text" name="busquedaRegistro1" id="busquedaRegistro1" >
		    <input type="button" id="lanzadorB1"  value="..." />
                    <!-- script que define y configura el calendario-->
                    <script type="text/javascript">
                        Calendar.setup({
                            inputField     :    "busquedaRegistro1",      // id del campo de texto
                            ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
                            button         :    "lanzadorB1"   // el id del botón que lanzará el calendario
                        });
                    </script>
		    <input type="text" name="busquedaRegistro2" id="busquedaRegistro2" >
		    <input type="button" id="lanzadorB2"  value="..." />
                    <!-- script que define y configura el calendario-->
                    <script type="text/javascript">
                        Calendar.setup({
                            inputField     :    "busquedaRegistro2",      // id del campo de texto
                            ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
                            button         :    "lanzadorB2"   // el id del botón que lanzará el calendario
                        });
                    </script>
		</td>
	    </tr>
	    <tr>
		<td colspan="2"><hr style="background: #CCC;"></td>
	    </tr>
	    <tr>
		<td colspan="2" style="text-align: right;"><input type="button" value="Buscar..." onclick="buscarRegistros()"</td>
	    </tr>
	</table>
	<div id="resultadosBusqueda" style="margin: 10px;width: 950px;border: 0px solid #CCC;background: #FFF;"></div>
<?
    }
    
    public function consultarRegistroDiario($noEmpleado,$fecha1,$fecha2){
	$sqlRD="SELECT * FROM detalle_captura_registro WHERE fecha BETWEEN '".$fecha1."' AND '".$fecha2."' and no_empleado='".$noEmpleado."'";
	$resRD=mysql_query($sqlRD,$this->conectar_matriz());
	if(mysql_num_rows($resRD)==0){
	    echo "( 0 ) registros en la base de datos.";
	}else{
?>
	    <table border="0" cellpadding="1" cellspacing="1" width="900" style="font-size:10px;">
		<tr>
		    <td colspan="3" style="text-align: left;font-size: 12px;">Resultados de la B&uacute;squeda:</td>
		</tr>		
<?
	    while($rowRD=mysql_fetch_array($resRD)){
?>
		<tr>
		    <td colspan="3"><br><?=$this->dameNombreActividad($rowRD["id_actividad"]);?></td>
		</tr>
		<tr>
		    <td width="300" class="cabeceraTitulosTabla">Nombre</td>
		    <td width="100" class="cabeceraTitulosTabla">Fecha Registro</td>
		    <td width="500" class="cabeceraTitulosTabla">Detalle de la actividad</td>		    
		</tr>
		<tr>		    
		    <td style="text-align: left;border-bottom: 1px solid #CCC;border-left:1px solid #CCC;"><? echo $this->dameNombreEmpleado($rowRD["no_empleado"]); ?></td>
		    <td style="text-align: center;border-bottom: 1px solid #CCC;"><?=$rowRD["fecha"];?></td>
		    <td style="text-align: center;border-bottom: 1px solid #CCC;border-right: 1px solid #CCC;">
<?		
		//mostrar los nombres de los status
		$sqlS="SELECT * FROM ACTIVIDAD_STATUS INNER JOIN SAT_STATUS ON ACTIVIDAD_STATUS.id_status = SAT_STATUS.id_status WHERE ACTIVIDAD_STATUS.id_actividad='".$rowRD["id_actividad"]."'";
		$resS=mysql_query($sqlS,$this->conectar_matriz());
		if(mysql_num_rows($resS)==0){
		    echo "( 0 ) registros encontrados.";
		}else{
		    $valorStatus=explode(",",$rowRD["status"]);
		    
		    echo "<table width='350' border='0' cellpadding='1' cellspacing='1' style='font-size:10px;'>
			    <tr>
				<td width='250' class='cabeceraTitulosTabla'>Status</td>
				<td width='100' class='cabeceraTitulosTabla'>Registros</td>
			    </tr>";
		    $i=0; $color="#E1E1E1";
		    while($rowS=mysql_fetch_array($resS)){
			//if($rowS['tiempo']!=0){
			    
			
			
			//se busca el nombre de los status
			//echo $rowS["nom_status"]."<br>";
			echo "<tr>
				<td style='background:<?=$color;?>;' class='resultadosTablaBusqueda'>".$rowS["nom_status"]."</td>
				<td style='background:<?=$color;?>;' class='resultadosTablaBusqueda'>".$valorStatus[$i]."</td>
			    </tr>";
			$i+=1;
			($color=="#E1E1E1") ? $color="#FFF" : $color="#E1E1E1"; 
		    //}
		    }
		    echo "<tr><td colspan='2'>&nbsp;</td></tr>";
		    echo "</table>";
		}
?>
		    </td>		    
		</tr>
<?
	    }
?>
	    </table>
<?
	}
    }
    
    public function insertaRegistroDiario($idEmpleado,$idStatus,$fechaReg,$horaReg,$valorStatus){
    	$sqlR="INSERT INTO detalle_captura_registro(no_empleado,id_actividad,status,fecha,hora) VALUES ('".$idEmpleado."','".$idStatus."','".$valorStatus."','".$fechaReg."','".$horaReg."')";
	$resR=mysql_query($sqlR,$this->conectar_matriz());
	if($resR){
		echo "<script type='text/javascript'> alert('Datos Guardados');  window.location.href='index.php'; </script>";//capturaActividad(); abrir('buscarEmpleado');
	}else{
		echo "<script type='text/javascript'> alert('Error al Guardar la informacion'); </script>";
	}
    }

    public function form(){
	date_default_timezone_set("Mexico/General");
	$hoy = date('H:i:s ',time());
?>
	<form id="asi_diario">
	    <table border="0" cellpadding="1" cellspacing="1" width="500" style="font-size: 12px;border: 1px solid #666;margin: 5px;" >
		<tr>
		    <td  style="border: 1px solid #CCC;background: #f0f0f0;height: 15px;padding: 5px;">		
		    <p align="right">
		    Fecha:<input type="text" name="fecha" id="fecha" value="<?=date("Y-m-d");?>">
		    <input type="button" id="lanzador1"  value="..." />
                    <!-- script que define y configura el calendario-->
                    <script type="text/javascript">
                                    Calendar.setup({
                                    inputField     :    "fecha",      // id del campo de texto
                                    ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
                                    button         :    "lanzador1"   // el id del botón que lanzará el calendario
                                    });
                          </script>
		    Hora:<input type="text" name="hora" id="hora"  value="<?=$hoy;?>" readonly>
		    </p>
		    </td>
		</tr>
		<tr>
		    <td style="height: 15px;padding: 5px;text-align: right;"><a href="#" onclick="abrir('buscarEmpleado','N/A')"> Buscar Empleado a Evaluar</a></td>
		</tr>
	    </table>
	</form>
	<div id="resultadosEvaluadores"></div>   
<?
    }
    public function buscarempleado($empleado,$opcionB){
	$sqlListado=" SELECT nombres,a_paterno,a_materno,no_empleado FROM cat_personal  WHERE nombres LIKE '%".$empleado."%' AND activo='1'";
	//$esta="SELECT * FROM cat_personal";
	$resListado=mysql_query($sqlListado,$this->conectar_cat_personal()) or die(mysql_error());
	if(mysql_num_rows($resListado)==0){
?>
	<script type="text/javascript">
	    alert("Error: el empleado que busco, no tiene registro de mes. Favor de configurar datos")
	</script>
<?
	}
	else{
     
?>
	<table align="center" BORDER="0" CELLPADDING="0" width="700" CELLSPACING="0" style="font-size: 12px;">
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
	
	/////////////////// desde aqui agregue yo ////////////////
	public function insertarempleado($fecha,$id_empleado,$nombre,$a_paterno,$a_materno){
	    $fecha2 = preg_split("/[\s-]/", $fecha);
	    $ano = $fecha2[0];
	    $mes = $fecha2[1];
	    $dia = $fecha2[2];
	
	    $sqlMuestraDatos="SELECT * FROM CAP_MES WHERE no_empleado='".$id_empleado."' AND mes='".$mes."'";
	    $resMuestraDatos=mysql_query($sqlMuestraDatos,$this->conectar_matriz()) or die(mysql_error());
	    $rowMuestraDatos=mysql_fetch_array($resMuestraDatos);
	    $total=mysql_num_rows($resMuestraDatos);
	    if($total != 0){
	
?>
        <table border="0" cellpadding="1" cellspacing="1" width="500" style="font-size: 12px;border: 0px solid #666;margin: 5px;">
            <tr>
                <td width="150" class="cabeceraTitulosTabla">No. de Nomina:</td><td width="350" class="resultadosTablaBusqueda"><input type="text" name="no_empleado" id="no_empleado" readonly></td>
            </tr>
            <tr>
                <td class="cabeceraTitulosTabla">Nombre:</td><td class="resultadosTablaBusqueda"><input type="text" name="nombres" id="nombres" readonly></td>   
            </tr>
            <tr>
                <td class="cabeceraTitulosTabla">Apellido Paterno:</td><td class="resultadosTablaBusqueda"><input type="text" name="apaterno" id="apaterno" readonly></td>
            </tr>
            <tr>
                <td class="cabeceraTitulosTabla">Apellido Materno:</td><td class="resultadosTablaBusqueda"><input type="text" name="amaterno" id="amaterno" readonly></td>
            </tr>
            <tr>
                <td class="cabeceraTitulosTabla">Horas a Laborar:</td><td class="resultadosTablaBusqueda"><input type="text" name="jornada" id="jornada" readonly></td>
            </tr>
            <tr>
                <td class="cabeceraTitulosTabla">Meta Productiva:</td><td class="resultadosTablaBusqueda"><input text="text" name="metapro" id="metapro" readonly></td>
            </tr> 
	</table><br>
<?
		$sqlActividades="SELECT * FROM ASIG_ACT WHERE id_empleado='".$id_empleado."'";
		$resActividades=mysql_query($sqlActividades,$this->conectar_matriz()) or die(mysql_error());
?>
        <table border="0" cellpadding="1" cellspacing="1" width="500" style="font-size: 12px;border: 0px solid #666;">
            <tr>
                <td width="150" class="cabeceraTitulosTabla">Actividad:</td>
                <td width="350" class="resultadosTablaBusqueda">         
                <select id="listaact" name="listaact" onchange="muestraStatus()" class="styled-select">
                <option value="">Seleccione una actividad</option>
<?
		while($rowActividades=mysql_fetch_array($resActividades)){
		    $sqlNombreAct="SELECT * FROM SAT_ACTIVIDAD WHERE id_actividad='".$rowActividades['id_actividad']."'";
		    $resNombreAct=mysql_query($sqlNombreAct,$this->conectar_matriz()) or die(mysql_error());
		    $rowNombreAct=mysql_fetch_array($resNombreAct);			
?>
                 <option value="<?=$rowNombreAct['id_actividad'];?>"><?=$rowNombreAct['nom_actividad'];?></option>
<?
		}
?>
                </select>
                </td>
            </tr>
	    <tr>
		<td colspan="2"></td>
	    </tr>
        </table><br>
	<div id="status_act"></div>                                
	<div id="msgGuardado" style="border:1px solid #ff0000;"></div>
	<script type="application/javascript">
	    ponerdatos('<?=$id_empleado?>','<?=$nombre?>','<?=$a_paterno?>','<?=$a_materno?>','<?=$rowMuestraDatos['horas_la'];?>','<?=$rowMuestraDatos['meta_pro'];?>');
	</script>
<?
	    }else{
		echo "El empleado (".$id_empleado.") no tiene configurados sus datos para el mes actual";
	    }
	}
	
	public function muestraStatus($listaact){
	    $sqlStatusAct="SELECT * FROM ACTIVIDAD_STATUS WHERE id_actividad='".$listaact."'";
	    $resStatusAct=mysql_query($sqlStatusAct,$this->conectar_matriz()) or die(mysql_error());
		    
	    $sqlproceso="SELECT * FROM SAT_ACTIVIDAD WHERE id_actividad='".$listaact."'";
	    $resproceso=mysql_query($sqlproceso,$this->conectar_matriz()) or die(mysql_error());
	    $rowproceso=mysql_fetch_array($resproceso);
	    $idProceso=$rowproceso['id_proceso'];
	    
	    $sqlNombreProceso="SELECT * FROM SAT_PROCESO WHERE id_proceso='".$idProceso."'";
	    $resNombreProceso=mysql_query($sqlNombreProceso,$this->conectar_matriz()) or die(mysql_error());
	    $rowNombreProceso=mysql_fetch_array($resNombreProceso);
	    $idProyecto=$rowNombreProceso['id_proyecto'];
	    
	    $sqlproyecto="SELECT * FROM SAT_PROYECTO WHERE id_proyecto='".$idProyecto."'";
	    $resproyecto=mysql_query($sqlproyecto,$this->conectar_matriz()) or die(mysql_error());
	    $rowproyecto=mysql_fetch_array($resproyecto);
?>
	    <input type="hidden" name="txtIdActividad" id="txtIdActividad" value="<?=$listaact;?>" />
		<table border="0" cellpadding="1" cellspacing="1" width="700" style="font-size: 12px;border: 0px solid #666;margin: 5px; " >
		<tr>
		    <td width="150" class="cabeceraTitulosTabla">Proyecto:</td><td width="550" class="resultadosTablaBusqueda"><strong><?=$rowproyecto['nom_proyecto']?></strong></td>
		</tr>
		<tr>
		    <td class="cabeceraTitulosTabla">Proceso:</td><td class="resultadosTablaBusqueda"><strong><?=$rowNombreProceso['nom_proceso']?></strong></td>
		</tr>
		<tr>
		    <td class="cabeceraTitulosTabla">Status:</td>
		</tr>		
<?
			$i=0;
			while($rowStatusAct=mysql_fetch_array($resStatusAct)){
			    if($rowStatusAct['tiempo'] == 0){
				?>
				<input type="hidden" name="scrap" id="scrap" value="*" />
			    <?}
			    if($rowStatusAct['tiempo']!= 0){
				$sqlNombreStatus="SELECT * FROM SAT_STATUS WHERE id_status='".$rowStatusAct['id_status']."'";
				$resNombreStatus=mysql_query($sqlNombreStatus,$this->conectar_matriz()) or die(mysql_error());
				$rowNombreStatus=mysql_fetch_array($resNombreStatus);
				$idTxt="txtStatus".$i;
				$divVal="divVal".$i;
?>		
		<tr>
		    <td><?=$rowNombreStatus['nom_status'];?></td>
		    <td><input type="text" id="<?=$idTxt;?>" name="<?=$idTxt;?>" onkeyup="verificaTecla('<?=$i;?>',event)" /><span id="<?=$divVal;?>" style="height: 20px;padding: 5px;background: #C3DBFE;color: #ff0000;font-weight: bold;display: none;"></span></td>    
		</tr>
<?
			    $i+=1;
			}}
?>
		<tr>
		    <td colspan="2"><input type="hidden" name="hdnContador" id="hdnContador" value="<?=$i;?>"></td>
		</tr>
		<tr>
		    <td><hr style="background: #CCC;"></td>
		</tr>
		<tr>
		    <td colspan="2" style="text-align: right;"><input type="reset" name="Cancelar" value="Cancelar" />
			<input type="button" name="Guardar" id="btnRegistroDiario" value="Guardar" onclick="guardarDatosRegistro()" onkeyup="guardarDatosRegistro()"/></td>
		</tr>
	    </table>
	    <script type="text/javascript"> $("#txtStatus0").focus(); </script>
<?
	}
}
?>
