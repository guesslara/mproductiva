<?
	include("modeloEnsamble.php");
	$objLote=new modeloEnsamble();
	//print_r($_POST);
	switch($_POST['action']){
		case "diagnostica":
			$idProyecto=$_POST['idProyectoSeleccionado'];
			$idUser=$_POST['idUser'];
			$opt=$_POST['opt'];
			$objLote->diagnostica($idProyecto,$idUser,$opt);
		break;
		case "formDia":
			$idProyecto=$_POST['idProyectoSeleccionado'];
			$idUser=$_POST['idUser'];
			$idParte=$_POST['idParte'];
			$objLote->formDia($idProyecto,$idUser,$idParte);
		break;
	
	}
?>