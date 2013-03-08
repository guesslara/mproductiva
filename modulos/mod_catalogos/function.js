    function ajaxApp(divDestino,url,parametros,metodo){	
            $.ajax({
            async:true,
            type: metodo,
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:url,
            data:parametros,
            beforeSend:function(){ 
		$("#divFooter").show().html("Cargando informacion..."); 
            },
            success:function(datos){ 
		$("#divFooter").hide();
		$("#"+divDestino).show().html(datos);		
            },
            timeout:90000000,
            error:function() { $("#"+divDestino).show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
            });
    }

    function catalogo_listar(c,pre){
        ajaxApp("muestra","controlador.php","ac=catalogo_listar&c="+c+"&pre="+pre,"POST");
    }
    
    function cdm_catalogox_agregar(c,pre){
       	ajaxApp("muestra","controlador.php","ac=catalogos_agregar&c="+c+"&pre="+pre,"POST");
    }
    
   function validar_catalogo_formulario(catalogo){
	//alert(catalogo);
	//exit;
      var campos=new Array();
      var valores=new Array();
      var sql_valores="";
      var ubicacion;  
      var caracteres = "abcdefghijklmnopqrstuvwxyzñ1234567890ü ABCDEFGHIJKLMNOPQRSTUVWXYZÑáéíóúÁÉÍÓÚÜ/-()&.:-,_";
      var cadena_valores="ac=cdm_catalogo_insertar&tabla="+catalogo;
      //var formName="frm_catalogo_nuevo_"+catalogo;

              for (var i=0;i<$("form input").length;i++){
                     campos.push($("form input")[i].id);
                     valores.push($("form input")[i].value);
		     //exit;
	      }
              for (var i2=0;i2<campos.length;i2++){
                        if ($("#"+campos[i2]).attr("class")=="campo_obligatorio"&&(valores[i2]==""||valores[i2]==undefined||valores[i2]==null)){
                               alert("Error: El campo ("+campos[i2]+") es obligatorio.");
                               return;
		     }
                     for (var j=0;j<valores[i2].length;j++){  // recorrido de string para buscar caracteres no validos en la cadena  
                        ubicacion = valores[i2].substring(j, j + 1)  
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
              if (confirm("¿Desea guardar el registro?")){
                     ajaxApp("muestra","controlador.php",cadena_valores+'&campo_valor='+sql_valores,"post");
	      }
    }
function catalogo_update(c,pre){
       	ajaxApp("muestra","controlador.php","ac=catalogo_update&c="+c+"&pre="+pre,"POST");
    }
   function actualiza(c,prefijo,id){
      ajaxApp("muestra","controlador.php","ac=catalogo_actualiza&c="+c+"&prefijo="+prefijo+"&id="+id,"POST");
   }
   function actualizate(catalogo,id){
      var campos=new Array();
      var valores=new Array();
      var sql_valores="";
      var ubicacion;  
      var caracteres = "abcdefghijklmnopqrstuvwxyzñ1234567890ü ABCDEFGHIJKLMNOPQRSTUVWXYZÑáéíóúÁÉÍÓÚÜ/-()&.:-,_";
      var cadena_valores="ac=actualizate&tabla="+catalogo;
             for (var i=0;i<$("form input").length;i++){
                     campos.push($("form input")[i].id);
                     valores.push($("form input")[i].value);
	      }
              for (var i2=0;i2<campos.length;i2++){
                     if ($("#"+campos[i2]).attr("class")=="campo_obligatorio"&&(valores[i2]==""||valores[i2]==undefined||valores[i2]==null)){
                     	    alert("Error: El campo ("+campos[i2]+") es obligatorio.");
                            return;
		     }
                     for (var j=0;j<valores[i2].length;j++){  // recorrido de string para buscar caracteres no validos en la cadena  
                        ubicacion = valores[i2].substring(j, j + 1)  
                        if (caracteres.indexOf(ubicacion) != -1) {  
                           if(ubicacion=="'"){
                              ubicacion=ubicacion.replace("'","''");
                              alert(ubicacion);
                              return;
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
                     ajaxApp("muestra","controlador.php",cadena_valores+'&campo_valor='+sql_valores+'&id='+id,"post");
	      }
   }
   function formProyecto(id,t){
	ajaxApp("muestra","controlador.php","ac=formProyecto&id="+id+"&t="+t,"post");
   }
   function guardadatos(t,id){
	//alert (id);
	//return;
	var cont="";
	var conta="";
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
	  alert("no se ha seleccionado ninguno");
	}
	else{	
		conta=cont;	   
	ajaxApp("muestra","controlador.php","ac=modi&conta="+conta+"&id="+id+"&t="+t,"POST");
	}
	
   }

    
		