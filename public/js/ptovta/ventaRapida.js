var manejoRefresh=limpiarLocales=limpiarImpuestos=limpiarPagos=errorRut=errorRut2=errorRut3=limpiarBodegas=NVenta=0;
var _tipoVenta_=0;
var _idVenta_=0;
var _idCaja_=0;
var _idLocal_=0;
var _idVendedor_=0;
var _nombreVendedor_="";
var _idCliente_=0;
var _nombreCliente_="";

var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};


$(document).ready(function(){	
	ProcesarInfoCaja();

	// Botones de cabecera de VentaRapida
	$(document).on('click','#botonConsultaStock', ConsultaStockProducto);
	
	$(document).on('click','#botonVendedorPreVenta', ModalVendedor);
	$(document).on('click','#botonCancelarAsignarVendedor', CerrarModalAsignarVendedor);
	$(document).on('click','#botonAsignarVendedor', CerrarModalAsignarVendedor);
	
	$(document).on('click','#botonClientePreVenta', ModalCliente);
	$(document).on('click','#botonCancelarAsignarCliente', CerrarModalAsignarCliente);
	$(document).on('click','#botonAsignarCliente', CerrarModalAsignarCliente);
	
	$(document).on('click','#botonFormaPagoPreVenta', ModalFormaPago);
	
	$(document).on('click','#botonPagoEfectivo', BotonPagoEfectivo);	
	$(document).on('click','#botonPagoCreditoPreVenta', BotonPagoCredito);
	$(document).on('click','#botonPagoTD', BotonPagoTD);
	$(document).on('click','#botonPagoTC', BotonPagoTC);
	
	$(document).on('click','#botonGuardarFormaPago', validadorFormaPago);
	$(document).on('click','#botonCancelarFormaPago', CancelarFormaPago);
	
	$(document).on('click','#botonCancelarFormaPagoPreVenta', CerrarModalFormaPago);
	$(document).on('click','#botonConfirmarFormaPagoPreVenta', CerrarModalFormaPago);
	

	$(document).on('click','#botonRecuperarPreVenta', RecuperarPreVenta);
	$(document).on('click','#botonAgregarProductos', AgregarProductos);
	$(document).on('click','#botonAgregarPreVentaPV', CargarPreVenta);
	
	$(document).on('click','#botonAgregarProductoPreVenta', AgregarProductoPreVenta);
	
	$(document).on('click','#botonVolverPreVenta', VolverPreVenta);
	$(document).on('click','#botonContinuarPreVenta', ContinuarPreVenta);
	$(document).on('click','#botonFinalizarPreVenta', FinalizarPreVenta);
	$(document).on('click','#botonCancelarPreVenta_1', CancelarPreVenta);
	$(document).on('click','#botonCancelarPreVenta_2', CancelarPreVenta);
	
	$(document).on('click','#botonPreVenta',PreVenta);
	$(document).on('click','#botonVentaDirecta',VentaDirecta);

	$(document).on('click','#botonTipoDTE',ModalTipoDTE);
	$(document).on('click','#botonBoleta',AsignaBoleta);
	$(document).on('click','#botonFactura',AsignaFactura);
	$(document).on('click','#botonCI',AsignaCI);
	
	/* focusout --> lost focus */
	$("#CodigoProductoPreVenta").focusout(function() {
        buscarProducto($("#CodigoProductoPreVenta").val());
    });
	
	
	$("#RUTCliente").focusout(function() {
		var valid = $("#RUTCliente").val();
		if (valid.length > 0){
			var res = verificarRut($("#RUTCliente"),1);
			$("#RUTCliente").val(res);
		}else{
			$("#ErrorRutCredito").text("");
		}
	});
	
	$("#RUTClienteCredito").focusout(function() {
        var valid = $("#RUTClienteCredito").val();
        if (valid.length > 0){
            var res = verificarRut($("#RUTClienteCredito"),4);
            $("#RUTClienteCredito").val(res);
        }else{
			$("#ErrorRutCredito").text("");
		}
    });

    $("#CodigoVendedor").focusout(function() {
        var valid = $("#CodigoVendedor");

         if (valid.length > 0){
            var res = verificarRUTVendedor($("#CodigoVendedor"));
            $("#CodigoVendedor").val(res);

        }else{
			$("#ErrorRutCredito").text("");
		}

    });

	/* Manejo de Variables de Session  */
	$('#IdVendedorPreVenta').on("change", function() {
		_idVendedor_=$("#IdVendedorPreVenta").val();
    });
	
	$("#NombreVendedorPreVenta").on("change paste keyup", function() {
		console.log("NombreVendedorPreVenta.change!!!");
		_nombreVendedor_=$("#NombreVendedorPreVenta").val();
		AsignarVendedorPreVenta();
    });
	/* Fin Variables de Session */
	
	$("#PrecioProductoPreVenta").change(function() {
        CalcularMontosPreVenta();
    });
		
	$("#CantidadProductoPreVenta").change(function() {
        CalcularMontosPreVenta();
    });
	
	$("#TotalPagadoPreVenta").change(function() {
		CalcularSaldoPago();
    });
	
	$("#TotalPreVentaFP").change(function() {
		CalcularSaldoPago();
    });
	
	$("#NumeroCuotasCredito").change(function() {
		CalcularMontoCuotas();
    });

	$("#NumeroCuotasCredito").focusin(function() {
		$("#NumeroCuotasCredito").select();
	});
	
	$("#MontoAFinanciar").change(function() {
		$("#MontoPagoEfectivo").val($("#MontoAFinanciar").val());
		CalcularMontoCuotas();
    });
	
	$("#InteresMensualCredito").change(function() {
		CalcularMontoCuotas();
    });

    $("#PrintPre").click(function(){
        $("div#CuerpoBoleta").printArea();
    });

    $("#PdfBoleta").click(function(){
    	if (_tipoVenta_ == 'Venta'){
	        var valores={
	            height : $("#DetalleBoleta").height(),
	            _token : $("#_token").val(),
	            IdVenta:$("#NumeroBoletaModal").val(), 
	            caso: 2
	        };
    	}
  		
  		if (_tipoVenta_ == 'PreVenta'){
	    	var valores={
	            height : $("#DetalleBoleta").height(),
	            _token : $("#_token").val(),
	            idPreVenta:$("#NumeroBoletaModal").val(), 
	            caso: 1
	        };
    	}
        OpenWindowWithPost(rutaPDF,'','_blank',valores);
    });	

    $("#CerrarModal").click(function(){
        $("#ModalBoletaPlantilla").modal("hide");
        BoletaString = '';
    });

	$('#FormPreVenta').formValidation({
        excluded:[':disabled'],
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'CodigoProductoPreVenta': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'Debe ingresar el Código del Producto.'
                    },
                }
            },
			'CantidadProductoPreVenta': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'Debe ingresar la cantidad a vender.'
                    },
                }
            },
        }
    })
    .on('success.form.fv', function(e){
        ProcesarProductoPreVenta();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
	
	$('#FormPreVenta').on('keypress', function(e) {
		var keyCode = e.keyCode || e.which;
      	if (keyCode === 13) { 
      		console.log("Enter " + e.target.name + " | e.type:" + e.type + " - e.which: " + e.which+ " - e.keyCode: " + e.keyCode + "...");

      		alert("Enter Formulario: Campo: " + e.target.name + "...");
			e.preventDefault();
			return false;
      }
    });

	$('#CodigoProductoPreVenta').on('keypress', function(e) {
    	var keyCode = e.keyCode || e.which;
      	if (keyCode === 13) { 
      		console.log("Enter " + e.target.name + " | e.type:" + e.type + " - e.which: " + e.which+ " - e.keyCode: " + e.keyCode + "...");

      		e.preventDefault();
      		e.stopImmediatePropagation();

      		$("#CodigoProductoPreVenta").trigger("focusout");
			
			return false;
      	}
    });

	$('#CantidadProductoPreVenta').on('keypress', function(e) {
    	var keyCode = e.keyCode || e.which;
       	if (keyCode === 13) { 
       		console.log("Enter " + e.target.name + " | e.type:" + e.type + " - e.which: " + e.which+ " - e.keyCode: " + e.keyCode + "...");

       		e.preventDefault();
       		e.stopImmediatePropagation();
			
			AgregarProductoPreVenta();

	 		return false;
       	}
    });

	$("#NroPreVenta").on('keypress', function(e) {
		var keyCode = e.keyCode || e.which;

		if (keyCode === 13) { 
       		console.log("Enter " + e.target.name + " | e.type:" + e.type + " - e.which: " + e.which+ " - e.keyCode: " + e.keyCode + "...");

       		e.preventDefault();
       		e.stopImmediatePropagation();
			
			var preventa_nro = $("#NroPreVenta").val();
			if(preventa_nro.length > 0){
				CargarPreVenta();
			}

	 		return false;
       	}
	});

	$('#FormVendedor').on('keypress', function(e) {
      	var keyCode = e.keyCode || e.which;
      	if (keyCode === 13) { 
      		console.log("Enter " + e.target.name + " | e.type:" + e.type + " - e.which: " + e.which+ " - e.keyCode: " + e.keyCode + "...");

		 	e.preventDefault();
		 	return false;
      	}
    });

    $('#CodigoVendedor').on('keypress', function(e) {
      	var keyCode = e.keyCode || e.which;
      	if (keyCode === 13) { 
      		console.log("Enter " + e.target.name + " | e.type:" + e.type + " - e.which: " + e.which+ " - e.keyCode: " + e.keyCode + "...");
		 	e.preventDefault();
		 	e.stopImmediatePropagation();

		 	verificarRUTVendedor($("#CodigoVendedor"));

		 	//buscarVendedor($("#CodigoVendedor").val());
		 	return false;
      	}
    });
	

    $('#FormCliente').on('keypress', function(e) {
      	var keyCode = e.keyCode || e.which;
      	if (keyCode === 13) { 
      		console.log("Enter #FormCliente: Campo: " + e.target.name + " | e.type:" + e.type + " - e.which: " + e.which+ " - e.keyCode: " + e.keyCode + "...");

		 	e.preventDefault();
		 	return false;
      	}
    });

    $('#RUTCliente').on('keypress', function(e) {
      	var keyCode = e.keyCode || e.which;
      	if (keyCode === 13) { 
      		console.log("Enter " + e.target.name + " | e.type:" + e.type + " - e.which: " + e.which+ " - e.keyCode: " + e.keyCode + "...");
		 	e.preventDefault();
		 	e.stopImmediatePropagation();

		 	$("#RUTCliente").trigger("focusout");

		 	return false;
      	}
    });


	$('#FormIngresoFP').on('keypress', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) { 
      	  console.log("Enter " + e.target.name + " | e.type:" + e.type + " - e.which: " + e.which+ " - e.keyCode: " + e.keyCode + "...");
		 e.preventDefault();
		 return false;
      }
    });

    $('#MontoPagoEfectivo').on('keypress', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) { 
      	  console.log("Enter " + e.target.name + " | e.type:" + e.type + " - e.which: " + e.which+ " - e.keyCode: " + e.keyCode + "...");
		 e.preventDefault();

		 validadorFormaPago();
		 return false;
      }
    });
	
	$('#FormConsultaStockProducto').on('keypress', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) { 
      	  console.log("Enter " + e.target.name + " | e.type:" + e.type + " - e.which: " + e.which+ " - e.keyCode: " + e.keyCode + "...");
		 e.preventDefault();
		 return false;
      }
    });
	
	$('#CodigoProductoConsultaCredito').on('keypress', function(e) {
    	var keyCode = e.keyCode || e.which;
      	if (keyCode === 13) { 
      		console.log("Enter " + e.target.name + " | e.type:" + e.type + " - e.which: " + e.which+ " - e.keyCode: " + e.keyCode + "...");

      		e.preventDefault();
      		e.stopImmediatePropagation();

      		botonConsultarStockProducto();
			
			return false;
      	}
    });

	$('#FormIngresoFP').formValidation({
        excluded:[':disabled'],
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'MontoPagoEfectivo': {
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
        ProcesarFormaPago();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});

var AsignaBoleta = function(){
	AsignaTipoDTE(1, 'Boleta');
	
	return false;
}

var AsignaFactura  = function(){
	AsignaTipoDTE(2, 'Factura');

	return false;
}

var AsignaCI  = function(){
	AsignaTipoDTE(5, 'CI');

	return false;
}

var AsignaTipoDTE = function(tipoDTE, nombreDTE){
	console.log("AsignaTipoDTE("+tipoDTE+")");
	$('#IdTipoDTEPreVenta').val(tipoDTE);
	$('#IdTipoDTE').val(tipoDTE);
	$('#botonTipoDTE').text(nombreDTE);

	if(_tipoVenta_=="PreVenta") parametroAjax.ruta=rutaPVDTE;
	if(_tipoVenta_=="Venta") parametroAjax.ruta=rutaVDTE;
					
	parametroAjax.data = $("#FormPreVenta").serialize();
	respuesta=procesarajax(parametroAjax);

	$("#ModalTipoDTE").modal('toggle');
}

var ActualizarTituloVentanaVenta = function(){
	console.log("ActualizarTitulo() _idLocal_: " + _idLocal_ + " | _idCaja_: " + _idCaja_)
	$("#spanTituloModalPreVenta").text(_tipoVenta_ + ": "+_idVenta_+" | Local: "+_idLocal_+" | Caja: "+_idCaja_+" | Vendedor: "+_nombreVendedor_);
}

var ConsultaStockProducto = function(){
    
	$("#spanTituloModalConsultaStockProducto").text("Consulta Sock Producto");
    $("#ModalConsultaStockProducto").modal();

    $('#ModalConsultaStockProducto').on('shown.bs.modal', function() {
		$('#CodigoProductoConsultaCredito').focus().select();
	});
}

var ModalVendedor = function(){
    
	$("#spanTituloModalModalVendedor").text("Asignar Vendedor a la "+_tipoVenta_);
    $("#ModalAsignarVendedor").modal();
	
	$('#ModalAsignarVendedor').on('shown.bs.modal', function() {
		$('#CodigoVendedor').focus().select();
	});
}

var CerrarModalAsignarVendedor = function(){
    
	$("#ModalAsignarVendedor").modal("hide");
	$('#TotalPreVenta').focus().select();
}

var AsignarVendedorPreVenta = function(){
	console.log("AsignarVendedorPreVenta()");
	
	ActualizarTituloVentanaVenta();
	
	$("#NombreVendedor_DIV").text(_nombreVendedor_);
	$("#botonVendedorPreVenta").text(_nombreVendedor_);
	
	console.log("Fin AsignarVendedorPreVenta()");
	
}

var ModalCliente = function(){
    
	$("#spanTituloModalCliente").text("Asignar Cliente a la "+_tipoVenta_);
    $("#ModalAsignarCliente").modal();
	
	$('#ModalAsignarCliente').on('shown.bs.modal', function() {
		$('#RUTCliente').focus().select();
	});
}

var ModalTipoDTE = function(){
    
	$("#spanTituloModalTipoDTE").text("Seleccione el Tipo de Documento");
    $("#ModalTipoDTE").modal();
	
	$('#ModalTipoDTE').on('shown.bs.modal', function() {
		//$('#RUTCliente').focus().select();
	});
}

var ModalFormaPago = function(){
    
	//$("#TotalPagadoPreVenta").val(0);
	CalcularSaldoPago();
	
	$("#spanTituloModalFP").text("Asignar Forma de Pago a la "+_tipoVenta_);
    $("#ModalAsignarFP").modal();
}

var BotonPagoEfectivo = function (){
	console.log("Pago Efectivo");
	
	$("#IdPreVentaPago").val($("#IdPreVenta").val());
	$("#IdFormaPagoPreVenta").val(0);
	
	var  MontoAPagar = ( parseFloat($("#SaldoPagoPreVenta").val()) * -1);
	$("#MontoPagoEfectivo").val(MontoAPagar);
	$("#NumeroTransaccionTarjeta").val(0);
	$("#CodigoAprobacionTarjeta").val(0);
	$("#FechaPrimeraCuota").val("01-01-2000");
	$("#NumeroCuotasCredito").val(0);
	$("#InteresMensualCredito").val(0);
	$("#MontoFinalCredito").val(0);
    $("#MontoCuotaCredito").val(0);
	
    $("#spanTituloModalFormaPago").text("Registrar Pago Efectivo");
	$("#ModalIngresoPago").modal();	
	
	$("#InfoAddTC").hide();
	$("#InfoAddCredito").hide();
	
	$("#divBotonM_FPE").hide();
	$("#divBotonAC_FPE").show();
	$("#botonGuardarFormaPago").text("Continuar");
	$("#botonGuardarFormaPago").prop('disabled', false);
    $("#botonGuardarFormaPago").removeClass("btn-danger");
    $("#botonGuardarFormaPago").addClass("btn-success");
    //desbloquearInputsFPE();
	
	$('#ModalIngresoPago').on('shown.bs.modal', function() {
		$('#MontoPagoEfectivo').focus().select();
	});
	
	return false;
}

var BotonPagoCredito = function (){
	console.log("Pago Credito");
	ProcesarCargaPreferencias();
	
	$("#IdPreVentaPago").val($("#IdPreVenta").val());
	$("#IdFormaPagoPreVenta").val(3);
	
	var  MontoAPagar = ( parseFloat($("#SaldoPagoPreVenta").val()) * -1);
	$("#MontoPagoEfectivo").val(MontoAPagar);
	$("#MontoAFinanciar").val(MontoAPagar);
	
	CalcularMontoCuotas();
	
	$("#FechaPrimeraCuota").val("");
	$("#NumeroTransaccionTarjeta").val(0);
	$("#CodigoAprobacionTarjeta").val(0);
	
	$("#InfoAddTC").hide();
	$("#InfoAddCredito").show();
	$('#RUTClienteCredito').val($('#RUTCliente').val());
	
	
	$("#divBotonM_FPE").hide();
	$("#divBotonAC_FPE").show();
	$("#botonGuardarFormaPago").text("Continuar");
	
    $("#spanTituloModalFormaPago").text("Registrar Pago Crédito Interno");
	$("#ModalIngresoPago").modal();	
	
    //desbloquearInputsFPE();
	
	$('#ModalIngresoPago').on('shown.bs.modal', function() {
		$('#RUTClienteCredito').focus().select();
	});
	return false;
}

var BotonPagoTD = function (){
	console.log("Pago TD");
	
	$("#IdPreVentaPago").val($("#IdPreVenta").val());
	$("#IdFormaPagoPreVenta").val(1);
	
	var  MontoAPagar = ( parseFloat($("#SaldoPagoPreVenta").val()) * -1);
	$("#MontoPagoEfectivo").val(MontoAPagar);
	$("#NumeroTransaccionTarjeta").val(0);
	$("#CodigoAprobacionTarjeta").val(0);
	$("#FechaPrimeraCuota").val("01-01-2000");
	$("#NumeroCuotasCredito").val(0);
	$("#InteresMensualCredito").val(0);
	$("#MontoFinalCredito").val(0);
    $("#MontoCuotaCredito").val(0);
	
    $("#spanTituloModalFormaPago").text("Registrar Pago Tarjeta de Debito / RedBanc / Tarjeta RUT");
	$("#ModalIngresoPago").modal();	
	
	$("#InfoAddTC").show();
	$("#InfoAddCredito").hide();
	
	$("#divBotonM_FPE").hide();
	$("#divBotonAC_FPE").show();
	$("#botonGuardarFormaPago").text("Continuar");
    //desbloquearInputsFPE();
	
	$('#ModalIngresoPago').on('shown.bs.modal', function() {
		$('#NumeroTransaccionTarjeta').focus().select();
	});
	
	return false;
}

var BotonPagoTC = function (){
	console.log("Pago TC");
	
	$("#IdPreVentaPago").val($("#IdPreVenta").val());
	$("#IdFormaPagoPreVenta").val(2);
	
	var  MontoAPagar = ( parseFloat($("#SaldoPagoPreVenta").val()) * -1);
	$("#MontoPagoEfectivo").val(MontoAPagar);
	$("#NumeroTransaccionTarjeta").val(0);
	$("#CodigoAprobacionTarjeta").val(0);
	$("#FechaPrimeraCuota").val("01-01-2000");
	$("#NumeroCuotasCredito").val(0);
	$("#InteresMensualCredito").val(0);
	$("#MontoFinalCredito").val(0);
    $("#MontoCuotaCredito").val(0);
	
    $("#spanTituloModalFormaPago").text("Registrar Pago Tarjeta de Crédito / VISA / MASTERCARD ");
	$("#ModalIngresoPago").modal();	
	
	$("#InfoAddTC").show();
	$("#InfoAddCredito").hide();
	
	$("#divBotonM_FPE").hide();
	$("#divBotonAC_FPE").show();
	$("#botonGuardarFormaPago").text("Continuar");
    //desbloquearInputsFPE();
	
	$('#ModalIngresoPago').on('shown.bs.modal', function() {
		$('#NumeroTransaccionTarjeta').focus().select();
	});
	
	return false;
}

var CancelarFormaPago = function(){
    
	$("#TotalPagadoPreVenta").val(0);
	CalcularSaldoPago();
	
    $("#ModalIngresoPago").modal("hide");
}

var CerrarModalFormaPago = function(){
    
	$("#botonFormaPagoPreVenta").text("Total Pagado: " + $("#TotalPagadoPreVenta").val());
    $("#ModalAsignarFP").modal("hide");
	
	$('#TotalPreVenta').focus().select();
}

var CerrarModalAsignarCliente = function(){
    
	$("#ModalAsignarCliente").modal("hide");
	$('#TotalPreVenta').focus().select();
}

var AsignarClientePreVenta = function(){
	$("#botonClientePreVenta").text($("#NombreClientePreVenta").val());
	$("#NombreCliente_DIV").text($("#NombreClientePreVenta").val());
	
	var infoCliente = "Estado Cliente: " + $("#EstadoClientePreVenta").val();
	$("#InfoCliente_DIV").text(infoCliente);
	
	var infoCliente2 = "Cupo Disponible: " + $("#CD_ClientePreVenta").val();
	$("#InfoCliente2_DIV").text(infoCliente2);
	
	var infoCliente3 = "Primera Cuota : " + $("#PC_ClientePreVenta").val();
	$("#InfoCliente3_DIV").text(infoCliente3);
	
}

var AsignarIdPreVenta = function(IdPreVenta){	
	ActualizarTituloVentanaVenta()
}

var RecuperarPreVenta = function(){
	$("#frameNroPreVenta").show();
	$("#frameProductos").hide();
	$("#botonRecuperarPreVenta").hide();
	$("#botonAgregarProductos").show();
	
	$("#NroPreVenta").focus();
}

var AgregarProductos = function(){
	$("#frameNroPreVenta").hide();
	$("#frameProductos").show();
	$("#botonRecuperarPreVenta").show();
	$("#botonAgregarProductos").hide();
	
	$("#CodigoProductoPreVenta").focus();
}

var CargarPreVenta = function(){
	console.log("CargarPreVenta()");
	
	if(_tipoVenta_=="PreVenta"){
		parametroAjax.ruta=rutaRPV;
		parametroAjax.data = $("#FormPreVenta").serialize();
		respuesta=procesarajax(parametroAjax);
		ManejoRespuestaProcesarProductoPreVenta(respuesta, 2);
	}else if(_tipoVenta_=="Venta"){
		parametroAjax.ruta=rutaRV;
		parametroAjax.data = $("#FormPreVenta").serialize();
		respuesta=procesarajax(parametroAjax);
		ManejoRespuestaProcesarProductoPreVenta(respuesta, 2);
	}
	
	console.log("Fin CargarPreVenta()");
	
	//printDIV();
}

var PersonalizaFormularioVenta = function(){
	ProcesarInfoCaja();
	
	$("#basic-forms-h-0").text('Productos de la '+_tipoVenta_);
	//$("#botonRecuperarPreVenta").text('Recuperar '+_tipoVenta_);
	//$("#botonAgregarPreVentaPV").text('Recuperar '+_tipoVenta_);
	
	$("#botonContinuarPreVenta").text('Continuar '+_tipoVenta_);
	$("#botonContinuarPreVenta").text('Continuar '+_tipoVenta_);
	//$('#lblNroPreVenta').text("Nro. "+_tipoVenta_);
	$('#lblTotalVenta').text("Total "+_tipoVenta_);
	$('#lblTotalVentaVR').text("Total "+_tipoVenta_);
	$('#lblTotalVenta_').text("Total "+_tipoVenta_);
}

var PreVenta= function(){
	_tipoVenta_ = "PreVenta";
	_idVenta_ = 0;

	CargarTablaProductosPreVenta(null);
	PersonalizaFormularioVenta();
	
	$("#frameProductos").show();
	$("#frameNroPreVenta").hide();
	$("#botonRecuperarPreVenta").show();
	$("#botonAgregarProductos").hide();
	
    $("#PreVentaStep_1").show();
    $("#NroPreVenta").val("");

	$("#PreVentaStep_2").hide();
		
	ActualizarTituloVentanaVenta()
	
	$('#IdPreVenta').val(0);
	$('#IdTipoDTEPreVenta').val(1);
	$('#botonTipoDTE').text('Boleta');

    $("#ModalPreVenta").modal();
	
	$('#ModalPreVenta').on('shown.bs.modal', function() {
		$('#CodigoProductoPreVenta').focus().select();
	});
}

var AgregarProductoPreVenta= function(){
	var IdProducto = $("#IdProductoPreVenta").val();
	
	if(IdProducto.length > 0){
		CalcularMontosPreVenta();
		$('#FormPreVenta').formValidation('validate');
	}else
	{
		 $.growl("Debe ingresar el Código del Producto!",{type: "warning", allow_dismiss: true,});
		 $("#CodigoProductoPreVenta").focus();
	}
}

var VolverPreVenta = function(){
	$("#PreVentaStep_1").show();
	$("#PreVentaStep_2").hide();
}

var ContinuarPreVenta = function(){
	$("#PreVentaStep_1").hide();
	$("#PreVentaStep_2").show();	
}

var verDetallesBoleta = function(idPreVenta){
	console.log("Id"+_tipoVenta_+": " + idPreVenta);

	$("#NumeroBoletaModal").val(idPreVenta);
	if(_tipoVenta_=="PreVenta") {
	    parametroAjax.ruta=rutaVDPV;
	    parametroAjax.data = {idPreVenta:idPreVenta,caso:1};
	    respuesta=procesarajax(parametroAjax);
	    //ManejoRespuestaVerBoleta(respuesta);

	}else if(_tipoVenta_=="Venta") {
		parametroAjax.ruta=rutaVDPV;
	    parametroAjax.data = {IdVenta:idPreVenta,caso:2};
	    respuesta=procesarajax(parametroAjax);
	    
	}

	ManejoRespuestaVerBoleta(respuesta);
}

var ManejoRespuestaVerBoleta = function(respuestaBoleta){
	console.log("ManejoRespuestaVerBoleta()");

	console.log("respuestaBoleta: " + respuestaBoleta.code);

    if(respuestaBoleta.code==200){
        if(respuestaBoleta.respuesta.status.code==200){
            $("#DetalleBoleta").html(respuestaBoleta.respuesta.boleta);
            var ID = $("#NumeroBoletaModal").val();
            console.log(ID);
            JsBarcode("#barcode", ID);
            $("#ModalBoletaPlantilla").modal();
        }else{
        $.growl({message:respuestaBoleta.respuesta.status.des_code},{type: "warning", allow_dismiss: true});
            
        }

    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true});
    }
}

var FinalizarPreVenta = function (){
    
	if(_tipoVenta_=="PreVenta"){					
		var TablaDetalles = $("#tablaDetalles").dataTable();
		var IdVendedor = $("#IdVendedorPreVenta").val();
		var IdTipoDTE = $("#IdTipoDTEPreVenta").val();
		var IdFormaPago = $("#IdFormaPagoPreVenta").val();
		if(TablaDetalles.fnGetData().length < 1){
            $.growl({message:"Debe Seleccionar al Menos un Producto a Vender"},{type: "warning", allow_dismiss: true});
			return;
		}
		if (IdVendedor.length < 1){
            $.growl({message:"Debe Seleccionar Vendedor"},{type: "warning", allow_dismiss: true});
			return;
		}
		if (IdTipoDTE.length < 1){
            $.growl({message:"Debe Seleccionar Tipo de DTE"},{type: "warning", allow_dismiss: true});
			return;
		}
		if (IdFormaPago.length < 1){
            $.growl({message:"Debe Seleccionar Forma de Pago"},{type: "warning", allow_dismiss: true});
			return;
		}
		parametroAjax.ruta=rutaPVCP;
		parametroAjax.data = $("#FormPreVenta").serialize();
		respuesta=procesarajax(parametroAjax);
	}else if(_tipoVenta_=="Venta"){
		parametroAjax.ruta=rutaVCP;
		//parametroAjax.data = {IdVenta:_idVenta_};
		parametroAjax.data = $("#FormPreVenta").serialize();
		respuesta=procesarajax(parametroAjax);
	}
	
	var res = JSON.parse(respuesta.respuesta.f_registro);
	if(res.code==200){

		verDetallesBoleta($('#IdPreVenta').val());

		$("#ModalPreVenta").modal("hide");
		$.growl({message:" "+_tipoVenta_+" Finalizada exitosamente, ahora el cliente puede pasar por Caja!!!"},{type: "success", allow_dismiss: true,});
	}
}

var CancelarPreVenta = function(){
	//Acciones Para Destrir tabla de Detalles
    $("#ModalPreVenta").modal("hide");
	$.growl({message:" "+_tipoVenta_+" Cancelada exitosamente!!!"},{type: "success", allow_dismiss: true,});
}

var VentaDirecta = function(){
	_tipoVenta_ = "Venta";
	_idVenta_ = 0;

	CargarTablaProductosPreVenta(null);
	PersonalizaFormularioVenta();
	
	$("#frameProductos").show();
	$("#frameNroPreVenta").hide();
	$("#botonRecuperarPreVenta").show();
	$("#botonAgregarProductos").hide();
	
    $("#PreVentaStep_1").show();
    $("#NroPreVenta").val("");

	$("#PreVentaStep_2").hide();
	
	//destruirTabla('#tablaDetalles');
	//$('#tablaDetalles thead').empty();
	
	ActualizarTituloVentanaVenta();
	//$("#spanTituloModalPreVenta").text(_tipoVenta_+": ---- | Local: ---- | Caja: ---- | Vendedor: ------");
	$('#IdPreVenta').val(0);
    $("#ModalPreVenta").modal();
	
	$('#ModalPreVenta').on('shown.bs.modal', function() {
		$('#CodigoProductoPreVenta').focus().select();
	});
}

/* Funciones Comunes de los formularios de PreVenta, Venta Directa y Venta Pre-Venta*/
var validadorFormaPago = function(){
	console.log("IdVenta Antes de Validar Formulario FormIngresoFP: " + $("#IdVenta").val());
    $('#FormIngresoFP').formValidation('validate');
};

var CalcularMontosPreVenta = function(){
    var CantidadPreVenta = $("#CantidadProductoPreVenta").val();
	var PrecioPreVenta =  $("#PrecioProductoPreVenta").val();
	var MontoDescuentoPreVenta = 0;
	
    var TotalLineaPreVenta = ((CantidadPreVenta * PrecioPreVenta) - MontoDescuentoPreVenta);
    $("#TotalLineaPreVenta").val(TotalLineaPreVenta);
}

var CalcularSaldoPago = function(){
	var totalPagado = parseFloat($("#TotalPagadoPreVenta").val());
	var totalVendido = parseFloat($("#TotalPreVentaFP").val());
	var saldoFinal = totalPagado - totalVendido;		
	$("#SaldoPagoPreVenta").val(saldoFinal);
	
	console.log("Saldo Pendiente de Pago: " + saldoFinal +" - TotalPagado: " + totalPagado + " - TotalVendido: " +totalVendido);
}
	
var CalcularMontoCuotas = function(){
	var montoCredito = $("#MontoAFinanciar").val();
	var numeroCuotas = $("#NumeroCuotasCredito").val();
	var interesMensual = $("#InteresMensualCredito").val();
	
    var montoFinalCredito = montoCredito * ( 1 + (numeroCuotas * interesMensual/100));
    var montoCuota = montoFinalCredito / numeroCuotas;
    $("#MontoFinalCredito").val(Math.round(montoFinalCredito));
    $("#MontoCuotaCredito").val(Math.round(montoCuota));
}

var EliminarPago = function(IdDetallePago){
	console.log("Eliminando Pago: " + rutaEP + " - IdDetallePago: " + IdDetallePago);
	
	if(_tipoVenta_=="PreVenta"){ 
		parametroAjax.ruta=rutaEP;
		parametroAjax.data = {IdDetallePago:IdDetallePago};
		respuesta=procesarajax(parametroAjax);
		ManejoRespuestaEliminarPago(respuesta);
	}else if(_tipoVenta_=="Venta"){ 
		parametroAjax.ruta=rutaVEP;
		parametroAjax.data = {IdDetallePago:IdDetallePago};
		respuesta=procesarajax(parametroAjax);
		ManejoRespuestaEliminarPago(respuesta);
	}
}

var verificarRut = function(control,caso){
    var res = Valida_Rut(control);
    var format = formateaRut(control.val(), res);
    if (format != false){
        errorRut = 0;
        errorRut2 = 0;
        if (caso==1){buscarCliente(format);$("#ErrorRut").text("");}
        if (caso==2){$("#ErrorRut2").text("");}
        if (caso==3){buscarEmpresa(format);$("#ErrorRut3").text("");}
		if (caso==4){buscarClienteVC(format);$("#ErrorRutCredito").text("");}
        return format;
    }else{
        if (caso==1){errorRut = 1;$("#ErrorRut").text("RUT Cliente inválido");}
        if (caso==2){errorRut2 = 1;$("#ErrorRut2").text("Rut invalido");}
        if (caso==3){errorRut3 = 1;$("#ErrorRut3").text("Rut invalido");}
		if (caso==4){errorRut4 = 1;$("#ErrorRutCredito").text("Rut invalido");}
        return control.val();
    }
}

var verificarRUTVendedor = function(control){
    var res = Valida_Rut(control);
    var format = formateaRut(control.val(), res);
    if (format != false){
        buscarVendedor(format);
        return format;
    }else{
        
        return control.val();
    }
}

var ProcesarCargaPreferencias = function(){
    parametroAjax.ruta=rutaPVC;
    parametroAjax.data = $("#FormIngresoFP").serialize();
    respuesta=procesarajax(parametroAjax);
	console.log("Respuesta: " + respuesta);
	
    ManejoRespuestaProcesarCargaPreferencias(respuesta);
};

var ProcesarInfoCaja = function(){
    parametroAjax.ruta=rutaCD;
    parametroAjax.data = $("#FormIngresoFP").serialize();
    respuesta=procesarajax(parametroAjax);
	console.log("ProcesarInfoCaja --> Respuesta: " + respuesta);
	
    ManejoRespuestaProcesarInfoCaja(respuesta);
};

var ProcesarFormaPago = function(){
    if(_tipoVenta_=="PreVenta"){ 
		parametroAjax.ruta=rutaFP;
		parametroAjax.data = $("#FormIngresoFP").serialize();
		respuesta=procesarajax(parametroAjax);
		ManejoRespuestaProcesarFormaPago(respuesta);
	}else if(_tipoVenta_=="Venta"){ 
		parametroAjax.ruta=rutaVFP;
		parametroAjax.data = $("#FormIngresoFP").serialize();
		respuesta=procesarajax(parametroAjax);
		ManejoRespuestaProcesarFormaPago(respuesta);
	}
};

var buscarClienteVC = function(RUTCliente){
    parametroAjax.ruta=rutaBCC;
    parametroAjax.data = {RUTCliente:RUTCliente};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaBuscarClienteVC(respuesta);
}

var buscarCliente = function(RUTCliente){
    parametroAjax.ruta=rutaPVBC;
    parametroAjax.data = {RUTCliente:RUTCliente};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaBuscarCliente(respuesta);
}

var buscarProducto = function(CodigoBarra){
	if(CodigoBarra.length > 0){
		parametroAjax.ruta=rutaPVBP;
		parametroAjax.data = {CodigoBarra:CodigoBarra};
		respuesta=procesarajax(parametroAjax);
		
		ManejoRespuestaBuscarProductoPreVenta(respuesta);


	}else{
		//$.growl("Debe ingresar el Código del Producto!",{type: "warning", allow_dismiss: true,});
		//$("#CodigoProductoPreVenta").focus();
	}
}

var buscarVendedor = function(CodigoVendedor){
	if(CodigoVendedor.length > 0){
		parametroAjax.ruta=rutaPVBV;
		parametroAjax.data = {RUTVendedor:CodigoVendedor};
		respuesta=procesarajax(parametroAjax);
		
		ManejoRespuestaBuscarVendedorPreVenta(respuesta);

	}else{
		//$.growl("Debe ingresar el Código del Producto!",{type: "warning", allow_dismiss: true,});
		//$("#CodigoProductoPreVenta").focus();
	}
}

var ManejoRespuestaBuscarProductoPreVenta = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta!=null){
            if(respuesta.respuesta.producto.IdProducto){
                
                if(respuesta.respuesta.producto.IdProducto==0){
                    $.growl({message:"Producto no encontrado"},{type: "warning", allow_dismiss: true});
                    $("#CodigoProductoPreVenta").focus().select();

                }else{
                    $("#IdProductoPreVenta").val(respuesta.respuesta.producto.IdProducto);
                    $("#NombreProductoPreVenta").val(respuesta.respuesta.producto.NombreProducto);
                    $("#PrecioProductoPreVenta").val(respuesta.respuesta.producto.PrecioVentaSugerido);
                    $("#CantidadProductoPreVenta").val(1);
					
					CalcularMontosPreVenta();
					$("#CantidadProductoPreVenta").focus().select();
                } 
            } else {
            	 $.growl({message:"Producto no encontrado"},{type: "warning", allow_dismiss: true});

            	$("#IdProductoPreVenta").val("");
                $("#NombreProductoPreVenta").val("");
                $("#PrecioProductoPreVenta").val("");
                $("#CantidadProductoPreVenta").val("");

            	$("#CodigoProductoPreVenta").focus().select();
            }
        }else{
            $.growl({message:"Producto no encontrado"},{type: "warning", allow_dismiss: true});
            $("#CodigoProductoPreVenta").focus().select();
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true});
        $("#CodigoProductoPreVenta").focus().select();
    }
}

var ManejoRespuestaBuscarVendedorPreVenta = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta.v_usuario!=null){
            if(respuesta.respuesta.v_usuario.IdVendedor){
                if(respuesta.respuesta.v_usuario.IdVendedor==0){
                    $.growl({message:"Vendedor no encontrado"},{type: "warning", allow_dismiss: true});
					
					$("#IdVendedorPreVenta").val(0);
                    $("#NombreVendedorPreVenta").val("¡Vendedor No Identificado!");
                    $("#CodigoVendedor").focus().select();
					
                }else{
                    $("#IdVendedorPreVenta").val(respuesta.respuesta.v_usuario.IdVendedor);
                    $("#NombreVendedorPreVenta").val(respuesta.respuesta.v_usuario.NombreVendedor);
					
					if(_tipoVenta_=="PreVenta") parametroAjax.ruta=rutaPVAV;
					if(_tipoVenta_=="Venta") parametroAjax.ruta=rutaVAV;
					
					parametroAjax.data = $("#FormPreVenta").serialize();
					respuesta=procesarajax(parametroAjax);

					CerrarModalAsignarVendedor();
                }
            } 
        }else{
            $.growl({message:"Vendedor no encontrado"},{type: "warning", allow_dismiss: true});
			
			$("#IdVendedorPreVenta").val(0);
			$("#NombreVendedorPreVenta").val("¡Vendedor No Identificado!");
        }
		
		_idVendedor_=$("#IdVendedorPreVenta").val();
		_nombreVendedor_=$("#NombreVendedorPreVenta").val();
		AsignarVendedorPreVenta();
		
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true});
    }
}

var ManejoRespuestaProcesarFormaPago = function(respuesta){
    if(respuesta.code==200){
        var res = JSON.parse(respuesta.respuesta.f_registro);
        switch(res.code) {
            case '200':
                $.growl({message:res.des_code},{type: "success", allow_dismiss: true,});
                $("#ModalIngresoPago").modal("hide");
				
				//$(".divBotonesC").toggle();
                //$('#IdVenta2').val("");
                $('#FormIngresoFP')[0].reset();
                CargarTablaPagos(respuesta.respuesta.v_pagos);
				console.log("Pago Procesado!!!");
				
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

var ProcesarProductoPreVenta = function(){
    if(errorRut == 0){
		if(_tipoVenta_=="PreVenta"){
			parametroAjax.ruta=rutaPVAP;
			parametroAjax.data = $("#FormPreVenta").serialize();
			respuesta=procesarajax(parametroAjax);
			ManejoRespuestaProcesarProductoPreVenta(respuesta, 1);
			
		}else if(_tipoVenta_=="Venta"){
			parametroAjax.ruta=rutaVAP;
			parametroAjax.data = $("#FormPreVenta").serialize();
			respuesta=procesarajax(parametroAjax);
			ManejoRespuestaProcesarProductoPreVenta(respuesta, 1);
		}
    }
};

var ManejoRespuestaProcesarProductoPreVenta = function(respuesta, origen){	
    if(respuesta.code==200){
		var res = JSON.parse(respuesta.respuesta.f_registro);
		
		if(res.code==200){
			$.growl({message:" "+_tipoVenta_+" Recuperada con éxito!!!"},{type: "success", allow_dismiss: true,});
					
			$("#IdProductoPreVenta").val("");
			$("#NombreProductoPreVenta").val("");
			$("#PrecioProductoPreVenta").val("");
			$("#CantidadProductoPreVenta").val("");
			$("#CodigoProductoPreVenta").val("");
			
			$('#EstadoPreVenta').val(respuesta.respuesta.v_cabecera[0].EstadoPreVenta);
			if(_tipoVenta_=="PreVenta") _idVenta_=respuesta.respuesta.v_cabecera[0].idPreVenta;
			if(_tipoVenta_=="Venta") _idVenta_=respuesta.respuesta.v_cabecera[0].IdVenta;
			
			$('#IdPreVenta').val(_idVenta_);
			AsignarIdPreVenta(_idVenta_);
			
			CargarTablaProductosPreVenta(respuesta.respuesta.v_detalles);
			
			if(origen == "2"){
				console.log("Origen: " + origen);
				$("#IdVendedorPreVenta").val(respuesta.respuesta.v_cabecera[0].IdVendedor);
				$("#NombreVendedorPreVenta").val(respuesta.respuesta.v_cabecera[0].NombreVendedor);
				
				_idVendedor_=$("#IdVendedorPreVenta").val();
				_nombreVendedor_=$("#NombreVendedorPreVenta").val();		
				AsignarVendedorPreVenta();		
				
				$("#IdClientePreVenta").val(respuesta.respuesta.v_cabecera[0].IdCliente);
				$("#NombreClientePreVenta").val(respuesta.respuesta.v_cabecera[0].NombreCliente);
				$("#RUTCliente").val(respuesta.respuesta.v_cabecera[0].RUTCliente);
				$("#RUTCliente").val(respuesta.respuesta.v_cabecera[0].RUTCliente);
				AsignarClientePreVenta();
				
				CargarTablaPagos(respuesta.respuesta.v_pagos);
				$("#botonFormaPagoPreVenta").text("Total Pagado: " + $("#TotalPagadoPreVenta").val());

				$('#IdTipoDTEPreVenta').val(respuesta.respuesta.v_cabecera[0].TipoDTE);
				$('#IdTipoDTE').val(respuesta.respuesta.v_cabecera[0].TipoDTE);
				$('#botonTipoDTE').text(respuesta.respuesta.v_cabecera[0].DTE);	
				AsignaTipoDTE($('#IdTipoDTEPreVenta').val(), $('#botonTipoDTE').text());
				
				AgregarProductos();
				if($('#EstadoPreVenta').val()==2){
					$("#botonVendedorPreVenta").prop('disabled', true);
					$("#botonClientePreVenta").prop('disabled', true);
					$("#botonFormaPagoPreVenta").prop('disabled', true);
					$("#botonAgregarProductoPreVenta").prop('disabled', true);
					$("#botonFinalizarPreVenta").hide();
					
					$("#botonCancelarPreVenta_1").text('Cerrar Formulario');
					$("#botonCancelarPreVenta_2").text('Cerrar Formulario');
					$("#basic-forms-h-0").text(' '+_tipoVenta_+' Finalizada');
					
					$("#frameNroPreVenta").show();
					$("#frameProductos").hide();
					
				}else{
					$("#botonVendedorPreVenta").prop('disabled', false);
					$("#botonClientePreVenta").prop('disabled', false);
					$("#botonFormaPagoPreVenta").prop('disabled', false);
					$("#botonAgregarProductoPreVenta").prop('disabled', false);
					$("#botonFinalizarPreVenta").show();
					
					$("#botonCancelarPreVenta_1").text('Cancelar '+_tipoVenta_);
					$("#botonCancelarPreVenta_2").text('Cancelar '+_tipoVenta_);
					$("#basic-forms-h-0").text('Productos '+_tipoVenta_);
				}
				console.log("Fin Origen: " + origen);
			}

			$("#CodigoProductoPreVenta").focus().select();

		}else{
			$.growl({message:res.des_code},{type: "warning", allow_dismiss: true,});
		}
		
    }else{
        $.growl({message:"Contacte al personal informático..."},{type: "danger", allow_dismiss: true,});
    }

};

var ManejoRespuestaBuscarCliente = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta!=null){
            if(respuesta.respuesta.v_cliente!=null){

				var EstadoClienteVC = respuesta.respuesta.v_cliente[0].EstadoCliente;
				if(EstadoClienteVC==2) $("#IdClientePreVenta").val("");
				else $("#IdClientePreVenta").val(respuesta.respuesta.v_cliente[0].IdCliente);	

				$("#IdClientePreVenta").val(respuesta.respuesta.v_cliente[0].IdCliente);	
				$("#NombreClientePreVenta").val(respuesta.respuesta.v_cliente[0].NombreCliente);
				$("#EstadoClientePreVenta").val(respuesta.respuesta.v_cliente[0].DetalleEstadoCliente);
				$("#CA_ClientePreVenta").val(respuesta.respuesta.v_cliente[0].CupoAutorizado);
				$("#CU_ClientePreVenta").val(respuesta.respuesta.v_cliente[0].CupoUtilizado);
				$("#CD_ClientePreVenta").val($("#CA_ClientePreVenta").val() - $("#CU_ClientePreVenta").val() );
				$("#CD_ClientePreVenta").val(parseFloat($("#CD_ClientePreVenta").val()).toLocaleString('cl'));					
				$("#PC_ClientePreVenta").val(moment(respuesta.respuesta.v_cliente[0].fechaProximaCuota, 'YYYY-MM-DD',true).format("DD-MM-YYYY"));   
					
				console.log("Actualiza Cliente en DB...");
				if(_tipoVenta_=="PreVenta") parametroAjax.ruta=rutaPVAC;
				if(_tipoVenta_=="Venta") parametroAjax.ruta=rutaVAC;
						
				parametroAjax.data = $("#FormPreVenta").serialize();
				respuesta=procesarajax(parametroAjax);
				
				if(EstadoClienteVC==1) AsignarClientePreVenta();
				$("#RUTCliente").focus().select();			
				
            }else{
				// var rut = $("#RUTProveedor").val();
                // $("#RUTProveedor2").val(rut);
                // $("#ModalProveedor").modal();

            }    
        }else{
            $.growl({message:"Cliente no encontrado"},{type: "warning", allow_dismiss: true,});
        }
		
		
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

var ManejoRespuestaEliminarPago = function(respuesta){
    
	if(respuesta.code==200){
        if(respuesta.respuesta!=null){
			
			switch(respuesta.code) {
				case '200':	
					$.growl({message:"Pago eliminado correctamente..."},{type: "success", allow_dismiss: true,});
					CargarTablaPagos(respuesta.respuesta.v_pagos);
					break;
				case '-2':
					$.growl({message:"Error---"},{type: "warning", allow_dismiss: true,});
					break;
				default:
					$.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
					break;
			}
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }

}

var ManejoRespuestaProcesarCargaPreferencias = function(respuesta){	
    if(respuesta.code==200){
		
        if(respuesta.respuesta!=null){
			
            if(respuesta.respuesta.IdCliente==0){
                $("#NumeroCuotasCredito").val(6);
				$("#InteresMensualCredito").val(2.5);
            }else{
                $("#NumeroCuotasCredito").val(respuesta.respuesta.v_pvc.NumeroMaxCuotas);
                $("#InteresMensualCredito").val(respuesta.respuesta.v_pvc.InteresMensual);
            }    
        }else{
            $.growl({message:"Cliente no encontrado"},{type: "warning", allow_dismiss: true,});
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

var ManejoRespuestaProcesarInfoCaja = function(respuesta){	
    if(respuesta.code==200){
		
        if(respuesta.respuesta!=null){
			console.log("respuesta.respuesta.v_cajaActual.IdCaja: " + respuesta.respuesta.v_cajaActual[0].IdCaja);
			console.log("respuesta.respuesta.v_cajaActual.IdLocal: " + respuesta.respuesta.v_cajaActual[0].IdLocal);
			
            if(respuesta.respuesta.v_cajaActual==null){
                _idCaja_= 0;
				_idLocal_= 0;
            }else{
				$("#IdLocalPreVenta").val(respuesta.respuesta.v_cajaActual[0].IdLocal);
				$("#IdCajaPreVenta").val(respuesta.respuesta.v_cajaActual[0].IdCaja);
								
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

var ManejoRespuestaBuscarClienteVC = function(respuesta){
	
	console.log("ManejoRespuestaBuscarClienteVC...");
	
    if(respuesta.code==200){
        if(respuesta.respuesta.v_cliente!=null){
            $("#IdClienteVC").val(respuesta.respuesta.v_cliente[0].IdCliente);
            $("#NombreClienteCredito").val(respuesta.respuesta.v_cliente[0].NombreCliente);
            $("#FechaPrimeraCuota").val(respuesta.respuesta.v_fechas.fechaPago);

            $("#bontonEstadoClienteVC").text("CLIENTE " + respuesta.respuesta.v_cliente[0].DetalleEstadoCliente);
            if(respuesta.respuesta.v_cliente[0].EstadoCliente==1) {
                $("#bontonEstadoClienteVC").removeClass("btn-danger");
                $("#bontonEstadoClienteVC").addClass("btn-success");

                $("#botonGuardarFormaPago").prop('disabled', false);
                $("#botonGuardarFormaPago").text("Continuar");
                $("#botonGuardarFormaPago").removeClass("btn-danger");
                $("#botonGuardarFormaPago").addClass("btn-success");

            }else if(respuesta.respuesta.v_cliente[0].EstadoCliente==2) {
                $("#bontonEstadoClienteVC").removeClass("btn-success");
                $("#bontonEstadoClienteVC").addClass("btn-danger");

                $("#botonGuardarFormaPago").text("VENTA NO PERMITIDA");
                $("#botonGuardarFormaPago").removeClass("btn-success");
                $("#botonGuardarFormaPago").addClass("btn-danger");
                $("#botonGuardarFormaPago").prop('disabled', true);

            }

            $("#bontonEstadoClienteVC").show();

        }else{
            $.growl({message:"Cliente no encontrado"},{type: "warning", allow_dismiss: true,});
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

var CargarTablaPagos = function(data){
    if(limpiarPagos==1) { destruirTabla('#tablaPagos'); $('#tablaPagos thead').empty();}
	
	$("#tablaPagos").dataTable({
		
		"footerCallback": function (data){
		var api = this.api(), data;
		// Remove the formatting to get integer data for summation
		var intVal = function (i){
			return typeof i === 'string' ?
				i.replace(/[\$,]/g, '')*1 :
				typeof i === 'number' ?
					i : 0;
		};
		// Total over all pages
		totalPago = api
			.column(4)
			.data()
			.reduce( function (a, b) {
				return intVal(a) + intVal(b);
			}, 0 );
		},
		
		responsive:false,
		"bSort": false,
		"scrollCollapse": false,
		"paging": false,
		"searching": false,
		"info":false,			
		"pageLength": 50, 
		
		"data": data,
		"columns":[
			{"title": "",
			 "data": "IdDetallePago",
				"render": function(data, type, row, meta){
					var result = `
					<center>
					<a href="#" onclick="EliminarPago(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Eliminar Pago" data-original-title="Delete">
						<i class="icofont icofont-ui-delete"></i>
					</a>
					</center>`;
					return result;
				}
			},
			{"title": "Id Pago","data": "IdDetallePago",visible:0},
			{"title": "Id "+_tipoVenta_,"data": "Id"+_tipoVenta_,visible:0},
			{"title": "Forma de Pago","data": "FormaPago", width: 200,  className: "text-left"},
			{"title": "Monto Pagado","data": "MontoPagado", width: 300, className: "text-right", render: $.fn.dataTable.render.number('.',',',2) }
		],   
		
	});

	limpiarPagos=1;
	console.log("Total Pagos: " + totalPago);
	$("#TotalPagadoPreVenta").val(totalPago);
	CalcularSaldoPago();
};

var CargarTablaProductosPreVenta = function(data){
    if(limpiarImpuestos==1){
		console.log("limpiarImpuestos: " + limpiarImpuestos);

		destruirTabla('#tablaDetalles');
		$('#tablaDetalles thead').empty();
		
	}
    
	$("#tablaDetalles").dataTable({
		
		"footerCallback": function (data){
		var api = this.api(), data;
		// Remove the formatting to get integer data for summation
		var intVal = function (i){
			return typeof i === 'string' ?
				i.replace(/[\$,]/g, '')*1 :
				typeof i === 'number' ?
					i : 0;
		};
		// Total over all pages
		totalPV = api
			.column(8)
			.data()
			.reduce( function (a, b) {
				return intVal(a) + intVal(b);
			}, 0 );
		},
		responsive:false,
		"bSort": false,
		"scrollCollapse": false,
		"paging": false,
		"searching": false,
		"info":false,			
		"pageLength": 50, 
		"columnDefs": [
			{"targets": [ 1 ],"searchable": true},
			{"sWidth": "1px", "aTargets": [8]}
		],
		"data": data,
		"columns":[
		   
			{"title": "Id","data": "IdDetalle"+_tipoVenta_,visible:0},
			{"title": "Id"+_tipoVenta_,"data": "Id"+_tipoVenta_,visible:0},
			{"title": "IdProducto","data": "IdProducto",visible:0},
			{"title": "Código","data": "CodigoBarra",
						className: "text-right"},
			{"title": "Producto","data": "NombreProducto", 
						width: 800},
			{"title": "Valor","data": "ValorUnitarioVenta", 
						width: 100,
						render: $.fn.dataTable.render.number( '.', ',', 2 ),
						className: "text-right"},
			{"title": "Cant.","data": "Cantidad"+_tipoVenta_, 
						width: 50,
						render: $.fn.dataTable.render.number( '.', ',', 2 ),
						className: "text-center"},
			{"title": "Dcto","data": "MontoDescuento",visible:0},
			{"title": "Total","data": "TotalLinea", 
						width: 100,
						render: $.fn.dataTable.render.number( '.', ',', 2 ),
						className: "text-right"},
			{"title": "",
				"data": "IdDetalle"+_tipoVenta_,
				width: 100,
				"render": function(data, type, row, meta){
					var result = `
					<center>
					
					 <a href="#" onclick="cambiarEstatusPreventa(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
						<i class="icofont icofont-ui-delete"></i>
					</a>
					</center>`;
					return result;
				}
			},	
		],
	});

	limpiarImpuestos=1;
	console.log("totalPV: " + totalPV);
	$("#TotalPreVenta_").val("$" + totalPV);
	$("#TotalPreVenta").val("$" + totalPV);
	$("#TotalPreVentaFP").val(totalPV);
	
	//calcularTotalPreVenta(totalPV);
};

// var CargarTablaProductosPreVenta = function(data){
//     if(limpiarImpuestos==1){
// 		destruirTabla('#tablaDetalles');
// 		$('#tablaDetalles thead').empty();
// 		console.log("limpiarImpuestos: " + limpiarImpuestos);
// 	}
    
// 	//var columnReport = [[4],[5],[6],[7],[8],[9]];       
	
// 	$("#tablaDetalles").dataTable({
		
// 		"footerCallback": function (data){
// 		var api = this.api(), data;
// 		// Remove the formatting to get integer data for summation
// 		var intVal = function (i){
// 			return typeof i === 'string' ?
// 				i.replace(/[\$,]/g, '')*1 :
// 				typeof i === 'number' ?
// 					i : 0;
// 		};
// 		// Total over all pages
// 		totalPV = api
// 			.column(8)
// 			.data()
// 			.reduce( function (a, b) {
// 				return intVal(a) + intVal(b);
// 			}, 0 );
// 		},
// 		responsive:false,
// 		"bSort": false,
// 		"scrollCollapse": false,
// 		"paging": false,
// 		"searching": false,
// 		"info":false,			
// 		"pageLength": 50, 
// 		"columnDefs": [
// 			{"targets": [ 1 ],"searchable": true},
// 			{"sWidth": "1px", "aTargets": [8]}
// 		],
// 		"data": data,
// 		"columns":[
		   
// 			{"title": "Id","data": "IdDetalle"+_tipoVenta_,visible:0},
// 			{"title": "Id"+_tipoVenta_,"data": "Id"+_tipoVenta_,visible:0},
// 			{"title": "IdProducto","data": "IdProducto",visible:0},
// 			{"title": "Código","data": "CodigoBarra",
// 						className: "text-right"},
// 			{"title": "Producto","data": "NombreProducto", 
// 						width: 800},
// 			{"title": "Valor","data": "ValorUnitarioVenta", 
// 						width: 100,
// 						render: $.fn.dataTable.render.number( '.', ',', 2 ),
// 						className: "text-right"},
// 			{"title": "Cant.","data": "Cantidad"+_tipoVenta_, 
// 						width: 50,
// 						render: $.fn.dataTable.render.number( '.', ',', 2 ),
// 						className: "text-center"},
// 			{"title": "Dcto","data": "MontoDescuento",visible:0},
// 			{"title": "Total","data": "TotalLinea", 
// 						width: 100,
// 						render: $.fn.dataTable.render.number( '.', ',', 2 ),
// 						className: "text-right"},
// 			{"title": "",
// 				"data": "IdDetalle"+_tipoVenta_,
// 				width: 100,
// 				"render": function(data, type, row, meta){
// 					var result = `
// 					<center>
					
// 					 <a href="#" onclick="cambiarEstatusPreventa(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
// 						<i class="icofont icofont-ui-delete"></i>
// 					</a>
// 					</center>`;
// 					return result;
// 				}
// 			},	
// 		],
// 		dom: 'Bfrtip',
//         buttons: [
//             {	extend: 'print',
// 				text: 'Imprimir '+_tipoVenta_,
// 				className: 'btn btn-inverse-warning',
// 				pageSize:'A5',
// 				autoPrint: true,
// 				exportOptions: {columns: columnReport, modifier: {page: 'all', } },
// 			},
//         ]
		
// 	});

// 	limpiarImpuestos=1;
// 	console.log("totalPV: " + totalPV);
// 	$("#TotalPreVenta_").val("$" + totalPV);
// 	$("#TotalPreVenta").val("$" + totalPV);
// 	$("#TotalPreVentaFP").val(totalPV);
	
// 	//calcularTotalPreVenta(totalPV);
// };

function printDIV(){
	var divToPrint = document.getElementById("tablaDetalles");
	var newWin = window.open('', 'Printing...');
	newWin.document.open();
	newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
	newWin.document.close();
	setTimeout(function(){newWin.close();}, 10);
}

