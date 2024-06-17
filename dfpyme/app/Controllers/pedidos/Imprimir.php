<?php

namespace App\Controllers\pedidos;

use App\Controllers\BaseController;

require APPPATH . "Controllers/mike42/autoload.php";

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use App\Libraries\impresion;



class Imprimir extends BaseController
{
    public function index()
    {
        return view('home/home');
    }


    function imprimirComanda()
    {

        //$id_mesa = 1;
        $id_mesa = $this->request->getPost('id_mesa');
        $id_usuario = $this->request->getPost('id_usuario');

        //$id_usuario = 3;

        $tipo_usuario = model('usuariosModel')->select('idtipo')->where('idusuario_sistema', $id_usuario)->first();
        $pedido = model('pedidoModel')->select('id')->where('fk_mesa', $id_mesa)->first();
        $nombre_mesa = model('mesasModel')->select('nombre')->where('id', $id_mesa)->first();

        $configuracion_comanda = model('configuracionPedidoModel')->select('partir_comanda')->first();


        $productos = array();

        if (!empty($pedido)) {
            $codigo_categoria = model('productoPedidoModel')->id_categoria($pedido['id']);

            $productos_pedido = $items = model('productoPedidoModel')->productos_pedido($pedido['id']);

            if (!empty($productos_pedido)) {

                if ($configuracion_comanda['partir_comanda'] == 't') {
                    foreach ($codigo_categoria as $valor) {

                        $items = model('productoPedidoModel')->productos_pedido_comanda($pedido['id'], $valor['codigo_categoria']);
                        //$items = model('tempProductoPedidoModel')->productos_pedido($pedido['id'], $valor['codigo_categoria']);



                        if (!empty($items)) {
                            foreach ($items as $detalle) {
                                $data['id'] = $detalle['id'];
                                $data['nombreproducto'] = $detalle['nombreproducto'];
                                $data['valor_venta'] = $detalle['valorventaproducto'];
                                $data['valor_total'] = $detalle['valor_total'];
                                $data['cantidad'] = $detalle['cantidad_producto'];
                                $data['nota_producto'] = $detalle['nota_producto'];
                                $data['valor_unitario'] = $detalle['valor_unitario'];
                                $data['codigo_interno'] = $detalle['codigointernoproducto'];
                                $data['impresos'] = $detalle['numero_productos_impresos_en_comanda'];
                                array_push($productos, $data);
                            }
                            //$this->generar_comanda($productos, $pedido['id'], $nombre_mesa['nombre'], $codigo_categoria[0]['codigo_categoria']);
                            $this->generar_comanda($productos, $pedido['id'], $nombre_mesa['nombre'], $valor['codigo_categoria']);
                            $productos = array();
                        }
                    }
                }
                if ($configuracion_comanda['partir_comanda'] == 'f') {

                    $items = model('productoPedidoModel')->productos_pedido_comanda_todos($pedido['id']);
                    //$items = model('tempProductoPedidoModel')->productos_pedido($pedido['id'], $valor['codigo_categoria']);

                    if (!empty($items)) {
                        foreach ($items as $detalle) {
                            $data['id'] = $detalle['id'];
                            $data['nombreproducto'] = $detalle['nombreproducto'];
                            $data['valor_venta'] = $detalle['valorventaproducto'];
                            $data['valor_total'] = $detalle['valor_total'];
                            $data['cantidad'] = $detalle['cantidad_producto'];
                            $data['nota_producto'] = $detalle['nota_producto'];
                            $data['valor_unitario'] = $detalle['valor_unitario'];
                            $data['codigo_interno'] = $detalle['codigointernoproducto'];
                            $data['impresos'] = $detalle['numero_productos_impresos_en_comanda'];
                            array_push($productos, $data);
                        }
                        //$this->generar_comanda($productos, $pedido['id'], $nombre_mesa['nombre'], $codigo_categoria[0]['codigo_categoria']);
                        $this->generar_comanda($productos, $pedido['id'], $nombre_mesa['nombre'],'1');
                        $productos = array();
                    }

                }
                $returnData = array(
                    "resultado" => 1
                );
                echo  json_encode($returnData);
            }

            if (empty($productos_pedido)) {

                if ($tipo_usuario['idtipo'] == 1 || $tipo_usuario['idtipo'] == 0) {

                    if ($configuracion_comanda['partir_comanda'] == 't') {
                        foreach ($codigo_categoria as $valor) {


                            $items = model('productoPedidoModel')->reimprimir_comanda($pedido['id'], $valor['codigo_categoria']);

                            foreach ($items as $detalle) {
                                $data['id'] = $detalle['id'];
                                $data['nombreproducto'] = $detalle['nombreproducto'];
                                $data['valor_venta'] = $detalle['valorventaproducto'];
                                $data['valor_total'] = $detalle['valor_total'];
                                $data['cantidad'] = $detalle['cantidad_producto'];
                                $data['nota_producto'] = $detalle['nota_producto'];
                                $data['valor_unitario'] = $detalle['valor_unitario'];
                                $data['codigo_interno'] = $detalle['codigointernoproducto'];
                                $data['impresos'] = $detalle['numero_productos_impresos_en_comanda'];
                                array_push($productos, $data);
                            }
                            $this->generar_comanda($productos, $pedido['id'], $nombre_mesa['nombre'], $valor['codigo_categoria']);
                            $productos = array();
                        }
                    }
                    if ($configuracion_comanda['partir_comanda'] == 'f') {

                        $items = model('productoPedidoModel')->reimprimir_comanda_todo($pedido['id']);

                        foreach ($items as $detalle) {
                            $data['id'] = $detalle['id'];
                            $data['nombreproducto'] = $detalle['nombreproducto'];
                            $data['valor_venta'] = $detalle['valorventaproducto'];
                            $data['valor_total'] = $detalle['valor_total'];
                            $data['cantidad'] = $detalle['cantidad_producto'];
                            $data['nota_producto'] = $detalle['nota_producto'];
                            $data['valor_unitario'] = $detalle['valor_unitario'];
                            $data['codigo_interno'] = $detalle['codigointernoproducto'];
                            $data['impresos'] = $detalle['numero_productos_impresos_en_comanda'];
                            array_push($productos, $data);
                        }
                        $this->generar_comanda($productos, $pedido['id'], $nombre_mesa['nombre'], '1');
                        $productos = array();
                    }
                    $returnData = array(
                        "resultado" => 1
                    );
                    echo  json_encode($returnData);
                } else if ($tipo_usuario['idtipo'] == 2) {
                    $returnData = array(
                        "resultado" => 0
                    );
                    echo  json_encode($returnData);
                }
            }


            /*  if (!empty($items)) {
                $returnData = array(
                    "resultado" => 1
                );
                echo  json_encode($returnData);
            } */
        }
    }


    function generar_comanda($productos, $numero_pedido, $nombre_mesa, $codigo_categoria)

    {

        $nombre_categoria = model('categoriasModel')->select('nombrecategoria')->where('codigocategoria', $codigo_categoria)->first();

        // $impresora = model('categoriasModel')->select('impresora')->where('codigocategoria', $codigo_categoria)->first();
        $id_impresora = model('categoriasModel')->select('impresora')->where('codigocategoria', $codigo_categoria)->first();
        $nombre_impresora = model('impresorasModel')->select('nombre')->where('id', $id_impresora)->first();
        $id_usuario = model('pedidoModel')->select('fk_usuario')->where('id', $numero_pedido)->first();
        $nombre_usuario = model('usuariosModel')->select('nombresusuario_sistema')->where('idusuario_sistema', $id_usuario['fk_usuario'])->first();

        $connector = new WindowsPrintConnector($nombre_impresora['nombre']);
        $printer = new Printer($connector);


        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setTextSize(1, 1);
        $printer->text("**" .  $nombre_categoria['nombrecategoria'] . "**" . "\n\n");



        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->setTextSize(1, 2);
        $printer->text("Pedido: " . $numero_pedido . "       Mesa: " . $nombre_mesa . "\n\n");
        $printer->setTextSize(1, 1);
        $printer->text("Mesero: " . $nombre_usuario['nombresusuario_sistema'] . "\n");

        $printer->text("Fecha :" . "   " . date('d/m/Y ') . "Hora  :" . "   " . date('h:i:s a', time()) . "\n\n");

        $printer->setJustification(Printer::JUSTIFY_LEFT);

        foreach ($productos as $productos) {


            $cantidad_productos_impresos = model('productoPedidoModel')->select('numero_productos_impresos_en_comanda')->where('id', $productos['id'])->first();
            $cantidad_productos = model('productoPedidoModel')->select('cantidad_producto')->where('id', $productos['id'])->first();



            $data = [
                'numero_productos_impresos_en_comanda' => $cantidad_productos_impresos['numero_productos_impresos_en_comanda'] + ($cantidad_productos['cantidad_producto'] - $cantidad_productos_impresos['numero_productos_impresos_en_comanda']),
            ];

            $actualizar = model('productoPedidoModel')->set($data);
            $actualizar = model('productoPedidoModel')->where('id', $productos['id']);
            $actualizar = model('productoPedidoModel')->update();
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->setTextSize(2, 1);
            $printer->text($productos['nombreproducto'] . "\n");


            if (($cantidad_productos['cantidad_producto'] - $cantidad_productos_impresos['numero_productos_impresos_en_comanda']) > 0) {
                $printer->text("Cant. " . $cantidad_productos['cantidad_producto'] - $cantidad_productos_impresos['numero_productos_impresos_en_comanda'] . "\n");
            }
            if (($cantidad_productos['cantidad_producto'] == $cantidad_productos_impresos['numero_productos_impresos_en_comanda'])) {
                $printer->text("Cant. " . $cantidad_productos['cantidad_producto'] . "\n");
            }
            if (!empty($productos['nota_producto'])) {
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->text("NOTAS:\n");
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->text($productos['nota_producto'] . "\n");
            }
            $printer->text("-----------------------\n");
            $printer->text("\n");
        }
        $observaciones_genereles = model('pedidoModel')->select('nota_pedido')->where('id', $numero_pedido)->first();
        if (!empty($observaciones_genereles['nota_pedido'])) {
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setTextSize(2, 1);
            $printer->text("OBSERVACIONES GENERALES \n");
            $printer->text("\n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->setTextSize(2, 1);
            $printer->text($observaciones_genereles['nota_pedido'] . "\n");
            /*
            Cortamos el papel. Si nuestra impresora
            no tiene soporte para ello, no generará
            ningún error
            */
            //$printer->cut();

            /*
            Por medio de la impresora mandamos un pulso.
            Esto es útil cuando la tenemos conectada
            por ejemplo a un cajón
            */
            //$printer->pulse();
            //$printer->close();
            # $printer = new Printer($connector);

            //$milibreria = new Ejemplolibreria();
            //$data = $milibreria->getRegistros();
        }
        $printer->cut();

        $printer->close();
    }

    public function imprimir_prefactura()
    {

        $id_mesa = $this->request->getPost('id_mesa');
        //$id_mesa = 418;
        $propina = $this->request->getPost('propina');
        $pedido = model('pedidoModel')->select('id')->where('fk_mesa', $id_mesa)->first();
        $numero_pedido = $pedido['id'];

        $id_usuario = model('pedidoModel')->select('fk_usuario')->where('id', $numero_pedido)->first();
        $id_mesa = model('pedidoModel')->select('fk_mesa')->where('id', $numero_pedido)->first();
        $nombre_mesa = model('mesasModel')->select('nombre')->where('id', $id_mesa['fk_mesa'])->first();
        $nombre_usuario = model('usuariosModel')->select('nombresusuario_sistema')->where('idusuario_sistema', $id_usuario['fk_usuario'])->first();
        $id_mesero = model('pedidoModel')->select('fk_usuario')->where('id', $id_mesa['fk_mesa'])->first();

        //$nombre_mesero = model('usuariosModel')->select('nombresusuario_sistema')->where('idusuario_sistema', $id_mesero['fk_usuario'])->first();

        $id_impresora = model('cajaModel')->select('id_impresora')->first();
        if (!empty($id_impresora)) {
            $nombre_de_impresora = model('impresorasModel')->select('nombre')->where('id', $id_impresora['id_impresora'])->first();
            $connector = new WindowsPrintConnector($nombre_de_impresora['nombre']);
            $printer = new Printer($connector);

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setTextSize(2, 2);
            $printer->text("Orden de pedido " . "\n");



            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->setTextSize(1, 1);
            $printer->text("Pedido N°   " . $numero_pedido . "\n");
            $printer->text("Mesa   N°   " . $nombre_mesa['nombre'] . "\n");
            if (!empty($nombre_mesero)) {
                $printer->text("Mesero:     " .    $nombre_mesero['nombresusuario_sistema'] . "\n");
            }
            if (empty($nombre_mesero)) {
                $printer->text("Mesero:     " .    $nombre_usuario['nombresusuario_sistema'] . "\n");
            }


            $printer->text("Fecha :  " . "   " . date('d/m/Y ') . "\n");
            $printer->text("Hora  :  " .  "   " .     date('h:i:s a', time()) . "\n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("----------------------------------------------- \n");
            $printer->text("CÓDIGO   PRODUCTO      CANTIDAD     NOTAS  \n");
            $printer->text("----------------------------------------------- \n");


            $items = model('productoPedidoModel')->pre_factura($numero_pedido);


            foreach ($items as $productos) {
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->setTextSize(1, 1);
                $printer->text("Cod." . $productos['codigointernoproducto'] . "      " . $productos['nombreproducto'] . "\n");
                $printer->text("Cant. " . $productos['cantidad_producto'] . "      " . "$" . number_format($productos['valor_unitario'], 0, ',', '.') . "                   " . "$" . number_format($productos['valor_total'], 0, ',', '.') . "\n");
                if (!empty($productos['nota_producto'])) {
                    $printer->setJustification(Printer::JUSTIFY_CENTER);
                    $printer->text("NOTAS:\n");
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->text($productos['nota_producto'] . "\n");
                }
                $printer->text("_______________________________________________ \n");
                $printer->text("\n");
            }

            $observacion_general = model('pedidoModel')->select('nota_pedido')->where('id', $numero_pedido)->first();
            if (!empty($observacion_general['nota_pedido'])) {
                $printer->setTextSize(2, 1);
                $printer->text("OBSERVACION GENERAL\n");
                $printer->text($observacion_general['nota_pedido'] . "\n");
            }

            $total = model('pedidoModel')->select('valor_total')->where('id', $numero_pedido)->first();
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->setTextSize(2, 1);
            $printer->setTextSize(1, 1);
            $printer->text("SUB TOTAL  :" . "$" . number_format($total['valor_total'], 0, ",", ".") . "\n");
            $printer->text("PROPINA    :" . "$" . number_format($propina, 0, ",", ".") . "\n");
            $printer->text("---------------------------------------------" . "\n");

            $printer->setTextSize(2, 2);
            $printer->text("TOTAL      :" . "$" . number_format($propina + $total['valor_total'], 0, ",", ".") . "\n");
            $printer->setTextSize(1, 1);
            $printer->text("---------------------------------------------" . "\n");

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("GRACIAS POR SU VISITA " . "\n");

            /*
            Cortamos el papel. Si nuestra impresora
            no tiene soporte para ello, no generará
            ningún error
            */
            $printer->cut();

            /*
            Por medio de la impresora mandamos un pulso.
            Esto es útil cuando la tenemos conectada
            por ejemplo a un cajón
            */
            //$printer->pulse();
            $printer->close();
            # $printer = new Printer($connector);

            //$milibreria = new Ejemplolibreria();
            //$data = $milibreria->getRegistros();
            $returnData = array(
                "resultado" => 1
            );
            echo  json_encode($returnData);
        } else if (empty($id_impresora)) {
            $returnData = array(
                "resultado" => 0
            );
            echo  json_encode($returnData);
        }
    }


    public function imprimir_factura()
    {

        // $id_factura = 15;

        $id_factura = $_POST['numero_de_factura'];

        $imp = new impresion();
        $impresion = $imp->imprimir_factura($id_factura);

        $imprime_boucher = model('cajaModel')->select('imp_comprobante_transferencia')->where('numerocaja', 1)->first();



        if ($imprime_boucher['imp_comprobante_transferencia'] == 1) {
            $movimientos_transaccion = model('pagosModel')->pago_transferencia($id_factura);
            $movimientos_efectivo = model('pagosModel')->pago_efectivo($id_factura);


            if (!empty($movimientos_transaccion)) {

                $imprimir = $imp->imprimir_comprobnate_transferencia($id_factura, $movimientos_transaccion[0]['recibido_transferencia'], $movimientos_efectivo[0]['recibido_efectivo'], $movimientos_efectivo[0]['total_pago']);
            }
        }
    }


    function imprimir_movimiento_caja()
    {


        $id_apertura = $this->request->getPost('id_apertura');

        $imp = new impresion();

        $impresion = $imp->imprimir_cuadre_caja($id_apertura);
    }

    function lista_electronicas()
    {

        $facturas_electronicas = model('facturaElectronicaModel')->orderBy('id', 'desc')->findAll();



        return view('duplicado_de_factura/factura_electronica', [
            'facturas' => $facturas_electronicas
        ]);
    }

    function imprimir_factura_electronica()
    {
        $imp = new impresion();


        $id_factura = $this->request->getPost('id_factura');
        //$id_factura = 2;

        $id_resolucion = model('facturaElectronicaModel')->select('id_resolucion')->where('id', $id_factura)->first();

        $datos_resolucion = model('resolucionElectronicaModel')->where('id', $id_resolucion['id_resolucion'])->first();

        if (!empty($datos_resolucion)) {

            $impresion = $imp->impresion_factura_electronica($id_factura);
        }
        if (empty($datos_resolucion)) {

            $impresion = $imp->imprimir_factura_electronica($id_factura);
        }
    }
    function impresion_factura_electronica()
    {


        $imp = new impresion();


        $id_factura = $this->request->getPost('id_factura'); 
        //$id_factura = 51;


        $id_resolucion = model('facturaElectronicaModel')->select('id_resolucion')->where('id', $id_factura)->first();

        $datos_resolucion = model('resolucionElectronicaModel')->where('id', $id_resolucion['id_resolucion'])->first();

        if (!empty($datos_resolucion)) {

            $impresion = $imp->impresion_factura_electronica($id_factura);
        }
        if (empty($datos_resolucion)) {

            $impresion = $imp->imprimir_factura_electronica($id_factura);
        }
    }

    function detalle_f_e()
    {
        $id_factura = $this->request->getPost('id_factura');
        $items = model('itemFacturaElectronicaModel')->where('id_de', $id_factura)->findAll();

        $total = model('facturaElectronicaModel')->select('total')->where('id', $id_factura)->first();


        $returnData = array(
            "resultado" => 1,
            "f_e" => view('consultas/detalle_factura_electronica', [
                'productos' => $items
            ]),
            "total" => "Total $ " . number_format($total['total'], 0, ',', '.')
        );
        echo  json_encode($returnData);
    }


    function reporte_ventas()
    {





        $id_apertura = $this->request->getPost('id_apertura');

        $id_impresora = model('impresionFacturaModel')->select('id_impresora')->first();
        $datos_empresa = model('empresaModel')->datosEmpresa();

        $nombre_impresora = model('impresorasModel')->select('nombre')->where('id', $id_impresora['id_impresora'])->first();

        $connector = new WindowsPrintConnector($nombre_impresora['nombre']);
        $printer = new Printer($connector);

        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setTextSize(1, 1);
        $printer->text($datos_empresa[0]['nombrecomercialempresa'] . "\n");
        $printer->text($datos_empresa[0]['nombrejuridicoempresa'] . "\n");
        $printer->text("NIT :" . $datos_empresa[0]['nitempresa'] . "\n");
        $printer->text($datos_empresa[0]['direccionempresa'] . "  " . $datos_empresa[0]['nombreciudad'] . " " . $datos_empresa[0]['nombredepartamento'] . "\n");
        $printer->text("TELEFONO:" . $datos_empresa[0]['telefonoempresa'] . "\n");
        $printer->text($datos_empresa[0]['nombreregimen'] . "\n");
        $printer->text("\n");



        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("**REPORTE DE VENTAS** \n\n");




        $categorias = model('kardexModel')->temp_categoria($id_apertura);


        $printer->setJustification(Printer::JUSTIFY_LEFT);



        foreach ($categorias as $detalle) {
            $nombre_categoria = model('categoriasModel')->select('nombrecategoria')->where('codigocategoria', $detalle['id_categoria'])->first();
            $categoria = $nombre_categoria['nombrecategoria'];
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("------------------------------------\n");
            $printer->text("CATEGORIA: " . $categoria . "\n");
            $printer->text("------------------------------------\n\n");
            $productos = model('kardexModel')->temp_categoria_productos($detalle['id_categoria'], $id_apertura);

            foreach ($productos as $valor) {
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                // Alinea la cantidad a la derecha con una longitud fija de 10 caracteres
                $cantidad_alineada = str_pad($valor['cantidad'], 7, ' ', STR_PAD_LEFT);
                $printer->text($cantidad_alineada . " ____ " . $valor['nombreproducto'] .   "\n");
            }
            $printer->text("\n");
        }




        $printer->text("\n");

        $printer->feed(1);
        $printer->cut();

        $printer->close();

        $returnData = array(
            "resultado" => 1
        );
        echo  json_encode($returnData);
    }
}
