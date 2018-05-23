var manejoRefresh=limpiarLocales=limpiarCajas=limpiarDetalleCaja=errorRut=errorRut2=errorRut3=limpiarBodegas=NVenta=0;

var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};


var verDetallesCajaDiaria = function(IdCaja){
    parametroAjax.ruta=rutaB;
    parametroAjax.data = {IdCaja:IdCaja};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaVerDetalleCajaDiaria(respuesta);
}


var ManejoRespuestaVerDetalleCajaDiaria = function(respuesta){
    if(respuesta.code==200){
        cargarDetalleCajaDiaria(respuesta.respuesta);
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

var cargarCajasDiarias = function(data){
    if(limpiarCajas==1){destruirTabla('#tablaCajaDiaria');$('#tablaCajaDiaria thead').empty();}
        $("#tablaCajaDiaria").dataTable({
            responsive:false,
            "aLengthMenu": DataTableLengthMenu,
            "pagingType": "full_numbers",
			"pageLength": 25 , 
            "language": LenguajeTabla,
            "columnDefs": [
                {"targets": [ 1 ],"searchable": true},
                {"sWidth": "1px", "aTargets": [6]}
            ],
            "data": data,
            "columns":[
                {"title": "ACC", "data": "IdCaja",
                    "render": function(data, type, row, meta){
                        var result = `
                        <center>
                        <a href="#" onclick="verDetallesCajaDiaria(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Detalles" data-original-title="Delete">
                            <i class="icofont icofont-search"></i>
                        </a>
                        <a href="#" onclick="cambiarEstatusVenta(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
                            <i class="icofont icofont-ui-delete"></i>
                        </a>	
                        </center>`;
                        return result;
                    }
                },
                {"title": "Id Caja","data": "IdCaja",  
							render: $.fn.dataTable.render.number( '.', ',', 0 ),
							className: "text-center"},
                {"title": "Fecha Caja", "data": "FechaCaja", className: "text-center", 
                    "render": function(data, type, row, meta){
                        if(type === 'display'){
                            data = moment(data, 'YYYY-MM-DD',true).format("DD-MM-YYYY");
                        }
                        return data;
                    }
                },
                {"title": "Local","data": "NombreLocal", className: "text-left"},
                {"title": "Usuario Apertura","data": "UsuarioApertura", className: "text-left"},
                {"title": "Fecha Apertura", className: "text-center", 
						"data": "FechaApertura",
						"render": function(data, type, row, meta){
							if(type === 'display'){
                                if( moment(data, moment.ISO_8601).isValid() ){
                                    data = moment(data, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY HH:mm:ss");
                                }else{
                                    data = 'Desconocida';
                                }
							}
							return data;
						}
				},
                {"title": "Usuario Cierre","data": "UsuarioCierre", className: "text-left", 
                            "render": function(data, type, row, meta){
                                if(type === 'display'){
                                    if( data == null ){
                                        data = 'Caja Abierta'
                                    }
                                }

                            return data;
                        }},
                {"title": "Fecha Cierre", className: "text-center", 
						"data": "FechaCierre",
						"render": function(data, type, row, meta){

							if( moment(data, moment.ISO_8601).isValid() ){
                                data = moment(data, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY HH:mm:ss");
                            }else{
                                data = 'Caja Abierta'
                            }
							return data;
						}
                },
				{"title": "Estado Caja","data": "DesEstadoCaja", className: "text-center"},
            ],			
        });
        limpiarCajas=1;
};

var cargarDetalleCajaDiaria = function(data){
    
	if(limpiarDetalleCaja==1){
		destruirTabla('#tablaDetalleCajaDiaria');
		$('#tablaDetalleCajaDiaria thead').empty();
	}
	
	$("#tablaDetalleCajaDiaria").dataTable({
		responsive:false,
		"aLengthMenu": DataTableLengthMenu,
		"pageLength": 5, 
		"language": LenguajeTabla,
		bFilter: false, 
		bInfo: false,
		"bPaginate": false,			
		"data": data,
		"columns":[
			{"title": "", "data": "IdCaja",
				"render": function(data, type, row, meta){
					var result = `
					<center>
					<a href="#" onclick="verDetallesVenta(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Detalles" data-original-title="Delete">
						<i class="icofont icofont-search"></i>
					</a>`;
					return result;
				}
			},
			{"title": "Id Caja","data": "IdCaja",visible:0},
			{"title": "Id Forma Pago","data": "IdFormaPago",visible:0},
			{"title": "Venta","data": "IdVenta"},
			{"title": "Forma Pago","data": "FormaPago"},
			{"title": "Total","data": "TotalFormaPago", 
                            render: $.fn.dataTable.render.number( '.', ',', 0 ),
                            className: "text-center"}, 
		],
	});
	limpiarDetalleCaja=1;
};


$(document).ready(function(){
    
    cargarCajasDiarias(d.v_cajas_diarias);
	cargarDetalleCajaDiaria(null);
	
	// Botones de cabecera de compra
    // $(document).on('click','#botonCDR', BotonAgregar);
    // $(document).on('click','#guardarI',validadorI);
    // $(document).on('click','#aceptarM',validadorP);
    // $(document).on('click','#cancelar',BotonCancelar);
    // $(document).on('click','#agregar',BotonAgregar);
    // $(document).on('click','#modificar',modificarCabeceras);
    // $(document).on('click','#volverAct',volverTabs);
});
