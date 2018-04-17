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
    console.log(respuesta.respuesta);
    if(respuesta.code==200){
        $("#spanTitulo").text("Detalles");
        $(".divDetalles").toggle();
        bloquearInuts();
        $("#divVolver").show();
        pintarDatosActualizar(respuesta.respuesta.v_detalles[0]);
        cargarTablaProductos(respuesta.respuesta.v_productos.productos);
        $("#TotalMontoValorizado").val(respuesta.respuesta.v_productos.sum[0].TotalValorizado);
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
    if(respuesta.code==200){
        var res = JSON.parse(respuesta.respuesta.f_registro.f_registro_bodega);
        switch(res.code) {
            case '200':
                $.growl({message:res.des_code},{type: "success", allow_dismiss: true,});
                $(".divDetalles").toggle();
                $(".divBotones").toggle();
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
                },
                {"title": "IdBodega","data": "IdBodega",visible:0},
                {"title": "Nombre Bodega","data": "NombreBodega"},
                {"title": "Descripción Bodega Local","data": "DescripcionBodega"},
                {"title": "Local Asociado","data": "NombreLocal"},
                {"title": "Fecha de Creación", "data": "auFechaCreacion", visible:0},
                {"title": "Usuario creacion","data": "auUsuarioCreacion",visible:0},
                {"title": "Creado por","data": "creador",visible:0},
                {"title": "auModificadoPor","data": "auUsuarioModificacion",visible:0},
                {"title": "auUsuarioModificacion","data": "auFechaModificacion",visible:0},
                {"title": "Modificado por","data": "modificador",visible:0},
                {"title": "Estado Bodega","data": "desEstadoBodega", className: "text-center"}
            ],
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
}

var cargarTablaProductos = function(data){
    if(limpiarBodegas==1){destruirTabla('#tablaProductos');}
        $("#tablaProductos").dataTable({
            responsive:false,
            "aLengthMenu": DataTableLengthMenu,
            "pagingType": "full_numbers",
            "language": LenguajeTabla,
            "columnDefs": [{
                "targets": [ 1 ],
                "searchable": false
            }],
            "data": data,
            "columns":[
                {"title": "Id","data": "IdProducto",visible:0},
                {"title": "IdFamilia","data": "IdFamilia", visible:0},
                {"title": "IdSubFamilia","data": "IdSubFamilia",visible:0},
                {"title": "Código","data": "CodigoBarra"},
                {"title": "Producto","data": "NombreProducto"},
                {"title": "Familia","data": "NombreFamilia"},
                {"title": "Subfamilia","data": "NombreSubFamilia"},
                {"title": "Precio UC","data": "PrecioUltimaCompra", 
					render: $.fn.dataTable.render.number( '.', ',', 2 ),
					className: "text-right"},
				{"title": "Stock Mínimo","data": "StockMinimo", 
					className: "text-right"},
                {"title": "Stock Máximo","data": "StockMaximo", 
					className: "text-right"},
                {"title": "Stock Actual","data": "Stock", 
					className: "text-right"},
                {"title": "Precio Venta","data": "PrecioVentaSugerido",
					render: $.fn.dataTable.render.number( '.', ',', 2 ),
					className: "text-right"},
                {"title": "Monto Valorizado","data": "MontoValorizado", 
					render: $.fn.dataTable.render.number( '.', ',', 2 ),
					className: "text-right"},
            ],
        });
        limpiarBodegas=1;
};

var pintarDatosActualizar= function(data){
    $(".md-form-control").addClass("md-valid");
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
    $('#FormBodega')[0].reset();
    $("#IdBodega").val("");
    $("#divTabs").show();
    $(".divDetalles").toggle();
    $(".divBotones").toggle();
    bloquearInuts();
}

var BotonAgregar = function(){
    $("#spanTitulo").text("Registrar Bodega");
    $("#divBtnModificar").hide();
    $("#divVolver").hide();
    $("#divBtnAceptar").show();
    $("#IdBodega").val("");
    $(".comboclear").val('').trigger("change");
    $('#FormBodega')[0].reset();
    $("#divTabs").hide();
    $(".divDetalles").toggle();
    $(".divBotones").toggle();
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
    $("#spanTitulo").text("Editar Bodega");
    $("#divVolver").hide();
    $(".divBotones").toggle();
    desbloquearInuts();
}

var volverTabs = function(){
    $("#spanTitulo").text("");
    $(".divDetalles").toggle();
    $("#detalles").addClass("active");
    $("#adetalles").addClass("active");
    $("#productos").removeClass("active");
    $("#aproductos").removeClass("active");
    $("#TotalMontoValorizado").val("");
}

var crearAllSelect = function(data){
    crearselect(data.v_locales,"IdLocal");
    crearselect(data.v_estados,"EstadoBodega");
    crearselect(data.v_locales,"IdLocald");
    crearselect(data.v_estados,"EstadoBodegad");
}

$(document).ready(function(){
    cargarTablaBodegas(d.v_bodegas);
    crearAllSelect(d);
    $(document).on('click','#guardar',validador);
    $(document).on('click','#cancelar',BotonCancelar);
    $(document).on('click','#agregar',BotonAgregar);
    $(document).on('click','#modificar',modificarBodega);
    $(document).on('click','#volverAct',volverTabs);
    $('#FormBodega').formValidation({
        excluded:[':disabled'],
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