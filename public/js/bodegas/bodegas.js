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
        pintarDatosDetalles(respuesta.respuesta.v_detalles[0]);
        cargarTablaProductos(respuesta.respuesta.v_productos);
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});       
    }

}
// Manejo Activar / Desactivar empresa
var ManejoRespuestaProcesarI = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta.activar>0){
            if(respuesta.respuesta.v_bodegas.length>0){
                $.growl({message:"Procesado"},{type: "success", allow_dismiss: true,});
                cargarTablaBodegas(respuesta.respuesta.v_bodegas);
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
    console.log(respuesta);
    console.log(respuesta.respuesta);
    console.log(respuesta.respuesta.f_registro);
    if(respuesta.code==200){
        var res = JSON.parse(respuesta.respuesta.f_registro.f_registro_bodega);
        switch(res.code) {
            case '200':
                $.growl({message:res.des_code},{type: "success", allow_dismiss: true,});
                $(".divForm").toggle();
                $('#FormBodega')[0].reset();
                $('#IdLocal').val("");
                cargarTablaBodegas(respuesta.respuesta.v_bodegas);
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

var cargarTablaBodegas = function(data){
    if(limpiarLocales==1){destruirTabla('#tablaBodega');$('#tablaBodega thead').empty();}
        $("#tablaBodega").dataTable({ 
            "aLengthMenu": DataTableLengthMenu,
            "pagingType": "full_numbers",
            "language": LenguajeTabla,
            "scrollX": true,
            "scrollY": '45vh',
            "scrollCollapse": true,
            "columnDefs": [
                {"targets": [ 1 ],"searchable": true},
                {"sWidth": "1px", "aTargets": [8]}
            ],
            "data": data,
            "columns":[
            {"title": "IdBodega","data": "IdBodega",visible:0},
            {"title": "Nombre Bodega","data": "NombreBodega"},
            {"title": "Descripcion Bodega Local","data": "DescripcionBodega"},
            {"title": "Local Asociado","data": "NombreLocal"},
            {"title": "fecha de creacion","data": "auFechaCreacion",visible:0},
            {"title": "Usuario creacion","data": "auUsuarioCreacion",visible:0},
            {"title": "Creado por","data": "creador"},
            {"title": "auModificadoPor","data": "auUsuarioModificacion",visible:0},
            {"title": "auUsuarioModificacion","data": "auFechaModificacion",visible:0},
            {"title": "Modificado por","data": "modificador",visible:0},
            {"title": "Estado","data": "desEstadoBodega"},
            {
                "title": "Opciones", 
                "data": "IdBodega",
                "render": function(data, type, row, meta){
                    var result = `
                    <center>
                    <a href="#" onclick="verDetallesBodega(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Detalles" data-original-title="Delete">
                        <i class="icofont icofont-search"></i>
                    </a>
                    <a href="#" onclick="cambiarEstatusLocal(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
                        <i class="icofont icofont-ui-delete"></i>
                    </a>
                    </center>`;
                    return result; 
                }
            }],
        });
        limpiarLocales=1;
    if (data.length>0){seleccionarTablaLocales();}
};

var seleccionarTablaLocales = function(data){
    var tableB = $('#tablaBodega').dataTable();
    $('#tablaBodega tbody').on('click', 'tr', function (e) {
        tableB.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        RegistroEmpresas = TablaTraerCampo('tablaBodega',this);
    });
    $('#tablaBodega tbody').on('dblclick', 'tr', function () {
        bloquearInuts();
        $("#divVolver").show();
        $("#divBtnModificar").show();
        $("#divBtnAceptar").hide();  
        cargarFormulario();
        pintarDatosActualizar(RegistroEmpresas);
    }); 
}

var cargarTablaProductos = function(data){
    if(limpiarBodegas==1){destruirTabla('#tablaProductos');}
        $("#tablaProductos").dataTable({ 
            "aLengthMenu": DataTableLengthMenu,
            'bSort': false,
            "scrollCollapse": false,
            "paging": false,
            "searching": false,
            "columnDefs": [
            {
                "targets": [ 1 ],
                "searchable": false
            }],
            "data": data,
            "columns":[
            {"title": "Id","data": "IdProducto",visible:0},
            {"title": "Nombre","data": "CodigoBarra"},
            {"title": "Descripción","data": "CodigoProveedor"},
            {"title": "NombreProducto","data": "NombreProducto"},
            {"title": "DescripcionProducto","data": "DescripcionProducto"},
            {"title": "IdUltimoProveedor","data": "IdUltimoProveedor"},
            {"title": "IdFamilia","data": "IdFamilia"},
            {"title": "IdSubFamilia","data": "IdSubFamilia"},
            {"title": "IdUnidadMedida","data": "IdUnidadMedida"},
            {"title": "SeCompra","data": "SeCompra"},
            {"title": "SeVende","data": "SeVende"},
            {"title": "Descontinuado","data": "Descontinuado"},
            {"title": "StockMinimo","data": "StockMinimo"},
            {"title": "StockMaximo","data": "StockMaximo"},
            {"title": "StockRecomendado","data": "StockRecomendado"},
            {"title": "PrecioUltimaCompra","data": "PrecioUltimaCompra"},
            {"title": "PrecioVentaSugerido","data": "PrecioVentaSugerido"},
            {"title": "EstadoProducto","data": "EstadoProducto"},
            ],
        });
        limpiarBodegas=1; 
};

var cargarFormulario= function(){
    $(".divForm").toggle();
}

var pintarDatosActualizar= function(data){
    $(".md-form-control").addClass("md-valid");
    $("#spanTitulo").text("Editar Bodega");
    $("#IdBodega").val(data.IdBodega);
    $("#NombreBodega").val(data.NombreBodega);
    $("#DescripcionBodega").val(data.DescripcionBodega);
    $("#IdLocal").val(data.IdLocal).trigger("change");
    $("#EstadoBodega").val(data.EstadoBodega).trigger("change");
}

var pintarDatosDetalles = function(data){
    $(".md-form-control").addClass("md-valid");
    $("#IdBodegad").val(data.IdBodega);
    $("#NombreBodegad").val(data.NombreBodega);
    $("#DescripcionBodegad").val(data.DescripcionBodega);
    $("#IdLocald").val(data.IdLocal).trigger("change");
    $("#EstadoBodegad").val(data.EstadoBodega).trigger("change");
}

var BotonCancelar = function(){
    $(".md-form-control").removeClass("md-valid");
    $("#spanTitulo").text("Bodega registrados");
    $(".divForm").toggle();    
    $('#divConsulta').hide();
    $('#FormBodega')[0].reset();
    $("#IdBodega").val("");
    $('#divSpanPerfiles').hide();
}

var BotonAgregar = function(){
    $("#spanTitulo").text("Registrar Bodega");
    $("#divBtnModificar").hide();
    $("#divVolver").hide();
    $("#divBtnAceptar").show();
    cargarFormulario();
    $("#divConsulta").hide();
    $("#divSpanPerfiles").hide();
    $("#IdBodega").val("");
    $(".comboclear").val('').trigger("change");
    $('#FormBodega')[0].reset();
    desbloquearInuts();
}

var ProcesarBodega = function(){
    if (errorRut==0){  
        var camposNuevo = {
            'IdLocal': $('#IdLocal').val(), 
            'EstadoBodega': $('#EstadoBodega').val()
        }
        parametroAjax.ruta=ruta;
        parametroAjax.data = $("#FormBodega").serialize() + '&' + $.param(camposNuevo);
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
    $('#FormBodega').formValidation('validate');
};

var cambiarEstatusLocal = function(IdBodega){
    parametroAjax.ruta=rutaA;
    parametroAjax.data = {IdBodega:IdBodega};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarI(respuesta);
}

var verDetallesBodega = function(IdBodega){
    parametroAjax.ruta=rutaD;
    parametroAjax.data = {IdBodega:IdBodega};
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
    $("#NombreBodega").prop('readonly', true);
    $("#DescripcionBodega").prop('readonly', true);
    $("#IdLocal").prop('disabled', true);
    $("#EstadoBodega").prop('disabled', true);
}

var desbloquearInuts = function(){
    $("#NombreBodega").prop('readonly', false);
    $("#DescripcionBodega").prop('readonly', false);
    $("#IdLocal").prop('disabled', false);
    $("#EstadoBodega").prop('disabled', false);
}

var modificarBodega = function(){
    $("#divBtnModificar").hide();
    $("#divBtnAceptar").show();
    desbloquearInuts();    
}

var volverTabs = function(){
    $(".divDetalles").toggle();   
}

var crearAllSelect = function(data){
    crearselect(data.v_locales,"IdLocal");
    crearselect(data.v_estados,"EstadoBodega");
    crearselect(data.v_locales,"IdLocald");
    crearselect(data.v_estados,"EstadoBodegad");
}

$(document).ready(function(){
    $("#spanTitulo").text("Bodegas registradas");
    cargarTablaBodegas(d.v_bodegas);
    crearAllSelect(d);
    $(document).on('click','#guardar',validador);
    $(document).on('click','#cancelar',BotonCancelar);
    $(document).on('click','#agregar',BotonAgregar);
    $(document).on('click','#modificar',modificarBodega);
    $(document).on('click','#volverAct',BotonCancelar);
    $(document).on('click','#btn-volver',volverTabs);
    $('#FormBodega').formValidation({
        excluded:[':disabled'],
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'NombreBodega': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            }, 
            'DescripcionBodega': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },            
            'IdLocal': {
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    }
                }
            },
            'EstadoBodega': {
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
        ProcesarBodega();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});