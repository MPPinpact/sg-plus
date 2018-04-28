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

$(document).ready(function() {
	// moment en idioma español
	// moment.locale('es');
	//Datos de usuario para cargar el contenido dependiendo del perfil
	v['v_perfil'] = $("#idPerfiltext").val();
	v['idUser'] = $("#idUsertext").val();
	//Cierre de sesion despues de 20 min de inactividad
	setTimeout(function(){();},1200000);
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
});