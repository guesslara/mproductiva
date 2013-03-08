// JavaScript Document
//funcion que recupera el alto y ancho del documento visible del body y regresa un array con los valores 
function getWindowData(){ 
    var widthViewport,heightViewport,xScroll,yScroll,widthTotal,heightTotal; 
    if (typeof window.innerWidth != 'undefined'){ 
        widthViewport= window.innerWidth-17; 
        heightViewport= window.innerHeight-17; 
    }else if(typeof document.documentElement != 'undefined' && typeof document.documentElement.clientWidth !='undefined' && document.documentElement.clientWidth != 0){ 
        widthViewport=document.documentElement.clientWidth; 
        heightViewport=document.documentElement.clientHeight; 
    }else{ 
        widthViewport= document.getElementsByTagName('body')[0].clientWidth; 
        heightViewport=document.getElementsByTagName('body')[0].clientHeight; 
    } 
    xScroll=self.pageXOffset || (document.documentElement.scrollLeft+document.body.scrollLeft); 
    yScroll=self.pageYOffset || (document.documentElement.scrollTop+document.body.scrollTop); 
    widthTotal=Math.max(document.documentElement.scrollWidth,document.body.scrollWidth,widthViewport); 
    heightTotal=Math.max(document.documentElement.scrollHeight,document.body.scrollHeight,heightViewport); 
    return [widthViewport,heightViewport,xScroll,yScroll,widthTotal,heightTotal]; 
}
function inicio(){
	medidas=getWindowData();
	document.getElementById("contenedorNx").style.height=(medidas[1]-45)+"px";
}
function planificador(){
	$.ajax({
		async:true,
		type: "GET",
		dataType: "html",
		contentType: "application/x-www-form-urlencoded",
		url:"mod_forecast/index.php",
		data:"",
		beforeSend:function(){ 
			$("#contenedorNx").show().html('<center><br><img src="../img/gif/LOADING1.GIF"><br>Procesando informacion, espere un momento.</center>'); 
		},
		success:function(datos){ 
			$("#contenedorNx").show().html(datos);
			//$("#seleccionModelo").hide();
			//document.frmCapturaDatos.reset();
			//document.getElementById("modeloCaptura").value=modelo;
		},
		timeout:90000000,
		error:function() { $("#contenedorNx").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
	});
}
function calendarizacion(){
	$.ajax({
		async:true,
		type: "GET",
		dataType: "html",
		contentType: "application/x-www-form-urlencoded",
		url:"mod_forecast/funciones.php",
		data:"action=calendarizacion",
		beforeSend:function(){ 
			$("#contenedorNx").show().html('<center><br><img src="../img/gif/LOADING1.GIF"><br>Procesando informacion, espere un momento.</center>'); 
		},
		success:function(datos){ 
			$("#contenedorNx").show().html(datos);
		},
		timeout:90000000,
		error:function() { $("#contenedorNx").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
	});
}