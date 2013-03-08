<?php
	/*
	 *Clase para la verificacion del usuario en la base de datos t variables de sesion en el sistema
	 *Fecha de creacion: 10 - Junio - 2010
	 *Autor: Gerardo Lara
	 *-------------------------------------------------------------------------------------------------------
	 *Modificacion para incluir las variables con un archivo de configuracion externo
	 *Fecha: 6- Noviembre - 2012
	 *Autor: Gerardo Lara
	*/
	include("../../clases/conexion/conexion.php");
	
	class modeloLogin{
		
		function verificaInfo($usuarioEntrante,$passEntrante){						
			include("../../includes/conectarbase.php");
			include("../../includes/txtApp.php");
			include("../../includes/configSvr.inc.php");
			include("../../clases/regLog.php");
			$passEntrante=strip_tags($passEntrante);
			$sqlVerifica="SELECT * FROM $tabla_usuarios WHERE usuario='".stripslashes(mysql_real_escape_string(strip_tags($usuarioEntrante)))."'";			
			$resVerifica=@mysql_query($sqlVerifica,$this->conexionBd());
			$resultados=@mysql_num_rows($resVerifica);
			if($resultados !=0){
				$rowVerifica=mysql_fetch_array($resVerifica);
				$id_usuario=$rowVerifica['ID'];
				$usuario=$rowVerifica['usuario'];
				$password_t=$rowVerifica['pass'];
				$nombre=$rowVerifica['nombre'];
				$apaterno=$rowVerifica['apaterno'];
				$nivel=$rowVerifica['nivel_acceso'];
				$colocaPass=$rowVerifica['cambiarPass'];
				$sexo=$rowVerifica['sexo'];
				$nomina=$rowVerifica['nomina'];				
				$password = md5($passEntrante);				
				if ($usuarioEntrante != $usuario){
					header("Location:index.php?error=0");
					exit;
				}				
				if ($password != $password_t){
					header("Location:index.php?error=0");
					exit;
				}								
				session_start();				
				session_name($txtApp['session']['name']);				
				session_cache_limiter('nocache,private');
				$_SESSION[$txtApp['session']['nivelUsuario']]=$nivel;				
				$_SESSION[$txtApp['session']['loginUsuario']]=$usuario;				
				$_SESSION[$txtApp['session']['passwordUsuario']]=$password;				
				$_SESSION[$txtApp['session']['idUsuario']]=$id_usuario;
				$_SESSION[$txtApp['session']['nombreUsuario']]=$nombre;
				$_SESSION[$txtApp['session']['apellidoUsuario']]=$apaterno;
				$_SESSION[$txtApp['session']['origenSistemaUsuario']]=$txtApp['session']['origenSistemaUsuarioNombre'];
				$_SESSION[$txtApp['session']['cambiarPassUsuario']]=$colocaPass;
				$_SESSION[$txtApp['session']['sexoUsuario']]=$sexo;
				$_SESSION[$txtApp['session']['nominaUsuario']]=$nomina;								
				$objLog=new regLog();
				$objLog->consulta($usuario,date("Y-m-d"),date("H:i:s"),$_SERVER['REMOTE_ADDR'],"ACCESO",$_SESSION[$txtApp['session']['origenSistemaUsuario']]);
				header('Location:../../modulos/main-4.php');
				exit;
			}else{
				session_start();				
				session_destroy();				
				header("Location: ../index.php?error=0");
				exit;
			}
		}
		
		private function conexionBd(){
			include("../../includes/config.inc.php");
			$conn = new Conexion();
			$conexion = $conn->getConexion($host,$usuario,$pass,$db);
			return $conexion;
		}
	}//fin de la clase
?>