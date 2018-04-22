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
    console.log(respuesta);
    if(respuesta.code==200){
        $("#spanTitulo").text("Detalles");
        $(".divDetalles").toggle();
        bloquearInuts();
        $("#divVolver").show();
        pintarDatosActualizar(respuesta.respuesta.v_detalles[0]);
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

// Manejo Activar / Desactivar empresa
var ManejoRespuestaProcesarI = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta.activar>0){
            $.growl({message:"Procesado"},{type: "success", allow_dismiss: true,});
            cargarTablaAbonoCliente(respuesta.respuesta.v_formas_de_pago);
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
                $('#FormAbonoCliente')[0].reset();
                $('#IdFormaPago').val("");
                cargarTablaAbonoCliente(respuesta.respuesta.v_formas_de_pago);
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

var cargarTablaAbonoCliente = function(data){
    if(limpiarLocales==1){destruirTabla('#TablaAbonoCliente');$('#TablaAbonoCliente thead').empty();}
        $("#TablaAbonoCliente").dataTable({
            responsive:false,
            'bSort': false,
            "scrollCollapse": false,
            "paging": false,
            "searching": false,
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
                    "data": "IdFormaPago",
                    "render": function(data, type, row, meta){
                        var result = `
                        <center>
                        <a href="#" onclick="verDetalles(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Detalles" data-original-title="Delete">
                            <i class="icofont icofont-search"></i>
                        </a>
                        <a href="#" onclick="cambiarEstatus(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
                            <i class="icofont icofont-ui-delete"></i>
                        </a>
                        </center>`; 
                        return result;
                    }
                },
                {"title": "IdFormaPago","data": "IdFormaPago",visible:0},
                {"title": "RUTCliente","data": "RUTCliente"},
                {"title": "Nombre Cliente","data": "NombreCliente"},                
                {"title": "Monto Abonado","data": "MontoAbono"},
                {"title": "EstadoAbono","data": "desEstadoAbono"},
                {"title": "auUsuarioCreacion","data": "auUsuarioCreacion",visible:0},
                {"title": "fecha de creacion","data": "auFechaCreacion",visible:0},
                {"title": "Creado por","data": "creador",visible:0},
                {"title": "auModificadoPor","data": "auUsuarioModificacion",visible:0},
                {"title": "auUsuarioModificacion","data": "auFechaModificacion",visible:0},
                {"title": "Modificado por","data": "modificador",visible:0}
                
            ],
        });
        limpiarLocales=1;
    // if (data.length>0){seleccionarTablaLocales();}
};

var pintarDatosActualizar= function(data){
    $(".md-form-control").addClass("md-valid");
    $("#IdFormaPago").val(data.IdFormaPago);
    $("#MontoAbono").val(data.MontoAbono);
    $("#EstadoFormadePago").val(data.EstadoFormadePago).trigger("change");
}

var BotonCancelar = function(){
    $(".md-form-control").removeClass("md-valid");
    $('#FormAbonoCliente')[0].reset();
    $("#IdFormaPago").val("");
    $("#divTabs").show();
    $(".divDetalles").toggle();
    $(".divBotones").toggle();
    bloquearInuts();
}

var BotonAgregar = function(){
    $("#spanTitulo").text("Registrar Forma de Pago");
    $("#divBtnModificar").hide();
    $("#divVolver").hide();
    $("#divBtnAceptar").show();
    $("#IdFormaPago").val("");
    $('#FormAbonoCliente')[0].reset();
    $("#divTabs").hide();
    $(".divDetalles").toggle();
    $(".divBotones").toggle();
    desbloquearInuts();
}

var ProcesarFormadePago = function(){
    parametroAjax.ruta=ruta;
    parametroAjax.data = $("#FormAbonoCliente").serialize();
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesar(respuesta);
};

var validador = function(){
    $('#FormAbonoCliente').formValidation('validate');
};

var cambiarEstatus = function(IdFormaPago){
    parametroAjax.ruta=rutaA;
    parametroAjax.data = {IdFormaPago:IdFormaPago};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarI(respuesta);
}

var verDetalles = function(IdFormaPago){
    parametroAjax.ruta=rutaD;
    parametroAjax.data = {IdFormaPago:IdFormaPago};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarD(respuesta);
}

var bloquearInuts = function(){
    $("#MontoAbono").prop('readonly', true);
    $("#EstadoFormaPago").prop('disabled', true);
}

var desbloquearInuts = function(){
    $("#MontoAbono").prop('readonly', false);
    $("#EstadoFormaPago").prop('disabled', false);
}

var modificarBodega = function(){
    $("#spanTitulo").text("Editar Proveedor");
    $("#divVolver").hide();
    $(".divBotones").toggle();
    desbloquearInuts();
}

var volverTabs = function(){
    $("#spanTitulo").text("");
    $(".divDetalles").toggle();
    // $("#detalles").addClass("active");
    // $("#adetalles").addClass("active");
    // $("#compras").removeClass("active");
    // $("#acompras").removeClass("active");
}

$(document).ready(function(){
    cargarTablaAbonoCliente(d.v_formas_de_pago);
    $(document).on('click','#guardar',validador);
    $(document).on('click','#cancelar',BotonCancelar);
    $(document).on('click','#agregar',BotonAgregar);
    $(document).on('click','#modificar',modificarBodega);
    $(document).on('click','#volverAct',volverTabs);
    $('#FormAbonoCliente').formValidation({
        excluded:[':disabled'],
        fields: {
            'MontoAbono': {
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
        ProcesarFormadePago();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});