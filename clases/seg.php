<?php
    class seguimientoSistema{
        
        private function conectarBdAcceso(){
            require("../../includes/config.inc.php");
            $link=mysql_connect($host,$usuario,$pass);        
            if($link==false){
                echo "Error en la conexion a la base de datos";
            }else{
                mysql_select_db($db_logRegs);
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
    }
?>