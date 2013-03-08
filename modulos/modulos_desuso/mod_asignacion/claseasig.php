<?
//session_start();
	//include("../../clases/funcionesComunes.php");
class asignacion{

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
		
		
		
	  
     /*private function conectarBd(){
		$link=mysql_connect('localhost','desarrollo','desarrollo');
		if($link==false){
			echo "Error en la conexion a la base de datos";
		}else{
			mysql_select_db('2013_matriz_productiva');
			return $link;
		}
            
	}*/
		public function guardarActividad($id_proceso,$nombre,$descripcion,$id_producto){
				$sql="INSERT INTO SAT_ACTIVIDAD (nom_actividad,id_proceso,id_producto,status,descripcion) VALUES ('".$nombre."','".$id_proceso."','".$id_producto."','Activo','".$descripcion."')";
				$res=mysql_query($sql,$this->conectarBd());
				if($res){
					echo "<script type='text/javascript'> alert('Actividad Guardada'); verActividades('".$id_proceso."');</script>";	
				}else{
						echo "<script type='text/javascript'> alert('Error al Guardar al Proceso'); </script>";	
				}
		}
		
		public function guardarProceso($id_proyecto,$nombre,$descripcion){
				$sql="INSERT INTO SAT_PROCESO (nom_proceso,status,id_proyecto,descripcion) VALUES ('".$nombre."','Activo','".$id_proyecto."','".$descripcion."')";
				$res=mysql_query($sql,$this->conectarBd());
				if($res){
					echo "<script type='text/javascript'> alert('Proceso Guardado'); verProcesos('".$id_proyecto."');</script>";	
				}else{
						echo "<script type='text/javascript'> alert('Error al Guardar al Proceso'); </script>";	
				}
		}
		
		public function nuevaActividad($id_proceso){
		      $sqlProducto="SELECT * FROM SAT_PRODUCTO";
		      $resProducto=mysql_query($sqlProducto,$this->conectarBd());
?>
				<input type="hidden" name="hdnProcesoActividad" id="hdnProcesoActividad" value="<?=$id_proceso?>">
				<table border="0" cellpadding="1" cellspacing="1" width="98%" style="font-size: 12px;border: 1px solid #666;">
						<tr>
								<td style="height: 15px;padding: 5px;background: #000;color: #FFF;">Nueva Actividad</td>
						</tr>
						<tr>
								<td>Nombre</td>
						</tr>
						<tr>
								<td><input type="text" name="txtNombreAct" id="txtNombreAct"></td>
						</tr>
						<tr>
								<td>Producto</td>
						</tr>
						<tr>
								<td>
<?
				 if(mysql_num_rows($resProducto)==0){
					    echo "No hay productos Capturados";
				 }else{
?>
					    <select name="cboProductoActividad" id="cboProductoActividad">						       
						     <option value="">Selecciona</option>
<?
					    while($rowProducto=mysql_fetch_array($resProducto)){
?>
						     <option value="<?=$rowProducto["id_producto"];?>"><?=$rowProducto["nom_producto"]." ".$rowProducto["modelo"];?></option>  
<?
					    }
?>
					    </select>
<?
				 }
?>
								</td>
						</tr>
						<tr>
								<td>Descripci&oacute;n</td>
						</tr>
						<tr>
								<td><textarea rows="3" cols="30" name="txtDescAct" id="txtDescAct"></textarea></td>
						</tr>
						<tr>
								<td><hr style="background: #666;"</td>
						</tr>
						<tr>
								<td style="text-align: right">
										<input type="button" onclick="cancelarCapturaActividad()" value="Cancelar">
										<input type="button" onclick="guardarActividad()" value="Guardar Actividad">
								</td>
						</tr>
						<tr>
								<td>&nbsp;</td>
						</tr>
				</table>
<?
		}
		
		public function nuevoProceso($id_proyecto){
?>
				<input type="hidden" name="hdnProcesoProyecto" id="hdnProcesoProyecto" value="<?=$id_proyecto?>">
				<table border="0" cellpadding="1" cellspacing="1" width="98%" style="font-size: 12px;border: 1px solid #666;">
						<tr>
								<td style="height: 15px;padding: 5px;background: #000;color: #FFF;">Nuevo Proceso</td>
						</tr>
						<tr>
								<td>Nombre</td>
						</tr>
						<tr>
								<td><input type="text" name="txtNombreProc" id="txtNombreProc"></td>
						</tr>
						<tr>
								<td>Descripci&oacute;n</td>
						</tr>
						<tr>
								<td><textarea rows="3" cols="30" name="txtDescProc" id="txtDescProc"></textarea></td>
						</tr>
						<tr>
								<td><hr style="background: #666;"</td>
						</tr>
						<tr>
								<td style="text-align: right">
										<input type="button" onclick="cancelarCapturaProceso()" value="Cancelar">
										<input type="button" onclick="guardarProceso()" value="Guardar Proceso">
								</td>
						</tr>
						<tr>
								<td>&nbsp;</td>
						</tr>
				</table>
<?
		}
		
     public function conectar(){
            $conexion=@mysql_connect('localhost','root','xampp') or die ("no se pudo conectar al servidor<br>".mysql_error());
		if(!$conexion){
                     echo "Error al conectarse al servidor";	
    }
		else{
                     @mysql_select_db('iqe_rrhh_2010') or die ("No se puede conectar a la base de datos<br>".mysql_error());
    }
    			return $conexion;
    }
    
	   public function guardarAsignacion($tabla,$idEmpleado,$accionForm,$valorForm,$proyectoSeleccionado){
		      //echo "<br>".$tabla;
		      if($tabla=="ASIG_PROC"){
				 $sqlAsig="INSERT INTO ".$tabla."(id_empleado,status,fecha_asig,hora_asig,id_proceso) VALUES ('".$idEmpleado."','Activo','".date("Y-m-d")."','".date("H:i:s")."','".$valorForm."')";
				 $resAsig=mysql_query($sqlAsig,$this->conectarBd());
				 if($resAsig){
					echo "<br>Registro Guardado";    
				 }else{
					    echo "<br>Error al Guardar la Asignacion";
				 }
		      }else if($tabla=="ASIG_ACT"){
				 $sqlAsig="INSERT INTO ".$tabla."(no_empleado,status,fecha_asig,hora_asig,id_actividad) VALUES ('".$idEmpleado."','Activo','".date("Y-m-d")."','".date("H:i:s")."','".$valorForm."')";
				 $resAsig=mysql_query($sqlAsig,$this->conectarBd());
				 if($resAsig){
					echo "<br>Registro Guardado";    
				 }else{
					    echo "<br>Error al Guardar la Asignacion";
				 }
		      }else if($tabla=="ASIG_PRO"){
				 $sqlAsig="INSERT INTO ".$tabla."(id_empleado,status,fecha_asig,hora_asig,id_proyecto) VALUES ('".$idEmpleado."','Activo','".date("Y-m-d")."','".date("H:i:s")."','".$proyectoSeleccionado."')";
				 $resAsig=mysql_query($sqlAsig,$this->conectarBd());
				 if($resAsig){
					echo "<br>Registro Guardado";    
				 }else{
					    echo "<br>Error al Guardar la Asignacion";
				 }
		      }
		      echo "<br>".$sqlAsig;
		      //echo "<script type='text/javascript'> cerrarVentana('ventanaDialogo') </script>";
	   }
    
	   public function consultaxcheck($contado,$idAccion,$valor){
		$prefijo="SAT_";
	       $origi=str_replace($prefijo,"",$contado);
	       $paconsu="nom_".$origi;
	       
	       if($idAccion=="proceso"){
		  $consulta="SELECT ".$paconsu." from ".$contado." WHERE id_proyecto='".$valor."'";
	       }else if($idAccion=="actividad"){
		  $consulta="SELECT ".$paconsu." from ".$contado." WHERE id_proceso='".$valor."'";
	       }else{
		  $consulta="SELECT ".$paconsu.",id_proyecto from ".$contado;    
	       }	       
	       $conejecutada=mysql_query($consulta,$this->conectarBd()) or die(mysql_error());
	       
	      
	       //if(mysql_num_rows($conejecutada)==0) die("No hay registros para mostrar")
	       $clase_obligaria="campo_obligatorio";
	       
?>
	        <FORM id="asig" >
		      <input type="hidden" name="hdnAccion" id="hdnAccion" value="<?=$idAccion;?>">
		      <input type="hidden" name="hdnValor" id="hdnValor" value="<?=$valor;?>">
		   <div style="border: 1px solid #CCC;background: #f0f0f0;height: 15px;padding: 5px;font-size: 12px;font-weight: bold;">Asignación de <?=$origi;?></div><br><br>
		    <table align="center" style="font-size: 12px;">			     
				 <tr>
					 <td colspan="2">Responsable (s)</td>
					 <td><a href="#" onclick="anadeR()" style="color:blue;">A&ntilde;adir Responsable</a></td>
				 </tr>
				 <tr>
					    <td colspan="3"><hr style="background: #999;"></td>
				 </tr>
				 <tr>
					 <td>Id Empleado:</td>
					 <td><input type="text" name="resP0" id="resP0" readonly="" class="<?=$clase_obligaria?>"></td>
					 <td> <a href="#" onclick="abrir('buscar');" style="color:blue;"> Buscar</a></td>
				 </tr>			 
				 <tr>
					 <td>Nombre:</td>
					 <td><input type="text" style="size: auto;" name="nresP0" id="nresP0" readonly="" value="" class="<?=$clase_obligaria?>"></td>
					 <td>&nbsp;</td>
				 </tr>				 
				 </tr>
					    <td colspan="3"><div id="otroR_0"></div>				
				 </tr>		 
				 <tr>
					    <td><?=$origi?>:</td>
					    <td>						      
					   <select id="<?=$paconsu?>" class="<?=$clase_obligaria?>" <?=$sol?>>
					    <option value="undefined">Seleccione una opcion</option>
<?
		      while($filas=mysql_fetch_array($conejecutada)){				 
				 if($idAccion=="proyecto"){
					    //echo "<script type='text/javascript'>alert('entro al if '".$filas["id_proyecto"]."');</script>";
					    $campoId=$filas["id_proyecto"];
				 }else{
					    $campoId=$filas[$paconsu];
				 }
?>
					    <option value="<?=$campoId;?>"><?=$filas[$paconsu]?></option>
<? 	       
		      } 
?>   
					    </select>
					    </td>
				 </tr>
				 <tr>
					    <td colspan="3"><hr style="background: #999;"/></td>
				 </tr>
				 <tr>
					    <td colspan="3" style="text-align: right;">
						       <input type="button" onclick="cerrarVentana('ventanaDialogo')" name="Cancelar" value="Cancelar" />
<?
			 $name=strtolower(str_replace("SAT_","",$contado));
			 $name1="id_".$name;
			 if($contado=="SAT_PROYECTO"){
				 $ti="ASIG_PRO";
			 //print_r($ti);
			 //exit;
?>
					    <input type="button" name="Guardar" value="Guardar" onclick="VALIDAR('<?=$ti?>','<?=$rowConsulta[$name1]?>');"> </h5>
<?
			 }
			 if($contado=="SAT_PROCESO"){
				 $ti="ASIG_PROC";
			 //print_r($ti);
			 //exit;
?>
					    <input type="button" name="Guardar" value="Guardar" onclick="VALIDAR('<?=$ti?>','<?=$rowConsulta[$name1]?>');"> </h5>
<?
			 }
			 if($contado=="SAT_ACTIVIDAD"){
				 $ti="ASIG_ACT";
			 //print_r($ti);
			 //exit;
?>
					    <input type="button" name="Guardar" value="Guardar" onclick="VALIDAR('<?=$ti?>','<?=$rowConsulta[$name1]?>');"> </h5>
<?
			 }
			 
?>      
					    </td>
				 </tr>
		    </table>	       
		    </FORM>
		<div id="resultadoGuardado"></div>
<?
	  
     }
     
     public function consultarempleado($tecla){

     $esta="SELECT * FROM cat_personal  WHERE nombres LIKE '".$tecla."%'  ";
	  
	 
     //$esta="SELECT * FROM cat_personal";
     $estaeje=mysql_query($esta,$this->conectar()) or die(mysql_error());
     //if(mysql_num_rows($estaeje)==0){
	  
	 // echo"No se encontraron registros";
	  
     //}
     //else{
     ?>
     <table align="center" BORDER="0" CELLPADDING="0" CELLSPACING="0" style="font-size: 12px;">
         <tr>
         <td colspan="15"><center><strong>EMPLEADOS</strong></center></td>
	 </tr>
         <tr>
         <td class="cabeceraTitulosTabla">N° Empleado</td>
	 <td class="cabeceraTitulosTabla">Nombre</td>
	 <td class="cabeceraTitulosTabla">Apellido Paterno</td>
	 <td class="cabeceraTitulosTabla">Apellido Materno</td>	 
        </tr>
        			
     <?
          
     while($fi=mysql_fetch_array($estaeje)){
   
  
     
     $noempleado=$fi["no_empleado"];
     $nombres=$fi["nombres"];
     $apaterno=$fi["a_paterno"];
     $amaterno=$fi["a_materno"];
     $pais=$fi["pais"];
     //$mandar="controladorasig.php?action=recibodatos&no_empleado=".$noempleado."";
     $mandar="controladorasig.php?action=recibodatos&no_empleado=".$noempleado."";
     
     ?>
     <tr>
	  
	  <!--<td><a href="<?=$mandar?>" onclick="seguro()" ><?=$noempleado;?></a></td>-->
	  <td class="resultadosTablaBusqueda1"><a href="#" style="color: blue;" onclick="cerrarVentana('buscar');insertarEmpleado('<?=$noempleado;?>','<?=$nombres;?>','<?=$apaterno;?>','<?=$amaterno?>')" ><?=$noempleado;?></a></td>
	  <td class="resultadosTablaBusqueda1"><?=$nombres;?></font></td>
	  <td class="resultadosTablaBusqueda1"><?=$apaterno;?></td>
	  <td class="resultadosTablaBusqueda1"><?=$amaterno;?></td>
     </tr>  
	  <script type="text/javascript">
		    function seguro(){
		    	
		    if(!confirm("esta seguro que desea eliminar el campo")){
			history.go(-1)
			return ""
		    }
		    }
		    
		    
		    
		  </script>
     <?
     }
     ?>
     </table>
     <?
     
    // }
     }
     public function insertarasignacion($tabla,$camvalores){
     	         //print_r($camvalores);
		//exit;
		$sql_campos="";
		$sql_valores="";
		$prefijo2='SAT_';
		
		$separar_campos=explode("@@@",trim($camvalores));
		//print_r($separar_campos);
		//exit;
		
		foreach ($separar_campos as $cam){
			$separar_campos2=explode("|||",trim($cam));
			//print_r($separar_campos);
			//exit;
			$campoX=str_replace("txt_","",trim($separar_campos2[0]));
			//print_r($campoX);
			//exit;
			$valorX=trim($separar_campos2[1]);
			//print_r($valorX);
			($sql_campos=="")? $sql_campos=$campoX : $sql_campos.=",".$campoX;
			($sql_valores=="")? $sql_valores=$valorX : $sql_valores.=",'".$valorX."'";
		}
		$sql_insertar="INSERT INTO $tabla($sql_campos) VALUES ($sql_valores);";
		//print_r($sql_insertar); exit;
		$consulta=mysql_query($sql_insertar,$this->conectarBd());
		if ($consulta){
			echo "<br><b>&nbsp;Registro Insertado Correctamente.</b>";
			//$idL=mysql_insert_id($this->conectarBd());
			//print($idL);
			//exit;
	       
			 
		}
		else {
			echo "<br>&nbsp; Error SQL (".mysql_error($link).")<br><br><b>&nbsp;El Registro NO se Inserto.</b>";
		}
		//}//fin try
     
     }
     
     
     
     public function consultas($con){
	  if($con=="Proyectos"){
	  $yamearte="select no_empleado,nombres,a_paterno,a_materno,id_asig_pro,nom_proyecto,status from iqe_rrhh_2010.cat_personal,desarrollo_pruebas.ASIG_PRO where iqe_rrhh_2010.cat_personal.no_empleado=desarrollo_pruebas.ASIG_PRO.id_empleado order by id_asig_pro";
	  }
	  if($con=="Procesos"){
	   $yamearte="select no_empleado,nombres,a_paterno,a_materno,id_asig_proc,nom_proceso,status from iqe_rrhh_2010.cat_personal,desarrollo_pruebas.ASIG_PROC where iqe_rrhh_2010.cat_personal.no_empleado=desarrollo_pruebas.ASIG_PROC.id_empleado order by id_asig_proc";    
	  }
	  if($con=="Actividades"){
	   $yamearte="select no_empleado,nombres,a_paterno,a_materno,id_asig_act,nom_actividad,status from iqe_rrhh_2010.cat_personal,desarrollo_pruebas.ASIG_ACT where iqe_rrhh_2010.cat_personal.no_empleado=desarrollo_pruebas.ASIG_ACT.id_empleado order by id_asig_act";    
	  }
	  $consulta=mysql_query($yamearte,$this->conectarBd());
	  
	  
	  ?>
	  <table border="1">
	  <tr>
	       <td colspan="8"><center><strong>Asignacion de <?=$con;?></strong></center></td>
	     </tr>
	     <tr>
	      <td> <strong>Id_Asignacion</strong></td> <td><strong>N°_Empleado</strong></td> <TD><strong>Nombre_Empleado</strong></TD><td><strong>Apellido Paterno</strong></td><td><strong>Apellido Materno</strong></td><td><strong>Nombre_<?=$con;?></strong></td><td><strong>Status Asignacion</strong></td> 
	     </tr>
	  <?
	  
	  while($ati=mysql_fetch_array($consulta)){
	  
	  $idact=$ati["id_asig_act"];
	  $iden=$ati["no_empleado"];
	  $no=$ati["nombres"];
	  $apate=$ati["a_paterno"];
	  $amate=$ati["a_materno"];
	  $nomact=$ati["nom_actividad"];
	  $statu=$ati["status"];
	  $nompro=$ati["nom_proyecto"];
	  $nomproc=$ati["nom_proceso"];
	  $idproc=$ati["id_asig_proc"];
	  $idpro=$ati["id_asig_pro"];
	  
	  if($con=="Proyectos"){
	  ?>
	     <tr>
	     <td><?=$idpro;?></td>
	     <td><?=$iden;?></td>
	     <td><?=$no;?></td>
	     <td><?=$apate;?></td>
	     <td><?=$amate;?></td>
	     <td><?=$nompro;?></td>
	     <td><?=$statu;?></td>
	     </tr>
	     <?
	       
	       
	  }
	  
	  if($con=="Procesos"){
	     ?>
	     <tr>
	     <td><?=$idproc;?></td>
	     <td><?=$iden;?></td>
	     <td><?=$no;?></td>
	     <td><?=$apate;?></td>
	     <td><?=$amate;?></td>
	     <td><?=$nomproc;?></td>
	     <td><?=$statu;?></td>
	     </tr>
	     <?
	  }
	  if($con=="Actividades"){
	        ?>
	     <tr>
	     <td><?=$idact;?></td>
	     <td><?=$iden;?></td>
	     <td><?=$no;?></td>
	     <td><?=$apate;?></td>
	     <td><?=$amate;?></td>
	     <td><?=$nomact;?></td>
	     <td><?=$statu;?></td>
	     </tr>
	     <?
	       
	  
	  }
	
	  }
	  ?>
	  </table>
	  <?
   
	  }
	  
     public function modificarasignaciones($opcion){
	  
	  if($opcion=="Proyectos"){
	  $lamisma="select no_empleado,nombres,a_paterno,a_materno,id_asig_pro,nom_proyecto,status from iqe_rrhh_2010.cat_personal,desarrollo_pruebas.ASIG_PRO where iqe_rrhh_2010.cat_personal.no_empleado=desarrollo_pruebas.ASIG_PRO.id_empleado order by id_asig_pro";
	  }
	  if($opcion=="Procesos"){
	  $lamisma="select no_empleado,nombres,a_paterno,a_materno,id_asig_proc,nom_proceso,status from iqe_rrhh_2010.cat_personal,desarrollo_pruebas.ASIG_PROC where iqe_rrhh_2010.cat_personal.no_empleado=desarrollo_pruebas.ASIG_PROC.id_empleado order by id_asig_proc"; 
	  }
	  if($opcion=="Actividades"){
	  $lamisma="select no_empleado,nombres,a_paterno,a_materno,id_asig_act,nom_actividad,status from iqe_rrhh_2010.cat_personal,desarrollo_pruebas.ASIG_ACT where iqe_rrhh_2010.cat_personal.no_empleado=desarrollo_pruebas.ASIG_ACT.id_empleado order by id_asig_act";
	  }
	  
	  $ejecutala=mysql_query($lamisma,$this->conectarBd());
	  
	  
	    
	  ?>
	  <form name="todo" id="todo">
	  <table border="1">
	  <tr>
	       <td colspan="8"><center><strong>Asignacion de <?=$opcion;?></strong></center></td>
	     </tr>
	     <tr>
	      <td> <strong>Id_Asignacion</strong></td> <td><strong>N°_Empleado</strong></td> <TD><strong>Nombre_Empleado</strong></TD><td><strong>Apellido Paterno</strong></td><td><strong>Apellido Materno</strong></td><td><strong>Nombre_<?=$opcion;?></strong></td><td><strong>Status Asignacion</strong></td> 
	     </tr>
	  <?
	  while($campo=mysql_fetch_array($ejecutala)){
	  
	  $a=$campo["id_asig_act"];
	  $b=$campo["no_empleado"];
	  $c=$campo["nombres"];
	  $d=$campo["a_paterno"];
	  $e=$campo["a_materno"];
	  $f=$campo["nom_actividad"];
	  $g=$campo["status"];
	  $h=$campo["nom_proyecto"];
	  $i=$campo["nom_proceso"];
	  $j=$campo["id_asig_proc"];
	  $k=$campo["id_asig_pro"];
	  
	  if($opcion=="Proyectos"){
	  ?>
	     <tr>
	     <td><input type="checkbox" id="idpro" name="idpro" value="<?=$k;?>"><?=$k;?></td>
	     <td><?=$b;?></td>
	     <td><?=$c;?></td>
	     <td><?=$d;?></td>
	     <td><?=$e;?></td>
	     <td><?=$h;?></td>
	     <td><?=$g;?></td>
	     </tr>
	  	  
	  <?
	       
	       
	  }
	  
	  if($opcion=="Procesos"){
	     ?>
	     <tr>
	     <td><input type="checkbox" id="idproc" name="idproc" value="<?=$j;?>"> <?=$j;?></td>
	     <td><?=$b;?></td>
	     <td><?=$c;?></td>
	     <td><?=$d;?></td>
	     <td><?=$e;?></td>
	     <td><?=$i;?></td>
	     <td><?=$g;?></td>
	     </tr>
	    
	     <?
	  }
	  if($opcion=="Actividades"){
	        ?>
		
	     <tr>
	     <td><input type="checkbox" id="idact" name="idact" value="<?=$a;?>"><?=$a;?></td>
	     <td><?=$b;?></td>
	     <td><?=$c;?></td>
	     <td><?=$d;?></td>
	     <td><?=$e;?></td>
	     <td><?=$f;?></td>
	     <td><?=$g;?></td>
	     </tr>
	    
	       
	     <?
	       
	  
	  }
	
	  }
	  ?>
	  </table>
	  <?
	  if($opcion=="Proyectos"){
	  $tabla="ASIG_PRO";
	  $tc="SAT_PRO";
	  $pro="proyecto";
	  ?>
	  <p><input type="button" id="enviar" value="modificar" onclick="modificar('<?=$tabla;?>','<?=$tc;?>','<?=$pro;?>');"></p>
	  <?
	  }
	  if($opcion=="Procesos"){
	  $tabla="ASIG_PROC";
	  $tc="SAT_PROC";
	  $pro="proceso";
	  ?>
	  <p><input type="button" id="enviar" value="modificar" onclick="modificar('<?=$tabla;?>','<?=$tc;?>','<?=$pro;?>');"</p>
	  <?
	  }
	  if($opcion=="Actividades"){
	  $tabla="ASIG_ACT";
	  $tc="SAT_ACT";
	  $pro="actividad";
	  ?>
	  <p><input type="button" id="enviar" value="modificar" onclick="modificar('<?=$tabla;?>','<?=$tc;?>','<?=$pro;?>');"</p>
	  <?
	  }
	  ?>
	  </form>
	  <?
	  }
     
     public function form_modificar($id,$table,$tc,$cam){
	  //print_r($cam);
	  //exit;
	   //$table=strtolower($table);
	  $idtabla="id_".$table;
	  $otraconca="nom_".$cam;
	  //print_r($otraconca);
	  //exit;
	   $xxx="SELECT $otraconca from $tc";
	   print_r($xxx); exit;
	       $otraxxx=mysql_query($xxx,$this->conectarBd()) or die(mysql_error());;
	      
	       //if(mysql_num_rows($conejecutada)==0) die("No hay registros para mostrar")
	       $clase_obligaria="campo_obligatorio";
	       
	      // $hoy = date('D-M-Y-h-i - g:i:s');
	       date_default_timezone_set("Mexico/General");
	       $hoy = date('Y-m-d H:i:s ',time());
	       //print_r($hoy);
              //exit;
	   
	  $consultita="select no_empleado,nombres,a_paterno,a_materno,$idtabla,$otraconca,status from iqe_rrhh_2010.cat_personal,desarrollo_pruebas.$table where iqe_rrhh_2010.cat_personal.no_empleado=desarrollo_pruebas.$table.id_empleado and $idtabla='$id' order by $idtabla";
	   //print_r($consultita);exit;
	  $ejecutaconsultita=mysql_query($consultita,$this->conectarBd()) or die("No se puede ejecutar la consulta: ".mysql_error());;
	  
	  while($camactu=mysql_fetch_array($ejecutaconsultita)){
	  
	  $Noempleado=$camactu["no_empleado"];
	  $NOM=$camactu["nombres"];
	  $AP=$camactu["a_paterno"];
	  $AM=$camactu["a_materno"];
	  $STA=$camactu["status"];
	  $IDASIG=$camactu[$idtabla];
	  $NOMACT=$camactu[$otraconca];
	  }
	  ?>
	  <tr><td colspan="3"><hr></td></tr>
	  <div id="contenedor">
	       <br>
	       <br>
	        <FORM id="asig_actu" >
		                   <p align="right">  <input type="text" id="fecha_asig" name="fecha_asig" value="<?=$hoy;?>" readonly></p>
	       <bR>
		    <br>
			 <br>
		 
		 
		 
		 <!--<input type="hidden" name="action" id="action" value="insertar">-->	
		    <fieldset style="width: 700px; height: 150px; " >
		    <table align="center">
			     <legend>Datos Personales</legend>     
			 <tr>
			 <td>Id Empleado:</td>
			 <td><input type="text" name="id_empleado" id="id_empleado" class="<?=$clase_obligaria?>"></td>
			 </tr>
			 
			 <tr>
			 <td>Nombre:</td>
			 <td><input type="text" name="nombres" id="nombres" value="" class="<?=$clase_obligaria?>"></td>
			 <td> <a href="#" onclick="abrir('buscar');"> Buscar</a></td>
			 
			 </tr>
			 <tr>
			 <td>Apellido Paterno:</td>
			 <td><input type="text" name="a_paterno" id="a_paterno" value=""></td>
			 </tr>
			 <tr>
			 <td>Apellido Materno:</td>
			 <td><input type="text" name="a_materno" id="a_materno" value=""></td>     
			 </tr>
		    </table>
		    </fieldset>
		    <br>
			 <br>
			      <br>
				   <br>
	  
	       <?=$cam?>:
	       <select id="<?=$otraconca?>" class="<?=$clase_obligaria?>" <?=$sol?>>
	       
	       <option value="undefined">Seleccione una opcion</option>
	        
	      
	       <?
	       
	       
	       
	       
	        while($lineas=mysql_fetch_array($xxx)){
	       ?>
	       <!--<tr>
	       <td><?=$lineas[0]?></td>
	       </tr>-->
	       <option value="<?=$lineas[0]?>" ><?=$lineas[0]?></option>
	       <? 
	       
     
	       
	       }
	      
	       ?>
	        
	       </select>
	     
	       <br>
		    <br>
			 <br>
			      <br>
	       Status de Asignacion:<select id="status" class="<?=$clase_obligaria?>">
	       <option value="undefined">Seleccione un status.</option>
	       <option value="Activo">Activo</option>
	       <option value="Inactivo">Inactivo</option>
	       </select>
		
						  <h5  name="marquesina" align="right"> Asignación de <?=$cam;?></h5>
		
		<br>
		    <br>
			 <br>
			      <br>
				   <br>
					<br>
					     <br>
						  <br>
						       
		     <hr align="center" width="80%"  size="3"/>
		      <h5 align="right"><input type="reset" name="Cancelar" value="Cancelar" />
			 <?

			 if($contado=="SAT_PROYECTO"){
		         $ti="ASIG_PRO";
			 
			 //print_r($ti);
			 //exit;
			 ?>
			 
			 <input type="button" name="Guardar" value="Guardar" onclick="actualizar('<?=$ti?>');"> </h5>
			 <?
			 }
			 if($contado=="SAT_PROCESO"){
			 $ti="ASIG_PROC";
			 //print_r($ti);
			 //exit;
			 ?>
			 <input type="button" name="Guardar" value="Guardar" onclick="actualizar('<?=$ti?>');"> </h5>
			 <?
			 }
			 if($contado=="SAT_ACTIVIDAD"){
			 $ti="ASIG_ACT";
			 //print_r($ti);
			 //exit;
			 ?>
			 <input type="button" name="Guardar" value="Guardar" onclick="actualizar('<?=$ti?>');"> </h5>
			 <?
			 }
			 
			 ?>

		    </FORM>
	       </div>  	
	  
	  <?
     }
     
     private function dameNombreEmpleado($no_empleado){
	   $sqlResp1="SELECT * FROM cat_personal WHERE no_empleado='".$no_empleado."'";//se construye la 2 consulta
	   $resResp1=mysql_query($sqlResp1,$this->conectar());
	   $rowResp1=mysql_fetch_array($resResp1);
	   echo "<div style='height:10px;padding:5px;margin-bottom:3px;'>".$rowResp1["nombres"]." ".$rowResp1["a_paterno"]." ".$rowResp1["a_materno"]."</div>";
     }
     
     public function listarProyectos($status){	   
	   $sqlConsult="SELECT * FROM SAT_PROYECTO INNER JOIN SAT_PAIS ON SAT_PROYECTO.id_pais = SAT_PAIS.id_pais WHERE SAT_PROYECTO.status = '".$status."' ORDER BY id_proyecto DESC";
	   $resulta=@mysql_query($sqlConsult,$this->conectarBd()) or die(mysql_error());
	   if(mysql_num_rows($resulta)==0){
		      echo "<br>( 0 ) Registros encontrados.<br>";
	   }else{
		     $color="#FFF";
		     echo "<div style='height:15px;padding:5px;text-align:center;background:#000;color:#FFF;'>Listado de Proyectos</div>";
		      while($row = mysql_fetch_array($resulta)){
				echo $sqlResp="SELECT * FROM ASIG_PRO WHERE id_proyecto='".$row["id_proyecto"]."' AND status='Activo'";
				$resResp=mysql_query($sqlResp,$this->conectarBd());				
?>
		      <div class="resultadosAvisos" style="height: auto; background: <?=$color?>;" title="Ver Detalle del Proyecto" onclick="klin('Actividades');verProcesos(<?=$row["id_proyecto"]?>);">
				 <table border="0" cellpadding="1" cellspacing="1" width="98%" style="font-size: 10px;">
					    <tr>
						       <td width="10%">Proyecto:</td>
						       <td width="88%"><?=substr($row["nom_proyecto"],0,40)."..."; ?></td>
					    </tr>
					    <tr>
						       <td>Descripci&oacute;n:</td>
						       <td><?=substr($row["descripcion"],0,40)."..."; ?></td>
					    </tr>
					    <tr>
						       <td>Fecha:</td>
						       <td><?=$row["fecha_inicio"];?></td>
					    </tr>
					    <tr>
						       <td>Pa&iacute;s:</td>
						       <td><?=$row["nom_pais"];?></td>
					    </tr>
					    <tr>
						       <td colspan="2">Responsable(s):</td>						
					    </tr>
					    <tr>
						       <td colspan="2">
<?
				 if(mysql_num_rows($resResp)==0){
					    echo "<span style='color:red;'>Responsable no Asignado</span>";
				 }else{
					    while($rowResp=mysql_fetch_array($resResp)){
						       $this->dameNombreEmpleado($rowResp["id_empleado"]);						       
					    }
				 }
?>  
						       </td>
					    </tr>
				</table>
		      </div>			   
<?php	
	   ($color=="#FFF") ? $color="#EEEEEE" : $color="#FFF";}
		      
	   } 
     }
     public function listarProcesos($id_proyecto){
	   $status="Activo";
	   $sqlP="SELECT * FROM SAT_PROYECTO WHERE id_proyecto='".$id_proyecto."'";//se extrae el nombre del proyecto
	   $resP=mysql_query($sqlP,$this->conectarBd());
	   $rowP=mysql_fetch_array($resP);
	   $sqlConsult="SELECT * FROM SAT_PROCESO where id_proyecto='".$id_proyecto."' AND status='".$status."'";
	   $resulta=@mysql_query($sqlConsult,$this->conectarBd()) or die(mysql_error());
?>
	   <div id="contiene">
		      <div id="barraA" style="height: 36px;background: #000;padding: 3px;">
				<div class="opcionesEnsamble" onclick="nuevoProceso('<?=$id_proyecto;?>')" title="Nuevo">Nuevo Proceso</div>
				<div class="opcionesEnsamble" onclick="nuevo('SAT_PROCESO','proceso','<?=$id_proyecto;?>')" title="Nuevo">Asignar Proceso</div>
		      </div>
		      <input type="hidden" name="hdntxtAccion" id="hdntxtAccion" value="procesos">
		      <input type="hidden" name="hdntxtValor" id="hdntxtValor" value="<?=$id_proyecto;?>">
		      <div style="clear: both;"></div>
		      <div style="height: 15px;padding: 5px;font-size: 12px;text-align: left;margin-bottom: 5px;">Procesos del proyecto: <strong><?=$rowP["nom_proyecto"];?></strong></div>
		      <div id="nuevoProceso" style="border: 1px solid #CCC;margin: 3px;background: #f0f0f0;margin-bottom: 10px;"></div>
		      <div id="abajo" style=" height: 90%; width: auto; overflow: auto;">
<?
	   if(mysql_num_rows($resulta)==0){
		      echo "<br>( 0 ) Registros encontrados.<br>";
	   }else{
		     $color="#FFF";
		      while($row = mysql_fetch_array($resulta)){
				$sqlResp="SELECT * FROM ASIG_PROC WHERE id_proceso='".$row["id_proceso"]."' AND status='Activo'";
				$resResp=mysql_query($sqlResp,$this->conectarBd());
?>
		      <div class="resultadosAvisos" style="height: auto;margin: 3px; background: <?=$color?>;" title="" onclick="verActividades(<?=$row['id_proceso']?>);">
				 <table border="0" cellpadding="1" cellspacing="1" width="98%" style="font-size: 10px;">
					    <tr>
						       <td width="10%">Proceso:</td>
						       <td width="88%"><?=substr($row["nom_proceso"],0,30)."..."; ?></td>
					    </tr>
					    <tr>
						       <td>Descripcion:</td>
						       <td><?=substr($row["descripcion"],0,30)."..."; ?></td>
					    </tr>
					    <tr>
						       <td colspan="2">Responsable(s):</td>						
					    </tr>
					    <tr>
						       <td colspan="2">
<?
				 if(mysql_num_rows($resResp)==0){
					    echo "<span style='color:red;'>Responsable no Asignado</span>";
				 }else{
					    while($rowResp=mysql_fetch_array($resResp)){
						       $this->dameNombreEmpleado($rowResp["no_empleado"]);						       
					    }
				 }
?>  
						       </td>
					    </tr>
				</table>
		      </div>			   
<?php	
		      ($color=="#FFF") ? $color="#EEEEEE" : $color="#FFF";
		      }	      
	   }
?>
	   </div>
<?
     }
      public function listarActividades($id_proceso){
		$sqlProc="SELECT * FROM SAT_PROCESO WHERE id_proceso='".$id_proceso."'";
		$resProc=mysql_query($sqlProc,$this->conectarBd());
		$rowProc=mysql_fetch_array($resProc);
	   $status="Activo";
	    ?>
	   <div id="contiene"">
		      <div id="barraA" style="height: 36px;background: #000;padding: 3px;">
				<div class="opcionesEnsamble" onclick="nuevaActividad('<?=$id_proceso;?>')" title="Nuevo">Nueva Actividad</div>
				<div class="opcionesEnsamble" onclick="nuevo('SAT_ACTIVIDAD','actividad','<?=$id_proceso;?>')" title="Nuevo">Asignar Actividad</div>
		      </div>
		      <input type="hidden" name="hdntxtAccion" id="hdntxtAccion" value="actividades">
		      <input type="hidden" name="hdntxtValor" id="hdntxtValor" value="<?=$id_proceso;?>">
		      <div style="clear: both;"></div>
		      <div style="height: 15px;padding: 5px;font-size: 12px;text-align: left;margin-bottom: 5px;">Actividades del Proceso: <strong><?=$rowProc["nom_proceso"];?></strong></div>
		      <div id="nuevaActividad" style="border: 1px solid #CCC;margin: 3px;background: #f0f0f0;margin-bottom: 10px;"></div>
		      <div id="abajo" style=" height: 90%; width: auto; overflow: auto;">
	   <?
	   //echo $sqlConsult="SELECT * FROM SAT_ACTIVIDAD where id_proceso='".$id_proceso."' AND status='".$status."'";
	   $sqlConsult="SELECT * FROM SAT_ACTIVIDAD INNER JOIN SAT_PRODUCTO ON SAT_ACTIVIDAD.id_producto = SAT_PRODUCTO.id_producto WHERE id_proceso = '".$id_proceso."' AND STATUS = '".$status."'";
	   $resulta=@mysql_query($sqlConsult,$this->conectarBd()) or die(mysql_error());
	   if(mysql_num_rows($resulta)==0){
		      echo "<br>( 0 ) Registros encontrados.<br>";
	   }else{
		     $color="#EEEEEE";
		      while($row = mysql_fetch_array($resulta)){
				 $sqlResp="SELECT * FROM ASIG_ACT WHERE id_actividad='".$row["id_actividad"]."' AND status='Activo'";
				 $resResp=mysql_query($sqlResp,$this->conectarBd());
?>
		      <div class="resultadosAvisos" style="margin: 3px;height: auto; background: <?=$color?>;" title="" onclick="ver();">
				 <table border="0" cellpadding="1" cellspacing="1" width="98%" style="font-size: 10px;">
					    <tr>
						       <td width="10%">Actividad:</td>
						       <td width="88%"><?=substr($row["nom_actividad"],0,30)."..."; ?></td>
					    </tr>
					    <tr>
						       <td>Descripcion:</td>
						       <td><?=substr($row["descripcion"],0,30)."..."; ?></td>
					    </tr>
					    <tr>
						       <td>Producto</td>
						       <td><?=$row["nom_producto"];?></td>
					    </tr>
					    <tr>
						       <td colspan="2">
<?
				 if(mysql_num_rows($resResp)==0){
					    echo "<span style='color:red;'>Personal no Asignado</span>";
				 }else{
					    echo "<div style='background:#FFF;height:100px;width:100%;border:1px solid #666;overflow:auto:'>";
					    while($rowResp=mysql_fetch_array($resResp)){
						       $this->dameNombreEmpleado($rowResp["no_empleado"]);						       
					    }
					    echo "</div>";
				 }
?>  
						       </td>
					    </tr>
				</table>
		      </div>			   
<?php	
	   ($color=="#EEEEEE") ? $color="#FFFFFF" : $color="#EEEEEE";}
		      
	   }
	   ?>
		      </div>
	   </div>
	   <?
     }
     public function agregaR($valor,$div){
?>
		 <tr>
			 <td>Id Empleado:</td>
			 <td><input type="text" name="<?=$valor?>" id="<?=$valor?>" readonly="" class="<?=$clase_obligaria?>"></td>
			  <td> <a href="#" onclick="abrir('buscar');"> Buscar</a></td>
			 </tr>
			 
			 <tr>
			 <td>Nombre:</td>
			 <td><input type="text" style="size: auto;" name="n<?=$valor?>" id="n<?=$valor?>" readonly="" value="" class="<?=$clase_obligaria?>"></td>
			 <td><a href="#" onclick="borraResp()">Borrar</a></td>
			 </tr>
			 <tr><td colspan="3"><hr></td></tr>
		<tr>
		<td colspan="2"><div id="<?=$div?>"></div>
<?php
	}
}
?>
	