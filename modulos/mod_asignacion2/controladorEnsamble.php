<?
	include("modeloEnsamble.php");
	$objAsig=new modeloEnsamble();
	//print_r($_POST);
	switch($_POST['action']){
		case "listarProyectos":
			$objAsig->listarProyectos();	
		break;
		case "listarProcesos":
			$objAsig->listarProcesos($_POST["idProyecto"]);
		break;
		case "listarActividades":
			$objAsig->listarActividades($_POST["idProceso"]);
		break;
		case "nuevoProceso":
			//print_r($_POST);
			$objAsig->nuevoProceso($_POST["id_proyecto"]);
		break;
		case "guardarProceso":
			//print_r($_POST);
			$objAsig->guardarProceso($_POST["id_proyecto"],$_POST["nombre"],$_POST["descripcion"]);
		break;
		case "nuevoActividad":
			$objAsig->nuevaActividad($_POST["id_proceso"]);
		break;
		case "guardarActividad":
			$objAsig->guardarActividad($_POST["id_proceso"],$_POST["nombre"],$_POST["descripcion"],$_POST["producto"],$_POST["status"]);
		break;
		case "formAsignacion":
			//print_r($_POST);
			$objAsig->formAsignacion($_POST["accion"],$_POST["idAccion"],$_POST["valor"],$_POST["parametroOpcional"]);
		break;
		case "consultarempleado":
			$tecla=$_POST["tecla"];
			$objAsig->consultarempleado($tecla);
		break;
		case "guardarAsignacionForm":
			//print_r($_POST);
			$tabla=$_POST["tabla"];
			$idEmpleado=$_POST["idEmpleado"];
			$accionForm=$_POST["accionForm"];
			$valorForm=$_POST["valorForm"];
			$parametroOpcional=$_POST["hdnParametroOpcional"];
			$objAsig->guardarAsignacion($tabla,$idEmpleado,$accionForm,$valorForm,$parametroOpcional);
		break;
		case "eliminarResponsable":
			//print_r($_POST);
			$objAsig->eliminarResponsable($_POST["no_empleado"],$_POST["origen"],$_POST["idOrigen"],$_POST["idOrigen1"]);
		break;
		case "guardarNuevoStatus":
			//print_r($_POST);
			$objAsig->guardarNuevoStatus($_POST["status"]);
		break;
		case "actualizarStatus":
			$objAsig->actualizarStatus();
		break;
		case "mostrarFormMetrica":
			$objAsig->mostrarFormMetrica($_POST["ultimoId"]);
		break;
		case "actualizarActividadStatus":
			$objAsig->actualizarStatusActividad($_POST["valores"]);
		break;
		case "formNuevoProducto":
			$objAsig->formNuevoProducto();
		break;
		case "guardarProducto":
			$objAsig->guardarProducto($_POST["nombreProd"],$_POST["modeloProd"]);
		break;
		case "actualizaListadoProductos":
			$objAsig->actualizaListadoProductos();
		break;
	}
?>