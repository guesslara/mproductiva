<?
	$pag=$_SERVER['PHP_SELF'];
	
	
	if($_GET['action']=="Error"){
		maneja_error();
	}
			
	if($_GET['action']=="modificaUsuario"){
		$id_usr=$_GET['id_usr'];
		modificaUsuario($id_usr);
	}
	
	if($_GET['action']=="nipUsuario"){
		$id_usr=$_GET['id_usr'];
		nip($id_usr);
	}
	
	if($_GET['action']=="modificaDatosUsuario"){
		$id_usr=$_GET['id_usr'];
		modificaDatosUsuario($id_usr);
	}
	
		
	if($_GET['action']=="generaNip"){
		include("../../includes/config.inc.php");
		include("../../includes/conectarbase.php");
		$id_usr=$_GET['id_usr'];
		$nvo_nip=$_POST['nip'];
		if ($nvo_nip==""){
			maneja_error(1);
		}
		if (!is_numeric($nvo_nip)){
			maneja_error(5);
		}
		$nen=md5($nvo_nip);
		// ....... Se revisa si existe ya el usuario en la tabla 'userautoriza', sino se inserta ......
		$sql_yaexiste="select id_usuario from userautoriza where id_usuario='".$id_usr."'";
		$result_existe=mysql_db_query($db,$sql_yaexiste);
		$ndr_yaexiste=mysql_num_rows($result_existe);
		if ($ndr_yaexiste>0){
			mysql_query("UPDATE userautoriza SET nip='$nen' WHERE id_usuario='$id_usr' ") or die(mysql_error());
			mysql_close ();			
		}else{
			mysql_query("INSERT INTO userautoriza (id,id_usuario,nip) values (null,'$id_usr','$nen') ") or die(mysql_error());
			mysql_close ();		
		}
		mensajes(0);
	}
	
	function nip($id_usr){
		include("../../includes/config.inc.php");
		include("../../includes/conectarbase.php");
		$sql_usuario="select usuario from userdbnextel where ID='".$id_usr."'";
		$result_usuario=mysql_db_query($db,$sql_usuario);
		$fila_usuario=mysql_fetch_array($result_usuario);
?>
		<div id="msgNipUsuario">
        <div style="margin:5px; font-size:12px; background:#FFF; height:190px; text-align:center;">
        <form name="" id="" method="post" action="funcionesContenido.php?action=generaNip&id_usr=<?=$id_usr?>"><br /><br /><br />
        <table width="348" border="0" cellpadding="1" cellspacing="1" align="center" style="font-size:12px;">
        	<tr>
            	<td colspan="2" style="height:25px; background:#000; color:#FFF; font-size:14px;">Confidencial</td>
            </tr>
        	<tr>
            	<td align="left" width="112" style="height:25px; border:1px solid #CCCCCC; background:#f0f0f0;">Usuario</td>
                <td align="left" width="223" style="height:25px; border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;">&nbsp;<?=$fila_usuario['usuario'];?></td>
            </tr>
        	<tr>
            	<td align="left" style="height:25px; border:1px solid #CCCCCC; background:#f0f0f0;">NIP</td>
                <td align="left" style="height:25px; border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;">&nbsp;<input type="password" name="nip" id="nip" size="4" maxlength="4" /></td>
            </tr>
            <tr>
            	<td colspan="2" align="right"><input type="button" value="Cancelar" onclick="cerrarDivNip()" /><input type="submit" value="Actualizar" /></td>
            </tr>                                
        </table><br />
        </form></div></div>
<?	
	}
	
	function modificaUsuario($id_usr){
		include("../../includes/config.inc.php");
		include("../../includes/conectarbase.php");
		$sql_datosUsuario="select * from userdbnextel where ID='".$id_usr."'";
		$result_datosUsuario=mysql_db_query($db,$sql_datosUsuario);
		$fila_datosUsuario=mysql_fetch_array($result_datosUsuario);
		//grupos
		$sql_grupos="SELECT * FROM grupos WHERE activo=1";
		$result_grupos=mysql_db_query($db,$sql_grupos);
?>
		<div id="desv">
        <div id="msgModificaUsuarios">
        	<div style="height:20px; color:#FFFFFF; background:#000000; font-size:12px;">Listado de Usuarios</div>
            <div style="margin:4px; background:#FFFFFF; overflow:auto; height:370px;"><br />
        <form name="" id="" method="post" action="">
        	<input type="hidden" name="idUsuarioAct" id="idUsuarioAct" value="<?=$id_usr;?>" />
        <table width="700" border="0" cellpadding="1" cellspacing="1" align="center" style="font-size:12px;">
          <tr>
            <td colspan="2" style=" background:#000000; padding:5px;"><a href="javascript:resetPass('<?=$id_usr;?>','<?=$fila_datosUsuario['usuario'];?>')" style="color:#FFFFFF; font-size:14px;">Reset Password</a></td>
          </tr>
          <tr>
            <td width="136" align="left" style="height:25px; border:1px solid #CCCCCC; background:#f0f0f0;">Nombre</td>
            <td width="551" align="left" style="height:25px; border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;"><input type="text" name="txtNombreUsuario" id="txtNombreUsuario" style="width:200px;" value="<?=$fila_datosUsuario['nombre'];?>" /></td>
          </tr>
          <tr>
            <td align="left" style="height:25px; border:1px solid #CCCCCC; background:#f0f0f0;">Apellido</td>
            <td align="left" style="height:25px; border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;"><input type="text" name="txtApellidoUsuario" id="txtApellidoUsuario" style="width:200px;" value="<?=$fila_datosUsuario['apaterno'];?>" /></td>
          </tr>
          <tr>
            <td align="left" style="height:25px; border:1px solid #CCCCCC; background:#f0f0f0;">Usuario</td>
            <td align="left" style="height:25px; border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;"><input type="text" name="txtUserName" id="txtUserName" style="width:200px;" value="<?=$fila_datosUsuario['usuario'];?>" /></td>
          </tr>
          <tr>
            <td align="left" style="height:25px; border:1px solid #CCCCCC; background:#f0f0f0;">Nivel Acceso</td>
            <td align="left" style="height:25px; border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;"><select name="lstNivelAcceso" id="lstNivelAcceso" style="width:200px;">
              <option value="<?=$fila_datosUsuario['nivel_acceso'];?>" selected="selected"><?=$fila_datosUsuario['nivel_acceso'];?></option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
            </select>            </td>
          </tr>
          <tr>
            <td align="left" style="height:25px; border:1px solid #CCCCCC; background:#f0f0f0;">Cambio Pass</td>
            <td align="left" style="height:25px; border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;"><select name="lstCambioPass" id="lstCambioPass" style="width:200px;">
              <option value="<?=$fila_datosUsuario['cambiarPass'];?>" selected="selected"><?=$fila_datosUsuario['cambiarPass'];?></option>
              <option value="0">Marcar para Cambiarlo</option>
              <option value="1">Marcar como Cambiado</option>
            </select>            </td>
          </tr>
          <tr>
            <td align="left" style="height:25px; border:1px solid #CCCCCC; background:#f0f0f0;">Directorio</td>
            <td align="left" style="height:25px; border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;"><input type="text" name="txtDirectorioUsuario" id="txtDirectorioUsuario" style="width:200px;" value="<?=$fila_datosUsuario['directorio'];?>" /></td>
          </tr>
          <tr>
            <td align="left" style="height:25px; border:1px solid #CCCCCC; background:#f0f0f0;">Sexo</td>
            <td align="left" style="height:25px; border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;"><select name="lstSexo" id="lstSexo" style="width:200px;">
              <option value="<?=$fila_datosUsuario['sexo'];?>" selected="selected"><?=$fila_datosUsuario['sexo'];?></option>
              <option value="M">Masculino</option>
              <option value="F">Femenino</option>
            </select>            </td>
          </tr>
          <tr>
          	<td align="left" style="height:25px; border:1px solid #CCCCCC; background:#f0f0f0;">Grupo</td>
            <td align="left" style="height:25px; border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;">
            <select name="cboGrupoUsuario" id="cboGrupoUsuario" style="width:200px;">
            	<option value="<?=$fila_datosUsuario['grupo'];?>" selected="selected"><?=$fila_datosUsuario['grupo'];?></option>
<?
			while($row_grupos=mysql_fetch_array($result_grupos)){
?>
				<option value="<?=$row_grupos['id'];?>" selected="selected"><?=$row_grupos['nombre'];?></option>
<?				
			}
?>
            </select>
            </td>
          </tr>
          <tr>
            <td align="left" style="height:25px; border:1px solid #CCCCCC; background:#f0f0f0;">Tipo</td>
            <td align="left" style="height:25px; border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;"><input type="text" name="txtTipoUsuario" id="txtTipoUsuario" style="width:200px;" value="<?=$fila_datosUsuario['tipo'];?>" /></td>
          </tr>
          <tr>
            <td align="left" style="height:25px; border:1px solid #CCCCCC; background:#f0f0f0;">No Nomina</td>
            <td align="left" style="height:25px; border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;"><input type="text" name="txtNominaUsuario" id="txtNominaUsuario" style="width:200px;" value="<?=$fila_datosUsuario['no_nomina'];?>" /></td>
          </tr>
          <tr>
          	<td align="left" style="height:25px; border:1px solid #CCCCCC; background:#f0f0f0;">Activo</td>
            <td align="left" style="height:25px; border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;">
            <select name="cboActivoUsuario" id="cboActivoUsuario" style="width:200px;">
            	<option value="<?=$fila_datosUsuario['activo'];?>" selected="selected"><?=$fila_datosUsuario['activo'];?></option>
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
            </select>
            </td>
          </tr>
          <tr>
            <td colspan="2" align="right" style="height:25px;">
            	<input type="button" name="button" id="button" value="Cancelar" onclick="cerrarDivModifica()" />
            	<input type="button" name="button2" id="button2" value="Actualizar" onclick="actualizaDatosUsuario()" />
            </td>
          </tr>                                                                      
        </table>
		</form><br />
        	</div>
        </div>
        </div>
<?		
	}	
?>