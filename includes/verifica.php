<?
	$usuarios_sesion="usuarios_nextel";
	$url=explode("?",$_SERVER['HTTP_REFERER']);
	$pagRef=$url[0];
	//archivo de configuracion
	include("config.inc.php");
	include("conectarbase.php");
	//se pudo realizar la conexion a la base de datos
	$user=$_POST['user'];
	$pass=$_POST['pass'];
	if (($user!="") && ($pass!="")){
		$sql="SELECT * FROM ".$tblUsers." WHERE usuario='".$user."'";
		$rs = mysql_db_query($db,$sql); 
		//echo 'Se ha extraido '.$rs->RecordCount().' registro.';
		if(mysql_num_rows($rs)!= 0){
			//se encontro al usuario en la base de datos
			/***********extraemos los datos del usuario**********/
			$fila=mysql_fetch_array($rs);
			//while($fila=$rs->FetchNextObject()){
			$id_usuario=$fila['ID'];
			$usuario=$fila['usuario'];
			$password_t=$fila['pass'];;
			$nombre=$fila['nombre'];;
			$apaterno=$fila['apaterno'];
			$nivel=$fila['nivel_acceso'];
			$colocaPass=$fila['cambiarpass'];
			$grupoUsuario=$fila['grupo'];
			//}
			/****************************************************/
			// eliminamos barras invertidas y dobles en sencillas
			$login = stripslashes($_POST['user']);
			//se transforma en mayusculas para comparar con los registros en la BD
			$login=strtoupper($login);
			$nombre_usuario=$login;
			// encriptamos el password en formato md5 irreversible.
			$password = md5($_POST['pass']);
			/*****************************************************/
			// chequeamos el nombre del usuario otra vez contrastandolo con la BD
			// esta vez sin barras invertidas, etc ...
			// si no es correcto, salimos del script con error 4 y redireccionamos a la
			// p᧩na de error.
			if ($login != $nombre_usuario){
				header("Location:".$pagRef."?error=2");
				exit;
			}
			if ($password != $password_t){
				header("Location:".$pagRef."?error=2");
				exit;
			}
			//enviamos una cookie
			setcookie("usuario","$nombre.$apaterno",time()+43200);
			setcookie("nivel","$nivel",time()+43200);
			// incia sessiones
			session_start();
			session_name($nombre.$apaterno);
			session_register("usuarios_nextel");
			// decimos al navegador que no "cachee" esta p᧩na.
			session_cache_limiter('nocache,private');
			// Asignamos variables de sesi󮠣on datos del Usuario para el uso en el
			// resto de p᧩nas autentificadas.
			// definimos usuario_nivel con el Nivel de acceso del usuario de nuestra BD de usuarios
			$_SESSION['id_usuario_n']=$id_usuario;
			$_SESSION['usuario_nivel_n']=$nivel;
			//definimos usuario_nivel con el Nivel de acceso del usuario de nuestra BD de usuarios
			//$_SESSION['usuario_login']=$usuario_datos['usuario'];
			$_SESSION['usuario_login_n']=$usuario;
			//definimos usuario_password con el password del usuario de la sesi󮠡ctual (formato md5 encriptado)
			$_SESSION['usuario_password_n']=$password;
			//otras variables
			$_SESSION['nombre_n']=$nombre;
			$_SESSION['apellido_n']=$apaterno;
			$_SESSION['cambiarPass_n']=$colocaPass;		
			$_SESSION['grupo_n']=$grupoUsuario;
			// Hacemos una llamada a si mismo (scritp) para que queden disponibles
			//si los datos han sido correctos se redirecciona a la pagina principal
			header('Location:../modulos/main-2.php?='.$SID.'');
			//header('Location:../modulos/principal.php?='.$SID.'');
			exit;
		}else{
			/*si por alguna razon no se encuentra en la BD se redirecciona con un error*/
			header("Location:".$pagRef."?error=2");
			//exit;
		}
	}else{
		// -------- Chequear sesion si existe -------
		// usamos la sesion de nombre definido.
		session_name($usuarios_sesion);
		// Iniciamos el uso de sesiones
		session_start();
		// Chequeamos si estan creadas las variables de sesi󮠤e identificaci󮠤el usuario,
		// El caso mas comun es el de una vez "matado" la sesion se intenta volver hacia atras
		// con el navegador.
		if (!isset($_SESSION['usuario_login']) && !isset($_SESSION['usuario_password'])){
			// Borramos la sesion creada por el inicio de session anterior
			session_destroy();
			//die ("Error cod.: 2 - Acceso incorrecto!");				
			header("Location:".$pagRef."?error=2");
			exit;
		}
	}
?>