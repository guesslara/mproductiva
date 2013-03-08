// JavaScript Document
	/*
	 *funcionesEnsamble: contiene las funciones de javascript como son las validaciones y redireccionamiento a div's
	 *Autor: Rocio Manuel Aguilar
	 *Fecha:29/Nov/2012
	*/
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
function cerrarVentana(div){
	$("#"+div).hide();
}
function mostrarLotes(idProyectoSeleccionado,opt){ 
	ajaxApp("listadoEmpaque","controladorEnsamble.php","action=mostrarLotes&idProyectoSeleccionado="+idProyectoSeleccionado+"&opt="+opt,"POST");
}
function consultaDetalleLote(idLote,idProyectoSeleccionado,item,opt){
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=consultaDetalleLote&idLote="+idLote+"&idProyectoSeleccionado="+idProyectoSeleccionado+"&item="+item+"&opt="+opt,"POST");
}
function consultaLotes(idProyectoSeleccionado){
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=consultaLotes&idProyectoSeleccionado="+idProyectoSeleccionado,"POST");
}
function clean2(){
        $("#detalleEmpaque").html("");
}
function clean1(){
        $("#listadoEmpaque").html("");
}
function guardalo(obj,idProyectoSeleccionado,idPartes,opt){
	//alert(opt);
	//return;
	var valorSeleccionado = obj.options[obj.selectedIndex].value;
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=guardaTec&valorSeleccionado="+valorSeleccionado+"&idProyectoSeleccionado="+idProyectoSeleccionado+"&idPartes="+idPartes+"&opt="+opt,"POST");

}
function AB(usuario,idProyectoSeleccionado){
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=AB&usuario="+usuario+"&idProyectoSeleccionado="+idProyectoSeleccionado,"POST");
}
function changeStatus(objt,ID){
	var valorAsignado = objt.options[objt.selectedIndex].value;
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=Status&valorAsignado="+valorAsignado+"&ID="+ID,"POST");
}
	
    
   
