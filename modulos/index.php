<?php
    session_start();
    session_regenerate_id(true);
    session_destroy();
    include("../includes/txtApp.php");
    if($_SESSION[$txtApp['session']['idUsuario']] != true){
	$_SESSION=array();
	session_unset();
	session_destroy();
	$parametros_cookies = session_get_cookie_params();
	setcookie(session_name(),0,1,$parametros_cookies["path"]);
	header("Location: mod_login/index.php");
	exit;
    }
?>