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
			if(!isset($_POST["tab"])){
				$tab=1;
			}else{
				$tab=$_POST["tab"];
			}
			$objMatriz->armarMatriz($_POST["noEmpleado"],$_POST["fecha1"],$_POST["fecha2"],$tab);
		break;
		case "detalleMatriz":
			//print_r($_POST);
			$objMatriz->armaDetalleMatriz($_POST["noEmpleado"],$_POST["fecha1"],$_POST["fecha2"],$_POST["idActividad"]);
		break;
	}
?>