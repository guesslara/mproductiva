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
function crear(){
	var noEmpleado=$("#txtBNoEmpleado").val();
	var fecha1=$("#busquedaRegistro1").val();
	var fecha2=$("#busquedaRegistro2").val();
	var mlxj=$("#hdnMinutosLaborablesJornada").val();
	parametros="action=creaTabla&noEmpleado="+noEmpleado+"&fecha1="+fecha1+"&fecha2="+fecha2+"&mlxj="+mlxj;
	ajaxApp("tabMatrizDetalle2","controladorEnsamble.php",parametros,"POST");
}
function cambioAj(arrtxs,arrctxs,arrtodo,grupos){
	var ctxs = arrctxs.split(",");
	var csyd=0, cont=0, hrsext=0;
	var ajcp=100;var sump=0;
	var res=0;var sumc=0;var sumt=0;
	var divg=grupos.split("/");
	var meta=parseInt($("#txtHdnMetaProd").val());
	var bx61=parseFloat($("#txtbx61").val());
	var by61=parseFloat($("#txtby61").val());
	var bz61=parseFloat($("#txtbz61").val());
	var bx62=parseFloat($("#txtbx62").val());
	var by62=parseFloat($("#txtby62").val());
	var bz62=parseFloat($("#txtbz62").val());	
	var jorlab=parseFloat($("#txtHdnJornadaLaboral").val());
	var HdnTiempoExtra=parseFloat($("#txtHdnTiempoExtra").val());
	var linea = arrtodo.split("*");
	var txs = arrtxs.split(",");
	bz61=bz61*(-1);
	bz62=bz62*(-1);
	rendi=100-(((by62+bz62)/bx62)*100);
	$("#rendi").attr("value","%"+(Math.round(rendi)));
	scrapxr=(by61/bx61)*100;
	$("#scrapxr").attr("value","%"+(Math.round(scrapxr)));
	rechazoxr=(bz61/bx61)*100;
	$("#rechazoxr").attr("value","%"+(Math.round(rechazoxr)));
	for(var j=0; j<(linea.length-1);j++){
		var dato=linea[j].split(",");
		fecha=dato[0].split("-");
		mifecha=new Date(fecha[0],(fecha[1]-1),fecha[2]);
		dia=mifecha.getDay();
		for(var i=1;i<txs.length;i++){
			txsmin=Math.round(ajcp*txs[i])/100;
			if(j<1)
				$("#txsm"+i).attr("value",txsmin);
			res=res+(dato[i]*txsmin);
			ttxs=Math.round((ctxs[i]*txsmin/60)*100)/100;
			if(j<1)
				$("#ttxs"+i).attr("value",ttxs);
		}
		t=res/60;
		$("#"+j+"res"+i).attr("value",Math.round(t));
		sumt=sumt+t;
		p=Math.round((t/jorlab)*100);
		$("#"+j+"res"+(i+1)).attr("value","% "+p);
		sump=sump+p;
		c=Math.round((p/meta)*100);
		$("#"+j+"res"+(i+2)).attr("value","% "+c);
		sumc=sumc+c;
		if(t!=0)
			cont++;
		res=0;
		if(dia==6 || dia==0){
			if(t!=0)
				csyd++;
			hrsext=hrsext+t;
		}
	}
	if(hrsext!=0){
		te=(((hrsext/meta)*100)/HdnTiempoExtra)*100;
		$("#te").attr("value","%"+(Math.round(te)));
	}
	if(cont>0){
		$("#tdlt").attr("value",Math.round(sumt*100)/100);
		$("#sumc").attr("value","%"+(Math.round(sumc/cont)));
		$("#sump").attr("value","%"+(Math.round(sump/cont)));
		$("#pxd").attr("value","%"+(Math.round(sump/cont)));
		$("#cont").attr("value",cont);
	}
	var labxMes=parseInt($("#txtHlabxMes").val());
	pxm=(sumt/labxMes)*100;
	$("#pxm").attr("value","%"+Math.round(pxm));
	cumpli=(pxm/meta)*100;
	$("#cumpli").attr("value","%"+Math.round(cumpli));
	return 1;
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
		
		
		var hdnCantidadNumeroStatus=$("#hdnCantidadNumeroStatus").val();
		/*Filas y Columnas*/
		var numeroColumnas=$("#hdnNumeroColumnas").val();
		var numeroFilas=contadoStatusPorMin;
		var sumaFilas=0;
		var sumaColumnas=0;
		/*Fin filas y columnas*/
		
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
		/*
		 *Forma para contabilizar los totales
		*/
		
		for(var i=0;i<numeroColumnas;i++){
			for(var j=0;j<numeroFilas;j++){
				var caja="#cajaMatriz_"+j+"_"+i;//se arma el nombre de la caja				
				var valCaja=parseFloat($(caja).val())//se obtiene su valor
				sumaColumnas=sumaColumnas+valCaja;//se suma al acumulador				
			}
			var cajaRes="#cantidadTotalxStatus_"+i//se arma la caja del resultado
			//alert(cajaRes);
			$(cajaRes).attr("value","");
			$(cajaRes).attr("value",sumaColumnas);
			$(cajaRes).css("background","white");
			sumaColumnas=0;//la variable se iguala a cero
		}
		
		for(var i=0;i<numeroColumnas;i++){
			for(var j=0;j<numeroFilas;j++){
				var caja="#cajaMatriz_"+i+"_"+j;//se arma el nombre de la caja				
				var valCaja=parseFloat($(caja).val())//se obtiene su valor
				sumaFilas=sumaFilas+valCaja;//se suma al acumulador
			}
			//alert(sumaFilas);//se manda el la variable a la primera casilla
			sumaFilas=0;//la variable se iguala a cero
		}
		
		
		for(var i=0;i<numeroColumnas;i++){			
			var variableCantidadXStatus="#cantidadTotalxStatus_"+i;   //se arma el nombre de la caja de texto a extraer
			var valor1=parseFloat($(variableCantidadXStatus).val());  //se recupera el valor
			var variableTiempoXStatus="#tiempoXStatusMin"+i;  //se recupera el tiempo X status (min)
			var valor2=parseFloat($(variableTiempoXStatus).val());  //se recupera el valor
			var tiempoTotalPorStatus=(parseFloat(valor1) * parseFloat(valor2)) / 60;  //se efectua la operacion
			var variableTiempototalXStatus="#cajaTiempoTotalXStatus"+i;  //se arma la caja del resultado
			$(variableTiempototalXStatus).attr("value",tiempoTotalPorStatus);  //se manda el resultado a la caja del resultado
		}
		
		
		
		
		
		
		
		
		/*
		for(var i=0;i<cantidadElementos;i++){
			for(var j=0;j<hdnCantidadNumeroStatus;j++){			
				var variableCantidadTotalXStatus="#cantidadTotalxStatus_"+i+"_"+j;//se recupera la Cantidad Total x Status
				var valor1=$(variableCantidadTotalXStatus).val();//se recupera el valor		
				var variableTiempoXStatusMin="#tiempoXStatusMin"+j;//se recupera el Tiempo X Status (min)
				var valor2=$(variableTiempoXStatusMin).val();//se recupera el valor				
				//Se efectua la operacion
				var tiempoTotalPorStatus=(parseFloat(valor1) * parseFloat(valor2)) / 60;
				//se manda el resultado de la operacion			
				var variableTiempoTotalXStatus="#cajaTiempoTotalXStatus"+j;
				$(variableTiempoTotalXStatus).attr("value",tiempoTotalPorStatus);
				
				
			}
		}
		*/
		
		/*Datos extra en las columnas*/
		/*
		valoresStatusMin=arrayTiempoStatus.split(",");
		
		for(var i=1;i<=contadoStatusPorMin;i++){
			for(var j=0;j<cantidadElementos;j++){
				for(var k=0;k<hdnCantidadNumeroStatus;k++){
					var caja="#caja_proceso_"+i+"_"+j+"_"+k;					
					if($(caja).length){
						//se procede a realizar el calculo
						var valorMatriz=$(caja).val();						
						//se extrae el valor de la caja a multiplicar
						var valorStatus="#tiempoXStatusMin"+k;
						valorAMulti=$(valorStatus).val();
						var resultadoValorMulti=(parseFloat(valorMatriz)*parseFloat(valorAMulti)) / 60;
						//caja a donde se envia el resultado
						cajaResultado="#statusTotalMulti_"+i+"_"+k;
						$(cajaResultado).attr("value",resultadoValorMulti);
					}
				}
			}
		}
		*/
		
		
	}catch(err){
		alert("Error en la Aplicacion");
	}
}
function calcularDatos2(){
	
}