<?php

namespace App\Controllers\comanda;

require APPPATH . "Controllers/mike42/autoload.php";

use App\Controllers\BaseController;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class imprimirComandaController extends BaseController
{
    public function index()
    {
        return view('home/home');
    }

    public function imprimir_comanda_desde_pedido()
    {

        $numero_pedido = $_POST['numero_pedido'];

        /**
         * Comprobacion de que en la columna se_imprime de la tabla producto_pedido hayan valores en false 
         */
        $imprimir_comanda = model('productoPedidoModel')->select('impresion_en_comanda')->where('numero_de_pedido', $numero_pedido)->find();


        $codigo_categoria = model('productoPedidoModel')->id_categoria($numero_pedido);

        foreach ($codigo_categoria as $valor) {
            $nombre_categoria = model('categoriasModel')->select('nombrecategoria')->where('codigocategoria', $valor['codigo_categoria'])->first();
            $impresora = model('categoriasModel')->select('impresora')->where('codigocategoria', $valor['codigo_categoria'])->first();
            $this->generar_comanda_desde_pedido($numero_pedido, $nombre_categoria['nombrecategoria'], $impresora['impresora'], $valor['codigo_categoria']);
        }
    }

    public function imprimir_comanda()
    {


        $numero_pedido = $_POST['numero_pedido_imprimir_comanda'];
        //$numero_pedido = 31883;


        if ($numero_pedido == "") {
            $returnData = array(
                "resultado" => 0,

            );
            echo  json_encode($returnData);
        } else {
            /**
             * Comprobacion de que en la columna se_imprime de la tabla producto_pedido hayan valores en false 
             */
            //$imprimir_comanda = model('productoPedidoModel')->imprimir_productos_pedido($numero_pedido);

            //if (!empty($imprimir_comanda)) {

            $codigo_categoria = model('productoPedidoModel')->id_categoria($numero_pedido);

            if ($codigo_categoria) {

                foreach ($codigo_categoria as $valor) {

                    $nombre_categoria = model('categoriasModel')->select('nombrecategoria')->where('codigocategoria', $valor['codigo_categoria'])->first();
                    $impresora = model('categoriasModel')->select('impresora')->where('codigocategoria', $valor['codigo_categoria'])->first();

                    $this->generar_comanda($numero_pedido, $nombre_categoria['nombrecategoria'], $impresora['impresora'], $valor['codigo_categoria']);
                }


          

                $returnData = array(
                    "resultado" => 1,

                );
                echo  json_encode($returnData);
            } else {
                $returnData = array(
                    "resultado" => 0,

                );
                echo  json_encode($returnData);
            }
        }
    }


    public function generar_comanda($numero_pedido, $nombre_categoria, $id_impresora, $id_categoria)
    {

        //$no_se_imprime_en_comanda = model('productoPedidoModel')->no_se_imprime_en_comanda($numero_pedido);

        /*  foreach ($no_se_imprime_en_comanda as $valor) {
            $impresion_en_comanda = [
                'impresion_en_comanda' => true,
            ];

            $actualizar = model('productoPedidoModel')->set($impresion_en_comanda);
            $actualizar = model('productoPedidoModel')->where('id', $valor['id']);
            $actualizar = model('productoPedidoModel')->update();
        }
 */
        $items = model('productoPedidoModel')->productos_pedido($numero_pedido, $id_categoria);


        $nombre_impresora = model('impresorasModel')->select('nombre')->where('id', $id_impresora)->first();


        $id_usuario = model('pedidoModel')->select('fk_usuario')->where('id', $numero_pedido)->first();
        $id_mesa = model('pedidoModel')->select('fk_mesa')->where('id', $numero_pedido)->first();
        $nombre_mesa = model('mesasModel')->select('nombre')->where('id', $id_mesa['fk_mesa'])->first();
        $nombre_usuario = model('usuariosModel')->select('nombresusuario_sistema')->where('idusuario_sistema', $id_usuario)->first();
 
      

        $connector = new WindowsPrintConnector($nombre_impresora['nombre']);
        $printer = new Printer($connector);


        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setTextSize(1, 1);
        $printer->text("**" . $nombre_categoria . "**" . "\n");



        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->setTextSize(1, 1);
        $printer->text("Pedido N°" . $numero_pedido . "Mesa N°" . $nombre_mesa['nombre'] . "\n");
       
        $printer->text("Mesero: " . $nombre_usuario['nombresusuario_sistema'] . "\n");

        $printer->text("Fecha :" . "   " . date('d/m/Y ') ."Hora  :" . "   " . date('h:i:s a', time()) . "\n\n");
        
        $printer->setJustification(Printer::JUSTIFY_LEFT);
       

        foreach ($items as $productos) {


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
            $printer->text("Cant. " . $cantidad_productos['cantidad_producto'] - $cantidad_productos_impresos['numero_productos_impresos_en_comanda'] . "\n");
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
    public function generar_comanda_desde_pedido($numero_pedido, $nombre_categoria, $id_impresora, $id_categoria)
    {
        $no_se_imprime_en_comanda = model('productoPedidoModel')->no_se_imprime_en_comanda($numero_pedido);

        foreach ($no_se_imprime_en_comanda as $valor) {
            $impresion_en_comanda = [
                'impresion_en_comanda' => true,
            ];

            $actualizar = model('productoPedidoModel')->set($impresion_en_comanda);
            $actualizar = model('productoPedidoModel')->where('id', $valor['id']);
            $actualizar = model('productoPedidoModel')->update();
        }
        $items = model('productoPedidoModel')->productos_pedido($numero_pedido, $id_categoria);

        if (!empty($items)) {

            $nombre_impresora = model('impresorasModel')->select('nombre')->where('id', $id_impresora)->first();

            $id_usuario = model('pedidoModel')->select('fk_usuario')->where('id', $numero_pedido)->first();
            $id_mesa = model('pedidoModel')->select('fk_mesa')->where('id', $numero_pedido)->first();
            $nombre_mesa = model('mesasModel')->select('nombre')->where('id', $id_mesa['fk_mesa'])->first();
            $nombre_usuario = model('usuariosModel')->select('nombresusuario_sistema')->where('idusuario_sistema', $id_usuario)->first();


            $connector = new WindowsPrintConnector($nombre_impresora['nombre']);
            $printer = new Printer($connector);

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setTextSize(1, 1);
            $printer->text("**" . $nombre_categoria . "**" . "\n");



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


            $items = model('productoPedidoModel')->productos_pedido($numero_pedido, $id_categoria);

            foreach ($items as $productos) {

                $data = [
                    'impresion_en_comanda' => true,
                ];

                $actualizar = model('productoPedidoModel')->set($data);
                $actualizar = model('productoPedidoModel')->where('id', $productos['id']);
                $actualizar = model('productoPedidoModel')->update();
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->setTextSize(2, 1);
                $printer->text($productos['nombreproducto'] . "\n");
                $printer->text("Cant. " . $productos['cantidad_producto'] . "\n");
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
                $printer->setTextSize(1, 2);
                $printer->text("** OBSERVACIONES GENERALES **\n");
                $printer->text("\n");
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->setTextSize(2, 1);
                $printer->text($observaciones_genereles['nota_pedido'] . "\n");
            }
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
        }

        if (empty($items)) {
            $returnData = array(
                "resultado" => 0
            );
            echo  json_encode($returnData);
        }
    }

    public function re_imprimir_comanda()
    {

        //$numero_pedido = 32425;
        $numero_pedido = $_POST['numero_de_pedido_reimprimir_comanda'];

        //$imprimir_comanda = model('productoPedidoModel')->select('impresion_en_comanda')->where('numero_de_pedido', $numero_pedido)->find();
        $codigo_categoria = model('productoPedidoModel')->id_categoria_2($numero_pedido);

        foreach ($codigo_categoria as $valor) {
            $nombre_categoria = model('categoriasModel')->select('nombrecategoria')->where('codigocategoria', $valor['codigo_categoria'])->first();
            $impresora = model('categoriasModel')->select('impresora')->where('codigocategoria', $valor['codigo_categoria'])->first();
            $this->generar_reimpresion_comanda($numero_pedido, $nombre_categoria['nombrecategoria'], $impresora['impresora'], $valor['codigo_categoria']);
        }
        $session = session();
        $session->setFlashdata('iconoMensaje', 'success');
        return redirect()->to(base_url('pedido/pedidos_para_facturar'))->with('mensaje', 'Impresión de comanda exitoso');
    }

    public function generar_reimpresion_comanda($numero_pedido, $nombre_categoria, $id_impresora, $id_categoria)
    {

        $items = model('productoPedidoModel')->reimprimir_productos_pedido($numero_pedido, $id_categoria);

        if (!empty($items)) {
            $nombre_impresora = model('impresorasModel')->select('nombre')->where('id', $id_impresora)->first();


            $id_usuario = model('pedidoModel')->select('fk_usuario')->where('id', $numero_pedido)->first();
            $id_mesa = model('pedidoModel')->select('fk_mesa')->where('id', $numero_pedido)->first();
            $nombre_mesa = model('mesasModel')->select('nombre')->where('id', $id_mesa['fk_mesa'])->first();
            $nombre_usuario = model('usuariosModel')->select('nombresusuario_sistema')->where('idusuario_sistema', $id_usuario)->first();


            $connector = new WindowsPrintConnector($nombre_impresora['nombre']);
            $printer = new Printer($connector);

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setTextSize(2, 2);
            $printer->text("REIMPRESION" . "\n");

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setTextSize(1, 1);
            $printer->text("**" . $nombre_categoria . "**" . "\n");



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


            // $items = model('productoPedidoModel')->productos_pedido($numero_pedido, $id_categoria);
            $items = model('productoPedidoModel')->reimprimir_comanda($numero_pedido, $id_categoria);

            foreach ($items as $productos) {

                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->setTextSize(2, 1);
                $printer->text($productos['nombreproducto'] . "\n");
                $printer->text("Cant. " . $productos['cantidad_producto'] . "\n");
                if (!empty($productos['nota_producto'])) {
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->text("NOTAS:\n");
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->text($productos['nota_producto'] . "\n");
                }
                $printer->text("------------------------\n");
                $printer->text("\n");
            }

            $observaciones_genereles = model('pedidoModel')->select('nota_pedido')->where('id', $numero_pedido)->first();
            if (!empty($observaciones_genereles['nota_pedido'])) {
                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->setTextSize(2, 1);
                $printer->text("OBSERVACIONES GENERALES\n");
                $printer->text("\n");
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->setTextSize(2, 1);
                $printer->text($observaciones_genereles['nota_pedido'] . "\n");
            }
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

        } else {
            $session = session();
            $session->setFlashdata('iconoMensaje', 'warning');
            return redirect()->to(base_url('salones/salones'))->with('mensaje', 'No hay productos para imprimir');
        }
    }

    function directa()
    {
        //$numero_pedido = 225;
        $numero_pedido = model('pedidoPosModel')->select('id')->where('fk_usuario', $this->request->getPost('usuario'))->first();



        if (empty($numero_pedido)) {
            $returnData = array(
                "resultado" => 0,

            );
            echo  json_encode($returnData);
        }

        if (!empty($numero_pedido)) {
            $id_impresora = model('precuentaModel')->select('id_impresora')->first();
            $nombre_de_impresora = model('impresorasModel')->select('nombre')->where('id', $id_impresora['id_impresora'])->first();
            $connector = new WindowsPrintConnector($nombre_de_impresora['nombre']);
            $printer = new Printer($connector);

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setTextSize(2, 2);
            $printer->text("PREFACTURA" . "\n");



            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->setTextSize(1, 1);

            $nombre_usuario = model('usuariosModel')->select('nombresusuario_sistema')->where('idusuario_sistema', $this->request->getPost('usuario'))->first();
            $printer->text("Atendido por : " . $nombre_usuario['nombresusuario_sistema'] . "\n");

            $printer->text("Fecha :" . "   " . date('d/m/Y ') . "\n");
            $printer->text("Hora  :" . "   " . date('h:i:s a', time()) . "\n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("----------------------------------------------- \n");
            $printer->text("CÓDIGO   PRODUCTO      CANTIDAD     NOTAS  \n");
            $printer->text("----------------------------------------------- \n");


            $items = model('productoPedidoPosModel')->pre_factura($numero_pedido['id']);


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

            $observacion_general = model('pedidoPosModel')->select('nota_general')->where('id', $numero_pedido['id'])->first();
            if (!empty($observacion_general['nota_general'])) {
                $printer->setTextSize(2, 1);
                $printer->text("OBSERVACION GENERAL\n");
                $printer->text($observacion_general['nota_general'] . "\n");
            }

            $total = model('pedidoPosModel')->select('valor_total')->where('id', $numero_pedido['id'])->first();
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->setTextSize(1, 1);
            $printer->text("TOTAL :" . "$" . number_format($total['valor_total'], 0, ",", ".") . "\n");
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
            $returnData = array(
                "resultado" => 1,

            );
            echo  json_encode($returnData);
        }
    }
}
