<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //return view('auth.login');
     return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/infoDashboard', 'HomeController@getInfoDashboard')->name('infoDashboard');

//CRUD Empresas
Route::get('/empresas', 'EmpresaController@getEmpresas')->name('empresas');
Route::post('/empresas', 'EmpresaController@postEmpresas')->name('empresas');
Route::post('/activarE', 'EmpresaController@postEmpresactiva')->name('activarE');
Route::post('/detallesE', 'EmpresaController@postEmpresadetalle')->name('detallesE');

//CRUD Locales
Route::get('/locales', 'LocalController@getLocal')->name('locales');
Route::post('/locales', 'LocalController@postLocal')->name('locales');
Route::post('/activarL', 'LocalController@postLocalactivo')->name('activarL');
Route::post('/detallesL', 'LocalController@postLocaldetalle')->name('detallesL');

//CRUD Bodega
Route::get('/bodegas', 'BodegaController@getBodega')->name('bodegas');
Route::post('/bodegas', 'BodegaController@postBodega')->name('bodegas');
Route::post('/activarB', 'BodegaController@postBodegactivo')->name('activarB');
Route::post('/detallesB', 'BodegaController@postBodegadetalle')->name('detallesB');

//CRUD Unidad de medida
Route::get('/umedidas', 'UnidadmedidaController@getUnidadmedida')->name('umedidas');
Route::post('/umedidas', 'UnidadmedidaController@postUnidadmedida')->name('umedidas');
Route::post('/activarUm', 'UnidadmedidaController@postUnidadmedidactivo')->name('activarUm');
Route::post('/umedidasb', 'UnidadmedidaController@postBuscarunidad')->name('umedidasb');

//CRUD Familia
Route::get('/familias', 'FamiliaController@getFamilia')->name('familias');
Route::post('/familiasActivas', 'FamiliaController@getFamiliasActivas')->name('familiasActivas');
Route::post('/familiasTodas', 'FamiliaController@getFamiliasTodas')->name('familiasTodas');
Route::post('/familias', 'FamiliaController@postFamilia')->name('familias');
Route::post('/activarF', 'FamiliaController@postFamiliactivo')->name('activarF');
Route::post('/familiab', 'FamiliaController@postBuscarfamilia')->name('familiab');

//CRUD SubFamilia
Route::get('/subfamilias', 'SubfamiliaController@getSubamilia')->name('subfamilias');
Route::post('/subfamilias', 'SubfamiliaController@postSubfamilia')->name('subfamilias');
Route::post('/subfamiliasActivas', 'SubfamiliaController@postSubfamiliaActivas')->name('subfamiliasActivas');
Route::post('/subfamiliasTodas', 'SubfamiliaController@postSubfamiliaTodas')->name('subfamiliasTodas');
Route::post('/activarSf', 'SubfamiliaController@postSubfamiliactivo')->name('activarSf');
Route::post('/subfamiliab', 'SubfamiliaController@postBuscarsubfamilia')->name('subfamiliab');

//CRUD Impuestos
Route::get('/impuestos', 'ImpuestoController@getImpuesto')->name('impuestos');
Route::post('/impuestos', 'ImpuestoController@postImpuesto')->name('impuestos');
Route::post('/activarI', 'ImpuestoController@postImpuestoactivo')->name('activarI');
Route::post('/impuestob', 'ImpuestoController@postBuscarimpuesto')->name('impuestob');

//CRUD Productos
Route::get('/productos', 'ProductoController@getProducto')->name('productos');
Route::post('/productos', 'ProductoController@postProducto')->name('productos');
Route::post('/activarPr', 'ProductoController@postProductoactivo')->name('activarPr');
Route::post('/descontinuarPr', 'ProductoController@postProductodescontinuar')->name('descontinuarPr');
Route::post('/detallesPr', 'ProductoController@postProductodetalle')->name('detallesPr');
Route::post('/buscarSubfamilia', 'ProductoController@postBuscarsub')->name('buscarSubfamilia');
Route::post('/procesarIm', 'ProductoController@postprocesarImpuesto')->name('procesarIm');
Route::post('/activarIm', 'ProductoController@postImpuestopactivo')->name('activarIm');
Route::post('/buscarProveedor', 'ProductoController@postBuscarProveedor')->name('buscarProveedor');

//CRUD Proveedores
Route::get('/proveedores', 'ProveedorController@getProveedor')->name('proveedores');
Route::post('/proveedores', 'ProveedorController@postProveedor')->name('proveedores');
Route::post('/activarPro', 'ProveedorController@postProveedoractivo')->name('activarPro');
Route::post('/detallesP', 'ProveedorController@postProveedordetalle')->name('detallesP');

//CRUD Clientes
Route::get('/clientes', 'ClienteController@getCliente')->name('clientes');
Route::post('/clientes', 'ClienteController@postCliente')->name('clientes');
Route::post('/activarCli', 'ClienteController@postClienteactivo')->name('activarCli');
Route::post('/detallesCli', 'ClienteController@postClienteDetalle')->name('detallesCli');

//CRUD Crédito
Route::get('/credito', 'CreditoController@getCreditoPreferencias')->name('credito');
Route::post('/credito', 'CreditoController@postCreditoPreferencias')->name('credito');
Route::post('/activarPCr', 'CreditoController@postCreditoPreferenciaactivo')->name('activarPCr');
Route::post('/preferCreditob', 'CreditoController@postBuscarCreditoPreferencia')->name('preferCreditob');

// CRUD Venta credito
Route::get('/ventaCredito', 'VentaCreditoController@getVentaCredito')->name('ventaCredito');
Route::post('/ventaCredito', 'VentaCreditoController@postVentaCredito')->name('ventaCredito');
Route::post('/activarCr', 'VentaCreditoController@postVentaCreditoactivo')->name('activarCr');
Route::post('/ventaCreditob', 'VentaCreditoController@postBuscarVentaCredito')->name('ventaCreditob');
Route::post('/ventaCliente', 'VentaCreditoController@postBuscarCliente')->name('ventaCliente');

// CRUD Ciclo Facturacion
Route::get('/cicloFacturacion', 'CicloFacturacionController@getCicloFacturacion')->name('cicloFacturacion');
Route::post('/cicloFacturacion', 'CicloFacturacionController@postCicloFacturacion')->name('cicloFacturacion');
Route::post('/activarCF', 'CicloFacturacionController@postCicloactivo')->name('activarCF');
Route::post('/detallesCF', 'CicloFacturacionController@postCiclodetalle')->name('detallesCF');
Route::post('/generarEECC', 'CicloFacturacionController@postGenerarEECC')->name('generarEECC');

//CRUD Compra
Route::get('/compras', 'CompraController@getCompras')->name('compras');
Route::get('/compraMasivaList', 'CompraController@getCompraMasivaList')->name('compraMasivaList');
Route::get('/compraMasivaNew', 'CompraController@getCompraMasivaNew')->name('compraMasivaNew');
Route::get('/compraMasivaReport', 'CompraController@getCompraMasivaReport')->name('compraMasivaReport');

Route::any('/compraMasivaView', 'CompraController@getCompraMasivaView')->name('compraMasivaView');
//Route::post('/compraMasivaView', 'CompraController@postCompraMasivaView')->name('compraMasivaView');

Route::post('/compras', 'CompraController@postCompras')->name('compras');
Route::post('/activarCom', 'CompraController@postCompractiva')->name('activarCom');
Route::post('/comprab', 'CompraController@postBuscarcompra')->name('comprab');
Route::post('/comprabp', 'CompraController@postBuscarproveedor')->name('comprabp');
Route::post('/comprabe', 'CompraController@postBuscarempresa')->name('comprabe');
Route::post('/comprapr', 'CompraController@postRegistroproveedor')->name('comprapr');
Route::post('/comprabb', 'CompraController@postBuscarBodega')->name('comprabb');
Route::post('/comprabc', 'CompraController@postBuscarcombos')->name('comprabc');
Route::post('/comprabpd', 'CompraController@postBuscarproductos')->name('comprabpd');
Route::post('/compraBPM', 'CompraController@postBuscarProductoMasivo')->name('compraBPM');
Route::post('/comprardc', 'CompraController@postRegistrarDetallec')->name('comprardc');
Route::post('/compraRDCM', 'CompraController@postRegistrarDetalleCompraMasiva')->name('compraRDCM');
Route::post('/compraRBD', 'CompraController@postRegistrarBodegaDestino')->name('compraRBD');
Route::post('/compraCDC', 'CompraController@postCargarDetalleCompraMasiva')->name('compraCDC');
Route::post('/compraFDC', 'CompraController@postFinalizarCompraMasiva')->name('compraFDC');


Route::post('/compraBD', 'CompraController@getBodegaDestino')->name('compraBD');
Route::post('/compraEBD', 'CompraController@postEliminarAsignacionBodegaDestino')->name('compraEBD');
Route::post('/compraCSP', 'CompraController@getStockProducto')->name('compraCSP');
Route::post('/compraRC', 'CompraController@getResumenCompra')->name('compraRC');

Route::post('/comprarbdc', 'CompraController@postBuscarDetallec')->name('comprarbdc');
Route::post('/comprada', 'CompraController@postCompradetalleactiva')->name('comprada');

Route::get('/compraPurchaseList', 'CompraController@getCompraPurchaseList')->name('compraPurchaseList');
Route::get('/compraPurchasListNew', 'CompraController@getCompraPurchaseList')->name('compraPurchasListNew');

//CRUd preventa
Route::get('/preventas', 'PreventaController@getPreventas')->name('preventas');
Route::post('/preventas', 'PreventaController@postPreventas')->name('preventas');
Route::post('/activarPre', 'PreventaController@postPreventactiva')->name('activarPre');
Route::post('/preventab', 'PreventaController@postBuscarPreventa')->name('preventab');
Route::post('/preventabc', 'PreventaController@postBuscarCliente')->name('preventabc');
Route::post('/preventabpd', 'PreventaController@postBuscarproductos')->name('preventabpd');
Route::post('/preventadc', 'PreventaController@postRegistrarDetallec')->name('preventadc');
Route::post('/preventabdc', 'PreventaController@postBuscarDetallec')->name('preventabdc');
Route::post('/preventacp', 'PreventaController@postCerrarPreventa')->name('preventacp');
Route::post('/preventada', 'PreventaController@postPreventadetalleactiva')->name('preventada');
Route::post('/preventaRP', 'PreventaController@postRegistrarPagoPreVenta')->name('preventaRP');
Route::post('/preventaEP', 'PreventaController@postDetallePagoActiva')->name('preventaEP');

//CRUd venta
Route::get('/ventas', 'VentaController@getVentas')->name('ventas');
Route::post('/ventab', 'VentaController@postBuscarVenta')->name('ventab');
Route::post('/ventaActivar', 'VentaController@postVentaActiva')->name('ventaActivar');
Route::post('/ventas', 'VentaController@postVentas')->name('ventas');
Route::post('/ventadv', 'VentaController@postRegistrarDetalleVenta')->name('ventadv');
Route::post('/ventabdc', 'VentaController@postBuscarDetalleVenta')->name('ventabdc');
Route::post('/ventaCerrar', 'VentaController@postCerrarVenta')->name('ventaCerrar');
Route::post('/ventasEP', 'VentaController@postDetallePagoActiva')->name('ventasEP');
Route::post('/ventasRP', 'VentaController@postRegistrarPagoVenta')->name('ventasRP');
Route::post('/ventasPVC', 'VentaController@postCargaPreferenciasCredito')->name('ventasPVC');
Route::post('/ventasBCC', 'VentaCreditoController@postBuscarCliente')->name('ventasBCC');
Route::post('/ventasFin', 'VentaController@postFinalizarVenta')->name('ventasFin');
Route::post('/ventaDetallesActiva', 'VentaController@postventaDetallesActiva')->name('ventaDetallesActiva');
Route::post('/ventasPre', 'VentaController@postCargarPreventa')->name('ventasPre');

//Pantalla punto de venta
Route::any('/ptovta', 'PuntoVentaController@getPuntoVenta')->name('ptovta');
Route::get('/cajaDiaria', 'PuntoVentaController@getCajaDiaria')->name('cajaDiaria');
Route::get('/cajaDiariaResumen', 'PuntoVentaController@getCajaDiariaResumen')->name('cajaDiariaResumen');
Route::get('/cajaDiariaCierre', 'PuntoVentaController@getCajaDiariaCierre')->name('cajaDiariaCierre');
Route::post('/cajaDiariaCierre', 'PuntoVentaController@postCajaDiariaCierre')->name('cajaDiariaCierre');
Route::post('/cajaDiariaResumen', 'PuntoVentaController@postCajaDiariaResumen')->name('cajaDiariaResumen');
Route::post('/cajaDiariaDetalleFP', 'PuntoVentaController@postDetalleVentaFormaPago')->name('cajaDiariaDetalleFP');

Route::get('/cajaDiariaDetalle', 'PuntoVentaController@getCajaDiariaDetalle')->name('cajaDiariaDetalle');
Route::get('/cajaDiariaResumenVenta', 'PuntoVentaController@getCajaDiariaResumenVenta')->name('cajaDiariaResumenVenta');
Route::get('/cajaDiariaDetalleVenta', 'PuntoVentaController@getCajaDiariaDetalleVenta')->name('cajaDiariaDetalleVenta');
Route::post('/detalleVenta', 'PuntoVentaController@postDetalleVenta')->name('detalleVenta');

Route::post('/reciboPago', 'PuntoVentaController@postReciboPago')->name('reciboPago');

Route::post('/addPreVentaPV', 'PreventaController@postAddPreVentaPreVenta')->name('addPreVentaPV');
Route::post('/addProductPV', 'PreventaController@postAddProductPreVenta')->name('addProductPV');
Route::post('/asginarVen', 'PreventaController@postAsignarVendedor')->name('asginarVen');
Route::post('/asginarCli', 'PreventaController@postAsignarCliente')->name('asginarCli');
Route::post('/asginarDTE', 'PreventaController@postAsignarDTE')->name('asginarDTE');

Route::post('/infoCD', 'PuntoVentaController@postInfoCajaDiaria')->name('infoCD');

Route::post('/buscarCDC', 'PuntoVentaController@postBuscarClienteDetalleCredito')->name('buscarCDC');
Route::post('/pagarCuenta', 'PuntoVentaController@postPagarCuenta')->name('pagarCuenta');
Route::post('/PtoBuscarP', 'PuntoVentaController@postBuscarProductosC')->name('PtoBuscarP');

Route::get('/puntoVentaConfig', 'PuntoVentaController@getConfigPuntoVenta')->name('puntoVentaConfig');
Route::post('/puntoVentaConfig', 'PuntoVentaController@postConfigPuntoVenta')->name('puntoVentaConfig');

/* Formulario Venta -> Punto de Venta */
Route::post('/addProductV', 'VentaController@postAddProductVenta')->name('addProductV');
Route::post('/asignarVenVen', 'VentaController@postAsignarVendedor')->name('asignarVenVen');
Route::post('/asignarCliVen', 'VentaController@postAsignarCliente')->name('asignarCliVen');
Route::post('/asginarDTEVen', 'VentaController@postAsignarDTE')->name('asginarDTEVen');
Route::post('/ventaRP', 'VentaController@postRegistrarPagoPuntoVenta')->name('ventaRP');
Route::post('/ventaEP', 'VentaController@postDetallePagoActiva')->name('ventaEP');
Route::post('/ventaVCV', 'VentaController@postCerrarVenta')->name('ventaVCV');
Route::post('/addPreVentaV', 'VentaController@postAddPreVentaVenta')->name('addPreVentaV');

//CRUD Vendedores
Route::get('/vendedores', 'VendedorController@getvendedor')->name('vendedores');
Route::post('/vendedores', 'VendedorController@postvendedor')->name('vendedores');
Route::post('/activarVen', 'VendedorController@postVendedoractivo')->name('activarVen');
Route::post('/detallesVen', 'VendedorController@postVendedordetalle')->name('detallesVen');
Route::post('/buscarVen', 'VendedorController@postBuscarVen')->name('buscarVen');

/// Registro de Metas
Route::post('/metas', 'VendedorController@postMetas')->name('metas');
Route::post('/metasE', 'VendedorController@postMetaselimiar')->name('metasE');
Route::post('/metasD', 'VendedorController@postMetasdetalles')->name('metasD');

//CRUD Formas de Pago
Route::get('/FormaPago', 'FormaPagoController@getFormaPago')->name('FormaPago');
Route::post('/FormaPago', 'FormaPagoController@postFormaPago')->name('FormaPago');
Route::post('/FormaPagoAtc', 'FormaPagoController@postFormaPagoactivo')->name('FormaPagoAtc');
Route::post('/FormaPagoDet', 'FormaPagoController@postFormaPagodetalle')->name('FormaPagoDet');

// CRUD inventario
Route::get('/inventario', 'InventarioController@getInventario')->name('inventario');
Route::post('/inventario', 'InventarioController@postInventario')->name('inventario');
Route::post('/inventarioa', 'InventarioController@postInventarioactivo')->name('inventarioa');
Route::post('/inventariob', 'InventarioController@postBuscarInventario')->name('inventariob');
Route::post('/inventariobdc', 'InventarioController@postBuscarDetalleInventario')->name('inventariobdc');
Route::post('/inventariodc', 'InventarioController@postRegistrarDetalleInventario')->name('inventariodc');
Route::post('/inventariobpd', 'InventarioController@postbuscarProducto')->name('inventariobpd');
Route::post('/inventariobb', 'InventarioController@postbuscarBodega')->name('inventariobb');
Route::post('/inventariobf', 'InventarioController@postbuscarFamilia')->name('inventariobf');
Route::post('/inventarioci', 'InventarioController@postCerrarInventario')->name('inventarioci');
Route::post('/inventarioibb', 'InventarioController@postBuscarBodegaCombo')->name('inventarioibb');

Route::get('/transferenciaBodega', 'TransferenciaBodegaController@getTransferenciasActivas')->name('transferenciaBodega');
Route::post('/transferenciaBodega', 'TransferenciaBodegaController@getInventario')->name('transferenciaBodega');

Route::get('/transferenciaList', 'TransferenciaBodegaController@getTransferenciasActivas')->name('transferenciaList');
Route::post('/transferenciaView', 'TransferenciaBodegaController@getTransferenciaView')->name('transferenciaView');
Route::get('/transferenciaNew', 'TransferenciaBodegaController@getTransferenciasNew')->name('transferenciaNew');

Route::post('/boletaV', 'BoletaController@postBoletaVer')->name('boletaV');
Route::post('/boletaPDF', 'BoletaController@postBoletaPdf')->name('boletaPDF');

//CRUD Abono Cliente
Route::get('/AbonoCliente', 'AbonoClienteController@getAbonoCliente')->name('AbonoCliente');
Route::post('/AbonoCliente', 'AbonoClienteController@postAbonoCliente')->name('AbonoCliente');
Route::post('/AbonoClienteAtc', 'AbonoClienteController@postAbonoClienteactivo')->name('AbonoClienteAtc');
Route::post('/AbonoClienteDet', 'AbonoClienteController@postAbonoClientedetalle')->name('AbonoClienteDet');
Route::post('/AbonoClienteBC', 'AbonoClienteController@postBuscarCliente')->name('AbonoClienteBC');

Route::group(['namespace' => 'Auth', 'prefix' => 'admin'], function (){
	//accesos (Seleccionar acceso para ingresar a la aplicacion)
	Route::get('/accesos', 'UsuarioController@getAccesos')->name('accesos');
	Route::post('/accesos', 'UsuarioController@postAccesos')->name('accesos');
	//Mostrar Perfiles de los usuarios (Activar / Desactivar)
	Route::get('/perfiles', 'UsuarioController@getPerfiles')->name('perfiles');
	Route::post('/perfiles', 'UsuarioController@postPerfiles')->name('perfiles');
	// Registro de usuarios
	Route::get('/usuarios', 'UsuarioController@getUsuarios')->name('usuarios');
	Route::post('/usuarios', 'UsuarioController@postUsuarios')->name('usuarios');
	// Cambio de contraseña por el mismo usuario
	Route::get('/password', 'UsuarioController@getPassword')->name('password');
	Route::post('/password', 'UsuarioController@postPassword')->name('password');
	// Pantalla de perfil del usuario
	Route::get('/perfil', 'UsuarioController@getPerfil')->name('perfil');
	Route::post('/perfil', 'UsuarioController@postPerfil')->name('perfil');
	//Cargar y eliminar foto de perfil de usuario
	Route::post('/fotoc', 'UsuarioController@postCargarfoto')->name('fotoc');
	Route::post('/fotoe', 'UsuarioController@postEliminarfoto')->name('fotoe');
	// Recuperar y reiniciar contraseña
	Route::post('/recuperar', 'RecuperarController@postRecuperar')->name('recuperar');
	Route::post('/reiniciar', 'UsuarioController@postReiniciar')->name('reiniciar');
	// Activar o Desactivar usuario
	Route::post('/activar', 'UsuarioController@postUsuarioactivo')->name('activar');
	// Activar o Desactivar Perfil de usuario
	Route::post('/activarP', 'UsuarioController@postPerfilactivo')->name('activarP');
	// Desbloquear cuenta de usuario por maximo de intentos fallídos
	Route::post('/desbloquearC', 'UsuarioController@postDesbloquearcuenta')->name('desbloquearC');
	Route::post('/buscarLocales','UsuarioController@postLocalesDisponiblesUsuario')->name('buscarLocales');
	Route::post('/agregarLocalUsuario','UsuarioController@postAgregarLocalUsuario')->name('agregarLocalUsuario');
	Route::post('/agregarTodosLocalUsuario','UsuarioController@postAgregarTodosLocalUsuario')->name('agregarTodosLocalUsuario');
	Route::post('/eliminarLocalUsuario','UsuarioController@postEliminarLocalUsuario')->name('eliminarLocalUsuario');
	
	
	
Route::post('/buscarUsuario', 'UsuarioController@postBuscarUsuario')->name('buscarUsuario');

Route::get('contact', 'TransferenciaController@create')->name('contact.create');
Route::post('contact', 'TransferenciaController@store')->name('contact.store');

});


