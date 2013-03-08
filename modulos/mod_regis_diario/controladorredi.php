<?
	include_once("claseredi.php");
	$registroDiario = new diario();	
	switch($_POST["action"]){ 
		case "insertar":
			$registroDiario->form();
		break;
		case "buscarempleado":
			$empleado=$_POST["buscar"];
			$registroDiario->buscarempleado($empleado);
		break;
		case "otro":
			$empp=$_POST["id_empleado"];
			print_r($empp);
		exit;
		case "otro":
			$empp=$_POST["id_empleado"];
			//print_r($empp);
		exit;
		case "insertarempleado":
			$fecha=$_POST["fecha"];
			$id_empleado=$_POST["id_empleado"];
			$nombre=$_POST["nombre"];
			$a_paterno=$_POST["a_paterno"];
			$a_materno=$_POST["a_materno"];
			$registroDiario->insertarempleado($fecha,$id_empleado,$nombre,$a_paterno,$a_materno);
		exit;
		case "muestraStatus":
			$listaact=$_POST["listaact"];
			$registroDiario->muestraStatus($listaact);
		exit;
		case "guardaRegistroDiario":
			//print_r($_POST);
			$idEmpleado=$_POST["idEmpleado"];
			$idStatus=$_POST["idStatus"];
			$fechaReg=$_POST["fechaReg"];
			$horaReg=$_POST["horaReg"];
			$valorStatus =$_POST["valorStatus"];
			$registroDiario->insertaRegistroDiario($idEmpleado,$idStatus,$fechaReg,$horaReg,$valorStatus);
		break;
	break;
}
