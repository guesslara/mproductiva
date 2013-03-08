// JavaScript Document
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

function limpiar(DIV){
if(DIV=="mostrar"){
	
	$("#infoEnsamble3").html("");
}
else{
	$("#mostrar").html("");
	//alert("aui llego");
}
}

function abrir(div){
	$("#transparenciaGeneral1").show("fast");
	

}


function catalogos(){
//alert("aqui si llega");

ajaxApp("infoEnsamble3","controladorcat.php","action=formcatalogos","POST");      
		
}

function catalogo_listar(c,pre){
        ajaxApp("mostrar","controladorcat.php","action=catalogo_listar&c="+c+"&pre="+pre,"POST");
    }
function cdm_catalogox_agregar(c,pre){
       	ajaxApp("mostrar","controladorcat.php","action=catalogos_agregar&c="+c+"&pre="+pre,"POST");
}
 function validar_catalogo_formulario(catalogo){
	//alert(catalogo);
	//exit;
      var campos=new Array();
      var valores=new Array();
      var sql_valores="";
      var ubicacion;
      var caracteres = "abcdefghijklmnopqrstuvwxyzñ1234567890ü ABCDEFGHIJKLMNOPQRSTUVWXYZÑáéíóúÁÉÍÓÚÜ/-()&.:-,_";
      var cadena_valores="action=cdm_catalogo_insertar&tabla="+catalogo;
      //var formName="frm_catalogo_nuevo_"+catalogo;
	
	
        for (var i=0;i<$("form input").length;i++){
	campos.push($("form input")[i].id);
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
	valores.push($("form input")[i].value);
		
		     
		   
	//alert(valores[i]);
	//exit;
 }
	// este for recorre los elementos select del formulario
	for(var e=0;e<$(" form select").length;e++){
	campos.push($("form select")[e].id);
	//alert(otrosarreglo[e]);
	      
	valores.push($(" form select")[e].value);
	//alert(valorselect[e]);
}
	       //alert(valores);
	
	       
        for (var i2=0;i2<campos.length;i2++){
			
			
	//pagina de jquery  http://visualjquery.com/
        if ($("#"+campos[i2]).attr("class")=="campo_obligatorio"&&(valores[i2]==""||valores[i2]==undefined||valores[i2]==null ||valores[i2]=="undefined")){
        alert("Error: El campo ("+campos[i2]+") es obligatorio.");
        return;
	}
		     
        for (var j=0;j<valores[i2].length;j++){  // recorrido de string para buscar caracteres no validos en la cadena  
        ubicacion = valores[i2].substring(j, j + 1)
			
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
        if (confirm("¿Desea guardar el registro?")){
        ajaxApp("mostrar","controladorcat.php",cadena_valores+'&campo_valor='+sql_valores,"POST");
	}
    }
function catalogo_update(c,pre){
       	ajaxApp("mostrar","controladorcat.php","action=catalogo_update&c="+c+"&pre="+pre,"POST");
    }
   function actualiza(c,prefijo,id){
      ajaxApp("mostrar","controladorcat.php","action=catalogo_actualiza&c="+c+"&prefijo="+prefijo+"&id="+id,"POST");
   }
   function actualizate(catalogo,id){
      var campos=new Array();
      var valores=new Array();
      var sql_valores="";
      var ubicacion;  
      var caracteres = "abcdefghijklmnopqrstuvwxyzñ1234567890ü ABCDEFGHIJKLMNOPQRSTUVWXYZÑáéíóúÁÉÍÓÚÜ/-()&.:-,_";
      var cadena_valores="action=actualizate&tabla="+catalogo;
             for (var i=0;i<$("form input").length;i++){
                     campos.push($("form input")[i].id);
                     valores.push($("form input")[i].value);
	      }
	      for(var e=0;e<$("form select").length;e++){
			campos.push($("form select")[e].id);
			valores.push($("form select")[e].value);
			
		}
		//alert(valores);
		//exit();
		
              for (var i2=0;i2<campos.length;i2++){
                     if ($("#"+campos[i2]).attr("class")=="campo_obligatorio"&&(valores[i2]==""||valores[i2]=="undefined"||valores[i2]==null)){
                     	    alert("Error: El campo ("+campos[i2]+") es obligatorio.");
                            return;
		     }
                     for (var j=0;j<valores[i2].length;j++){  // recorrido de string para buscar caracteres no validos en la cadena  
                        ubicacion = valores[i2].substring(j, j + 1)  
                        if (caracteres.indexOf(ubicacion) != -1) {  
                           if(ubicacion=="'"){
                              ubicacion=ubicacion.replace("'","''");
                              //alert(ubicacion);
                              //return;
                           }
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
              if (confirm("¿Desea actualiza el registro?")){
                     ajaxApp("mostrar","controladorcat.php",cadena_valores+'&campo_valor='+sql_valores+'&id='+id,"post");
	      }
   }    
 


function cerrarVentana(div){
	$("#"+div).hide();
}
