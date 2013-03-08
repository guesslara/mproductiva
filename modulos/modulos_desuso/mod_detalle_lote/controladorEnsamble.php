<?
	/*
	 *controladorEnsamble:contiene la instancia de la clase y las variables para cada una de las funciones de las clases
	 *Autor: Rocio Manuel Aguilar
	 *Fecha:20/Nov/2012
	*/
	include("modeloEnsamble.php");
	$objLote=new modeloEnsamble();
	//print_r($_POST);
	switch($_POST['action']){
		case "mostrarLotes":
			$objLote->mostrarLotesProyecto($_POST["idProyectoSeleccionado"]);
		break;
		case "consultaDetalleLote":
			$id_lote=$_POST['idLote'];
			$id_proyecto=$_POST['idProyectoSeleccionado'];
			$noItem=$_POST['item'];
			//print_r($_POST);
			//exit;
			$objLote->consultaDetalleLote($id_lote,$id_proyecto,$noItem);
		break;
		case "formAgrega":
			$id_lote=$_POST['idLote'];
			$id_proyecto=$_POST['idProyectoSeleccionado'];
			$noItem=$_POST['item'];
			$objLote->formAgrega($id_lote,$id_proyecto,$noItem);
		break;
		case "addDetalleLote":
			$noParte=$_POST['noParte'];
			$modelo=$_POST['modelo'];
			$codeType=$_POST['codeType'];
			$flowTag=$_POST['flowTag'];
			$numSerie=$_POST['numSerie'];
			$fechaReg=$_POST['fechReg'];
			$horaReg=$_POST['horaReg'];
			$desc=$_POST['desc'];
			$id_lote=$_POST['idLote'];
			$id_proyecto=$_POST['idProyectoSeleccionado'];
			$noItem=$_POST['item'];
			$objLote->agregar($noParte,$modelo,$codeType,$flowTag,$numSerie,$fechaReg,$horaReg,$desc,$id_lote,$id_proyecto,$noItem);
		break;
		case "consultaModifica":
			$id_lote=$_POST['idLote'];
			$id_proyecto=$_POST['idProyectoSeleccionado'];
			$noItem=$_POST['item'];
			$objLote->consultaModifica($id_lote,$id_proyecto,$noItem);
		break;
		case "formModifica":
			$id_lote=$_POST['idLote'];
			$id_proyecto=$_POST['idProyectoSeleccionado'];
			$noItem=$_POST['item'];
			$idParte=$_POST['idParte'];
			$objLote->formModifica($id_lote,$id_proyecto,$noItem,$idParte);
		break;
		case "modifica":
			$noParte=$_POST['noParte'];
			$modelo=$_POST['modelo'];
			$codeType=$_POST['codeType'];
			$flowTag=$_POST['flowTag'];
			$numSerie=$_POST['numSerie'];
			$fechaReg=$_POST['fechReg'];
			$horaReg=$_POST['horaReg'];
			$desc=$_POST['desc'];
			$id_lote=$_POST['idLote'];
			$id_proyecto=$_POST['idProyectoSeleccionado'];
			$noItem=$_POST['item'];
			$idParte=$_POST['idParte'];
			$objLote->modifica($noParte,$modelo,$codeType,$flowTag,$numSerie,$fechaReg,$horaReg,$desc,$id_lote,$id_proyecto,$idParte,$noItem);
		break;
		case "consultaLotes":
			$id_proyecto=$_POST['idProyectoSeleccionado'];
			$objLote->consultaLotes($id_proyecto);
		break;
		case "formLotes":
			$id_proyecto=$_POST['idProyectoSeleccionado'];
			$idUsuario=$_POST['idUsuario'];
			$objLote->formLotes($id_proyecto,$idUsuario);
		break;
		case "addLote":
			//print_r($_POST);
			$noPO=$_POST['noPO'];
			$noItem=$_POST['noItem'];
			$fechaReg=$_POST['fechaReg'];
			$horaReg=$_POST['horaReg'];
			$diasTAT=$_POST['diasTAT'];
			$observaciones=$_POST['observaciones'];
			$id_proyecto=$_POST['id_proyecto'];
			$idUsuario=$_POST['idUsuario'];
			$objLote->agregarLote($noPO,$noItem,$fechaReg,$horaReg,$diasTAT,$observaciones,$idUsuario,$id_proyecto);
		 break;
		case "consultaModificaLotes":
			$id_proyecto=$_POST['idProyectoSeleccionado'];
			$id_usuario=$_POST['id_usuario'];
			$objLote->consultaModificaLotes($id_proyecto,$id_usuario);
		break;
		case "formModificaLote":
			$idLote=$_POST['idLote'];
			$id_proyecto=$_POST['idProyectoSeleccionado'];
			$id_usuario=$_POST['id_usuario'];
			$objLote->formModificaLote($idLote,$id_proyecto,$id_usuario);
		break;
		case "modificaLote":
			$noPO=$_POST['noPO'];
			$noItem=$_POST['noItem'];
			$fechaReg=$_POST['fechaReg'];
			$horaReg=$_POST['horaReg'];
			$diasTAT=$_POST['diasTAT'];
			$observaciones=$_POST['observaciones'];
			$idLote=$_POST['idLote'];
			$id_proyecto=$_POST['idProyectoSeleccionado'];
			$id_usuario=$_POST['id_usuario'];
			$objLote->modificaLote($noPO,$noItem,$fechaReg,$horaReg,$diasTAT,$observaciones,$idLote,$id_proyecto,$id_usuario);
		break;
	
	}
?>
