var RegistroEmpresas  = '';
var manejoRefresh=limpiarLocales=errorRut=limpiarBodegas=limpiarMovimientos=limpiarEECC=limpiarMovimientosA=limpiarMovimientosP=0;

var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};

var ManejoRespuestaProcesarD = function(respuesta){
    console.log(respuesta);
    console.log(respuesta.respuesta);
    if(respuesta.code==200){
        $(".divDetalles").toggle();
        $("#divVolver").show();
        $("#spanTitulo").text("Detalles");
        bloquearInuts();
        pintarDatosActualizar(respuesta.respuesta.v_detalles[0]);
        cargarTablaMovimientos(respuesta.respuesta.v_movimientos);
        cargarTablaMovimientosActual(respuesta.respuesta.v_movimientos_ultimo_eecc);
        cargarTablaMovimientosProximo(respuesta.respuesta.v_movimientos_proximo_eecc);
        cargarTablaEECC(respuesta.respuesta.v_eecc);

    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }

}
// Manejo Activar / Desactivar cliente
var ManejoRespuestaProcesarI = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta.activar>0){
            if(respuesta.respuesta.v_clientes.length>0){
                $.growl({message:"Procesado"},{type: "success", allow_dismiss: true,});
                cargarTablaClientes(respuesta.respuesta.v_clientes);
            }
        }else{
            $.growl({message:"Debe seleccionar un registro"},{type: "warning", allow_dismiss: true,});
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

// Manejo Registro o actualizacion de cliente
var ManejoRespuestaProcesar = function(respuesta){
    if(respuesta.code==200){
        var res = JSON.parse(respuesta.respuesta.f_registro);
        switch(res.code) {
            case '200':
                $.growl({message:res.des_code},{type: "success", allow_dismiss: true,});
                $(".divDetalles").toggle();
                $(".divBotones").toggle();
                $('#FormCliente')[0].reset();
                $('#IdCliente').val("");
                cargarTablaClientes(respuesta.respuesta.v_clientes);
                break;
            case '-2':
                $.growl({message:res.des_code},{type: "warning", allow_dismiss: true,});
                break;
            default:
                $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
                break;
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
};

var cargarTablaClientes = function(data){
    console.log(data);
    if(limpiarLocales==1){
        destruirTabla('#tablaClientes');
        $('#tablaClientes thead').empty();
    }

        $("#tablaClientes").dataTable({
            responsive:false,
            "aLengthMenu": DataTableLengthMenu,
            "pagingType": "full_numbers",
            "language": LenguajeTabla,
            "columnDefs": [
                {"targets": [ 1 ],"searchable": true},
            ],
            "data": data,
            "columns":[
                {
                    "title": "",
                    "data": "IdCliente",
                    "render": function(data, type, row, meta){
                        var result = `
                        <center>
                        <a href="#" onclick="verDetallesCliente(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Detalles" data-original-title="Detalle">
                            <i class="icofont icofont-search"></i>
                        </a>
                        <a href="#" onclick="cambiarEstatusCliente(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
                            <i class="icofont icofont-ui-delete"></i>
                        </a>
                        </center>`;
                        return result;
                    }
                },
                {"title": "Id","data": "IdCliente",visible:0},
                {"title": "RUT Cliente","data": "RUTCliente"},
                {"title": "Nombre Cliente","data": "NombreCliente"},
                {"title": "Dia de Pago","data": "DiaPago"},
                {"title": "Cupo Autorizado","data": "CupoAutorizado",
                             render: $.fn.dataTable.render.number( '.', ',', 0 ),
                            className: "text-center"},
                {"title": "Cupo Utilizado","data": "CupoUtilizado",
                             render: $.fn.dataTable.render.number( '.', ',', 0 ),
                            className: "text-center"},
                // {"title": "Monto Facturado","data": "MontoUltimaFacturacion", 
                //             render: $.fn.dataTable.render.number( '.', ',', 0 ),
                //             className: "text-center"},
                // {"title": "Saldo Facturación","data": "SaldoAnteriorUF",
                //             render: $.fn.dataTable.render.number( '.', ',', 0 ),
                //             className: "text-center"},
                {"title": "Estado Cliente","data": "DetalleEstadoCliente"}
            ],
        });
        limpiarLocales=1;
};

var cargarTablaMovimientos = function(data){
    if(limpiarMovimientos==1){
        destruirTabla('#tablaClientesMovimientos');
        $('#tablaClientesMovimientos thead').empty();
    }

        $("#tablaClientesMovimientos").dataTable({
            responsive:false,
            "aLengthMenu": DataTableLengthMenu,
            "pagingType": "full_numbers",
            "language": LenguajeTabla,
            "columnDefs": [
                {"targets": [ 1 ],"searchable": true},
                {"sWidth": "1px", "aTargets": [6]}
            ],
            "data": data,
            "columns":[
                {"title": "Id","data": "IdMovimiento",visible:0},
                {
                    "title": "Fecha Movimiento", 
                    "data": "FechaMovimiento",
                    "render": function(data, type, row, meta){
                        if(type === 'display'){
                            data = moment(data, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY");
                        }
                        return data;
                    }
                },
                {
                    "title": "Fecha Vencimiento", 
                    "data": "FechaVencimiento",
                    "render": function(data, type, row, meta){
                        if(type === 'display'){
                            data = moment(data, 'YYYY-MM-DD',true).format("DD-MM-YYYY");
                        }
                        return data;
                    }
                },                
                {"title": "Tipo Movimiento","data": "TipoMovimiento"},
                {"title": "N° Documento","data": "NumeroDocumento"},
                {"title": "Descripción","data": "DescripcionMovimiento"},
                {"title": "Monto","data": "MontoMovimiento"}
            ],
        });
        limpiarMovimientos=1;
};

var cargarTablaMovimientosProximo = function(data){
    if(limpiarMovimientosP==1){
        destruirTabla('#tablaProximaFacturacion');
        $('#tablaProximaFacturacion thead').empty();
    }

        $("#tablaProximaFacturacion").dataTable({
            responsive:false,
            "aLengthMenu": DataTableLengthMenu,
            "pagingType": "full_numbers",
            "language": LenguajeTabla,
            "columnDefs": [
                {"targets": [ 1 ],"searchable": true},
                {"sWidth": "1px", "aTargets": [6]}
            ],
            "data": data,
            "columns":[
                {"title": "Id","data": "IdMovimiento",visible:0},
                {
                    "title": "Fecha Movimiento", 
                    "data": "FechaMovimiento",
                    "render": function(data, type, row, meta){
                        if(type === 'display'){
                            data = moment(data, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY");
                        }
                        return data;
                    }
                },
                {
                    "title": "Fecha Vencimiento", 
                    "data": "FechaVencimiento",
                    "render": function(data, type, row, meta){
                        if(type === 'display'){
                            data = moment(data, 'YYYY-MM-DD',true).format("DD-MM-YYYY");
                        }
                        return data;
                    }
                },                
                {"title": "Tipo Movimiento","data": "TipoMovimiento"},
                {"title": "N° Documento","data": "NumeroDocumento"},
                {"title": "Descripción","data": "DescripcionMovimiento"},
                {"title": "Monto","data": "MontoMovimiento"}
            ],
        });
        limpiarMovimientosP=1;
};

var cargarTablaMovimientosActual = function(data){
    if(limpiarMovimientosA==1){
        destruirTabla('#tablaFacturacionActual');
        $('#tablaFacturacionActual thead').empty();
    }

        $("#tablaFacturacionActual").dataTable({
            responsive:false,
            "aLengthMenu": DataTableLengthMenu,
            "pagingType": "full_numbers",
            "language": LenguajeTabla,
            "columnDefs": [
                {"targets": [ 1 ],"searchable": true},
                {"sWidth": "1px", "aTargets": [5]}
            ],
            "data": data,
            "columns":[
                {"title": "Id","data": "IdMovimiento",visible:0},
                {"title": "Fecha Movimiento", 
                    "data": "FechaMovimiento",
                    "render": function(data, type, row, meta){
                        if(type === 'display'){
                            data = moment(data, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY");
                        }
                        return data;
                    }
                },
                {"title": "Tipo Movimiento","data": "TipoMovimiento"},
                {"title": "N° Documento","data": "NumeroDocumento"},
                {"title": "Descripción","data": "DescripcionMovimiento"},
                {"title": "Monto","data": "MontoMovimiento"}
            ],
        });
        limpiarMovimientosA=1;
};

var cargarTablaEECC = function(data){
    if(limpiarEECC==1){
        destruirTabla('#tablaClientesEECC');
        $('#tablaClientesEECC thead').empty();
    }

        $("#tablaClientesEECC").dataTable({
            responsive:false,
            "aLengthMenu": DataTableLengthMenu,
            "pagingType": "full_numbers",
            "language": LenguajeTabla,
            "columnDefs": [
                {"targets": [ 1 ],"searchable": true},
                {"sWidth": "1px", "aTargets": [4]}
            ],
            "data": data,
            "columns":[
                {"title": "Id","data": "IdEECC",visible:0},
                {
                    "title": "Fecha Vencimiento", 
                    "data": "FechaVencimiento",
                    "render": function(data, type, row, meta){
                        if(type === 'display'){
                            data = moment(data, 'YYYY-MM-DD',true).format("DD-MM-YYYY");
                        }
                        return data;
                    }
                },                
                {"title": "Monto Autorizado","data": "MontoAutorizado"},
                {"title": "Monto Utilizado","data": "MontoUtilizado"},
                {"title": "Monto Disponible","data": "MontoDisponible"},
                {"title": "Monto Facturado Actual","data": "MontoFacturadoActual"}
            ],
        });
        limpiarEECC=1;
};

var pintarDatosActualizar= function(data){
    console.log(data);
    $(".md-form-control").addClass("md-valid");
    $("#IdCliente").val(data.IdCliente);
    $("#RUTCliente").val(data.RUTCliente);
    $("#NombreCliente").val(data.NombreCliente);
    $("#DireccionCliente").val(data.DireccionCliente);
    $("#TelefonoCliente").val(data.TelefonoCliente);
    $("#DiaPago").val(data.DiaPago);
    $("#CupoAutorizado").val(data.CupoAutorizado);
    $("#CupoUtilizado").val(data.CupoUtilizado);
    $("#EstadoCliente").val(data.EstadoCliente).trigger("change");
    $("#IdCicloFacturacion").val(data.IdCicloFacturacion).trigger("change");
}

var BotonCancelar = function(){
    $(".md-form-control").removeClass("md-valid");
    $("#spanTitulo").text("");
    $(".divDetalles").toggle();
    $(".divBotones").toggle();
    $('#FormCliente')[0].reset();
    $("#IdCliente").val("");
}

var BotonAgregar = function(){
    $("#spanTitulo").text("Registrar Cliente");
    $("#divBtnModificar").hide();
    $("#divVolver").hide();
    $(".divBotones").toggle();
    $(".divDetalles").toggle();
    $("#IdCliente").val("");
    $(".comboclear").val('').trigger("change");
    $('#FormCliente')[0].reset();
    desbloquearInuts();
}

var ProcesarCliente = function(){
    if (errorRut==0){
        parametroAjax.ruta=ruta;
        parametroAjax.data = $("#FormCliente").serialize();
        respuesta=procesarajax(parametroAjax);
        ManejoRespuestaProcesar(respuesta);
    }
};

var validador = function(){
    $('#FormCliente').formValidation('validate');
};

var cambiarEstatusCliente = function(IdCliente){
    parametroAjax.ruta=rutaA;
    parametroAjax.data = {IdCliente:IdCliente};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarI(respuesta);
}

var verDetallesCliente = function(IdCliente){
    parametroAjax.ruta=rutaD;
    parametroAjax.data = {IdCliente:IdCliente};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarD(respuesta);
}

var bloquearInuts = function(){
    $("#RUTCliente").prop('readonly', true);
    $("#NombreCliente").prop('readonly', true);
    $("#DireccionCliente").prop('readonly', true);
    $("#TelefonoCliente").prop('readonly', true);
    $("#CupoAutorizado").prop('readonly', true);
    $("#CupoUtilizado").prop('readonly', true);
    $("#IdCicloFacturacion").prop('disabled', true);
    $("#EstadoCliente").prop('disabled', true);
}

var desbloquearInuts = function(){
    $("#RUTCliente").prop('readonly', false);
    $("#NombreCliente").prop('readonly', false);
    $("#DireccionCliente").prop('readonly', false);
    $("#TelefonoCliente").prop('readonly', false);
    $("#CupoAutorizado").prop('readonly', false);
    $("#CupoUtilizado").prop('readonly', false);
    $("#IdCicloFacturacion").prop('disabled', false);
    $("#EstadoCliente").prop('disabled', false);
}

var modificarCliente = function(){
    $("#spanTitulo").text("Editar Cliente");
    $(".divBotones").toggle();
    $("#divVolver").hide();
    desbloquearInuts();
}

var volverTabs = function(){
    $("#spanTitulo").text("");
    $(".divDetalles").toggle();
    
    $("#aDetalles").addClass("active");
    $("#TabDetalles").addClass("active");

    $("#aFacturacionActual").removeClass("active");
    $("#TabFacturacionActual").removeClass("active");

    $("#aProximaFacturacion").removeClass("active");
    $("#TabProximaFacturacion").removeClass("active");

    $("#aMovimientos").removeClass("active");    
    $("#TabMovimientos").removeClass("active");

    $("#aEECC").removeClass("active");
    $("#TabEECC").removeClass("active");
}

var crearAllSelect = function(data){
    crearselect(data.v_ciclos,"IdCicloFacturacion");
    crearselect(data.v_estados,"EstadoCliente");
}

var verificarRut = function(control){
    var res = Valida_Rut(control);
    var format = formateaRut(control.val(), res);
    if (format != false){
        errorRut = 0;
        $("#ErrorRut").text("");
        return format;
    }else{
        errorRut = 1;
        $("#ErrorRut").text("Rut invalido");
        return control.val();
    }
}

$(document).ready(function(){
    $("#TelefonoCliente").inputmask({ mask: "9-9999-9999"});
    $("#RUTCliente").focusout(function() {
        var valid = $("#RUTCliente").val();
        if (valid.length > 0){
            var res = verificarRut($("#RUTCliente"));
            $("#RUTCliente").val(res);
        }else{$("#ErrorRut").text("");}
    });
    cargarTablaClientes(d.v_clientes);
    crearAllSelect(d);
    $(document).on('click','#guardar',validador);
    $(document).on('click','#cancelar',BotonCancelar);
    $(document).on('click','#agregar',BotonAgregar);
    $(document).on('click','#modificar',modificarCliente);
    $(document).on('click','#volverAct',volverTabs);

    $('#FormCliente').formValidation({
        excluded:[':disabled'],
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'RUTCliente': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'NombreCliente': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'TelefonoCliente': {
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    }
                }
            },
            'DireccionCliente': {
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    }
                }
            },
            'CupoAutorizado': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'CupoUtilizado': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'IdCicloFacturacion': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'EstadoCliente': {
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
        ProcesarCliente();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});