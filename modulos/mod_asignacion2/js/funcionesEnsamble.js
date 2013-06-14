var otrResp=0;
function ajaxApp(divDestino,url,parametros,metodo){	
	$.ajax({
	async:true,
	type: metodo,
	dataType: "html",
	contentType: "application/x-www-form-urlencoded",
	url:url,
	data:parametros,
	beforeSend:function(){ 
		$("#cargadorGeneral").show(); 
	},
	success:function(datos){ 
		$("#cargadorGeneral").hide();
		$("#"+divDestino).show().html(datos);		
	},
	timeout:90000000,
	error:function() { $("#"+divDestino).show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
	});
}
function listarProyectos(){
	ajaxApp("contenido11","controladorEnsamble.php","action=listarProyectos","POST");
}
function listarProcesos(idProyecto){
	ajaxApp("contenido12","controladorEnsamble.php","action=listarProcesos&idProyecto="+idProyecto,"POST");
}
function listarActividades(idProceso,opt){
	ajaxApp("contenido13","controladorEnsamble.php","action=listarActividades&idProceso="+idProceso+"&opt="+opt,"POST");
}
function nuevoProceso(id_proyecto){
	$("#formularioOpciones").show();
	ajaxApp("contenidoFormularioOpciones","controladorEnsamble.php","action=nuevoProceso&id_proyecto="+id_proyecto,"POST");
}
function cancelarCapturaProceso(){
	$("#formularioOpciones").hide();
}
function guardarProceso(){
	id_proyecto=$("#hdnProcesoProyecto").val();
	nombre=$("#txtNombreProc").val();
	descripcion=$("#txtDescProc").val();
	if(nombre=="" || descripcion==""){
		alert("Error debe llenar todos los campos");
	}else{
		ajaxApp("nuevoProceso","controladorEnsamble.php","action=guardarProceso&id_proyecto="+id_proyecto+"&nombre="+nombre+"&descripcion="+descripcion,"POST");
	}
}
function nuevaActividad(id_proceso){
	$("#formularioOpciones").show();
	$("#barraTitulo1VentanaDialogoValidacion2").hide();
	$("#barraTitulo1VentanaDialogoCapturaFinal").show();
	ajaxApp("contenidoFormularioOpciones","controladorEnsamble.php","action=nuevoActividad&id_proceso="+id_proceso,"POST");
}
function cancelarCapturaActividad(){
	$("#formularioOpciones").hide();
}
function guardarActividad(){
	id_proceso=$("#hdnProcesoActividad").val();
	nombre=$("#txtNombreAct").val();
	descripcion=$("#txtDescAct").val();
	producto=$("#cboProductoActividad").val();
	//se recuperan los status relacionados
	var status="";

	for (var i=0;i<document.frmNuevaActividad.elements.length;i++){
		if (document.frmNuevaActividad.elements[i].type=="checkbox"){
			if (document.frmNuevaActividad.elements[i].checked){
				if (status=="")
					status=status+document.frmNuevaActividad.elements[i].value;
				else
					status=status+","+document.frmNuevaActividad.elements[i].value;
			}	
		}
	}
	//alert(status);
	if(nombre=="" || descripcion=="" || producto=="" || status==""){
		alert("Error debe llenar todos los campos");
	}else{
		//ajaxApp("nuevaActividad","controladorEnsamble.php","action=guardarActividad&id_proceso="+id_proceso+"&nombre="+nombre+"&descripcion="+descripcion+"&producto="+producto+"&status="+status,"POST");
		ajaxApp("contenidoFormularioOpciones","controladorEnsamble.php","action=guardarActividad&id_proceso="+id_proceso+"&nombre="+nombre+"&descripcion="+descripcion+"&producto="+producto+"&status="+status,"POST");
	}
}
function mostrarFormMetrica(ultimoId){
	/*codigo provisional ejemplo actividad 9*/
	$("#formularioOpciones").show();
	/*---*/
	ajaxApp("contenidoFormularioOpciones","controladorEnsamble.php","action=mostrarFormMetrica&ultimoId="+ultimoId,"POST");
}
function cerrarVentana(div){
	$("#"+div).hide();
}
function nuevaAsignacion(accion,idAccion,valor,parametroOpcional){
	otrResp=0;
	$("#ventanaDialogo").show();
	ajaxApp("msgVentanaDialogo","controladorEnsamble.php","action=formAsignacion&accion="+accion+"&idAccion="+idAccion+"&valor="+valor+"&parametroOpcional="+parametroOpcional,"POST");
}
function abrir(div){
	$("#"+div).show();
}
function buscarE(){
	tecla=document.getElementById("si").value;
	ajaxApp("ListarEmpleados","controladorEnsamble.php","action=consultarempleado&tecla="+tecla,"POST");
}
function insertarEmpleado(idEmpleado,nombres,apellidoP,apellidoM){
	$("#resP"+otrResp).attr("value",idEmpleado);
	$("#nresP"+otrResp).attr("value",nombres+" "+apellidoP+" "+apellidoM);
	cerrarVentana('buscar');
}
function VALIDAR(tabla,id){
	var id_empleados="";
	var accionForm=$("#hdnAccion").val();
	var valorForm=$("#hdnValor").val();
	var parametroOpcional=$("#hdnParametroOpcional").val();
	//alert("Accion: "+accionForm+"\n\nValor: "+valorForm);
	for(var y=0;y<=otrResp;y++){
		id_empleados+=$("#resP"+y).val();
		if(accionForm=="proyecto"){
			parametros="action=guardarAsignacionForm&tabla="+tabla+"&idEmpleado="+id_empleados+"&accionForm="+accionForm+"&valorForm="+valorForm;
		}else{
			parametros="action=guardarAsignacionForm&tabla="+tabla+"&idEmpleado="+id_empleados+"&accionForm="+accionForm+"&valorForm="+valorForm+"&hdnParametroOpcional="+parametroOpcional;	
		}		
		//alert(parametros);
		ajaxApp("resultadoGuardado","controladorEnsamble.php",parametros,"POST");
	}
}
function eliminaResponsable(no_empleado,origen,idOrigen,idOrigen1){
	if(confirm("Esta seguro de eliminar al Usuario del "+origen+" seleccionado?")){
		ajaxApp("cargadorEmpaque","controladorEnsamble.php","action=eliminarResponsable&no_empleado="+no_empleado+"&origen="+origen+"&idOrigen="+idOrigen+"&idOrigen1="+idOrigen1,"POST");
	}
}
function agregarStatus(){
	var status=prompt("Introduzca el Nombre del Status a Agregar");
	if(status=="" || status==undefined || status==null){
		alert("Valor no valido para el Status");
	}else{
		ajaxApp("cargadorEmpaque","controladorEnsamble.php","action=guardarNuevoStatus&status="+status,"POST");
	}
}
function actualizarStatus(){
	ajaxApp("statusExistentes","controladorEnsamble.php","action=																																																																																																																																																																																																									actualizarStatus","POST");
}
function cambiaOpe(name){
	var valorB=$("#"+name).val();
	if(valorB=="+"){
		$("#"+name).val("-");
	}else{
		$("#"+name).val("+");
	}
}
function guardarDatosExtraActividad(){
	var cant=$("#hdnContadorResp").val();
	var valores="";
	for(var i=0;i<cant;i++){
		
		var cajaTiempo="#txtStatus"+i;
		var idActStatus="#txtIdStatus"+i;
		var operador="#button"+i;
		var tiempoCaja=$(cajaTiempo).val();
		var idStatusAct=$(idActStatus).val();
		var operacion=$(operador).val();
		if(operacion=="+"){
			operacion="mas";
		}else{
			operacion="menos";
		}
		if(valores==""){
			valores=tiempoCaja+","+operacion+","+idStatusAct;
		}else{
			valores=valores+"|"+tiempoCaja+","+operacion+","+idStatusAct;
		}
		
		if(tiempoCaja=="" || tiempoCaja==0 || tiempoCaja==null || tiempoCaja==undefined ||operacion==""){
			alert("No deje espacios en blanco");
			return;
			break;
		}
	}																												
	parametros="action=actualizarActividadStatus&valores="+valores+" ";
	ajaxApp("contenidoFormularioOpciones","controladorEnsamble.php",parametros,"POST");
}
function agregaProducto(){
	$("#formularioOpciones2").show();
	ajaxApp("contenidoFormularioOpciones2","controladorEnsamble.php","action=formNuevoProducto","POST");
}
function guardarProducto(){
	nombreProd=$("#txtNomProducto").val();
	modeloProd=$("#txtModeloProducto").val();
	if(nombreProd=="" || modeloProd==""){
		alert("Error: No deje espacios en blanco");
	}else{
		ajaxApp("cargadorEmpaque","controladorEnsamble.php","action=guardarProducto&nombreProd="+nombreProd+"&modeloProd="+modeloProd,"POST");	
	}	
}
function actualizarListadoProductos(){
	ajaxApp("divProductoS","controladorEnsamble.php","action=actualizaListadoProductos","POST");
}
function modAct(idAct,idProceso){
	$("#formularioOpciones").show();
	$("#barraTitulo1VentanaDialogoValidacion2").show();
	$("#barraTitulo1VentanaDialogoCapturaFinal").hide();
	ajaxApp("contenidoFormularioOpciones","controladorEnsamble.php","action=modAct&idAct="+idAct+"&idProceso="+idProceso,"POST");
}
function confGuarda(opcion){
	if(!confirm("¿Esta seguro que desea modificar"+opcion+"?"))exit();
}
function guardaE(obj,idAct,campo,idProceso){
	valor=$("#"+obj).val();
	ajaxApp("contenidoFormularioOpciones","controladorEnsamble.php","action=guardaE&idAct="+idAct+"&campo="+campo+"&valor="+valor+"&idProceso="+idProceso,"POST");
}
function quitarStatus(idActSta,idAct){
	ajaxApp("contenidoFormularioOpciones","controladorEnsamble.php","action=quitarStatus&idActSta="+idActSta+"&idAct="+idAct,"POST");
}