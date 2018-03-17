var RegistroImpuestos  = '';
var manejoRefresh=limpiarImpuestos=errorRut=0;

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
            if(respuesta.respuesta.v_impuestos.length>0){
                $.growl({message:"Procesado"},{type: "success", allow_dismiss: true,});
                cargarTablaImpuestos(respuesta.respuesta.v_impuestos);
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
        var res = JSON.parse(respuesta.respuesta.f_registro.f_registro_impuesto);
        switch(res.code) {
            case '200':
                $.growl({message:res.des_code},{type: "success", allow_dismiss: true,});
                $(".divForm").toggle();
                $('#FormImpuestos')[0].reset();
                $('#IdImpuesto').val("");
                cargarTablaImpuestos(respuesta.respuesta.v_impuestos);
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

var cargarTablaImpuestos = function(data){
    if(limpiarImpuestos==1){destruirTabla('#tablaImpuesto');$('#tablaImpuesto thead').empty();}
        $("#tablaImpuesto").dataTable({
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
                    "data": "IdImpuesto",
                    "render": function(data, type, row, meta){
                        var result = `
                        <center>
                        <a href="#" onclick="verDetallesimpuesto(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Detalles" data-original-title="Delete">
                            <i class="icofont icofont-search"></i>
                        </a>
                        <a href="#" onclick="cambiarEstatusImpuesto(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
                            <i class="icofont icofont-ui-delete"></i>
                        </a>
                        </center>`;
                        return result;
                    }
                },
                {"title": "IdImpuesto","data": "IdImpuesto",visible:0},
                {"title": "Nombre","data": "NombreImpuesto"},
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
                {"title": "fecha de creacion","data": "auFechaCreacion"},
                {"title": "Usuario creacion","data": "auUsuarioCreacion",visible:0},
                {"title": "Creado por","data": "creador"},
                {"title": "auModificadoPor","data": "auUsuarioModificacion",visible:0},
                {"title": "auUsuarioModificacion","data": "auFechaModificacion",visible:0},
                {"title": "Modificado por","data": "modificador"},
                {"title": "Estado","data": "DesEstadoImpuesto"}
            ],
        });
        limpiarImpuestos=1;
    if (data.length>0){seleccionarTablaImpuesto();}
};

var seleccionarTablaImpuesto = function(data){
    var tableB = $('#tablaImpuesto').dataTable();
    $('#tablaImpuesto tbody').on('click', 'tr', function (e) {
        tableB.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        RegistroImpuestos = TablaTraerCampo('tablaImpuesto',this);
    });
}

var cargarFormulario= function(){
    $(".divForm").toggle();
}

var verDetallesimpuesto = function(data){
    parametroAjax.ruta=rutaB;
    parametroAjax.data = {"IdImpuesto":data} ;
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaBuscar(respuesta);
}

var pintarDatosActualizar= function(data){
    $(".md-form-control").addClass("md-valid");
    $("#IdImpuesto").val(data.IdImpuesto);
    $("#ValorImpuesto").val(data.ValorImpuesto);
    $("#NombreImpuesto").val(data.NombreImpuesto);
    $("#EstadoImpuesto").val(data.EstadoImpuesto).trigger("change");
}

var BotonCancelar = function(){
    $(".md-form-control").removeClass("md-valid");
    $("#spanTitulo").text("Listado de Impuestos Registrados");
    $(".divForm").toggle();
    $('#divConsulta').hide();
    $('#FormImpuestos')[0].reset();
    $("#IdImpuesto").val("");
    $('#divSpanPerfiles').hide();
}

var BotonAgregar = function(){
    $("#spanTitulo").text("Registrar Impuesto");
    $("#divBtnModificar").hide();
    $("#divVolver").hide();
    $("#divBtnAceptar").show();
    cargarFormulario();
    $("#divConsulta").hide();
    $("#divSpanPerfiles").hide();
    $("#IdImpuesto").val("");
    $(".comboclear").val('').trigger("change");
    $('#FormImpuestos')[0].reset();
    desbloquearInuts();
}

var Procesarimpuesto = function(){
    if (errorRut==0){
        var camposNuevo = {
            'EstadoImpuesto': $('#EstadoImpuesto').val()
        }
        parametroAjax.ruta=ruta;
        parametroAjax.data = $("#FormImpuestos").serialize() + '&' + $.param(camposNuevo);
        respuesta=procesarajax(parametroAjax);
        ManejoRespuestaProcesar(respuesta);
    }
};

var validador = function(){
    $('#FormImpuestos').formValidation('validate');
};

var cambiarEstatusImpuesto = function(IdImpuesto){
    parametroAjax.ruta=rutaA;
    parametroAjax.data = {IdImpuesto:IdImpuesto};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarI(respuesta);
}

var bloquearInuts = function(){
    $("#NombreImpuesto").prop('readonly', true);
    $("#ValorImpuesto").prop('readonly', true);
    $("#EstadoImpuesto").prop('disabled', true);
}

var desbloquearInuts = function(){
    $("#NombreImpuesto").prop('readonly', false);
    $("#ValorImpuesto").prop('readonly', false);
    $("#EstadoImpuesto").prop('disabled', false);
}

var modificarFamilia = function(){
    $("#spanTitulo").text("Editar Impuestos");
    $("#divBtnModificar").hide();
    $("#divBtnAceptar").show();
    desbloquearInuts();
}

var crearAllSelect = function(data){
    crearselect(data.v_estados,"EstadoImpuesto");
}

$(document).ready(function(){
    $("#spanTitulo").text("Listado de Impuestos Registrados");
    cargarTablaImpuestos(d.v_impuestos);
    crearAllSelect(d);
    $(document).on('click','#guardar',validador);
    $(document).on('click','#cancelar',BotonCancelar);
    $(document).on('click','#agregar',BotonAgregar);
    $(document).on('click','#modificar',modificarFamilia);
    $(document).on('click','#volverAct',BotonCancelar);
    $('#FormImpuestos').formValidation({
        excluded:[':disabled'],
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'NombreImpuesto': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'ValorImpuesto': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'EstadoImpuesto': {
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
        Procesarimpuesto();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});