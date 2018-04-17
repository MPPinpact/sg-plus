var RegistroEmpresas  = '';
var manejoRefresh=limpiarVendedores=errorRut=limpiarMetas=0;

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
        $('#FormMetas')[0].reset();        
        bloquearInuts();
        $("#divVolver").show();
        pintarDatosActualizar(respuesta.respuesta.v_detalles[0]);
        cargarTablaMetas(respuesta.respuesta.v_metas);
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

var ManejoRespuestaProcesarDetalles = function(respuesta){
    if(respuesta.code==200){
        pintarDatosActualizarMetas(respuesta.respuesta.v_detallesM[0]);
        bloquearInutsMetas();
        $("#divModificarM").show();
        $("#divAceptarM").hide();
        $("#ModalMetas").modal();
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

var ManejoRespuestaProcesarEstatusM = function(respuesta){
    if(respuesta.code==200){
        $.growl({message:"Procesado"},{type: "success", allow_dismiss: true,});
        cargarTablaMetas(respuesta.respuesta.v_metas);
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}


// Manejo Registro o actualizacion vendedor
var ManejoRespuestaProcesar = function(respuesta){
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


// Manejo Registro o actualizacion meta
var ManejoRespuestaProcesarMeta = function(respuesta){
    if(respuesta.code==200){
        var res = JSON.parse(respuesta.respuesta.f_registro);
        switch(res.code) {
            case '200':
                $.growl({message:res.des_code},{type: "success", allow_dismiss: true,});
                $('#PeriodoVentaInicio').val("");
                $('#PeriodoVentaFin').val("");
                $('#MetaPeriodo').val("");
                $("#ModalMetas").modal("hide");
                cargarTablaMetas(respuesta.respuesta.v_metas);
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
            {"title": "Nombre Vendedor","data": "NombreVendedor"},
            {"title": "Comisión x Venta","data": "ComisionVendedor",
					render: $.fn.dataTable.render.number( '.', ',', 2 ),
					className: "text-right"},
            {"title": "fecha de creacion","data": "auFechaCreacion",visible:0},
            {"title": "Usuario creacion","data": "auUsuarioCreacion",visible:0},
            {"title": "Creado por","data": "creador",visible:0},
            {"title": "auModificadoPor","data": "auUsuarioModificacion",visible:0},
            {"title": "auUsuarioModificacion","data": "auFechaModificacion",visible:0},
            {"title": "Modificado por","data": "modificador",visible:0},
            {"title": "Estado Vendedor","data": "desEstadoVendedor"}
        ],
    });
    limpiarVendedores=1;
};


var cargarTablaMetas = function(data){
    if(limpiarMetas==1){destruirTabla('#tablaMetas');}
        $("#tablaMetas").dataTable({
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
                {"title": "IdMeta","data": "IdMeta",visible:0},
                {"title": "IdVendedor","data": "IdVendedor",visible:0},
                {
                    "title": "",
                    "data": "IdMeta",
                    "render": function(data, type, row, meta){
                        var result = `
                        <center>
                        <a href="#" onclick="verDetallesM(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Detalles" data-original-title="Delete">
                            <i class="icofont icofont-search"></i>
                        </a>
                        <a href="#" onclick="cambiarEstatusM(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
                            <i class="icofont icofont-ui-delete"></i>
                        </a>
                        </center>`;
                        return result;
                    }
                },
                {
                    "title": "Fecha Inicio", 
                    "data": "PeriodoVentaInicio",
                    "render": function(data, type, row, meta){
                        if(type === 'display'){
                            data = moment(data, 'YYYY-MM-DD',true).format("DD-MM-YYYY");
                        }
                        return data;
                    }
                },
                {
                    "title": "Fecha Fin", 
                    "data": "PeriodoVentaFin",
                    "render": function(data, type, row, meta){
                        if(type === 'display'){
                            data = moment(data, 'YYYY-MM-DD',true).format("DD-MM-YYYY");
                        }
                        return data;
                    }
                },
                {"title": "Monto Meta","data": "MetaPeriodo",render: $.fn.dataTable.render.number( '.', ',', 2 ),className: "text-right"},

            ],
        });
        limpiarMetas=1;
};

var pintarDatosActualizar= function(data){
    $(".md-form-control").addClass("md-valid");
    $("#IdVendedor").val(data.IdVendedor);
    $("#IdVendedor2").val(data.IdVendedor);
    $("#RUTVendedor").val(data.RUTVendedor);
    $("#NombreVendedor").val(data.NombreVendedor);
    $("#ComisionVendedor").val(data.ComisionVendedor);
    $("#EstadoVendedor").val(data.EstadoVendedor).trigger("change");
}

var pintarDatosActualizarMetas = function(data){
    $("#IdMeta").val(data.IdMeta);
    $("#IdVendedor2").val(data.IdVendedor);
    $("#PeriodoVentaInicio").val(moment(data.PeriodoVentaInicio, 'YYYY-MM-DD',true).format("DD-MM-YYYY"));
    $("#PeriodoVentaFin").val(moment(data.PeriodoVentaFin, 'YYYY-MM-DD',true).format("DD-MM-YYYY"));
    $("#MetaPeriodo").val(data.MetaPeriodo);
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

var ProcesarMeta = function(){
        parametroAjax.ruta=rutaM;
        parametroAjax.data = $("#FormMetas").serialize();
        respuesta=procesarajax(parametroAjax);
        ManejoRespuestaProcesarMeta(respuesta);
};

var validador = function(){
    $('#FormVendedor').formValidation('validate');
};

var validadorM = function(){
    $('#FormMetas').formValidation('validate');
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

var verDetallesM = function(IdMeta){
    parametroAjax.ruta=rutaDM;
    parametroAjax.data = {IdMeta:IdMeta};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarDetalles(respuesta);
}

var cambiarEstatusM = function(IdMeta){
    parametroAjax.ruta=rutaE;
    parametroAjax.data = {IdMeta:IdMeta,IdVendedor:$("#IdVendedor2").val()};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarEstatusM(respuesta);
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

var bloquearInutsMetas = function(){
    $("#PeriodoVentaInicio").prop('readonly', true);
    $("#PeriodoVentaFin").prop('readonly', true);
    $("#MetaPeriodo").prop('readonly', true);
}

var desbloquearInutsMetas = function(){
    $("#PeriodoVentaInicio").prop('readonly', false);
    $("#PeriodoVentaFin").prop('readonly', false);
    $("#MetaPeriodo").prop('readonly', false);
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

var agregarMeta = function(){
    $("#IdMeta").val("")
    $("#divModificarM").hide();
    $("#divAceptarM").show();
    $("#ModalMetas").modal();
    desbloquearInutsMetas();


}

var cancelarMeta = function(){
    $('#FormMetas')[0].reset();
    $("#IdMeta").val("");
    $("#IdVendedor2").val("");
}

var modificarMeta = function(){
    desbloquearInutsMetas();
    $("#divModificarM").hide();
    $("#divAceptarM").show();
}

$(document).ready(function(){
    $("#PeriodoVentaInicio").inputmask({ mask: "99-99-9999"});
    $("#PeriodoVentaFin").inputmask({ mask: "99-99-9999"});
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
    $(document).on('click','#guardarM',validadorM);
    $(document).on('click','#cancelar',BotonCancelar);
    $(document).on('click','#agregar',BotonAgregar);
    $(document).on('click','#modificar',modificarBodega);
    $(document).on('click','#volverAct',volverTabs);
    $(document).on('click','#agregarM',agregarMeta);
    $(document).on('click','#cancelarM',cancelarMeta);
    $(document).on('click','#modificarM',modificarMeta);
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


    $('#FormMetas').formValidation({
        excluded:[':disabled'],
        fields: {
            'PeriodoVentaInicio': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'PeriodoVentaFin': {
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    }
                }
            },
            'MetaPeriodo': {
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    }
                }
            },
        }
    })
    .on('success.form.fv', function(e){
        ProcesarMeta();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});