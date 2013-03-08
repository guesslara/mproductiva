// JavaScript Document
	/*
	 *funcionesEnsamble: contiene las validaciones y direcciona a los div correspondientes las funciones y sus variables
	 *Autor: Rocio Manuel Aguilar
	 *Fecha:20/Nov/2012
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
function mostrarLotes(idProyectoSeleccionado){
	ajaxApp("listadoEmpaque","controladorEnsamble.php","action=mostrarLotes&idProyectoSeleccionado="+idProyectoSeleccionado,"POST");
}
function consultaDetalleLote(idLote,idProyectoSeleccionado,item){
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=consultaDetalleLote&idLote="+idLote+"&idProyectoSeleccionado="+idProyectoSeleccionado+"&item="+item,"POST");
}
function consulta(){
	var idLote=document.getElementById("id_lote").value;
	var idProyectoSeleccionado=document.getElementById("id_proyecto").value;
	var item=document.getElementById("noItem").value;
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=consultaDetalleLote&idLote="+idLote+"&idProyectoSeleccionado="+idProyectoSeleccionado+"&item="+item,"POST");
}
function formAgrega(){
	var idLote=document.getElementById("id_lote").value;
	var idProyectoSeleccionado=document.getElementById("id_proyecto").value;
	var item=document.getElementById("noItem").value;
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=formAgrega&idLote="+idLote+"&idProyectoSeleccionado="+idProyectoSeleccionado+"&item="+item,"POST");
	}
function agregar(){
	var noParte=$("#noParte").val();
	var modelo=$("#modelo").val();
	var codeType=$("#codeType").val();
	var flowTag=$("#flowTag").val();
	var numSerie=$("#numSerie").val();
	var fechReg=$("#date").val();
	var horaReg=$("#hour").val();
	var desc=$("#desc").val();
	var idLote=document.getElementById("id_lote").value;
	var idProyectoSeleccionado=document.getElementById("id_proyecto").value;
	var item=document.getElementById("noItem").value;	 if(noParte==""||modelo==""||numSerie==""){
		alert("Verifique que los campos no se encuentren vacios");
		return;
	 }
	 else{
		ajaxApp("detalleEmpaque","controladorEnsamble.php","action=addDetalleLote&noParte="+noParte+"&modelo="+modelo+"&codeType="+codeType+"&flowTag="+flowTag+"&numSerie="+numSerie+"&fechReg="+fechReg+"&horaReg="+horaReg+"&desc="+desc+"&idLote="+idLote+"&idProyectoSeleccionado="+idProyectoSeleccionado+"&item="+item,"POST");
	 }
    }
    function consultaX(){
	var idLote=document.getElementById("id_lote").value;
	var idProyectoSeleccionado=document.getElementById("id_proyecto").value;
	var item=document.getElementById("noItem").value;
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=consultaDetalleLote&idLote="+idLote+"&idProyectoSeleccionado="+idProyectoSeleccionado+"&item="+item,"POST");
    }
    function consultaModifica(){
	var idLote=document.getElementById("id_lote").value;
	var idProyectoSeleccionado=document.getElementById("id_proyecto").value;
	var item=document.getElementById("noItem").value;
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=consultaModifica&idLote="+idLote+"&idProyectoSeleccionado="+idProyectoSeleccionado+"&item="+item,"POST");
    }
    
   function Modificar(idParte){
	var idLote=document.getElementById("id_lote").value;
	var idProyectoSeleccionado=document.getElementById("id_proyecto").value;
	var item=document.getElementById("noItem").value;
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=formModifica&idLote="+idLote+"&idProyectoSeleccionado="+idProyectoSeleccionado+"&item="+item+"&idParte="+idParte,"POST");
   }
   function modifica(){
	var noParte=$("#noParte").val();
	var modelo=$("#modelo").val();
	var codeType=$("#codeType").val();
	var flowTag=$("#flowTag").val();
	var numSerie=$("#numSerie").val();
	var fechReg=$("#date").val();
	var horaReg=$("#hour").val();
	var desc=$("#desc").val();
	var idLote=document.getElementById("id_lote").value;
	var idProyectoSeleccionado=document.getElementById("id_proyecto").value;
	var idParte=document.getElementById("idParte").value;
	var item=document.getElementById("noItem").value;
	 if(noParte==""||modelo==""||numSerie==""){
		alert("Verifique que los campos no se encuentren vacios");
		return;
	 }
	 else{
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=modifica&noParte="+noParte+"&modelo="+modelo+"&codeType="+codeType+"&flowTag="+flowTag+"&numSerie="+numSerie+"&fechReg="+fechReg+"&horaReg="+horaReg+"&desc="+desc+"&idLote="+idLote+"&idProyectoSeleccionado="+idProyectoSeleccionado+"&item="+item+"&idParte="+idParte,"POST");
	}
	
   }
   function consultaLotes(idProyectoSeleccionado){
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=consultaLotes&idProyectoSeleccionado="+idProyectoSeleccionado,"POST");
   }
   function formLotes(idUsuario,idProyectoSeleccionado){
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=formLotes&idUsuario="+idUsuario+"&idProyectoSeleccionado="+idProyectoSeleccionado,"POST");
   }
   function agregarLotes(){
	var noPO=$("#noPO").val();
	var noItem=$("#noItem").val();
	var fechaReg=$("#fechaReg").val();
	var horaReg=$("#horaReg").val();
	var diasTAT=$("#diasTAT").val();
	var observaciones=$("#observaciones").val();
	var idUsuario=document.getElementById("idUsuario").value;
	var id_proyecto=document.getElementById("id_proyecto").value;
	 if(noPO==""||noItem==""){
		alert("Verifique que los campos no se encuentren vacios");
		return;
	 }
	 else{
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=addLote&noPO="+noPO+"&noItem="+noItem+"&fechaReg="+fechaReg+"&horaReg="+horaReg+"&diasTAT="+diasTAT+"&observaciones="+observaciones+"&idUsuario="+idUsuario+"&id_proyecto="+id_proyecto,"POST");
	}
   }
    function clean2(){
          $("#detalleEmpaque").html("");
    }
     function consultaModificaLotes(id_usuario,idProyectoSeleccionado){
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=consultaModificaLotes&id_usuario="+id_usuario+"&idProyectoSeleccionado="+idProyectoSeleccionado,"POST");
     }
   function formModificaLote(idLote,idProyectoSeleccionado,id_usuario){
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=formModificaLote&idProyectoSeleccionado="+idProyectoSeleccionado+"&idLote="+idLote+"&id_usuario="+id_usuario,"POST");
    }
    function modificaLote(idLote,idProyectoSeleccionado,id_usuario){
	var noPO=$("#nuPo").val();
	var noItem=$("#noItem").val();
	var fechaReg=$("#fechaReg").val();
	var horaReg=$("#horaReg").val();
	var diasTAT=$("#diasTAT").val();
	var observaciones=$("#observaciones").val();
	 if(noPO==""||noItem==""||fechaReg==""){
		alert("Verifique que los campos no se encuentren vacios");
		return;
	 }
	 else{
		ajaxApp("detalleEmpaque","controladorEnsamble.php","action=modificaLote&noItem="+noItem+"&noPO="+noPO+"&fechaReg="+fechaReg+"&horaReg="+horaReg+"&diasTAT="+diasTAT+"&observaciones="+observaciones+"&idLote="+idLote+"&idProyectoSeleccionado="+idProyectoSeleccionado+"&id_usuario="+id_usuario,"POST");
	}
	
    }
   
    
   
