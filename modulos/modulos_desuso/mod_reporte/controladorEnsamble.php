<?
	include("modeloEnsamble.php");
	$objEnsamble=new modeloEnsamble();
	//print_r($_POST);
	switch($_POST['action']){
		case "panel":
			$id_proyecto=$_POST['idProyectoSeleccionado'];
			$objEnsamble->panel($id_proyecto);
		break;
	}
?>
