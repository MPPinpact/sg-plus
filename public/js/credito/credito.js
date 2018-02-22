var RegistroLocales  = '';
var manejoRefresh=limpiarPreferencias=errorRut=limpiarBodegas=0;

var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};

var ManejoRespuestaProcesarD = function(respuesta){
    if(respuesta.code==200){
        $(".divDetalles").toggle();
        $("#divVolver").show();
        bloquearInuts();
        pintarDatosActualizar(respuesta.respuesta.v_detalles[0]);
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }

}
// Manejo Activar / Desactivar empresa
var ManejoRespuestaProcesarI = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta.activar>0){
            if(respuesta.respuesta.v_credito_preferencias.length>0){
                $.growl({message:"Procesado"},{type: "success", allow_dismiss: true,});
                cargarTablaPreferencia(respuesta.respuesta.v_credito_preferencias);
            }
        }else{
            $.growl({message:"Debe seleccionar un registro"},{type: "warning", allow_dismiss: true,});
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

// Manejo Registro o actualizacion de empresa
var ManejoRespuestaProcesar = function(respuesta){

    if(respuesta.code==200){
        var res = JSON.parse(respuesta.respuesta.f_registro);
        switch(res.code) {
            case '200':
                $.growl({message:res.des_code},{type: "success", allow_dismiss: true,});
                $(".divDetalles").toggle();
                $(".divBotones").toggle();
                $('#FormCredito')[0].reset();
                $("#IdCreditoPreferencia").val("");
                cargarTablaPreferencia(respuesta.respuesta.v_credito_preferencias);
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

var cargarTablaPreferencia = function(data){
    if(limpiarPreferencias==1){destruirTabla('#tablaPreferencias');$('#tablaPreferencias thead').empty();}
        $("#tablaPreferencias").dataTable({
            responsive:false,
            "aLengthMenu": DataTableLengthMenu,
            "pagingType": "full_numbers",
            "language": LenguajeTabla,
            "columnDefs": [
                {"targets": [ 1 ],"searchable": true},
                {"sWidth": "1px", "aTargets": [8]}
            ],
            "data": data,
            "columns":[
                {
                    "title": " ",
                    "data": "IdCreditoPreferencia",
                    "render": function(data, type, row, meta){
                        var result = `
                        <center>
                        <a href="#" onclick="verDetallesVenta(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Preferencia" data-original-title="Delete">
                            <i class="icofont icofont-search"></i>
                        </a>
                        <a href="#" onclick="cambiarEstatusPreferencia(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
                            <i class="icofont icofont-ui-delete"></i>
                        </a>
                        </center>`;
                        return result;
                    }
                },
                {"title": "Id Preferencia","data": "IdCreditoPreferencia",visible:0},
                {"title": "Fecha de Inicio","data": "FechaInicio"},
                {"title": "Fecha de Fin","data": "FechaFin"},
				{"title": "Interes Mensual","data": "InteresMensual"},
				{"title": "Max de Cuotas","data": "NumeroMaxCuotas"},
				{"title": "Primera Cuota","data": "TolenranciaDiasPrimeraCuota"},
				{"title": "Deuda Vencida","data": "AdvertenciaDeudaVencida"},
				{"title": "Monto Mantención","data": "MontoMantencionCuenta"},
				{"title": "Estado","data": "DetalleEstadoPreferencia"},

                {"title": "Fecha de creacion","data": "auFechaCreacion",visible:0},
                {"title": "Usuario creacion","data": "auUsuarioCreacion",visible:0},
                {"title": "auModificadoPor","data": "auUsuarioModificacion",visible:0},
                {"title": "auUsuarioModificacion","data": "auFechaModificacion",visible:0}

            ],
        });
        limpiarPreferencias=1;
};

var pintarDatosActualizar= function(data){
    $(".md-form-control").addClass("md-valid");
    $("#IdCreditoPreferencia").val(data.IdCreditoPreferencia);
    $("#FechaInicio").val(data.FechaInicio);
    $("#FechaFin").val(data.FechaFin);
    $("#InteresMensual").val(data.InteresMensual);
    $("#NumeroMaxCuotas").val(data.NumeroMaxCuotas);
    $("#TolenranciaDiasPrimeraCuota").val(data.TolenranciaDiasPrimeraCuota);
    $("#AdvertenciaDeudaVencida").val(data.AdvertenciaDeudaVencida);
    $("#MontoMantencionCuenta").val(data.MontoMantencionCuenta);
    $("#EstadoPreferencia").val(data.EstadoPreferencia).trigger("change");
}

var pintarDatosDetalles = function(data){
    $("#IdLocald").val(data.IdLocal);
    $("#NombreLocald").val(data.NombreLocal);
    $("#IdEmpresad").val(data.IdEmpresa).trigger("change");
    $("#IdEncargadoLocald").val(data.IdEncargadoLocal).trigger("change");
    $("#EstadoLocald").val(data.EstadoLocal).trigger("change");
}

var BotonCancelar = function(){
    $("#divTabs").show();
    $(".divDetalles").toggle();
    $(".md-form-control").removeClass("md-valid");
    $("#spanTitulo").text("");
    $('#FormCredito')[0].reset();
    $("#IdCreditoPreferencia").val("");
    $(".divBotones").toggle();
    bloquearInuts();
}

var BotonAgregar = function(){
    $(".md-form-control").removeClass("md-valid");
    $("#spanTitulo").text("Registrar Preferencias de Crédito");
    $(".comboclear").val('').trigger("change");
    $('#FormCredito')[0].reset();
    $("#IdCreditoPreferencia").val("");
    $("#divTabs").hide();
    $("#divVolver").hide();
    $(".divDetalles").toggle();
    $(".divBotones").toggle();
    desbloquearInuts();
}

var ProcesarCredito = function(){
    if (errorRut==0){
        parametroAjax.ruta=ruta;
        parametroAjax.data = $("#FormCredito").serialize();
        respuesta=procesarajax(parametroAjax);
        ManejoRespuestaProcesar(respuesta);
    }
};

var validador = function(){
    $('#FormCredito').formValidation('validate');
};

var cambiarEstatusPreferencia = function(IdCreditoPreferencia){
    parametroAjax.ruta=rutaA;
    parametroAjax.data = {IdCreditoPreferencia:IdCreditoPreferencia};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarI(respuesta);
}

var verDetallesVenta = function(IdCreditoPreferencia){
    parametroAjax.ruta=rutaPr;
    parametroAjax.data = {IdCreditoPreferencia:IdCreditoPreferencia};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarD(respuesta);
}


var bloquearInuts = function(){
    $("#FechaInicio").prop('readonly', true);
    $("#FechaFin").prop('readonly', true);
    $("#InteresMensual").prop('readonly', true);
    $("#NumeroMaxCuotas").prop('readonly', true);
    $("#TolenranciaDiasPrimeraCuota").prop('readonly', true);
    $("#AdvertenciaDeudaVencida").prop('readonly', true);
    $("#MontoMantencionCuenta").prop('readonly', true);
    $("#EstadoPreferencia").prop('disabled', true);
}

var desbloquearInuts = function(){
    $("#FechaInicio").prop('readonly', false);
    $("#FechaFin").prop('readonly', false);
    $("#InteresMensual").prop('readonly', false);
    $("#NumeroMaxCuotas").prop('readonly', false);
    $("#TolenranciaDiasPrimeraCuota").prop('readonly', false);
    $("#AdvertenciaDeudaVencida").prop('readonly', false);
    $("#MontoMantencionCuenta").prop('readonly', false);
    $("#EstadoPreferencia").prop('disabled', false);
}

var modificarPreferencia = function(){
    $("#divVolver").hide();
    $(".divBotones").toggle();
    desbloquearInuts();
}

var volverTabs = function(){
    $(".divDetalles").toggle();
    $("#adetalles").addClass("active");
    $("#detalles").addClass("active");
    $("#bodegas").removeClass("active");
    $("#abodegas").removeClass("active");
}

var crearAllSelect = function(data){
    crearselect(data.v_estados,"EstadoPreferencia");
}

$(document).ready(function(){
    cargarTablaPreferencia(d.v_credito_preferencias);
    crearAllSelect(d);
    $(document).on('click','#guardar',validador);
    $(document).on('click','#agregar',BotonAgregar);
    $(document).on('click','#cancelar',BotonCancelar);
    $(document).on('click','#modificar',modificarPreferencia);
    $(document).on('click','#volverAct',volverTabs);
    $('#FormCredito').formValidation({
        excluded:[':disabled'],
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'FechaInicio': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'FechaFin': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'InteresMensual': {
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    }
                }
            },
            'NumeroMaxCuotas': {
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    }
                }
            },
            'TolenranciaDiasPrimeraCuota': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'AdvertenciaDeudaVencida': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'MontoMantencionCuenta': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'EstadoPreferencia': {
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
        ProcesarCredito();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});