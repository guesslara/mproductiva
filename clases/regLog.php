<?php
    /**************************************************************    
    Clase para realizar el log sobre los accesos de los usuarios
    Autor:Dante R. Juarez
    Implementacion en acceso sistema del cliente
    modificada por Gerardo Lara 06/08/2012
    ***************************************************************/
class regLog{
       
    private function conectarBdAcceso(){
	require("../../includes/config.inc.php");
	$link=mysql_connect($host,$usuario,$pass);        
	if($link==false){
            echo "Error en la conexion a la base de datos";
        }else{
            mysql_select_db($db);
            return $link;            
	}				
    }
    
    public function consulta($logUsr,$logFecha,$logHora,$logIp,$logEvento,$sistemaAcceso){
        $this->total_consultas++;
        $consulta="INSERT INTO registraEventos(logUsr,logFecha,logHora,logIp,logEvento,logSistema) VALUES('".$logUsr."','".$logFecha."','".$logHora."','".$_SERVER['REMOTE_ADDR']."','".$logEvento."','".$sistemaAcceso."')";        
        $resultado=mysql_query($consulta,$this->conectarBdAcceso());        
        if(!$resultado){
            echo 'Error: ' . mysql_error();
            //exit;
        }
        //return $resultado;
    }
}//fin de la clase
?>