var RegistroUnidades  = '';
var manejoRefresh=limpiarUnidades=errorRut=0;

var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};

var ManejoRespuestaBuscar = function(respuesta){
    if(respuesta.code==200){
        bloquearInuts();
        $("#spanTitulo").text("Detalles");
        $("#divVolver").show();
        $("#divBtnModificar").show();
        $("#divBtnAceptar").hide();
        cargarFormulario();
        pintarDatosActualizar(respuesta.respuesta);
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

var ManejoRespuestaProcesarD = function(respuesta){
    if(respuesta.code==200){
        $(".divDetalles").toggle();
        pintarDatosDetalles(respuesta.respuesta.v_detalles[0]);
        cargarTablaBodegas(respuesta.respuesta.v_bodegas);
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}
// Manejo Activar / Desactivar empresa
var ManejoRespuestaProcesarI = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta.activar>0){
            if(respuesta.respuesta.v_unidades.length>0){
                $.growl({message:"Procesado"},{type: "success", allow_dismiss: true,});
                cargarTablaUnidades(respuesta.respuesta.v_unidades);
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
        var res = JSON.parse(respuesta.respuesta.f_registro.f_registro_unidadmedida);
        switch(res.code) {
            case '200':
                $.growl({message:res.des_code},{type: "success", allow_dismiss: true,});
                $(".divForm").toggle();
                $('#FormUnidad')[0].reset();
                $('#IdUnidadMedida').val("");
                cargarTablaUnidades(respuesta.respuesta.v_unidades);
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

var cargarTablaUnidades = function(data){
    if(limpiarUnidades==1){destruirTabla('#tablaUnidades');$('#tablaUnidades thead').empty();}
        $("#tablaUnidades").dataTable({
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
                    "data": "IdUnidadMedida",
                    "render": function(data, type, row, meta){
                        var result = `
                        <center>
                        <a href="#" onclick="verDetallesunidad(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Detalles" data-original-title="Delete">
                            <i class="icofont icofont-search"></i>
                        </a>
                        <a href="#" onclick="cambiarEstatusUnidad(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
                            <i class="icofont icofont-ui-delete"></i>
                        </a>
                        </center>`;
                        return result;
                    }
                },
                {"title": "IdUnidadMedida","data": "IdUnidadMedida",visible:0},
                {"title": "Nombre","data": "NombreUnidadMedida"},
                {"title": "fecha de creacion","data": "auFechaCreacion"},
                {"title": "Usuario creacion","data": "auUsuarioCreacion",visible:0},
                {"title": "Creado por","data": "creador"},
                {"title": "auModificadoPor","data": "auUsuarioModificacion",visible:0},
                {"title": "auUsuarioModificacion","data": "auFechaModificacion",visible:0},
                {"title": "Modificado por","data": "modificador"},
                {"title": "Estado","data": "DesEstadoUnidadMedida"}
            ],
        });
        limpiarUnidades=1;
    if (data.length>0){seleccionarTablaUnidades();}
};

var seleccionarTablaUnidades = function(data){
    var tableB = $('#tablaUnidades').dataTable();
    $('#tablaUnidades tbody').on('click', 'tr', function (e) {
        tableB.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        RegistroUnidades = TablaTraerCampo('tablaUnidades',this);
    });
}

var verDetallesunidad = function(data){
    parametroAjax.ruta=rutaB;
    parametroAjax.data = {"IdUnidadMedida":data} ;
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaBuscar(respuesta);
}

var cargarFormulario= function(){
    $(".divForm").toggle();
}

var pintarDatosActualizar= function(data){
    $(".md-form-control").addClass("md-valid");
    $("#IdUnidadMedida").val(data.IdUnidadMedida);
    $("#NombreUnidadMedida").val(data.NombreUnidadMedida);
    $("#EstadoUnidadMedida").val(data.EstadoUnidadMedida).trigger("change");
}

var BotonCancelar = function(){
    $("#spanTitulo").text("Listado de Unidades de Medida registradas");
    $(".md-form-control").removeClass("md-valid");
    $(".divForm").toggle();
    $('#divConsulta').hide();
    $('#FormUnidad')[0].reset();
    $("#idUser").val("");
    $('#divSpanPerfiles').hide();
}

var BotonAgregar = function(){
    $("#spanTitulo").text("Registrar Unidades de Medida");
    $("#divBtnModificar").hide();
    $("#divVolver").hide();
    $("#divBtnAceptar").show();
    cargarFormulario();
    $("#divConsulta").hide();
    $("#divSpanPerfiles").hide();
    $("#idUser").val("");
    $(".comboclear").val('').trigger("change");
    $('#FormUnidad')[0].reset();
    desbloquearInuts();
}

var ProcesarUnidad = function(){
    if (errorRut==0){
        var camposNuevo = {
            'EstadoUnidadMedida': $('#EstadoUnidadMedida').val()
        }
        parametroAjax.ruta=ruta;
        parametroAjax.data = $("#FormUnidad").serialize() + '&' + $.param(camposNuevo);
        respuesta=procesarajax(parametroAjax);
        ManejoRespuestaProcesar(respuesta);
    }
};

var validador = function(){
    $('#FormUnidad').formValidation('validate');
};

var cambiarEstatusUnidad = function(IdUnidadMedida){
    parametroAjax.ruta=rutaA;
    parametroAjax.data = {IdUnidadMedida:IdUnidadMedida};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarI(respuesta);
}

var bloquearInuts = function(){
    $("#NombreUnidadMedida").prop('readonly', true);
    $("#EstadoUnidadMedida").prop('disabled', true);
}

var desbloquearInuts = function(){
    $("#NombreUnidadMedida").prop('readonly', false);
    $("#EstadoUnidadMedida").prop('disabled', false);
}

var modificarUnidad = function(){
    $("#spanTitulo").text("Editar Unidad de Medida");
    $("#divBtnModificar").hide();
    $("#divBtnAceptar").show();
    desbloquearInuts();
}

var crearAllSelect = function(data){
    crearselect(data.v_estados,"EstadoUnidadMedida");
}

$(document).ready(function(){
    $("#spanTitulo").text("Listado de Unidades de Medida registradas");
    cargarTablaUnidades(d.v_unidades);
    crearAllSelect(d);
    $(document).on('click','#guardar',validador);
    $(document).on('click','#cancelar',BotonCancelar);
    $(document).on('click','#agregar',BotonAgregar);
    $(document).on('click','#modificar',modificarUnidad);
    $(document).on('click','#volverAct',BotonCancelar);
    $('#FormUnidad').formValidation({
        excluded:[':disabled'],
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'NombreUnidadMedida': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'EstadoUnidadMedida': {
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
        ProcesarUnidad();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});