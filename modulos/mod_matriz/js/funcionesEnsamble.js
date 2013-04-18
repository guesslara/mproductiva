var tabAux=2;
var cantidadJornada="";
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
function cargarCapturasMatriz(tabMatrizDetalle){
	var nombreCombo="#cboActividadMatriz"+tabMatrizDetalle;
	var noEmpleadoH="#txtHdnNoEmpleado"+tabMatrizDetalle;
	var idActividad=$(nombreCombo).val();	
	var noEmpleado=$(noEmpleadoH).val();
	var fecha1=$("#txtHdnFecha1").val();
	var fecha2=$("#txtHdnFecha2").val();
	//alert("Actividad: "+idActividad+"\n\nEmpleado: "+noEmpleado);
	if(noEmpleado=="" || fecha1=="" || fecha2==""){
		alert("Verifique la informacion proporcionada");
	}else{
		ajaxApp(tabMatrizDetalle,"controladorEnsamble.php","action=detalleMatriz&noEmpleado="+noEmpleado+"&fecha1="+fecha1+"&fecha2="+fecha2+"&idActividad="+idActividad,"POST");
	}
}
function calcularDatosMatriz(){	
	try{
		var arrayTiempoStatus=$("#hdnArrayTiempoStatus").val();
		var cantidadElementos=$("#hdnCantidadElementos").val();//cantidad de los procesos
		var cantidadStatusTiempo=$("#hdnCantidadStatusTiempo").val();//cantidad de los status	
		var contadoStatusPorMin=$("#hdnContadoStatusPorMin").val();//contador para las operaciones de tiempo x status (min)
		
		var ajusteAlTiempoPorStatus=$("#ajusteAlTiempoPorStatus").val();//se recupera la cantidad de ajuste al tiempo
		
		var ajusteCapacidadProduccion=1+parseFloat(ajusteAlTiempoPorStatus);
		$("#ajusteCapacidadProduccion").attr("value",ajusteCapacidadProduccion);
		
		var ajusteCapacidadProduccion=$("#ajusteCapacidadProduccion").val();
		var minutosLaborablesPorJornada=$("#hdnMinutosLaborablesJornada").val();
		
		tiemposPorStatus=arrayTiempoStatus.split(",");
		
		
		for(var i=0;i<tiemposPorStatus.length;i++){
			//calculos para sacar tiempo x status en minutos
			valorTiempoXStatusMin=parseFloat(tiemposPorStatus[i]) / parseFloat(ajusteCapacidadProduccion);
			tiempoPorStatusMin="tiempoXStatusMin"+i;
			$("#"+tiempoPorStatusMin).attr("value",valorTiempoXStatusMin);
			//calculos para sacar la cantidad por jornada
			nombreCajaJornada="cantidadJornada"+i;//nombre de las cajas
			//valorCantidadPorJornada=$("#"+nombreCajaJornada).val();
			valorCantidadPorJornada=parseFloat(minutosLaborablesPorJornada) / valorTiempoXStatusMin;
			$("#"+nombreCajaJornada).attr("value",valorCantidadPorJornada)
		}
	}catch(err){
		alert("Error en la Aplicacion");
	}
}