// var RegistroLocales  = '';
var manejoRefresh=limpiarPreferencias=errorRut=limpiarBodegas=ErrorCuotas=0;
var CuotaMax=0;
var Interes='';
var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};

var ManejoRespuestaBuscarCliente = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta.v_cliente!=null){
            $("#IdCliente").val(respuesta.respuesta.v_cliente[0].IdCliente);
            $("#NombreCliente").val(respuesta.respuesta.v_cliente[0].NombreCliente);
            $("#PrimeraCuota").val(respuesta.respuesta.v_fechas.fechaPago);
        }else{
            $.growl({message:"Cliente no encontrado"},{type: "warning", allow_dismiss: true,});
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
        $("#divBtnModificar").show();
        $("#divBtnAceptar").hide();
        $("#spanTitulo").text("Detalles");
        pintarDatosActualizar(respuesta.respuesta.v_detalles[0]);
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }

}

// Manejo Activar / Desactivar empresa
var ManejoRespuestaProcesarI = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta.activar>0){
            if(respuesta.respuesta.v_credito_venta.length>0){
                $.growl({message:"Procesado"},{type: "success", allow_dismiss: true,});
                cargarTablaVentaCredito(respuesta.respuesta.v_credito_venta);
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
                $('#FormVentaCredito')[0].reset();
                $('#IdVentaCredito').val("");
                cargarTablaVentaCredito(respuesta.respuesta.v_credito_venta);
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

var cargarTablaVentaCredito = function(data){
    if(limpiarPreferencias==1){destruirTabla('#tablaVentasCredito');$('#tablaVentasCredito thead').empty();}
        $("#tablaVentasCredito").dataTable({
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
                    "title": " ",
                    "data": "IdVentaCredito",
                    "render": function(data, type, row, meta){
                        var result = `
                        <center>
                        <a href="#" onclick="verDetalleVentaCredito(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Venta Crédito" data-original-title="Delete">
                            <i class="icofont icofont-search"></i>
                        </a>
                        <a href="#" onclick="cambiarEstatusVenta(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
                            <i class="icofont icofont-ui-delete"></i>
                        </a>
                        </center>`;
                        return result;
                    }
                },
                {"title": "Id Venta Crédito","data": "IdVentaCredito",visible:0},
                {   
                    "title": "Fecha Venta", 
                    "data": "FechaVentaCredito",
                    "render": function(data, type, row, meta){
                        if(type === 'display'){
                            data = moment(data, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY");
                        }
                        return data;
                    }
                },                
                {"title": "Monto Crédito","data": "MontoCredito"},
                {"title": "Nro. Cuotas","data": "NumeroCuotas"},
                {"title": "Monto Cuota","data": "MontoCuota"},
                {   
                    "title": "Primera Cuota", 
                    "data": "PrimeraCuota",
                    "render": function(data, type, row, meta){
                        if(type === 'display'){
                            data = moment(data, 'YYYY-MM-DD',true).format("DD-MM-YYYY");
                        }
                        return data;
                    }
                },  
                {"title": "Estado","data": "DesEstadoVentaCredito"},
                {"title": "Fecha de creacion","data": "auFechaCreacion",visible:0},
                {"title": "Usuario creacion","data": "auUsuarioCreacion",visible:0},
                {"title": "auModificadoPor","data": "auUsuarioModificacion",visible:0},
                {"title": "auUsuarioModificacion","data": "auFechaModificacion",visible:0}

            ],
        });
        limpiarPreferencias=1;
};

var pintarDatosActualizar= function(data){
    $(".md-form-control").addClass("md-valid");
    $("#IdVentaCredito").val(data.IdVentaCredito);
    $("#IdVenta").val(data.IdVenta);
    $("#RUTCliente").val(data.RUTCliente);
    $("#NombreCliente").val(data.NombreCliente);
    $("#MontoCredito").val(data.MontoCredito);
    $("#NumeroCuotas").val(data.NumeroCuotas);
    $("#InteresMensual").val(data.InteresMensual);
    $("#MontoFinal").val(data.MontoFinal);
    $("#MontoCuota").val(data.MontoCuota);
    $("#PrimeraCuota").val(moment(data.PrimeraCuota, 'YYYY-MM-DD',true).format("DD-MM-YYYY"));   
}

var BotonCancelar = function(){
    $("#divTabs").show();
    $(".divDetalles").toggle();
    $(".md-form-control").removeClass("md-valid");
    $("#spanTitulo").text("Ventas a Crédito Registrados");
    $(".divForm").toggle();
    $('#divConsulta').hide();
    $('#FormVentaCredito')[0].reset();
    $("#idUser").val("");
    $('#divSpanPerfiles').hide();
    $(".divBotones").toggle();
    bloquearInuts();
}

var BotonAgregar = function(){
    $("#spanTitulo").text("Registrar Venta a Crédito");
    $('#FormVentaCredito')[0].reset();
    $("#divTabs").hide();
    $("#divVolver").hide();
    $(".divDetalles").toggle();
    $(".divBotones").toggle();
    $("#NumeroCuotas").val(CuotaMax);
    $("#InteresMensual").val(Interes);
    desbloquearInuts();

}

var ProcesarVentaCredito = function(){
    if (errorRut==0){
        if(ErrorCuotas==0){
            parametroAjax.ruta=ruta;
            parametroAjax.data = $("#FormVentaCredito").serialize();
            respuesta=procesarajax(parametroAjax);
            ManejoRespuestaProcesar(respuesta);
        }else{
            $.growl({message:"El número de cuotas no debe ser mayor al numero de coutas de la prefencia de crédito activa"},{type: "warning", allow_dismiss: true,}); 
        }
    }
};

var validador = function(){
    $('#FormVentaCredito').formValidation('validate');
};

var cambiarEstatusVenta = function(IdVentaCredito){
    parametroAjax.ruta=rutaA;
    parametroAjax.data = {IdVentaCredito:IdVentaCredito};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarI(respuesta);
}

var verDetalleVentaCredito = function(IdVentaCredito){
    parametroAjax.ruta=rutaB;
    parametroAjax.data = {IdVentaCredito:IdVentaCredito};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarD(respuesta);
}

var bloquearInuts = function(){
    $("#IdVenta").prop('readonly', true);
    $("#RUTCliente").prop('readonly', true);
    $("#MontoCredito").prop('readonly', true);
    $("#NumeroCuotas").prop('readonly', true);
    //$("#InteresMensual").prop('readonly', true);
    //$("#MontoFinal").prop('readonly', true);
    //$("#MontoCuota").prop('readonly', true);
    $("#PrimeraCuota").prop('readonly', true);
}

var desbloquearInuts = function(){
    $("#IdVenta").prop('readonly', false);
    $("#RUTCliente").prop('readonly', false);
    $("#MontoCredito").prop('readonly', false);
    $("#NumeroCuotas").prop('readonly', false);
    //$("#InteresMensual").prop('readonly', false);
    //$("#MontoFinal").prop('readonly', false);
    //$("#MontoCuota").prop('readonly', false);
    $("#PrimeraCuota").prop('readonly', false);
}

var modificarForm = function(){
    $("#divVolver").hide();
    $(".divBotones").toggle();
    $("#spanTitulo").text("Editar Venta a Crédito");
    desbloquearInuts();
}

var volverTabs = function(){
    $(".divDetalles").toggle();
    $("#adetalles").addClass("active");
    $("#detalles").addClass("active");
    $("#bodegas").removeClass("active");
    $("#abodegas").removeClass("active");
    $("#spanTitulo").text("")
}

var verificarRut = function(control){
    var res = Valida_Rut(control);
    var format = formateaRut(control.val(), res);
    if (format != false){
        errorRut = 0;
        $("#ErrorRut").text("");
        buscarCliente(format);
        return format;
    }else{
        errorRut = 1;
        $("#ErrorRut").text("Rut invalido");
        return control.val();
    }
}
var calcularCuotas = function(montoCredito, numeroCuotas, interesMensual){
    var montoFinalCredito = montoCredito * ( 1 + (numeroCuotas * interesMensual/100));
    var montoCuota = montoFinalCredito / numeroCuotas;
    $("#MontoFinal").val(Math.round(montoFinalCredito));
    $("#MontoCuota").val(Math.round(montoCuota));
}

var buscarCliente = function(RUTCliente){
    parametroAjax.ruta=rutaC;
    parametroAjax.data = {RUTCliente:RUTCliente};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaBuscarCliente(respuesta);
}

var cargarInteresCuotas = function(data){
    console.log(data);
    CuotaMax=data.NumeroMaxCuotas;
    Interes = data.InteresMensual;
}

$(document).ready(function(){
    console.log(d);
    cargarInteresCuotas(d['v_prefencias']);
    $("#RUTCliente").focusout(function() {
        var valid = $("#RUTCliente").val();
        if (valid.length > 0){
            var res = verificarRut($("#RUTCliente"));
            $("#RUTCliente").val(res);
        }else{
            $("#ErrorRut").text("");
        }
    });
   $("#NumeroCuotas").focusout(function () {
        var montoCredito = $("#MontoCredito").val();
        var numeroCuotas = $("#NumeroCuotas").val();
        var InteresMensual = $("#InteresMensual").val();
        if (montoCredito.length > 0){
            if (parseInt(numeroCuotas) > parseInt(CuotaMax)){
                ErrorCuotas=1; 
            }else{
                ErrorCuotas=0; 
            }
            var res = calcularCuotas(montoCredito, numeroCuotas, InteresMensual);
        }else{
            $.growl({message:"Debe ingresar el monto a Finaciar"},{type: "warning", allow_dismiss: true,});
        }
    });
    $("#spanTitulo").text("Ventas a Crédito Registradas");
    cargarTablaVentaCredito(d.v_credito_venta);
    $(document).on('click','#guardar',validador);
    $(document).on('click','#cancelar',BotonCancelar);
    $(document).on('click','#agregar',BotonAgregar);
    $(document).on('click','#modificar',modificarForm);
    $(document).on('click','#volverAct',volverTabs);
    $('#FormVentaCredito').formValidation({
        excluded:[':disabled'],
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'IdVenta': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'RUTCliente': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'MontoCredito': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'NumeroCuotas': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'InteresMensual': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'MontoFinal': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'MontoCuota': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'PrimeraCuota': {
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
        ProcesarVentaCredito();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});