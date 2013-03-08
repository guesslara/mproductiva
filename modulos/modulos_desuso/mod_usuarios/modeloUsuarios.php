<?
	/*
	*/
	require_once("../../includes/config.inc.php");
	require_once("../../clases/conexion/conexion.php");
	
	class modeloUsuarios{
		private $conexion;		
		
		function __construct($host,$usuario,$pass,$db){
			try {
				$conn = new Conexion();
				$this->conexion = $conn->getConexion($host,$usuario,$pass,$db);
				if($this->conexion === false){
					echo "Error en la aplicacion (Modelo)";
				}
			} catch(Exception $e){
				echo "Error en la aplicacion (Excepcion)";
			}
		}//fin construct
		
		//actualizacion del grupo
		public function actualizaGrupo($permisos,$idGrupo){
			$sqlActualizaGrupo="UPDATE grupos set opcFuncional='".$permisos."' WHERE id='".$idGrupo."'";
			$resActualizaGrupo=mysql_query($sqlActualizaGrupo,$this->conexion);
			echo "<br>&nbsp;&nbsp;".mysql_affected_rows()." registro(s) afectado(s) en la Base de Datos.";
		}
		//modificacion del grupo
		public function modificaGrupo($idGrupo){
			$sqlGrupoActual="SELECT * FROM grupos WHERE id='".$idGrupo."'";
			$resGrupoActual=mysql_query($sqlGrupoActual,$this->conexion);
			$rowGrupoActual=mysql_fetch_array($resGrupoActual);
			$privilegios=$rowGrupoActual['opcFuncional'];
			$privilegios=explode("|",$privilegios);
			//funcionalidades
			$sqlFuncionalidades="SELECT * FROM gruposmods WHERE activo=1";
			$resFuncionalidades=mysql_query($sqlFuncionalidades,$this->conexion);
?>
			<form name="frmModificaGrupo" id="frmModificaGrupo">
            <table width="98%" align="center" border="0" cellpadding="1" cellspacing="1" style="font-size:12px;">
            	<tr>
                	<td colspan="3" style="height:25px; background:#000000; color:#FFFFFF;">Informacion del Grupo</td>
                </tr>
                <tr>
                	<td width="50%" style="height:25px; border:1px solid #999; background:#CCC;">Nombre Grupo:</td>
                    <td colspan="2" width="50%">&nbsp;<?=$rowGrupoActual['nombre'];?></td>
                </tr>
                <tr>
                	<td colspan="3">&nbsp;</td>                    
                </tr>
                <tr>
                	<td style="height:25px; border:1px solid #999; background:#CCC;">Modulos</td>
                    <td style="height:25px; border:1px solid #999; background:#CCC;">Pertenece a</td>
                    <td style="height:25px; border:1px solid #999; background:#CCC;">Permisos</td>
                </tr>
<?
			$color="#FFF";
			while($rowFuncionalidades=mysql_fetch_array($resFuncionalidades)){
?>
				<tr style="background:<?=$color;?>;">
                	<td style="border-bottom:1px solid #CCC;"><?=$rowFuncionalidades['modulo'];?></td>
                    <td style="border-bottom:1px solid #CCC;"><?=$rowFuncionalidades['pertenece_a'];?></td>
                    <td style="border-bottom:1px solid #CCC;">
<?
					if(in_array($rowFuncionalidades['id'],$privilegios)){						
						$indice=array_search($rowFuncionalidades['id'],$privilegios);
?>
						<input type="checkbox" id="cb" name="cb" checked="checked" value="<?=$rowFuncionalidades['id']?>" />
<?						
					}else{						
?>
						<input type="checkbox" id="cb" name="cb" value="<?=$rowFuncionalidades['id']?>" />
<?						
					}
?>
                    </td>
                </tr>
<?				
				($color=="FFF") ? $color="F0F0F0" : $color="FFF";
			}
?>
                <tr>
                	<td colspan="3"><hr style="color:#CCC;" /></td>                    
                </tr>
                <tr>
                	<td colspan="3" align="right"><input type="button" value="Guardar Cambios" onclick="actualizaGrupo('<?=$idGrupo;?>')" /></td>                    
                </tr>
            </table>
            </form>
<?			
		}
		//consulta de grupos
		public function consultaGrupos(){
			$sqlGrupos="SELECT * FROM grupos";
			$resultGrupos=mysql_query($sqlGrupos,$this->conexion);
			
			if(mysql_num_rows($resultGrupos)==0){
				echo " ( 0 ) Registros encontrados en la Base de Datos.";
			}else{
?>
			<table width="800" border="0" cellpadding="1" cellspacing="1" align="center" style="font-size:12px;">
				<tr>
					<td width="228" align="center" style="height:30px; background:#000000; color:#FFFFFF;">Nombre</td>
					<td width="350" align="center" style="height:30px;background:#000000; color:#FFFFFF;">Fecha / Hora creaci&oacute;n</td>
					<td width="76" align="center" style="height:30px;background:#000000; color:#FFFFFF;">Activo</td>
					<td width="133" align="center" style="height:30px;background:#000000; color:#FFFFFF;">Funcionalidades</td>
				</tr>                  
<?			
				while($rowGrupos=mysql_fetch_array($resultGrupos)){
					$valores=explode("|",$rowGrupos['opcFuncional']);
?>
				<tr>
					<td align="center" style="height:25px; border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC; border-left:1px solid #CCC;"><a href="javascript:modificaGrupo('<?=$rowGrupos['id'];?>')" title="Modificar los privilegiios de este grupo"><?=$rowGrupos['nombre'];?></a></td>
					<td align="center" style="height:25px; border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;"><?=$rowGrupos['fecha_hora_creacion'];?></td>
					<td align="center" style="height:25px; border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;"><?=$rowGrupos['activo'];?></td>
					<td align="left" style="height:25px; border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;">
                    	<div style="height:200px; overflow:auto;">
<?
					for($i=0;$i<count($valores);$i++){
						$sqlModulos="SELECT modulo FROM gruposmods WHERE id='".$valores[$i]."'";
						$resultModulos=mysql_query($sqlModulos,$this->conexion);
						$rowModulos=mysql_fetch_array($resultModulos);
						echo $rowModulos['modulo']."<br>";
					}
?>
                    	</div>
                    </td>
				</tr>
<?					
				}
?>
			</table>
<?
			}
		}
		//guarda Grupo
		function guardaGrupo($nombreGrupo,$permisos){
			$horaCreacion=date("Y-m-d")."/".date("H:i:s");
			echo "<br>".$sqlGuardaGrupo="INSERT INTO grupos (fecha_hora_creacion,nombre,opcFuncional) values('".$horaCreacion."','".$nombreGrupo."','".$permisos."')";
			$resultGuardaGrupo=mysql_query($sqlGuardaGrupo,$this->conexion);
			if($resultGuardaGrupo==true){
				echo "<br>Se ha creado el Grupo satisfactoriamente.<br>";
			}else{
				echo "<br>Se ha creado el Grupo satisfactoriamente.<br>";
			}
		}
		
		//agrega grupo
		function addGrupo(){		
			include("../../includes/conectarbase.php");
			$sql_modulos="SELECT * FROM gruposmods WHERE activo='1'";
			$result_modulos=mysql_query($sql_modulos,$this->conexion);
			$regs=mysql_num_rows($result_modulos);
	?>
			<form name="crearGrupo" id="crearGrupo"><br />
            <table width="600" border="0" cellspacing="1" cellpadding="1" align="center" style="font-size:12px; border:1px solid #666;">
				<tr>
					<td colspan="6" style="height:25px; margin-top:5px; background:#000; color:#FFF;">Agregar Nuevo Grupo</td>
				</tr>
				<tr>
					<td width="162">Nombre del Grupo</td>
					<td colspan="5"><input type="text" name="nombreGrupo" id="nombreGrupo" style="width:250px; font-size:14px;" /></td>					
				</tr>
				<tr>
					<td colspan="6" style="height:25px;">Seleccione los Privilegios del grupo en el Sistema</td>
				</tr>
				<tr>
					<td colspan="2" align="left" style=" background:#CCC; border:1px solid #999;">Modulo</td>
					<td width="139" align="center" style=" background:#CCC; border:1px solid #999;">Permiso</td>
					<!--<td width="137" align="center">Lectura</td>-->
					<!--<td align="center">W</td>-->
					<!--<td align="center">X</td>-->
				</tr>
	<?
				if($regs != 0){
					while($row_modulos=mysql_fetch_array($result_modulos)){
	?>
						<tr>
							<td colspan="2" style="height:25px; border-bottom:1px solid #CCC;">&nbsp;&nbsp;<?=$row_modulos['modulo'];?></td>
							<td style="text-align:center;height:25px; border-bottom:1px solid #CCC; border-left:1px solid #CCC;"><input type="checkbox" name="cb" value="<?=$row_modulos['id'];?>" /></td>
							<!--<td style=" text-align:center;height:25px;"><input type="checkbox" name="cb" value="1" /></td>-->
							<!--<td style="text-align:center;height:25px;"><input type="checkbox" name="cb" value="1" /></td>-->
							<!--<td style="text-align:center;height:25px;"><input type="checkbox" value="1" /></td>-->
						</tr>
	<?		
					}
				}else{
	?>
					<tr>
						<td colspan="6">No hay Modulos Activos</td>
					</tr>
	<?			
				}
	?>
				<tr>
					<td colspan="6"><hr color="#CCCCCC" /></td>
				</tr>
				<tr>
					<td colspan="6" align="right"><input type="button" value="Guardar Grupo" onclick="guardaGrupo()" /></td>
				</tr>            
	</table></form><br />
	<?			
		}
		//reset pass
		public function resetPass($id_usr){
			include("../../includes/config.inc.php");
			include("../../includes/conectarbase.php");
			$pass=$strP;
			$sql_reset="UPDATE userdbnextel set pass='".$strP."',cambiarPass='0' WHERE ID='".$id_usr."'";
			$result_reset=mysql_query($sql_reset,$this->conexion);
			if($result_reset==true){
				$this->mensajes(2);
			}else{
				$this->maneja_error(8);
			}
		}
		//datos a modificar
		public function datosActualizados($nombre,$apellido,$usuarioNuevo,$nivel,$cambioPass,$sexo,$directorioUsuario,$tipo,$idNominaUsuario,$grupoUsuario,$activoUsuario,$idUsuarioAct){
			include("../../includes/config.inc.php");
			include("../../includes/conectarbase.php");
			echo $sql_updateUsr="UPDATE ".$tblUsers." SET usuario='".$usuarioNuevo."',nombre='".$nombre."',apaterno='".$apellido."',nivel_acceso='".$nivel."',cambiarPass='".$cambioPass."',directorio='".$directorioUsuario."',sexo='".$sexo."',tipo='".$tipo."',no_nomina='".$idNominaUsuario."',grupo='".$grupoUsuario."',activo='".$activoUsuario."' WHERE ID='".$idUsuarioAct."'";
			$result_datosAct=mysql_query($sql_updateUsr,$this->conexion);
			if($result_datosAct==true){
				$this->mensajes(1);
			}else{
				$this->maneja_error(7);
			}
		}//fin datos a modificar
		
		//guarda usuario
		public function guardaUsuario($nombre,$apellido,$usuarioNuevo,$pass1,$pass2,$nivel,$sexo,$tipo,$nomina,$grupoUsuario){
			include("../../includes/config.inc.php");
			include("../../includes/conectarbase.php");
			//se forza a una segunda validacion
			if ($pass1=="" or $pass2=="" or $usuario=="" or $nivel==""){ maneja_error(1); }
			if ($pass1 != $pass2){ maneja_error(2); }
			if (!eregi("[0-9]",$nivel)){ maneja_error(3); }
			//se verifica que el nombre de usuario no exista en la base de datos
			$usuario=stripslashes($usuario);
			$sql_verificaUser="select ID from userdbnextel where usuario='".$usuario."'";
			$result_verificaUser=mysql_query($sql_verificaUser,$this->conexion);
			$total_encontrados = mysql_num_rows ($result_verificaUser);
			if ($total_encontrados != 0) {
				$this->maneja_error(4);
			}else{
				$pass1 = md5($pass1);
				//se inserta el registro en la base de datos
				$sql_1="insert into userdbnextel (usuario,pass,nombre,apaterno,nivel_acceso,sexo,tipo,no_nomina,grupo,fecha_creacion,hora_creacion)";
				$sql_2="values ('".$usuarioNuevo."','".$pass1."','".$nombre."','".$apellido."','".$nivel."','".$sexo."','".$tipo."','".$nomina."','".$grupoUsuario."','".date('Y-m-d')."','".date('H:i:s')."')";
				$sql_inserta=$sql_1.$sql_2;
				$result_inserta=mysql_db_query($db,$sql_inserta);
				if($result_inserta==true){
					$this->mensajes(0);
				}else{
					$this->maneja_error(6);
				}
			}		
		}//fin guarda usuario
		
		//nuevo usuario
		public function nuevoUsuarioForm(){
			include("../../includes/conectarbase.php");
			$sql_grupos="SELECT * FROM grupos WHERE activo=1";
			$result_grupos=mysql_query($sql_grupos,$this->conexion);
			$regs_grupos=mysql_num_rows($result_grupos);
			$pagActual=$_SERVER['PHP_SELF'];
?>
        <div style="padding:10px;">
            <form method="post">
            	<input type="hidden" id="seleccionUsuario" name="seleccionUsuario" />
                <table width="600" border="0" cellspacing="1" cellpadding="1" align="center" style="font-size:12px;">
                  <tr>
                    <td colspan="2" style="height:25px; margin-top:5px; background:#000; color:#FFF;">Registro de nuevo Usuario</td>
                  </tr>
                  <!--<tr>
                  	<td colspan="2" align="left" style="height:25px;">Selecciona:                    
                    	<select name="seleccionCapturaUsuario" id="seleccionCapturaUsuario" onchange="seleeccionCaptura()">
                        	<option value="">Selecciona</option>
                            <option value="usrSistema">Usuario del Sistema</option>
                            <option value="usrPersona">Personal en General</option>
                        </select>
                    </td>
                  </tr>-->
                  </table>
                  <div id="datosUsuarioPersonales" style="display:block; margin:5px;">
                  <table width="600" border="0" cellspacing="1" cellpadding="1" align="center" style="font-size:12px; border:1px solid #666;">
                      <tr>
                        <td width="156" class="bordesTitulos" style="height:25px;">Nombre</td>
                        <td width="350" class="bordesContenido" style="height:25px;"><input type="text" name="txtNombre" id="txtNombre" style="width:250px; font-size:14px;" /></td>
                      </tr>
                      <tr>
                        <td class="bordesTitulos" style="height:25px;">Apellido Paterno</td>
                        <td class="bordesContenido" style="height:25px;"><input type="text" name="txtPaterno" id="txtPaterno" style="width:250px;" /></td>
                      </tr>
                      <tr>
                        <td colspan="2">&nbsp;</td>
                      </tr>
                  </table>
                  </div>
                  <div id="datosUsuarioSistemaP" style="display:block; margin:5px;">
                  <table width="600" border="0" cellspacing="1" cellpadding="1" align="center" style="font-size:12px; border:1px solid #666;">
                      <tr>
                        <td width="156" class="bordesTitulos" style="height:25px;">Nombre de Usuario</td>
                        <td width="350" class="bordesContenido" style="height:25px;"><input type="text" name="txtUsuario" id="txtUsuario" style="width:250px;" /></td>
                      </tr>
                      <tr>
                        <td class="bordesTitulos" style="height:25px;">Password:</td>
                        <td class="bordesContenido" style="height:25px;"><input type="password" name="txtPass" id="txtPass" style="width:250px;" /></td>
                      </tr>
                      <tr>
                        <td class="bordesTitulos" style="height:25px;">Password repitalo:</td>
                        <td class="bordesContenido" style="height:25px;"><input type="password" name="txtPass1" id="txtPass1" style="width:250px;" /></td>
                      </tr>
                  </table>
                  </div>
                  <div id="datosAdicionales1" style="display:block; margin:5px;">
	                <table width="600" border="0" cellspacing="1" cellpadding="1" align="center" style="font-size:12px; border:1px solid #666;">
                      <tr>
                        <td colspan="2">&nbsp;</td>
                      </tr>
                      <tr>
                      	<td width="156" class="bordesTitulos">Tipo</td>
                        <td width="350" class="bordesContenido"><input type="text" name="idTipoUsuario" id="idTipoUsuario" /></td>
                      </tr>
                      <tr>
                      	<td class="bordesTitulos">No Nomina</td>
                        <td class="bordesContenido"><input type="text" name="idNoNominaUsuario" id="idNoNominaUsuario" /></td>
                      </tr>
                    </table>  
                </div>
                  <div id="datosAdicionales" style="display:block; margin:5px;">
                  <table width="600" border="0" cellspacing="1" cellpadding="1" align="center" style="font-size:12px; border:1px solid #666;">
                      <tr>
                        <td colspan="2">&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="156" class="bordesTitulos" style="height:25px;">Nivel de Acceso</td>
                        <td width="350" class="bordesContenido" style="height:25px;"><select name="nivelAcceso" id="nivelAcceso" style="width:250px;">
                          <option value="--" selected="selected">Selecciona...</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                          <option value="6">6</option>
                        </select></td>
                      </tr>        
                      <tr>
                        <td class="bordesTitulos" style="height:25px;">Sexo:</td>
                        <td class="bordesContenido" style="height:25px;"><select name="lstSexo" id="lstSexo" style="width:250px;">
                          <option value="--" selected="selected">Selecciona...</option>
                          <option value="M">Masculino</option>
                          <option value="F">Femenino</option>
                        </select></td>
                      </tr>
                      <tr>
                      	<td class="bordesTitulos" style="height:25px;">Grupo:</td>
                        <td class="bordesContenido" style="height:25px;">
<?
						if($regs_grupos != 0){
?>
							<select name="cboGrupoUsuario" id="cboGrupoUsuario" style="width:250px;">
                            	<option value="--" selected="selected">Selecciona...</option>
<?
								while($row_grupos=mysql_fetch_array($result_grupos)){
?>
								<option value="<?=$row_grupos['id'];?>"><?=$row_grupos['nombre'];?></option>
<?								
								}
?>
                            </select>
<?							
						}else{
							echo "No hay Grupos definidos todavia.";
						}
?>
                        &nbsp;&nbsp;<a href="#">Agregar Grupo</a>
                        </td>
                      </tr>                 
                      <tr>
                        <td colspan="2" style="height:25px;" align="right">&nbsp;<input type="button" value="Guardar Informaci&oacute;n" onclick="validacion()" /></td>            
                      </tr>  
                </table>
                </div>                
            </form>
        </div>
<?
		}//fin nuevo usuario
		
		//borrar usuario
		public function borrarUsuario($id_usr){
			include("../../includes/config.inc.php");
			include("../../includes/conectarbase.php");
			$sql_elimina="UPDATE userdbnextel SET activo=0,fecha_eliminacion='".date('Y-m-d')."',hora_eliminacion='".date('H:i:s')."' WHERE ID='".$id_usr."'";
			$result_del1=mysql_query($sql_elimina,$this->conexion);
			if($result_del1==true){	
?>
				<div id="msgResetPass">
					<div style="margin:5px; font-size:12px; background:#FFF; height:190px; text-align:center;"><img src="../../img/clean.png" /> Se ha eliminado el usuario, exitosamente.<br /><br /><br /><input type="button" value="Cerrar" onclick="cierraMsgDel()" /></div>
				</div>
<?			
			}else{
?>
				<div id="msgResetPass">
					<div style="margin:5px; font-size:12px; background:#FFF; height:190px; text-align:center;"><img src="../../img/alert.png" /> Error al eliminar el usuario.<br /><br /><br /><input type="button" value="Cerrar" onclick="cierraMsgDel()" /></div>
				</div>
<?			
			}
		}//fin borrar usuario
		
		//listar los usuarios
		public function listarUsuarios($param){
			include("../../includes/config.inc.php");
			include("../../includes/conectarbase.php");
			//$sql_usuarios="select * from userdbnextel where nivel_acceso <>0 order by nombre asc";
			if($param==1){
				$sql_usuarios="SELECT * FROM userdbnextel WHERE activo=1 ORDER BY nombre ASC";	
			}else if($param==0){
				$sql_usuarios="SELECT * FROM userdbnextel WHERE activo=0 ORDER BY nombre ASC";
			}
			
			//$sql_usuarios="SELECT * FROM produccion_trabajadores WHERE activo='1'";
			$result_usuarios=mysql_query($sql_usuarios,$this->conexion);
			$total_usuariosPer=mysql_num_rows($result_usuarios);
?>
				<!--<div id="desv">
					<div id="msgListaUsuarios">-->
					<div style="height:20px; color:#FFFFFF; background:#000000; font-size:12px;">
						<div style="float:left;">Listado de Usuarios</div>
						<div style="float:right;"><a href="javascript:cerrarDivUsuarios()"><img src="../img/close.gif" border="0" /></a></div>
					</div>
					<!--<div style="margin:4px; height:auto; background:#FFFFFF;"><br />-->
<?
			if($total_usuariosPer != 0){		
?>
				<table width="700" border="0" cellpadding="1" cellspacing="1" align="center" style="font-size:12px;">
				  <tr>
					<td width="134" align="left" style="height:30px; background:#000000; color:#FFFFFF;">Nombre</td>
					<td width="134" align="left" style="height:30px;background:#000000; color:#FFFFFF;">Apellido</td>
					<td width="116" align="center" style="height:30px;background:#000000; color:#FFFFFF;">Usuario</td>
					<td width="37" align="center" style="height:30px;background:#000000; color:#FFFFFF;">NIP</td>
					<td width="34" align="center" style="height:30px;background:#000000; color:#FFFFFF;">Nivel</td>
					<td width="34" align="center" style="height:30px;background:#000000; color:#FFFFFF;">Sexo</td>
					<td width="34" align="center" style="height:30px;background:#000000; color:#FFFFFF;">Grupo</td>
					<td width="173" align="center" style="height:30px;background:#000000; color:#FFFFFF;">Acciones</td>
				  </tr>
<?		
			$color="#f0f0f0";
			while($fila_usr=mysql_fetch_array($result_usuarios)){
?>
				  <tr style="background-color:<?=$color;?>" onmouseover="anterior=this.style.backgroundColor;this.style.backgroundColor='#D5EAFF'" onmouseout="this.style.backgroundColor=anterior">
					<td align="left" style="height:25px; border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;">&nbsp;<?=$fila_usr['nombre'];?></td>
					<td align="left" style="height:25px; border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;">&nbsp;<?=$fila_usr['apaterno'];?></td>
					<td align="center" style="height:25px; border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;">&nbsp;<?=$fila_usr['usuario'];?></td>
					<td align="center" style="height:25px; border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;">&nbsp;<?=$nip2;?></td>
					<td align="center" style="height:25px; border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;">&nbsp;<?=$fila_usr['nivel_acceso'];?></td>
					<td align="center" style="height:25px; border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;">&nbsp;<?=$fila_usr['sexo'];?></td>
                    <td align="center" style="height:25px; border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;">&nbsp;<?=$fila_usr['grupo'];?></td>
					<td align="center" style="height:25px; border-bottom:1px solid #CCCCCC;">&nbsp;<a href="javascript:modificaUsuario('<?=$fila_usr['ID'];?>')">Modificar</a> | <a href="javascript:nip('<?=$fila_usr['ID'];?>')">NIP</a> | <a href="javascript:eliminaUsuario('<?=$fila_usr['ID'];?>','<?=$fila_usr['usuario'];?>')">Eliminar</a></td>
				  </tr>
<?			
				($color=="#f0f0f0") ? $color="#FFFFFF" : $color="#f0f0f0" ;
			}
?>
				</table><br />
<?
			}else{
				echo "<br><strong>&nbsp;No se encontraron registros en la Base de Datos.</strong><br>";
			}
?>
					<!--</div>-->
<!--					</div>
				</div>-->
<?		
		}//fin listar usuarios
		
		function maneja_error($numError){
			$error_accion_ms[0]= "No se puede borrar el Usuario, debe existir por lo menos uno.<br>Si desea borrarlo, primero cree uno nuevo.";
			$error_accion_ms[1]= "Faltan Datos.";
			$error_accion_ms[2]= "Passwords no coinciden.";
			$error_accion_ms[3]= "El Nivel de Acceso ha de ser numerico.";
			$error_accion_ms[4]= "El Nombre de Usuario ya existe en la Base de Datos.";
			$error_accion_ms[5]= "El NIP debe ser numerico.";
			$error_accion_ms[6]= "Error al Guardar la informaci&oacute;n del Usuario Actual.";
			$error_accion_ms[7]= "Error al Actualizar la informaci&oacute;n del Usuario Actual.";
			$error_accion_ms[8]= "Error al Actualizar el Password del Usuario Actual.";
		
			$error_cod = $numError;
			echo "<div align='center'><br><br>$error_accion_ms[$error_cod]<br><br></div>";		
		}
		
		function mensajes($numMensaje){
			$accion_ms[0]= "Registro Guardado Satisfactoriamente.";	
			$accion_ms[1]= "Datos Actualizados Satisfactoriamente.";
			$accion_ms[2]= "Password Actualizado..";
		
			$msg_cod = $numMensaje;
			//echo "<div align='center'>$accion_ms[$msg_cod]<br><br><a href='../mod_conf/index.php'>Regresar al Men&uacute;</a></div>";		
			echo "<div align='center'><br><br>$accion_ms[$msg_cod]<br><br></div>";
		}
		
	}//final de clase

	//$objModeloUsuarios=new modeloUsuarios($host,$usuario,$pass,$db);
?>