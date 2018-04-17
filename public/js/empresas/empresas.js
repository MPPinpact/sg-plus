var RegistroEmpresas  = '';
var manejoRefresh=limpiarEmpresas=errorRut=limpiarLocales=0;

var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};

var ManejoRespuestaProcesarD = function(respuesta){
    if(respuesta.code==200){
        $("#spanTitulo").text("Detalles");
        $("#adetalles").addClass("active");
        $("#detalles").addClass("active");
        $("#locales").removeClass("active");
        $("#alocales").removeClass("active");
        $(".divDetalles").toggle();
        $("#divVolver").show();
        $(".md-form-control").addClass("md-valid");
        bloquearInuts();
        pintarDatosActualizar(respuesta.respuesta.v_detalles[0]);
        cargarTablaLocales(respuesta.respuesta.v_locales.locales);
        $("#TotalMontoValorizado").val(respuesta.respuesta.v_locales.sum[0].TotalValorizado);
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }

}
// Manejo Activar / Desactivar empresa
var ManejoRespuestaProcesarI = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta.activar>0){
            if(respuesta.respuesta.v_empresas.length>0){
                $.growl({message:"Procesado"},{type: "success", allow_dismiss: true,});
                cargarTablaEmpresas(respuesta.respuesta.v_empresas);
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
        var res = JSON.parse(respuesta.respuesta.f_registro.f_registro_empresa);
        switch(res.code) {
            case '200':
                $.growl({message:res.des_code},{type: "success", allow_dismiss: true,});
                $(".divDetalles").toggle();
                $(".divBotones").toggle();
                $('#FormEmpresa')[0].reset();
                $('#IdEmpresa').val("");
                cargarTablaEmpresas(respuesta.respuesta.v_empresas);
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

var cargarTablaEmpresas = function(data){
    if(limpiarEmpresas==1){destruirTabla('#tablaEmpresas');$('#tablaEmpresas thead').empty();}
        $("#tablaEmpresas").dataTable({
            responsive:false,
            "aLengthMenu": DataTableLengthMenu,
            "pagingType": "full_numbers",
            "language": LenguajeTabla,
            "columnDefs": [
                {"targets": [ 1 ],"searchable": true},
                {"sWidth": "1px", "aTargets": [12]}
            ],
            "data": data,
            "columns":[
                {
                    "title": "",
                    "data": "IdEmpresa",
                    "render": function(data, type, row, meta){
                        var result = `
                        <center>
                        <a href="#" onclick="verDetallesEmpresa(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Detalles" data-original-title="Delete">
                            <i class="icofont icofont-search"></i>
                        </a>
                        <a href="#" onclick="cambiarEstatusEmpresa(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
                            <i class="icofont icofont-ui-delete"></i>
                        </a>
                        </center>`;
                        return result;
                    }
                },
                {"title": "IdEmpresa","data": "IdEmpresa",visible:0},
                {"title": "IdRepresentanteLegal","data": "IdRepresentanteLegal",visible:0},
                {"title": "Nombre","data": "NombreFantasia"},
                {
                    "title": "RUT",
                    "data": "RUT",
                    "render": function(data, type, row, meta){
                        if(type === 'display'){
                            data = formateaRut(data, true)
                        }
                        return data;
                    }
                },
                {"title": "Razon Social","data": "RazonSocial"},
                {"title": "fecha de creacion","data": "auFechaCreacion",visible:0},
                {"title": "Usuario creacion","data": "auUsuarioCreacion",visible:0},
                {"title": "Creado por","data": "creador"},
                {"title": "auModificadoPor","data": "auUsuarioModificacion",visible:0},
                {"title": "auUsuarioModificacion","data": "auFechaModificacion",visible:0},
                {"title": "Modificado por","data": "modificador",visible:0},
                {"title": "Estado","data": "desEstadoEmpresa"}
            ],
        });
        limpiarEmpresas=1;
    if (data.length>0){seleccionarTablaEmpleados();}
};

var seleccionarTablaEmpleados = function(data){
    var tableB = $('#tablaEmpresas').dataTable();
    $('#tablaEmpresas tbody').on('click', 'tr', function (e) {
        tableB.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        RegistroEmpresas = TablaTraerCampo('tablaEmpresas',this);
    });
}

var cargarTablaLocales = function(data){
    if(limpiarLocales==1){destruirTabla('#tablaLocales');}
        $("#tablaLocales").dataTable({
            responsive:false,
            "aLengthMenu": DataTableLengthMenu,
            "pagingType": "full_numbers",
            "language": LenguajeTabla,
            "columnDefs": [
            {
                "targets": [ 1 ],
                "searchable": false
            }],
            "data": data,
            "columns":
			[
				{"title": "Id","data": "IdLocal",visible:0},
				{"title": "Nombre del Local","data": "NombreLocal"},
				{"title": "Encargado Local","data": "IdEncargadoLocal"},
				{"title": "Mercadería Valorizada","data": "MontoValorizado", 
					render: $.fn.dataTable.render.number( '.', ',', 2 ),
					className: "text-right"},
				{"title": "Estado","data": "desEstadoLocal", visible:0},
            ],
        });
        limpiarLocales=1;
};

// var cargarFormulario= function(){
//     $(".divForm").toggle();
// }

var pintarDatosActualizar= function(data){
    $(".md-form-control").addClass("md-valid");
    $("#IdEmpresa").val(data.IdEmpresa);
    $("#RUT").val(data.RUT);
    $("#RazonSocial").val(data.RazonSocial);
    $("#NombreFantasia").val(data.NombreFantasia);
    $("#Giro").val(data.Giro);
    $("#IdRepresentanteLegal").val(data.IdRepresentanteLegal).trigger("change");
    $("#EstadoEmpresa").val(data.EstadoEmpresa).trigger("change");
}

var pintarDatosDetalles = function(data){
    $("#RUTd").val(data.RUT);
    $("#RazonSociald").val(data.RazonSocial);
    $("#NombreFantasiad").val(data.NombreFantasia);
    $("#Girod").val(data.Giro);
    $("#IdRepresentanteLegald").val(data.IdRepresentanteLegal);
    $("#desEstadoEmpresad").val(data.desEstadoEmpresa);
}

var BotonCancelar = function(){
    $("#divTabs").show();
    $(".divDetalles").toggle();
    $(".md-form-control").removeClass("md-valid");
    $("#spanTitulo").text("Empresas registradas");
    $(".divBotones").toggle();
    $('#FormEmpresa')[0].reset();
    $("#idUser").val("");
    bloquearInuts();
}

var BotonAgregar = function(){
    $("#spanTitulo").text("Registrar Empresa");
    $("#divTabs").hide();
    $("#divVolver").hide();
    $(".divDetalles").toggle();
    $(".divBotones").toggle();
    $("#idUser").val("");
    $(".comboclear").val('').trigger("change");
    $('#FormEmpresa')[0].reset();
    desbloquearInuts();
}

var ProcesarEmpresa = function(){
    if (errorRut==0){
        var camposNuevo = {'IdRepresentanteLegal': $('#IdRepresentanteLegal').val(), 'EstadoEmpresa': $('#EstadoEmpresa').val()}
        parametroAjax.ruta=ruta;
        parametroAjax.data = $("#FormEmpresa").serialize() + '&' + $.param(camposNuevo);
        respuesta=procesarajax(parametroAjax);
        ManejoRespuestaProcesar(respuesta);
    }
};

var validador = function(){
    $('#FormEmpresa').formValidation('validate');
};

var cambiarEstatusEmpresa = function(IdEmpresa){
    parametroAjax.ruta=rutaA;
    parametroAjax.data = {IdEmpresa:IdEmpresa};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarI(respuesta);
}

var verDetallesEmpresa = function(IdEmpresa){
    parametroAjax.ruta=rutaD;
    parametroAjax.data = {IdEmpresa:IdEmpresa};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarD(respuesta);
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

var bloquearInuts = function(){
    $("#RUT").prop('readonly', true);
    $("#RazonSocial").prop('readonly', true);
    $("#NombreFantasia").prop('readonly', true);
    $("#Giro").prop('readonly', true);
    $("#IdRepresentanteLegal").prop('disabled', true);
    $("#EstadoEmpresa").prop('disabled', true);
}

var desbloquearInuts = function(){
    $("#RUT").prop('readonly', false);
    $("#RazonSocial").prop('readonly', false);
    $("#NombreFantasia").prop('readonly', false);
    $("#Giro").prop('readonly', false);
    $("#IdRepresentanteLegal").prop('disabled', false);
    $("#EstadoEmpresa").prop('disabled', false);
}

var modificarEmpresa = function(){
    $("#spanTitulo").text("Editar Empresa");
    $("#divVolver").hide();
    $(".divBotones").toggle();
    desbloquearInuts();
}

var volverTabs = function(){
    $("#spanTitulo").text("");
    $(".divDetalles").toggle();
}

var crearAllSelect = function(data){
    var option = [
        {"id":"1","text":"Representante 1"},
        {"id":"2","text":"Representante 2"},
        {"id":"3","text":"Representante 3"}
    ];
    crearselect(data.v_estados,"EstadoEmpresa");
    crearselect(data.v_estados,"EstadoEmpresad");
    crearselect(option,"IdRepresentanteLegal");
    crearselect(option,"IdRepresentanteLegald");
}

$(document).ready(function(){
    crearAllSelect(d);
    $("#RUT").focusout(function() {
        var valid = $("#RUT").val();
        if (valid.length > 0){
            var res = verificarRut($("#RUT"));
            $("#RUT").val(res);
        }else{$("#ErrorRut").text("");}
    });
    cargarTablaEmpresas(d.v_empresas);
    $(document).on('click','#guardar',validador);
    $(document).on('click','#cancelar',BotonCancelar);
    $(document).on('click','#agregar',BotonAgregar);
    $(document).on('click','#modificar',modificarEmpresa);
    $(document).on('click','#volverAct',volverTabs);
    $('#FormEmpresa').formValidation({
        excluded:[':disabled'],
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'RUT': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'RazonSocial': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'NombreFantasia': {
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    }
                }
            },
            'Giro': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'IdRepresentanteLegal': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'EstadoEmpresa': {
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
        ProcesarEmpresa();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});