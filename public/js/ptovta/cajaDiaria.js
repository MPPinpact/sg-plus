var manejoRefresh=limpiarLocales=limpiarCajas=limpiarDetalleCaja=errorRut=errorRut2=errorRut3=limpiarBodegas=NVenta=0;

var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};


var cargarCajasDiarias = function(data){
    if(limpiarCajas==1){destruirTabla('#tablaCajaDiaria');$('#tablaCajaDiaria thead').empty();}
        $("#tablaCajaDiaria").dataTable({
            responsive:false,
            "aLengthMenu": DataTableLengthMenu,
            "pagingType": "full_numbers",
			"pageLength": 10, 
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
                        <a href="#" onclick="verDetallesVenta(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Detalles" data-original-title="Delete">
                            <i class="icofont icofont-search"></i>
                        </a>
                        <a href="#" onclick="cambiarEstatusVenta(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
                            <i class="icofont icofont-ui-delete"></i>
                        </a>	
                        </center>`;
                        return result;
                    }
                },
                {"title": "Id Caja","data": "IdCaja",  className: "text-center",
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
                {"title": "Usuario Responsable","data": "IdUsuario", className: "text-center"},
                {"title": "Fecha Apertura", className: "text-center", 
						"data": "FechaApertura",
						"render": function(data, type, row, meta){
							if(type === 'display'){
								data = moment(data, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY");
							}
							return data;
						}
				},
                {"title": "Fecha Cierre", className: "text-center", 
						"data": "FechaCierre",
						"render": function(data, type, row, meta){
							if(type === 'display'){
								data = moment(data, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY");
							}
							return data;
						}
                },
				{"title": "Estado Caja","data": "EstadoCaja", className: "text-center"},
            ],			
        });
        limpiarCajas=1;
};

var cargarDetalleCajaDiaria = function(data){
    if(limpiarDetalleCaja==1){destruirTabla('#tablaDetalleCajaDiaria');$('#tablaDetalleCajaDiaria thead').empty();}
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
                        </a>
                        <a href="#" onclick="cambiarEstatusVenta(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
                            <i class="icofont icofont-ui-delete"></i>
                        </a>	
                        </center>`;
                        return result;
                    }
                },
                {"title": "Forma de Pago","data": "IdVenta"},
                {"title": "Monto","data": "TotalVenta",
							render: $.fn.dataTable.render.number( '.', ',', 2 ),
							className: "text-right"},
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

// var calcularMontos = function(CantidadVenta,ValorUnitarioVenta,FactorImpuesto,MontoDescuento){
    // var ValorImpuesto = (CantidadVenta * ValorUnitarioVenta * FactorImpuesto / 100)
    // $("#ValorImpuestos").val(ValorImpuesto);
    // var TotalLinea = ((CantidadVenta * ValorUnitarioVenta) - MontoDescuento);
    // $("#TotalLinea").val(TotalLinea);
    // var ValorUnitarioFinal = (TotalLinea / CantidadVenta);
    // $("#ValorUnitarioFinal").val(ValorUnitarioFinal);
// }

// var calcularTotalVenta = function(totalVenta){
	// $("#TotalVentaDetalle").val(totalVenta);
	// $("#TotalVentaPago").val(totalVenta);
	// $("#TotalVenta").val(totalVenta);
// }

// var ManejoRespuestaBuscarProducto = function(respuesta){
    // if(respuesta.code==200){
        // if(respuesta.respuesta!=null){
            // if(respuesta.respuesta.producto.IdProducto){
                // if(respuesta.respuesta.producto.IdProducto==0){
                    // $.growl({message:"Producto no encontrado"},{type: "warning", allow_dismiss: true});
                // }else{
                    // $("#IdProducto").val(respuesta.respuesta.producto.IdProducto);
                    // $("#NombreProducto").val(respuesta.respuesta.producto.NombreProducto);
                    // $("#ValorUnitarioVenta").val(respuesta.respuesta.producto.PrecioVentaSugerido);
                    // $("#CantidadVenta").val(1);
                    // $("#FactorImpuesto").val(respuesta.respuesta.impuesto);
                    // $("#MontoDescuento").val(0);
                    // $("#IdUnidadMedida").val(respuesta.respuesta.producto.IdUnidadMedida).trigger("change");
                    // calcularMontos($("#CantidadVenta").val(),$("#ValorUnitarioVenta").val(),$("#FactorImpuesto").val(),$("#MontoDescuento").val());
                // } 
            // } 
        // }else{
            // $.growl({message:"Producto no encontrado"},{type: "warning", allow_dismiss: true});
        // }
    // }else{
        // $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true});
    // }
// }

// var ManejoRespuestaBuscarCliente = function(respuesta){
    // if(respuesta.code==200){
        // if(respuesta.respuesta!=null){
            // if(respuesta.respuesta.IdCliente==0){
                // // var rut = $("#RUTProveedor").val();
                // // $("#RUTProveedor2").val(rut);
                // // $("#ModalProveedor").modal();
            // }else{
                // $("#IdCliente").val(respuesta.respuesta.IdCliente);
                // $("#NombreCliente").val(respuesta.respuesta.NombreCliente);
            // }    
        // }else{
            // $.growl({message:"Cliente no encontrado"},{type: "warning", allow_dismiss: true,});
        // }
    // }else{
        // $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    // }
// }

// var ManejoRespuestaBuscarClienteVC = function(respuesta){
	
	// console.log("ManejoRespuestaBuscarClienteVC...");
	
    // if(respuesta.code==200){
        // if(respuesta.respuesta.v_cliente!=null){
            // $("#IdClienteVC").val(respuesta.respuesta.v_cliente[0].IdCliente);
            // $("#NombreClienteCredito").val(respuesta.respuesta.v_cliente[0].NombreCliente);
            // $("#FechaPrimeraCuota").val(respuesta.respuesta.v_fechas.fechaPago);
        // }else{
            // $.growl({message:"Cliente no encontrado"},{type: "warning", allow_dismiss: true,});
        // }
    // }else{
        // $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    // }
// }

// var ManejoRespuestaBuscarEmpresa = function(respuesta){
    // if(respuesta.code==200){
        // if(respuesta.respuesta!=null){
            // crearselect(respuesta.respuesta.v_locales,"IdLocal");
            // if(respuesta.respuesta.busqueda.IdEmpresa==0){
                // $("#idEmpresa").val("");
                // $("#NombreFantasiaE").val("");
                // $.growl({message:"Empresa no encontrada"},{type: "warning", allow_dismiss: true,});
            // }else{
                // $("#idEmpresa").val(respuesta.respuesta.busqueda.IdEmpresa);
                // $("#NombreFantasiaE").val(respuesta.respuesta.busqueda.NombreFantasia);
            // }    
        // }else{
            // $.growl({message:"Contacte al personal informatico"},{type: "warning", allow_dismiss: true,});
        // }
    // }else{
        // $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    // }
// }

// var ManejoRespuestaProcesarDetalleVenta = function(respuesta){
    // if(respuesta.code==200){
        // if(respuesta.respuesta!=null){
            // $("#ModalDetalleVenta").modal();
            // $("#spanTituloModal").text("Detalle Venta");
            // $("#divBotonM").show();
            // $("#divBotonesAC").hide();
            // bloquearInputsDetalles();
            // pintarDatosActualizarDetalles(respuesta.respuesta[0]);
        // }else{
            // $.growl({message:"Contacte al personal informatico"},{type: "warning", allow_dismiss: true,});
        // }
    // }else{
        // $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    // }
// }

// var ManejoRespuestaProcesarCD = function(respuesta){
    // if(respuesta.code==200){
        // if(respuesta.respuesta.activar>0){
            // if(respuesta.respuesta.v_detalles.length>0){
                // $.growl({message:"Procesado"},{type: "success", allow_dismiss: true,});
                // cargarTablaDetalles(respuesta.respuesta.v_detalles);
            // }
        // }else{
            // $.growl({message:"Debe seleccionar un registro"},{type: "warning", allow_dismiss: true,});
        // }
    // }else{
        // $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    // }
// }

// var ManejoRespuestaProcesarD = function(respuesta){
    // if(respuesta.code==200){
        // NVenta=respuesta.respuesta.v_cabecera[0].IdVenta;
        // bloquearInputs();
        // $("#div-mod").show();
        // $("#div-acep").hide();
        // $(".divDetalles").toggle();
        // $("#divVolver").show();
        // $("#divTabs").show();
        // $("#spanTitulo").text("Detalle Venta");
		
        // pintarDatosActualizar(respuesta.respuesta.v_cabecera[0]);
        // cargarTablaDetalles(respuesta.respuesta.v_detalles);
		// cargarTablaPagos(respuesta.respuesta.v_pagos);
		
        // if(parseInt(respuesta.respuesta.v_cabecera[0].EstadoVenta)>1){
            // $(".CerrarVenta").hide();
            // $("#agregarC").hide();
        // }else{
            // $(".CerrarVenta").show();
            // $("#agregarC").show();
        // }
    // }else{
        // $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    // }
// }

// // Manejo Activar / Desactivar compra
// var ManejoRespuestaProcesarI = function(respuesta){
    // if(respuesta.code==200){
        // if(respuesta.respuesta.activar>0){
            // if(respuesta.respuesta.v_ventas.length>0){
                // $.growl({message:"Procesado"},{type: "success", allow_dismiss: true,});
                // cargarTablaVentas(respuesta.respuesta.v_ventas);
            // }
        // }else{
            // $.growl({message:"Debe seleccionar un registro"},{type: "warning", allow_dismiss: true,});
        // }
    // }else{
        // $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    // }
// }

// // Manejo Registro de proveedor
// var ManejoRespuestaProcesarProveedor = function(respuesta,nombre){
    // if(respuesta.code==200){
        // if(respuesta.respuesta>0){
            // $("#IdProveedor").val(respuesta.respuesta);
            // $("#NombreFantasia").val(nombre);
            // $("#ModalProveedor").modal("hide");
        // }else{
            // $.growl({message:"ocurrió un error mientras se registraba el proveedor"},{type: "warning", allow_dismiss: true,}); 
        // }
    // }else{
        // $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    // }
// };

// // Manejo Registro o actualizacion de cabecera de compra
// var ManejoRespuestaProcesar = function(respuesta){
    // if(respuesta.code==200){
        // var res = JSON.parse(respuesta.respuesta.f_registro);
        // if(res.code=="200"){ 
            // $.growl({message:res.des_code},{type: "success", allow_dismiss: true,});
            // $("#IdVenta").val(res.IdVenta);
            // $("#IdVenta2").val(res.IdVenta);
            // $("#div-mod").hide();
            // $("#div-acep").hide();
			
            // $("#aCabecera").removeClass("active");
            // $("#TabCabecera").removeClass("active");
			
            // $("#TabDetalles").addClass("active");
            // $("#aDetalles").addClass("active");
			
            // $("#divTabs").show();
            // $("#divVolver").show();               
        // }
        // if (res.code=="-2"){
            // $.growl({message:res.des_code},{type: "warning", allow_dismiss: true,});
        // }
    // }else{
        // $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    // }
// };

// var ManejoRespuestaProcesarDetalles = function(respuesta){
    // if(respuesta.code==200){
        // var res = JSON.parse(respuesta.respuesta.f_registro);
        // switch(res.code) {
            // case '200':
                // $.growl({message:res.des_code},{type: "success", allow_dismiss: true,});
                // $(".divBotonesC").toggle();
                // $("#ModalDetalleVenta").modal("hide");
                // $('#IdDetalleCompra').val("");
                // $('#FormDetalle')[0].reset();
                // cargarTablaDetalles(respuesta.respuesta.v_detalles);
                // break;
            // case '-2':
                // $.growl({message:res.des_code},{type: "warning", allow_dismiss: true,});
                // break;
            // default:
                // $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
                // break;
        // }
    // }else{
        // $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    // }

// }

// var cargarTablaVentas = function(data){
    // if(limpiarCajas==1){destruirTabla('#tablaVentas');$('#tablaVentas thead').empty();}
        // $("#tablaVentas").dataTable({
            // responsive:false,
            // "aLengthMenu": DataTableLengthMenu,
            // "pagingType": "full_numbers",
			// "pageLength": 50, 
            // "language": LenguajeTabla,
            // "columnDefs": [
                // {"targets": [ 1 ],"searchable": true},
                // {"sWidth": "1px", "aTargets": [8]}
            // ],
            // "data": data,
            // "columns":[
                // {
                    // "title": "",
                    // "data": "IdVenta",
                    // "render": function(data, type, row, meta){
                        // var result = `
                        // <center>
                        // <a href="#" onclick="verDetallesVenta(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Detalles" data-original-title="Delete">
                            // <i class="icofont icofont-search"></i>
                        // </a>
                        // <a href="#" onclick="cambiarEstatusVenta(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
                            // <i class="icofont icofont-ui-delete"></i>
                        // </a>	
                        // </center>`;
                        // return result;
                    // }
                // },
                // {"title": "Id","data": "IdVenta", 
							// render: $.fn.dataTable.render.number( '.', ',', 0 ),
							// className: "text-center"},
                // {
                    // "title": "Fecha Venta", 
                    // "data": "FechaVenta", className: "text-center", 
                    // "render": function(data, type, row, meta){
                        // if(type === 'display'){
                            // data = moment(data, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY");
                        // }
                        // return data;
                    // }
                // },
                // {"title": "Nombre Local","data": "NombreLocal"},
                // {"title": "RUT Cliente","data": "RUTCliente", className: "text-center"},
                // {"title": "Nombre Cliente","data": "NombreCliente"},
                // {"title": "Nombre Vendedor","data": "NombreVendedor"},
                // {"title": "Total","data": "TotalVenta",
							// render: $.fn.dataTable.render.number( '.', ',', 2 ),
							// className: "text-right"},
                // {"title": "Estado Venta","data": "EstadoVenta",visible:0},
                // {"title": "Estado","data": "DesEstadoVenta", className: "text-center"}
            // ],
        // });
        // limpiarLocales=1;
// };

// var cargarTablaDetalles = function(data){
    // if(limpiarImpuestos==1){
		// destruirTabla('#tablaDetalles');
		// $('#tablaDetalles thead').empty();
	// }
		
        // var columnReport = [[5],[6],[9],[11],[12]];       
        // $("#tablaDetalles").dataTable({
			
			// "footerCallback": function (data){
            // var api = this.api(), data;
            // // Remove the formatting to get integer data for summation
            // var intVal = function (i){
                // return typeof i === 'string' ?
                    // i.replace(/[\$,]/g, '')*1 :
                    // typeof i === 'number' ?
                        // i : 0;
            // };
            // // Total over all pages
            // totalVenta = api
                // .column(12)
                // .data()
                // .reduce( function (a, b) {
                    // return intVal(a) + intVal(b);
                // }, 0 );
			// },
            // responsive:false,
            // "bSort": false,
            // "scrollCollapse": false,
            // "paging": false,
            // "searching": false,
            // "info":false,			
			// "pageLength": 50, 
            // "columnDefs": [
                // {"targets": [ 1 ],"searchable": true},
                // {"sWidth": "1px", "aTargets": [8]}
            // ],
            // "data": data,
            // "columns":[
                // {
                 // "title": "",
                 // "data": "IdDetalleVenta",
                    // "render": function(data, type, row, meta){
                        // var result = `
                        // <center>
                        // <a href="#" onclick="verDetallesDetalleVenta(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Detalles" data-original-title="Delete">
                            // <i class="icofont icofont-search"></i>
                        // </a>
                        // <a href="#" onclick="cambiarEstatusDetalleVenta(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
                            // <i class="icofont icofont-ui-delete"></i>
                        // </a>
                        // </center>`;
                        // return result;
                    // }
                // },
                // {"title": "Id","data": "IdDetalleVenta",visible:0},
                // {"title": "IdVenta","data": "IdVenta",visible:0},
                // {"title": "IdProducto","data": "IdProducto",visible:0},
                // {"title": "IdUnidadMedida","data": "IdUnidadMedida",visible:0},
                // {"title": "Nombre Producto","data": "NombreProducto", 
							// width: 200},
                // {"title": "Cantidad","data": "CantidadVenta", 
							// width: 50,
							// render: $.fn.dataTable.render.number( '.', ',', 2 ),
							// className: "text-center"},
                // {"title": "Valor Unitario","data": "ValorUnitarioVenta", 
							// render: $.fn.dataTable.render.number( '.', ',', 2 ),
							// className: "text-right"},
                // {"title": "Factor Impuesto","data": "FactorImpuesto",visible:0},
                // {"title": "Valor Impuestos","data": "ValorImpuestos",visible:0},
                // {"title": "Monto Descuento","data": "MontoDescuento",
							// render: $.fn.dataTable.render.number( '.', ',', 2 ),
							// className: "text-right"},
                // {"title": "Valor Unitario Final","data": "ValorUnitarioFinal",
							// render: $.fn.dataTable.render.number( '.', ',', 2 ),
							// visible:0},
                // {"title": "Total Linea","data": "TotalLinea", 
							// render: $.fn.dataTable.render.number( '.', ',', 2 ),
							// className: "text-right"},
                // {"title": "Estado","data": "EstadoVentaDetalle",visible:0},
                // {"title": "Estado","data": "desEstadoVentaDetalle",visible:0}
            // ],   
            // dom: 'Bfrtip',
            // buttons: [
                // {
                    // text: 'Agregar PreVenta', className: 'btn-xlg btn-inverse-primary waves-effect waves-light botonAgregarPreVenta'
                // },
				// {
                    // text: 'Agregar Producto', className: 'btn-xlg btn-inverse-primary waves-effect waves-light botonAgregarProducto'
                // },
				// {
                    // text: 'Finalizar Venta', className: 'btn-xlg btn-inverse-primary waves-effect waves-light CerrarVenta'
                // },
				 // {
                    // extend: 'pdf',
                    // text: 'Imprimir Venta',
                    // className: 'btn-xlg btn-inverse-primary waves-effect waves-light ImprimirVenta',
                    // // orientation:'landscape',  //Hoja Horizontal
                    // pageSize:'A4',
                    // title:'Detalle Venta N° '+NVenta,
					// filename:'DetalleVenta_'+NVenta,
                    // exportOptions: {columns: columnReport, modifier: {page: 'all', } }, 
                    // customize : function(doc){
                        // doc.defaultStyle.fontSize = 8; 
                        // doc.pageMargins = [100, 40, 40,0];
                        // var colCount = new Array();   
                        // $($("#tablaDetalles").dataTable()).find('tbody tr:first-child td').each(function(){
                            // if($(this).attr('colspan')){
                                // for(var i=1;i<=$(this).attr('colspan');$i++){
                                    // colCount.push('*');
                                // }
                            // }else{ colCount.push('*'); }
                        // });
                        // doc.content[1].table.widths = colCount;
                    // }
                // }
            // ]
        // });

	// limpiarImpuestos=1;
	// calcularTotalVenta(totalVenta);
// };

// var cargarTablaPagos = function(data){
    // if(limpiarPagos==1) { destruirTabla('#tablaPagos'); $('#tablaPagos thead').empty();}
	
	
        // $("#tablaPagos").dataTable({
			
			// "footerCallback": function (data){
            // var api = this.api(), data;
            // // Remove the formatting to get integer data for summation
            // var intVal = function (i){
                // return typeof i === 'string' ?
                    // i.replace(/[\$,]/g, '')*1 :
                    // typeof i === 'number' ?
                        // i : 0;
            // };
            // // Total over all pages
            // totalPago = api
                // .column(4)
                // .data()
                // .reduce( function (a, b) {
                    // return intVal(a) + intVal(b);
                // }, 0 );
			// },
			
            // responsive:false,
            // "bSort": false,
            // "scrollCollapse": false,
            // "paging": false,
            // "searching": false,
            // "info":false,			
			// "pageLength": 50, 
            
            // "data": data,
            // "columns":[
                // {
                 // "title": "",
                 // "data": "IdDetallePago",
                    // "render": function(data, type, row, meta){
                        // var result = `
                        // <center>
                        // <a href="#" onclick="verDetallePago(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Pago" data-original-title="Delete">
                            // <i class="icofont icofont-search"></i>
                        // </a>
                        // <a href="#" onclick="eliminarPago(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Eliminar Pago" data-original-title="Delete">
                            // <i class="icofont icofont-ui-delete"></i>
                        // </a>
                        // </center>`;
                        // return result;
                    // }
                // },
                // {"title": "Id Pago","data": "IdDetallePago",visible:0},
                // {"title": "Id Venta","data": "IdVenta",visible:0},
                // {"title": "Forma de Pago","data": "FormaPago", width: 200,  className: "text-left"},
                // {"title": "Monto Pagado","data": "MontoPagado", width: 300, className: "text-right", render: $.fn.dataTable.render.number('.',',',2) }
            // ],   
            
        // });

	// limpiarPagos=1;
	// console.log("Total Pagos: " + totalPago);
	// $("#TotalPagado").val(totalPago);
	// calcularSaldoPago();
// };


// var pintarDatosActualizar = function(data){
	// console.log("EstadoVenta: " + data.EstadoVenta);
	
    // $(".md-form-control").addClass("md-valid");
    // $("#IdVenta").val(data.IdVenta);
    // $("#IdVenta2").val(data.IdVenta);
    // $("#IdCliente").val(data.IdCliente);
    // $("#FechaVenta").val(moment(data.FechaVenta, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY"));
    // $("#RUTCliente").val(data.RUTCliente);
	// $("#IdEstadoVenta").val(data.EstadoVenta);
    // $("#NombreCliente").val(data.NombreCliente);
    // $("#TotalVenta").val(data.TotalVenta);
// }

// var pintarDatosActualizarDetalles = function(data){
    // $("#IdVenta2").val(data.IdVenta);
    // $("#IdDetalleVenta").val(data.IdDetalleVenta);
    // $("#IdProducto").val(data.IdProducto);
    // $("#CodigoBarra").val(data.CodigoBarra);
    // $("#NombreProducto").val(data.NombreProducto);
    // $("#IdUnidadMedida").val(data.IdUnidadMedida).trigger("change");
    // $("#CantidadVenta").val(data.CantidadVenta);
    // $("#ValorUnitarioVenta").val(data.ValorUnitarioVenta);
    // $("#FactorImpuesto").val(data.FactorImpuesto);
    // $("#ValorImpuestos").val(data.ValorImpuestos);
    // $("#MontoDescuento").val(data.MontoDescuento);
    // $("#ValorUnitarioFinal").val(data.ValorUnitarioFinal);
    // $("#TotalLinea").val(data.TotalLinea);
// }

// var BotonAgregar = function(){
    // $("#spanTitulo").text("Registrar Venta");
    // desbloquearInputs();
    // $(".divDetalles").toggle();
    // $("#divVolver").hide();
    // $("#IdVenta").val("");
    // $('#FormVentas')[0].reset();
    // $('#FormDetalle')[0].reset();
	// $("#divTabs").hide();
    // $("#div-mod").hide();
    // $("#div-acep").show();
    // var now = moment().format('DD-MM-YYYY')
    // $("#FechaVenta").val(now);
	
	// cargarTablaDetalles();
	// $("#agregarC").show();
// }

// var BotonCancelar = function(){
    // $("#spanTitulo").text("");
    // $(".md-form-control").removeClass("md-valid");
    // $('#FormVentas')[0].reset();
    // $('#FormDetalle')[0].reset();
	// $("#IdVenta").val("");
    // $("#divTabs").show();
    // $("#div-mod").hide();
    // $("#div-acep").hide();
    // // $(".divBotones").toggle();
    // $(".divDetalles").toggle();
    // bloquearInputs();
    // $("#PrecioUltimaCompra").prop('readonly', true);
    // NVenta=0;
// }

// var volverListado = function(){
    // $(".divDetalles").toggle();
    // $('#FormVentas')[0].reset();
    // $('#FormDetalle')[0].reset();
    // $("#IdVenta").val("");
    // $("#IdVenta2").val("");
	// $("#RUTProveedor2").val("");
	
    // $("#IdDetalleCompra").val("");
    // $("#IdProducto").val("");
    // $("#aCabecera").removeClass("active");
    // $("#TabCabecera").removeClass("active");
    // $("#TabDetalles").addClass("active");
    // $("#aDetalles").addClass("active");
    // NVenta=0;
// }

// var BotonAgregarPreVenta = function(){
	// console.log("Boton Finalizar Venta...");
	
	// $("#IdVentaPreVenta").val($("#IdVenta").val());	
	// $("#ModalAgregarPreVenta").modal();	
	
	// $('#ModalAgregarPreVenta').on('shown.bs.modal', function() {
		// $('#NumeroPreVenta').focus().select();
	// });
// }  


// var BotonFinalizarVenta = function(){
	// console.log("Boton Finalizar Venta...");
	
	// $("#divBotonAC_FV").show();
	// $("#ModalFinalizarVenta").modal();	
// }  

// var BotonFinalizarVentaOK = function(){
	// console.log("Boton Finalizar Venta OK...");
	
	// parametroAjax.ruta=rutaFV;
    // parametroAjax.data = $("#FormVentas").serialize();
    // respuesta=procesarajax(parametroAjax);
	// console.log("Respuesta: " + respuesta);
	
    // //ManejoRespuestaProcesarCargaPreferencias(respuesta);
// } 

// var BotonFinalizarVentaNO = function(){
	// console.log("Boton Finalizar Venta NO...");
	
	// $("#ModalFinalizarVenta").modal("hide");
// }  

// var BotonCancelarVenta = function(){
	// console.log("Boton Cancelar Venta...");
	
	// $("#divBotonAC_CV").show();
	// $("#ModalCancelarVenta").modal();	
// }  

// var BotonCancelarVentaOK = function(){
	// window.location.href = ruta;
// }

// var BotonCancelarVentaNO = function(){
	// console.log("Boton Cancelar Venta NO...");
	
	// $("#ModalCancelarVenta").modal("hide");	
// }

// var cargarInteresCuotas = function(data){
    // CuotaMax=data.NumeroMaxCuotas;
    // Interes = data.InteresMensual;
// }

// var calcularMontoCuotas = function(){
	// var montoCredito = $("#MontoAFinanciar").val();
	// var numeroCuotas = $("#NumeroCuotasCredito").val();
	// var interesMensual = $("#InteresMensualCredito").val();
	
    // var montoFinalCredito = montoCredito * ( 1 + (numeroCuotas * interesMensual/100));
    // var montoCuota = montoFinalCredito / numeroCuotas;
    // $("#MontoFinalCredito").val(Math.round(montoFinalCredito));
    // $("#MontoCuotaCredito").val(Math.round(montoCuota));
// }

// var BotonPagoCredito = function (){
	// console.log("Pago Credito");
	// ProcesarCargaPreferencias();
	
	// $("#IdVentaPago").val($("#IdVenta").val());
	// $("#IdFormaPago").val(3);
	
	// var  MontoAPagar = ( parseFloat($("#SaldoPago").val()) * -1);
	// $("#MontoPagoEfectivo").val(MontoAPagar);
	// $("#MontoAFinanciar").val(MontoAPagar);
	
	// calcularMontoCuotas();
	
	// $("#FechaPrimeraCuota").val("");
	// $("#NumeroTransaccionTarjeta").val(0);
	// $("#CodigoAprobacionTarjeta").val(0);
	
	// $("#InfoAddTC").hide();
	// $("#InfoAddCredito").show();

	// $("#divBotonM_FPE").hide();
	// $("#divBotonAC_FPE").show();
	// $("#guardarFPE").text("Continuar");
	
    // $("#spanTituloModalPagoEfectivo").text("Registrar Pago Crédito Interno");
	// $("#ModalDetallePagoEfectivo").modal();	
	
    // desbloquearInputsFPE();
	
	// $('#ModalDetallePagoEfectivo').on('shown.bs.modal', function() {
		// $('#RUTClienteCredito').focus().select();
	// });
// }

// var BotonPagoTD = function (){
	// console.log("Pago TD");
	
	// $("#IdVentaPago").val($("#IdVenta").val());
	// $("#IdFormaPago").val(1);
	
	// var  MontoAPagar = ( parseFloat($("#SaldoPago").val()) * -1);
	// $("#MontoPagoEfectivo").val(MontoAPagar);
	// $("#NumeroTransaccionTarjeta").val(0);
	// $("#CodigoAprobacionTarjeta").val(0);
	// $("#FechaPrimeraCuota").val("01-01-2000");
	// $("#NumeroCuotasCredito").val(0);
	// $("#InteresMensualCredito").val(0);
	// $("#MontoFinalCredito").val(0);
    // $("#MontoCuotaCredito").val(0);
	
    // $("#spanTituloModalPagoEfectivo").text("Registrar Pago Tarjeta de Debito / RedBanc / Tarjeta RUT");
	// $("#ModalDetallePagoEfectivo").modal();	
	
	// $("#InfoAddTC").show();
	// $("#InfoAddCredito").hide();
	
	// $("#divBotonM_FPE").hide();
	// $("#divBotonAC_FPE").show();
	// $("#guardarFPE").text("Continuar");
    // desbloquearInputsFPE();
	
	// $('#ModalDetallePagoEfectivo').on('shown.bs.modal', function() {
		// $('#NumeroTransaccionTarjeta').focus().select();
	// });
// }

// var BotonPagoTC = function (){
	// console.log("Pago TC");
	
	// $("#IdVentaPago").val($("#IdVenta").val());
	// $("#IdFormaPago").val(2);
	
	// var  MontoAPagar = ( parseFloat($("#SaldoPago").val()) * -1);
	// $("#MontoPagoEfectivo").val(MontoAPagar);
	// $("#NumeroTransaccionTarjeta").val(0);
	// $("#CodigoAprobacionTarjeta").val(0);
	// $("#FechaPrimeraCuota").val("01-01-2000");
	// $("#NumeroCuotasCredito").val(0);
	// $("#InteresMensualCredito").val(0);
	// $("#MontoFinalCredito").val(0);
    // $("#MontoCuotaCredito").val(0);
	
    // $("#spanTituloModalPagoEfectivo").text("Registrar Pago Tarjeta de Crédito / VISA / MASTERCARD ");
	// $("#ModalDetallePagoEfectivo").modal();	
	
	// $("#InfoAddTC").show();
	// $("#InfoAddCredito").hide();
	
	// $("#divBotonM_FPE").hide();
	// $("#divBotonAC_FPE").show();
	// $("#guardarFPE").text("Continuar");
    // desbloquearInputsFPE();
	
	// $('#ModalDetallePagoEfectivo').on('shown.bs.modal', function() {
		// $('#NumeroTransaccionTarjeta').focus().select();
	// });
// }

// var BotonPagoEfectivo = function (){
	// console.log("Pago Efectivo");
	
	// $("#IdVentaPago").val($("#IdVenta").val());
	// $("#IdFormaPago").val(0);
	
	// var  MontoAPagar = ( parseFloat($("#SaldoPago").val()) * -1);
	// $("#MontoPagoEfectivo").val(MontoAPagar);
	// $("#NumeroTransaccionTarjeta").val(0);
	// $("#CodigoAprobacionTarjeta").val(0);
	// $("#FechaPrimeraCuota").val("01-01-2000");
	// $("#NumeroCuotasCredito").val(0);
	// $("#InteresMensualCredito").val(0);
	// $("#MontoFinalCredito").val(0);
    // $("#MontoCuotaCredito").val(0);
	
    // $("#spanTituloModalPagoEfectivo").text("Registrar Pago Efectivo");
	// $("#ModalDetallePagoEfectivo").modal();	
	
	// $("#InfoAddTC").hide();
	// $("#InfoAddCredito").hide();
	
	// $("#divBotonM_FPE").hide();
	// $("#divBotonAC_FPE").show();
	// $("#guardarFPE").text("Continuar");
    // desbloquearInputsFPE();
	
	// $('#ModalDetallePagoEfectivo').on('shown.bs.modal', function() {
		// $('#MontoPagoEfectivo').focus().select();
	// });
// }

// var BotonCancelarFPEe = function(){
    // $("#ModalDetallePagoEfectivo").modal("hide");
    
	// $("#divBotonM_FPE").hide();
    // $("#divBotonAC_FPE").hide();
    // $('#FormFPE')[0].reset();
    
    // bloquearInputsFPE();
// }

// var ProcesarCargaPreferencias = function(){
    // parametroAjax.ruta=rutaPVC;
    // parametroAjax.data = $("#FormFPE").serialize();
    // respuesta=procesarajax(parametroAjax);
	// console.log("Respuesta: " + respuesta);
	
    // ManejoRespuestaProcesarCargaPreferencias(respuesta);
// };

// var ManejoRespuestaProcesarCargaPreferencias = function(respuesta){	
    // if(respuesta.code==200){
        // if(respuesta.respuesta!=null){
            // if(respuesta.respuesta.IdCliente==0){
                // $("#NumeroCuotasCredito").val(6);
				// $("#InteresMensualCredito").val(2.5);
            // }else{
                // $("#NumeroCuotasCredito").val(respuesta.respuesta.v_pvc.NumeroMaxCuotas);
                // $("#InteresMensualCredito").val(respuesta.respuesta.v_pvc.InteresMensual);
            // }    
        // }else{
            // $.growl({message:"Cliente no encontrado"},{type: "warning", allow_dismiss: true,});
        // }
    // }else{
        // $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    // }
// }

// var ProcesarFPE = function(){
    // parametroAjax.ruta=rutaFP;
    // parametroAjax.data = $("#FormFPE").serialize();
    // respuesta=procesarajax(parametroAjax);
    // ManejoRespuestaProcesarFPE(respuesta);
// };

// var ManejoRespuestaProcesarFPE = function(respuesta){
    // if(respuesta.code==200){
        // var res = JSON.parse(respuesta.respuesta.f_registro);
        // switch(res.code) {
            // case '200':
                // $.growl({message:res.des_code},{type: "success", allow_dismiss: true,});
                // $("#ModalDetallePagoEfectivo").modal("hide");
				
				// $(".divBotonesC").toggle();
                // $('#IdVenta2').val("");
                // $('#FormFPE')[0].reset();
                // cargarTablaPagos(respuesta.respuesta.v_pagos);
                // break;
            // case '-2':
                // $.growl({message:res.des_code},{type: "warning", allow_dismiss: true,});
                // break;
            // default:
                // $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
                // break;
        // }
    // }else{
        // $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    // }
// }

// var BotonAgregarDetalle = function (){
    // $("#spanTituloModal").text("Registrar Detalle");
	// $("#guardar").text("Continuar");
    // $("#divBotonM").hide();
    // $("#divBotonesAC").show();
    // // $('#FormDetalle')[0].reset();
    // $("#IdDetalleVenta").val("");
    // $("#IdProducto").val("");
    // $("#CodigoBarra").val("");
    // $("#NombreProducto").val("");
    // $("#CantidadVenta").val("");
    // $("#ValorUnitarioVenta").val("");
    // $("#FactorImpuesto").val("");
    // $("#ValorImpuestos").val("");
    // $("#MontoDescuento").val("");
    // $("#ValorUnitarioFinal").val("");
    // $("#TotalLinea").val("");
    // $(".comboclear").val('').trigger("change");
    // desbloquearInputsDetalles();
// }

// var BotonCancelarDetalle = function(){
    // $("#ModalDetalleVenta").modal("hide");
    // $("#divBotonM").hide();
    // $("#divBotonesAC").hide();
    // $('#FormDetalle')[0].reset();
    // $("#IdDetalleCompra").val("");
    // $("#IdProducto").val("");
    // $(".comboclear").val('').trigger("change");
    // bloquearInputsDetalles();
// }

// var calcularSaldoPago = function(){
		// var totalPagado = parseFloat($("#TotalPagado").val());
		// var totalVendido = parseFloat($("#TotalVentaPago").val());
		// var saldoFinal = totalPagado - totalVendido;		
		// $("#SaldoPago").val(saldoFinal);
		
		// console.log("Saldo Pendiente de Pago: " + saldoFinal +" - TotalPagado: " + totalPagado + " - TotalVendido: " +totalVendido);
	// }

	// $("#NumeroCuotasCredito").change(function() {
		// calcularMontoCuotas();
    // });
	
	// $("#MontoAFinanciar").change(function() {
		// $("#MontoPagoEfectivo").val($("#MontoAFinanciar").val());
		// calcularMontoCuotas();
    // });
	
	// $("#InteresMensualCredito").change(function() {
		// calcularMontoCuotas();
    // });	
	
	// $("#TotalPagado").change(function() {
		// calcularSaldoPago();
    // });
	
	// $("#RUTClienteCredito").focusout(function() {
        // var valid = $("#RUTClienteCredito").val();
        // if (valid.length > 0){
            // var res = verificarRut($("#RUTClienteCredito"),4);
            // $("#RUTClienteCredito").val(res);
        // }else{
			// $("#ErrorRutCredito").text("");
		// }
    // });
	
	// $("#TotalVentaPago").change(function() {
		// calcularSaldoPago();
    // });
	
// var ProcesarProveedor = function(){
    // var nombre = $("#NombreFantasia2").val();
    // parametroAjax.ruta=rutaPR;
    // parametroAjax.data = $("#FormProveedorNew").serialize();
    // respuesta=procesarajax(parametroAjax);
    // ManejoRespuestaProcesarProveedor(respuesta,nombre);
// };

// var ProcesarVenta = function(){
    // if(errorRut == 0){
        // parametroAjax.ruta=ruta;
        // parametroAjax.data = $("#FormVentas").serialize();
        // respuesta=procesarajax(parametroAjax);
        // ManejoRespuestaProcesar(respuesta);
    // }
// };

// var ProcesarDetalleCompra = function(){
    // parametroAjax.ruta=rutaDV;
    // parametroAjax.data = $("#FormDetalle").serialize();
    // respuesta=procesarajax(parametroAjax);
    // ManejoRespuestaProcesarDetalles(respuesta);
// };

// var validador = function(){
	// console.log("IdVenta Antes de Validar Formulario: " + $("#IdVenta").val());
    // $('#FormVentas').formValidation('validate');
// };

// var validadorFPE = function(){
	// console.log("IdVenta Antes de Validar Formulario FormFPE: " + $("#IdVenta").val());
    // $('#FormFPE').formValidation('validate');
// };

// var validadorP = function(){
    // $('#FormProveedorNew').formValidation('validate');
// };

// var validadorI = function(){
    // $('#FormImpuesto').formValidation('validate');
// }

// var validadorD = function(){
    // $('#FormDetalle').formValidation('validate');
// };

// var cambiarEstatusVenta = function(IdVenta){
    // parametroAjax.ruta=rutaAV;
    // parametroAjax.data = {IdVenta:IdVenta};
    // respuesta=procesarajax(parametroAjax);
    // ManejoRespuestaProcesarI(respuesta);
// }

// var verDetallesVenta = function(IdVenta){
    // parametroAjax.ruta=rutaB;
    // parametroAjax.data = {IdVenta:IdVenta};
    // respuesta=procesarajax(parametroAjax);
    // ManejoRespuestaProcesarD(respuesta);
// }

// var verDetallesDetalleVenta = function(IdDetalleVenta){
    // parametroAjax.ruta=rutaBDC;
    // parametroAjax.data = {IdDetalleVenta:IdDetalleVenta};
    // respuesta=procesarajax(parametroAjax);
    // ManejoRespuestaProcesarDetalleVenta(respuesta);
// }

// var cambiarEstatusDetalleVenta = function(IdDetalleCompra){
    // parametroAjax.ruta=rutaCDA;
    // parametroAjax.data = {IdDetalleCompra:IdDetalleCompra};
    // respuesta=procesarajax(parametroAjax);
    // ManejoRespuestaProcesarCD(respuesta);
// }

// var eliminarPago = function(IdDetallePago){
	// console.log("Eliminando Pago: " + rutaEP + " - IdDetallePago: " + IdDetallePago);
    // parametroAjax.ruta=rutaEP;
    // parametroAjax.data = {IdDetallePago:IdDetallePago};
    // respuesta=procesarajax(parametroAjax);
    // ManejoRespuestaEliminarPago(respuesta);
// }

// var ManejoRespuestaEliminarPago = function(respuesta){
    
	// if(respuesta.code==200){
        // if(respuesta.respuesta!=null){
			
			// switch(respuesta.code) {
				// case '200':	
					// $.growl({message:"Pago eliminado correctamente..."},{type: "success", allow_dismiss: true,});
					// cargarTablaPagos(respuesta.respuesta.v_pagos);
					// break;
				// case '-2':
					// $.growl({message:"Error---"},{type: "warning", allow_dismiss: true,});
					// break;
				// default:
					// $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
					// break;
			// }
        // }
    // }else{
        // $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    // }

// }

// var ManejoRespuestaProcesarPagos = function(respuesta){
    // if(respuesta.code==200){
        // var res = JSON.parse(respuesta.respuesta.f_registro);
        // switch(res.code) {
            // case '200':
                // $.growl({message:res.des_code},{type: "success", allow_dismiss: true,});
                
                // $("#ModalDetallePagoEfectivo").modal("hide");
                // $('#IdDetallePago').val("");
                // $('#FormPagos')[0].reset();
				
                // cargarTablaPagos(respuesta.respuesta.v_pagos);
                // break;
            // case '-2':
                // $.growl({message:res.des_code},{type: "warning", allow_dismiss: true,});
                // break;
            // default:
                // $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
                // break;
        // }
    // }else{
        // $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    // }

// }


// var bloquearInputs = function(){
    // $("#FechaVenta").prop('readonly', true);
    // $("#RUTCliente").prop('readonly', true);
    // // $("#NombreCliente").prop('readonly', true);
// }


// var desbloquearInputs = function(){
    // $("#FechaVenta").prop('readonly', false);
    // $("#RUTCliente").prop('readonly', false);
    // // $("#NombreCliente").prop('readonly', false);
// }

// var bloquearInputsDetalles = function(){
    // $("#CodigoBarra").prop('readonly', true);
    // // $("#NombreProducto").prop('readonly', true);
    // $("#CantidadVenta").prop('readonly', true);
    // $("#ValorUnitario").prop('readonly', true);
    // // $("#FactorImpuesto").prop('readonly', true);
    // // $("#ValorImpuestos").prop('readonly', true);
    // $("#MontoDescuento").prop('readonly', true);
    // // $("#ValorUnitarioFinal").prop('readonly', true);
    // // $("#TotalLinea").prop('readonly', true);
    // $("#IdUnidadMedida").prop('disabled', true);
// }

// var desbloquearInputsDetalles = function(){
    // $("#CodigoBarra").prop('readonly', false);
    // // $("#NombreProducto").prop('readonly', false);
    // $("#CantidadVenta").prop('readonly', false);
    // $("#ValorUnitario").prop('readonly', false);
    // // $("#FactorImpuesto").prop('readonly', false);
    // // $("#ValorImpuestos").prop('readonly', false);
    // $("#MontoDescuento").prop('readonly', false);
    // // $("#ValorUnitarioFinal").prop('readonly', false);
    // // $("#TotalLinea").prop('readonly', false);
    // $("#IdUnidadMedida").prop('disabled', false);
// }

// var desbloquearInputsFPE = function(){
    // $("#MontoPagoEfectivo").prop('readonly', false);
// }

// var bloquearInputsFPE = function(){
    // $("#MontoPagoEfectivo").prop('readonly', true);
// }

// var modificarCabeceras = function(){
    // $("#spanTitulo").text("Editar Pre-Venta");
	// $("#guardar").text("Guardar");
    // $("#divVolver").hide();
    // // $(".divBotones").toggle();
    // $("#div-mod").hide();
    // $("#div-acep").show();
    // desbloquearInputs();
// }

// var modificarDetalles = function(){
    // $("#spanTituloModal").text("Editar Detalle");
    // $("#divBotonM").hide();
    // $("#divBotonesAC").show();
    // desbloquearInputsDetalles();
// }

// var volverTabs = function(){
    // $("#spanTitulo").text("");
    // $(".divDetalles").toggle();
    // $("#aCabecera").removeClass("active");
    // $("#astock").removeClass("active");
    // $("#akardex").removeClass("active");
    // $("#TabCabecera").removeClass("active");
    // $("#TabStock").removeClass("active");
    // $("#TabKardex").removeClass("active");
    // $("#TabDetalles").addClass("active");
    // $("#aDetalles").addClass("active");
// }

// var crearAllSelect = function(data){
    // // crearselect(data.v_tipo_dte,"TipoDTE");
    // // crearselect(data.v_estados,"EstadoCompra");
    // // crearselect(data.v_estados,"EstadoDetalleCompra");
    // crearselect(data.v_unidad_medida,"IdUnidadMedida");
// }


// var verificarRut = function(control,caso){
    // var res = Valida_Rut(control);
    // var format = formateaRut(control.val(), res);
    // if (format != false){
        // errorRut = 0;
        // errorRut2 = 0;
        // if (caso==1){buscarCliente(format);$("#ErrorRut").text("");}
        // if (caso==2){$("#ErrorRut2").text("");}
        // if (caso==3){buscarEmpresa(format);$("#ErrorRut3").text("");}
		// if (caso==4){buscarClienteVC(format);$("#ErrorRutCredito").text("");}
        // return format;
    // }else{
        // if (caso==1){errorRut = 1;$("#ErrorRut").text("Rut invalido");}
        // if (caso==2){errorRut2 = 1;$("#ErrorRut2").text("Rut invalido");}
        // if (caso==3){errorRut3 = 1;$("#ErrorRut3").text("Rut invalido");}
		// if (caso==4){errorRut4 = 1;$("#ErrorRutCredito").text("Rut invalido");}
        // return control.val();
    // }
// }

// var buscarCombos = function(IdLocal,IdBodega){
    // parametroAjax.ruta=rutaBC;
    // parametroAjax.data = {IdLocal:IdLocal,IdBodega:IdBodega};
    // respuesta=procesarajax(parametroAjax);
    // if(respuesta.code==200){var res = respuesta.respuesta;}
    // else{ var res= 0; }
    // return res;
// }

// var buscarProducto = function(CodigoBarra){
    // parametroAjax.ruta=rutaBPD;
    // parametroAjax.data = {CodigoBarra:CodigoBarra};
    // respuesta=procesarajax(parametroAjax);
    // ManejoRespuestaBuscarProducto(respuesta);
// }

// var buscarCliente = function(RUTCliente){
    // parametroAjax.ruta=rutaBC;
    // parametroAjax.data = {RUTCliente:RUTCliente};
    // respuesta=procesarajax(parametroAjax);
    // ManejoRespuestaBuscarCliente(respuesta);
// }

// var buscarClienteVC = function(RUTCliente){
    // parametroAjax.ruta=rutaBCC;
    // parametroAjax.data = {RUTCliente:RUTCliente};
    // respuesta=procesarajax(parametroAjax);
    // ManejoRespuestaBuscarClienteVC(respuesta);
// }

// var buscarEmpresa = function(RUTEmpresa){
    // parametroAjax.ruta=rutaBE;
    // parametroAjax.data = {RUTEmpresa:RUTEmpresa};
    // respuesta=procesarajax(parametroAjax);
    // ManejoRespuestaBuscarEmpresa(respuesta);
// }

// var buscarBodegas = function(IdLocal){
    // parametroAjax.ruta=rutaBB;
    // parametroAjax.data = {IdLocal:IdLocal};
    // respuesta=procesarajax(parametroAjax);
    // if (respuesta.code==200){
        // crearselect(respuesta.respuesta,"IdBodega");
    // }
// }

// var calcularFechaPago = function (fecha){
    // var FechaDTE = moment(fecha, 'DD-MM-YYYY',true).format("YYYY-MM-DD");
    // var FechaSuma = moment(FechaDTE).add(1, 'month').format("YYYY-MM-DD");
    // var FechaVencimiento = moment(FechaSuma, 'YYYY-MM-DD',true).format("DD-MM-YYYY");
    // $("#FechaVencimiento").val(FechaVencimiento);
    // $("#FechaPago").val(FechaVencimiento);
    // $("#FechaVencimiento").focus();
    // $("#FechaPago").focus();
    // $("#TotalNeto").focus();
// }

// var CerrarVenta = function (){
    // parametroAjax.ruta=rutaCV;
    // parametroAjax.data = {IdVenta:NVenta};
    // respuesta=procesarajax(parametroAjax);

	// $(".CerrarVenta").hide();
	// $("#agregarC").hide();
	// $.growl({message:"Venta cerrada exitosamente!!!"},{type: "success", allow_dismiss: true,});
	
    // console.log(respuesta);
    // console.log(respuesta.respuesta);
// }

// var ImprimirVenta = function (){
	
	// if(parseInt($("#IdEstadoVenta").val()) == 1){
		// CerrarVenta();
	// }
	
// }

// var RegistrarPago = function (){
	// console.log("Registrar Pago...");
// }

// var FinalizarVenta = function (){
	// console.log("Finalizar Venta...");
// }

// $(document).ready(function(){
    // $("#FechaVenta").inputmask({ mask: "99-99-9999"});
    // // $("#NombreCliente").val(now);
    // cargarTablaVentas(d.v_ventas);
    // crearAllSelect(d);
    // // $("#IdLocal").change(function() {
    // //     buscarBodegas($("#IdLocal").val());
    // // });
	
    // $("#RUTCliente").focusout(function() {
        // var valid = $("#RUTCliente").val();
        // if (valid.length > 0){
            // var res = verificarRut($("#RUTCliente"),1);
            // $("#RUTCliente").val(res);
        // }else{$("#ErrorRut").text("");}
    // });
 
    // $("#CodigoBarra").focusout(function() {
        // buscarProducto($("#CodigoBarra").val());
    // });

    // $("#CantidadVenta").focusout(function() {
        // calcularMontos($("#CantidadVenta").val(),$("#ValorUnitarioVenta").val(),$("#FactorImpuesto").val(),$("#MontoDescuento").val());
    // });

    // // Botones de cabecera de compra
    // $(document).on('click','#guardar',validador);
    // $(document).on('click','#guardarI',validadorI);
    // $(document).on('click','#aceptarM',validadorP);
    // $(document).on('click','#cancelar',BotonCancelar);
    // $(document).on('click','#agregar',BotonAgregar);
    // $(document).on('click','#modificar',modificarCabeceras);
    // $(document).on('click','#volverAct',volverTabs);
    // // Botones de detalles de compra
    // $(document).on('click','#agregarC',BotonAgregarDetalle);
    // $(document).on('click','#guardarC',validadorD);
    // $(document).on('click','#cancelarC',BotonCancelarDetalle);
    // $(document).on('click','#closeModal',BotonCancelarDetalle);
    // $(document).on('click','#modificarC',modificarDetalles);
    // $(document).on('click','#btn-list',volverListado);
    // $(document).on('click','.CerrarVenta',CerrarVenta);
	// $(document).on('click','.ImprimirVenta',ImprimirVenta);
	// $(document).on('click','.RegistrarPago',RegistrarPago);
	// $(document).on('click','.FinalizarVenta',FinalizarVenta);
	// //Botones FP
	// $(document).on('click','#pagoEfectivo',BotonPagoEfectivo);
	// $(document).on('click','#botonPagoTC',BotonPagoTC);
	// $(document).on('click','#botonPagoTD',BotonPagoTD);
	// $(document).on('click','#botonPagoCredito',BotonPagoCredito);
	
	// $(document).on('click','#guardarFPE', validadorFPE);
	
	// $(document).on('click','#botonFinalizarVenta', BotonFinalizarVenta);
	// $(document).on('click','#botonFinalizarVenta_OK', BotonFinalizarVentaOK);
	// $(document).on('click','#botonFinalizarVenta_Cancel', BotonFinalizarVentaNO);
	
	// $(document).on('click','#botonCancelarVenta', BotonCancelarVenta);
	// $(document).on('click','#botonCancelarVenta_OK', BotonCancelarVentaOK);
	// $(document).on('click','#botonCancelarVenta_Cancel', BotonCancelarVentaNO);

	// $(document).on('click','.botonAgregarPreVenta', BotonAgregarPreVenta);
	
	
    // $('#FormDetalle').on('keyup keypress', function(e) {
      // var keyCode = e.keyCode || e.which;
      // if (keyCode === 13) { 
        // e.preventDefault();
        // return false;
      // }
    // });
	
	// $('#FormFPE').on('keyup keypress', function(e) {
      // var keyCode = e.keyCode || e.which;
      // if (keyCode === 13) { 
		 // e.preventDefault();
		 // return false;
      // }
    // });

    // $('#FormVentas').formValidation({
        // excluded:[':disabled'],
        // // message: 'El módulo le falta un campo para ser completado',
        // fields: {
            // 'FechaVenta': {
                // verbose: false,
                // validators: {
                    // notEmpty: {
                        // message: 'El campo es requerido.'
                    // },
                // }
            // },
            // 'RUTCliente': {
                // verbose: false,
                // validators: {
                    // notEmpty: {
                        // message: 'El campo es requerido.'
                    // },
                // }
            // },
        // }
    // })
    // .on('success.form.fv', function(e){
        // ProcesarVenta();
    // })
    // .on('status.field.fv', function(e, data){
        // data.element.parents('.form-group').removeClass('has-success');
    // });
	
	// $('#FormFPE').formValidation({
        // excluded:[':disabled'],
        // // message: 'El módulo le falta un campo para ser completado',
        // fields: {
            // 'MontoPagoEfectivo': {
                // verbose: false,
                // validators: {
                    // notEmpty: {
                        // message: 'El campo es requerido.'
                    // },
                // }
            // },
        // }
    // })
    // .on('success.form.fv', function(e){
        // ProcesarFPE();
    // })
    // .on('status.field.fv', function(e, data){
        // data.element.parents('.form-group').removeClass('has-success');
    // });


    // $('#FormDetalle').formValidation({
        // excluded:[':disabled'],
        // // message: 'El módulo le falta un campo para ser completado',
        // fields: {
            // 'CodigoBarra': {
                // verbose: false,
                // validators: {
                    // notEmpty: {
                        // message: 'El campo es requerido.'
                    // },
                // }
            // },
            // 'IdUnidadMedida': {
                // verbose: false,
                // validators: {
                    // notEmpty: {
                        // message: 'El campo es requerido.'
                    // },
                // }
            // },
            // 'CantidadVenta': {
                // verbose: false,
                // validators: {
                    // notEmpty: {
                        // message: 'El campo es requerido.'
                    // },
                // }
            // },
            // 'ValorUnitarioVenta': {
                // verbose: false,
                // validators: {
                    // notEmpty: {
                        // message: 'El campo es requerido.'
                    // },
                // }
            // }
            // // ,
            // // 'MontoDescuento': {
            // //     verbose: false,
            // //     validators: {
            // //         notEmpty: {
            // //             message: 'El campo es requerido.'
            // //         },
            // //     }
            // // }
        // }
    // })
    // .on('success.form.fv', function(e){
        // ProcesarDetalleCompra();
    // })
    // .on('status.field.fv', function(e, data){
        // data.element.parents('.form-group').removeClass('has-success');
    // });
// });