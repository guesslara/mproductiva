<?
	/*
	 *controlEnsamble: instancia de la clase que se creo en modeloEnsamble del modulo mod_DYR
	  donde tiene como objetivo enlazar cada una de las instancias con sus funciones
	 *Autor: Rocio Manuel Aguilar
	 *Fecha:
	*/
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
		case "formFallas":
			$idParte=$_POST['idParte'];
			$idProyecto=$_POST['idProyectoSeleccionado'];
			//print_r($idParte);
			$objLote->fallas($idParte,$idProyecto);
		break;
	
	}
?>