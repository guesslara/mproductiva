<?
	/*
	 *controlEnsamble: contiene las instancias de la clase de modeloEnsamble para las funciones de la consulta, inserción, agregado y modificacion de datos
	 *Autor: Rocio Manuel Aguilar
	 *Fecha:29/Nov/2012
	*/
	include("modeloEnsamble.php");
	$objLote=new modeloEnsamble();
	//print_r($_POST);
	switch($_POST['action']){
		case "mostrarLotes":
			/*print_r($_POST);
			exit;*/
			$opt=$_POST['opt'];
			$objLote->mostrarLotesProyecto($_POST["idProyectoSeleccionado"],$opt);
		break;
		case "consultaDetalleLote":
			$id_lote=$_POST['idLote'];
			$id_proyecto=$_POST['idProyectoSeleccionado'];
			$noItem=$_POST['item'];
			$opt=$_POST['opt'];
			$objLote->consultaDetalleLote($id_lote,$id_proyecto,$noItem,$opt);
		break;
		case "guardaTec":
			$id_tecnico=$_POST['valorSeleccionado'];
			$id_proyecto=$_POST['idProyectoSeleccionado'];
			$idPartes=$_POST['idPartes'];
			$opt=$_POST['opt'];
			/*print_r($_POST);
			exit;*/
			$objLote->guardaTec($id_tecnico,$id_proyecto,$idPartes,$opt);
		break;
		case "AB":
			$id_proyecto=$_POST['idProyectoSeleccionado'];
			$usuario=$_POST['usuario'];
			$objLote->AB($usuario,$id_proyecto);
		break;
		case "Status":
			$status=$_POST['valorAsignado'];
			$ID=$_POST['ID'];
			$objLote->status($status,$ID);
		break;
		
	
	}
?>
