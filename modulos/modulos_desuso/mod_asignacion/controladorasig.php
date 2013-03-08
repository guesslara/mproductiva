<?php

include_once("claseasig.php");
$obj = new asignacion();

switch($_POST["action"]){
    case "listar":
        $status=$_POST["status"];
        $obj->listarProyectos($status);
    break;
    case "listarProcesos":
        $id_proyecto=$_POST["id_proyecto"];
        $obj->listarProcesos($id_proyecto);
    break;
    case "listarActividades":
        $id_proceso=$_POST["id_proceso"];
        $obj->listarActividades($id_proceso);
    break;
    case "consultaxcheck":
        $cual=$_POST["cual"];
	$idAccion=$_POST["idAccion"];
	$valor=$_POST["valor"];
        $obj->consultaxcheck($cual,$idAccion,$valor);
    break;
    case "agregarR":
	$obj->agregaR($_POST['id'],$_POST['div']);
    break;
    case "guardarAsignacionForm":
	//print_r($_POST);
	$tabla=$_POST["tabla"];
	$idEmpleado=$_POST["idEmpleado"];
	$accionForm=$_POST["accionForm"];
	$valorForm=$_POST["valorForm"];
	$proyectoSeleccionado=$_POST["proyectoSeleccionado"];
	$obj->guardarAsignacion($tabla,$idEmpleado,$accionForm,$valorForm,$proyectoSeleccionado);
    break;
    case "consultarempleado":
    //print_r($_POST);
    //exit;
    $tecla=$_POST["tecla"];
    $obj->consultarempleado($tecla);
    break;

    case "insertarasignacion":
    //print_r($_POST);
    //exit;
    $tabla=$_POST["tabla"];
    //print_r($tabla);
    //exit;
    $camvalores=$_POST["valores"];
    //print_r($camvalores);
    //exit;

    $obj->insertarasignacion($tabla,$camvalores);
    break;
    case "consultarasignaciones":
    $obj->consultarasignaciones();
    break;
    case "consultas":
       // print_r($_POST);
        //exit;
    $con=$_POST["con"];
    $obj->consultas($con);
    break;
    case "modificarasignaciones":
    //print_r($_POST);
    //exit;
    $opcion=$_POST["opcion"];
    //print_r($opcion);
    //exit;
    $obj->modificarasignaciones($opcion);
    break;

    case "formmodi":
    //print_r($_POST);
    //exit;
    $table=$_POST["tabla"];
    //print_r($table);
   // exit;
    $id=$_POST["contadora"];
    //print_r($id);
   // exit;
   $tc=$_POST["tc"];
   //print_r($tc);
   //exit;
   $cam=$_POST["cam"];
   //print_r($cam);
   //exit;
    $obj->form_modificar($id,$table,$tc,$cam);
    break;
    
    case "nuevoProceso":
	//print_r($_POST);
	$obj->nuevoProceso($_POST["id_proyecto"]);
    break;
    case "guardarProceso":
	print_r($_POST);
	$obj->guardarProceso($_POST["id_proyecto"],$_POST["nombre"],$_POST["descripcion"]);
    break;
    case "nuevoActividad":
	$obj->nuevaActividad($_POST["id_proceso"]);
    break;
    case "guardarActividad":
	$obj->guardarActividad($_POST["id_proceso"],$_POST["nombre"],$_POST["descripcion"],$_POST["producto"]);
    break;
    
}