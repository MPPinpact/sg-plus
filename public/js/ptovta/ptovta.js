var manejoRefresh=limpiarProductos=limpiarCajas=limpiarDetalleCaja=errorRut=errorRut2=errorRut3=limpiarBodegas=NVenta=0;

var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};

var ConsultaCreditoCliente = function(){
	$("#spanTituloModalCreditoCliente").text("Consulta Crédito Interno de Clientes");
    $("#ModalConsultaCreditoCliente").modal();
}

var PagoCreditoCliente = function(){
	$("#spanTituloModalPagoCredito").text("Pago/Abono Crédito Interno de Cliente");
    $("#ModalPagoCreditoCliente").modal();
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
        $("#ModalPagoCreditoCliente").modal("hide");
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

var ManejoRespuestaBuscarProducto = function(respuesta){
    if(respuesta.code==200){
        if (respuesta.respuesta.Existe == 0){ $.growl({message:"Código de producto no encontrado"},{type: "warning", allow_dismiss: true,}); }
        respuesta.respuesta.v_stock ? $("#NombreProductoConsulta").text(respuesta.respuesta.v_stock[0].NombreProducto) : $("#NombreProductoConsulta").text("") 
        cargarTablaProductos(respuesta.respuesta.v_stock);
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}


var ManejoRespuestaBuscarClienteDC = function(respuesta,caso){
    if(respuesta.code==200){
        var cliente = respuesta.respuesta.v_cliente;
        if (cliente.length > 0){
            if (caso == 1){
                $("#IdClienteConsultaCredito").val(cliente[0].IdCliente);
                $("#NombreClienteConsultaCredito").val(cliente[0].NombreCliente);
                $("#CreditoAutorizadoConsultaCredito").val(cliente[0].CupoAutorizado);
                $("#CreditoUtilizadoConsultaCredito").val(cliente[0].CupoUtilizado);
                var disp = (parseInt(cliente[0].CupoAutorizado)-parseInt(cliente[0].CupoUtilizado));
                $("#CreditoDisponibleConsultaCredito").val(disp);
                // $("#UltimaCompraConsultaCredito").val(c.);
                // $("#UltimoPagoConsultaCredito").val(c.);
                // $("#UltimoMontoFacturadoConsultaCredito").val(c.);
                $("#EstadoClienteConsultaCredito").val(cliente[0].DetalleEstadoCliente);
            }
            if (caso == 2){
                $("#IdClientePagoCredito").val(cliente[0].IdCliente);
                $("#NombreClientePagoCredito").val(cliente[0].NombreCliente);
                $("#MontoFacturadoPagoCredito").val("");
                $("#FechaVencimientoPagoCredito").val("");
                $("#DeudaTotalPagoCredito").val("");
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
    if(limpiarProductos==1){destruirTabla('#listado_productos_preventa');$('#listado_productos_preventa thead').empty();}
    $("#listado_productos_preventa").dataTable({
        responsive:false,
        'bSort': false,
        "scrollCollapse": false,
        "paging": false,
        "searching": false,
        "aLengthMenu": DataTableLengthMenu,
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

var botonConsultarStockProducto = function(){
    var VarCodigoProducto = $("#CodigoProductoConsultaCredito").val();
    if (VarCodigoProducto.length > 1){
        parametroAjax.ruta=rutaBP;
        parametroAjax.data = {CodigoProducto:VarCodigoProducto};
        respuesta=procesarajax(parametroAjax);
        ManejoRespuestaBuscarProducto(respuesta); 
    }else{
        $.growl({message:"Ingrese Codigo  de producto "},{type: "warning", allow_dismiss: true,});
    }
}

var botonCerrarStockProducto = function(){
    $("#CodigoProductoConsultaCredito").val("");
    destruirTabla('#listado_productos_preventa');$('#listado_productos_preventa thead').empty();
    $("#NombreProductoConsulta").text("");
    limpiarProductos=0;
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

    // $(document).on('click','#modificar',modificarCabeceras);
    // $(document).on('click','#volverAct',volverTabs);
    $('#FormPagoCredito').formValidation({
        excluded:[':disabled'],
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'MontoClientePagoCredito': {
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
