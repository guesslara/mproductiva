<?
    include_once("clasemes.php");
    $uno = new mes();

    switch($_POST["action"]){ 
        case "formregis":
            $uno->formregis();
        break;
        case "consultarempleado":
            $emp=$_POST["emp"];
            $uno->consultarempleado($emp);
        break;
        case "insertarregistro":
            $tab=$_POST["tabla"];
            //print_r($tab);
            $camvolor=$_POST["valores"];
            //print_r($camvolor);
            //exit;
            $uno->insertarasignacion($tab,$camvolor);
        break;
        case "consultar":
            $uno->consultar_mes();    
        break;
        case "modificar":
            $uno->modifica_mes();
        break;
        case "formmodi":
            $id= $_POST["idcap"];
            //print_r($id);
            //exit;
            $uno->formmodi($id);
        break;
        case "actualizar":
            $tac=$_POST["tac"];
            $arreglo=$_POST["valores"];
            //print_r($arreglo);
            //exit;
            $ids=$_POST["id"];
            $uno->actualiza($tac,$arreglo,$ids);
        break;
        case "verificarEmpleado":
            $uno->verificaEmpleado($_POST["noEmpleado"],$_POST["mes"]);
        break;
        case "verMesConfiguracion":
            //se incluye la clase y se muestra el calendario
            //include("../../clases/calendarioPage.php");
            //$objCalendario=new calendarioPage();
            //$objCalendario->calendarizacion($_POST["mes"],date("Y"),date("d"));
            $uno->calendarizacion($_POST["mes"],date("Y"),date("d"),"N/A");
        break;
    }
?>