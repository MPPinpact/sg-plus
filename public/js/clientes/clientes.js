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
    // if(respuesta.code==200){
        $(".divDetalles").toggle();
        // pintarDatosDetalles(respuesta.respuesta.v_detalles[0]);
        // cargarTablaClientes(respuesta.respuesta.v_clientes);
    // }else{
        // $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});       
    // }

}
// Manejo Activar / Desactivar empresa  
var ManejoRespuestaProcesarI = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta.activar>0){
            if(respuesta.respuesta.v_clientes.length>0){
                $.growl({message:"Procesado"},{type: "success", allow_dismiss: true,});
                cargarTablaClientes(respuesta.respuesta.v_clientes);
            }
        }else{
            $.growl({message:"Debe seleccionar un registro"},{type: "warning", allow_dismiss: true,});
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

// Manejo respuesta descontinuar Cliente
var ManejoRespuestaProcesarDescontinuar = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta.descontinuar>0){
            if(respuesta.respuesta.v_clientes.length>0){
                $.growl({message:"Procesado"},{type: "success", allow_dismiss: true,});
                cargarTablaClientes(respuesta.respuesta.v_clientes);
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
        var res = JSON.parse(respuesta.respuesta.f_registro.f_registro_cliente);
        switch(res.code) {
            case '200':
                $.growl({message:res.des_code},{type: "success", allow_dismiss: true,});
                $(".divForm").toggle();
                $('#FormCliente')[0].reset();
                $('#IdCliente').val("");
                cargarTablaClientes(respuesta.respuesta.v_clientes);
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

var cargarTablaClientes = function(data){
    if(limpiarLocales==1){destruirTabla('#tablaClientes');$('#tablaClientes thead').empty();}
        $("#tablaClientes").dataTable({ 
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
                    "data": "IdProducto",
                    "render": function(data, type, row, meta){
                        var result = `
                        <center>
                        <a href="#" onclick="verDetallesCliente(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Detalles" data-original-title="Detalle">
                            <i class="icofont icofont-search"></i>
                        </a>
                        <a href="#" onclick="cambiarEstatusProducto(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
                            <i class="icofont icofont-ui-delete"></i>
                        </a>
                        <a href="#" onclick="descontinuarProducto(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Descontinuar Cliente" data-original-title="Delete">
                            <i class="icofont icofont-close"></i>
                        </a>
                        </center>`;
                        return result; 
                    }
                },
                {"title": "Id","data": "IdCliente",visible:0},
                {"title": "RUT Cliente","data": "RUTCliente"},
                {"title": "Nombre Cliente","data": "NombreCliente"},
                {"title": "Direccion Cliente","data": "DireccionCliente"},
                {"title": "Dia de Pago","data": "DiaPago"},
                {"title": "Cupo Autorizado","data": "CupoAutorizado"},
                {"title": "Cupo Utilizado","data": "CupoUtilizado"},
                {"title": "Estado Cliente","data": "DetalleEstadoCliente"}
            ],
        });
        limpiarLocales=1;
    if (data.length>0){seleccionarTablaClientes();}
};

var seleccionarTablaClientes = function(data){
    var tableB = $('#tablaClientes').dataTable();
    $('#tablaClientes tbody').on('click', 'tr', function (e) {
        tableB.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        RegistroEmpresas = TablaTraerCampo('tablaClientes',this);
    });
    $('#tablaClientes tbody').on('dblclick', 'tr', function () {
        bloquearInuts();
        $("#divVolver").show();
        $("#divBtnModificar").show();
        $("#divBtnAceptar").hide();  
        cargarFormulario();
        pintarDatosActualizar(RegistroEmpresas);
    }); 
}

var cargarFormulario= function(){
    $(".divForm").toggle();
}

var pintarDatosActualizar= function(data){
    $(".md-form-control").addClass("md-valid");
    $("#spanTitulo").text("Editar Cliente");
    $("#IdCliente").val(data.IdCliente);
    $("#RUTCliente").val(data.RUTCliente);
    $("#NombreCliente").val(data.NombreCliente);
    $("#DireccionCliente").val(data.DireccionCliente);
    $("#DiaPago").val(data.DiaPago);
    $("#CupoAutorizado").val(data.CupoAutorizado);
    $("#CupoUtilizado").val(data.CupoUtilizado);
    $("#EstadoCliente").val(data.EstadoCliente).trigger("change");
}

var pintarDatosDetalles = function(data){
    $(".md-form-control").addClass("md-valid");
    $("#IdCliented").val(data.IdCliente);
    $("#NombreBodegad").val(data.NombreBodega);
    $("#DescripcionBodegad").val(data.DescripcionBodega);
    $("#IdCliented").val(data.IdCliente).trigger("change");
    $("#EstadoBodegad").val(data.EstadoBodega).trigger("change");
}

var BotonCancelar = function(){
    $(".md-form-control").removeClass("md-valid");
    $("#spanTitulo").text("Clientes registrados");
    $(".divForm").toggle();    
    $('#divConsulta').hide();
    $('#FormCliente')[0].reset();
    $("#IdCliente").val("");
    $('#divSpanPerfiles').hide();
}

var BotonAgregar = function(){
    $("#spanTitulo").text("Registrar Cliente");
    $("#divBtnModificar").hide();
    $("#divVolver").hide();
    $("#divBtnAceptar").show();
    cargarFormulario();
    $("#divConsulta").hide();
    $("#divSpanPerfiles").hide();
    $("#IdCliente").val("");
    $(".comboclear").val('').trigger("change");
    $('#FormCliente')[0].reset();
    desbloquearInuts();
}

var ProcesarCliente = function(){
    if (errorRut==0){  
        parametroAjax.ruta=ruta;
        parametroAjax.data = $("#FormCliente").serialize();
        respuesta=procesarajax(parametroAjax);
        ManejoRespuestaProcesar(respuesta);
    }
};

var validador = function(){
    $('#FormCliente').formValidation('validate');
};

var cambiarEstatusCliente = function(IdCliente){
    parametroAjax.ruta=rutaA;
    parametroAjax.data = {IdCliente:IdCliente};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarI(respuesta);
}

var descontinuarCliente = function(IdCliente){
    parametroAjax.ruta=rutaDes;
    parametroAjax.data = {IdCliente:IdCliente};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarDescontinuar(respuesta);   
}

var verDetallesCliente = function(IdCliente){
    parametroAjax.ruta=rutaD;
    parametroAjax.data = {IdCliente:IdCliente};
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
    $("#IdFamilia").prop('disabled', true);
    $("#IdSubFamilia").prop('disabled', true);
    $("#IdUnidadMedida").prop('disabled', true);
    $("#SeCompra").prop('disabled', true);
    $("#SeVende").prop('disabled', true);
    $("#EsProductoCombo").prop('disabled', true);
    $("#Descontinuado").prop('disabled', true);
    $("#IdBodega").prop('disabled', true);
    $("#EstadoProducto").prop('disabled', true);
}

var desbloquearInuts = function(){
    $("#CodigoBarra").prop('readonly', false);
    $("#CodigoProveedor").prop('readonly', false);
    $("#NombreProducto").prop('readonly', false);
    $("#DescripcionProducto").prop('readonly', false);
    $("#StockMinimo").prop('readonly', false);
    $("#StockMaximo").prop('readonly', false);
    $("#StockRecomendado").prop('readonly', false);
    // $("#PrecioUltimaCompra").prop('readonly', false);
    $("#PrecioVentaSugerido").prop('readonly', false);
    $("#IdUltimoProveedor").prop('disabled', false);
    $("#IdFamilia").prop('disabled', false);
    $("#IdSubFamilia").prop('disabled', false);
    $("#IdUnidadMedida").prop('disabled', false);
    $("#SeCompra").prop('disabled', false);
    $("#SeVende").prop('disabled', false);
    $("#EsProductoCombo").prop('disabled', false);
    $("#Descontinuado").prop('disabled', false);
    $("#IdBodega").prop('disabled', false);
    $("#EstadoProducto").prop('disabled', false);
}

var modificarBodega = function(){
    $("#divBtnModificar").hide();
    $("#divBtnAceptar").show();
    desbloquearInuts();    
}

var volverTabs = function(){
    $(".divDetalles").toggle();   
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
    var secompra=[{"id":1,"text":"SI"},{"id":0,"text":"NO"}];  
    var escombo=[{"id":1,"text":"SI"},{"id":2,"text":"NO"}];
    crearselect(escombo,"Descontinuado");
    crearselect(escombo,"EsProductoCombo");
    crearselect(secompra,"SeVende");
    crearselect(secompra,"SeCompra");
    crearselect(v_proveedor,"IdUltimoProveedor");
    crearselect(data.v_familias,"IdFamilia");
    crearselect(data.v_unidad,"IdUnidadMedida");
    crearselect(data.v_bodegas,"IdBodega");
    crearselect(data.v_estados,"EstadoProducto");    
}

$(document).ready(function(){
    $("#spanTitulo").text("Clientes registrados");
    cargarTablaClientes(d.v_clientes);
    crearAllSelect(d);
    $(document).on('click','#guardar',validador);
    $(document).on('click','#cancelar',BotonCancelar);
    $(document).on('click','#agregar',BotonAgregar);
    $(document).on('click','#modificar',modificarBodega);
    $(document).on('click','#volverAct',BotonCancelar);
    $(document).on('click','#btn-volver',volverTabs);

    
    $("#IdFamilia").change(function() {
        buscarSubfamilia($("#IdFamilia").val());
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
            'IdUltimoProveedor': {
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
            'IdBodega': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'EstadoCliente': {
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
        ProcesarCliente();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});