<?php

namespace App\Controllers\pre_factura;

require APPPATH . "Controllers/mike42/autoload.php";

use App\Controllers\BaseController;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class prefacturaController extends BaseController
{
    public function index()
    {
        return view('home/home');
    }
    public function impresora()
    {

        $impresoras = model('impresorasModel')->select('*')->find();
        $id_impresora = model('precuentaModel')->select('id_impresora')->first();

        if (!empty($id_impresora)) {

            return view('pre_factura/pre_factura', [
                'impresoras' => $impresoras,
                'id_impresora' => $id_impresora['id_impresora']
            ]);
        } else {
            return view('pre_factura/asignar_impresora', [
                'impresoras' => $impresoras,
                'resultado' => 0
            ]);
        }
    }

    public function imprimir()
    {

        $numero_pedido = $_POST['numero_de_pedido_pre_factura'];
        $id_usuario = model('pedidoModel')->select('fk_usuario')->where('id', $numero_pedido)->first();
        $id_mesa = model('pedidoModel')->select('fk_mesa')->where('id', $numero_pedido)->first();
        $nombre_mesa = model('mesasModel')->select('nombre')->where('id', $id_mesa['fk_mesa'])->first();
        $nombre_usuario = model('usuariosModel')->select('nombresusuario_sistema')->where('idusuario_sistema', $id_usuario)->first();

        $id_impresora = model('precuentaModel')->select('id_impresora')->first();
        if (!empty($id_impresora)) {
            $nombre_de_impresora = model('impresorasModel')->select('nombre')->where('id', $id_impresora['id_impresora'])->first();
            $connector = new WindowsPrintConnector($nombre_de_impresora['nombre']);
            $printer = new Printer($connector);

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setTextSize(2, 2);
            $printer->text("PREFACTURA" . "\n");



            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->setTextSize(1, 1);
            $printer->text("Pedido N°" . $numero_pedido . "\n");
            $printer->text("Mesa N°" . $nombre_mesa['nombre'] . "\n");
            $printer->text("Mesero: " . $nombre_usuario['nombresusuario_sistema'] . "\n");

            $printer->text("Fecha :" . "   " . date('d/m/Y ') . "\n");
            $printer->text("Hora  :" . "   " . date('h:i:s a', time()) . "\n");
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
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->setTextSize(2, 2);
            $printer->text("TOTAL :" . "$" . number_format($total['valor_total'], 0, ",", ".") . "\n");
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
            return redirect()->to(base_url('pedido/pedidos_para_facturar'))->with('mensaje', 'Prefactura correcta');
        } else if (empty($id_impresora)) {
            $session = session();
            $session->setFlashdata('iconoMensaje', 'error');
            return redirect()->to(base_url('pre_factura/impresora'))->with('mensaje', 'No hay impresora asignada  para imprimir la prefactura');
        }
    }

    public function imprimir_desde_pedido()
    {

        $numero_pedido = $_POST['numero_de_pedido_pre_factura'];

        $id_usuario = model('pedidoModel')->select('fk_usuario')->where('id', $numero_pedido)->first();
        $id_mesa = model('pedidoModel')->select('fk_mesa')->where('id', $numero_pedido)->first();
        $nombre_mesa = model('mesasModel')->select('nombre')->where('id', $id_mesa['fk_mesa'])->first();
        $nombre_usuario = model('usuariosModel')->select('nombresusuario_sistema')->where('idusuario_sistema', $id_usuario)->first();

        $id_impresora = model('precuentaModel')->select('id_impresora')->first();
        if (!empty($id_impresora)) {
            $nombre_de_impresora = model('impresorasModel')->select('nombre')->where('id', $id_impresora['id_impresora'])->first();
            $connector = new WindowsPrintConnector($nombre_de_impresora['nombre']);
            $printer = new Printer($connector);

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setTextSize(2, 2);
            $printer->text("PREFACTURA" . "\n");



            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->setTextSize(1, 1);
            $printer->text("Pedido N°" . $numero_pedido . "\n");
            $printer->text("Mesa N°" . $nombre_mesa['nombre'] . "\n");
            $printer->text("Mesero: " . $nombre_usuario['nombresusuario_sistema'] . "\n");

            $printer->text("Fecha :" . "   " . date('d/m/Y ') . "\n");
            $printer->text("Hora  :" . "   " . date('h:i:s a', time()) . "\n");
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
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->setTextSize(2, 2);
            $printer->text("TOTAL :" . "$" . number_format($total['valor_total'], 0, ",", ".") . "\n");
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

    public function asignar_impresora()
    {
        $id_impresora = $_POST['id_impresora'];




        $id_de_impresora = model('precuentaModel')->select('id_impresora')->first();

        if (!empty($id_de_impresora['id_impresora'])) {


            $data = [
                'id_impresora' => $id_impresora,

            ];
            $model = model('precuentaModel');
            $pre_cuenta = $model->set($data);
            $pre_cuenta = $model->where('id', 1);
            $pre_cuenta = $model->update();


            if ($pre_cuenta) {
                $session = session();
                $session->setFlashdata('iconoMensaje', 'success');
                return redirect()->to(base_url('pre_factura/impresora'))->with('mensaje', 'Impresora asignada');
            } else {
                $session = session();
                $session->setFlashdata('iconoMensaje', 'error');
                return redirect()->to(base_url('pre_factura/impresora'))->with('mensaje', 'Error al asignar la impresora');
            }
        }
        if (empty($id_de_impresora['id_impresora'])) {
            $data = [
                'id_impresora' => $id_impresora
            ];

            $insertado = model('precuentaModel')->insert($data);
            if ($insertado) {
                $session = session();
                $session->setFlashdata('iconoMensaje', 'success');
                return redirect()->to(base_url('pre_factura/impresora'))->with('mensaje', 'Impresora asignada');
            }
        }
    }
    public function imprimir_prefactura()
    {
        $id_mesa = $_POST['id_mesa'];

        $numer_pedido = model('pedidoModel')->select('id')->where('fk_mesa', $id_mesa)->first();
        $numero_pedido = $numer_pedido['id'];
        $id_usuario = model('pedidoModel')->select('fk_usuario')->where('id', $numero_pedido)->first();
        $id_mesa = model('pedidoModel')->select('fk_mesa')->where('id', $numero_pedido)->first();
        $nombre_mesa = model('mesasModel')->select('nombre')->where('id', $id_mesa['fk_mesa'])->first();
        $nombre_usuario = model('usuariosModel')->select('nombresusuario_sistema')->where('idusuario_sistema', $id_usuario)->first();

        //$id_impresora = model('precuentaModel')->select('id_impresora')->first();
        if (!empty($id_mesa)) {
           // $nombre_de_impresora = model('impresorasModel')->select('nombre')->where('id', $id_impresora['id_impresora'])->first();
            $connector = new WindowsPrintConnector('FACTURACION');
            $printer = new Printer($connector);

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setTextSize(2, 2);
            $printer->text("PREFACTURA" . "\n");



            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->setTextSize(1, 1);
            $printer->text("Pedido N°" . $numero_pedido . "\n");
            $printer->text("Mesa N°" . $nombre_mesa['nombre'] . "\n");
            $printer->text("Mesero: " . $nombre_usuario['nombresusuario_sistema'] . "\n");

            $printer->text("Fecha :" . "   " . date('d/m/Y ') . "\n");
            $printer->text("Hora  :" . "   " . date('h:i:s a', time()) . "\n");
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
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->setTextSize(2, 2);
            $printer->text("TOTAL :" . "$" . number_format($total['valor_total'], 0, ",", ".") . "\n");
            $printer->setTextSize(1, 1);
            $printer->text("------------------------------------------------" . "\n");
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
}
