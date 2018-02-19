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
        $("#spanTitulo").text("Detalles");
        $(".divDetalles").toggle();
        bloquearInuts();
        $("#divVolver").show();
        pintarDatosActualizar(respuesta.respuesta.v_detalles[0]);
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
    if(respuesta.code==200){
        var res = JSON.parse(respuesta.respuesta.f_registro);
        switch(res.code) {
            case '200':
                $.growl({message:res.des_code},{type: "success", allow_dismiss: true,});
                $(".divDetalles").toggle();
                $(".divBotones").toggle();
                $('#FormProveedor')[0].reset();
                $('#IdProveedor').val("");
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
                    "data": "IdProveedor",
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
                {"title": "IdProveedor","data": "IdProveedor",visible:0},
                {"title": "RUT Proveedor","data": "RUTProveedor"},
                {"title": "Codigo Proveedor","data": "CodigoProveedor"},
                {"title": "Razon Social","data": "RazonSocialProveedor"},
                {"title": "Nombre Fantasia","data": "NombreFantasia"},
                {"title": "Dirección","data": "Direccion"},
                {"title": "Teléfeno","data": "Telefeno"},
                {"title": "Vendedor","data": "Vendedor"},

                {"title": "fecha de creacion","data": "auFechaCreacion",visible:0},
                {"title": "Usuario creacion","data": "auUsuarioCreacion",visible:0},
                {"title": "Creado por","data": "creador"},
                {"title": "auModificadoPor","data": "auUsuarioModificacion",visible:0},
                {"title": "auUsuarioModificacion","data": "auFechaModificacion",visible:0},
                {"title": "Modificado por","data": "modificador",visible:0},
                {"title": "Estado","data": "DesEstadoProveedor"}
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
                {"title": "Codigo Proveedor","data": "CodigoProveedor"},
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
                {"title": "Id Bodega","data": "IdProveedor",visible:0},
                {"title": "Bodega","data": "NombreBodega"},
                {"title": "EstadoProducto","data": "EstadoProducto",visible:0},
                {"title": "Estado","data": "DesEstadoProducto"}
            ],
        });
        limpiarBodegas=1;
};

var pintarDatosActualizar= function(data){
    $(".md-form-control").addClass("md-valid");
    $("#IdProveedor").val(data.IdProveedor);
    $("#RUTProveedor").val(data.RUTProveedor);
    $("#CodigoProveedor").val(data.CodigoProveedor);
    $("#RazonSocialProveedor").val(data.RazonSocialProveedor);
    $("#NombreFantasia").val(data.NombreFantasia);
    $("#Direccion").val(data.Direccion);
    $("#Telefeno").val(data.Telefeno);
    $("#Vendedor").val(data.Vendedor);
    $("#EstadoProveedor").val(data.EstadoProveedor).trigger("change");
}

var BotonCancelar = function(){
    $(".md-form-control").removeClass("md-valid");
    $('#FormProveedor')[0].reset();
    $("#IdProveedor").val("");
    $("#divTabs").show();
    $(".divDetalles").toggle();
    $(".divBotones").toggle();
    bloquearInuts();
}

var BotonAgregar = function(){
    $("#spanTitulo").text("Registrar Proveedor");
    $("#divBtnModificar").hide();
    $("#divVolver").hide();
    $("#divBtnAceptar").show();
    $("#IdProveedor").val("");
    $(".comboclear").val('').trigger("change");
    $('#FormProveedor')[0].reset();
    $("#divTabs").hide();
    $(".divDetalles").toggle();
    $(".divBotones").toggle();
    desbloquearInuts();
}

var ProcesarProveedor = function(){
    if (errorRut==0){
        var camposNuevo = {
            'EstadoProveedor': $('#EstadoProveedor').val()
        }
        parametroAjax.ruta=ruta;
        parametroAjax.data = $("#FormProveedor").serialize() + '&' + $.param(camposNuevo);
        respuesta=procesarajax(parametroAjax);
        ManejoRespuestaProcesar(respuesta);
    }
};

var validador = function(){
    $('#FormProveedor').formValidation('validate');
};

var cambiarEstatus = function(IdProveedor){
    parametroAjax.ruta=rutaA;
    parametroAjax.data = {IdProveedor:IdProveedor};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarI(respuesta);
}

var verDetalles = function(IdProveedor){
    parametroAjax.ruta=rutaD;
    parametroAjax.data = {IdProveedor:IdProveedor};
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
    $("#RUTProveedor").prop('readonly', true);
    $("#CodigoProveedor").prop('readonly', true);
    $("#RazonSocialProveedor").prop('readonly', true);
    $("#NombreFantasia").prop('readonly', true);
    $("#Direccion").prop('readonly', true);
    $("#Telefeno").prop('readonly', true);
    $("#Vendedor").prop('readonly', true);
    $("#EstadoProveedor").prop('disabled', true);
}

var desbloquearInuts = function(){
    $("#RUTProveedor").prop('readonly', false);
    $("#CodigoProveedor").prop('readonly', false);
    $("#RazonSocialProveedor").prop('readonly', false);
    $("#NombreFantasia").prop('readonly', false);
    $("#Direccion").prop('readonly', false);
    $("#Telefeno").prop('readonly', false);
    $("#Vendedor").prop('readonly', false);
    $("#EstadoProveedor").prop('disabled', false);
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
    crearselect(data.v_estados,"EstadoProveedor");
}

$(document).ready(function(){
    cargarTablaProveedores(d.v_proveedores);
    crearAllSelect(d);
    $(document).on('click','#guardar',validador);
    $(document).on('click','#cancelar',BotonCancelar);
    $(document).on('click','#agregar',BotonAgregar);
    $(document).on('click','#modificar',modificarBodega);
    $(document).on('click','#volverAct',volverTabs);
    $('#FormProveedor').formValidation({
        excluded:[':disabled'],
        fields: {
            'RUTProveedor': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'CodigoProveedor': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'RazonSocialProveedor': {
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    }
                }
            },
            'NombreFantasia': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'Direccion': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'Telefeno': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'Vendedor': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'EstadoProveedor': {
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
        ProcesarProveedor();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});