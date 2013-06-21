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
function mostrarFormMetrica(ultimoId,id_proceso){
	/*codigo provisional ejemplo actividad 9*/
	$("#formularioOpciones").show();
	/*---*/
	ajaxApp("contenidoFormularioOpciones","controladorEnsamble.php","action=mostrarFormMetrica&ultimoId="+ultimoId+"&idProceso="+id_proceso,"POST");
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
function agregarStatus(div){
	var status=prompt("Introduzca el Nombre del Status a Agregar");
	if(status=="" || status==undefined || status==null){
		alert("Valor no valido para el Status");
	}else{
		ajaxApp("cargadorEmpaque","controladorEnsamble.php","action=guardarNuevoStatus&status="+status+"&div="+div,"POST");
	}
}
function actualizarStatus(div){
	ajaxApp(div,"controladorEnsamble.php","action=actualizarStatus","POST");
}
function cambiaOpe(name){
	var valorB=$("#"+name).val();
	if(valorB=="+"){
		$("#"+name).val("-");
	}else{
		$("#"+name).val("+");
	}
}
function guardarDatosExtraActividad(idProceso){
	var cant=$("#hdnContadorResp").val();
	var valores="";
	for(var i=0;i<cant;i++){
		
		var cajaTiempo="#txtStatus"+i;
		var idActStatus="#txtIdStatus"+i;
		var operador="#button"+i;
		var idSta="#idSt"+i;
		var tiempoCaja=$(cajaTiempo).val();
		var idStatusAct=$(idActStatus).val();
		var operacion=$(operador).val();
		var idSta1=$(idSta).val();
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
		if(idSta1=="1"){
			if(tiempoCaja==""||tiempoCaja==null || tiempoCaja==undefined || tiempoCaja==0.000 || tiempoCaja==0){
			alert("No deje espacios en blanco 1");
			return;
			break;
		}}else{
		if(tiempoCaja==""|| tiempoCaja==0|| tiempoCaja==null || tiempoCaja==undefined){
			alert("No deje espacios en blanco 2");
			return;
			break;
		}}
	}																												
	parametros="action=actualizarActividadStatus&valores="+valores+"&idProceso="+idProceso;
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
function guardaE(obj,campo){
	idAct=$("#idA").val();
	idProceso=$("#idP").val();
	valor=$("#"+obj).val();
	ajaxApp("contenidoFormularioOpciones","controladorEnsamble.php","action=guardaE&idAct="+idAct+"&campo="+campo+"&valor="+valor+"&idProceso="+idProceso,"POST");
}
function confDelSta(opcion){
	if(opcion=='SCRAP'){
		alert("EL STATUS DE "+opcion+" NO PUEDE SER ELIMINADO");
		return;
	}
	if(!confirm("¿Esta seguro que desea Eliminar el Status = "+opcion+"?"))exit();
}
function quitarStatus(idActSta,idAct,idProceso){
	ajaxApp("contenidoFormularioOpciones","controladorEnsamble.php","action=quitarStatus&idActSta="+idActSta+"&idAct="+idAct+"&idProceso="+idProceso,"POST");
}
function agregarMS(idAct,idProceso){
	$("#transparenciaGeneralSt").show();
	ajaxApp("listadoStatus","controladorEnsamble.php","action=FormStat&idAct="+idAct+"&idProceso="+idProceso,"POST");
}
function guardarNuevoStA(idAct,idProceso){
	var status="";

	for (var i=0;i<document.mS.elements.length;i++){
		if (document.mS.elements[i].type=="checkbox"){
			if (document.mS.elements[i].checked){
				if (status=="")
					status=status+document.mS.elements[i].value;
				else
					status=status+","+document.mS.elements[i].value;
			}	
		}
	}
	//alert(status);
	if(status==""){
		alert("Sebe Seleccionar uno o mas campos");
	}else{
		//ajaxApp("nuevaActividad","controladorEnsamble.php","action=guardarActividad&id_proceso="+id_proceso+"&nombre="+nombre+"&descripcion="+descripcion+"&producto="+producto+"&status="+status,"POST");
		ajaxApp("contenidoFormularioOpciones","controladorEnsamble.php","action=guardarNSA&idAct="+idAct+"&status="+status+"&idProceso="+idProceso,"POST");
	}
}
function editaStatus(idActSta,idAct,idProceso){
	timeStatus="CtimS"+idActSta;
	opSta="BopSta"+idActSta;
	opcionesB="opciones"+idActSta;
	botonEdita="edita"+idActSta;
	$("#"+opcionesB).show();	
	$("#"+timeStatus).removeAttr("readOnly");
	$("#"+opSta).removeAttr("disabled");
	$("#"+botonEdita).show();
	$("#divVacio").hide();
	/*$("#"+timeStatus).removeAttr("style");
	$("#"+opSta).removeAttr("style");*/
	$("#"+ timeStatus).css("border","1px solid #CCC");
	$("#"+ opSta).css("border","1px solid #CCC");
	$("#"+ timeStatus).focus();
}
function canclMo(idActSta,idAct,idProceso){
	timeStatus="CtimS"+idActSta;
	opSta="BopSta"+idActSta;
	opcionesB="opciones"+idActSta;
	$("#"+opcionesB).hide();	
	$("#"+timeStatus).attr("readonly","readOnly");
	$("#"+opSta).attr("disabled","disabled");
	$("#"+ timeStatus).css("border","none");
	$("#"+ opSta).css("border","none");
}
function checkActivar(obj,cajaT,tim){
	if(obj!="ASt"){
		if($("#"+obj).is(":checked")){
			$("#"+cajaT).removeAttr("readonly");
			$("#"+cajaT).removeAttr("value","");
		}else{
			$("#"+cajaT).attr("readonly","readonly");
			$("#"+cajaT).attr("value","0");
		}
	}else{
		var nomDivE="edita"+cajaT;
		var cT="CtimS"+cajaT;
		var bt="BopSta"+cajaT;
		if($("#"+obj).is(":checked")){
			$("#divVacio").hide();
			$("#"+nomDivE).show();
			$("#"+cT).attr("value",tim);
		}else{
			$("#divVacio").show();
			$("#"+nomDivE).hide();
			$("#opciones"+cajaT).hide();
			$("#"+cT).attr("value","0");
			$("#"+cT).attr("readonly","readonly");
			$("#"+cT).css("border","none");
			$("#"+bt).css("border","none");
			$("#"+bt).attr("disabled","disabled");
		}
	}
}
function cACS(opS,idActSta,idAct,id_proceso){
 	if(confirm("¿Esta seguro que desea "+opS+" el Status SCRAP?")){
 		if(opS=="Desactivar"){
 			ajaxApp("contenidoFormularioOpciones","controladorEnsamble.php","action=actualizaDE&idActSta="+idActSta+"&time=0&operador=mas&idAct="+idAct+"&idProceso="+id_proceso,"POST");
 		}else{
 			editaStatus(idActSta,idAct,id_proceso);
 		}
 	}else{
 		$("#formularioOpciones").show();
		$("#barraTitulo1VentanaDialogoValidacion2").show();
		$("#barraTitulo1VentanaDialogoCapturaFinal").hide();
		ajaxApp("contenidoFormularioOpciones","controladorEnsamble.php","action=modAct&idAct="+idAct+"&idProceso="+id_proceso,"POST");
		return;
 	}
}
function guardarMod(opS,idActSta,idAct,id_proceso){
	if(confirm("¿Esta seguro que desea modificar el status: "+opS+"?")){
		var cTim="#CtimS"+idActSta;
		var bOpe="#BopSta"+idActSta;
		var tiempo=$(cTim).val();
		var op=$(bOpe).val();
		if(op=="+"){
			operador="mas";
		}else{
			operador="menos";
		}
		ajaxApp("contenidoFormularioOpciones","controladorEnsamble.php","action=actualizaDE&idActSta="+idActSta+"&time="+tiempo+"&operador="+operador+"&idAct="+idAct+"&idProceso="+id_proceso,"POST");
	}else{
		$("#formularioOpciones").show();
		$("#barraTitulo1VentanaDialogoValidacion2").show();
		$("#barraTitulo1VentanaDialogoCapturaFinal").hide();
		ajaxApp("contenidoFormularioOpciones","controladorEnsamble.php","action=modAct&idAct="+idAct+"&idProceso="+id_proceso,"POST");
		return;
	}

}
function agregaSBA(idAct,idProceso){
	var status=prompt("Introduzca el Nombre del Status a Agregar");
		if(status=="" || status==undefined || status==null){
			alert("Valor no valido para el Status");
		}else{
			$("#transparenciaGeneralSt").show();
			ajaxApp("listadoStatus","controladorEnsamble.php","action=agregaSBA&status="+status+"&idAct="+idAct+"&idProceso="+idProceso,"POST");
		}
}
