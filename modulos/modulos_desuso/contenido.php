<?
	session_start();
	if(!session_is_registered('usuarios_nextel')){
		session_destroy();
		header("Location: mod_login/index.php?error=2");
		exit;
	}
	include("../includes/config.inc.php");
	include("../includes/conectarbase.php");
	$sql_usuarioX="select sexo from userdbnextel where id='".$_SESSION['id_usuario']."'";
	$result_usuarioX=mysql_db_query($db,$sql_usuarioX);
	$fila_usuarioX=mysql_fetch_array($result_usuarioX);
	if($fila_usuarioX['sexo']=="M"){
		$img="../img/User-male-64.png";
	}else if($fila_usuarioX['sexo']=="F"){
		$img="../img/User-female-64.png";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<style type="text/css">
<!--
body{ background:#666; margin:3px;}
-->
</style>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<div style="overflow:hidden; height:100%; font-family:Verdana, Geneva, sans-serif;">
	<div style="float:left; font-size:18px; padding:20px; clear:both;">Seleccione una Opci&oacute;n del men&uacute;</div>
    <div style="border:2px solid #000; background-color:#FFF; height:80px; width:400px; float:right;">
        <table width="100%" border="0" align="right" cellspacing="0" cellpadding="0" style="font-family:Verdana, Geneva, sans-serif; color:#000;">
          <tr>
            <td width="25%" rowspan="3" valign="middle" align="center"><img src=<?=$img;?> border="0" width="64" height="64" /></td>
            <td width="75%" valign="top" style="height:25px; font-size:10px;">&nbsp;Bienvenid@:</td>
          </tr>
          <tr>
            <td valign="top" style="height:25px; font-size:10px;">&nbsp;<?=$_SESSION['nombre']." ".$_SESSION['apellido'];?></td>
          </tr>
          <tr>
            <td style="height:25px; font-size:10px;">&nbsp;<?=date("F j Y, g:i a");?></td>
          </tr>
        </table>	
    </div>
</div>
</body>
</html>