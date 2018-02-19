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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

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
Route::post('/familias', 'FamiliaController@postFamilia')->name('familias');
Route::post('/activarF', 'FamiliaController@postFamiliactivo')->name('activarF');
Route::post('/familiab', 'FamiliaController@postBuscarfamilia')->name('familiab');

//CRUD SubFamilia
Route::get('/subfamilias', 'SubfamiliaController@getSubamilia')->name('subfamilias');
Route::post('/subfamilias', 'SubfamiliaController@postSubfamilia')->name('subfamilias');
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

//CRUD Proveedores
Route::get('/proveedores', 'ProveedorController@getProveedor')->name('proveedores');
Route::post('/proveedores', 'ProveedorController@postProveedor')->name('proveedores');
Route::post('/activarPro', 'ProveedorController@postProveedoractivo')->name('activarPro');
Route::post('/detallesP', 'ProveedorController@postProveedordetalle')->name('detallesP');

//CRUD Clientes
Route::get('/clientes', 'ClienteController@getCliente')->name('clientes');

//CRUD Creédito
Route::get('/credito', 'CreditoController@getCreditoPreferencias')->name('credito');
Route::get('/ventaCredito', 'VentaCreditoController@getVentaCredito')->name('ventaCredito');
Route::get('/cicloFacturacion', 'CicloFacturacionController@getCicloFacturacionl')->name('cicloFacturacion');


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
});


