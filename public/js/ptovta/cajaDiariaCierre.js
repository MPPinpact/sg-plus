var manejoRefresh=limpiarLocales=limpiarCajaDiariaResumen=limpiarCajaDiariaDetalle=limpiarCajaDiariaDetallePagos=errorRut2=errorRut3=limpiarBodegas=NVenta=0;

var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};


var verDetalleVentasFormaPago = function(IdFormaPago){
	console.log("verDetalleVentasFormaPago(IdFormaPago)");
	$("#IdFormaPago").val(IdFormaPago);
	
	parametroAjax.ruta=rutaCDFPDV;
    parametroAjax.data = $("#FormCajaDiaria").serialize();
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaVerDetalleVentasFormaPago(respuesta);
}

var ManejoRespuestaVerDetalleVentasFormaPago = function(respuesta){
    if(respuesta.code==200){
        cargarCajaDiariaDetalleVentas(respuesta.respuesta);
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

var ManejoRespuestaProcesarInfoCaja = function(respuesta){	
	console.log(respuesta[0].IdCaja);
	console.log(respuesta[0].IdLocal);
   
	if(respuesta!=null){
		console.log("respuesta.respuesta.v_cajaActual.IdCaja: " + respuesta[0].IdCaja);
		console.log("respuesta.respuesta.v_cajaActual.IdLocal: " + respuesta[0].IdLocal);
		
		$("#IdLocal").val(respuesta[0].IdLocal);
		$("#IdCaja").val(respuesta[0].IdCaja);
		   
	}else{
		$("#IdLocal").val(0);
		$("#IdCaja").val(0);
			
		$.growl({message:"Cliente no encontrado"},{type: "warning", allow_dismiss: true,});
	}
		

	
	console.log("Fin de ManejoRespuestaProcesarInfoCaja()");
}

var cargarCajaDiariaResumen = function(data){
		
};

var titulosListados = function(){
	console.log("titulosListados()"); 
	$('#CierreCajaDiaria').html("Cierre de Caja Diaria<br />Caja Actual Nro. "+$("#IdCaja").val());
}	

var CerrarCajaDiaria = function(){
	console.log("verDetalleVentasFormaPago(IdFormaPago)");
	
	parametroAjax.ruta=rutaCDCC;
    parametroAjax.data = $("#FormCajaDiaria").serialize();
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaCerrarCajaDiaria(respuesta);
	
}

var ManejoRespuestaCerrarCajaDiaria = function(respuesta){	
	console.log("ManejoRespuestaCerrarCajaDiaria()");
	   
	if(respuesta.code==200){
		window.location.href = "/cajaDiaria";
		//$("#IdLocal").val(respuesta[0].IdLocal);
		//$("#IdCaja").val(respuesta[0].IdCaja);
		   
	}else{
			
		$.growl({message:"Cliente no encontrado"},{type: "warning", allow_dismiss: true,});
	}
		

	
	console.log("Fin de ManejoRespuestaCerrarCajaDiaria()");
}

$(document).ready(function(){

	
	ManejoRespuestaProcesarInfoCaja(d.v_cajaActual);
    cargarCajaDiariaResumen(d.v_resumen_caja);	
	titulosListados();
	
	$(document).on('click','#botonCerrarCajaDiaria', CerrarCajaDiaria);
		
});
