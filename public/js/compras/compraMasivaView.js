var manejoRefresh=limpiarTablaCompraMasiva=limpiarTablaResutadoBusqueda=limpiarTablaBodegaDestino=limpiarTablaStockProducto=errorRut3=limpiarBodegas=0;

var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};

var StockProducto = function(IdProducto){
	console.log("StockProducto");
	
	parametroAjax.ruta=rutaCSP;
    parametroAjax.data = {IdProducto:IdProducto};
    respuesta=procesarajax(parametroAjax);
    cargarTablaStockProducto(respuesta.respuesta.v_stock);
	
	$("#NombreProductoStock").text("Stock del Producto: Pan con Queso...");
	$("#ModalStockProducto").modal();
	
	
}

var BotonBuscarProducto = function(){
	console.log("BotonBuscarProducto");
	
	cargarResultadoBusquedaProducto(null);
	
	$("#spanTituloModalBusquedaProducto").text("Busqueda de Producto...");
	$("#InfoProducto").val($.trim($("#NombreProducto").val()));
	$("#ModalBuscarProducto").modal();
	
	$('#ModalBuscarProducto').on('shown.bs.modal', function() {
		$('#InfoProducto').focus().select();
	});
	
	var largoTXT = $.trim($("#InfoProducto").val());
	
	if(largoTXT.length > 0) BuscarProducto();
}

var BotonBuscarCodigo = function(){
	var IdProducto = $("#CodigoBarra").val();
	CargarInfoProducto(IdProducto);
}

var BuscarProducto = function(){
	console.log("BotonBuscar");
	
	var largoTXT = $.trim($("#InfoProducto").val());
	
	if(largoTXT.length >= 4){	
		parametroAjax.ruta=rutaBPM;
		parametroAjax.data = {InfoProducto:$("#InfoProducto").val()};
		respuesta=procesarajax(parametroAjax);
		console.log("procesarajax()");
		
		ManejoRespuestaBuscarProducto(respuesta);
		
	}else{
		$.growl({message:"Debe ingresar al menos 3 caracteres para realizar la busqueda de un Producto!!!"},{type: "warning", allow_dismiss: true});
		
	}
}

var CargarInfoProducto = function(CodigoBarra){
	console.log("CargarInfoProducto");
	
    parametroAjax.ruta=rutaBPD;
    parametroAjax.data = {CodigoBarra:CodigoBarra};
    respuesta=procesarajax(parametroAjax);
	
    ManejoRespuestaCargarInfoProductos(respuesta);
}

var SelectProducto = function(IdProducto){
	
	$("#CodigoBarra").val(IdProducto);
	$("#ModalBuscarProducto").modal("hide");
	CargarInfoProducto(IdProducto);
	
	$('#CantidadProducto').focus().select();
}

var BodegaDestino = function(){
	console.log("BodegaDestino");
	
	RegistrarDetalleCompra();
	$("#IdLocal").val(0);
	$("#IdBodega").val(0);
		
	cargarTablaBodegaDestino(null);
	
	
	$("#CantidadAsignada").val($("#CantidadProducto").val());
	$("#CantidadBD").val($("#CantidadProducto").val());
	
	$("#spanTituloModalBodegaDestino").text("Asignar Productos a Bodegas...");
	$("#ModalBodegaDestino").modal();
	
	$('#ModalBodegaDestino').on('shown.bs.modal', function() {
		$('#IdLocal').focus().select();
	});
}

var BodegaDestinoDetalle = function(IdDetalleCompra){
	
	$("#IdLocal").val(0);
	$("#IdBodega").val(0);
	$("#IdDetalleCompraBD").val(IdDetalleCompra);	
	$("#IdCompraBD").val($("#IdCompra").val());
	
	parametroAjax.ruta=rutaBD;
    parametroAjax.data = {IdDetalleCompraBD:IdDetalleCompra};
    respuesta=procesarajax(parametroAjax);
    cargarTablaBodegaDestino(respuesta.respuesta.v_bodega_destino);
	
	$("#CantidadAsignada").val("");
	$("#spanTituloModalBodegaDestino").text("Asignar Productos a Bodegas...");
	$("#ModalBodegaDestino").modal();
	
	$('#ModalBodegaDestino').on('shown.bs.modal', function() {
		$('#IdLocal').focus().select();
	});
	
}

var AsignarBodegaProducto = function(){
	console.log("AsignarBodegaProducto");
	
	var largoTXT = $.trim($("#CantidadAsignada").val());
	
	if(largoTXT.length > 0){	
		$("#CantidadBD").val($("#CantidadBD").val() - $("#CantidadAsignada").val());
	
		parametroAjax.ruta=rutaRBD;
		parametroAjax.data = $("#FormAsignarBodega").serialize();
		respuesta=procesarajax(parametroAjax);

		ManejoRespuestaAsignarBodega(respuesta);
	}else{
		alert("Debe Ingresar la cantidad de Producto asignada a esta bodega!!!");
		$("#CantidadAsignada").focus();
	}
}

var RegistrarDetalleCompra = function(){
	console.log("RegistrarDetalleCompra");
	
    parametroAjax.ruta=rutaRDCM;
    parametroAjax.data = $("#FormDetalleCompra").serialize();
    respuesta=procesarajax(parametroAjax);

    ManejoRespuestaRegistroDetalleCompra(respuesta);
}

var EliminarAsignacionBodegaDestino = function(IdBodegaDestino){
	console.log("EliminarAsignacionBodegaDestino");
	
	var IdDetalleCompraBD = $("#IdDetalleCompraBD").val();
	var IdCompraBD = $("#IdCompraBD").val();
	
	$("#IdDetalleCompraBD").val();
	parametroAjax.ruta=rutaEBD;
	parametroAjax.data = {IdBodegaDestino:IdBodegaDestino, IdDetalleCompraBD:IdDetalleCompraBD, IdCompraBD:IdCompraBD}
	respuesta=procesarajax(parametroAjax);

	ManejoRespuestaAsignarBodega(respuesta);
	
}

var RegistrarCompra = function(){
	console.log("RegistrarCompra");
	$("#botonImprimirEtiqueta").removeClass("btn-lg btn btn-block");
	$("#botonImprimirEtiqueta").addClass("btn-lg btn-primary waves-effect waves-light btn-block");
	$("#botonImprimirEtiqueta").prop('disabled', false);
	
	$("#botonRegistrarCompra").prop('disabled', true);
	$("#botonRegistrarCompra").addClass("btn-lg btn btn-block");
	
	$("#cerrarBodegaDestino").text("Nuevo Ingreso");
	
}

var CerrarModalBodegaDestino = function(){
	var texto = $("#cerrarBodegaDestino").text();
	
	//if(texto=="Nuevo Ingreso"){
		console.log("Nuevo Ingreso");
		
		$("#IdProducto").val("");
		$("#NombreProducto").val("");
		$("#CodigoBarra").val("");
		$("#CantidadProducto").val("");
		$("#PrecioCosto").val("");
		$("#PrecioVenta").val("");
		$("#botonBodegaDestino").prop('disabled', false);
		
		$("#botonRegistrarCompra").prop('disabled', false);
		$("#botonRegistrarCompra").removeClass("btn-lg btn btn-block");
		$("#botonRegistrarCompra").addClass("btn-lg btn-primary waves-effect waves-light btn-block");
		
		$("#botonImprimirEtiqueta").removeClass("btn-lg btn-primary waves-effect waves-light btn-block");
		$("#botonImprimirEtiqueta").addClass("btn-lg btn btn-block");
		$("#botonImprimirEtiqueta").prop('disabled', true);
	
		$("#cerrarBodegaDestino").removeClass("btn-lg btn-success waves-effect waves-light btn-block");
		$("#cerrarBodegaDestino").addClass("btn-lg btn-danger waves-effect waves-light btn-block");
		$("#cerrarBodegaDestino").text("Cerrar");
		
		
		
		$('#NombreProducto').focus().select();		
		
	//}else{
		//console.log("Solo Cerrrar ");
	//}
}

var ManejoRespuestaAsignarBodega = function(respuesta){
		
    if(respuesta.code==200){
        if(respuesta.respuesta!=null){
								
			cargarTablaBodegaDestino(respuesta.respuesta.v_bodega_destino);
			cargarTablaCompraMasiva(respuesta.respuesta.v_detalle_compra_masiva);
			
			$("#CantidadAsignada").val($("#CantidadBD").val());
			$("#IdLocal").val("0");
			$("#IdBodega").val("0");
			
			$.growl({message:"Detalle Compra no registrado"},{type: "success", allow_dismiss: true});
			
		}else{
			$.growl({message:"Detalle Compra Registrado!!!"},{type: "warning", allow_dismiss: true});
				
        } 
	}else{
		$.growl({message:"Error al registrar detalle de compra"},{type: "danger", allow_dismiss: true});
		
    }
}

var ManejoRespuestaRegistroDetalleCompra = function(respuesta){
		
    if(respuesta.code==200){
        if(respuesta.respuesta!=null){
			var idc = $.trim($("#IdCompra").val());
			var dc = JSON.parse(respuesta.respuesta.detalle_compra);
			
			if( idc.length == 0){
				var c = JSON.parse(respuesta.respuesta.f_registro_compra);
				
				$("#IdCompra").val(c.IdCompra);
				$("#IdCompraBD").val(c.IdCompra);
				$("#IdProductoBD").val($("#IdProducto").val());
				
			}
			
			$("#IdDetalleCompraBD").val(dc.IdDetalleCompra);
			
			cargarTablaCompraMasiva(respuesta.respuesta.v_detalle_compra_masiva);
			$.growl({message:"Detalle Compra no registrado"},{type: "success", allow_dismiss: true});
			
		}else{
			$.growl({message:"Detalle Compra Registrado!!!"},{type: "warning", allow_dismiss: true});
				
        } 
	}else{
		$.growl({message:"Error al registrar detalle de compra"},{type: "danger", allow_dismiss: true});
		
    }
}

var ManejoRespuestaCargarInfoProductos = function(respuesta){
	console.log(respuesta);
    console.log(respuesta.respuesta);
	
    if(respuesta.code==200){
        if(respuesta.respuesta!=null){
			
			console.log(respuesta.respuesta.producto);
            if(respuesta.respuesta.producto.IdProducto){
				
				if(respuesta.respuesta.producto.IdProducto==0){
                    $.growl({message:"Producto no encontrado"},{type: "warning", allow_dismiss: true});
					
                }else{
                    $("#IdProducto").val(respuesta.respuesta.producto.IdProducto);
                    $("#NombreProducto").val(respuesta.respuesta.producto.NombreProducto);
                    $("#CantidadProducto").val(1);
					$("#PrecioCosto").val(respuesta.respuesta.producto.PrecioUltimaCompra);
                    $("#PrecioVenta").val(respuesta.respuesta.producto.PrecioVentaSugerido);
					$('#CantidadProducto').focus().select();
					
					$("#botonBodegaDestino").prop('disabled', false);
                }
			}else{
				$.growl({message:"Producto no encontrado"},{type: "warning", allow_dismiss: true});
				
				$("#IdProducto").val(0);
				$("#NombreProducto").val("");
				$("#CantidadProducto").val(1);
				$("#PrecioCosto").val("");
				$("#PrecioVenta").val("");
				
				$('#CodigoBarra').focus().select();
            }    
        }else{
            $.growl({message:"Producto no encontrado"},{type: "warning", allow_dismiss: true});
        }
    }
}

var ManejoRespuestaBuscarProducto = function(respuesta){
    console.log(respuesta);
    console.log(respuesta.respuesta);
    if(respuesta.code==200){
        if(respuesta.respuesta!=null){
            if(respuesta.respuesta.productos){
				cargarResultadoBusquedaProducto(respuesta.respuesta.productos);
            }    
        }else{
            $.growl({message:"Producto no encontrado"},{type: "warning", allow_dismiss: true});
        }
    }
}

var cargarTablaBodegaDestino = function(data){
    
	if(limpiarTablaBodegaDestino==1){
		destruirTabla('#tablaBodegaDestino');
		$('#tablaBodegaDestino thead').empty();
	}
	
	var columnReport = [[1],[2]];
	
	$("#tablaBodegaDestino").dataTable({
		responsive:false,
		"aLengthMenu": DataTableLengthMenu,
		"pagingType": "full_numbers",
		"language": LenguajeTabla,
		
		"bFilter": false,
		"data": data,
		"columns":[
			{"title": "Id","data": "Id",visible:0},
			{"title": "Local","data": "NombreLocal"},
			{"title": "Bodega","data": "NombreBodega",},
			{"title": "IdProducto","data": "IdProducto",visible:0},
			{"title": "Producto","data": "NombreProducto",},
			{"title": "Cantidad","data": "Cantidad" ,
						render: $.fn.dataTable.render.number( '.', ',', 2 ), 
						className: "text-right"},
			{"title": "",
				"data": "Id",
				"render": function(data, type, row, meta){
					var result = `
					<center>
					<a href="#" onclick="EliminarAsignacionBodegaDestino(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Eliminar Asignación a Bodega Stock Producto" data-original-title="Delete">
						<i class="icofont icofont-ui-delete"></i>
					</a>
					</center>`;
					return result;
				}
			},
		],
	});
	limpiarTablaBodegaDestino=1;
};

var cargarResultadoBusquedaProducto = function(data){
    if(limpiarTablaResutadoBusqueda==1){
		destruirTabla('#tablaResultadoBusquedaProducto');
		$('#tablaResultadoBusquedaProducto thead').empty();
	}
	
	var columnReport = [[1],[2]];
	
	$("#tablaResultadoBusquedaProducto").dataTable({
		responsive:false,
		"aLengthMenu": DataTableLengthMenu,
		"pagingType": "full_numbers",
		"language": LenguajeTabla,
		
		"bFilter": false,
		"data": data,
		"columns":[
			
			{"title": "Id","data": "IdProducto",visible:0},
			{"title": "Código","data": "CodigoBarra"},
			{"title": "Producto","data": "NombreProducto",},
			{"title": "Precio Costo","data": "PrecioUltimaCompra", 
						render: $.fn.dataTable.render.number( '.', ',', 2 ), 
						className: "text-right"},
			{"title": "Precio Venta","data": "PrecioVentaSugerido", 
						render: $.fn.dataTable.render.number( '.', ',', 2 ), 
						className: "text-right"},
			{"title": "",
				"data": "CodigoBarra",
				"render": function(data, type, row, meta){
					var result = `
					<center>
					
					<a href="#" onclick="SelectProducto(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Seleccionar Producto" data-original-title="Delete">
						<i class="icofont icofont-ui-check"></i>
					</a>
					</center>`;
					return result;
				}
			},
			{"title": "",
				"data": "IdProducto",
				"render": function(data, type, row, meta){
					var result = `
					<center>
					<a href="#" onclick="StockProducto(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Stock Producto" data-original-title="Delete">
						<i class="icofont icofont-search"></i>
					</a>
					
					</center>`;
					return result;
				}
			},
		],
	});
	limpiarTablaResutadoBusqueda=1;
};

var cargarTablaCompraMasiva = function(data){
    if(limpiarTablaCompraMasiva==1){
		destruirTabla('#tablaDetalleCompra');
		$('#tablaDetalleCompra thead').empty();
	}
	
	var columnReport = [[1],[2]];
	
	$("#tablaDetalleCompra").dataTable({
		responsive:false,
		"aLengthMenu": DataTableLengthMenu,
		"pagingType": "full_numbers",
		"language": LenguajeTabla,
		"paging":   false,
		"bFilter": false,
		"data": data,
		"columns":[
			{"title": "Id","data": "IdCompra",visible:0},
			{"title": "Producto","data": "NombreProducto"},
			{"title": "Cantidad","data": "CantidadComprada",
						render: $.fn.dataTable.render.number( '.', ',', 2 ), 
						className: "text-right"},
			{"title": "Precio Costo","data": "ValorUnitarioFinal",
						render: $.fn.dataTable.render.number( '.', ',', 2 ), 
						className: "text-right"},
			{"title": "Precio Venta","data": "ValorSugeridoVenta", 
						render: $.fn.dataTable.render.number( '.', ',', 2 ), 
						className: "text-right"},
			{"title": "Destino","data": "BodegaDestino"},
			{"title": "Etiquetas",
				"data": "IdDetalleCompra",
				"render": function(data, type, row, meta){
					var result = `
					<center>
					<a href="#" onclick="ImprimirEtiquetas(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Imprimir Etiquetas" data-original-title="Delete">
						<i class="icofont icofont-print"></i>
					</a>
					<a href="#" onclick="BodegaDestinoDetalle(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Bodega Destino" data-original-title="Delete">
						<i class="icofont icofont-home-search"></i>
					</a>
					</center>`;
					return result;
				},
			},
		],
	});
	limpiarTablaCompraMasiva=1;
};

var cargarTablaStockProducto = function(data){
    
	if(limpiarTablaStockProducto==1){
		destruirTabla('#tablaStockProducto');
		$('#tablaStockProducto thead').empty();
	}
	
	var columnReport = [[1],[2]];
	
	$("#tablaStockProducto").dataTable({
		responsive:false,
		"aLengthMenu": DataTableLengthMenu,
		"pagingType": "full_numbers",
		"language": LenguajeTabla,
		
		"bFilter": false,
		"data": data,
		"columns":[
			{"title": "IdSotck","data": "IdStock",visible:0},
			{"title": "Local","data": "NombreLocal"},
			{"title": "Bodega","data": "NombreBodega",},
			{"title": "Cantidad","data": "Stock" ,
						render: $.fn.dataTable.render.number( '.', ',', 2 ), 
						className: "text-right"},
		],
	});
	limpiarTablaStockProducto=1;
};




/* Funciones Antiguas */
var ProcesarProveedor = function(){
    var nombre = $("#NombreFantasia2").val();
    parametroAjax.ruta=rutaPR;
    parametroAjax.data = $("#FormProveedorNew").serialize();
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarProveedor(respuesta,nombre);
};

var ProcesarCompra = function(){
    if(errorRut == 0 && errorRut2 == 0 && errorRut3==0){
        parametroAjax.ruta=ruta;
        parametroAjax.data = $("#FormCompras").serialize();
        respuesta=procesarajax(parametroAjax);
        ManejoRespuestaProcesar(respuesta);
    }
};

var ProcesarDetalleCompra = function(){
    parametroAjax.ruta=rutaDC;
    parametroAjax.data = $("#FormDetalle").serialize();
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarDetalles(respuesta);
};

var validadorD = function(){
    $('#FormDetalle').formValidation('validate');
};

var cambiarEstatusCompra = function(IdCompra){
    parametroAjax.ruta=rutaA;
    parametroAjax.data = {IdCompra:IdCompra};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarI(respuesta);
}

var volverTabs = function(){
    $("#spanTitulo").text("");
    $(".divDetalles").toggle();
    $("#aimpuestos").removeClass("active");
    $("#astock").removeClass("active");
    $("#akardex").removeClass("active");
    $("#TabImpuestos").removeClass("active");
    $("#TabStock").removeClass("active");
    $("#TabKardex").removeClass("active");
    $("#Tabdetalles").addClass("active");
    $("#adetalles").addClass("active");
}

var crearAllSelect = function(data){
  
	crearselect(data.v_locales,"IdLocal");
}

var verificarRut = function(control,caso){
    var res = Valida_Rut(control);
    var format = formateaRut(control.val(), res);
    if (format != false){
        errorRut = 0;
        errorRut2 = 0;
        if (caso==1){buscarProveedor(format);$("#ErrorRut").text("");}
        if (caso==2){$("#ErrorRut2").text("");}
        if (caso==3){buscarEmpresa(format);$("#ErrorRut3").text("");}
        return format;
    }else{
        if (caso==1){errorRut = 1;$("#ErrorRut").text("Rut invalido");}
        if (caso==2){errorRut2 = 1;$("#ErrorRut2").text("Rut invalido");}
        if (caso==3){errorRut3 = 1;$("#ErrorRut3").text("Rut invalido");}
        return control.val();
    }
}

var buscarCombos = function(IdLocal,IdBodega){
    parametroAjax.ruta=rutaBC;
    parametroAjax.data = {IdLocal:IdLocal,IdBodega:IdBodega};
    respuesta=procesarajax(parametroAjax);
    if(respuesta.code==200){var res = respuesta.respuesta;}
    else{ var res= 0; }
    return res;
}

var buscarProveedor = function(RUTProveedor){
    parametroAjax.ruta=rutaBP;
    parametroAjax.data = {RUTProveedor:RUTProveedor};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaBuscarProveedor(respuesta);
}

var buscarEmpresa = function(RUTEmpresa){
    parametroAjax.ruta=rutaBE;
    parametroAjax.data = {RUTEmpresa:RUTEmpresa};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaBuscarEmpresa(respuesta);
}

var buscarBodegas = function(IdLocal){
    parametroAjax.ruta=rutaBB;
    parametroAjax.data = {IdLocal:IdLocal};
    respuesta=procesarajax(parametroAjax);
    if (respuesta.code==200){
        crearselect(respuesta.respuesta,"IdBodega");
    }
}

$(document).ready(function(){
    $("#botonBodegaDestino").prop('disabled', true);

    cargarTablaCompraMasiva(d.v_detalle_compra_masiva);
    crearAllSelect(d);
	
    $("#IdLocal").change(function() {
		console.log("IdLocal.change()");
        buscarBodegas($("#IdLocal").val());
    });
		
	// Botones de detalles de compra masiva
	$(document).on('click','#botonBuscarProducto', BotonBuscarProducto);
	$(document).on('click','#botonBuscar', BuscarProducto);
	$(document).on('click','#botonBuscarCodigo', BotonBuscarCodigo);
	
	
	$(document).on('click','#botonBodegaDestino', BodegaDestino);
	$(document).on('click','#botonRegistrarCompra', RegistrarCompra);
	$(document).on('click','#cerrarBodegaDestino', CerrarModalBodegaDestino);
	
	$(document).on('click','#botonAsignarProducto', AsignarBodegaProducto);
	
	$('#FormAsignarBodega').on('keyup keypress', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) { 
        e.preventDefault();
        return false;
      }
    });
	
	$('#FormDetalleCompra').on('keyup keypress', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) { 
        e.preventDefault();
        return false;
      }
    });
	
	$('#InfoProducto').on('keyup keypress', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) { 
        e.preventDefault();
		BuscarProducto();
        return false;
      }
    });
	
	$('#CodigoBarra').on('keyup keypress', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) { 
        e.preventDefault();
		BotonBuscarCodigo();
        return false;
      }
    });
	
});