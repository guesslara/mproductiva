<?
	//configuracion
	require_once("../../includes/config.inc.php");
	//se incluye el modelo
	require_once("modeloUsuarios.php");
	//objeto del modelo
	$objModeloUsuarios=new modeloUsuarios($host,$usuario,$pass,$db);
	
	if($_GET['action']=="consultaUsuarios"){
		//se listan los usuarios
		$param=$_GET['param'];
		$objModeloUsuarios->listarUsuarios($param);
	}
	//eliminacion de usuarios
	if($_GET['action']=="borrarUsuario"){
		$id_usr=$_GET['id_usr'];
		$objModeloUsuarios->borrarUsuario($id_usr);
	}
	//nuevo usuario
	if($_GET['action']=="nuevoUsuarioForm"){
		$objModeloUsuarios->nuevoUsuarioForm();
	}
	//guarda usuario
	if($_POST['action']=="guardarUsuario"){
		//print_r($_POST);
		$nombre=$_POST['nombre'];
		$apellido=$_POST['apellido'];
		$usuario=$_POST['usuario'];
		$pass1=$_POST['pass1'];
		$pass2=$_POST['pass2'];
		$nivel=$_POST['nivel'];
		$sexo=$_POST['sexo'];
		$tipo=$_POST['tipo'];
		$nomina=$_POST['nomina'];
		$grupoUsuario=$_POST['grupoUsuario'];
		$objModeloUsuarios->guardaUsuario($nombre,$apellido,$usuario,$pass1,$pass2,$nivel,$sexo,$tipo,$nomina,$grupoUsuario);
	}
	//actualizacion de datos
	if($_POST['action']=="actualizaDatosUsuario"){
		//print_r($_POST);
		$nombre=$_POST['nombre'];
		$apellido=$_POST['apellido'];
		$usuario=$_POST['usuario'];
		$nivel=$_POST['nivel'];
		$cambioPass=$_POST['cambioPass'];
		$sexo=$_POST['sexo'];
		$directorioUsuario=$_POST['directorioUsuario'];
		$tipo=$_POST['tipo'];
		$idNoNominaUsuario=$_POST['idNoNominaUsuario'];
		$grupoUsuario=$_POST['grupoUsuario'];
		$activoUsuario=$_POST['activoUsuario'];
		$idUsuarioAct=$_POST['idUsuarioAct'];
		$objModeloUsuarios->datosActualizados($nombre,$apellido,$usuario,$nivel,$cambioPass,$sexo,$directorioUsuario,$tipo,$idNoNominaUsuario,$grupoUsuario,$activoUsuario,$idUsuarioAct);
	}
	//reset pass
	if($_GET['action']=="resetPass"){
		$id_usr=$_GET['id_usr'];
		$objModeloUsuarios->resetPass($id_usr);
	}
	//agrega grupo
	if($_GET['action']=="addGrupo"){
		$objModeloUsuarios->addGrupo();
	}
	//guardado del grupo
	if($_POST['action']=="guardaGrupo"){
		$nombreGrupo=$_POST['nombreGrupo'];
		$permisos=$_POST['permisos'];
		$objModeloUsuarios->guardaGrupo($nombreGrupo,$permisos);
	}
	//consulta de grupos
	if($_GET['action']=="consultarGrupos"){
		$objModeloUsuarios->consultaGrupos();
	}
	//modificar grupo
	if($_GET['action']=="modificaGrupo"){
		$idGrupo=$_GET['idGrupo'];
		$objModeloUsuarios->modificaGrupo($idGrupo);
	}
	//actualizacion del grupo
	if($_POST['action']=="actualizaGrupo"){
		//print_r($_POST);
		$permisos=$_POST['permisos'];
		$idGrupo=$_POST['idGrupo'];
		$objModeloUsuarios->actualizaGrupo($permisos,$idGrupo);
	}
?>