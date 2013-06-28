<?
	include("modeloEnsamble.php");
	$objAsig=new modeloEnsamble();
	//print_r($_POST);
	switch($_POST['action']){
		case "listarProyectos":
			$objAsig->listarProyectos($_POST['idUsuario'],$_POST["optProyecto"]);	
		break;
		case "listarProcesos":
			$objAsig->listarProcesos($_POST["idProyecto"],$_POST["idUsuario"],$_POST["optPc"]);
		break;
		case "listarActividades":
			$objAsig->listarActividades($_POST["idProceso"],$_POST["opt"],$_POST["idUsuario"]);
		break;
		case "nuevoProceso":
			//print_r($_POST);
			$objAsig->nuevoProceso($_POST["id_proyecto"],$_POST["idUsuario"]);
		break;
		case "guardarProceso":
			//print_r($_POST);
			$objAsig->guardarProceso($_POST["id_proyecto"],$_POST["nombre"],$_POST["descripcion"],$_POST["idUsuario"]);
		break;
		case "nuevoActividad":
			$objAsig->nuevaActividad($_POST["id_proceso"],$_POST["idUsuario"]);
		break;
		case "guardarActividad":
			//print_r($_POST);
			$objAsig->guardarActividad($_POST["id_proceso"],$_POST["nombre"],$_POST["descripcion"],$_POST["producto"],$_POST["status"],$_POST["idUsuario"]);
		break;
		case "formAsignacion":
			//print_r($_POST);
			$objAsig->formAsignacion($_POST["accion"],$_POST["idAccion"],$_POST["valor"],$_POST["parametroOpcional"],$_POST["idUsuario"]);
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
			$idUsuario=$_POST["idUsuario"];
			$objAsig->guardarAsignacion($tabla,$idEmpleado,$accionForm,$valorForm,$parametroOpcional,$idUsuario);
		break;
		case "eliminarResponsable":
			$objAsig->eliminarResponsable($_POST["no_empleado"],$_POST["origen"],$_POST["idOrigen"],$_POST["idOrigen1"],$_POST["idUsuario"]);
		break;
		case "guardarNuevoStatus":
			$objAsig->guardarNuevoStatus($_POST["status"],$_POST["div"]);
		break;
		case "actualizarStatus":
			$objAsig->actualizarStatus();
		break;
		case "mostrarFormMetrica":
			$objAsig->mostrarFormMetrica($_POST["ultimoId"],$_POST["idProceso"],$_POST["idUsuario"]);
		break;
		case "actualizarActividadStatus":
			$objAsig->actualizarStatusActividad($_POST["valores"],$_POST["idProceso"],$_POST["idUsuario"]);
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
		case "modAct":
			$objAsig->formActuaAct($_POST["idAct"],$_POST["idProceso"],$_POST["idUsuario"]);
		break;
		case "guardaE":
			$objAsig->guardaE($_POST["idAct"],$_POST["campo"],$_POST["valor"],$_POST["idProceso"],$_POST["idUsuario"]);
		break;
		case "quitarStatus":
			$objAsig->quitarStatus($_POST["idActSta"],$_POST["idAct"],$_POST["idProceso"],$_POST["idUsuario"]);
		break;
		case "FormStat":
			$objAsig->FormStat($_POST["idAct"],$_POST["idProceso"],$_POST["idUsuario"]);
		break;
		case "guardarNSA":
			$objAsig->guardarNSA($_POST["idAct"],$_POST["status"],$_POST["idProceso"],$_POST["idUsuario"]);
		break;
		case "actualizaDE":
			$objAsig->actualizaDE($_POST["idActSta"],$_POST["time"],$_POST["operador"],$_POST["idAct"],$_POST["idProceso"],$_POST["idUsuario"]);
		break;
		case "agregaSBA":
			$objAsig->agregaSBA($_POST["status"],$_POST["idAct"],$_POST["idProceso"],$_POST["idUsuario"]);
		break;
		case "FormActualizaProceso":
			$objAsig->FormActualizaProceso($_POST["id_proyecto"],$_POST["idProceso"],$_POST["idUsuario"]);
		break;
		case "actualizaProceso":
			$objAsig->actualizaProceso($_POST["id_proyecto"],$_POST["nombre"],$_POST["descripcion"],$_POST["id_proceso"],$_POST["idUsuario"]);
		break;
		case "nuevoProyecto":
			$objAsig->nuevoProyecto($_POST["idUsuario"]);                                                                                                              
		break;
		case "guardarProyecto":
			$objAsig->guardarProyecto($_POST["nombre"],$_POST["descPry"],$_POST["fechaInicio"],$_POST["fechaFin"],$_POST["pais"],$_POST["stat"],$_POST["obsPry"],$_POST["idUsuario"]);
		break;
		case "formActPry":
			$objAsig->formActPry($_POST["idProyecto"],$_POST["idUsuario"]);                                                                                                              
		break;
		case "ActualizarProyecto":
			$objAsig->ActualizarProyecto($_POST["nombre"],$_POST["descPry"],$_POST["fechaInicio"],$_POST["fechaFin"],$_POST["pais"],$_POST["stat"],$_POST["obsPry"],$_POST["idUsuario"],$_POST["idProyecto"]);
		break;

	}
?>