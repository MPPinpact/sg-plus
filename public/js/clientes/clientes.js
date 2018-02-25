var RegistroEmpresas  = '';
var manejoRefresh=limpiarLocales=errorRut=limpiarBodegas=0;

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
        $("#spanTitulo").text("Detalles");
        bloquearInuts();
        pintarDatosActualizar(respuesta.respuesta.v_detalles[0]);
        // cargarTablaClientes(respuesta.respuesta.v_clientes);
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
    if(limpiarLocales==1){destruirTabla('#tablaClientes');$('#tablaClientes thead').empty();}
        $("#tablaClientes").dataTable({
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
                {"title": "Direccion Cliente","data": "DireccionCliente"},
                {"title": "Dia de Pago","data": "DiaPago"},
                {"title": "Cupo Autorizado","data": "CupoAutorizado"},
                {"title": "Cupo Utilizado","data": "CupoUtilizado"},
                {"title": "Estado Cliente","data": "DetalleEstadoCliente"}
            ],
        });
        limpiarLocales=1;
};

var pintarDatosActualizar= function(data){
    $(".md-form-control").addClass("md-valid");
    $("#IdCliente").val(data.IdCliente);
    $("#RUTCliente").val(data.RUTCliente);
    $("#NombreCliente").val(data.NombreCliente);
    $("#DireccionCliente").val(data.DireccionCliente);
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
    $("#CupoAutorizado").prop('readonly', true);
    $("#CupoUtilizado").prop('readonly', true);
    $("#IdCicloFacturacion").prop('disabled', true);
    $("#EstadoCliente").prop('disabled', true);
}

var desbloquearInuts = function(){
    $("#RUTCliente").prop('readonly', false);
    $("#NombreCliente").prop('readonly', false);
    $("#DireccionCliente").prop('readonly', false);
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
    $("#aMovimientos").removeClass("active");
    $("#aEECC").removeClass("active");
    $("#TabDetalles").addClass("active");
    $("#TabMovimientos").removeClass("active");
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