var tabAux=2;
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
function abrir(div,opcion){
	$("#"+div).show("fast");
	if(div=="buscarEmpleado"){
		$("#txtOpcionBusqueda").attr("value",opcion);
		$("#buscar").focus();
	}
}
function cerrarVentana(div){
	$("#"+div).hide();
}
function buscarEmpleado(){
	var buscar=$("#buscar").val();
	var opcionB=$("#txtOpcionBusqueda").val();
	ajaxApp("ListarEmpleados","controladorEnsamble.php","action=buscarempleado&buscar="+buscar+"&opcionB="+opcionB,"POST");	
}
function ponerDAtosEmpleado2(no_empleado,nombre,apaterno,amaterno){	
	$("#nombreCompletoABuscar").html(nombre+" "+apaterno+" "+amaterno);
	$("#txtBNoEmpleado").attr("value",no_empleado);
}
function buscarDatosMatriz(){
	var noEmpleado=$("#txtBNoEmpleado").val();
	var fecha1=$("#busquedaRegistro1").val();
	var fecha2=$("#busquedaRegistro2").val();
	if(tabAux==2){
		//se carga en el primer div el predeterminado
		ajaxApp("contentTab1","controladorEnsamble.php","action=buscarDatosMatriz&noEmpleado="+noEmpleado+"&fecha1="+fecha1+"&fecha2="+fecha2,"POST");
		tabAux+=1;
	}else{
		//se coloca el siguiente tab		
		parametros="action=buscarDatosMatriz&noEmpleado="+noEmpleado+"&fecha1="+fecha1+"&fecha2="+fecha2;
		addTab("Resultados","controladorEnsamble.php",parametros,"POST");
	}	
}
function cargarCapturasMatriz(){
	var idActividad=$("#cboActividadMatriz").val();
	alert(idActividad);
}