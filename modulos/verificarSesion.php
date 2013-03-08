<?php
    include("../includes/txtApp.php");
    session_start();
    //session_regenerate_id(true);
    /*if(!isset($_SESSION[$txtApp['session']['idUsuario']])){
	//header("Location: cerrar_sesion.php?<?$SID;>");
	echo "<script type='text/javascript'> alert('Su sesion se ha cerrado por Inactividad'); window.location.href='cerrar_sesion.php'; </script>";
	exit;
    }*/
    
    if($_SESSION[$txtApp['session']['idUsuario']] != true){
	$_SESSION=array();
	session_unset();
	session_destroy();
	$parametros_cookies = session_get_cookie_params();
	setcookie(session_name(),0,1,$parametros_cookies["path"]);
	echo "<script type='text/javascript'> alert('Su sesion se ha cerrado por Inactividad'); </script>";
	header("Location: mod_login/index.php");
	exit;
    }/*else{
	echo "<script type='text/javascript'>
		alert('sesion existe');
		alert('".$_SESSION[$txtApp['session']['nombreUsuario']]."');
	    </script>";
    }*/
?>