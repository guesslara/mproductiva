// JavaScript Document
function ajaxApp(divDestino,url,parametros,metodo){
	$.ajax({
	async:true,
	type: metodo,
	dataType: "html",
	contentType: "application/x-www-form-urlencoded",
	url:url,
	data:parametros,
	beforeSend:function(){ 
		$("#cargando").show();		
	},
	success:function(datos){
		$("#cargando").hide();
		$("#"+divDestino).show().html(datos); 
	},
	timeout:90000000,
	error:function() { $("#"+divDestino).show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
	});
}
function nuevoUsuario(){
	div="detalleUsuarios";
	url="mod_usuarios/controladorUsuarios.php";
	parametros="action=nuevoUsuarioForm";
	metodo="GET";
	ajaxApp(div,url,parametros,metodo);	
}
function validacion(){
	//se recuperan los datos del formulario
	var validar=true;
	
	var nombre=document.getElementById("txtNombre").value;
	var apellido=document.getElementById("txtPaterno").value;
	var usuario=document.getElementById("txtUsuario").value;
	var pass1=document.getElementById("txtPass").value;
	var pass2=document.getElementById("txtPass1").value;
	var nivel=document.getElementById("nivelAcceso").options[document.getElementById("nivelAcceso").selectedIndex].value;
	var sexo=document.getElementById("lstSexo").options[document.getElementById("lstSexo").selectedIndex].value;
	/*nuevos datos*/
	var tipo=document.getElementById("idTipoUsuario").value;
	var idNoNominaUsuario=document.getElementById("idNoNominaUsuario").value;
	var grupoUsuario=document.getElementById("cboGrupoUsuario").options[document.getElementById("cboGrupoUsuario").selectedIndex].value;
	
	/**/
	if(nombre==""){ alert('Especifique el Nombre del Usuario'); validar=false;	}
	if(apellido==""){ alert('Especifique el Apellido del Usuario'); validar=false;	}
	if(usuario==""){ alert('Especifique el nombre de usuario para el Sistema');	validar=false;}
	if(nivel=="--"){ alert('Especifique un nivel de Usuario'); validar=false; }
	if(sexo=="--"){ alert('Especifique el sexo del usuario (Masculino / Femenino)'); validar=false; }
	
	if(tipo==""){ alert('Especifique el Tipo de Empleado'); validar=false;}
	if(idNoNominaUsuario==""){ alert('Especifique el No de Nomina del EMpleado'); validar=false;}
	if(grupoUsuario==""){ alert('Seleccione el Grupo al que pertenece el Usuario'); validar=false;}
	
	if((pass1.lenth)!=(pass2.lenth)){
		alert('La longitud de los passwords introducidos no Coinciden');
		validar=false;
	}else if(pass1 != pass2){
		alert('Los passwords no coinciden, verifiquelos');
		validar=false;
	}else if(pass1==""){
		alert('Introduzaca el Password del Usuario');
		validar=false;
	}else if(pass2==""){
		alert('Introduzca de nuevo el Password');
		validar=false;
	}

	//return validar;
	
	if(validar==true){
		//alert(usuario);
		div="detalleUsuarios";
		url="mod_usuarios/controladorUsuarios.php";
		parametros="action=guardarUsuario&nombre="+nombre+"&apellido="+apellido+"&usuario="+usuario+"&pass1="+pass1+"&pass2="+pass2+"&nivel="+nivel+"&sexo="+sexo+"&tipo="+tipo+"&nomina="+idNoNominaUsuario+"&grupoUsuario="+grupoUsuario;
		metodo="POST";
		ajaxApp(div,url,parametros,metodo);
		consultarUsuarios("act");
	}	
}

/***********************************************/
var anterior;
function consultarUsuarios(param){
	//consultaUsuarios
	if(param=="act"){
		param="1";
	}else if(param=="ina"){
		param="0";
	}
	
	div="detalleUsuarios";
	url="mod_usuarios/controladorUsuarios.php";
	parametros="action=consultaUsuarios&param="+param;
	metodo="GET";	
	ajaxApp(div,url,parametros,metodo);
}
function modificaUsuario(id_usr){
	div="modificaUsuario";
	url="mod_usuarios/funcionesUsuarios.php";
	parametros="action=modificaUsuario&id_usr="+id_usr;
	metodo="GET";
	ajaxApp(div,url,parametros,metodo);
}
function nip(id_usr){
	div="nip";
	url="mod_usuarios/funcionesUsuarios.php";
	parametros="action=nipUsuario&id_usr="+id_usr;
	metodo="GET";
	ajaxApp(div,url,parametros,metodo);
}
function resetPass(id_usr,username){
	if(confirm('Esta seguro de hacer un reset en el password del usuario: '+username)){
		//se ejecuta el procedimiento
		div="detalleUsuarios";
		url="mod_usuarios/controladorUsuarios.php";
		parametros="action=resetPass&id_usr="+id_usr;
		metodo="GET";
		ajaxApp(div,url,parametros,metodo);
	}else{
		alert('Accion Cancelada');
	}
}
function eliminaUsuario(id_usr,user){
	if(confirm('Esta seguro de Borrar al usuario: '+user)){
		//se ejecuta el procedimiento
		div="eliminaUsuario";
		url="mod_usuarios/controladorUsuarios.php";
		parametros="action=borrarUsuario&id_usr="+id_usr;
		metodo="GET";
		ajaxApp(div,url,parametros,metodo);
		
		cerrarDivUsuarios();
		consultarUsuarios();
	}else{
		alert('Accion Cancelada');
	}
}
function cerrarDivUsuarios(){
	$("#consultaUsuarios").hide(); 
}
function cerrarDivModifica(){
	$("#modificaUsuario").hide(); 
}
function cerrarDivNip(){
	$("#nip").hide(); 
}
function cierraMsgReset(){	
	$("#msgResetPass").hide(); 
}
function cierraMsgDel(){
	$("#msgResetPass").hide(); 	
}
function seleeccionCaptura(){
	var seleccionCaptura=document.getElementById("seleccionCapturaUsuario").options[document.getElementById("seleccionCapturaUsuario").selectedIndex].value;
	alert(seleccionCaptura);
	if(seleccionCaptura=="usrSistema"){
		document.getElementById("datosUsuarioSistemaP").style.display="block";
		document.getElementById("datosAdicionales").style.display="block";
		document.getElementById("datosUsuarioPersonales").style.display="block";		
		document.getElementById("datosAdicionales1").style.display="none";
	}else if(seleccionCaptura=="usrPersona"){
		document.getElementById("datosUsuarioPersonales").style.display="block";		
		document.getElementById("datosAdicionales").style.display="block";
		document.getElementById("datosAdicionales1").style.display="block";
		document.getElementById("datosUsuarioSistemaP").style.display="none";
	}
}
function addGrupo(){
	div="detalleUsuarios";
	url="mod_usuarios/controladorUsuarios.php";
	parametros="action=addGrupo";
	metodo="GET";
	ajaxApp(div,url,parametros,metodo);
}
function actualizaDatosUsuario(){
//se recuperan los datos del formulario
	cerrarDivModifica();
	var validar=true;
	
	var nombre=document.getElementById("txtNombreUsuario").value;
	var apellido=document.getElementById("txtApellidoUsuario").value;
	var usuario=document.getElementById("txtUserName").value;
	var nivel=document.getElementById("lstNivelAcceso").options[document.getElementById("lstNivelAcceso").selectedIndex].value;
	var cambioPass=document.getElementById("lstCambioPass").options[document.getElementById("lstCambioPass").selectedIndex].value;
	var sexo=document.getElementById("lstSexo").options[document.getElementById("lstSexo").selectedIndex].value;
	/*nuevos datos*/
	var directorioUsuario=document.getElementById("txtDirectorioUsuario").value;
	var tipo=document.getElementById("txtTipoUsuario").value;
	var idNoNominaUsuario=document.getElementById("txtNominaUsuario").value;
	var grupoUsuario=document.getElementById("cboGrupoUsuario").options[document.getElementById("cboGrupoUsuario").selectedIndex].value;
	var activoUsuario=document.getElementById("cboActivoUsuario").options[document.getElementById("cboActivoUsuario").selectedIndex].value;
	
	var idUsuarioAct=document.getElementById("idUsuarioAct").value;
	
	if(validar==true){
		div="detalleUsuarios";
		url="mod_usuarios/controladorUsuarios.php";
		parametros="action=actualizaDatosUsuario&nombre="+nombre+"&apellido="+apellido+"&usuario="+usuario+"&nivel="+nivel+"&cambioPass="+cambioPass+"&sexo="+sexo+"&directorioUsuario="+directorioUsuario+"&tipo="+tipo+"&idNoNominaUsuario="+idNoNominaUsuario+"&grupoUsuario="+grupoUsuario+"&activoUsuario="+activoUsuario+"&idUsuarioAct="+idUsuarioAct;
		metodo="POST";
		ajaxApp(div,url,parametros,metodo);
	}
	consultarUsuarios('ina');
}
function guardaGrupo(){
	try{
		var nombreGrupo=document.getElementById("nombreGrupo").value;
		var claves2="";
		for (var i=0;i<document.crearGrupo.elements.length;i++){
			if (document.crearGrupo.elements[i].type=="checkbox"){
				if (document.crearGrupo.elements[i].checked){
					if (claves2=="")
						claves2=claves2+document.crearGrupo.elements[i].value;
					else
						claves2=claves2+","+document.crearGrupo.elements[i].value;
				}
			}
		}
		if(claves2==""){
			alert("Verifique la informacion para poder crear el grupo");
		}else{
			//alert(claves2);
			div="detalleUsuarios";
			url="mod_usuarios/controladorUsuarios.php";
			parametros="action=guardaGrupo&nombreGrupo="+nombreGrupo+"&permisos="+claves2;
			metodo="POST";
			//ajax
			ajaxApp(div,url,parametros,metodo);
		}		

		
	}catch(e){
		alert("Verifique la informacion para poder crear el grupo");
	}
}
function consultaGrupos(){
	div="detalleUsuarios";
	url="mod_usuarios/controladorUsuarios.php";
	parametro="action=consultarGrupos";
	metodo="GET";
	ajaxApp(div,url,parametro,metodo);
}
function modificaGrupo(idGrupo){
	div="detalleUsuarios";
	url="mod_usuarios/controladorUsuarios.php";
	parametro="action=modificaGrupo&idGrupo="+idGrupo;
	metodo="GET";
	ajaxApp(div,url,parametro,metodo);
}
function actualizaGrupo(idGrupo){
	try{
		var claves3="";
		for (var i=0;i<document.frmModificaGrupo.elements.length;i++){
			if (document.frmModificaGrupo.elements[i].type=="checkbox"){
				if (document.frmModificaGrupo.elements[i].checked){
					if (claves3=="")
						claves3=claves3+document.frmModificaGrupo.elements[i].value;
					else
						claves3=claves3+","+document.frmModificaGrupo.elements[i].value;
				}
			}
		}
		if(claves3==""){
			alert("Verifique la informacion para poder crear el grupo");
		}else{
			//alert(claves3);
			div="detalleUsuarios";
			url="mod_usuarios/controladorUsuarios.php";
			parametros="action=actualizaGrupo&permisos="+claves3+"&idGrupo="+idGrupo;
			metodo="POST";
			//ajax
			ajaxApp(div,url,parametros,metodo);
		}
	}catch(e){
		alert("Excepcion: Verifique la informacion para poder crear el grupo");
	}
}