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
    if(limpiarCajaDiariaResumen==1){
		destruirTabla('#tablaCajaDiariaResumen');
		$('#tablaCajaDiariaResumen thead').empty();
	}
	
	$("#tablaCajaDiariaResumen").dataTable({
		 "footerCallback": function ( row, data, start, end, display ) {
		var api = this.api(), data;
		// Remove the formatting to get integer data for summation
		var intVal = function (i){
			return typeof i === 'string' ?
				i.replace(/[\$,]/g, '')*1 :
				typeof i === 'number' ?
					i : 0;
		};
		// Total over all pages
		totalRecaudado = api
			.column(2)
			.data()
			.reduce( function (a, b) {
				return intVal(a) + intVal(b);
			}, 0 );
			
			$( api.column( 2 ).footer() ).html('$'+totalRecaudado +' ( Total Recaudado )');
		},
		responsive:false,
		bFilter: false, 
		searching: false,
		paging: false, 
		"aLengthMenu": DataTableLengthMenu,
		"language": LenguajeTabla,
		"data": data,
		
		"columns":[
			{"title": "Nro. Caja","data": "IdCaja",  className: "text-center", render: $.fn.dataTable.render.number( '.', ',', 0 ), className: "text-center"},
			{"title": "FormaPago", "data": "FormaPago", className: "text-left"},
			{"title": "Recaudado","data": "TotalFormaPago", render: $.fn.dataTable.render.number( '.', ',', 0 ), className: "text-right"},
			{"title": "", "data": "IdFormaPago",
				"render": function(data, type, row, meta){
					var result = `
					<center>
					<a href="#" onclick="verDetalleVentasFormaPago(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Movimientos" data-original-title="Delete">
						<i class="icofont icofont-search"></i>
					</a>
					</center>`;
					return result;
				}
			},
		],			
	});
	limpiarCajas=1;
	console.log("Total Recaudado: " + totalRecaudado);
		
};

var cargarCajaDiariaDetalleVentas = function(data){
    if(limpiarCajaDiariaDetalle==1){
		destruirTabla('#tablaCajaDiariaDetalle');
		$('#tablaCajaDiariaDetalle thead').empty();
	}
	
	$("#tablaCajaDiariaDetalle").dataTable({
		 "footerCallback": function ( row, data, start, end, display ) {
		var api = this.api(), data;
		// Remove the formatting to get integer data for summation
		var intVal = function (i){
			return typeof i === 'string' ?
				i.replace(/[\$,]/g, '')*1 :
				typeof i === 'number' ?
					i : 0;
		};
		// Total over all pages
		totalFormaPago = api
			.column(2)
			.data()
			.reduce( function (a, b) {
				return intVal(a) + intVal(b);
			}, 0 );
			
			$( api.column( 2 ).footer() ).html('$'+totalFormaPago+' ( Total Forma Pago )');
		},
		responsive:false,
		bFilter: false, 
		searching: false,
		paging: false, 
		"aLengthMenu": DataTableLengthMenu,
		"language": LenguajeTabla,
		"data": data,
		
		"columns":[
			{"title": "Nro. Venta","data": "IdVenta",  className: "text-center", render: $.fn.dataTable.render.number( '.', ',', 0 ), className: "text-center"},
			{"title": "Fecha", 
							"data": "FechaVenta", className: "text-center", 
							"render": function(data, type, row, meta){
								if(type === 'display'){
									data = moment(data, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY");
								}
								return data;
							}
			},
			{"title": "Cliente", "data": "NombreCliente", className: "text-left"},
			{"title": "Monto","data": "TotalFormaPago", render: $.fn.dataTable.render.number( '.', ',', 0 ), className: "text-right"},
			{"title": "", "data": "IdCaja",
				"render": function(data, type, row, meta){
					var result = `
					<center>
					<a href="#" onclick="verVenta(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Movimientos" data-original-title="Delete">
						<i class="icofont icofont-search"></i>
					</a>
					</center>`;
					return result;
				}
			},
		],			
	});
	limpiarCajaDiariaDetalle=1;
	console.log("Total Forma Pago: " + totalFormaPago);
};

var cargarResumenRecaudacion = function(data){
	
	console.log("cargarResumenRecaudacion()");
	
    if(limpiarCajaDiariaResumen==1){
		destruirTabla('#tablaResumenRecaudacion');
		$('#tablaResumenRecaudacion thead').empty();
	}
	
	$("#tablaResumenRecaudacion").dataTable({
		 "footerCallback": function ( row, data, start, end, display ) {
		var api = this.api(), data;
		// Remove the formatting to get integer data for summation
		var intVal = function (i){
			return typeof i === 'string' ?
				i.replace(/[\$,]/g, '')*1 :
				typeof i === 'number' ?
					i : 0;
		};
		// Total over all pages
		totalRecaudado = api
			.column(2)
			.data()
			.reduce( function (a, b) {
				return intVal(a) + intVal(b);
			}, 0 );
			
			$( api.column( 2 ).footer() ).html('$'+totalRecaudado +' ( Total Recaudado )');
		},
		responsive:false,
		bFilter: false, 
		searching: false,
		paging: false, 
		"aLengthMenu": DataTableLengthMenu,
		"language": LenguajeTabla,
		"data": data,
		
		"columns":
		[
			{"title": "Nro. Caja","data": "IdCaja",  className: "text-center", render: $.fn.dataTable.render.number( '.', ',', 0 ), className: "text-center", visible:0}, 
			{"title": "Item","data": "Item",  className: "text-center", render: $.fn.dataTable.render.number( '.', ',', 0 ), className: "text-center", visible:0}, 
			{"title": "Concepto","data": "Concepto", className: "text-left", width: 300},
			{"title": "Monto Recaudado", "data": "MontoRecaudado", render: $.fn.dataTable.render.number( '.', ',', 0 ), className: "text-right", width: 200},	
		],			
	});
	limpiarCajas=1;
	console.log("Total Recaudado: " + totalRecaudado);
		
};

var cargarDetallePagosCajaDiaria = function(data){
	
	console.log("cargarDetallePagosCajaDiaria()");
	
    if(limpiarCajaDiariaDetallePagos==1){
		destruirTabla('#tablaDetallePago');
		$('#tablaDetallePago thead').empty();
	}
	
	$("#tablaDetallePago").dataTable({
		 "footerCallback": function ( row, data, start, end, display ) {
		var api = this.api(), data;
		// Remove the formatting to get integer data for summation
		var intVal = function (i){
			return typeof i === 'string' ?
				i.replace(/[\$,]/g, '')*1 :
				typeof i === 'number' ?
					i : 0;
		};
		// Total over all pages
		totalRecaudado = api
			.column(2)
			.data()
			.reduce( function (a, b) {
				return intVal(a) + intVal(b);
			}, 0 );
			
			$( api.column( 2 ).footer() ).html('$'+totalRecaudado +' ( Total Recaudado )');
		},
		responsive:false,
		bFilter: false, 
		searching: false,
		paging: false, 
		"aLengthMenu": DataTableLengthMenu,
		"language": LenguajeTabla,
		"data": data,
		
		"columns":
		[
			{"title": "Nro. Pago","data": "IdAbono",  className: "text-center", render: $.fn.dataTable.render.number( '.', ',', 0 )}, 
			{"title": "Fecha de Pago",
							"data": "FechaAbono", className: "text-center", 
							"render": function(data, type, row, meta){
								if(type === 'display'){
									data = moment(data, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY");
								}
								return data;
							}
			}, 
			{"title": "Cliente","data": "NombreCliente", className: "text-left"},
			{"title": "RUTCliente","data": "RUTCliente", className: "text-left"},
			{"title": "Forma de Pago","data": "FormaPago", className: "text-left"},
			{"title": "Monto Recaudado", "data": "MontoAbono", className: "text-right", render: $.fn.dataTable.render.number( '.', ',', 0 )},	
		],			
	});
	limpiarCajaDiariaDetallePagos=1;
	console.log("Total Recaudado: " + totalRecaudado);
		
};

var titulosListados = function(){
	console.log("titulosListados()"); 
	$('#ResumenRecaudacionEfectivo').html("Resumen Recaudación Efectivo<br />Caja Actual Nro. "+$("#IdCaja").val());
	$('#ResumenPagosRecibidos').html("Detalle de Pagos de Cuentas Recibidos<br />Caja Actual Nro. "+$("#IdCaja").val());
	$('#ResumenIngresosFP').html("Resumen de Ingresos por Forma de Pago<<br />Caja Actual Nro. "+$("#IdCaja").val());
	$('#DetalleIngresosFP').html("Detalle de Ingresos por Forma de Pago<br />Caja Actual  Nro. "+$("#IdCaja").val());
	
}	


$(document).ready(function(){

	
	ManejoRespuestaProcesarInfoCaja(d.v_cajaActual);
    cargarCajaDiariaResumen(d.v_resumen_caja);
	cargarCajaDiariaDetalleVentas(null)
	
	cargarResumenRecaudacion(d.v_recaudacion_caja_diaria);
	cargarDetallePagosCajaDiaria(d.v_detalle_pagos_caja_diaria);
	
	titulosListados();
	
	
});
