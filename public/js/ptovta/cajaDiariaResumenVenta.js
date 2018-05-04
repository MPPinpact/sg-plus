var manejoRefresh=limpiarLocales=limpiarCajaDiariaResumen=limpiarCajaDiariaDetalle=limpiarDetalle=errorRut2=errorRut3=limpiarBodegas=NVenta=0;

var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};

var verDetalleVenta = function(IdVenta){
	console.log("verDetalleVenta(IdVenta)");
	$("#IdVenta").val(IdVenta);
	
	parametroAjax.ruta=rutaCDDV;
    parametroAjax.data = $("#FormCajaDiaria").serialize();
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaVerDetalleVenta(respuesta);
}

var ManejoRespuestaVerDetalleVenta = function(respuesta){
	console.log("Detalle: " + respuesta.respuesta.v_detalle_venta[0]);
		
    if(respuesta.code==200){
		
        cargarDetalleVenta(respuesta.respuesta.v_detalle_venta);
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

var cargarCajaDiariaResumenVenta = function(data){
    if(limpiarCajaDiariaResumen==1){
		destruirTabla('#tablaCajaDiariaResumenVenta');
		$('#tablaCajaDiariaResumenVenta thead').empty();
	}
	
	$("#tablaCajaDiariaResumenVenta").dataTable({
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
			{"title": "Nro. Venta","data": "IdVenta",  className: "text-center", render: $.fn.dataTable.render.number( '.', ',', 0 ), className: "text-center"},
			{"title": "FormaPago", "data": "FormaPago", className: "text-left"},
			{"title": "RUT Client", "data": "RUTCliente", className: "text-left"},
			{"title": "Cliente", "data": "NombreCliente", className: "text-left"},
			{"title": "Monto","data": "TotalFormaPago", render: $.fn.dataTable.render.number( '.', ',', 0 ), className: "text-right"},
			{"title": "", "data": "IdVenta",
				"render": function(data, type, row, meta){
					var result = `
					<center>
					<a href="#" onclick="verDetalleVenta(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Movimientos" data-original-title="Delete">
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

var cargarDetalleVenta = function(data){
    if(limpiarDetalle==1){
		destruirTabla('#tablaDetalleVenta');
		$('#tablaDetalleVenta thead').empty();
	}
	
	$("#tablaDetalleVenta").dataTable({
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
			{"title": "Id Venta","data": "IdVenta", visible:0},
			{"title": "Producto", "data": "NombreProducto", className: "text-left"},
			{"title": "Cant", "data": "CantidadVenta", className: "text-center", render: $.fn.dataTable.render.number( '.', ',', 0 )},
			{"title": "Valor","data": "ValorUnitarioVenta", className: "text-right", render: $.fn.dataTable.render.number( '.', ',', 0 )},
			{"title": "Total","data": "TotalLinea", className: "text-right", render: $.fn.dataTable.render.number( '.', ',', 0 )},
		],			
	});
	limpiarDetalle=1;
	console.log("Total Forma Pago: " + totalFormaPago);
};



$(document).ready(function(){
	
	ManejoRespuestaProcesarInfoCaja(d.v_cajaActual);
    cargarCajaDiariaResumenVenta(d.v_detalle_venta);
	cargarDetalleVenta(null)
	
	
});