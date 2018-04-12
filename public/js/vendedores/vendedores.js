var RegistroEmpresas  = '';
var manejoRefresh=limpiarVendedores=errorRut=limpiarBodegas=0;

var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};

var ManejoRespuestaBuscarNombre = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta.v_usuario != null){
            $("#NombreVendedor").val(respuesta.respuesta.v_usuario.usrNombreFull);
        }else{
            $("#NombreVendedor").val("");
        }
    }else{
        $.growl({message:"Ocurrio un error tratando de buscar el vendedor"},{type: "danger", allow_dismiss: true,});
    }
}

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

// Manejo Activar / Desactivar vendedor
var ManejoRespuestaProcesarI = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta.activar>0){
            if(respuesta.respuesta.v_vendedores.length>0){
                $.growl({message:"Procesado"},{type: "success", allow_dismiss: true,});
                cargarTablaVendedores(respuesta.respuesta.v_vendedores);
            }
        }else{
            $.growl({message:"Debe seleccionar un registro"},{type: "warning", allow_dismiss: true,});
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

// Manejo Registro o actualizacion vendedor
var ManejoRespuestaProcesar = function(respuesta){
    console.log(respuesta);
    console.log(respuesta.respuesta);
    if(respuesta.code==200){
        var res = JSON.parse(respuesta.respuesta.f_registro);
        switch(res.code) {
            case '200':
                $.growl({message:res.des_code},{type: "success", allow_dismiss: true,});
                $(".divDetalles").toggle();
                $(".divBotones").toggle();
                $('#FormVendedor')[0].reset();
                $('#IdVendedor').val("");
                cargarTablaVendedores(respuesta.respuesta.v_vendedores);
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

var cargarTablaVendedores = function(data){
    if(limpiarVendedores==1){destruirTabla('#tablaVendedor');$('#tablaVendedor thead').empty();}
    $("#tablaVendedor").dataTable({
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
                "data": "IdVendedor",
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
            {"title": "IdVendedor","data": "IdVendedor",visible:0},
            {"title": "RUT","data": "RUTVendedor"},
            {"title": "Nombre","data": "NombreVendedor"},
            {"title": "Comisión","data": "ComisionVendedor"},
            {"title": "fecha de creacion","data": "auFechaCreacion",visible:0},
            {"title": "Usuario creacion","data": "auUsuarioCreacion",visible:0},
            {"title": "Creado por","data": "creador"},
            {"title": "auModificadoPor","data": "auUsuarioModificacion",visible:0},
            {"title": "auUsuarioModificacion","data": "auFechaModificacion",visible:0},
            {"title": "Modificado por","data": "modificador",visible:0},
            {"title": "Estado","data": "desEstadoVendedor"}
        ],
    });
    limpiarVendedores=1;
};


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
                {"title": "Id Bodega","data": "IdVendedor",visible:0},
                {"title": "Bodega","data": "NombreBodega"},
                {"title": "EstadoProducto","data": "EstadoProducto",visible:0},
                {"title": "Estado","data": "DesEstadoProducto"}
            ],
        });
        limpiarBodegas=1;
};

var pintarDatosActualizar= function(data){
    $(".md-form-control").addClass("md-valid");
    $("#IdVendedor").val(data.IdVendedor);
    $("#RUTVendedor").val(data.RUTVendedor);
    $("#NombreVendedor").val(data.NombreVendedor);
    $("#ComisionVendedor").val(data.ComisionVendedor);
    $("#EstadoVendedor").val(data.EstadoVendedor).trigger("change");
}

var BotonCancelar = function(){
    $(".md-form-control").removeClass("md-valid");
    $('#FormVendedor')[0].reset();
    $("#IdVendedor").val("");
    $("#divTabs").show();
    $(".divDetalles").toggle();
    $(".divBotones").toggle();
    bloquearInuts();
}

var BotonAgregar = function(){
    $("#spanTitulo").text("Registrar Vendedor");
    $("#divBtnModificar").hide();
    $("#divVolver").hide();
    $("#divBtnAceptar").show();
    $("#IdVendedor").val("");
    $(".comboclear").val('').trigger("change");
    $('#FormVendedor')[0].reset();
    $("#divTabs").hide();
    $(".divDetalles").toggle();
    $(".divBotones").toggle();
    desbloquearInuts();
}

var ProcesarVendedor = function(){
    if (errorRut==0){
        parametroAjax.ruta=ruta;
        parametroAjax.data = $("#FormVendedor").serialize();
        respuesta=procesarajax(parametroAjax);
        ManejoRespuestaProcesar(respuesta);
    }
};

var validador = function(){
    $('#FormVendedor').formValidation('validate');
};

var cambiarEstatus = function(IdVendedor){
    parametroAjax.ruta=rutaA;
    parametroAjax.data = {IdVendedor:IdVendedor};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarI(respuesta);
}

var verDetalles = function(IdVendedor){
    parametroAjax.ruta=rutaD;
    parametroAjax.data = {IdVendedor:IdVendedor};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarD(respuesta);
}

var verificarRut = function(control){
    var res = Valida_Rut(control);
    var format = formateaRut(control.val(), res);
    if (format != false){
        errorRut = 0;
        buscarNombreusuario(format);
        $("#ErrorRut").text("");
        return format;
    }else{
        errorRut = 1;
        $("#ErrorRut").text("Rut invalido");
        return control.val();
    }
}

var buscarNombreusuario = function(RUTVendedor){
    parametroAjax.ruta=rutaB;
    parametroAjax.data = {RUTVendedor:RUTVendedor};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaBuscarNombre(respuesta);
}

var bloquearInuts = function(){
    $("#RUTVendedor").prop('readonly', true);
    $("#NombreVendedor").prop('readonly', true);
    $("#ComisionVendedor").prop('readonly', true);
}

var desbloquearInuts = function(){
    $("#RUTVendedor").prop('readonly', false);
    $("#NombreVendedor").prop('readonly', false);
    $("#ComisionVendedor").prop('readonly', false);
}

var modificarBodega = function(){
    $("#spanTitulo").text("Editar Vendedor");
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
    $("#RUTVendedor").focusout(function() {
        var valid = $("#RUTVendedor").val();
        if (valid.length > 0){
            var res = verificarRut($("#RUTVendedor"));
            $("#RUTVendedor").val(res);
        }else{$("#ErrorRut").text("");}
    });
    cargarTablaVendedores(d.v_vendedores);
    crearAllSelect(d);
    $(document).on('click','#guardar',validador);
    $(document).on('click','#cancelar',BotonCancelar);
    $(document).on('click','#agregar',BotonAgregar);
    $(document).on('click','#modificar',modificarBodega);
    $(document).on('click','#volverAct',volverTabs);
    $('#FormVendedor').formValidation({
        excluded:[':disabled'],
        fields: {
            'RUTVendedor': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'ComisionVendedor': {
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    }
                }
            },
        }
    })
    .on('success.form.fv', function(e){
        ProcesarVendedor();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});