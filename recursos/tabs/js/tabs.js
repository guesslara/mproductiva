// acciones sobre los tabs en la interfaz de usuario
var tab=2;
function ajaxApp(divDestino,url,parametros,metodo){	
	$.ajax({
	async:true,
	type: metodo,
	dataType: "html",
	contentType: "application/x-www-form-urlencoded",
	url:url,
	data:parametros,
	beforeSend:function(){ 
		$("#"+divDestino).show().html("Cargando Informacion..."); 
	},
	success:function(datos){ 
		//$("#cargando").hide();
		$("#"+divDestino).show().html(datos);		
	},
	timeout:90000000,
	error:function() { $("#"+divDestino).show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
	});
}

function redimensionar(){
	altoDocTab=$(document).height();
	document.getElementById("contenidoTab").style.height=(altoDocTab-40)+"px";
}

function addTab(nombreTab,url,parametros,metodo){
	try{
		longCad=nombreTab.length;
		//alert(longCad);
		if(longCad >=10){
			nombreTab1=nombreTab.substr(0,10)+"...";
		}else{
			nombreTab1=nombreTab;
		}
		//identificador del tab
		idTab="tab"+tab;
		//identificador del contenido
		idContenidoTab="contentTab"+tab;
		//se agrega el tab a la capa contenedora
		$("#contenedorTabs").append("<div id='"+idTab+"' class='bordeDiv' title='"+nombreTab+"'><a href='#' class='enlacesTabs' onclick=\"mostrarTab('"+tab+"','"+idContenidoTab+"')\">"+nombreTab1+"</a><div class='btnCerrar' onclick=\"cierraTab('"+tab+"','"+tab+"')\">&nbsp;</div></div>");
		//se añade el contenido
		$("#contenidoTab").append("<div id='"+idContenidoTab+"' class='contenidoTabs' >Contenido Tab"+tab+"</div>");
		//se ocultan todos los contenidos
		$(".contenidoTabs").hide();
		//se muestra el tab actual
		$("#"+idContenidoTab).show();
		//se regresan los tabs a un estilo unico
		$("div").removeClass("bordeDivActivo");
		//se coloca el foco sobre el div activo
		$("#"+idTab).addClass("bordeDivActivo");
		//se aumenta el contador del los tabs
		//si se hace la peticion ajax se llama a la funcion		
		parametros+="&tab="+tab;
		//alert(parametros);
		ajaxApp(idContenidoTab,url,parametros,metodo);
		tab+=1;
	}catch(e){alert("Error en la Aplicacion.");}
}

function mostrarTab(idTab,idContenido){
	try{
		//se ocultan todos los contenidos
		$(".contenidoTabs").hide();
		//se eliminan los elementos que estan como activos
		$("div.bordeDivActivo").removeClass("bordeDivActivo");
		//se coloca como activo el div seleccionado
		$("#tab"+idTab).addClass("bordeDivActivo");
		//se muestra el contenido
		$("#"+idContenido).show();
	}catch(e){alert("Error en la Aplicacion.")}
}

function cierraTab(divTab,contentTab){
	//alert("divTab -> "+divTab+"\n\n"+"contentTab ->"+contentTab);
	try{
		//se prepara una variable para verificar si hay tabs a la derecha
		divTabAumento=parseInt(divTab)+1;
		divNext=("tab"+divTabAumento);
		divCont=("contentTab"+divTabAumento);
		//se remueve el div seleccionado
		$("#tab"+divTab).remove();
		//se remueve el contenido del tab seleccionado
		$("#contentTab"+contentTab).remove();
		//se compara si existe div a la derecha si es asi se mostrar el contenido del div a la derecha	
		if($("#"+divNext).length >=1){				
			//se muestra el contenido
			$("#"+divNext).show();
			$("#"+divCont).show();				
			$("div.bordeDivActivo").removeClass("bordeDivActivo");
			//se coloca el foco sobre el div activo
			$("#"+divNext).addClass("bordeDivActivo");
		}else if($("#"+divNext).length == 0){
			//en caso contrario restamos  en 1 para verificar cual es el div a la izquierda
			divTabAnt=parseInt(divTab)-1;
			//se forma la etiqueta del div
			divTabAnt1=("tab"+divTabAnt);				
			//se muestra el div a la izquierda
			$("#"+divTabAnt1).show();
			//se muestra el contenido
			$("#contentTab"+divTabAnt).show();				
			$("div.bordeDivActivo").removeClass("bordeDivActivo");
			//se coloca el foco sobre el div activo
			$("#"+divTabAnt1).addClass("bordeDivActivo");
		}

	}catch(e){alert('Error en la aplicacion.');}
}

function verificaMovIzq(){
	try{
		posicioncontenedorTabs = $("#contenedorTabs").offset();		
		//alert(posicioncontenedorTabs.left);
		if( (posicioncontenedorTabs.left==-5)||(posicioncontenedorTabs.left==-95) || (posicioncontenedorTabs.left==4)){
			$('#left').attr('disabled','-1');
		}
	}catch(e){alert("Error en la Aplicacion.");}
}	

function verificaMovDer(){
	try{
		posicioncontenedorTabs = $("#contenedorTabs").offset();
		if(posicioncontenedorTabs.left==5){
			$('#left').removeAttr('disabled');		
		}
	}catch(e){alert("Error en la aplicacion.");}
}