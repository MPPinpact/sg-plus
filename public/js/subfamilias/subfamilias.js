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

// Manejo Activar / Desactivar empresa
var ManejoRespuestaProcesarI = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta.activar>0){
            if(respuesta.respuesta.v_subfamilias.length>0){
                $.growl({message:"Procesado"},{type: "success", allow_dismiss: true,});
                cargarTablaSubfamilias(respuesta.respuesta.v_subfamilias);
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
        var res = JSON.parse(respuesta.respuesta.f_registro.f_registro_subfamilias);
        switch(res.code) {
            case '200':
                $.growl({message:res.des_code},{type: "success", allow_dismiss: true,});
                $(".divForm").toggle();
                $('#FormSubfamilia')[0].reset();
                $('#IdSubFamilia').val("");
                cargarTablaSubfamilias(respuesta.respuesta.v_subfamilias);
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

var ManejoRespuestaFiltrarSubFamilias = function(respuesta){
    if(respuesta.code==200){
            if(respuesta.respuesta.v_subfamilias.length>0){
                $.growl({message:"Listado Actualizado..."},{type: "success", allow_dismiss: true,});
                cargarTablaSubfamilias(respuesta.respuesta.v_subfamilias);
            }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

var cargarTablaSubfamilias = function(data){
    if(limpiarUnidades==1){destruirTabla('#tablaSubfamilias');$('#tablaSubfamilias thead').empty();}
        $("#tablaSubfamilias").dataTable({
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
                    "data": "IdSubFamilia",
                    "render": function(data, type, row, meta){
                        var result = `
                        <center>
                        <a href="#" onclick="verDetallesubfamilia(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Detalles" data-original-title="Delete">
                            <i class="icofont icofont-search"></i>
                        </a>
                        <a href="#" onclick="cambiarEstatusUnidad(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
                            <i class="icofont icofont-ui-delete"></i>
                        </a>
                        </center>`;
                        return result;
                    }
                },
                {"title": "IdSubFamilia","data": "IdSubFamilia",visible:0},
                {"title": "Nombre","data": "NombreSubFamilia"},
                {"title": "Familia","data": "NombreFamilia"},
                 {   
                    "title": "Fecha de Creación", 
                    "data": "auFechaCreacion",
                    "render": function(data, type, row, meta){
                        if(type === 'display'){
                            data = moment(data, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY");
                        }
                        return data;
                    }
                },  
                {"title": "Usuario creacion","data": "auUsuarioCreacion",visible:0},
                {"title": "Creado por","data": "creador"},
                {"title": "auModificadoPor","data": "auUsuarioModificacion",visible:0},
                {"title": "auUsuarioModificacion","data": "auFechaModificacion",visible:0},
                {"title": "Modificado por","data": "modificador"},
                {"title": "Estado","data": "DesEstadoSubFamilia"}
                ],
        });
        limpiarUnidades=1;
    if (data.length>0){seleccionarTablaSubfamilias();}
};

var seleccionarTablaSubfamilias = function(data){
    var tableB = $('#tablaSubfamilias').dataTable();
    $('#tablaSubfamilias tbody').on('click', 'tr', function (e) {
        tableB.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        RegistroUnidades = TablaTraerCampo('tablaSubfamilias',this);
    });
}

var cargarFormulario= function(){
    $(".divForm").toggle();
}

var VerSubFamiliasActivas = function(data){
    parametroAjax.ruta=rutaSA;
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaFiltrarSubFamilias(respuesta);
}

var VerTodasLasSubFamilias = function(data){
    parametroAjax.ruta=rutaTS;
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaFiltrarSubFamilias(respuesta);
}

var verDetallesubfamilia = function(data){
    parametroAjax.ruta=rutaB;
    parametroAjax.data = {"IdSubFamilia":data} ;
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaBuscar(respuesta);
}

var pintarDatosActualizar= function(data){
    $(".md-form-control").addClass("md-valid");
    $("#IdSubFamilia").val(data.IdSubFamilia);
    $("#NombreSubFamilia").val(data.NombreSubFamilia);
    $("#IdUnidadMedida").val(data.IdUnidadMedida);
    $("#IdFamilia").val(data.IdFamilia);
    $("#EstadoSubFamilia").val(data.EstadoSubFamilia).trigger("change");
}

var BotonCancelar = function(){
    $(".md-form-control").removeClass("md-valid");
    $("#spanTitulo").text("Listado Subfamilias Registradas");
    $(".divForm").toggle();
    $('#divConsulta').hide();
    $('#FormSubfamilia')[0].reset();
    $("#IdSubFamilia").val("");
    $('#divSpanPerfiles').hide();
}

var BotonAgregar = function(){
    $("#spanTitulo").text("Registrar Subfamilia");
    $("#divBtnModificar").hide();
    $("#divVolver").hide();
    $("#divBtnAceptar").show();
    cargarFormulario();
    $("#divConsulta").hide();
    $("#divSpanPerfiles").hide();
    $("#IdSubFamilia").val("");
    $(".comboclear").val('').trigger("change");
    $('#FormSubfamilia')[0].reset();
    desbloquearInuts();
}

var ProcesarUnidad = function(){
    if (errorRut==0){
        var camposNuevo = {
            'IdUnidadMedida': $('#IdUnidadMedida').val(),
            'EstadoSubFamilia': $('#EstadoSubFamilia').val()
        }
        parametroAjax.ruta=ruta;
        parametroAjax.data = $("#FormSubfamilia").serialize() + '&' + $.param(camposNuevo);
        respuesta=procesarajax(parametroAjax);
        ManejoRespuestaProcesar(respuesta);
    }
};

var validador = function(){
    $('#FormSubfamilia').formValidation('validate');
};

var cambiarEstatusUnidad = function(IdSubFamilia){
    parametroAjax.ruta=rutaA;
    parametroAjax.data = {IdSubFamilia:IdSubFamilia};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarI(respuesta);
}

var bloquearInuts = function(){
    $("#NombreSubFamilia").prop('readonly', true);
    $("#IdUnidadMedida").prop('disabled', true);
    $("#EstadoSubFamilia").prop('disabled', true);
    $("#IdFamilia").prop('disabled', true);
}

var desbloquearInuts = function(){
    $("#NombreSubFamilia").prop('readonly', false);
    $("#IdUnidadMedida").prop('disabled', false);
    $("#EstadoSubFamilia").prop('disabled', false);
    $("#IdFamilia").prop('disabled', false);
}

var modificarFamilia = function(){
    $("#spanTitulo").text("Editar Subfamilia");
    $("#divBtnModificar").hide();
    $("#divBtnAceptar").show();
    desbloquearInuts();
}

var crearAllSelect = function(data){
    crearselect(data.v_unidadmedida,"IdUnidadMedida");
    crearselect(data.v_estados,"EstadoSubFamilia");
    crearselect(data.v_familia,"IdFamilia");
}

$(document).ready(function(){
    $("#spanTitulo").text("Listado Subfamilias Registradas");
    cargarTablaSubfamilias(d.v_subfamilias);
    crearAllSelect(d);
    $(document).on('click','#guardar',validador);
    $(document).on('click','#cancelar',BotonCancelar);
    $(document).on('click','#agregar',BotonAgregar);
    $(document).on('click','#modificar',modificarFamilia);
    $(document).on('click','#volverAct',BotonCancelar);

    $(document).on('click','#botonActivas',VerSubFamiliasActivas);
    $(document).on('click','#botonTodas',VerTodasLasSubFamilias);


    $('#FormSubfamilia').formValidation({
        excluded:[':disabled'],
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'NombreSubFamilia': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'IdUnidadMedida': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'EstadoSubFamilia': {
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