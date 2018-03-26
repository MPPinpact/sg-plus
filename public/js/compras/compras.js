var manejoRefresh=limpiarLocales=limpiarImpuestos=errorRut=errorRut2=errorRut3=limpiarBodegas=0;

var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};

var calcularMontos = function(CantidadComprada,ValorUnitario,FactorImpuesto,MontoDescuento){
    var ValorImpuesto = (CantidadComprada * ValorUnitario * FactorImpuesto / 100)
    $("#ValorImpuestos").val(ValorImpuesto);
    var TotalLinea = ((CantidadComprada * ValorUnitario) + ValorImpuesto - MontoDescuento);
    $("#TotalLinea").val(TotalLinea);
    var ValorUnitarioFinal = (TotalLinea / CantidadComprada);
    $("#ValorUnitarioFinal").val(ValorUnitarioFinal);
}

var ManejoRespuestaBuscarProducto = function(respuesta){
    console.log(respuesta);
    console.log(respuesta.respuesta);
    if(respuesta.code==200){
        if(respuesta.respuesta!=null){
            if(respuesta.respuesta.producto.IdProducto){
                if(respuesta.respuesta.producto.IdProducto==0){
                    $.growl({message:"Producto no encontrado"},{type: "warning", allow_dismiss: true});
                }else{
                    $("#IdProducto").val(respuesta.respuesta.producto.IdProducto);
                    $("#NombreProducto").val(respuesta.respuesta.producto.NombreProducto);
                    $("#ValorUnitario").val(respuesta.respuesta.producto.PrecioUltimaCompra);
                    $("#CantidadComprada").val(1);
                    $("#FactorImpuesto").val(respuesta.respuesta.impuesto);
                    $("#MontoDescuento").val(0);
                    $("#IdUnidadMedida").val(respuesta.respuesta.producto.IdUnidadMedida).trigger("change");
                    calcularMontos($("#CantidadComprada").val(),$("#ValorUnitario").val(),$("#FactorImpuesto").val(),$("#MontoDescuento").val());
                }    
            }    
        }else{
            $.growl({message:"Producto no encontrado"},{type: "warning", allow_dismiss: true});
        }
    }
}

var ManejoRespuestaBuscarProveedor = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta!=null){
            if(respuesta.respuesta.IdProveedor==0){
                var rut = $("#RUTProveedor").val();
                $("#RUTProveedor2").val(rut);
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

var ManejoRespuestaProcesarCompraD = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta!=null){
            $("#ModalDetalleCompra").modal();
            $("#spanTituloModal").text("Detalle Compra");
            $("#divBotonM").show();
            $("#divBotonesAC").hide();
            bloquearInputsDetalles();
            pintarDatosActualizarDetalles(respuesta.respuesta[0]);
        }else{
            $.growl({message:"Contacte al personal informatico"},{type: "warning", allow_dismiss: true,});
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

var ManejoRespuestaProcesarCD = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta.activar>0){
            if(respuesta.respuesta.v_detalles.length>0){
                $.growl({message:"Procesado"},{type: "success", allow_dismiss: true,});
                cargarTablaDetalles(respuesta.respuesta.v_detalles);
            }
        }else{
            $.growl({message:"Debe seleccionar un registro"},{type: "warning", allow_dismiss: true,});
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

var ManejoRespuestaProcesarD = function(respuesta){
    if(respuesta.code==200){
        bloquearInputs();
        $("#div-mod").show();
        $("#div-acep").hide();
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

// Manejo Registro de proveedor
var ManejoRespuestaProcesarProveedor = function(respuesta,nombre){
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

// Manejo Registro o actualizacion de cabecera de compra
var ManejoRespuestaProcesar = function(respuesta){
    if(respuesta.code==200){
        var res = JSON.parse(respuesta.respuesta.f_registro);
        switch(res.code) {
            case '200':
                $.growl({message:res.des_code},{type: "success", allow_dismiss: true,});
                // $(".divBotones").toggle();
                $("#div-mod").hide();
                $("#div-acep").hide();
                $("#aimpuestos").addClass("active");
                $("#TabImpuestos").addClass("active");
                $("#Tabdetalles").removeClass("active");
                $("#adetalles").removeClass("active");
                $("#divTabs").show();
                $("#divVolver").show();
               
                // $(".divDetalles").toggle();
                // $('#FormCompras')[0].reset();
                // $('#IdCompra').val("");
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

var ManejoRespuestaProcesarDetalles = function(respuesta){
    if(respuesta.code==200){
        var res = JSON.parse(respuesta.respuesta.f_registro);
        switch(res.code) {
            case '200':
                $.growl({message:res.des_code},{type: "success", allow_dismiss: true,});
                $(".divBotonesC").toggle();
                $("#ModalDetalleCompra").modal("hide");
                $('#IdDetalleCompra').val("");
                $('#FormDetalle')[0].reset();
                cargarTablaDetalles(respuesta.respuesta.v_detalles);
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

}

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
                        <a href="#" onclick="verDetallesCompraD(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Detalles" data-original-title="Delete">
                            <i class="icofont icofont-search"></i>
                        </a>
                        <a href="#" onclick="cambiarEstatusCompraD(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
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
                {"title": "Cantidad Comprada","data": "CantidadComprada"},
                {"title": "Nombre Producto","data": "NombreProducto"},
                {"title": "UM","data": "NombreUnidadMedida"},
                {"title": "Valor Unitario","data": "ValorUnitario"},
                {"title": "Monto Descuento","data": "MontoDescuento"},
                {"title": "Valor Unitario Final","data": "ValorUnitarioFinal"},
                {"title": "Total Linea","data": "TotalLinea"},
                {"title": "Factor Impuesto","data": "FactorImpuesto",visible:0},
                {"title": "Valor Impuestos","data": "ValorImpuestos",visible:0},
                {"title": "Estado","data": "DesEstadoCompra",visible:0},
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
    $("#IdProveedor").val(data.IdProveedor);
    $("#RUTProveedor").val(data.RUTProveedor);
    $("#NombreFantasia").val(data.NombreFantasiaProveedor);
    $("#idEmpresa").val(data.idEmpresa);
    $("#RUT").val(data.RUTEmpresa);
    $("#NombreFantasiaE").val(data.NombreFantasiaEmpresa);
    $("#FolioDTE").val(data.FolioDTE);
    $("#FechaDTE").val(moment(data.FechaDTE, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY"));
    $("#FechaVencimiento").val(moment(data.FechaVencimiento, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY"));
    $("#FechaPago").val(moment(data.FechaPago, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY"));
    $("#TotalNeto").val(data.TotalNeto);
    $("#TotalDescuentos").val(data.TotalDescuentos);
    $("#TotalImpuestos").val(data.TotalImpuestos);
    $("#TotalCompra").val(data.TotalCompra);
    var combos = buscarCombos(data.IdLocal,data.IdBodega);
    crearselect(combos.v_local,"IdLocal");    
    crearselect(combos.v_bodega,"IdBodega");
    $("#IdLocal").val(data.IdLocal).trigger("change");
    $("#TipoDTE").val(data.TipoDTE).trigger("change");
    $("#EstadoCompra").val(data.EstadoCompra).trigger("change");
    $("#IdBodega").val(data.IdBodega).trigger("change");
}

var pintarDatosActualizarDetalles = function(data){
    $("#IdDetalleCompra").val(data.IdDetalleCompra);
    $("#IdCompra2").val(data.IdCompra);
    $("#IdProducto").val(data.IdProducto);
    $("#CodigoBarra").val(data.CodigoBarra);
    $("#NombreProducto").val(data.NombreProducto);
    $("#IdUnidadMedida").val(data.IdUnidadMedida).trigger("change");
    $("#CantidadComprada").val(data.CantidadComprada);
    $("#ValorUnitario").val(data.ValorUnitario);
    $("#FactorImpuesto").val(data.FactorImpuesto);
    $("#ValorImpuestos").val(data.ValorImpuestos);
    $("#MontoDescuento").val(data.MontoDescuento);
    $("#ValorUnitarioFinal").val(data.ValorUnitarioFinal);
    $("#TotalLinea").val(data.TotalLinea);
    // $("#EstadoDetalleCompra").val(data.EstadoDetalleCompra).trigger("change");
}

var BotonAgregar = function(){
    $("#spanTitulo").text("Registrar Compra");
    desbloquearInputs();
    $(".divDetalles").toggle();
    $("#divVolver").hide();
    $("#IdCompra").val("");
    $(".comboclear").val('').trigger("change");
    $('#FormCompras')[0].reset();
    $("#divTabs").hide();
    $("#div-mod").hide();
    $("#div-acep").show();
    // $(".divBotones").toggle();
    $("#PrecioUltimaCompra").prop('readonly', false);
}

var BotonCancelar = function(){
    $("#spanTitulo").text("");
    $(".md-form-control").removeClass("md-valid");
    $('#FormCompras')[0].reset();
    $("#IdCompra").val("");
    $("#divTabs").show();
    $("#div-mod").hide();
    $("#div-acep").hide();
    // $(".divBotones").toggle();
    $(".divDetalles").toggle();
    bloquearInputs();
    $("#PrecioUltimaCompra").prop('readonly', true);
}

var volverListado = function(){
    $(".divDetalles").toggle();
    $('#FormCompras')[0].reset();
    $('#FormProveedorNew')[0].reset();
    $('#FormDetalle')[0].reset();
    $("#IdCompra").val("");
    $("#RUTProveedor2").val("");
    $("#IdDetalleCompra").val("");
    $("#IdCompra2").val("");
    $("#IdProducto").val("");
    $("#aimpuestos").removeClass("active");
    $("#TabImpuestos").removeClass("active");
    $("#Tabdetalles").addClass("active");
    $("#adetalles").addClass("active");
}

var BotonAgregarDetalle = function (){
    $("#spanTituloModal").text("Registrar Detalle");
    $("#divBotonM").hide();
    $("#divBotonesAC").show();
    $('#FormDetalle')[0].reset();
    $("#IdDetalleCompra").val("");
    $("#IdProducto").val("");
    $(".comboclear").val('').trigger("change");
    desbloquearInputsDetalles();
}

var BotonCancelarDetalle = function(){
    $("#ModalDetalleCompra").modal("hide");
    $("#divBotonM").hide();
    $("#divBotonesAC").hide();
    $('#FormDetalle')[0].reset();
    $("#IdDetalleCompra").val("");
    $("#IdProducto").val("");
    $(".comboclear").val('').trigger("change");
    bloquearInputsDetalles();
}

var ProcesarProveedor = function(){
    var nombre = $("#NombreFantasia2").val();
    parametroAjax.ruta=rutaPR;
    parametroAjax.data = $("#FormProveedorNew").serialize();
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarProveedor(respuesta,nombre);
};

var ProcesarCompra = function(){
    if(errorRut == 0 && errorRut2 == 0 && errorRut3==0){
        parametroAjax.ruta=ruta;
        parametroAjax.data = $("#FormCompras").serialize();
        respuesta=procesarajax(parametroAjax);
        ManejoRespuestaProcesar(respuesta);
    }
};

var ProcesarDetalleCompra = function(){
    parametroAjax.ruta=rutaDC;
    parametroAjax.data = $("#FormDetalle").serialize();
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarDetalles(respuesta);
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

var validadorD = function(){
    $('#FormDetalle').formValidation('validate');
};

var cambiarEstatusCompra = function(IdCompra){
    parametroAjax.ruta=rutaA;
    parametroAjax.data = {IdCompra:IdCompra};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarI(respuesta);
}

var verDetallesCompras = function(IdCompra){
    parametroAjax.ruta=rutaB;
    parametroAjax.data = {IdCompra:IdCompra};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarD(respuesta);
}

var verDetallesCompraD = function(IdDetalleCompra){
    parametroAjax.ruta=rutaBDC;
    parametroAjax.data = {IdDetalleCompra:IdDetalleCompra};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarCompraD(respuesta);
}

var cambiarEstatusCompraD = function(IdDetalleCompra){
    parametroAjax.ruta=rutaCDA;
    parametroAjax.data = {IdDetalleCompra:IdDetalleCompra};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarCD(respuesta);
}

var bloquearInputs = function(){
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


var desbloquearInputs = function(){
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

var bloquearInputsDetalles = function(){
    $("#CodigoBarra").prop('readonly', true);
    $("#NombreProducto").prop('readonly', true);
    $("#CantidadComprada").prop('readonly', true);
    $("#ValorUnitario").prop('readonly', true);
    // $("#FactorImpuesto").prop('readonly', true);
    // $("#ValorImpuestos").prop('readonly', true);
    $("#MontoDescuento").prop('readonly', true);
    // $("#ValorUnitarioFinal").prop('readonly', true);
    // $("#TotalLinea").prop('readonly', true);
    $("#IdUnidadMedida").prop('disabled', true);
    // $("#EstadoDetalleCompra").prop('disabled', true);
}

var desbloquearInputsDetalles = function(){
    $("#CodigoBarra").prop('readonly', false);
    $("#NombreProducto").prop('readonly', false);
    $("#CantidadComprada").prop('readonly', false);
    $("#ValorUnitario").prop('readonly', false);
    // $("#FactorImpuesto").prop('readonly', false);
    // $("#ValorImpuestos").prop('readonly', false);
    $("#MontoDescuento").prop('readonly', false);
    // $("#ValorUnitarioFinal").prop('readonly', false);
    // $("#TotalLinea").prop('readonly', false);
    $("#IdUnidadMedida").prop('disabled', false);
    // $("#EstadoDetalleCompra").prop('disabled', false);
}

var modificarCabeceras = function(){
    $("#spanTitulo").text("Editar Compra");
    $("#divVolver").hide();
    // $(".divBotones").toggle();
    $("#div-mod").hide();
    $("#div-acep").show();
    desbloquearInputs();
}

var modificarDetalles = function(){
    $("#spanTituloModal").text("Editar Detalle");
    $("#divBotonM").hide();
    $("#divBotonesAC").show();
    desbloquearInputsDetalles();
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
    crearselect(data.v_tipo_dte,"TipoDTE");
    crearselect(data.v_estados,"EstadoCompra");
    crearselect(data.v_estados,"EstadoDetalleCompra");
    crearselect(data.v_unidad_medida,"IdUnidadMedida");
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

var buscarCombos = function(IdLocal,IdBodega){
    parametroAjax.ruta=rutaBC;
    parametroAjax.data = {IdLocal:IdLocal,IdBodega:IdBodega};
    respuesta=procesarajax(parametroAjax);
    if(respuesta.code==200){var res = respuesta.respuesta;}
    else{ var res= 0; }
    return res;
}

var buscarProducto = function(CodigoBarra){
    parametroAjax.ruta=rutaBPD;
    parametroAjax.data = {CodigoBarra:CodigoBarra};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaBuscarProducto(respuesta);
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

var calcularFechaPago = function (fecha){
    var FechaDTE = moment(fecha, 'DD-MM-YYYY',true).format("YYYY-MM-DD");
    var FechaSuma = moment(FechaDTE).add(1, 'month').format("YYYY-MM-DD");
    var FechaVencimiento = moment(FechaSuma, 'YYYY-MM-DD',true).format("DD-MM-YYYY");
    $("#FechaVencimiento").val(FechaVencimiento);
    $("#FechaPago").val(FechaVencimiento);
    $("#FechaVencimiento").focus();
    $("#FechaPago").focus();
    $("#TotalNeto").focus();
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
    $("#FechaDTE").focusout(function() {
        calcularFechaPago($("#FechaDTE").val());
    });
    $("#CodigoBarra").focusout(function() {
        buscarProducto($("#CodigoBarra").val());
    });

    $("#CantidadComprada").focusout(function() {
        calcularMontos($("#CantidadComprada").val(),$("#ValorUnitario").val(),$("#FactorImpuesto").val(),$("#MontoDescuento").val());
    });

    $("#ValorUnitario").focusout(function() {
        calcularMontos($("#CantidadComprada").val(),$("#ValorUnitario").val(),$("#FactorImpuesto").val(),$("#MontoDescuento").val());
    });

    $("#MontoDescuento").focusout(function() {
        calcularMontos($("#CantidadComprada").val(),$("#ValorUnitario").val(),$("#FactorImpuesto").val(),$("#MontoDescuento").val());
    });

    // Botones de cabecera de compra
    $(document).on('click','#guardar',validador);
    $(document).on('click','#guardarI',validadorI);
    $(document).on('click','#aceptarM',validadorP);
    $(document).on('click','#cancelar',BotonCancelar);
    $(document).on('click','#agregar',BotonAgregar);
    $(document).on('click','#modificar',modificarCabeceras);
    $(document).on('click','#volverAct',volverTabs);
    // Botones de detalles de compra
    $(document).on('click','#agregarC',BotonAgregarDetalle);
    $(document).on('click','#guardarC',validadorD);
    $(document).on('click','#cancelarC',BotonCancelarDetalle);
    $(document).on('click','#closeModal',BotonCancelarDetalle);
    $(document).on('click','#modificarC',modificarDetalles);
    $(document).on('click','#btn-list',volverListado);



    // $("#RUTProveedor").focusout(function() {
    //     var valid = $("#RUTProveedor").val();
    //     if (valid.length > 0){
    //         var res = verificarRut($("#RUTProveedor"));
    //         $("#RUTProveedor").val(res);
    //     }else{$("#ErrorRut").text("");}
    // });

    $('#FormDetalle').on('keyup keypress', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) { 
        e.preventDefault();
        return false;
      }
    });

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
            'NombreFantasia2': {
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
            'IdOrdenCompra': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'RUTProveedor': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            // 'NombreFantasia': {
            //     validators: {
            //         notEmpty: {
            //             message: 'El campo es requerido.'
            //         }
            //     }
            // },
            'RUT': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            // 'NombreFantasiaE': {
            //     verbose: false,
            //     validators: {
            //         notEmpty: {
            //             message: 'El campo es requerido.'
            //         },
            //     }
            // },
            'IdLocal': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'IdBodega': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'TipoDTE': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'FolioDTE': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'FechaDTE': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'FechaVencimiento': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'FechaPago': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'TotalNeto': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'TotalDescuentos': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'TotalImpuestos': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'TotalCompra': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'EstadoCompra': {
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

    $('#FormDetalle').formValidation({
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
            'IdUnidadMedida': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'CantidadComprada': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'ValorUnitario': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            // 'FactorImpuesto': {
            //     verbose: false,
            //     validators: {
            //         notEmpty: {
            //             message: 'El campo es requerido.'
            //         },
            //     }
            // },
            // 'ValorImpuestos': {
            //     verbose: false,
            //     validators: {
            //         notEmpty: {
            //             message: 'El campo es requerido.'
            //         },
            //     }
            // },
            'MontoDescuento': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            }
            // ,
            // 'ValorUnitarioFinal': {
            //     verbose: false,
            //     validators: {
            //         notEmpty: {
            //             message: 'El campo es requerido.'
            //         },
            //     }
            // },
            // 'TotalLinea': {
            //     verbose: false,
            //     validators: {
            //         notEmpty: {
            //             message: 'El campo es requerido.'
            //         },
            //     }
            // }
            // ,
            // 'EstadoDetalleCompra': {
            //     verbose: false,
            //     validators: {
            //         notEmpty: {
            //             message: 'El campo es requerido.'
            //         },
            //     }
            // }
        }
    })
    .on('success.form.fv', function(e){
        ProcesarDetalleCompra();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});