var manejoRefresh=limpiarLocales=limpiarCajas=limpiarDetalleCaja=errorRut=errorRut2=errorRut3=limpiarBodegas=NVenta=0;

var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};

$(document).ready(function(){	
	// Botones de cabecera de compra
    $(document).on('click','#botonConsultaCredito', ConsultaCreditoCliente);
    $(document).on('click','#botonPagoCredito', PagoCreditoCliente);
    // $(document).on('click','#cancelar',BotonCancelar);
    // $(document).on('click','#agregar',BotonAgregar);
    // $(document).on('click','#modificar',modificarCabeceras);
    // $(document).on('click','#volverAct',volverTabs);
});


var ConsultaCreditoCliente = function(){
    
	$("#spanTituloModalCreditoCliente").text("Consulta Crédito Interno de Clientes");
    $("#ModalConsultaCreditoCliente").modal();
}

var PagoCreditoCliente = function(){
    
	$("#spanTituloModalPagoCredito").text("Pago/Abono Crédito Interno de Cliente");
    $("#ModalPagoCreditoCliente").modal();
}

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

var ManejoRespuestaProcesarD = function(respuesta){
    if(respuesta.code==200){
        cargarDetalleCajaDiaria(respuesta.respuesta);
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

var ManejoRespuestaProcesarPagarCuenta = function(respuesta){
    console.log(respuesta);
    console.log(respuesta.respuesta);
    if(respuesta.code==200){
        $("#ModalPagoCreditoCliente").modal("hide");
        
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
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


var verificarRut = function(control,caso){
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
    ManejoRespuestaBuscarClienteDC(respuesta);
}

$(document).ready(function(){   
    $("#FechaVencimientoClientePagoCredito").inputmask({ mask: "99-99-9999"});
    $("#RUTClienteConsultaCredito").focusout(function() {
        var valid = $("#RUTClienteConsultaCredito").val();
        if (valid.length > 0){
            var res = verificarRut($("#RUTClienteConsultaCredito"),1);
            $("#RUTClienteConsultaCredito").val(res);
        }else{$("#ErrorRutConsultaCredito").text("");}
    });
    $("#RUTClientePagoCredito").focusout(function() {
        var valid = $("#RUTClientePagoCredito").val();
        if (valid.length > 0){
            var res = verificarRut($("#RUTClientePagoCredito"),2);
            $("#RUTClientePagoCredito").val(res);
        }else{$("#ErrorRutPagoCredito").text("");}
    });
    crearAllSelect(d);
    // Botones de cabecera de compra
    $(document).on('click','#botonConsultaCredito', ConsultaCreditoCliente);
    $(document).on('click','#botonPagoCredito', PagoCreditoCliente);
    $(document).on('click','#botonCanelarPago',BotonCancelarPago);
    $(document).on('click','#botonPagarCuenta',validatePC);
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
