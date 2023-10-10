<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Login::index');
$routes->get('/home', 'Home::index', ['filter' => \App\Filters\Auth::class]);

$routes->group('rutas', ['namespace' => 'App\Controllers\rutas', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->get('index', 'Rutas::index');
    $routes->post('crearRuta', 'Rutas::crearRuta');
    $routes->post('getRutas', 'Rutas::getRutas');
});

$routes->group('usuarios', ['namespace' => 'App\Controllers\usuarios'], function ($routes) {
    $routes->get('index', 'Usuario::index', ['filter' => \App\Filters\Auth::class]);
    $routes->post('crearUsuario', 'Usuario::crearUsuario', ['filter' => \App\Filters\Auth::class]);
    $routes->post('login', 'Usuario::login');
    $routes->post('getUsuarios', 'Usuario::getUsuarios', ['filter' => \App\Filters\Auth::class]);
    $routes->post('cambiar_clave', 'Usuario::cambiar_clave', ['filter' => \App\Filters\Auth::class]);
});

$routes->group('calendario', ['namespace' => 'App\Controllers\fechas', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->get('dias_no_cobro', 'Fechas::Mostrar_dias_cobrables');
});

$routes->group('autocompletar', ['namespace' => 'App\Controllers\autocompletar', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->post('identificacion', 'IdentificacionTercero::index');
    $routes->post('cliente', 'Cliente::index');   //Busqueda de autocompletado de cliente 
});
$routes->group('terceros', ['namespace' => 'App\Controllers\terceros', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->get('index', 'Terceros::index');
    $routes->post('cargar_modal', 'Terceros::cargar_modal');
    $routes->post('get_terceros', 'Terceros::getTerceros');
    $routes->post('crear_terceros', 'Terceros::crearTerceros');
});


$routes->group('clientes', ['namespace' => 'App\Controllers\clientes', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->post('index', 'Clientes::index');
    $routes->post('crear_cliente', 'Clientes::crear_cliente');
    $routes->post('fotos', 'Clientes::fotos');
});

$routes->group('identificaciones', ['namespace' => 'App\Controllers\identificaciones', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->post('get_todos', 'Identificaciones::get_todos');
});

$routes->group('clientes', ['namespace' => 'App\Controllers\clientes', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->get('index', 'Clientes::index');
    $routes->post('getClientes', 'Clientes::getClientes');
    $routes->post('get_clientes', 'Clientes::get_clientes');
    $routes->post('detalle', 'Clientes::detalle');
});

$routes->group('cobrador', ['namespace' => 'App\Controllers\cobrador', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->get('apertura', 'Cobrador::apertura');
    
});

$routes->group('prestamos', ['namespace' => 'App\Controllers\prestamos', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->get('index', 'Prestamos::index');
    $routes->post('get_del_dia', 'Prestamos::get_del_dia');
    $routes->get('listar', 'Prestamos::listar');
    $routes->post('getTodos', 'Prestamos::getTodos');
    $routes->post('abrirModal', 'Prestamos::abrirModal');
    $routes->post('generarPrestamo', 'Prestamos::generar_prestamo');
    $routes->post('cuotasPrestamo', 'Prestamos::cuotas_prestamo');
    $routes->post('get_prestamos_usuario', 'Prestamos::get_prestamos_usuario');
    $routes->post('abonar', 'Prestamos::abonar');
    $routes->post('pagar', 'Prestamos::pagar');
    $routes->post('detalle', 'Prestamos::detalle');
});

$routes->group('ingresos', ['namespace' => 'App\Controllers\ingresos', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->post('crear', 'Ingresos::set_ingreso');
    $routes->post('gastos', 'Ingresos::set_egresos');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
