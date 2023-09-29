<?php

namespace App\Controllers\pedidos;

use App\Controllers\BaseController;

require APPPATH . "Controllers/mike42/autoload.php";

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;


class Imprimir extends BaseController
{
    public function index()
    {
        return view('home/home');
    }


    function imprimirComanda()
    {

        //$id_mesa = 3; 
        $id_mesa = $this->request->getPost('id_mesa');

        $pedido = model('pedidoModel')->select('id')->where('fk_mesa', $id_mesa)->first();
        $nombre_mesa = model('mesasModel')->select('nombre')->where('id', $id_mesa)->first();

        $productos = array();
        if (!empty($pedido)) {
            $codigo_categoria = model('productoPedidoModel')->id_categoria($pedido['id']);


            foreach ($codigo_categoria as $valor) {
                $items = model('productoPedidoModel')->productos_pedido($pedido['id'], $valor['codigo_categoria']);

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
                    $this->generar_comanda($valor['codigo_categoria'], $productos, $pedido['id'], $nombre_mesa['nombre']);
                }
            }
            if (empty($items)) {
                $returnData = array(
                    "resultado" => 0
                );
                echo  json_encode($returnData);
            }
            if (!empty($items)) {
                $returnData = array(
                    "resultado" => 1
                );
                echo  json_encode($returnData);
            }
        }
    }

    function generar_comanda($codigo_categoria, $productos, $numero_pedido, $nombre_mesa)
    {
        $nombre_categoria = model('categoriasModel')->select('nombrecategoria')->where('codigocategoria', $codigo_categoria)->first();

        $impresora = model('categoriasModel')->select('impresora')->where('codigocategoria', $codigo_categoria)->first();
        $id_impresora = model('categoriasModel')->select('impresora')->where('codigocategoria', $codigo_categoria)->first();
        $nombre_impresora = model('impresorasModel')->select('nombre')->where('id', $id_impresora)->first();
        $id_usuario = model('pedidoModel')->select('fk_usuario')->where('id', $numero_pedido)->first();
        $nombre_usuario = model('usuariosModel')->select('nombresusuario_sistema')->where('idusuario_sistema', $id_usuario['fk_usuario'])->first();

        $connector = new WindowsPrintConnector($nombre_impresora['nombre']);
        $printer = new Printer($connector);


        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setTextSize(1, 1);
        $printer->text("**" . $nombre_categoria['nombrecategoria'] . "**" . "\n");



        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->setTextSize(1, 1);
        $printer->text("Pedido N°" . $numero_pedido . "       Mesa N°" . $nombre_mesa . "\n");

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
        $propina = $this->request->getPost('propina');
        $pedido = model('pedidoModel')->select('id')->where('fk_mesa', $id_mesa)->first();
        $numero_pedido = $pedido['id'];

        $id_usuario = model('pedidoModel')->select('fk_usuario')->where('id', $numero_pedido)->first();
        $id_mesa = model('pedidoModel')->select('fk_mesa')->where('id', $numero_pedido)->first();
        $nombre_mesa = model('mesasModel')->select('nombre')->where('id', $id_mesa['fk_mesa'])->first();
        $nombre_usuario = model('usuariosModel')->select('nombresusuario_sistema')->where('idusuario_sistema', $id_usuario)->first();
        $id_mesero = model('mesasModel')->select('id_mesero')->where('id', $id_mesa)->first();
        $nombre_mesero = model('usuariosModel')->select('nombresusuario_sistema')->where('idusuario_sistema', $id_mesero['id_mesero'])->first();

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
            if (!empty($nombre_mesero)) {
                $printer->text("Mesero: " . $nombre_mesero['nombresusuario_sistema'] . "\n");
            }
            if (empty($nombre_mesero)) {
                $printer->text("Mesero: " . $nombre_usuario['nombresusuario_sistema'] . "\n");
            }


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

        //$id_factura = 120397;
        $id_factura = $_POST['numero_de_factura'];

        $numero_factura = model('facturaVentaModel')->select('numerofactura_venta')->where('id', $id_factura)->first();


        if (!empty($numero_factura['numerofactura_venta'])) {

            $numero_factura['numerofactura_venta'];


            $fecha_factura_venta = model('facturaVentaModel')->select('fecha_factura_venta')->where('id', $id_factura)->first();
            $hora_factura_venta = model('facturaVentaModel')->select('horafactura_venta')->where('id', $id_factura)->first();
            $id_usuario = model('facturaVentaModel')->select('idusuario_sistema')->where('id', $id_factura)->first();
            $nombre_usuario = model('usuariosModel')->select('nombresusuario_sistema')->where('idusuario_sistema', $id_usuario['idusuario_sistema'])->first();
            $datos_empresa = model('empresaModel')->datosEmpresa();

            $nit_cliente = model('facturaVentaModel')->select('nitcliente')->where('id', $id_factura)->first();
            $nombre_cliente = model('clientesModel')->select('nombrescliente')->where('nitcliente', $nit_cliente['nitcliente'])->first();

            $id_impresora = model('impresionFacturaModel')->select('id_impresora')->first();

            $nombre_impresora = model('impresorasModel')->select('nombre')->where('id', $id_impresora['id_impresora'])->first();

            $connector = new WindowsPrintConnector($nombre_impresora['nombre']);
            $printer = new Printer($connector);

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setTextSize(1, 2);
            $printer->text($datos_empresa[0]['nombrecomercialempresa'] . "\n");
            $printer->setTextSize(1, 1);
            $printer->text($datos_empresa[0]['nombrejuridicoempresa'] . "\n");
            $printer->text("NIT :" . $datos_empresa[0]['nitempresa'] . "\n");
            $printer->text($datos_empresa[0]['direccionempresa'] . "  " . $datos_empresa[0]['nombreciudad'] . " " . $datos_empresa[0]['nombredepartamento'] . "\n");
            $printer->text("TELEFONO:" . $datos_empresa[0]['telefonoempresa'] . "\n");
            $printer->text($datos_empresa[0]['nombreregimen'] . "\n");
            $printer->text("\n");


            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->setTextSize(1, 1);
            $estado_factura = model('facturaVentaModel')->estado_factura($id_factura);

            if ($estado_factura[0]['idestado'] == 1 or $estado_factura[0]['idestado'] == 2) {
                $printer->text("FACTURA DE VENTA: " . $numero_factura['numerofactura_venta'] . "\n");
            }

            if ($estado_factura[0]['idestado'] == 7) {
                $printer->text("REMISION : " . $numero_factura['numerofactura_venta'] . "\n");
            }



            $printer->text("TIPO DE VENTA:" . $estado_factura[0]['descripcionestado'] . "\n");

            $printer->text("FECHA:" . " " . $fecha_factura_venta['fecha_factura_venta'] . "  " . date("g:i a", strtotime($hora_factura_venta['horafactura_venta'])) . "\n");
            if ($estado_factura[0]['idestado'] == 2) {
                $printer->text("FECHA LIMITE:" . $estado_factura[0]['fechalimitefactura_venta'] . "\n");
            }
            $printer->text("CAJA : 1" . "\n");
            $printer->text("CAJERO: " . $nombre_usuario['nombresusuario_sistema'] . "\n");

            $printer->text("---------------------------------------------" . "\n");
            $printer->text("CLIENTE :" . " " . $nombre_cliente['nombrescliente'] . "\n");
            $printer->text("NIT     :" . " " . number_format($nit_cliente['nitcliente'], 0, ",", ".") . "\n");
            $printer->text("---------------------------------------------" . "\n");
            $printer->text("CODIGO    DESCRIPCION   VALOR UNITARIO    TOTAL" . "\n");
            $printer->text("---------------------------------------------" . "\n");



            $items = model('productoFacturaVentaModel')->getProductosFacturaVentaModel($id_factura);

            foreach ($items as $detalle) {
                $valor_venta = $detalle['total'] / $detalle['cantidadproducto_factura_venta'];
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->text("Cod." . $detalle['codigointernoproducto'] . "      " . $detalle['nombreproducto'] . "\n");
                $printer->text("Cant. " . $detalle['cantidadproducto_factura_venta'] . "      " . "$" . number_format($valor_venta, 0, ',', '.') . "                   " . "$" . number_format($detalle['total'], 0, ',', '.') . "\n");
            }

            $cantidad_iva = model('productoFacturaVentaModel')->impuestos($id_factura);
            $iva_temp = 0;
            $ico_temp = 0;
            $venta_real_temp = 0;




            foreach ($cantidad_iva  as $detalle) {
                $iva = $detalle['cantidadproducto_factura_venta'] * $detalle['iva'];
                $impuesto_al_consumo = $detalle['cantidadproducto_factura_venta'] * $detalle['impuesto_al_consumo'];
                $total_iva = $iva + $iva_temp;
                $iva_temp = $total_iva;

                $total_ico = $impuesto_al_consumo + $ico_temp;
                $ico_temp = $total_ico;

                $sub_total = $detalle['valor_venta_real'] * $detalle['cantidadproducto_factura_venta'];
                //$sub_total = $detalle['valor_venta_real'] * $detalle['cantidadproducto_factura_venta'];
                $sub_totales = $sub_total + $venta_real_temp;
                $venta_real_temp = $sub_totales;
            }

            //echo $total_iva."</br>";


            $printer->text("---------------------------------------------" . "\n");
            $total = model('productoFacturaVentaModel')->selectSum('total')->where('id_factura', $id_factura)->find();
            $printer->setJustification(Printer::JUSTIFY_RIGHT);


            $printer->text("SUB TOTAL :" . "$" . number_format($total[0]['total'] - ($total_ico - $total_iva), 0, ",", ".") . "\n");


            if ($total_iva != 0) {
                $printer->text("IVA       :" . "$" . number_format($total_iva, 0, ",", ".") . "\n");
            }
            if ($total_ico) {
                $printer->text("IMPUESTO AL CONSUMO :" . "$" . number_format($total_ico, 0, ",", ".") . "\n");
            }
            $descuento = model('facturaVentaModel')->select('descuento')->where('id', $id_factura)->first();
            $printer->text("DESCUENTO :" . "$" . number_format($descuento['descuento'], 0, ",", ".") . "\n");

            $propina = model('facturaVentaModel')->select('propina')->where('id', $id_factura)->first();
            $printer->text("PROPINA :" . "$" . number_format($propina['propina'], 0, ",", ".") . "\n\n");
            $printer->setTextSize(2, 2);
            $printer->text("TOTAL :" . "$" . number_format(($total[0]['total'] - $descuento['descuento']) + $propina['propina'], 0, ",", ".") . "\n\n");

            $efectivo = model('facturaFormaPagoModel')->selectSum('valor_pago')->where('id_factura', $id_factura)->find();
            $printer->setTextSize(1, 1);
            $id_forma_pago = model('facturaFormaPagoModel')->id_forma_pago($id_factura);
            $temp_cambio = 0;
            foreach ($id_forma_pago as $forma_pago) {
                $id_forma_pago = model('facturaFormaPagoModel')->id_forma_pago($id_factura);
                $nombre_forma_pago = model('facturaFormaPagoModel')->nombre_forma_pago($forma_pago['idforma_pago']);
                $valor_forma_pago = model('facturaFormaPagoModel')->valor_forma_pago($forma_pago['idforma_pago'], $id_factura);

                if ($valor_forma_pago[0]['valor_pago'] > 0) {
                    $printer->text($nombre_forma_pago[0]['nombreforma_pago'] . ":  $" . number_format($valor_forma_pago[0]['valor_pago'], 0, ",", ".") . "\n");
                }
            }
            if ($estado_factura[0]['idestado'] == 1 or $estado_factura[0]['idestado'] == 7) {
                $printer->text("CAMBIO: " . "$" . number_format($efectivo[0]['valor_pago'] - (($total[0]['total'] - $descuento['descuento']) + $propina['propina']), 0, ",", ".") . "\n");
                $printer->text("-----------------------------------------------" . "\n");
            }


            $regimen = model('empresaModel')->select('idregimen')->first();

            if ($regimen['idregimen'] == 1) {

                $tarifa_iva = model('productoFacturaVentaModel')->tarifa_iva($id_factura);
                if (!empty($tarifa_iva)) {
                    $printer->setJustification(Printer::JUSTIFY_CENTER);
                    $printer->setTextSize(1, 1);
                    $printer->text("**DISCRIMINACION TARIFAS DE IVA** \n");
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->text("TARIFA    COMPRA       BASE/IMP         IVA" . "\n");
                    foreach ($tarifa_iva as $iva) {
                        $datos_iva = model('productoFacturaVentaModel')->base_iva($iva['valor_iva'], $id_factura);
                        if (!empty($datos_iva)) {
                            $printer->text($iva['valor_iva'] . "%" . "          " . "$" . number_format($datos_iva[0]['compra'], 0, ",", ".") . "   " . "$" . number_format($datos_iva[0]['base'] * $datos_iva[0]['cantidadproducto_factura_venta'], 0, ",", ".") . "    " . "$" . number_format($datos_iva[0]['compra'] - ($datos_iva[0]['base'] * $datos_iva[0]['cantidadproducto_factura_venta']), 0, ",", ".") . "\n");
                        }
                    }
                }

                $tarifa_ico = model('productoFacturaVentaModel')->tarifa_ico($id_factura);



                if (!empty($tarifa_ico)) {
                    $printer->text("\n");
                    $printer->setJustification(Printer::JUSTIFY_CENTER);
                    $printer->setTextSize(1, 1);
                    $printer->text("**DISCRIMINACION TARIFAS DE IPO CONSUMO** \n");
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->text("TARIFA    COMPRA     BASE/IMP        IPO CONSUMO" . "\n");

                    foreach ($tarifa_ico as $ico) {
                        //  $printer->text($iva['valor_iva']."%". "\n");
                        $total_compra = model('productoFacturaVentaModel')->total_compra($ico['valor_ico'], $id_factura);

                        $base_ico = model('productoFacturaVentaModel')->base_ico($ico['valor_ico'], $id_factura);

                        if ($total_compra[0]['compra'] >= 100000) {
                            $printer->text($ico['valor_ico'] . "%" . "        " . "$" . number_format($total_compra[0]['compra'], 0, ",", ".") . "   " . "$" . number_format($total_compra[0]['compra'] - ($base_ico[0]['base']), 0, ",", ".") . "         " . "$" . number_format($base_ico[0]['base'], 0, ",", ".") . "\n");
                        }
                        if ($total_compra[0]['compra'] < 100000) {
                            $printer->text($ico['valor_ico'] . "%" . "        " . "$" . number_format($total_compra[0]['compra'], 0, ",", ".") . "    " . "$" . number_format($total_compra[0]['compra'] - ($base_ico[0]['base']), 0, ",", ".") . "         " . "$" . number_format($base_ico[0]['base'], 0, ",", ".") . "\n");
                        }
                    }
                }


                // if ($estado_factura[0]['descripcionestado'] == 1 or $estado_factura[0]['descripcionestado'] == 2) {
                $id_registro_dian = model('consecutivosModel')->select('numeroconsecutivo')->Where('idconsecutivos', 6)->first();


                // $prefijo_factura = model('consecutivosModel')->select('numeroconsecutivo')->where('conceptoconsecutivo =', 'FacturaPrefijo')->first();
                $prefijo_factura = model('dianModel')->select('inicialestatica')->where('iddian ', $id_registro_dian['numeroconsecutivo'])->first();

                $id_resolucion_dian = model('consecutivosModel')->select('numeroconsecutivo')->where('conceptoconsecutivo =', 'IdRegistroDian')->first();

                $factura_prefijo = model('consecutivosModel')->select('numeroconsecutivo')->where('idconsecutivos', $id_resolucion_dian['numeroconsecutivo'])->first();

                $fecha_dian = model('dianModel')->select('fechadian')->where('iddian', $id_resolucion_dian['numeroconsecutivo'])->first();
                $rango_inicial = model('dianModel')->select('rangoinicialdian')->where('iddian', $id_resolucion_dian['numeroconsecutivo'])->first();
                $rango_final = model('dianModel')->select('rangofinaldian')->where('iddian', $id_resolucion_dian['numeroconsecutivo'])->first();
                $texto_inicial = model('dianModel')->select('texto_inicial')->where('iddian', $id_resolucion_dian['numeroconsecutivo'])->first();
                $texto_final = model('dianModel')->select('texto_final')->where('iddian', $id_resolucion_dian['numeroconsecutivo'])->first();

                $numero_resolucion_dian = model('dianModel')->select('numeroresoluciondian')->where('iddian', $id_resolucion_dian['numeroconsecutivo'])->first();
                $printer->text("\n");
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->setTextSize(1, 1);
                $printer->text($texto_inicial['texto_inicial'] . $numero_resolucion_dian['numeroresoluciondian'] . " de" . " " . $fecha_dian['fechadian'] . "\n");
                $printer->text($texto_final['texto_final'] . " Del " . $rango_inicial['rangoinicialdian'] . " al " . " "  . $rango_final['rangofinaldian'] . " " . "Prefijo " . $prefijo_factura['inicialestatica'] . "\n\n");
            }

            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->setTextSize(1, 1);
            $fk_usuario_mesero = model('facturaVentaModel')->select('fk_usuario_mesero')->where('id', $id_factura)->first();
            $nombreusuario_sistema = model('usuariosModel')->select('nombresusuario_sistema')->where('idusuario_sistema', $fk_usuario_mesero['fk_usuario_mesero'])->first();
            $printer->text("ATENDIDO POR:" . $nombreusuario_sistema['nombresusuario_sistema'] . "\n");

            $observaciones_genereles = model('facturaVentaModel')->select('observaciones_generales')->where('id', $id_factura)->first();
            $fk_mesa = model('facturaVentaModel')->select('fk_mesa')->where('id', $id_factura)->first();
            $nombre_mesa = model('mesasModel')->select('nombre')->where('id', $fk_mesa['fk_mesa'])->first();
            if (!empty($nombre_mesa['nombre'])) {
                $printer->text("MESA:" . $nombre_mesa['nombre'] . "\n");
            }
            if (empty($nombre_mesa['nombre'])) {
                $printer->text("MESA: VENTAS DE MOSTRADOR" . "\n");
            }

            if (!empty($observaciones_genereles['observaciones_generales'])) {
                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->setTextSize(1, 2);
                $printer->text("OBSERVACIONES GENERALES\n");
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->setTextSize(1, 1);
                $printer->text($observaciones_genereles['observaciones_generales'] . "\n");
            }

            $printer->text("-----------------------------------------------" . "\n");
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setTextSize(1, 1);
            $printer->text("IMPRESO POR SOFTWARE DFPYME INTREDETE" . "\n");
            $printer->text("NIT: 901448365-5" . "\n");

            $printer->text("-----------------------------------------------" . "\n");
            $printer->text("GRACIAS POR SU VISITA " . "\n");

            $printer->feed(1);
            $printer->cut();

            $printer->close();

            $movimientos_transaccion = model('facturaformaPagoModel')->valor_pago_transaccion($id_factura);
            $movimientos_efectivo = model('facturaformaPagoModel')->valor_pago_transaccion($id_factura);

            $imprime_boucher = model('cajaModel')->select('imp_comprobante_transferencia')->where('numerocaja', 1)->first();

            if ($imprime_boucher['imp_comprobante_transferencia'] == 1) {

                if (!empty($movimientos_transaccion[0]['valor_pago'])) {
                    $printer->setJustification(Printer::JUSTIFY_CENTER);
                    $printer->setTextSize(1, 1);
                    $printer->text("SOPORTE TRANSFERENCIA\n");
                    $printer->text($datos_empresa[0]['nombrecomercialempresa'] . "\n");
                    //$printer->text($datos_empresa[0]['representantelegalempresa'] . "\n");
                    $printer->text("NIT :" . $datos_empresa[0]['nitempresa'] . "\n");

                    $printer->text("\n");

                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->setTextSize(1, 1);
                    $printer->text("FACTURA DE VENTA:" . $numero_factura['numerofactura_venta'] . "\n");
                    $printer->text("FECHA:" . " " . $fecha_factura_venta['fecha_factura_venta'] . "  " . $hora_factura_venta['horafactura_venta'] . "\n");

                    $printer->text("TOTAL :" . "$" . number_format($total[0]['total'], 0, ",", ".") . "\n\n");
                    $efectivo = "";
                    if (!empty($movimientos_efectivo[0]['valor_pago'])) {
                        //$printer->text("EFECTIVO :" . "$" . number_format($movimientos_efectivo[0]['valorfactura_forma_pago'], 0, ",", ".") . "\n");
                        $efectivo = $movimientos_efectivo[0]['valor_pago'];
                    }
                    if (empty($movimientos_efectivo[0]['valor_pago'])) {
                        //$printer->text("EFECTIVO :" . "$" . number_format($movimientos_efectivo[0]['valorfactura_forma_pago'], 0, ",", ".") . "\n");
                        $efectivo = 0;
                    }
                    $printer->setTextSize(1, 1);
                    $printer->text("Pago efectivo  :" . "$" . number_format($efectivo, 0, ",", ".") . "\n");
                    $printer->text("Pago transferencia :" . "$" . number_format($movimientos_transaccion[0]['valor_pago'], 0, ",", ".") . "\n");
                    $printer->text("Cambio :" . "$" . number_format(($movimientos_transaccion[0]['valor_pago'] + $movimientos_efectivo[0]['valor_pago']) - $total[0]['total'], 0, ",", ".") . "\n\n\n");

                    $printer->text("Nota:____________________________________" . "\n\n");
                    $printer->setTextSize(1, 1);
                    $printer->text("Nombre:_________________________________ \n\n");
                    $printer->text("Identificación:__________________________ \n\n");
                    $printer->text("Teléfono:________________________________\n\n");


                    $printer->feed(1);
                    $printer->cut();
                    $printer->pulse();
                    $printer->close();
                } else if (empty($movimientos_transaccion)) {
                    $printer->pulse();
                    $printer->close();
                }
            }
            $returnData = array(
                "resultado" => 1, //Falta plata 
                "tabla" => view('factura_pos/tabla_reset_factura')
            );
            echo  json_encode($returnData);
        }
    }


    function imprimir_movimiento_caja()
    {

        $id_apertura = $this->request->getPost('id_apertura');
        //$id_apertura = 26;

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

        $fecha_apertura = model('aperturaModel')->select('fecha')->where('id', $id_apertura)->first();
        $hora_apertura = model('aperturaModel')->select('hora')->where('id', $id_apertura)->first();

        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("**CUADRE DE CAJA** \n");

        $printer->text("Fecha apertura:  " . $fecha_apertura['fecha'] . " " . date("g:i a", strtotime($hora_apertura['hora'])) . "\n");


        $cierre = model('cierreModel')->select('fecha')->where('idapertura', $id_apertura)->first();

        if (!empty($cierre)) {
            $printer->text("Fecha cierre:    " . $cierre['fecha'] . " " . date("g:i a", strtotime($hora_apertura['hora'])) . "\n");
        }
        if (empty($cierre)) {
            $printer->text("Fecha cierre:    Sin cierre " . "\n");
        }




        $printer->text("Caja N° : 1 \n");

        $printer->text("\n");

        $valor_apertura = model('aperturaModel')->select('valor')->where('id', $id_apertura)->first();
        $printer->text("VALOR APERTURA   : " . "$" . number_format($valor_apertura['valor'], 0, ",", ".") . "\n");

        $printer->text("\n");

        $printer->text("-----------------------------------------------\n ");
        $printer->text("INGRESOS \n ");
        $printer->text("-----------------------------------------------\n ");
        $printer->text("\n");



        $ingresos_efectivo = model('pagosModel')->selectSum('efectivo')->where('id_apertura', $id_apertura)->findAll();
        $ingresos_transaccion = model('pagosModel')->selectSum('transferencia')->where('id_apertura', $id_apertura)->findAll();
        $propinas = model('pagosModel')->selectSum('propina')->where('id_apertura', $id_apertura)->findAll();


        $printer->text("Ingresos efectivo:      " . "$" . number_format($ingresos_efectivo[0]['efectivo'], 0, ",", ".") . "\n");
        $printer->text("Ingresos transacción: " . "$" . number_format($ingresos_transaccion[0]['transferencia'], 0, ",", ".") . "\n");
        //$total_ingresos = model('facturaFormaPagoModel')->total_ingresos($fecha_y_hora_apertura['fecha_y_hora_apertura'], $fecha_y_hora_actual);
        $printer->text("Total ingresos          " . "$" . number_format($ingresos_efectivo[0]['efectivo'] + $ingresos_transaccion[0]['transferencia'], 0, ",", ".") . "\n");


        $printer->text("\n");

        $printer->text("------------------------------------------------\n ");
        $printer->text("RETIROS \n");
        $printer->text("------------------------------------------------\n ");
        $retiros = model('retiroModel')->select('*')->where('id_apertura', $id_apertura)->findAll();

        $printer->text("\n");
        foreach ($retiros as $detalle) {
            $printer->text("FECHA: " . $detalle['fecha'] . " " . date("g:i a", strtotime($detalle['hora'])) . "\n");
            $concepto = model('retiroFormaPagoModel')->select('concepto')->where('idretiro', $detalle['id'])->first();
            $printer->text("CONCEPTO:" . $concepto['concepto'] . "\n");
            $valor = model('retiroFormaPagoModel')->select('valor')->where('idretiro', $detalle['id'])->first();
            $printer->text("VALOR:" . "$" . number_format($valor['valor'], 0, ",", ".") . "\n");
            $printer->text("\n");
        }



        $temp_retiros = 0;
        $total_retiros = 0;
        foreach ($retiros as $detalle) {
            $valor = model('retiroFormaPagoModel')->select('valor')->where('idretiro', $detalle['id'])->first();
            $temp_retiros = $temp_retiros + $valor['valor'];
            $total_retiros = $temp_retiros;
        }

        $printer->text("Total retiros: " . "$" . number_format($total_retiros, 0, ",", ".") . "\n");

        $printer->text("\n");

        $printer->text("------------------------------------------------\n ");
        $printer->text("DEVOLUCIONES \n");
        $printer->text("------------------------------------------------\n ");
        $printer->text("\n");

        $devolucion_venta = model('devolucionModel')->where('id_apertura', $id_apertura)->findAll();


        $temp_devoluciones = 0;
        $total_devoluciones = 0;

        foreach ($devolucion_venta as $detalle) {

            $printer->text("FECHA:" . $detalle['fecha'] . " " . date("g:i a", strtotime($detalle['hora'])) . "\n");
            $codigo_interno_producto = model('detalleDevolucionVentaModel')->select('codigo')->where('id_devolucion_venta', $detalle['id'])->first();
            $nombre_producto = model('productoModel')->select('nombreproducto')->where('codigointernoproducto', $codigo_interno_producto['codigo'])->first();
            $printer->text("PRODUCTO: " . $nombre_producto['nombreproducto'] . "\n");
            $valor = model('devolucionVentaEfectivoModel')->select('valor')->where('iddevolucion', $detalle['id'])->first();
            $printer->text("VALOR " . "$" . number_format($valor['valor'], 0, ",", ".") . "\n");
            $printer->text("\n");


            $temp_devoluciones = $temp_devoluciones + $valor['valor'];
            $total_devoluciones = $temp_devoluciones;
        }

        $printer->text("Total devoluciones:" . "$" . number_format($total_devoluciones, 0, ",", ".") . "\n");

        $printer->text("\n");
        $printer->text("------------------------------------------------\n");
        $printer->text("Ingresos-retiros-devoluciones \n");
        $printer->text("------------------------------------------------\n");

        $printer->text("Ingresos+apertura " . "$" . number_format($ingresos_efectivo[0]['efectivo'] + $valor_apertura['valor'] + $ingresos_transaccion[0]['transferencia'], 0, ",", ".") . "\n");

        $printer->text("Total retiros: " . "$" . number_format($total_retiros, 0, ",", ".") . "\n");
        $printer->text("Total devoluciones:" . "$" . number_format($total_devoluciones, 0, ",", ".") . "\n");

        $temp = $ingresos_efectivo[0]['efectivo'] + $valor_apertura['valor'] + $ingresos_transaccion[0]['transferencia'];
        $total_caja = $total_retiros + $total_devoluciones;
        $total_en_caja = $temp - $total_caja;

        $printer->text("(-) Efectivo en caja: " . number_format($total_en_caja, 0, ",", ".") . "\n");

        $printer->text("\n");
        $printer->text("-----------------------------------------------\n");
        $printer->text("Cierre de caja \n");
        $printer->text("-----------------------------------------------\n");
        $printer->text("Efectivo en caja del sistema  " . "$" . number_format($total_en_caja, 0, ",", ".") . " \n");
        $valor_cierre_efectivo_usuario = model('cierreFormaPagoModel')->valor_cierre_efectivo_usuario($id_apertura);

        $printer->text("\n");

        if (empty($ingresos_transaccion)) {
            $transaccion = 0;
        }


        /* $printer->text("Transacciones: " . "$" .# number_format($transaccion, 0, ",", ".") . "\n");
        //$valor_cierre_transaccion_usuari = model('cierreFormaPagoModel')->valor_cierre_transaccion_usuario($id_apertura);
       if (empty($valor_cierre_transaccion_usuari)) {
            $valor_cierre_transaccion_usuario = 0;
        }
        if (!empty($valor_cierre_transaccion_usuari)) {
            $valor_cierre_transaccion_usuario = $valor_cierre_transaccion_usuari[0]['valor'];
        } */


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
