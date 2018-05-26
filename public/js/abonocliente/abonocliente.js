var RegistroEmpresas  = '';
var manejoRefresh=limpiarLocales=errorRut=limpiarBodegas=0;
var _idCaja_ = 0;
var _idLocal_ = 0;

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
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

// Manejo Activar / Desactivar empresa
var ManejoRespuestaProcesarI = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta.activar>0){
            $.growl({message:"Procesado"},{type: "success", allow_dismiss: true,});
            cargarTablaAbonoCliente(respuesta.respuesta.v_abono_cliente);
        }else{
            $.growl({message:"Debe seleccionar un registro"},{type: "warning", allow_dismiss: true,});
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

// Manejo respuesta buscar cliente
var ManejoRespuestaBuscarCliente = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta!=null){
            if(respuesta.respuesta.IdCliente==0){
                $("#IdClienteAbono").val("");
                $("#NombreClienteAbono").val("");
                $("#MontoAbono").val("");
            }else{
                $("#IdClienteAbono").val(respuesta.respuesta.IdCliente);
                $("#NombreClienteAbono").val(respuesta.respuesta.NombreCliente);
            }    
        }else{
            $.growl({message:"Cliente no encontrado"},{type: "warning", allow_dismiss: true,});
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
                location.reload();
                // $(".divDetalles").toggle();
                // $(".divBotones").toggle();
                // $('#FormAbonoCliente')[0].reset();
                // $('#IdFormaPago').val("");
                // cargarTablaAbonoCliente(respuesta.respuesta.v_abono_cliente);
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

var cargarTablaAbonoCliente = function(data){
    if(limpiarLocales==1){destruirTabla('#TablaAbonoCliente');$('#TablaAbonoCliente thead').empty();}
        $("#TablaAbonoCliente").dataTable({
            responsive:false,
            'bSort': false,
            "scrollCollapse": false,
            "paging": false,
            "searching": false,
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
                    "data": "IdAbono",
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
                {"title": "RUTCliente","data": "RUTCliente"},
                {"title": "Nombre Cliente","data": "NombreCliente"},                
                {"title": "Monto Abonado","data": "MontoAbono"},
                {"title": "EstadoAbono","data": "desEstadoAbono"},
                {"title": "auUsuarioCreacion","data": "auUsuarioCreacion",visible:0},
                {"title": "fecha de creacion","data": "auFechaCreacion",visible:0},
                {"title": "Creado por","data": "creador",visible:0},
                {"title": "auModificadoPor","data": "auUsuarioModificacion",visible:0},
                {"title": "auUsuarioModificacion","data": "auFechaModificacion",visible:0},
                {"title": "Modificado por","data": "modificador",visible:0}
                
            ],
        });
        limpiarLocales=1;
    // if (data.length>0){seleccionarTablaLocales();}
};

var pintarDatosActualizar= function(data){
    $(".md-form-control").addClass("md-valid");
    $("#IdAbono").val(data.IdAbono);
    $("#IdClienteAbono").val(data.IdCliente);
    $("#RUTClienteAbono").val(data.RUTCliente);
    $("#NombreClienteAbono").val(data.NombreCliente);
    $("#MontoAbono").val(data.MontoAbono);
    $("#IdFormaPago").val(data.IdFormaPago).trigger("change");
}

var BotonCancelar = function(){
    $(".md-form-control").removeClass("md-valid");
    $('#FormAbonoCliente')[0].reset();
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
    $('#FormAbonoCliente')[0].reset();
    $("#divTabs").hide();
    $(".divDetalles").toggle();
    $(".divBotones").toggle();
    desbloquearInuts();
}

var ProcesarAbonoCliente = function(){
    parametroAjax.ruta=ruta;
    parametroAjax.data = $("#FormAbonoCliente").serialize();
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesar(respuesta);
};

var validador = function(){
    $('#FormAbonoCliente').formValidation('validate');
};

var cambiarEstatus = function(IdAbono){
    parametroAjax.ruta=rutaA;
    parametroAjax.data = {IdAbono:IdAbono};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarI(respuesta);
}

var verDetalles = function(IdAbono){
    parametroAjax.ruta=rutaD;
    parametroAjax.data = {IdAbono:IdAbono};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarD(respuesta);
}

var buscarCliente = function(RUTCliente){
    parametroAjax.ruta=rutaBC;
    parametroAjax.data = {RUTCliente:RUTCliente};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaBuscarCliente(respuesta);
}

var bloquearInuts = function(){
    $("#RUTClienteAbono").prop('readonly', true);
    $("#MontoAbono").prop('readonly', true);
    $("#IdFormaPago").prop('disabled', true);
}

var desbloquearInuts = function(){
    $("#RUTClienteAbono").prop('readonly', false);
    $("#MontoAbono").prop('readonly', false);
    $("#IdFormaPago").prop('disabled', false);  
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
    // $("#detalles").addClass("active");
    // $("#adetalles").addClass("active");
    // $("#compras").removeClass("active");
    // $("#acompras").removeClass("active");
}

var crearAllSelect = function(data){
    // crearselect(data.v_tipo_dte,"TipoDTE");
    // crearselect(data.v_estados,"EstadoCompra");
    // crearselect(data.v_estados,"EstadoDetalleCompra");
    crearselect(data.v_formas_pago,"IdFormaPago");
}

var verificarRut = function(control,caso){
    var res = Valida_Rut(control);
    var format = formateaRut(control.val(), res);
    if (format != false){
        errorRut = 0;
        buscarCliente(format);
        $("#ErrorRut").text("");
        return format;
    }else{
        errorRut = 1;$("#ErrorRut").text("Rut invalido");
        return control.val();
    }
}

var ProcesarInfoCaja = function(){
    parametroAjax.ruta=rutaCD;
    parametroAjax.data = $("#FormAbonoCliente").serialize();
    respuesta=procesarajax(parametroAjax);
    console.log("ProcesarInfoCaja --> Respuesta: " + respuesta);
    
    ManejoRespuestaProcesarInfoCaja(respuesta);
};

var ManejoRespuestaProcesarInfoCaja = function(respuesta){  
    if(respuesta.code==200){
        
        if(respuesta.respuesta!=null){
            console.log("respuesta.respuesta.v_cajaActual.IdCaja: " + respuesta.respuesta.v_cajaActual[0].IdCaja);
            console.log("respuesta.respuesta.v_cajaActual.IdLocal: " + respuesta.respuesta.v_cajaActual[0].IdLocal);
            
            if(respuesta.respuesta.v_cajaActual==null){
                _idCaja_= 0;
                _idLocal_= 0;
            }else{
                $("#IdLocal").val(respuesta.respuesta.v_cajaActual[0].IdLocal);
                $("#IdCaja").val(respuesta.respuesta.v_cajaActual[0].IdCaja);
                                
                _idCaja_= respuesta.respuesta.v_cajaActual[0].IdCaja;
                _idLocal_= respuesta.respuesta.v_cajaActual[0].IdLocal;
            }    
        }else{
            $.growl({message:"Cliente no encontrado"},{type: "warning", allow_dismiss: true,});
        }
        
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
    
    console.log("Fin de ManejoRespuestaProcesarInfoCaja()");
}


$(document).ready(function(){
    console.log(d);
    ProcesarInfoCaja();

    cargarTablaAbonoCliente(d.v_abono_cliente);
    crearAllSelect(d);
    $("#RUTClienteAbono").focusout(function() {
        var valid = $("#RUTClienteAbono").val();
        if (valid.length > 0){
            var res = verificarRut($("#RUTClienteAbono"));
            $("#RUTClienteAbono").val(res);
        }else{$("#ErrorRut").text("");}
    });
    $(document).on('click','#guardar',validador);
    $(document).on('click','#cancelar',BotonCancelar);
    $(document).on('click','#agregar',BotonAgregar);
    $(document).on('click','#modificar',modificarBodega);
    $(document).on('click','#volverAct',volverTabs);
    $('#FormAbonoCliente').formValidation({
        excluded:[':disabled'],
        fields: {
            'RUTClienteAbono': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },   
            'MontoAbono': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },         
            'IdFormaPago': {
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
        ProcesarAbonoCliente();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});