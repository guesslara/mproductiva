<?
	include("modeloEnsamble.php");
	$objMatriz=new modeloEnsamble();
	switch($_POST['action']){
		case "buscarempleado":
			$empleado=$_POST["buscar"];
			$opcionB=$_POST["opcionB"];
			$objMatriz->buscarempleado($empleado,$opcionB);
		break;
		case "buscarDatosMatriz":
			//print_r($_POST);
			$objMatriz->armarMatriz($_POST["noEmpleado"],$_POST["fecha1"],$_POST["fecha2"]);
		break;
	}
?>