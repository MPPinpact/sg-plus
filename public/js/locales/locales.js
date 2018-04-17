var RegistroLocales  = '';
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
    console.log(respuesta.respuesta);
    if(respuesta.code==200){
        $(".divDetalles").toggle();
        $("#divVolver").show();
        $("#spanTitulo").text("Detalles");
        bloquearInuts();
        pintarDatosActualizar(respuesta.respuesta.v_detalles[0]);
        cargarTablaBodegas(respuesta.respuesta.v_bodegas.bodegas);
        console.log(respuesta.respuesta.v_bodegas.sum[0].TotalValorizado);
        $("#TotalMontoValorizadoL").val(respuesta.respuesta.v_bodegas.sum[0].TotalValorizado);
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }

}
// Manejo Activar / Desactivar empresa
var ManejoRespuestaProcesarI = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta.activar>0){
            if(respuesta.respuesta.v_locales.length>0){
                $.growl({message:"Procesado"},{type: "success", allow_dismiss: true,});
                cargarTablaLocales(respuesta.respuesta.v_locales);
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
        var res = JSON.parse(respuesta.respuesta.f_registro.f_registro_local);
        switch(res.code) {
            case '200':
                $.growl({message:res.des_code},{type: "success", allow_dismiss: true,});
                $(".divDetalles").toggle();
                $(".divBotones").toggle();
                $('#FormLocal')[0].reset();
                $('#IdLocal').val("");
                cargarTablaLocales(respuesta.respuesta.v_locales);
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

var cargarTablaLocales = function(data){
    if(limpiarLocales==1){destruirTabla('#tablaLocales');$('#tablaLocales thead').empty();}
        $("#tablaLocales").dataTable({
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
                    "data": "IdLocal",
                    "render": function(data, type, row, meta){
                        var result = `
                        <center>
                        <a href="#" onclick="verDetallesLocal(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Detalles" data-original-title="Delete">
                            <i class="icofont icofont-search"></i>
                        </a>
                        <a href="#" onclick="cambiarEstatusLocal(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
                            <i class="icofont icofont-ui-delete"></i>
                        </a>
                        </center>`;
                        return result;
                    }
                },
                {"title": "IdLocal","data": "IdLocal",visible:0},
                {"title": "Nombre","data": "NombreLocal"},
                {"title": "Encargado Local","data": "IdEncargadoLocal"},
                {"title": "fecha de creacion","data": "auFechaCreacion",visible:0},
                {"title": "Usuario creacion","data": "auUsuarioCreacion",visible:0},
                {"title": "Creado por","data": "creador",visible:0},
                {"title": "auModificadoPor","data": "auUsuarioModificacion",visible:0},
                {"title": "auUsuarioModificacion","data": "auFechaModificacion",visible:0},
                {"title": "Modificado por","data": "modificador",visible:0},
                {"title": "Estado","data": "desEstadoLocal"}
            ],
        });
        limpiarLocales=1;
    if (data.length>0){seleccionarTablaLocales();}
};

var seleccionarTablaLocales = function(data){
    var tableB = $('#tablaLocales').dataTable();
    $('#tablaLocales tbody').on('click', 'tr', function (e) {
        tableB.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        RegistroLocales = TablaTraerCampo('tablaLocales',this);
    });
    // $('#tablaLocales tbody').on('dblclick', 'tr', function () {
    //     bloquearInuts();
    //     $("#divVolver").show();
    //     $("#divBtnModificar").show();
    //     $("#divBtnAceptar").hide();
    //     cargarFormulario();
    //     pintarDatosActualizar(RegistroLocales);
    // });
}

var cargarTablaBodegas = function(data){
    if(limpiarBodegas==1){destruirTabla('#tablaBodegas');}
        $("#tablaBodegas").dataTable({
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
				{"title": "Id","data": "IdBodega",visible:0},
				{"title": "Nombre Bodega","data": "NombreBodega"},
				{"title": "Descripción","data": "DescripcionBodega"},
				{"title": "Mercadería Valorizada","data": "MontoValorizado",
					render: $.fn.dataTable.render.number( '.', ',', 2 ),
					className: "text-right"},
				{"title": "Estado Local","data": "desEstadoBodega", className: "text-center"},
            ],
        });
        limpiarBodegas=1;
};

var pintarDatosActualizar= function(data){
    $(".md-form-control").addClass("md-valid");
    // $("#spanTitulo").text("Editar Local");
    $("#IdLocal").val(data.IdLocal);
    $("#NombreLocal").val(data.NombreLocal);
    $("#IdEmpresa").val(data.IdEmpresa).trigger("change");
    $("#IdEncargadoLocal").val(data.IdEncargadoLocal).trigger("change");
    $("#EstadoLocal").val(data.EstadoLocal).trigger("change");
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
    $(".divForm").toggle();
    $('#FormLocal')[0].reset();
    $("#idUser").val("");
    $(".divBotones").toggle();
    bloquearInuts();
}

var BotonAgregar = function(){
    $("#spanTitulo").text("Registrar Local");
    $("#idUser").val("");
    $(".comboclear").val('').trigger("change");
    $('#FormLocal')[0].reset();
    $("#divTabs").hide();
    $("#divVolver").hide();
    $(".divDetalles").toggle();
    $(".divBotones").toggle();
    desbloquearInuts();
}

var ProcesarLocal = function(){
    if (errorRut==0){
        var camposNuevo = {
            'IdEmpresa': $('#IdEmpresa').val(),
            'IdEncargadoLocal': $('#IdEncargadoLocal').val(),
            'EstadoLocal': $('#EstadoLocal').val()
        }
        parametroAjax.ruta=ruta;
        parametroAjax.data = $("#FormLocal").serialize() + '&' + $.param(camposNuevo);
        respuesta=procesarajax(parametroAjax);
        ManejoRespuestaProcesar(respuesta);
    }
};

var reiniciarClave = function(idUser){
    parametroAjax.ruta=rutaR;
    parametroAjax.data = {idUser:idUser};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarR(respuesta);
}

var validador = function(){
    $('#FormLocal').formValidation('validate');
};

var cambiarEstatusLocal = function(IdLocal){
    parametroAjax.ruta=rutaA;
    parametroAjax.data = {IdLocal:IdLocal};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarI(respuesta);
}

var verDetallesLocal = function(IdLocal){
    parametroAjax.ruta=rutaD;
    parametroAjax.data = {IdLocal:IdLocal};
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
    $("#NombreLocal").prop('readonly', true);
    $("#IdEmpresa").prop('disabled', true);
    $("#IdEncargadoLocal").prop('disabled', true);
    $("#EstadoLocal").prop('disabled', true);
}

var desbloquearInuts = function(){
    $("#NombreLocal").prop('readonly', false);
    $("#IdEmpresa").prop('disabled', false);
    $("#IdEncargadoLocal").prop('disabled', false);
    $("#EstadoLocal").prop('disabled', false);
}

var modificarLocal = function(){
    $("#spanTitulo").text("Editar Local");
    $("#divVolver").hide();
    $(".divBotones").toggle();
    desbloquearInuts();
}

var volverTabs = function(){
    $("#spanTitulo").text("");
    $(".divDetalles").toggle();
    $("#adetalles").addClass("active");
    $("#detalles").addClass("active");
    $("#bodegas").removeClass("active");
    $("#abodegas").removeClass("active");
}

var crearAllSelect = function(data){
    var encargado =[{"id":"1","text":"Encargado 1"},{"id":"2","text":"Encargado 2"}];
    crearselect(encargado,"IdEncargadoLocal");
    crearselect(encargado,"IdEncargadoLocald");
    crearselect(data.v_empresas,"IdEmpresa");
    crearselect(data.v_estados,"EstadoLocal");
    crearselect(data.v_empresas,"IdEmpresad");
    crearselect(data.v_estados,"EstadoLocald");
}

$(document).ready(function(){
    cargarTablaLocales(d.v_locales);
    crearAllSelect(d);
    $(document).on('click','#guardar',validador);
    $(document).on('click','#cancelar',BotonCancelar);
    $(document).on('click','#agregar',BotonAgregar);
    $(document).on('click','#modificar',modificarLocal);
    $(document).on('click','#volverAct',volverTabs);
    $('#FormLocal').formValidation({
        excluded:[':disabled'],
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'NombreLocal': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'IdEmpresa': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'IdEncargadoLocal': {
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    }
                }
            },
            'EstadoLocal': {
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
        ProcesarLocal();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});