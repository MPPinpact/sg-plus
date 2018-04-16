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
    // console.info(respuesta);
    if(respuesta.code==200){
        $("#spanTitulo").text("Detalles");
        $(".divDetalles").toggle();
        bloquearInuts();
        $("#divVolver").show();
        // console.info(respuesta.respuesta.v_detalles[0]);
        pintarDatosActualizar(respuesta.respuesta.v_detalles[0]);
        // cargarTablaProductos(respuesta.respuesta.v_productos);
        // cargarTablaProductos(respuesta.respuesta.v_productos);
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

// Manejo Activar / Desactivar empresa
var ManejoRespuestaProcesarI = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta.activar>0){
            if(respuesta.respuesta.v_proveedores.length>0){
                $.growl({message:"Procesado"},{type: "success", allow_dismiss: true,});
                cargarTablaProveedores(respuesta.respuesta.v_proveedores);
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
    console.info(respuesta);
    if(respuesta.code==200){
        var res = JSON.parse(respuesta.respuesta.f_registro);
        switch(res.code) {
            case '200':
                $.growl({message:res.des_code},{type: "success", allow_dismiss: true,});
                $(".divDetalles").toggle();
                $(".divBotones").toggle();
                $('#FormRegFormaPago')[0].reset();
                $('#IdFormaPago').val("");
                cargarTablaProveedores(respuesta.respuesta.v_bodegas);
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

var cargarTablaProveedores = function(data){
    console.log(data)
    if(limpiarLocales==1){destruirTabla('#tablaProveedor');$('#tablaProveedor thead').empty();}
        $("#tablaProveedor").dataTable({
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
                {"title": "NombreFormaPago","data": "NombreFormaPago"},
                {"title": "EstadoFormaPago","data": "EstadoFormaPago",visible:0},
                {"title": "auFechaModificacion","data": "auFechaModificacion",visible:0},
                {"title": "auUsuarioModificacion","data": "auUsuarioModificacion",visible:0},
                {"title": "auFechaCreacion","data": "auFechaCreacion",visible:0},
                {"title": "auUsuarioCreacion","data": "auUsuarioCreacion",visible:0},


                {"title": "fecha de creacion","data": "auFechaCreacion",visible:0},
                {"title": "Usuario creacion","data": "auUsuarioCreacion",visible:0},
                {"title": "Creado por","data": "creador"},
                {"title": "auModificadoPor","data": "auUsuarioModificacion",visible:0},
                {"title": "auUsuarioModificacion","data": "auFechaModificacion",visible:0},
                {"title": "Modificado por","data": "modificador",visible:0},
                {"title": "Estado","data": "desEstadoFormaPago"}
            ],
        });
        limpiarLocales=1;
    // if (data.length>0){seleccionarTablaLocales();}
};

// var seleccionarTablaLocales = function(data){
//     var tableB = $('#tablaProveedor').dataTable();
//     $('#tablaProveedor tbody').on('click', 'tr', function (e) {
//         tableB.$('tr.selected').removeClass('selected');
//         $(this).addClass('selected');
//         RegistroEmpresas = TablaTraerCampo('tablaProveedor',this);
//     });
// }

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
                {"title": "Codigo Barra","data": "CodigoBarra"},
                {"title": "Codigo Proveedor","data": "pEstadoFormaPago"},
                {"title": "Nombre Producto","data": "NombreProducto"},
                {"title": "Descripcion Producto","data": "DescripcionProducto"},
                {"title": "Ultimo Proveedor","data": "IdUltimoProveedor"},
                {"title": "IdFamilia","data": "IdFamilia", visible:0},
                {"title": "Familia","data": "NombreFamilia"},
                {"title": "IdSubFamilia","data": "IdSubFamilia",visible:0},
                {"title": "Subfamilia","data": "NombreSubFamilia"},
                {"title": "IdUnidadMedida","data": "IdUnidadMedida",visible:0},
                {"title": "Unidad Medida","data": "NombreUnidadMedida"},
                {"title": "Se Compra","data": "SeCompra",visible:0},
                {"title": "Se Compra","data": "DesCompra"},
                {"title": "Se Vende","data": "SeVende", visible:0},
                {"title": "Se Vende","data": "DesVende"},
                {"title": "Se Combo","data": "EsProductoCombo", visible:0},
                {"title": "Producto Combo","data": "DesProductoCombo"},
                {"title": "Descontinuado","data": "Descontinuado",visible:0},
                {"title": "Descontinuado","data": "DesDescontinuado"},
                {"title": "Stock Minimo","data": "StockMinimo"},
                {"title": "Stock Maximo","data": "StockMaximo"},
                {"title": "Stock Recomendado","data": "StockRecomendado"},
                {"title": "Precio Ultima Compra","data": "PrecioUltimaCompra"},
                {"title": "Precio Venta Sugerido","data": "PrecioVentaSugerido"},
                {"title": "Id Bodega","data": "IdFormaPago",visible:0},
                {"title": "Bodega","data": "NombreBodega"},
                {"title": "EstadoProducto","data": "EstadoProducto",visible:0},
                {"title": "Estado","data": "DesEstadoProducto"}
            ],
        });
        limpiarBodegas=1;
};

var pintarDatosActualizar= function(data){
    // console.info(data.NombreFormaPago);
    $(".md-form-control").addClass("md-valid");
    $("#IdFormaPago").val(data.IdFormaPago);
    $("#pNombreFormaPago").val(data.NombreFormaPago);
    $("#pEstadoFormaPago").val(data.pEstadoFormaPago);
    $("#pauFechaModificacion").val(data.pauFechaModificacion);
    $("#pauUsuarioModificacion").val(data.pauUsuarioModificacion);
    $("#pauFechaCreacion").val(data.pauFechaCreacion);
    $("#pauUsuarioCreacion").val(data.pauUsuarioCreacion);
    $("#FormadePago").val(data.FormadePago).trigger("change");
    $("#EstadoFormadePago").val(data.EstadoFormadePago).trigger("change");
}

var BotonCancelar = function(){
    $(".md-form-control").removeClass("md-valid");
    $('#FormRegFormaPago')[0].reset();
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
    $(".comboclear").val('').trigger("change");
    $('#FormRegFormaPago')[0].reset();
    $("#divTabs").hide();
    $(".divDetalles").toggle();
    $(".divBotones").toggle();
    desbloquearInuts();
}

var ProcesarFormadePago = function(){
    // console.info('llegue');
    if (errorRut==0){
        var camposNuevo = {
            'pNombreFormaPago': $('#pNombreFormaPago').val(),
            'EstadoFormaPago': $('#EstadoFormaPago').val()
        }
    // console.info(camposNuevo);    
        parametroAjax.ruta=ruta;
        parametroAjax.data = $("#FormRegFormaPago").serialize() + '&' + $.param(camposNuevo);
        respuesta=procesarajax(parametroAjax);
    // console.info(respuesta);    
        ManejoRespuestaProcesar(respuesta);
    }
};

var validador = function(){
    $('#FormRegFormaPago').formValidation('validate');
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
    $("#pNombreFormaPago").prop('readonly', true);
    $("#EstadoFormaPago").prop('disabled', true);
}

var desbloquearInuts = function(){
    $("#pNombreFormaPago").prop('readonly', false);
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
    $("#detalles").addClass("active");
    $("#adetalles").addClass("active");
    $("#compras").removeClass("active");
    $("#acompras").removeClass("active");
}

var crearAllSelect = function(data){
    // console.log(data);
    crearselect(data.v_formas_de_pago,"FormadePago");
    crearselect(data.v_estados,"EstadoFormaPago");
}

$(document).ready(function(){
    cargarTablaProveedores(d.v_formas_pago);
    crearAllSelect(d);
    $(document).on('click','#guardar',validador);
    $(document).on('click','#cancelar',BotonCancelar);
    $(document).on('click','#agregar',BotonAgregar);
    $(document).on('click','#modificar',modificarBodega);
    $(document).on('click','#volverAct',volverTabs);
    $('#FormRegFormaPago').formValidation({
        excluded:[':disabled'],
        fields: {
            'pNombreFormaPago': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'pEstadoFormaPago': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'pauFechaModificacion': {
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    }
                }
            },
            'pauUsuarioModificacion': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'pauFechaCreacion': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'EstadoFormaPago': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'FormadePago': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
           'EstadoFormadePago': {
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