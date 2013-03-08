<?php
	/*
	 *Clase para poder leer los permisos del grupo y mostrar los menus para el usuario especificados desde la base de datos
	 *Creada el 11 de Abril de 2011
	 *Autor: Gerardo Lara
	 *Version 1
	 *------------------------------------------------------------------------------------------------------
	 *Modificacion 20 de Septiembre de 2011 - Ajuste en al momento de escribir el menu de usuario
	 *Modifico: Gerardo Lara
	 *Version 1.0.1
	 *
	*/
	include("conexion/conexion.php");	
	class permisosUsuario{		
		function __construct(){
			
		}//fin construct		
		private function verificaPermisos($idUsuario){
			include("../includes/config.inc.php");
			$this->conexionBd();			
			$sqlUsuarioPer="SELECT grupo2 FROM ".$tabla_usuarios." WHERE ID='".$idUsuario."'";
			$resultUsuarioPer=@mysql_query($sqlUsuarioPer,$this->conexion) or die("Error al ejecutar la Consulta");
			if(mysql_num_rows($resultUsuarioPer)==0){
				echo "Verifique la informacion del usuario.";
			}else{
				$rowUsuarioPer=mysql_fetch_array($resultUsuarioPer);				
				$sqlFuncional="SELECT opcFuncional FROM grupos WHERE id='".$rowUsuarioPer['grupo2']."'";
				$resultFuncionalidades=@mysql_query($sqlFuncional,$this->conexion) or die("Error al Verificar los Permisos del Usuario Actual.");
				$rowFuncionalidades=mysql_fetch_array($resultFuncionalidades);				
				$elementos=$rowFuncionalidades['opcFuncional'];
				return $elementos;
			}
		}		
		public function construyeMenuxxxxx($idUsuario){
			$eMenu="";
			$elementos=$this->verificaPermisos($idUsuario);
			$elementos=str_replace("|",",",$elementos);
			$sqlMenuUsuario="SELECT modulo,ruta,rutaimg FROM gruposmods WHERE id in (".$elementos.") AND pertenece_a='Menu' ORDER BY numeroMenu";
			$resultMenuUsuario=mysql_query($sqlMenuUsuario,$this->conexion);
			while($rowMenuUsuario=mysql_fetch_array($resultMenuUsuario)){				
				echo "<div id='".$rowMenuUsuario['modulo']."' class=\"botonesBarraIzq\" title='".$rowMenuUsuario['modulo']."' onclick=\"opcionesMenu('".$rowMenuUsuario['modulo']."')\"><a href='".$rowMenuUsuario['ruta']."?".$SID."' style='color:#000;text-decoration:none;font-weight:bold;' target=\"contenedorVentana\">".$rowMenuUsuario['modulo']."</a></div>";
			}
			$eMenu=explode(",",$eMenu);			
			return $eMenu;
		}
		public function construyeMenu($idUsuario){
			$eMenu="";
			$elementos=$this->verificaPermisos($idUsuario);
			$elementos=str_replace("|",",",$elementos);
			$sqlMenuUsuario="SELECT modulo,ruta,rutaimg,numeroMenu,pertenece_a_menu,rutaMenuSub,moduloSubMenu FROM gruposmods WHERE id in (".$elementos.") AND pertenece_a='Menu' ORDER BY numeroMenu";
			$resultMenuUsuario=mysql_query($sqlMenuUsuario,$this->conexion);			
			while($rowMenuUsuario=mysql_fetch_array($resultMenuUsuario)){				
?>
				<ul>
<?
				if($rowMenuUsuario["ruta"]==""){
?>
					<li class="nivel1"><a href="#" class="nivel1"><?=$rowMenuUsuario['modulo'];?></a>
<?
				}else{
?>
					<li class="nivel1"><a href="<?=$rowMenuUsuario['ruta']."?".$SID;?>" target="contenedorVentana" class="nivel1"><?=$rowMenuUsuario['modulo'];?></a>
<?
				}
				if($rowMenuUsuario['pertenece_a_menu']==$rowMenuUsuario["numeroMenu"]){
?>
					<ul class="nivel2">
						<li><a href="<?=$rowMenuUsuario['rutaMenuSub']."?".$SID;?>" target="contenedorVentana"><?=$rowMenuUsuario['moduloSubMenu'];?></a></li>
					</ul>
<?
				}
?>
					</li>
				</ul>
<?
			}
			$eMenu=explode(",",$eMenu);
			return $eMenu;
		}
		private function conexionBd(){
			try{
				include("../includes/config.inc.php");
				$conn = new Conexion();
				$this->conexion = $conn->getConexion($host,$usuario,$pass,$db);
				
			}catch(Exception $e){
				echo "Ha ocurrido un error en la aplicaci&oacute;n.";
			} 
		}//fin de la conexion		
	}//fin de la clase
?>