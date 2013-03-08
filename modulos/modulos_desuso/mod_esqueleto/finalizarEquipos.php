<?php
    /*
    Clase para finalizar los equipos en la base de datos con lo cual se cumple el ciclo en el sistema de los equipos
    */
    
    class finalizarEquipos{
        
        private function conectarBd(){
            require("../../includes/config.inc.php");
	    $link=mysql_connect($host,$usuario,$pass);
	    if($link==false){
		echo "Error en la conexion a la base de datos";
	    }else{
		mysql_select_db($db);
		return $link;
	    }				
	}
                
        public function finalizarEquiposBD($idEntregaInterna){
            echo $idEntregaInterna;
            //se extraen las entregas asociadas a la entrega interna
            $sqlEntregasAsoc="SELECT id_entregas FROM empaque_validaciones WHERE id='".$idEntregaInterna."'";
            $resEntregasAsoc=mysql_query($sqlEntregasAsoc,$this->conectarBd());
            $rowEntregasAsoc=mysql_fetch_array($resEntregasAsoc);
            echo "<br>Extrayendo entregas relacionadas.";
            $arrayEntregasAsoc=explode(",",$rowEntregasAsoc["id_entregas"]);
            for($i=0;$i<count($arrayEntregasAsoc);$i++){
                //se extraen los imei's por entregas capturadas
                $sqlItemsEntregas="SELECT * FROM empaque_items WHERE id_empaque='".$arrayEntregasAsoc[$i]."'";
                $resItemsEntregas=mysql_query($sqlItemsEntregas,$this->conectarBd());
                if(mysql_num_rows($resItemsEntregas)!=0){
                    echo "<br>Preparandose para actualizar<br>";
                    //se procede a actualizar la informacion de los equipos en la base de datos con el campo mfgdate
                    while($rowItemsEntregas=mysql_fetch_array($resItemsEntregas)){
                        if($rowItemsEntregas["statusEntrega"]=="OK"){
                            //se busca el imei en la tabla principal y se actualiza la informacion capturada
                            //se actualizan los status del equipo                            
                            $sqlActualizaEquipo="UPDATE equipos set mfgdate='".$rowItemsEntregas["mfgdate"]."',status='ENVIADO',statusProceso='ENVIADO' WHERE imei='".$rowItemsEntregas["imei"]."'";
                            $resActualizaEquipo=mysql_query($sqlActualizaEquipo,$this->conectarBd());
                            if($resActualizaEquipo){
                                echo "Imei: ".$rowItemsEntregas["imei"]."actualizado.<br>";
                            }else{
                                echo "Imei: ".$rowItemsEntregas["imei"]."NO ACTUALIZADO.<br>";
                            }
                        }//fin if
                    }//fin while
                }//fin if                
            }//fin for
            //despues de actualizar los imeis en la base de datos se procede a extraerlos para poder insertarlos en la tabla EQUIPOS_ENVIADOS
            echo "<br>Extrayendo datos.....<br>";
            /*
             continuacion..............
            */
            
        }//fin funcion
    }//fin de la clase
?>