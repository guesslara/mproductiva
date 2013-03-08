<?
	session_start();
	include("../../clases/funcionesComunes.php");
	class modeloEnsamble{

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

		
		
		
		
		
	}//fin de la clase
?>
