// JavaScript Document
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
function verificaTeclaImeiEmpaque(evento){
	if(evento.which==13){		
		//se valida la longitud de la cadena capturada
		var imei=document.getElementById("txtImeiEmpaque").value;
		if(imei.length < 15){
			$("#erroresCaptura").html("");
			$("#erroresCaptura").append("Error: verifique que haya introducido en el Imei la informacion correcta.");
			
		}else{
			document.getElementById("txtSimEmpaque").focus();
		}
		
	}
}

function verProcesos(id_proyecto){
	ajaxApp("Procesos","controladorasig.php","action=listarProcesos&id_proyecto="+id_proyecto,"POST");
}
function verActividades(id_proceso){
	ajaxApp("Actividades","controladorasig.php","action=listarActividades&id_proceso="+id_proceso,"POST");
}
function klin(div){
	$("#"+div).html("");
}
function nuevo(cual,idAccion,valor){
	otrResp=0;
	$("#ventanaDialogo").show();
	ajaxApp("msgVentanaDialogo","controladorasig.php","action=consultaxcheck&cual="+cual+"&idAccion="+idAccion+"&valor="+valor,"POST");
}
function anadeR(){
	var checo=$("#resP"+otrResp).val();
	if(checo!=""){
		div="otroR_"+otrResp;
		otrResp++;
		parametros="action=agregarR&id=resP"+otrResp+"&div=otroR_"+otrResp;
		if(otrResp<3){
			ajaxApp(div,"controladorasig.php",parametros,"POST");
		}else{
			alert("Ya no se Puede colocar mas Responsables");
			otrResp--;
		}
	}else{
		alert("Debe llenar los Campos para Continuar");
		return 0;
	}
	return 1;
}
function borraResp(){
	otrResp--;
	$("#otroR_"+otrResp).html("");	
}
function limpiarse(DIV){
if(DIV=="muestraasignaciones"){
	
	$("#infoEnsamble3").html("");
}
else{
	$("#muestraasignaciones").html("");
	//alert("aui llego");
}
}

function limpiar(){
	
for (i=0;i<document.check.elements.length;i++)
if(document.check.elements[i].type == "checkbox")
document.check.elements[i].checked=0
}

function abrir(div){
	//alert(div);
	//exit;
	$("#"+div).show("fast");
	

}   
function asignacion(){
//alert("aqi tambien");
ajaxApp("infoEnsamble3","controladorasig.php","action=formasignacion","POST");
}
function cerrarVentana(div){
	$("#"+div).hide();
}
function enviotab(prefijo) {
	//alert(prefijo);
	//exit;
var cont="";
var contado="";
	for(j=0;j<document.check.elements.length;j++){
		if(document.check.elements[j].type =="checkbox"){
		    if(document.check.elements[j].checked){
		       if(cont==""){
			 cont=cont+document.check.elements[j].value;
		       }	
		      else{
		        cont=cont+","+document.check.elements[j].value;
			
			} 
		     }	
		}
	}
	if(cont==""){
	  alert("No se selecciono ninguna opcion");
	}
	
	else{	
		contado=cont;
		//alert(contado);
		//exit;
	ajaxApp("muestraasignaciones","controladorasig.php","action=consultaxcheck&contado="+contado+"&prefijo="+prefijo,"POST");
	}
	
}


function VALIDAR(tabla,id){
	//alert("funcion validar")
	//alert("tabla="+tabla+"id="+id);
	var id_empleados="";
	var accionForm=$("#hdnAccion").val();
	var valorForm=$("#hdnValor").val();
	alert("Accion: "+accionForm+"\n\nValor: "+valorForm);
	for(var y=0;y<=otrResp;y++){
		id_empleados+=$("#resP"+y).val();
		if(accionForm=="proyecto"){
			proyectoSeleccionado=$("#nom_PROYECTO").val();//se recupera el proyecto del listado
			parametros="action=guardarAsignacionForm&tabla="+tabla+"&idEmpleado="+id_empleados+"&accionForm="+accionForm+"&valorForm="+valorForm+"&proyectoSeleccionado="+proyectoSeleccionado;
		}else{
			parametros="action=guardarAsignacionForm&tabla="+tabla+"&idEmpleado="+id_empleados+"&accionForm="+accionForm+"&valorForm="+valorForm+"&proyectoSeleccionado=N/A";	
		}		
		alert(parametros);
		ajaxApp("resultadoGuardado","controladorasig.php",parametros,"POST");
	}
}
function modificar(tabla,tc,cam){
	var contadisimo="";
	var contadora="";
	for(w=0;w<document.todo.elements.length;w++){
		if(document.todo.elements[w].type =="checkbox"){
		    if(document.todo.elements[w].checked){
		       if(contadisimo==""){
			 contadisimo=contadisimo+document.todo.elements[w].value;
		       }	
		      else{
		        contadisimo=contadisimo+","+document.todo.elements[w].value;
			
			} 
		     }	
		}
	}
	if(contadisimo==""){
	  alert("No se selecciono ninguna opcion");
	}
	
	else{	
		contadora=contadisimo;
		//alert(contadora);
		//exit;
	ajaxApp("muestraasignaciones","controladorasig.php","action=formmodi&contadora="+contadora+"&tabla="+tabla+"&tc="+tc+"&cam="+cam,"POST");
	}
	
}

function siconsultar(){
var este=document.selects.opciones.selectedIndex
con=document.selects.opciones.options[este].value
//alert(con);
//exit;
if(este==0){
	alert("Debe seleccionar una opcion");
	return
}
else{	fechaasig=document.getElementById("fecha_asig").id;
	//alert(fechaasig);exit;
	campos.push(fechaasig);
	fechaasig2=document.getElementById("fecha_asig").value;
	//alert(fechaasig2);
	valores.push(fechaasig2);
	
	//alert(valores);
	
       //for (var i=0;i<$("#asig  input:text").length;i++){
	
		//campos.push($("#asig  input:text")[i=0].id);
		
	
	//campos.push($(" form input")[i].id);
	
	//alert(campos[i=]);
	//exit;
	/*if(campos[i]=="select"){
	alert("hooola");
	exit;
	}*/
	//alert(campos[i]);
	//exit
	/* for(var e=0;e<$("select").length;e++){
	este=campos.push($("select")[e].id);
	alert(campos[e=2]);
	exit;
	}*/
//valores.push($("#asig  input:text")[i=0].value);
		
		     
		   
ajaxApp("muestraasignaciones","controladorasig.php","action=consultas&con="+con,"POST");
}
}
function simodificar(){
var indicador=document.selects1.opciones.selectedIndex
opcion=document.selects1.opciones.options[indicador].value
//alert(opcion);
//exit;
if(indicador==0){
	alert("Debe seleccionar una opcion");
	return
}
else{
ajaxApp("muestraasignaciones","controladorasig.php","action=modificarasignaciones&opcion="+opcion,"POST");
}
}

 /*function limpiarSelect() {
    var select = document.getElementById("selects").value;
    //alert(select);
    //exit;
    while (select.length > 0) {
        select.remove(1);
    }
}*/
function buscarE(){
tecla=document.getElementById("si").value;

ajaxApp("ListarEmpleados","controladorasig.php","action=consultarempleado&tecla="+tecla,"POST");
}
function actualizar(ta){


}

/************************************************************************/

function insertarEmpleado(idEmpleado,nombres,apellidoP,apellidoM){
	$("#resP"+otrResp).attr("value",idEmpleado);
	$("#nresP"+otrResp).attr("value",nombres+" "+apellidoP+" "+apellidoM);
}
/************************************************************************/
function nuevoProceso(id_proyecto){
	ajaxApp("nuevoProceso","controladorasig.php","action=nuevoProceso&id_proyecto="+id_proyecto,"POST");
}
function guardarProceso(){
	id_proyecto=$("#hdnProcesoProyecto").val();
	nombre=$("#txtNombreProc").val();
	descripcion=$("#txtDescProc").val();
	if(nombre=="" || descripcion==""){
		alert("Error debe llenar todos los campos");
	}else{
		ajaxApp("nuevoProceso","controladorasig.php","action=guardarProceso&id_proyecto="+id_proyecto+"&nombre="+nombre+"&descripcion="+descripcion,"POST");
	}
}
function cancelarCapturaProceso(){
	$("#nuevoProceso").hide();
}
function nuevaActividad(id_proceso){
	ajaxApp("nuevaActividad","controladorasig.php","action=nuevoActividad&id_proceso="+id_proceso,"POST");
}
function cancelarCapturaActividad(){
	$("#nuevaActividad").hide();
}
function guardarActividad(){
	id_proceso=$("#hdnProcesoActividad").val();
	nombre=$("#txtNombreAct").val();
	descripcion=$("#txtDescAct").val();
	producto=$("#cboProductoActividad").val();
	if(nombre=="" || descripcion=="" || producto==""){
		alert("Error debe llenar todos los campos");
	}else{
		ajaxApp("nuevaActividad","controladorasig.php","action=guardarActividad&id_proceso="+id_proceso+"&nombre="+nombre+"&descripcion="+descripcion+"&producto="+producto,"POST");
	}
}