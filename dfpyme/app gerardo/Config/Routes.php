<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

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
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Login::index');

$routes->group('salones', ['namespace' => 'App\Controllers\Salones', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->get('list', 'salonesController::index');
    $routes->get('salones', 'salonesController::salones'); //consulta de todos los salones creados 
    $routes->get('datos_iniciales', 'salonesController::datos_iniciales'); //consulta de todos los salones creados 
    $routes->post('mesas', 'salonesController::salon_mesas');
    $routes->post('save', 'salonesController::save');
    $routes->post('edit', 'salonesController::editar');
    $routes->post('update', 'salonesController::actualizar');
});

$routes->group('login', ['namespace' => 'App\Controllers\login'], function ($routes) {
    $routes->post('login', 'loginController::login');
    $routes->get('closeSesion', 'loginController::closeSesion');
});

$routes->get('home', 'Home::index');


$routes->group('home', ['Home::index', 'filter' => \App\Filters\Auth::class], function ($routes) {
});




$routes->group('usuarios', ['namespace' => 'App\Controllers\usuarios', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->get('list', 'usuariosController::index');
    $routes->post('edit', 'usuariosController::editar');
    $routes->post('update', 'usuariosController::actualizar');
    $routes->post('eliminar', 'usuariosController::eliminar');
    $routes->post('crear', 'usuariosController::crear');
});


$routes->group('mesas', ['namespace' => 'App\Controllers\Mesa', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->get('list', 'mesaController::index');
    $routes->get('add', 'mesaController::datos_iniciales');
    $routes->post('save', 'mesaController::save');
    $routes->post('pedido', 'mesaController::mesaPedido');
    $routes->post('editar', 'mesaController::editar');
    $routes->post('cambiar_de_mesa', 'mesaController::cambiar_de_mesa');
    $routes->post('actualizar', 'mesaController::actualizar');
    $routes->get('todas_las_mesas', 'mesaController::todas_las_mesas');
    $routes->post('intercambio_mesa', 'mesaController::intercambio_mesa');
});

$routes->group('producto', ['namespace' => 'App\Controllers\producto', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->post('pedido', 'productoController::productoPedido');
    $routes->post('pedido_pos', 'productoController::pedido_pos');
    $routes->post('agregar_producto_al_pedido', 'productoController::agregar_producto_al_pedido');
    $routes->post('insertar_productos_tabla_pedido', 'productoController::insertar_productos_tabla_pedido');
    $routes->post('buscar_productos_id_categoria', 'productoController::buscar_productos_id_categoria');
    $routes->post('agregar_productos_x_categoria', 'productoController::agregar_productos_x_categoria');
    $routes->post('productos_del_pedido_para_facturar', 'productoController::productos_del_pedido_para_facturar');
    $routes->post('detalle_pedido', 'productoController::detalle_pedido');
    $routes->post('editar_cantidades_de_pedido', 'productoController::editar_cantidades_de_pedido');
    $routes->post('buscar_por_codigo_de_barras', 'productoController::buscar_por_codigo_de_barras');
    $routes->post('cargar_producto_al_pedido', 'productoController::cargar_producto_al_pedido');
    $routes->post('entregar_producto', 'productoController::entregar_producto');
    $routes->post('actualizar_entregar_producto', 'productoController::actualizar_entregar_producto');
    $routes->post('usuario_pedido', 'productoController::usuario_pedido');
    $routes->post('agregar_observacion_general', 'productoController::agregar_observacion_general');
    $routes->post('facturar_pedido', 'productoController::facturar_pedido');
    $routes->post('insertar_producto_desde_categoria', 'productoController::insertar_producto_desde_categoria');
    $routes->post('actualizar_cantidades_de_pedido', 'productoController::actualizar_cantidades_de_pedido');
    $routes->post('eliminar_producto', 'productoController::eliminar_producto');
    $routes->post('eliminacion_de_producto', 'productoController::eliminacion_de_producto');
    $routes->post('cargar_item_al_pedido', 'productoController::cargar_item_al_pedido');
    $routes->post('editar_con_pin', 'productoController::editar_con_pin');
    $routes->post('eliminar_con_pin_pad', 'productoController::eliminar_con_pin_pad');
    $routes->post('editar_con_pin_pad', 'productoController::editar_con_pin_pad');
    $routes->post('crear', 'operacionesProductoController::crear');
    $routes->post('imagen', 'operacionesProductoController::imagen');
    $routes->post('lista_precios', 'operacionesProductoController::lista_precios');
    $routes->get('actualizar_factura_venta', 'productoController::actualizar_factura_venta');
    $routes->post('listado', 'productoController::index');
    $routes->post('get_codigo_interno', 'operacionesProductoController::get_codigo_interno');
    $routes->post('categorias', 'operacionesProductoController::categorias');
    $routes->post('marcas', 'operacionesProductoController::marcas');
    $routes->post('iva', 'operacionesProductoController::iva');
    $routes->post('ico', 'operacionesProductoController::ico');
    $routes->get('lista_de_productos', 'productoController::lista_de_productos');
    $routes->post('index', 'productoController::index');
    $routes->post('creacion_producto', 'operacionesProductoController::creacion_producto');
    $routes->post('editar_precios', 'operacionesProductoController::editar_precios');
    $routes->post('actualizar_precio_producto', 'operacionesProductoController::actualizar_precio_producto');
    $routes->post('eliminar_producto_inventario', 'operacionesProductoController::eliminar_producto_inventario');
    $routes->post('borrar_producto_inventario', 'operacionesProductoController::borrar_producto_inventario');
    $routes->post('eliminacion_de_pedido_desde_pedido', 'operacionesProductoController::eliminacion_de_pedido_desde_pedido');
    $routes->post('actualizacion_cantidades', 'productoController::actualizacion_cantidades');
    $routes->post('autorizacion_pin', 'operacionesProductoController::autorizacion_pin');
    $routes->post('eliminar_pedido_usuario', 'operacionesProductoController::eliminar_pedido_usuario');
});

$routes->group('impresora', ['namespace' => 'App\Controllers\impresora', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->get('listado', 'impresoraController::index');
    $routes->get('datos_iniciales', 'impresoraController::datos_iniciales');
    $routes->post('salvar', 'impresoraController::salvar');
    $routes->post('editar', 'impresoraController::editar');
    $routes->post('actualizar', 'impresoraController::actualizar');
    $routes->get('administracion', 'impresoraController::administracion');
});

$routes->group('categoria', ['namespace' => 'App\Controllers\categoria', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->get('index', 'categoriaController::index');
    $routes->get('crear', 'categoriaController::crear');
    $routes->post('actualizar', 'categoriaController::actualizar');
    $routes->post('guardar', 'categoriaController::guardar');
    $routes->post('actualizar_estado_categoria', 'categoriaController::actualizar_estado_categoria');
    $routes->post('actualizar_impresora', 'categoriaController::actualizar_impresora');
    $routes->post('actualizar_nombre', 'categoriaController::actualizar_nombre');
    $routes->get('marcas', 'categoriaController::get_todas_las_marcas_producto');
    $routes->post('crear_marcas', 'categoriaController::crear_marcas');
    $routes->post('editar_marca', 'categoriaController::editar_marca');
    $routes->post('actualizar_marca', 'categoriaController::actualizar_marca');
});

$routes->group('pedido', ['namespace' => 'App\Controllers\pedido', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->get('pedidos_para_facturar', 'pedidoController::index');
    $routes->get('pedidos_para_facturacion', 'pedidoController::pedidos_para_facturacion');
    $routes->post('eliminacion_de_pedido', 'pedidoController::eliminacion_de_pedido');
    $routes->post('agregar_nota_al_pedido', 'pedidoController::agregar_nota_al_pedido');
    $routes->post('facturar_pedido', 'pedidoController::facturar_pedido');
    $routes->post('cerrar_venta', 'pedidoController::cerrar_venta');
    $routes->post('nota_de_pedido', 'pedidoController::nota_de_pedido');
    $routes->post('valor_pedido', 'pedidoController::valor_pedido');
    $routes->post('total_pedido', 'pedidoController::total_pedido');
    $routes->post('forma_pago', 'pedidoController::forma_pago');
    $routes->post('facturar_credito', 'pedidoController::facturar_credito');
    $routes->post('borrar_pedido', 'pedidoController::borrar_pedido');
    $routes->post('actualizar_cantidades', 'pedidoController::actualizar_cantidades');
    $routes->post('eliminar_cantidades', 'pedidoController::eliminar_cantidades');
    $routes->post('pedido', 'pedidoController::pedido');
});

$routes->group('factura_pos', ['namespace' => 'App\Controllers\factura_pos', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->post('factura_pos', 'facturacionConImpuestosController::factura_pos');
    $routes->get('factura_pos', 'facturacionConImpuestosController::factura_pos');
    $routes->post('facturacion_pos', 'facturacionConImpuestosController::facturacion_pos');
    $routes->get('pedidos_para_facturacion', 'pedidoController::pedidos_para_facturacion');
    $routes->get('cerrar_venta', 'facturacionConImpuestosController::cerrar_venta');
    $routes->post('imprimir_factura', 'facturacionConImpuestosController::imprimir_factura');
    $routes->post('imprimir_factura_desde_pedido', 'facturacionConImpuestosController::imprimir_factura_desde_pedido');
    $routes->post('municipios', 'facturacionConImpuestosController::municipios');
    $routes->post('imprimir_factura_sin_impuestos', 'facturacionSinImpuestosController::imprimir_factura');
    $routes->post('imprimir_factura_sin_impuestos_directa', 'facturacionSinImpuestosController::imprimir_factura_directa');
    $routes->post('imprimir_factura_partir_factura', 'facturacionSinImpuestosController::imprimir_factura_partir_factura');
    $routes->post('cerrar_venta_partir_factura', 'facturacionSinImpuestosController::cerrar_venta_partir_factura');
    $routes->post('reset_factura', 'facturacionSinImpuestosController::reset_factura');
    $routes->get('modulo_facturacion', 'facturacionConImpuestosController::modulo_facturacion');
});

$routes->group('comanda', ['namespace' => 'App\Controllers\comanda', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->post('imprimir_comanda', 'imprimirComandaController::imprimir_comanda');
    $routes->post('imprimir_comanda_desde_pedido', 'imprimirComandaController::imprimir_comanda_desde_pedido');
    $routes->post('re_imprimir_comanda', 'imprimirComandaController::re_imprimir_comanda');
    $routes->post('directa', 'imprimirComandaController::directa');
});

$routes->group('clientes', ['namespace' => 'App\Controllers\cliente', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->post('listado', 'clienteController::index');
    $routes->post('agregar', 'clienteController::agregar');
    $routes->post('clientes_autocompletado', 'clienteController::clientes_autocompletado');
    $routes->get('todos_los_clientes', 'clienteController::todos_los_clientes');
    $routes->get('tabla_todos_los_clientes', 'clienteController::tabla_todos_los_clientes');
    $routes->post('nuevo_cliente', 'clienteController::nuevo_cliente');
    $routes->post('editar_cliente', 'clienteController::editar_cliente');
    $routes->post('actualizar_datos_cliente', 'clienteController::actualizar_datos_cliente');
});

$routes->group('pre_factura', ['namespace' => 'App\Controllers\pre_factura', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->post('imprimir', 'prefacturaController::imprimir');
    $routes->post('imprimir_prefactura', 'prefacturaController::imprimir_prefactura');
    $routes->post('imprimir_desde_pedido', 'prefacturaController::imprimir_desde_pedido');
    $routes->get('impresora', 'prefacturaController::impresora');
    $routes->post('asignar_impresora', 'prefacturaController::asignar_impresora');
});

$routes->group('clientes', ['namespace' => 'App\Controllers\clientes', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->post('list', 'clienteController::index');
    $routes->get('add', 'clientesController::agregar_cliente');
});

$routes->group('factura_electronica', ['namespace' => 'App\Controllers\factura_electronica', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->post('pre_factura', 'FacturaElectronica::pre_factura');
});


$routes->group('factura_directa', ['namespace' => 'App\Controllers\factura_pos', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->post('facturacion', 'facturaDirectaController::facturacion');
    $routes->post('imprimir_comanda', 'imprimirComandaController::imprimir_comanda');
    $routes->post('eliminar_producto', 'facturaDirectaController::eliminar_producto');
    $routes->post('eliminacion_de_producto', 'facturaDirectaController::eliminacion_de_producto');
    $routes->get('factura_pos', 'facturaDirectaController::factura_pos');
    $routes->post('comanda_directa', 'facturaDirectaController::comanda_directa');
});

$routes->group('administracion_impresora', ['namespace' => 'App\Controllers\administracion_impresora', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->post('apertutraCajonMonedero', 'aperturaCajonMonederoController::apertutra_cajon_monedero');
    $routes->get('cajon_monedero', 'aperturaCajonMonederoController::cajon_monedero');
    $routes->get('impresion_factura', 'impresionFacturaController::impresion_factura');
    $routes->post('asignar_impresora_facturacion', 'impresionFacturaController::asignar_impresora_facturacion');
    $routes->get('configuracion_pedido', 'impresionFacturaController::configuracion_pedido');
    $routes->post('actualizar_configuracion_pedido', 'impresionFacturaController::actualizar_configuracion_pedido');
});


$routes->group('edicion_eliminacion_factura_pedido', ['namespace' => 'App\Controllers\pedido', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->post('edicion', 'edicionEliminacionFacturaPedidoController::edicion');
    $routes->post('edicion_pos', 'edicionEliminacionFacturaPedidoController::edicion_pos');
    $routes->post('actualizar_producto_pedido', 'edicionEliminacionFacturaPedidoController::actualizar_producto_pedido');
    $routes->post('actualizar_producto_pos', 'edicionEliminacionFacturaPedidoController::actualizar_producto_pos');
    $routes->post('actualizar_precio_pedido', 'edicionEliminacionFacturaPedidoController::actualizar_precio_pedido');
    $routes->post('eliminar_producto_pedido', 'edicionEliminacionFacturaPedidoController::eliminar_producto_pedido');
    $routes->post('borrar_producto', 'edicionEliminacionFacturaPedidoController::borrar_producto');
    $routes->post('actualizar_registro_factura_directa', 'edicionEliminacionFacturaPedidoController::actualizar_registro_factura_directa');
});


$routes->group('partir_factura', ['namespace' => 'App\Controllers\pedido', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->post('partir_factura', 'partirFacturaController::partir_factura');
    $routes->post('consultar_total', 'partirFacturaController::consultar_total');
    $routes->post('facturar', 'partirFacturaController::facturar');
    $routes->post('cancelar_partir_factura', 'partirFacturaController::cancelar_partir_factura');
    $routes->post('actualizar_cantidad_tabla_partir_factura', 'partirFacturaController::actualizar_cantidad_tabla_partir_factura');
});

$routes->group('consultas_y_reportes', ['namespace' => 'App\Controllers\consultas_y_reportes', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->get('informe_fiscal_de_ventas', 'informeFiscalVentasController::informe_fiscal_ventas');
    $routes->get('duplicado_factura', 'duplicadoFacturaController::duplicado_factura');
    $routes->post('informe_fiscal_de_ventas_datos', 'informeFiscalVentasController::informe_fiscal_ventas_datos');
    $routes->post('facturas_por_rango_de_fechas', 'duplicadoFacturaController::facturas_por_rango_de_fechas');
    $routes->post('detalle_factura', 'duplicadoFacturaController::detalle_factura');
    $routes->post('imprimir_duplicado_factura', 'duplicadoFacturaController::imprimir_duplicado_factura');
    $routes->get('informe_fiscal_ventas_pdf', 'informeFiscalVentasController::informe_fiscal_ventas_pdf');
    $routes->get('generar_informe_fiscal_ventas_pdf', 'informeFiscalVentasController::generar_informe_fiscal_ventas_pdf');
    $routes->get('reporte_caja_diaria', 'cajaDiariaController::reporte_caja_diaria');
    $routes->get('index', 'reporteDeVentasController::index');
    $routes->get('producto', 'reporteDeVentasController::producto');
    $routes->post('informe_caja', 'cajaDiariaController::informe_caja');
    $routes->post('reporte_caja_diaria_datos', 'cajaDiariaController::reporte_caja_diaria_datos');
    $routes->post('reporte_caja_diaria_datos_ico', 'cajaDiariaController::reporte_caja_diaria_datos_ico');
    $routes->post('guardar_reporte_caja_diaria', 'cajaDiariaController::guardar_reporte_caja_diaria');
    $routes->post('solo_guardar_reporte_caja_diaria', 'cajaDiariaController::solo_guardar_reporte_caja_diaria');
    $routes->get('imprimir_reporte_de_caja_id', 'cajaDiariaController::imprimir_reporte_de_caja_id');
    $routes->post('imprimir_reporte_caja_diaria', 'cajaDiariaController::imprimir_reporte_caja_diaria');
    $routes->get('consulta_de_ventas', 'reporteDeVentasController::consulta_de_ventas');
    $routes->get('consultas_caja', 'reporteDeVentasController::consultas_caja');
    $routes->post('consultas_caja_por_fecha', 'reporteDeVentasController::consultas_caja_por_fecha');
    $routes->post('datos_consultas_caja_por_fecha', 'reporteDeVentasController::datos_consultas_caja_por_fecha');
    $routes->post('detalle_de_ventas', 'reporteDeVentasController::detalle_de_ventas');
    $routes->post('detalle_de_ventas_sin_cierre', 'reporteDeVentasController::detalle_de_ventas_sin_cierre');
    $routes->post('datos_consultar_producto', 'reporteDeVentasController::datos_consultar_producto');
    $routes->post('tabla_consultar_producto', 'reporteDeVentasController::tabla_consultar_producto');
    $routes->get('producto_agrupados', 'reporteDeVentasController::producto_agrupados');
    $routes->post('consultar_producto_agrupado', 'reporteDeVentasController::consultar_producto_agrupado');
    $routes->post('datos_consultar_producto_agrupado', 'reporteDeVentasController::datos_consultar_producto_agrupado');
    $routes->post('valor_apertura', 'reporteDeVentasController::valor_apertura');
    $routes->post('actualizar_efectivo_usuario', 'reporteDeVentasController::actualizar_efectivo_usuario');
    $routes->post('actualizar_transaccion_usuario', 'reporteDeVentasController::actualizar_transaccion_usuario');
    $routes->get('datos_consultar_producto_agrupado_pdf', 'reporteDeVentasController::datos_consultar_producto_agrupado_pdf');
    $routes->get('reporte_caja_diario', 'reporteDeVentasController::reporte_caja_diario');
    $routes->post('imprimir_reporte_fiscal', 'reporteDeVentasController::imprimir_reporte_fiscal');
    $routes->post('saldo_factura', 'AbonosController::saldo_factura');
    $routes->post('actualizar_saldo', 'AbonosController::actualizar_saldo');
    $routes->post('imprimir_ingreso', 'AbonosController::imprimir_ingreso');
    $routes->get('reporte_flujo_efectivo', 'FlujoEfectivoController::reporte_flujo_efectivo');
    $routes->post('datos_reporte_flujo_efectivo', 'FlujoEfectivoController::datos_reporte_flujo_efectivo');
    $routes->post('excel_reporte_flujo_efectivo', 'FlujoEfectivoController::excel_reporte_flujo_efectivo');
    $routes->post('pdf_reporte_producto', 'reporteDeVentasController::pdf_reporte_producto');
    $routes->post('editar_valor_apertura', 'cajaDiariaController::editar_valor_apertura');
    $routes->post('cambiar_valor_apertura', 'cajaDiariaController::cambiar_valor_apertura');
    $routes->post('total_ingresos_efectivo', 'cajaDiariaController::total_ingresos_efectivo');
    $routes->post('total_ingresos_transaccion', 'cajaDiariaController::total_ingresos_transaccion');
    $routes->post('retiros', 'cajaDiariaController::retiros');
    $routes->post('movimientos_de_caja', 'cajaDiariaController::movimientos_de_caja');
    $routes->post('detalle_movimiento_de_caja', 'cajaDiariaController::detalle_movimiento_de_caja');
    $routes->post('reporte_de_ventas', 'cajaDiariaController::reporte_de_ventas');
    $routes->post('detalle_retiros', 'cajaDiariaController::detalle_retiros');
    $routes->post('editar_valor_cierre', 'cajaDiariaController::editar_valor_cierre');
    $routes->post('actualizar_valor_cierre', 'cajaDiariaController::actualizar_valor_cierre');
    $routes->post('editar_valor_cierre_transferencias', 'cajaDiariaController::editar_valor_cierre_transferencias');
    $routes->post('actualizar_valor_cierre_transferencias', 'cajaDiariaController::actualizar_valor_cierre_transferencias');
    $routes->get('buscar_pedidos_borrados', 'cajaDiariaController::buscar_pedidos_borrados');
    $routes->post('pedidos_borrados', 'cajaDiariaController::pedidos_borrados');
    $routes->post('pedidos_borrados', 'cajaDiariaController::pedidos_borrados');
    $routes->get('informe_fiscal_desde_caja', 'cajaDiariaController::informe_fiscal_desde_caja');
    $routes->post('expotar_informe_ventas_pdf', 'informeFiscalVentasController::expotar_informe_ventas_pdf');
    $routes->post('fiscal_manual_pdf', 'informeFiscalVentasController::fiscal_manual_pdf');
    $routes->get('documento', 'Documento::documento');
    $routes->get('tipo_documento', 'Documento::tipo_documento');
    $routes->get('cliente', 'Documento::cliente');
    $routes->post('cartera_cliente', 'Documento::cartera_cliente');
    $routes->post('pagar_cartera_cliente', 'Documento::pagar_cartera_cliente');
    $routes->post('imprimir_comprobante_ingreso', 'Documento::imprimir_comprobante_ingreso');
    $routes->get('consulta_cartera', 'Documento::consulta_cartera');
    $routes->post('datos_consulta_cartera', 'Documento::datos_consulta_cartera');
    $routes->get('por_defecto', 'Documento::por_defecto');
    $routes->post('consultar_por_documento', 'Documento::consultar_por_documento');
    $routes->post('consultar_por_cliente', 'Documento::consultar_por_cliente');
    $routes->post('consulta_de_cartera', 'Documento::consulta_de_cartera');
    $routes->post('aperturas', 'Documento::aperturas');
});

$routes->group('devolucion', ['namespace' => 'App\Controllers\devolucion', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->post('guardar_devolucion', 'devolucionController::guardar_devolucion');
    $routes->post('retiro', 'devolucionController::retiro');
    $routes->post('imprimir_retiro', 'devolucionController::imprimir_retiro');
    $routes->post('re_imprimir_retiro', 'devolucionController::re_imprimir_retiro');
    $routes->post('no_imprimir_retiro', 'devolucionController::no_imprimir_retiro');
    $routes->post('edicion_retiro_de_dinero', 'devolucionController::edicion_retiro_de_dinero');
    $routes->post('actualizar_retiro_de_dinero', 'devolucionController::actualizar_retiro_de_dinero');
    $routes->get('crear_cuenta', 'RetiroController::crear_cuenta');
    $routes->post('agregar_cuenta', 'RetiroController::agregar_cuenta');
    $routes->get('listado', 'RetiroController::listado');
    $routes->get('rubros_listado', 'RetiroController::rubros_listado');
    $routes->get('crear_rubro', 'RetiroController::crear_rubro');
    $routes->post('agregar_rubro', 'RetiroController::agregar_rubro');
    $routes->post('cuenta_rubro', 'RetiroController::cuenta_rubro');
    $routes->post('editar_rubro', 'RetiroController::editar_rubro');
    $routes->post('actualizar_rubro', 'RetiroController::actualizar_rubro');
});
$routes->group('caja', ['namespace' => 'App\Controllers\caja', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->get('apertura', 'cajaController::apertura');
    $routes->get('lista_precios', 'cajaController::lista_precios');
    $routes->post('listado_precios', 'cajaController::listado_precios');
    $routes->post('generar_apertura', 'cajaController::generar_apertura');
    $routes->get('cierre', 'cajaController::cierre');
    $routes->post('generar_cierre', 'cajaController::generar_cierre');
    $routes->post('imprimir_cierre', 'cajaController::imprimir_cierre');
    $routes->post('imprimir_movimiento_caja', 'cajaController::imprimir_movimiento_caja');
    $routes->post('actualizar_lista_precios', 'cajaController::actualizar_lista_precios');
    $routes->post('imprimir_movimiento_caja_sin_cierre', 'cajaController::imprimir_movimiento_caja_sin_cierre');
    $routes->post('actualizar_apertura_caja_sin_cierre', 'cajaController::actualizar_apertura_caja_sin_cierre');
    $routes->post('exportar_a_excel_reporte_categorias', 'cajaController::exportar_a_excel_reporte_categorias');
    $routes->post('imp_movimiento_caja', 'cajaController::imp_movimiento_caja');
});

$routes->group('empresa', ['namespace' => 'App\Controllers\empresa', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->get('datos', 'EmpresaController::datos');
    $routes->post('actualizar_datos', 'EmpresaController::actualizar_datos');
    $routes->get('resolucion_facturacion', 'EmpresaController::resolucion_facturacion');
    $routes->get('consecutivos', 'EmpresaController::consecutivos');
    $routes->post('guardar_resolucion_facturacion', 'EmpresaController::guardar_resolucion_facturacion');
    $routes->post('actualizar_consecutivos', 'EmpresaController::actualizar_consecutivos');
    $routes->post('municipios', 'EmpresaController::municipios');
    $routes->post('actualizar_nombre_cuenta', 'EmpresaController::actualizar_nombre_cuenta');
    $routes->post('datos_resolucion_facturacion', 'EmpresaController::datos_resolucion_facturacion');
    $routes->post('actualizar_resolucion_facturacion', 'EmpresaController::actualizar_resolucion_facturacion');
    $routes->post('activacion_resolucion_facturacion', 'EmpresaController::activacion_resolucion_facturacion');
    $routes->post('activar_resolucion_dian', 'EmpresaController::activar_resolucion_dian');
    $routes->get('comprobante_transaccion', 'EmpresaController::comprobante_transaccion');
    $routes->post('configuracion_impresion', 'EmpresaController::configuracion_impresion');
});

$routes->group('caja_general', ['namespace' => 'App\Controllers\caja_general', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->get('apertura_general', 'cajaGeneralController::apertura');
    $routes->get('cierre_general', 'cajaGeneralController::cierre');
    $routes->post('generar_apertura', 'cajaGeneralController::generar_apertura');
    $routes->post('generar_cierre', 'cajaGeneralController::generar_cierre');
    $routes->get('consulta_general', 'cajaGeneralController::consulta_general');
    $routes->post('total_ingresos', 'cajaGeneralController::total_ingresos');
    $routes->post('imprimir_movimiento_caja_general', 'cajaGeneralController::imprimir_movimiento_caja_general');
    $routes->post('ver_retiros', 'cajaGeneralController::ver_retiros');
    $routes->post('editar_apertura', 'cajaGeneralController::editar_apertura');
    $routes->post('actualizar_valor_apertura', 'cajaGeneralController::actualizar_valor_apertura');
    $routes->post('actualizar_valor_cierre', 'cajaGeneralController::actualizar_valor_cierre');
    $routes->post('validar_cierre', 'cajaGeneralController::validar_cierre');
    $routes->get('todos_los_cierres_caja_general', 'cajaGeneralController::todos_los_cierres_caja_general');
    $routes->post('consultar_movimiento', 'cajaGeneralController::consultar_movimiento');
});

/**
 * Rutas para la tomas de pedido mejorados 
 */

$routes->group('pedidos', ['namespace' => 'App\Controllers\pedidos', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->get('mesas', 'Mesas::index');
    $routes->post('productos_categoria', 'Mesas::productos_categoria');
    $routes->post('agregar_producto', 'Mesas::agregar_producto');
    $routes->post('imprimirComanda', 'Imprimir::imprimirComanda');
    $routes->post('pedido', 'Mesas::pedido');
    $routes->post('prefactura', 'Imprimir::imprimir_prefactura');
    $routes->post('nota', 'Mesas::nota');
    $routes->get('tiempo_real', 'Mesas::get_mesas_tiempo_real');
    $routes->post('mesas_salon', 'Mesas::mesas_salon');
    $routes->post('get_mesas', 'Mesas::get_mesas');
    $routes->post('agregar_nota', 'Mesas::agregar_nota');
    $routes->post('consultar_nota', 'Mesas::consultar_nota');
    $routes->post('eliminar_producto', 'Mesas::eliminar_producto');
    $routes->post('actualizar_cantidades', 'Mesas::actualizar_cantidades');
    $routes->post('eliminacion_de_pedido', 'Mesas::eliminacion_de_pedido');
    $routes->post('restar_producto', 'Mesas::restar_producto');
    $routes->post('productos_pedido', 'Mesas::productos_pedido');
    $routes->post('partir_factura', 'PartirFactura::partir_factura');
    $routes->post('valor', 'PartirFactura::valor');
    $routes->post('cerrar_venta', 'CerrarVenta::cerrar_venta');
    $routes->post('imprimir_factura', 'Imprimir::imprimir_factura');
    $routes->post('actualizar_cantidad_pago_parcial', 'PartirFactura::actualizar_cantidad_pago_parcial');
    $routes->post('restar_partir_factura', 'PartirFactura::restar_partir_factura');
    $routes->post('cancelar_pago_parcial', 'PartirFactura::cancelar_pago_parcial');
    $routes->post('valor_pago_parcial', 'PartirFactura::valor_pago_parcial');
});

$routes->group('inventario', ['namespace' => 'App\Controllers\pedidos', 'filter' => \App\Filters\Auth::class], function ($routes) {
    $routes->get('ingreso', 'Inventarios::ingreso');
    $routes->post('ingreso_inventario', 'Inventarios::ingreso_inventario');
  

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
