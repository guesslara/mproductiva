<?php
/*
 *Controlador para poder interactuar con las operaciones en los catalogos
*/
    include_once("classCat.php");
    $obj = new catalogo();
	switch($_POST["action"]){
            case 'catalogo_listar':
                $c=$_POST['c'];
		$prefijo=$_POST['pre'];
                $obj->catalogo_listar($c,$prefijo);
                
            break;
	    case 'catalogos_agregar':
		$c=$_POST['c'];
		$prefijo=$_POST['pre'];
		$obj->catalogos_agregar($c,$prefijo);
	    break;
	    case 'cdm_catalogo_insertar':
		$t=$_POST['tabla'];
		$cv=$_POST['campo_valor'];
		$obj->catalogo_insertar($t,$cv);
	    break;
	    case 'catalogo_update':
		$c=$_POST['c'];
		$prefijo=$_POST['pre'];
		$obj->catalogo_update($c,$prefijo);
	    break;
	    case 'catalogo_actualiza':
	        $c=$_POST['c'];
		$prefijo=$_POST['prefijo'];
		$id=$_POST['id'];
		$obj->catalogo_actualiza($c,$prefijo,$id);
	    break;
	    case 'actualizate':
	    	$t=$_POST['tabla'];
		$cv=$_POST['campo_valor'];
		$id=$_POST['id'];
		$obj->actualizate($t,$cv,$id);
	    break;
	
	    case "formcatalogos":
	    $obj->formcatalogos();
	    break;	    
	}
?>