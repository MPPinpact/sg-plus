var manejoRefresh=limpiarLocales=limpiarImpuestos=errorRut=errorRut2=errorRut3=limpiarBodegas=0;

var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};

var ManejoRespuestaBuscarProveedor = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta!=null){
            if(respuesta.respuesta.IdProveedor==0){
                var rut = $("#RUTProveedor").val();
                $("#RUTProveedor2").val(rut);
                // console.log(rut),
                $("#ModalProveedor").modal();
            }else{
                $("#IdProveedor").val(respuesta.respuesta.IdProveedor);
                $("#NombreFantasia").val(respuesta.respuesta.NombreFantasia);
            }    
        }else{
            $.growl({message:"Proveedor no encontrado"},{type: "warning", allow_dismiss: true,});
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

var ManejoRespuestaBuscarEmpresa = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta!=null){
            crearselect(respuesta.respuesta.v_locales,"IdLocal");
            if(respuesta.respuesta.busqueda.IdEmpresa==0){
                $("#idEmpresa").val("");
                $("#NombreFantasiaE").val("");
                $.growl({message:"Empresa no encontrada"},{type: "warning", allow_dismiss: true,});
            }else{
                $("#idEmpresa").val(respuesta.respuesta.busqueda.IdEmpresa);
                $("#NombreFantasiaE").val(respuesta.respuesta.busqueda.NombreFantasia);
            }    
        }else{
            $.growl({message:"Contacte al personal informatico"},{type: "warning", allow_dismiss: true,});
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}
var ManejoRespuestaProcesarD = function(respuesta){
    if(respuesta.code==200){
        bloquearInuts();
        $(".divDetalles").toggle();
        $("#divVolver").show();
        $("#divTabs").show();
        $("#spanTitulo").text("Detalles");
        $("#IdCompra2").val(respuesta.respuesta.v_detalles.IdCompra);
        pintarDatosActualizar(respuesta.respuesta.v_cabecera[0]);
        cargarTablaDetalles(respuesta.respuesta.v_detalles);
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

// Manejo Activar / Desactivar compra
var ManejoRespuestaProcesarI = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta.activar>0){
            if(respuesta.respuesta.v_compras.length>0){
                $.growl({message:"Procesado"},{type: "success", allow_dismiss: true,});
                cargarTablaCompras(respuesta.respuesta.v_compras);
            }
        }else{
            $.growl({message:"Debe seleccionar un registro"},{type: "warning", allow_dismiss: true,});
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

// // Manejo Activar / Desactivar Impuesto a producto
// var ManejoRespuestaProcesarAI = function(respuesta){
//     if(respuesta.code==200){
//         if(respuesta.respuesta.activar>0){
//             $.growl({message:"Procesado"},{type: "success", allow_dismiss: true,});
//             cargarTablaDetalles(respuesta.respuesta.v_impuestos);
//         }else{
//             $.growl({message:"Debe seleccionar un registro"},{type: "warning", allow_dismiss: true,});
//         }
//     }else{
//         $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
//     }
// }

// // Manejo respuesta descontinuar Producto
// var ManejoRespuestaProcesarDescontinuar = function(respuesta){
//     if(respuesta.code==200){
//         if(respuesta.respuesta.descontinuar>0){
//             if(respuesta.respuesta.v_compras.length>0){
//                 $.growl({message:"Procesado"},{type: "success", allow_dismiss: true,});
//                 cargarTablaCompras(respuesta.respuesta.v_compras);
//             }
//         }else{
//             $.growl({message:"Debe seleccionar un registro"},{type: "warning", allow_dismiss: true,});
//         }
//     }else{
//         $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
//     }
// }

// Manejo Registro de proveedor
var ManejoRespuestaProcesarProveedor = function(respuesta,nombre){
    console.log(respuesta);
    console.log(respuesta.respuesta);
    console.log(nombre);
    if(respuesta.code==200){
        if(respuesta.respuesta>0){
            $("#IdProveedor").val(respuesta.respuesta);
            $("#NombreFantasia").val(nombre);
            $("#ModalProveedor").modal("hide");
        }else{
            $.growl({message:"ocurrió un error mientras se registraba el proveedor"},{type: "warning", allow_dismiss: true,}); 
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
};

// Manejo Registro o actualizacion de empresa
var ManejoRespuestaProcesar = function(respuesta){
    if(respuesta.code==200){
        var res = JSON.parse(respuesta.respuesta.f_registro);
        switch(res.code) {
            case '200':
                $.growl({message:res.des_code},{type: "success", allow_dismiss: true,});
                $(".divDetalles").toggle();
                $(".divBotones").toggle();
                $('#FormCompras')[0].reset();
                $('#IdCompra').val("");
                cargarTablaCompras(respuesta.respuesta.v_compras);
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

var cargarTablaCompras = function(data){
    if(limpiarLocales==1){destruirTabla('#tablaCompras');$('#tablaCompras thead').empty();}
        $("#tablaCompras").dataTable({
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
                    "data": "IdCompra",
                    "render": function(data, type, row, meta){
                        var result = `
                        <center>
                        <a href="#" onclick="verDetallesCompras(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Detalles" data-original-title="Delete">
                            <i class="icofont icofont-search"></i>
                        </a>
                        <a href="#" onclick="cambiarEstatusCompra(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
                            <i class="icofont icofont-ui-delete"></i>
                        </a>
                        </center>`;
                        return result;
                    }
                },
                {"title": "Id","data": "IdCompra",visible:0},
                {"title": "OC.","data": "IdOrdenCompra"},
                {"title": "IdProveedor","data": "IdProveedor",visible:0},
                {"title": "IdBodega","data": "IdBodega",visible:0},
                {"title": "RUT Proveedor","data": "RUTProveedor"},
                {"title": "Tipo DTE","data": "TipoDTE"},
                {"title": "Folio DTE","data": "FolioDTE"},
                {"title": "Total Neto","data": "TotalNeto"},
                {"title": "Total Descuentos","data": "TotalDescuentos"},
                {"title": "Total Impuestos","data": "TotalImpuestos"},
                {"title": "Total Compra","data": "TotalCompra"},
                {"title": "EstadoCompra","data": "EstadoCompra",visible:0},
                {
                    "title": "Fecha DTE", 
                    "data": "FechaDTE",
                    "render": function(data, type, row, meta){
                        if(type === 'display'){
                            data = moment(data, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY");
                        }
                        return data;
                    }
                },
                {"title": "Estado","data": "DesEstadoCompra"}
            ],
        });
        limpiarLocales=1;
};

var cargarTablaDetalles = function(data){
    if(limpiarImpuestos==1){destruirTabla('#tablaDetalles');$('#tablaDetalles thead').empty();}
        $("#tablaDetalles").dataTable({
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
                    "data": "IdDetalleCompra",
                    "render": function(data, type, row, meta){
                        var result = `
                        <center>
                        <a href="#" onclick="cambiarEstatusDetalles(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
                            <i class="icofont icofont-ui-delete"></i>
                        </a>
                        </center>`;
                        return result;
                    }
                },
                {"title": "Id","data": "IdDetalleCompra",visible:0},
                {"title": "IdCompra","data": "IdCompra",visible:0},
                {"title": "IdProducto","data": "IdProducto",visible:0},
                {"title": "IdUnidadMedida","data": "IdUnidadMedida",visible:0},
                {"title": "Nombre Producto","data": "NombreProducto"},
                {"title": "Nombre Unidad Medida","data": "NombreUnidadMedida"},
                {"title": "Cantidad Comprada","data": "CantidadComprada"},
                {"title": "Valor Unitario","data": "ValorUnitario"},
                {"title": "Factor Impuesto","data": "FactorImpuesto"},
                {"title": "Valor Impuestos","data": "ValorImpuestos"},
                {"title": "Monto Descuento","data": "MontoDescuento"},
                {"title": "Valor Unitario Final","data": "ValorUnitarioFinal"},
                {"title": "Total Linea","data": "TotalLinea"},
                {"title": "Estado","data": "DesEstadoCompra"},
                {"title": "Precio Venta Sugerido","data": "auFechaCreacion",visible:0},
                {"title": "Precio Venta Sugerido","data": "auUsuarioCreacion",visible:0},
                {"title": "Precio Venta Sugerido","data": "auFechaModificacion",visible:0},
                {"title": "Precio Venta Sugerido","data": "auFechaModificacion",visible:0},
                {"title": "EstadoDetalleCompra","data": "EstadoDetalleCompra",visible:0}
            ],
        });
        limpiarImpuestos=1;
};

var pintarDatosActualizar= function(data){
    $(".md-form-control").addClass("md-valid");
    $("#IdCompra").val(data.IdCompra);
    $("#IdCompra2").val(data.IdCompra);
    $("#IdOrdenCompra").val(data.IdOrdenCompra);
    $("#RUTProveedor").val(data.RUTProveedor);
    $("#FolioDTE").val(data.FolioDTE);
    $("#FechaDTE").val(moment(data.FechaDTE, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY"));
    $("#FechaVencimiento").val(moment(data.FechaVencimiento, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY"));
    $("#FechaPago").val(moment(data.FechaPago, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY"));
    $("#FechaPago").val(data.FechaPago);
    $("#TotalNeto").val(data.TotalNeto);
    $("#TotalDescuentos").val(data.TotalDescuentos);
    $("#TotalImpuestos").val(data.TotalImpuestos);
    $("#TotalCompra").val(data.TotalCompra);
    $("#IdBodega").val(data.IdBodega).trigger("change");
    $("#TipoDTE").val(data.TipoDTE).trigger("change");
    $("#EstadoCompra").val(data.EstadoCompra).trigger("change");
}

var BotonCancelar = function(){
    $("#spanTitulo").text("");
    $(".md-form-control").removeClass("md-valid");
    $('#FormCompras')[0].reset();
    $("#IdCompra").val("");
    $("#divTabs").show();
    $(".divBotones").toggle();
    $(".divDetalles").toggle();
    bloquearInuts();
    $("#PrecioUltimaCompra").prop('readonly', true);
}

var BotonAgregar = function(){
    $("#spanTitulo").text("Registrar Compra");
    desbloquearInuts();
    $(".divDetalles").toggle();
    $("#divVolver").hide();
    $("#IdCompra").val("");
    $(".comboclear").val('').trigger("change");
    $('#FormCompras')[0].reset();
    $("#divTabs").hide();
    $(".divBotones").toggle();
    $("#PrecioUltimaCompra").prop('readonly', false);
}

var BotonAgregarCabecera = function (){
    $(".divCabecera").toggle();
    $('#FormCabecera')[0].reset();
    $("#IdDetalleCompra").val("");
    $(".comboclear").val('').trigger("change");
}

var ProcesarProveedor = function(){
    var nombre = $("#NombreFantasia2").val();
    parametroAjax.ruta=rutaPR;
    parametroAjax.data = $("#FormProveedorNew").serialize();
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarProveedor(respuesta,nombre);
};

var ProcesarCompra = function(){
    if(errorRut == 0){
        parametroAjax.ruta=ruta;
        parametroAjax.data = $("#FormCompras").serialize();
        respuesta=procesarajax(parametroAjax);
        ManejoRespuestaProcesar(respuesta);
    }
};

var validador = function(){
    $('#FormCompras').formValidation('validate');
};

var validadorP = function(){
    $('#FormProveedorNew').formValidation('validate');
};

var validadorI = function(){
    $('#FormImpuesto').formValidation('validate');
}

var cambiarEstatusCompra = function(IdCompra){
    parametroAjax.ruta=rutaA;
    parametroAjax.data = {IdCompra:IdCompra};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarI(respuesta);
}


var cambiarEstatusDetalles = function(IdDetalleCompra){
/*
    parametroAjax.ruta=rutaAI;
    parametroAjax.data = {IdDetalleCompra:IdDetalleCompra};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarAI(respuesta);
*/
}


var verDetallesCompras = function(IdCompra){
    parametroAjax.ruta=rutaB;
    parametroAjax.data = {IdCompra:IdCompra};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarD(respuesta);
}

var bloquearInuts = function(){
    $("#IdOrdenCompra").prop('readonly', true);
    $("#RUTProveedor").prop('readonly', true);
    $("#RUT").prop('readonly', true);
    $("#FolioDTE").prop('readonly', true);
    $("#FechaDTE").prop('readonly', true);
    $("#FechaVencimiento").prop('readonly', true);
    $("#FechaPago").prop('readonly', true);
    $("#TotalNeto").prop('readonly', true);
    $("#TotalDescuentos").prop('readonly', true);
    $("#TotalImpuestos").prop('readonly', true);
    $("#TotalCompra").prop('readonly', true);
    $("#IdBodega").prop('disabled', true);
    $("#TipoDTE").prop('disabled', true);
    $("#IdLocal").prop('disabled', true);
    $("#EstadoCompra").prop('disabled', true);
}

var desbloquearInuts = function(){
    $("#IdOrdenCompra").prop('readonly', false);
    $("#RUTProveedor").prop('readonly', false);
    $("#RUT").prop('readonly', false);
    $("#FolioDTE").prop('readonly', false);
    $("#FechaDTE").prop('readonly', false);
    $("#FechaVencimiento").prop('readonly', false);
    $("#FechaPago").prop('readonly', false);
    $("#TotalNeto").prop('readonly', false);
    $("#TotalDescuentos").prop('readonly', false);
    $("#TotalImpuestos").prop('readonly', false);
    $("#TotalCompra").prop('readonly', false);
    $("#IdBodega").prop('disabled', false);
    $("#TipoDTE").prop('disabled', false);
    $("#IdLocal").prop('disabled', false);
    $("#EstadoCompra").prop('disabled', false);

}

var modificarProducto = function(){
    $("#spanTitulo").text("Editar Compra");
    $("#divVolver").hide();
    $(".divBotones").toggle();
    desbloquearInuts();
}

var volverTabs = function(){
    $("#spanTitulo").text("");
    $(".divDetalles").toggle();
    $("#aimpuestos").removeClass("active");
    $("#astock").removeClass("active");
    $("#akardex").removeClass("active");
    $("#TabImpuestos").removeClass("active");
    $("#TabStock").removeClass("active");
    $("#TabKardex").removeClass("active");
    $("#Tabdetalles").addClass("active");
    $("#adetalles").addClass("active");
}

var crearAllSelect = function(data){
    // var v_TipoDtes =[{"id":1,"text":"DTE 1"},{"id":2,"text":"DTE 2"},{"id":3,"text":"DTE 3"},{"id":4,"text":"DTE 4"}];
    crearselect(data.v_tipo_dte,"TipoDTE");
    crearselect(data.v_estados,"EstadoCompra");
    // crearselect(data.v_bodegas,"IdBodega");
}


var verificarRut = function(control,caso){
    var res = Valida_Rut(control);
    var format = formateaRut(control.val(), res);
    if (format != false){
        errorRut = 0;
        errorRut2 = 0;
        if (caso==1){buscarProveedor(format);$("#ErrorRut").text("");}
        if (caso==2){$("#ErrorRut2").text("");}
        if (caso==3){buscarEmpresa(format);$("#ErrorRut3").text("");}
        return format;
    }else{
        if (caso==1){errorRut = 1;$("#ErrorRut").text("Rut invalido");}
        if (caso==2){errorRut2 = 1;$("#ErrorRut2").text("Rut invalido");}
        if (caso==3){errorRut3 = 1;$("#ErrorRut3").text("Rut invalido");}
        return control.val();
    }
}

var crearFormatoFecha = function(){
    $("#FechaDTE").inputmask({ mask: "99-99-9999"});
    $("#FechaVencimiento").inputmask({ mask: "99-99-9999"});
    $("#FechaPago").inputmask({ mask: "99-99-9999"});
}

var buscarProveedor = function(RUTProveedor){
    parametroAjax.ruta=rutaBP;
    parametroAjax.data = {RUTProveedor:RUTProveedor};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaBuscarProveedor(respuesta);
}

var buscarEmpresa = function(RUTEmpresa){
    parametroAjax.ruta=rutaBE;
    parametroAjax.data = {RUTEmpresa:RUTEmpresa};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaBuscarEmpresa(respuesta);
}

var buscarBodegas = function(IdLocal){
    parametroAjax.ruta=rutaBB;
    parametroAjax.data = {IdLocal:IdLocal};
    respuesta=procesarajax(parametroAjax);
    if (respuesta.code==200){
        crearselect(respuesta.respuesta,"IdBodega");
    }
}

$(document).ready(function(){
    crearFormatoFecha();
    cargarTablaCompras(d.v_compras);
    crearAllSelect(d);
    $("#IdLocal").change(function() {
        buscarBodegas($("#IdLocal").val());
    });
    $("#RUTProveedor").focusout(function() {
        var valid = $("#RUTProveedor").val();
        if (valid.length > 0){
            var res = verificarRut($("#RUTProveedor"),1);
            $("#RUTProveedor").val(res);
        }else{$("#ErrorRut").text("");}
    });
    $("#RUTProveedor2").focusout(function() {
        var valid = $("#RUTProveedor2").val();
        if (valid.length > 0){
            var res = verificarRut($("#RUTProveedor2"),2);
            $("#RUTProveedor2").val(res);
        }else{$("#ErrorRut2").text("");}
    });

    $("#RUT").focusout(function() {
        var valid = $("#RUT").val();
        if (valid.length > 0){
            var res = verificarRut($("#RUT"),3);
            $("#RUT").val(res);
        }else{$("#ErrorRut3").text("");}
    });
    $(document).on('click','#guardar',validador);
    $(document).on('click','#guardarI',validadorI);
    $(document).on('click','#cancelar',BotonCancelar);
    $(document).on('click','#agregar',BotonAgregar);
    $(document).on('click','#modificar',modificarProducto);
    $(document).on('click','#volverAct',volverTabs);
    $(document).on('click','#agregarC',BotonAgregarCabecera);

    $(document).on('click','#aceptarM',validadorP);
    // $("#RUTProveedor").focusout(function() {
    //     var valid = $("#RUTProveedor").val();
    //     if (valid.length > 0){
    //         var res = verificarRut($("#RUTProveedor"));
    //         $("#RUTProveedor").val(res);
    //     }else{$("#ErrorRut").text("");}
    // });

    $('#FormProveedorNew').formValidation({
        excluded:[':disabled'],
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'RUTProveedor2': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
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
        }
    })
    .on('success.form.fv', function(e){
        ProcesarProveedor();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });



    $('#FormCompras').formValidation({
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
            'CodigoProveedor': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'NombreProducto': {
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    }
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
            'StockMaximo': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
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
            'IdSubFamilia': {
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
            'SeCompra': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'SeVende': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'EsProductoCombo': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'Descontinuado': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'EstadoProducto': {
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
        ProcesarCompra();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});