var meses = ['', 'Enero','Febrero','Marzo','Abril','Mayo', 'Junio', 'Julio', 'Agosto', 'Septiempre','Octubre','Noviembre','Diciembre'];
var imgProgreso = '<img alt="" src="/img/giphy.gif" height="50" width="50"/>';
var stopRead = 0;
var cambiarSalir = function(){
	v_salir = 1;
}

var parametroAjaxGET = {
    'token': $('input[name=_token]').val(),
    'tipo': 'GET',
    'data': {},
    'ruta': '',
    'async': false
};

var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};

// Maximizar ventana de chat
var ShowMessage = function(){
	$("#divChatMin").stop();
	$("#divChatMin").hide("slow");
	$("#divChat").show("fast");
	$('#message').focus();
	cambiarStatusMessage();
}

// Minimizar ventana de chat
var HideMessage = function(){
	$("#divChat").hide("fast");
	$("#divChatMin").show("slow");
}

var cargarPanelesVenta = function(){
	//console.log("cargarPaneles()");
	
    parametroAjax.ruta=rutaHome;
    respuesta=procesarajax(parametroAjax);

    ventaAgno = respuesta.respuesta.ventaAgno;
    ventaMes = respuesta.respuesta.ventaMes;
    ventaSemana = respuesta.respuesta.ventaSemana;
    ventaDia = respuesta.respuesta.ventaDia;
    vendedores = respuesta.respuesta.vendedores;

	var ventaLocal="";
	var totalLocales=0;

    for(i=0; i < ventaDia.length; i++){
    	ventaLocal = ventaLocal + ventaDia[i].NombreLocal + ": $ " + parseFloat(ventaDia[i].TotalVenta).toLocaleString('cl') + "<br>";
    	totalLocales = parseFloat(totalLocales) + parseFloat(ventaDia[i].TotalVenta);
    }

    $("#VentaDiaLocal").html(ventaLocal);
    $("#totalVentaDia").html(parseFloat(totalLocales).toLocaleString('cl'));

	var ventaLocal="";
	var totalLocales=0;

    for(i=0; i < ventaSemana.length; i++){
    	ventaLocal = ventaLocal + ventaSemana[i].NombreLocal + ": $ " + parseFloat(ventaSemana[i].TotalVenta).toLocaleString('cl') + "<br>";
    	totalLocales = parseFloat(totalLocales) + parseFloat(ventaSemana[i].TotalVenta);
    }

    $("#VentaSemanaLocal").html(ventaLocal);
    $("#totalVentaSemana").html(parseFloat(totalLocales).toLocaleString('cl'));

    var ventaLocal="";
	var totalLocales=0;

    for(i=0; i < ventaMes.length; i++){
    	ventaLocal = ventaLocal + ventaMes[i].NombreLocal + ": $ " + parseFloat(ventaMes[i].TotalVenta).toLocaleString('cl') + "<br>";
    	totalLocales = parseFloat(totalLocales) + parseFloat(ventaMes[i].TotalVenta);
    }

    $("#VentaMesLocal").html(ventaLocal);
	$("#totalVentaMes").html(parseFloat(totalLocales).toLocaleString('cl') );
	$("#totalMes").html("Venta acumulada en " + meses[ventaMes[0].Mes]);


	var ventaLocal="";
	var totalLocales=0;

    for(i=0; i < ventaAgno.length; i++){
    	ventaLocal = ventaLocal + ventaAgno[i].NombreLocal + ": $ " + parseFloat(ventaAgno[i].TotalVenta).toLocaleString('cl') + "<br>";
    	totalLocales = parseFloat(totalLocales) + parseFloat(ventaAgno[i].TotalVenta);
    }

    $("#VentaAgnoLocal").html(ventaLocal);
	$("#totalVentaAgno").html(parseFloat(totalLocales).toLocaleString('cl') );
	$("#totalAgno").html("Venta acumulado el " + ventaAgno[0].Agno);

    //Score Venta 
    $("#tablaScoreVendedoresBody").empty();

    for(i=0; i < vendedores.length; i++){
        var avance = 0;
        if(vendedores[i].AcumuladoPeriodo>0){
            avance = (parseFloat(vendedores[i].AcumuladoPeriodo) / parseFloat(vendedores[i].MetaPeriodo) * 100).toLocaleString('cl');
        }else{
            vendedores[i].AcumuladoPeriodo = 0;
        }
        $('#tablaScoreVendedores tr:last').after('<tr><th><img class="img-fluid rounded-circle" src="'+vendedores[i].FotoVendedor+'" alt="User"></th><td>'+vendedores[i].NombreVendedor+'<p><i class="icofont icofont-sale-discount"></i>Comisión: '+parseFloat(vendedores[i].ComisionVendedor).toLocaleString('cl')+'</p></td><td>$'+ parseFloat(vendedores[i].MetaPeriodo).toLocaleString('cl')+'</td><td>$'+parseFloat(vendedores[i].AcumuladoPeriodo).toLocaleString('cl')+'</td><td class="chart">'+avance+'% <span class="pie" style="display: none;">180,180</span></td></tr>');
    }   
}

var cargarScoreVendedores = function(){
    //console.log("cargarScoreVendedores()");

}

$(document).ready(function() {
	// moment en idioma español
	// moment.locale('es');
	//Datos de usuario para cargar el contenido dependiendo del perfil
	v['v_perfil'] = $("#idPerfiltext").val();
	v['idUser'] = $("#idUsertext").val();
	//Cierre de sesion despues de 20 min de inactividad
	setTimeout(function(){Salir();},1200000);
	// Cierre de session por manupulacion de url o cierre del navegador
	window.onbeforeunload = function (e) {if (v_salir == 0){Salir();}v_salir = 0;}
    // $(document).on('click','.btn',cambiarSalir);
    $(document).on('click','.settings-menu',cambiarSalir);
    $(document).on('click','.waves-effect',cambiarSalir);
    $(document).on('click','.logo',cambiarSalir);
    $(document).on('click','.download-icon',cambiarSalir);
    //$(document).on('click','.text-muted',cambiarSalir);
    
    $(document).on('click','#btn-logout',Salir);
	$(document.body).on("keydown", this, function (event) {
	    if (event.keyCode == 116) {
	        cambiarSalir();
	    }
	});

	cargarPanelesVenta();
    cargarScoreVendedores();
});