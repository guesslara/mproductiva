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

function captura_actividad(){
	ajaxApp("muestraasignaciones","controladorredi.php","action=insertar","post");
}
function abrir(div){	
	$("#"+div).show("fast");
	if(div=="buscarEmpleado"){
		$("#buscar").focus();
	}
}
function cerrarVentana(div){
	$("#"+div).hide();
}
function buscarEmpleado(){
	var buscar=$("#buscar").val();
	ajaxApp("ListarEmpleados","controladorredi.php","action=buscarempleado&buscar="+buscar,"POST");	
}
function insertarempleado(id_empleado,nombre,a_paterno,a_materno){
	var fecha=$("#fecha").val();
	if((fecha=="")||(fecha=="undefined")||(fecha==null)){
		alert("Debe seleccionar una Fecha para continuar");
	}else{
	ajaxApp("resultadosEvaluadores","controladorredi.php","action=insertarempleado&fecha="+fecha+"&id_empleado="+id_empleado+"&nombre="+nombre+"&a_paterno="+a_paterno+"&a_materno="+a_materno,"POST");
	}
}
function ponerdatos(id_empleado,nombre,a_paterno,a_materno,horas_produc,meta_produc){
	$("#no_empleado").attr("value",id_empleado);
	$("#nombres").attr("value",nombre);
	$("#apaterno").attr("value",a_paterno);
	$("#amaterno").attr("value",a_materno);
	$("#jornada").attr("value",horas_produc);
	$("#metapro").attr("value",meta_produc);
}
function muestraStatus(){
	var listaact=$("#listaact").val();
	ajaxApp("status_act","controladorredi.php","action=muestraStatus&listaact="+listaact,"POST");
}
function verificaTecla(contador,evento){
	contador=parseInt(contador);
	if(evento.which==13){		
		hdnContador=$("#hdnContador").val();
		contadorActual=parseInt(contador);
		cajaActual="#txtStatus"+contadorActual;
		divActual="#divVal"+contadorActual;
		if($(cajaActual).val()==""){
			
			$(divActual).show();
			$(divActual).html("Error no deje espacios en blanco");
			$(cajaActual).css("background","yellow");
			$(cajaActual).focus();
		}else{
			$(divActual).hide();
			$(divActual).html("");
			$(cajaActual).css("background","white");
			
			contador=parseInt(contador+1);
			var sigTxt="#txtStatus"+contador;
			$(sigTxt).focus();
			
			//alert("Contador: "+contador+"\nOculto: "+hdnContador);
			
			if(contador==hdnContador){
				//alert("entro");
				$("#btnRegistroDiario").focus();
			}
		}
	}
}
function guardarDatosRegistro(){
	var valorStatus="";
	if(confirm("La informacion es Correcta?")){
		//se procede a recuperar los valores del formulario y los datos para la insercion		
		var idEmpleado=$("#no_empleado").val();
		var idStatus=$("txtIdActividad").val();
		var fechaReg=$("#fecha").val();
		var horaReg=$("#hora").val();
		//se procede a recuperar los status
		var nroRepeticiones=$("#hdnContador").val();
		/*for(var i=0;i<nroRepeticiones;i++){
			var nombreCaja="#txtStatus"+i;
			if(valorStatus==""){
				valorStatus=$(nombreCaja).val();
			}else{
				valorStatus=valorStatus+","+$(nombreCaja).val();
			}
		}*/
		//parametros="action=guardaRegistroDiario&idEmpleado="+idEmpleado+"&idStatus="+idStatus+"fechaReg="+fechaReg+"&horaReg="+horaReg+"&valorStatus="+valorStatus;
		//alert(parametros);
	}
}