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
    	}
		else{
                     @mysql_select_db('iqe_rrhh_2010') or die ("No se puede conectar a la base de datos<br>".mysql_error());
    	}
    			return $conexion;
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
		    <td style="height: 15px;padding: 5px;text-align: right;"><a href="#" onclick="abrir('buscarEmpleado')"> Buscar Empleado a Evaluar</a></td>
		</tr>
	    </table>
	</form>
	<div id="resultadosEvaluadores"></div>   
<?
    }
    public function buscarempleado($empleado){
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
		<td class="resultadosTablaBusqueda"><a href="#" onclick="insertarempleado('<?=$rowListado["no_empleado"];?>','<?=$rowListado["nombres"];?>','<?=$rowListado["a_paterno"];?>','<?=$rowListado["a_materno"];?>'),cerrarVentana('buscarEmpleado')" ><?=$rowListado["no_empleado"];?></a></td>
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
                <option value="undefined">Seleccione una actividad</option>
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
			}
?>
		<tr>
		    <td colspan="2"><input type="hidden" name="hdnContador" id="hdnContador" value="<?=$i;?>"></td>
		</tr>
		<tr>
		    <td><hr style="background: #CCC;"></td>
		</tr>
		<tr>
		    <td colspan="2" style="text-align: right;"><input type="reset" name="Cancelar" value="Cancelar" /><input type="button" name="Guardar" id="btnRegistroDiario" value="Guardar" onclick="guardarDatosRegistro()" onkeyup="guardarDatosRegistro()"/></td>
		</tr>
	    </table>
	    <script type="text/javascript"> $("#txtStatus0").focus(); </script>
<?
	}
}
?>
