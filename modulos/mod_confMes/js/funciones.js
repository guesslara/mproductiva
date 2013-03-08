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


function abrir(div){
	//alert(div);
	//exit;
	$("#"+div).show("fast");
	

}

function cerrarVentana(div){
	$("#"+div).hide();
}



function nuevoregis(){

ajaxApp("muestraasignaciones","controladormes.php","action=formregis","POST");

}

function buscarEmpleado(){

emp=document.getElementById("si").value;

ajaxApp("ListarEmpleados","controladormes.php","action=consultarempleado&emp="+emp,"POST");
}
function insertarEmpleado(idEmpleado,nombres,apellidoP,apellidoM){
	//alert(idEmpleado);
	$("#no_empleado").attr("value",idEmpleado);
	$("#nombres").attr("value",nombres);
	$("#a_paterno").attr("value",apellidoP);
	$("#a_materno").attr("value",apellidoM);
	cerrarVentana('buscarEmpleado');
}

function VALIDAR(tabla){
	//alert(tabla);
	//exit;
      var campos=new Array();
      var valores=new Array();
      var sql_valores="";
      var ubicacion;
	var caracteres = "abcdefghijklmnopqrstuvwxyzñ1234567890ü ABCDEFGHIJKLMNOPQRSTUVWXYZÑáéíóúÁÉÍÓÚÜ/-()&.:-,_";
	
       for (var i=0;i<$("#asig_mes  input:text").length;i++){

	campos.push($("#asig_mes  input:text")[i].id);
	//alert(campos[i=7]);
	//exit;
	valores.push($("#asig_mes input:text")[i].value);
	
	}
	for(var e=0;e<$("#asig_mes select").length;e++){
	campos.push($("#asig_mes select")[e].id);
	//alert(otrosarreglo[e]);
	      
	valores.push($("#asig_mes select")[e].value);
	//alert(valorselect[e]);

	}
	campos.splice(1,1);
	campos.splice(2,1);
	campos.splice(1,1);
	
	valores.splice(1,1);
	valores.splice(2,1);
	valores.splice(1,1);
	
	//alert(valores);
	//exit;
	
	
	
	for (var i2=0;i2<campos.length;i2++){
	//pagina de jquery  http://visualjquery.com/
        if ($("#"+campos[i2]).attr("class")=="campo_obligatorio"&&(valores[i2]==""||valores[i2]==undefined||valores[i2]==null||valores[i2]=="undefined")){
        alert("Error: El campo ("+campos[i2]+") es obligatorio.");
        return;
	}
	//alert(campos[i2]);		     
        for (var j=0;j<valores[i2].length;j++){  // recorrido de string para buscar caracteres no validos en la cadena  
        ubicacion = valores[i2].substring(j, j + 1)
        //alert(valores[j]);		
	//alert(ubicacion);
	//exit;
        if (caracteres.indexOf(ubicacion) != -1) {  
                           
        }

        else {  
        alert("ERROR: No se acepta el caracter '" + ubicacion + "'.")  
        return; 
        }  
        }
        if (sql_valores==""){
         sql_valores=campos[i2]+"|||"+valores[i2];
	 } else {
        sql_valores+="@@@"+campos[i2]+"|||"+valores[i2];
		
	}
                     
	}
	//alert(sql_valores);
	//exit;
        if (confirm("¿Desea guardar el registro?")){
                 ajaxApp("muestraasignaciones","controladormes.php","action=insertarregistro&tabla="+tabla+"&valores="+sql_valores,"POST");
	      }
}

function calcular(){


a=document.getElementById("dias_lab").value;
//alert(a);
b=document.getElementById("jorna_lab").value;
c=document.getElementById("dias_li").value;
d=document.getElementById("tiem_ex").value;

if(isNaN(a)||isNaN(b)||isNaN(c)||isNaN(d)){
	alert("Error: El campo Dias Laborables solo admite numeros");
	return false;
}

else{
aa=parseInt(a);

bb=parseInt(b);

cc=parseInt(c);

dd=parseFloat(d);
//alert(dd);
//exit

diasli=cc*bb;
resu=aa*bb;
otro=resu-diasli;
////otromas=float
otromas= otro+dd;
//alert(otromas);


$("#horas_la").attr("value",otromas);

}
f=document.getElementById("meta_pro").value;

if(f>100){
alert(" En el campo Meta Productiva debe ingresar un porcentaje entre 1 y 100 ");
}
}




function consultaregis(){
	
	ajaxApp("muestraasignaciones","controladormes.php","action=consultar","POST");
}

function modificar(){
ajaxApp("muestraasignaciones","controladormes.php","action=modificar","post");
}
function formmodi(idcap){
//alert(idcap);
//exit;
ajaxApp("muestraasignaciones","controladormes.php","action=formmodi&idcap="+idcap,"post");


}

function ACTUALIZAR(tac,id){
//alert(id);exit;
      var campos=new Array();
      var valores=new Array();
      var sql_valores="";
      var ubicacion;
	var caracteres = "abcdefghijklmnopqrstuvwxyzñ1234567890ü ABCDEFGHIJKLMNOPQRSTUVWXYZÑáéíóúÁÉÍÓÚÜ/-()&.:-,_";
	
       for (var i=0;i<$("#asig_mes_modi  input:text").length;i++){

	campos.push($("#asig_mes_modi  input:text")[i].id);
	//alert(campos[i=7]);
	//exit;
	valores.push($("#asig_mes_modi input:text")[i].value);
	
	}
	for(var e=0;e<$("#asig_mes_modi select").length;e++){
	campos.push($("#asig_mes_modi select")[e].id);
	//alert(otrosarreglo[e]);
	      
	valores.push($("#asig_mes_modi select")[e].value);
	//alert(valorselect[e]);

	}
	campos.splice(1,1);
	campos.splice(2,1);
	campos.splice(1,1);
	
	valores.splice(1,1);
	valores.splice(2,1);
	valores.splice(1,1);
	
	//alert(valores);
	//exit;
	
	
	
	for (var i2=0;i2<campos.length;i2++){
	//pagina de jquery  http://visualjquery.com/
        if ($("#"+campos[i2]).attr("class")=="campo_obligatorio"&&(valores[i2]==""||valores[i2]==undefined||valores[i2]==null||valores[i2]=="undefined")){
        alert("Error: El campo ("+campos[i2]+") es obligatorio.");
        return;
	}
	//alert(campos[i2]);		     
        for (var j=0;j<valores[i2].length;j++){  // recorrido de string para buscar caracteres no validos en la cadena  
        ubicacion = valores[i2].substring(j, j + 1)
        //alert(valores[j]);		
	//alert(ubicacion);
	//exit;
        if (caracteres.indexOf(ubicacion) != -1) {  
                           
        }
        else {  
        alert("ERROR: No se acepta el caracter '" + ubicacion + "'.")  
        return; 
        }  
        }
        if (sql_valores==""){
         sql_valores=campos[i2]+"|||"+valores[i2];
	 } else {
        sql_valores+="@@@"+campos[i2]+"|||"+valores[i2];
		
	}
                     
	}
	//alert(sql_valores);
	//exit;
        if (confirm("¿Desea actualizar el registro?")){
                 ajaxApp("muestraasignaciones","controladormes.php","action=actualizar&tac="+tac+"&valores="+sql_valores+"&id="+id,"POST");
	      }

	
}
function verificaMes(){
	$("#divVerificacion").html("");
	noEmpleado=$("#no_empleado").val();//se recupera el numero del empleado
	mesVerificar=$("#mes").val()//se recupera el mes
	ajaxApp("divVerificacion","controladormes.php","action=verificarEmpleado&noEmpleado="+noEmpleado+"&mes="+mesVerificar,"POST");
}
