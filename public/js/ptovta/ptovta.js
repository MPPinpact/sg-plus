var manejoRefresh=limpiarProductos=limpiarCajas=limpiarDetalleCaja=limpiarTablaResutadoBusqueda=limpiarTablaStockProducto=errorRut=errorRut2=errorRut3=limpiarBodegas=NVenta=0;

var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};

var BotonBuscarProducto = function(){
    console.log("BotonBuscarProducto");
    
    cargarResultadoBusquedaProducto(null);
    
    $("#spanTituloModalBusquedaProducto").text("Busqueda de Producto...");
    $("#ModalBuscarProducto").modal();
    
    $('#ModalBuscarProducto').on('shown.bs.modal', function() {
        $('#InfoProducto').focus().select();
    });
    
    var largoTXT = $.trim($("#InfoProducto").val());
    
    if(largoTXT.length > 0) BuscarProducto();
}

var BuscarProducto = function(){
    console.log("BotonBuscar");
    // console.log("Estoy pasando por aqui");
    // return;
    
    var largoTXT = $.trim($("#InfoProducto").val());
    
    if(largoTXT.length >= 4){   
        parametroAjax.ruta=rutaBPM;
        parametroAjax.data = {InfoProducto:$("#InfoProducto").val()};
        respuesta=procesarajax(parametroAjax);
        console.log("procesarajax()");
        
        ManejoRespuestaBuscarProductoPTOVTA(respuesta);
        
    }else{
        $.growl({message:"Debe ingresar al menos 3 caracteres para realizar la busqueda de un Producto!!!"},{type: "warning", allow_dismiss: true});
        
    }
}

var ManejoRespuestaBuscarProductoPTOVTA = function(respuesta){
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

var cargarResultadoBusquedaProducto = function(data){
    if(limpiarTablaResutadoBusqueda==1){
        destruirTabla('#tablaResultadoBusquedaProducto');
        $('#tablaResultadoBusquedaProducto thead').empty();
    }
    
    var columnReport = [[1],[2]];
    
    $("#tablaResultadoBusquedaProducto").dataTable({
        responsive:true,
        "aLengthMenu": [[5],[5]],
        "pagingType": "full_numbers",
        "searching": false,
        "scrollCollapse": false,
        "lengthChange": false, 
        "language": LenguajeTabla,
        "bFilter": false,
        "data": data,
        "columns":[
            
            {"title": "Id","data": "IdProducto",visible:0},
            {"title": "Código","data": "CodigoBarra"},
            {"title": "Producto","data": "NombreProducto",},
            {"title": "Precio Venta","data": "PrecioVentaSugerido", 
                        render: $.fn.dataTable.render.number( '.', ',', 2 ), 
                        className: "text-right"},
            {"title": "Stock Total","data": "StockActual", 
                        render: $.fn.dataTable.render.number( '.', ',', 2 ), 
                        className: "text-right"},
            {"title": "Ver Stock",
                "data": null,
                "render": function(data, type, row, meta){
                    var result = `
                    <center>
                    <a href="#" onclick="StockProducto(`+data.IdProducto+`,'`+data.NombreProducto+`');" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Stock Producto" data-original-title="Delete">
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

var cargarTablaStockProducto = function(data){
    
    if(limpiarTablaStockProducto==1){
        destruirTabla('#tablaStockProducto');
        $('#tablaStockProducto thead').empty();
    }
        
    $("#tablaStockProducto").dataTable({
        responsive:false,
        "aLengthMenu": [[5],[5]],
        "pagingType": "full_numbers",
        "language": LenguajeTabla,
        "lengthChange": false, 
        "bFilter": false,
        "scrollCollapse": false,
        
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

var StockProducto = function(IdProducto,NombreProducto){
    console.log("Estoy 1111");
    console.log("StockProducto");

    parametroAjax.ruta=rutaCSP;
    parametroAjax.data = {IdProducto:IdProducto};
    respuesta=procesarajax(parametroAjax);
    cargarTablaStockProducto(respuesta.respuesta.v_stock);
    
    $("#NombreProductoStock").text("Stock del Producto: "+NombreProducto);
    $("#ModalStockProducto").modal();   
}

var ConsultaCreditoCliente = function(){
    $("#bontonEstadoCliente").hide();
	$("#spanTituloModalCreditoCliente").text("Consulta Crédito Interno de Clientes");
    $("#ModalConsultaCreditoCliente").modal();

    $('#ModalConsultaCreditoCliente').on('shown.bs.modal', function() {
        $('#RUTClienteConsultaCredito').focus().select();
    });
}

var PagoCreditoCliente = function(){
    $("#IdCajaPC").val(_idCaja_);

	$("#spanTituloModalPagoCredito").text("Pago/Abono Crédito Interno de Cliente");
    $("#ModalPagoCreditoCliente").modal();

    $('#ModalPagoCreditoCliente').on('shown.bs.modal', function() {
        $('#RUTClientePagoCredito').focus().select();
    });
}

var ManejoRespuestaProcesarD = function(respuesta){
    if(respuesta.code==200){
        cargarDetalleCajaDiaria(respuesta.respuesta);
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

var ManejoRespuestaProcesarPagarCuenta = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta.code==200){
            $("#ModalPagoCreditoCliente").modal("hide");
            $("#IdClientePagoCredito").val("");
            $("#RUTClientePagoCredito").val("");
            $("#NombreClientePagoCredito").val("");
            $("#MontoFacturadoPagoCredito").val("");
            $("#FechaVencimientoPagoCredito").val("");
            $("#DeudaTotalPagoCredito").val("");
            $("#MontoAPagarPagoCredito").val("");
            $("#IdFormaPagoCredito").val("").trigger("change");
            $.growl({message:respuesta.respuesta.des_code},{type: "success", allow_dismiss: true,});
        }else{
            $.growl({message:respuesta.respuesta.des_code},{type: "warning", allow_dismiss: true,});
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

var ManejoRespuestaBuscarProducto = function(respuesta){
    if(respuesta.code==200){
        if (respuesta.respuesta.Existe == 0){ $.growl({message:"Código de producto no encontrado"},{type: "warning", allow_dismiss: true,}); }
        if (respuesta.respuesta.v_stock){
            var v_stock = [];
            if (respuesta.respuesta.v_stock.length == 0){
                $("#NombreProductoConsulta").text("")
                $.growl({message:"Producto sin stock"},{type: "warning", allow_dismiss: true,});
            }
            if (respuesta.respuesta.v_stock.length > 0){
                $("#NombreProductoConsulta").text(respuesta.respuesta.v_stock[0].NombreProducto);
                v_stock = respuesta.respuesta.v_stock;
            }
            cargarTablaProductos(v_stock);
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

var ManejoRespuestaBuscarClienteDC = function(respuesta,caso){
    if(respuesta.code==200){
        var cliente = respuesta.respuesta.v_cliente.cliente;
        if (cliente.length > 0){
            //Caso consulta credito
            if (caso == 1){
                limpiarDatosCreditoClientes();
                $("#IdClienteConsultaCredito").val(cliente[0].IdCliente);
                $("#NombreClienteConsultaCredito").val(cliente[0].NombreCliente);
                $("#CreditoAutorizadoConsultaCredito").val(cliente[0].CupoAutorizado);
                $("#CreditoUtilizadoConsultaCredito").val(cliente[0].CupoUtilizado);
                var disp = (parseInt(cliente[0].CupoAutorizado)-parseInt(cliente[0].CupoUtilizado));
                $("#CreditoDisponibleConsultaCredito").val(disp);
                if (respuesta.respuesta.v_cliente.UltimaCompra.length > 0){
                    $("#UltimaCompraConsultaCredito").val(respuesta.respuesta.v_cliente.UltimaCompra[0].TotalVenta);
                }
                if (respuesta.respuesta.v_cliente.UltimoPago.length > 0){
                    $("#UltimoPagoConsultaCredito").val(respuesta.respuesta.v_cliente.UltimoPago[0].MontoAbono);
                }
                if (respuesta.respuesta.v_cliente.MontoAnterior.length > 0){
                    $("#UltimoMontoFacturadoConsultaCredito").val(respuesta.respuesta.v_cliente.MontoAnterior[0].MontoFacturadoAnterior);
                }
                $("#EstadoClienteConsultaCredito").val(cliente[0].DetalleEstadoCliente);

                $("#bontonEstadoCliente").text(cliente[0].DetalleEstadoCliente);
                if(cliente[0].EstadoCliente==1) {
                    $("#bontonEstadoCliente").removeClass("btn-danger");
                    $("#bontonEstadoCliente").addClass("btn-success");
                }else if(cliente[0].EstadoCliente==2) {
                    $("#bontonEstadoCliente").removeClass("btn-success");
                    $("#bontonEstadoCliente").addClass("btn-danger");
                }

                $("#bontonEstadoCliente").show();

            }
            //Caso pago Credito  UltimoMontoFacturadoConsultaCredito
            if (caso == 2){ 
                $("#IdClientePagoCredito").val(cliente[0].IdCliente);
                $("#NombreClientePagoCredito").val(cliente[0].NombreCliente);
                // if (respuesta.respuesta.v_cliente.MontoActual.length > 0){
                //     $("#MontoFacturadoPagoCredito").val(respuesta.respuesta.v_cliente.MontoActual[0].MontoFacturadoActual);
                // }
                if (respuesta.respuesta.v_cliente.MontoAnterior.length > 0){
                    $("#MontoFacturadoPagoCredito").val(respuesta.respuesta.v_cliente.MontoAnterior[0].MontoFacturadoAnterior);
                }
                if (respuesta.respuesta.v_cliente.FechaVencimiento.length > 0){
                    $("#FechaVencimientoPagoCredito").val(respuesta.respuesta.v_cliente.FechaVencimiento[0].FechaVencimiento);
                }
                if (respuesta.respuesta.v_cliente.DeudaTotal.length > 0){
                    $("#DeudaTotalPagoCredito").val(respuesta.respuesta.v_cliente.DeudaTotal[0].CupoUtilizado);
                }
            }

        }else{
            $.growl({message:"Cliente no encontrado"},{type: "warning", allow_dismiss: true,});
            if (caso == 1){
                $(".ConsultaCreditoCliente").val("");
            }
            if (caso == 2){
                $(".PagoCreditoM").val("");
                $("#IdFormaPagoCredito").val("").trigger("change");
            }
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

var cargarTablaProductos = function(data){
    
    if(limpiarProductos==1){
        destruirTabla('#listado_productos_preventa');
        $('#listado_productos_preventa thead').empty();
    }

    $("#listado_productos_preventa").dataTable({
        responsive:false,
        'bSort': false,
        "scrollCollapse": false,
        "lengthChange": false, 
        "searching": false,
        "aLengthMenu": [[5],[5]],
        "pagingType": "full_numbers",
        "language": LenguajeTabla,
        "columnDefs": [
            {"sWidth": "1px", "aTargets": [1]},
        ],
        "data": data,
        "columns":[
            {"title": "Ubicación","data": "LocalBodega"},
            {"title": "Stock","data": "Stock"},
            {"title": "Precio","data": "PrecioVentaSugerido"},
        ],
    });
    limpiarProductos=1;
}

var pintarDatosCreditoClientes = function(data){
    console.log("pintarDatosCreditoClientes()");

    $("#IdClienteConsultaCredito").val(data.IdCliente);
    $("#NombreClienteConsultaCredito").val(data.NombreCliente);
    $("#CreditoAutorizadoConsultaCredito").val(data.CupoAutorizado);
    $("#CreditoUtilizadoConsultaCredito").val(data.CupoUtilizado);
    var disponible = (parseInt(data.CupoAutorizado)-parseInt(data.CupoUtilizado));
    $("#CreditoDisponibleConsultaCredito").val(disponible);
    $("#UltimaCompraConsultaCredito").val("");
    $("#UltimoPagoConsultaCredito").val("");
    $("#UltimoMontoFacturadoConsultaCredito").val("");
    $("#EstadoClienteConsultaCredito").val(data.DetalleEstadoCliente);

    $("#bontonEstadoCliente").text(data.DetalleEstadoCliente);
    $("#bontonEstadoCliente").show();
}

var limpiarDatosCreditoClientes = function(){
    $("#IdClienteConsultaCredito").val("");
    $("#NombreClienteConsultaCredito").val("");
    $("#CreditoAutorizadoConsultaCredito").val("");
    $("#CreditoUtilizadoConsultaCredito").val("");
    $("#CreditoDisponibleConsultaCredito").val("");
    $("#UltimaCompraConsultaCredito").val("");
    $("#UltimoPagoConsultaCredito").val("");
    $("#UltimoMontoFacturadoConsultaCredito").val("");
    $("#EstadoClienteConsultaCredito").val("");   
    $("#bontonEstadoCliente").text("");

}

var pintarDatosPagoCreditoClientes = function(data){
    $("#IdClientePagoCredito").val(data.IdCliente);
    $("#NombreClientePagoCredito").val(data.NombreCliente);
    $("#MontoFacturadoClientePagoCredito").val(200);
    $("#FechaVencimientoClientePagoCredito").val('30-04-2018');
    $("#DeudaTotalClientePagoCredito").val(250);
    // $("#MontoClientePagoCredito").val(250);
    // $("#IdFormaPagoCredito").val("").trigger("change");
}

var limpiarDatospagoCreditoClientes = function(){
    $("#IdClientePagoCredito").val("");
    $("#NombreClientePagoCredito").val("");
    $("#MontoFacturadoClientePagoCredito").val("");
    $("#FechaVencimientoClientePagoCredito").val("");
    $("#DeudaTotalClientePagoCredito").val("");
    $("#MontoClientePagoCredito").val("");
    $("#IdFormaPagoCredito").val("").trigger("change");
}

var BotonPagarCuenta = function(){ 
    if(errorRutPagoCuenta == 0){
        parametroAjax.ruta=rutaPC;
        parametroAjax.data = $("#FormPagoCredito").serialize();
        respuesta=procesarajax(parametroAjax);
        ManejoRespuestaProcesarPagarCuenta(respuesta);
    }
};


var validatePC = function(){
    $('#FormPagoCredito').formValidation('validate');
};


var verDetallesCajaDiaria = function(IdCaja){
    parametroAjax.ruta=rutaB;
    parametroAjax.data = {IdCaja:IdCaja};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarD(respuesta);
}

var crearAllSelect = function(data){
    crearselect(data.v_formas_pago,"IdFormaPagoCredito");
}

var cargarInfoCajaDiaria = function(info){
	console.log("IdCaja: " + info.IdCaja);
	_idCaja_  = info.IdCaja;
}


var verificarRutC = function(control,caso){
    var res = Valida_Rut(control);
    var format = formateaRut(control.val(), res);
    if (format != false){
        errorRut = 0;
        errorRutPagoCuenta = 0;
        if (caso==1){buscarClienteDC(format,1);$("#ErrorRutConsultaCredito").text("");}
        if (caso==2){buscarClienteDC(format,2);$("#RUTClientePagoCredito").text("");}
        if (caso==3){buscarEmpresa(format);$("#ErrorRut3").text("");}
		if (caso==4){buscarClienteVC(format);$("#ErrorRutCredito").text("");}
        return format;
    }else{
        if (caso==1){errorRut = 1;$("#ErrorRutConsultaCredito").text("Rut invalido");limpiarDatosCreditoClientes();}
        if (caso==2){errorRutPagoCuenta = 1;$("#ErrorRutPagoCredito").text("Rut invalido");limpiarDatosCreditoClientes();}
        if (caso==3){errorRut3 = 1;$("#ErrorRut3").text("Rut invalido");}
		if (caso==4){errorRut4 = 1;$("#ErrorRutCredito").text("Rut invalido");}
        return control.val();
    }
}

var buscarClienteDC = function(RUTCliente,Caso){
    parametroAjax.ruta=rutaBC;
    parametroAjax.data = {RUTCliente:RUTCliente,Caso:Caso};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaBuscarClienteDC(respuesta,Caso);
}

var BotonCancelarPago = function(){
    $('#FormPagoCredito')[0].reset();
}

var CerrarConsultaPago = function(){
    $('#FormConsultaCredito')[0].reset();
}

var CerrarPagoCredito = function(){
    $('#FormPagoCredito')[0].reset();
}

// var botonConsultarStockProducto = function(){
//     var VarCodigoProducto = $("#CodigoProductoConsultaCredito").val();
//     if (VarCodigoProducto.length > 1){
//         parametroAjax.ruta=rutaBP;
//         parametroAjax.data = {CodigoProducto:VarCodigoProducto};
//         respuesta=procesarajax(parametroAjax);
//         ManejoRespuestaBuscarProducto(respuesta); 
//     }else{
//         $.growl({message:"Ingrese Codigo  de producto "},{type: "warning", allow_dismiss: true,});
//     }
// }

var botonConsultarStockProducto = function(){
    console.log("BotonBuscar");
    var largoTXT = $.trim($("#CodigoProductoConsultaCredito").val());
    if(largoTXT.length >= 4){   
        parametroAjax.ruta=rutaBP;
        parametroAjax.data = {InfoProducto:$("#CodigoProductoConsultaCredito").val()};
        respuesta=procesarajax(parametroAjax);
        console.log("procesarajax()");
        ManejoRespuestaBuscarProducto(respuesta);
    }else{
        $.growl({message:"Debe ingresar al menos 3 caracteres para realizar la busqueda de un Producto!!!"},{type: "warning", allow_dismiss: true});
    }
}

var botonCerrarStockProducto = function(){
    $("#CodigoProductoConsultaCredito").val("");
    // destruirTabla('#listado_productos_preventa');$('#listado_productos_preventa thead').empty();
    if(limpiarProductos==1){destruirTabla('#tablaLocales');$('#tablaLocales thead').empty();limpiarProductos=0;}
    $("#NombreProductoConsulta").text("");
}

$(document).ready(function(){   
    $("#FechaVencimientoClientePagoCredito").inputmask({ mask: "99-99-9999"});
    $("#RUTClienteConsultaCredito").focusout(function() {
        var valid = $("#RUTClienteConsultaCredito").val();
        if (valid.length > 0){
            var res = verificarRutC($("#RUTClienteConsultaCredito"),1);
            $("#RUTClienteConsultaCredito").val(res);
        }else{$("#ErrorRutConsultaCredito").text("");}
    });
    $("#RUTClientePagoCredito").focusout(function() {
        var valid = $("#RUTClientePagoCredito").val();
        if (valid.length > 0){
            var res = verificarRutC($("#RUTClientePagoCredito"),2);
            $("#RUTClientePagoCredito").val(res);
        }else{$("#ErrorRutPagoCredito").text("");}
    });
    
    crearAllSelect(d);
    // Botones de cabecera de compra
    $(document).on('click','#botonConsultaCredito', ConsultaCreditoCliente);
    $(document).on('click','#botonPagoCredito', PagoCreditoCliente);
    $(document).on('click','#botonCanelarPago',BotonCancelarPago);
    $(document).on('click','#botonPagarCuenta',validatePC);
    $(document).on('click','#cancelarFPE',CerrarConsultaPago);
    $(document).on('click','#botonCanelarPago',CerrarPagoCredito);
    $(document).on('click','#botonConsultarStockProducto',botonConsultarStockProducto);
    $(document).on('click','#cancelarBPS',botonCerrarStockProducto);

    $(document).on('click','#botonConsultaProducto',BotonBuscarProducto);
    $(document).on('click','#botonBuscar',BuscarProducto);
    
	
    $('#InfoProducto').on('keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) { 
            console.log("Enter " + e.target.name + " | e.type:" + e.type + " - e.which: " + e.which+ " - e.keyCode: " + e.keyCode + "...");
            e.preventDefault();

            BuscarProducto();
            return false;
        }
    });

    $('#FormPagoCredito').formValidation({
        excluded:[':disabled'],
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'RUTClientePagoCredito': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'MontoAPagarPagoCredito': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'IdFormaPagoCredito': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },                                      
        }
    })
    .on('success.form.fv', function(e){
        BotonPagarCuenta();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});
