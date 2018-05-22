var RegistroEmpresas  = '';
var manejoRefresh=limpiarLocales=limpiarImpuestos=errorRut=limpiarBodegas=limpiarStock=0;
var ckCompra = ckVenta = ckDescontinuado = ckCombo = 0;

var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};

var ManejoRespuestaProcesarD = function(respuesta){
    if(respuesta.code==200){
        bloquearInuts();
        var np = respuesta.respuesta.v_detalles[0].NombreProducto;
        var cp = respuesta.respuesta.v_detalles[0].CodigoBarra;

        $(".divDetalles").toggle();
        $("#divVolver").show();
        $("#divTabs").show();
        $("#spanTitulo").text("Detalles del Producto: " + np + " [" + cp + "]");
        $("#ImpuestosDelProducto").text("Impuestos del Producto: " + np + " [" + cp + "]");
        $("#StockDelProducto").text("Stock del Producto: " + np + " [" + cp + "]");
        
        $("#IdProducto2").val(respuesta.respuesta.v_detalles[0].IdProducto);
        pintarDatosActualizar(respuesta.respuesta.v_detalles[0]);
        cargarTablaImpuestos(respuesta.respuesta.v_impuestos);
        cargarTablaStock(respuesta.respuesta.v_stock);
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

// Manejo Activar / Desactivar empresa
var ManejoRespuestaProcesarI = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta.activar>0){
            if(respuesta.respuesta.v_productos.length>0){
                $.growl({message:"Procesado"},{type: "success", allow_dismiss: true,});
                cargarTablaProductos(respuesta.respuesta.v_productos);
            }
        }else{
            $.growl({message:"Debe seleccionar un registro"},{type: "warning", allow_dismiss: true,});
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

// Manejo Activar / Desactivar Impuesto a producto
var ManejoRespuestaProcesarAI = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta.activar>0){
            $.growl({message:"Procesado"},{type: "success", allow_dismiss: true,});
            cargarTablaImpuestos(respuesta.respuesta.v_impuestos);
        }else{
            $.growl({message:"Debe seleccionar un registro"},{type: "warning", allow_dismiss: true,});
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

// Manejo respuesta descontinuar Producto
var ManejoRespuestaProcesarDescontinuar = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta.descontinuar>0){
            if(respuesta.respuesta.v_productos.length>0){
                $.growl({message:"Procesado"},{type: "success", allow_dismiss: true,});
                cargarTablaProductos(respuesta.respuesta.v_productos);
            }
        }else{
            $.growl({message:"Debe seleccionar un registro"},{type: "warning", allow_dismiss: true,});
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

// Manejo Registro o actualizacion de empresa
var ManejoRespuestaProcesarImpuesto = function(respuesta){
    if(respuesta.code==200){
        var res = JSON.parse(respuesta.respuesta.f_registro_producto_impuesto);
        switch(res.code) {
            case '200':
                $.growl({message:res.des_code},{type: "success", allow_dismiss: true,});
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

// Manejo Registro o actualizacion de empresa
var ManejoRespuestaProcesar = function(respuesta){
    if(respuesta.code==200){
        var res = JSON.parse(respuesta.respuesta.f_registro.f_registro_producto);
        switch(res.code) {
            case '200':
                $.growl({message:res.des_code},{type: "success", allow_dismiss: true,});
                $(".divDetalles").toggle();
                $(".divBotones").toggle();
                $('#FormProducto')[0].reset();
                $('#IdProducto').val("");
                cargarTablaProductos(respuesta.respuesta.v_productos);
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

var cargarTablaProductos = function(data){
    if(limpiarLocales==1){destruirTabla('#tablaProductos');$('#tablaProductos thead').empty();}
        $("#tablaProductos").dataTable({
            responsive:false,
            "aLengthMenu": DataTableLengthMenu,
            "pageLength": 25,
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
                    "data": "IdProducto",
                    "render": function(data, type, row, meta){
                        var result = `
                        <center>
                        <a href="#" onclick="verDetallesProducto(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Detalles" data-original-title="Delete">
                            <i class="icofont icofont-search"></i>
                        </a>
                        <a href="#" onclick="cambiarEstatusProducto(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
                            <i class="icofont icofont-ui-delete"></i>
                        </a>
                        <a href="#" onclick="descontinuarProducto(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Descontinuar Producto" data-original-title="Delete">
                            <i class="icofont icofont-close"></i>
                        </a>
                        </center>`;
                        return result;
                    }
                },
                {"title": "Id","data": "IdProducto",visible:0},
                {"title": "Codigo Barra","data": "CodigoBarra"},
                {"title": "Codigo Proveedor","data": "CodigoProveedor",visible:0},
                {"title": "Nombre Producto","data": "NombreProducto"},
                {"title": "Descripcion Producto","data": "DescripcionProducto"},
                {"title": "Ultimo Proveedor","data": "IdUltimoProveedor",visible:0},
                {"title": "IdFamilia","data": "IdFamilia", visible:0},
                {"title": "Familia","data": "NombreFamilia",visible:0},
                {"title": "IdSubFamilia","data": "IdSubFamilia",visible:0},
                {"title": "Subfamilia","data": "NombreSubFamilia",visible:0},
                {"title": "IdUnidadMedida","data": "IdUnidadMedida",visible:0},
                {"title": "Unidad Medida","data": "NombreUnidadMedida",visible:0},
                {"title": "Se Compra","data": "DesCompra",visible:0},
                {"title": "Se Vende","data": "DesVende",visible:0},
                {"title": "Es Combo","data": "EsProductoCombo", visible:0},
                {"title": "Combo/Pack","data": "DesProductoCombo"},
                {"title": "Descontinuado","data": "DesDescontinuado"},
                {"title": "$ Última Compra","data": "PrecioUltimaCompra",
                            render: $.fn.dataTable.render.number( '.', ',', 2 ),
                            className: "text-right"},
                {"title": "$ Vta Sugerido","data": "PrecioVentaSugerido",
                            render: $.fn.dataTable.render.number( '.', ',', 2 ),
                            className: "text-right"},
                {"title": "STK Actual","data": "StockActual",
                            render: $.fn.dataTable.render.number( '.', ',', 2 ),
                            className: "text-right"},
                {"title": "STK Mínimo","data": "StockMinimo", 
                            render: $.fn.dataTable.render.number( '.', ',', 2 ),
                            className: "text-right"},
                {"title": "STK Máximo","data": "StockMaximo",
                            render: $.fn.dataTable.render.number( '.', ',', 2 ),
                            className: "text-right"},
                {"title": "STK Recomendado","data": "StockRecomendado",
                            render: $.fn.dataTable.render.number( '.', ',', 2 ),
                            className: "text-right"},
                {"title": "EstadoProducto","data": "EstadoProducto",visible:0},
                {"title": "Estado","data": "DesEstadoProducto"}
            ],
        });
        limpiarLocales=1;
    // if (data.length>0){seleccionarTablaProductos();}
};

// var seleccionarTablaProductos = function(data){
//     var tableB = $('#tablaProductos').dataTable();
//     $('#tablaProductos tbody').on('click', 'tr', function (e) {
//         tableB.$('tr.selected').removeClass('selected');
//         $(this).addClass('selected');
//         RegistroEmpresas = TablaTraerCampo('tablaProductos',this);
//     });
// }

var cargarTablaImpuestos = function(data){
    if(limpiarImpuestos==1){destruirTabla('#tablaImpuestos');$('#tablaImpuestos thead').empty();}
        $("#tablaImpuestos").dataTable({
            responsive:false,
            "bSort": false,
            "scrollCollapse": false,
            "paging": false,
            "searching": false,
            "info":false,
            "columnDefs": [
                {"targets": [ 1 ],"searchable": true},
                {"sWidth": "1px", "aTargets": [8]}
            ],
            "data": data,
            "columns":[
                {
                    "title": "",
                    "data": "IdProductoImpuesto",
                    "render": function(data, type, row, meta){
                        var result = `
                        <center>
                        <a href="#" onclick="cambiarEstatusImpuesto(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
                            <i class="icofont icofont-ui-delete"></i>
                        </a>
                        </center>`;
                        return result;
                    }
                },
                {"title": "Id","data": "IdProductoImpuesto",visible:0},
                {"title": "Nombre Impuesto","data": "NombreImpuesto"},
                {"title": "Valor Impuesto","data": "ValorImpuesto"},
                {"title": "Precio Venta Sugerido","data": "auFechaCreacion",visible:0},
                {"title": "Precio Venta Sugerido","data": "auUsuarioCreacion",visible:0},
                {"title": "Creado por","data": "creador"},
                {"title": "Precio Venta Sugerido","data": "auFechaModificacion",visible:0},
                {"title": "Precio Venta Sugerido","data": "auFechaModificacion",visible:0},
                {"title": "EstadoProductoImpuesto","data": "EstadoProductoImpuesto",visible:0},
                {"title": "Estado","data": "DesEstadoProductoImpuesto"}
            ],
        });
        limpiarImpuestos=1;
};

var cargarTablaStock = function(data){
    if(limpiarStock==1){destruirTabla('#tablaStock');$('#tablaStock thead').empty();}
    $("#tablaStock").dataTable({
        responsive:false,
        "bSort": false,
        "scrollCollapse": false,
        "paging": false,
        "searching": true,
        "info":true,
        "columnDefs": [
            {"targets": [ 1 ],"searchable": true},
        ],
        "data": data,
        "columns":[
            {"title": "Empresa","data": "NombreFantasia"},
            {"title": "Local","data": "NombreLocal"},
            {"title": "Bodega","data": "NombreBodega"},
            {"title": "Stock","data": "Stock",
				render: $.fn.dataTable.render.number( '.', ',', 2 ),
				className: "text-right"},
            {"title": "Monto Valorizado","data": "MontoValorizado", 
				render: $.fn.dataTable.render.number( '.', ',', 2 ),
				className: "text-right"},
        ],
    });
    limpiarStock=1;
}

var pintarDatosActualizar= function(data){
    $(".md-form-control").addClass("md-valid");
    $("#RUTProveedor").val(data.RUTProveedor);
    $("#NombreProveedor").val(data.NombreProveedor);
    $("#IdProducto").val(data.IdProducto);
    $("#CodigoBarra").val(data.CodigoBarra);
    $("#CodigoProveedor").val(data.CodigoProveedor);
    $("#NombreProducto").val(data.NombreProducto);
    $("#DescripcionProducto").val(data.DescripcionProducto);
    $("#StockMinimo").val(data.StockMinimo);
    $("#StockMaximo").val(data.StockMaximo);
    $("#StockRecomendado").val(data.StockRecomendado);
    $("#PrecioUltimaCompra").val(data.PrecioUltimaCompra);
    $("#PrecioVentaSugerido").val(data.PrecioVentaSugerido);
    $("#IdUltimoProveedor").val(data.IdUltimoProveedor).trigger("change");
    $("#IdFamilia").val(data.IdFamilia).trigger("change");
    $("#IdSubFamilia").val(data.IdSubFamilia).trigger("change");
    $("#IdUnidadMedida").val(data.IdUnidadMedida).trigger("change");
    if ((data.SeCompra) == 1){ $( "#SeCompra" ).prop( "checked", true );}
    if ((data.EsProductoCombo) == 1){ $( "#EsProductoCombo" ).prop( "checked", true ); }
    if ((data.Descontinuado) == 1){ $( "#Descontinuado" ).prop( "checked", true ); }
    if ((data.SeVende) == 1){$( "#SeVende" ).prop( "checked", true ); }
    // $("#EstadoProducto").val(data.EstadoProducto).trigger("change");
}

var BotonCancelar = function(){
    $("#spanTitulo").text("");
    $(".md-form-control").removeClass("md-valid");
    $('#FormProducto')[0].reset();
    $("#IdProducto").val("");
    $("#divTabs").show();
    $(".divBotones").toggle();
    $(".divDetalles").toggle();
    bloquearInuts();
    $("#PrecioUltimaCompra").prop('readonly', true);
}

var BotonAgregar = function(){
    $("#spanTitulo").text("Registrar Producto");
    desbloquearInuts();
    $(".divDetalles").toggle();
    $("#divVolver").hide();
    $("#IdProducto").val("");
    $(".comboclear").val('').trigger("change");
    $('#FormProducto')[0].reset();
    $("#divTabs").hide();
    $(".divBotones").toggle();
    $("#PrecioUltimaCompra").prop('readonly', false);
}

var ProcesarImpuesto = function(){
    parametroAjax.ruta=rutaPI;
    parametroAjax.data = $("#FormImpuesto").serialize();
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarImpuesto(respuesta);
};

var ProcesarProducto = function(){
    if(errorRut == 0){
        if ($('#SeVende').is(":checked")){ $('#SeVende').val(1) }else{ $('#SeVende').val(0) }
        if ($('#SeCompra').is(":checked")){ $('#SeCompra').val(1) }else{ $('#SeCompra').val(0) }
        if ($('#EsProductoCombo').is(":checked")){ $('#EsProductoCombo').val(1) }else{ $('#EsProductoCombo').val(2) }
        if ($('#Descontinuado').is(":checked")){ $('#Descontinuado').val(1) }else{ $('#Descontinuado').val(2) }
        var camposNuevo = {
            'IdUltimoProveedor': $('#IdUltimoProveedor').val(),
            'IdFamilia': $('#IdFamilia').val(),
            'IdSubFamilia': $('#IdSubFamilia').val(),
            'IdUnidadMedida': $('#IdUnidadMedida').val(),
            'SeCompra': $('#SeCompra').val(),
            'SeVende': $('#SeVende').val(),
            'EsProductoCombo': $('#EsProductoCombo').val(),
            'Descontinuado': $('#Descontinuado').val(),
            'EstadoProducto': $('#EstadoProducto').val()
        }
        parametroAjax.ruta=ruta;
        parametroAjax.data = $("#FormProducto").serialize() + '&' + $.param(camposNuevo);
        respuesta=procesarajax(parametroAjax);
        ManejoRespuestaProcesar(respuesta);
    }
};

var validador = function(){
    $('#FormProducto').formValidation('validate');
};

var validadorI = function(){
    $('#FormImpuesto').formValidation('validate');
}

var cambiarEstatusProducto = function(IdProducto){
    parametroAjax.ruta=rutaA;
    parametroAjax.data = {IdProducto:IdProducto};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarI(respuesta);
}

var cambiarEstatusImpuesto = function(IdProductoImpuesto){
    parametroAjax.ruta=rutaAI;
    parametroAjax.data = {IdProductoImpuesto:IdProductoImpuesto};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarAI(respuesta);
}

var descontinuarProducto = function(IdProducto){
    parametroAjax.ruta=rutaDes;
    parametroAjax.data = {IdProducto:IdProducto};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarDescontinuar(respuesta);
}

var verDetallesProducto = function(IdProducto){
    parametroAjax.ruta=rutaD;
    parametroAjax.data = {IdProducto:IdProducto};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarD(respuesta);
}

var bloquearInuts = function(){
    $("#CodigoBarra").prop('readonly', true);
    $("#CodigoProveedor").prop('readonly', true);
    $("#NombreProducto").prop('readonly', true);
    $("#DescripcionProducto").prop('readonly', true);
    $("#StockMinimo").prop('readonly', true);
    $("#StockMaximo").prop('readonly', true);
    $("#StockRecomendado").prop('readonly', true);
    $("#PrecioUltimaCompra").prop('readonly', true);
    $("#PrecioVentaSugerido").prop('readonly', true);
    $("#IdUltimoProveedor").prop('disabled', true);
    $("#NombreProveedor").prop('readonly', true);
    $("#RUTProveedor").prop('readonly', true);
    $("#IdFamilia").prop('disabled', true);
    $("#IdSubFamilia").prop('disabled', true);
    $("#IdUnidadMedida").prop('disabled', true);
    $("#SeCompra").prop('disabled', true);
    $("#SeVende").prop('disabled', true);
    $("#EsProductoCombo").prop('disabled', true);
    $("#Descontinuado").prop('disabled', true);
    // $("#EstadoProducto").prop('disabled', true);
}

var desbloquearInuts = function(){
    $("#CodigoBarra").prop('readonly', false);
    $("#CodigoProveedor").prop('readonly', false);
    $("#NombreProducto").prop('readonly', false);
    $("#DescripcionProducto").prop('readonly', false);
    $("#StockMinimo").prop('readonly', false);
    $("#StockMaximo").prop('readonly', false);
    $("#StockRecomendado").prop('readonly', false);
    $("#PrecioVentaSugerido").prop('readonly', false);
    $("#IdUltimoProveedor").prop('disabled', false);
    $("#IdFamilia").prop('disabled', false);
    $("#IdSubFamilia").prop('disabled', false);
    $("#IdUnidadMedida").prop('disabled', false);
    $("#SeCompra").prop('disabled', false);
    $("#SeVende").prop('disabled', false);
    $("#EsProductoCombo").prop('disabled', false);
    $("#Descontinuado").prop('disabled', false);
    // $("#EstadoProducto").prop('disabled', false);
}

var modificarProducto = function(){
    $("#spanTitulo").text("Editar Producto");
    $("#divVolver").hide();
    $(".divBotones").toggle();
    desbloquearInuts();
}

var volverTabs = function(){
    $("#spanTitulo").text("");
    $(".divDetalles").toggle();
    $("#areceta").removeClass("active");
    $("#aimpuestos").removeClass("active");
    $("#astock").removeClass("active");
    $("#akardex").removeClass("active");
    $("#Tabreceta").removeClass("active");
    $("#TabImpuestos").removeClass("active");
    $("#TabStock").removeClass("active");
    $("#TabKardex").removeClass("active");
    $("#Tabdetalles").addClass("active");
    $("#adetalles").addClass("active");
}

var buscarSubfamilia = function(IdFamilia){
    parametroAjax.ruta=rutaB;
    parametroAjax.data = {IdFamilia:IdFamilia};
    respuesta=procesarajax(parametroAjax);
    if (respuesta.code==200){
        crearselect(respuesta.respuesta,"IdSubFamilia");
    }
}

var crearAllSelect = function(data){
    var v_proveedor =[{"id":1,"text":"proveedor 1"},{"id":2,"text":"proveedor 2"}];
    crearselect(v_proveedor,"IdUltimoProveedor");
    crearselect(data.v_familias,"IdFamilia");
    crearselect(data.v_unidad,"IdUnidadMedida");
    crearselect(data.v_estados,"EstadoProducto");
    crearselect(data.v_impuestos,"IdImpuesto");

}

var ManejoRespuestaBuscarProveedor = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta.v_proveedor!=null){
            $("#IdUltimoProveedor").val(respuesta.respuesta.v_proveedor.IdProveedor);
            $("#NombreProveedor").val(respuesta.respuesta.v_proveedor.NombreFantasia);
        }else{
            $.growl({message:"Proveedor no encontrado"},{type: "warning", allow_dismiss: true,});
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

var buscarProveedor = function(RUTProveedor){
    parametroAjax.ruta=rutaPP;
    parametroAjax.data = {RUTProveedor:RUTProveedor};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaBuscarProveedor(respuesta);
}

var verificarRut = function(control){
    var res = Valida_Rut(control);
    var format = formateaRut(control.val(), res);
    if (format != false){
        errorRut = 0;
        $("#ErrorRut").text("");
        buscarProveedor(format);
        return format;
    }else{
        errorRut = 1;
        $("#ErrorRut").text("Rut invalido");
        return control.val();
    }
}

$(document).ready(function(){
    cargarTablaProductos(d.v_productos);
    crearAllSelect(d);
    $(document).on('click','#guardar',validador);
    $(document).on('click','#guardarI',validadorI);
    $(document).on('click','#cancelar',BotonCancelar);
    $(document).on('click','#agregar',BotonAgregar);
    $(document).on('click','#modificar',modificarProducto);
    $(document).on('click','#volverAct',volverTabs);
    $("#IdFamilia").change(function() {
        buscarSubfamilia($("#IdFamilia").val());
    });

    $("#RUTProveedor").focusout(function() {
        var valid = $("#RUTProveedor").val();
        if (valid.length > 0){
            var res = verificarRut($("#RUTProveedor"));
            $("#RUTProveedor").val(res);
        }else{$("#ErrorRut").text("");}
    });

    $('#FormImpuesto').formValidation({
        excluded:[':disabled'],
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'IdImpuesto': {
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
        ProcesarImpuesto();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });


    $('#FormProducto').formValidation({
        excluded:[':disabled'],
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'CodigoBarra': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            // 'CodigoProveedor': {
            //     verbose: false,
            //     validators: {
            //         notEmpty: {
            //             message: 'El campo es requerido.'
            //         },
            //     }
            // },
            'NombreProducto': {
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                    stringLength: {
                        min: 4,
                        message: 'Debe tener mas de 3 caracteres'
                    },
                }
            },
            'DescripcionProducto': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'StockMinimo': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            // 'StockMaximo': {
            //     verbose: false,
            //     validators: {
            //         notEmpty: {
            //             message: 'El campo es requerido.'
            //         },
            //     }
            // },
            'StockRecomendado': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'PrecioUltimaCompra': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'PrecioVentaSugerido': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'IdFamilia': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            // 'IdSubFamilia': {
            //     verbose: false,
            //     validators: {
            //         notEmpty: {
            //             message: 'El campo es requerido.'
            //         },
            //     }
            // },
            // 'IdUnidadMedida': {
            //     verbose: false,
            //     validators: {
            //         notEmpty: {
            //             message: 'El campo es requerido.'
            //         },
            //     }
            // },
        }
    })
    .on('success.form.fv', function(e){
        ProcesarProducto();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});