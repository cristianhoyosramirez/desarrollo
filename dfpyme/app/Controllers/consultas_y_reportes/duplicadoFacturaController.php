<?php

namespace App\Controllers\consultas_y_reportes;

require APPPATH . "Controllers/mike42/autoload.php";

use App\Controllers\BaseController;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class duplicadoFacturaController extends BaseController
{
    public function index()
    {
        return view('home/home');
    }

    public function duplicado_factura()
    {
        return view('duplicado_de_factura/duplicado_factura');
    }

    public function facturas_por_rango_de_fechas()
    {



        if (!$this->validate([
            'fecha_inicial' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No hay fecha definida',
                ]
            ],
            'fecha_final' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No hay fecha definida',
                ]
            ],

        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fecha_inicial = $_POST['fecha_inicial'];
        $fecha_final = $_POST['fecha_final'];
        $id_usuario = $_POST['id_usuario'];
        $facturas_rango_de_fechas = model('facturaVentaModel')->facturas_por_rango_de_fechas($fecha_inicial, $fecha_final);



        foreach ($facturas_rango_de_fechas as $detalle) {
            $valor_factura = model('productoFacturaVentaModel')->selectSum('total')->where('id_factura', $detalle['id'])->find();
            $data = [
                'nit_cliente' => $detalle['nitcliente'],
                'valor_factura' => $valor_factura[0]['total'],
                'numero_factura' => $detalle['numerofactura_venta'],
                'fecha_factura' => $detalle['fecha_factura_venta'],
                'id_factura' => $detalle['id'],
                'id_usuario' => $id_usuario,
                'horafactura_venta' => $detalle['horafactura_venta'],
                'fk_mesa' => $detalle['fk_mesa'],
                'numero_pedido' => $detalle['numero_pedido']
            ];
            $insert = model('duplicadoFacturaModel')->insert($data);
        }
        $facturas_por_rango_de_fechas = model('duplicadoFacturaModel')->orderBy('id', 'asc')->find();


        $borrar = model('duplicadoFacturaModel')->where('id_usuario', $id_usuario);
        $borrar->delete();

        return view('duplicado_de_factura/facturas_por_rango_de_fecha', [
            "facturas" => $facturas_por_rango_de_fechas
        ]);
    }

    public function detalle_factura()
    {
        $id_factura = $_POST['id_factura'];
        $items = model('productoFacturaVentaModel')->getProductosFacturaVentaModel($id_factura);

        $datos_factura = model('facturaVentaModel')->encabezado_facturas_venta($id_factura);
        $total_factura = model('facturaVentaModel')->select('valor_factura')->where('id', $id_factura)->first();
        $productos = view('duplicado_de_factura/productos_factura_duplicado', [
            'productos' => $items,
            'fecha_factura' => $datos_factura[0]['fecha_factura_venta'],
            'numero_factura' => $datos_factura[0]['numerofactura_venta'],
            'nit_cliente' => $datos_factura[0]['nitcliente'],
            'hora_factura' => $datos_factura[0]['horafactura_venta'],
            'total_factura' => $total_factura['valor_factura']
        ]);

        $returnData = array(
            "resultado" => 1, //Hay numero de pedido
            "productos" => $productos


        );
        echo  json_encode($returnData);
    }

    public function imprimir_duplicado_factura()
    {
        $id_factura = $_POST['id_de_factura'];

        //$id_factura = 47837;

        $items = model('productoFacturaVentaModel')->getProductosFacturaVentaModel($id_factura);

        if (!empty($items)) {

            $numero_factura = model('facturaVentaModel')->select('numerofactura_venta')->where('id', $id_factura)->first();
            $fecha_factura_venta = model('facturaVentaModel')->select('fecha_factura_venta')->where('id', $id_factura)->first();
            $hora_factura_venta = model('facturaVentaModel')->select('horafactura_venta')->where('id', $id_factura)->first();
            $id_usuario = model('facturaVentaModel')->select('idusuario_sistema')->where('id', $id_factura)->first();

            $nombre_usuario = model('usuariosModel')->select('nombresusuario_sistema')->where('idusuario_sistema', $id_usuario['idusuario_sistema'])->first();
            $datos_empresa = model('empresaModel')->datosEmpresa();

            $nit_cliente = model('facturaVentaModel')->select('nitcliente')->where('id', $id_factura)->first();
            $nombre_cliente = model('clientesModel')->select('nombrescliente')->where('nitcliente', $nit_cliente['nitcliente'])->first();

            $nombre_impresora = 'FACTURACION';
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
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("\n");
            $printer->text("*DUPLICADO DE FACTURA*" . "\n");
            $printer->text("\n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->setTextSize(1, 1);
            $printer->text("FACTURA DE VENTA:" . $numero_factura['numerofactura_venta'] . "\n");
            $estado = model('facturaVentaModel')->select('idestado')->where('id', $id_factura)->first();
            $nombre_estado = model('estadoModel')->select('descripcionestado')->where('idestado', $estado['idestado'])->first();

            $printer->text("TIPO DE VENTA :" . $nombre_estado['descripcionestado'] . "\n");


            $printer->text("FECHA:" . " " . $fecha_factura_venta['fecha_factura_venta'] . "  " . $hora_factura_venta['horafactura_venta'] . "\n");
            $printer->text("CAJA 1:" . "\n");
            $printer->text("CAJERO: " . $nombre_usuario['nombresusuario_sistema'] . "\n");

            $printer->text("FECHA REIMPRESIÓN:" . date('Y-m-d') . "\n");



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

            $printer->text("---------------------------------------------" . "\n");
            $total = model('productoFacturaVentaModel')->selectSum('total')->where('id_factura', $id_factura)->find();
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $descuento = model('facturaVentaModel')->select('descuento')->where('id', $id_factura)->first();
            $propina = model('facturaVentaModel')->select('propina')->where('id', $id_factura)->first();
            $printer->text("DESCUENTO:" . "$" . number_format($descuento['descuento'], 0, ",", ".") . "\n");
            $printer->text("PROPINA:" . "$" . number_format($propina['propina'], 0, ",", ".") . "\n");
            $printer->setTextSize(2, 2);
            $printer->text("TOTAL :" . "$" . number_format(($total[0]['total'] - $descuento['descuento']) + $propina['propina'], 0, ",", ".") . "\n");
            $printer->setTextSize(1, 1);
            $efectivo = model('facturaFormaPagoModel')->selectSum('valor_pago')->where('id_factura', $id_factura)->find();

            if ($estado['idestado'] == 1) {
                $printer->text("EFECTIVO :" . "$" . number_format($efectivo[0]['valor_pago'], 0, ",", ".") . "\n");
                $printer->text("CAMBIO :" . "$" . number_format($efectivo[0]['valor_pago'] - ($total[0]['total'] - $descuento['descuento']) + $propina['propina'], 0, ",", ".") . "\n");
            }
            $printer->text("-----------------------------------------------" . "\n");

            $id_regimen = model('empresaModel')->select('idregimen')->first();

            if ($id_regimen['idregimen'] == 1) {

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
                        $datos_ico = model('productoFacturaVentaModel')->base_ico($ico['valor_ico'], $id_factura);
                        $compra = model('productoFacturaVentaModel')->selectSum('total')->where('valor_ico', $ico['valor_ico'])->find();
                        $compra = model('productoFacturaVentaModel')->selectSum('total')->where('id_factura', $id_factura)->find();

                        if (!empty($datos_ico)) {
                            $printer->text($ico['valor_ico'] . "%" . "          " . "$" . number_format($compra[0]['total'], 0, ",", ".") . "   " . "$" . number_format($datos_ico[0]['base'], 0, ",", ".") . "    " . "$" . number_format($compra[0]['total'] - ($datos_ico[0]['base']), 0, ",", ".") . "\n");
                        }
                    }
                }

                $printer->text("\n");
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->setTextSize(1, 1);

                $resolucion_dian = model('consecutivosModel')->select('numeroconsecutivo')->where('idconsecutivos', 6)->first();
                $numero_resolucion_dian = model('dianModel')->select('numeroresoluciondian')->where('iddian', $resolucion_dian['numeroconsecutivo'])->first();

                $fecha_dian = model('dianModel')->select('fechadian')->where('iddian', $resolucion_dian['numeroconsecutivo'])->first();

                $rango_inicial = model('dianModel')->select('rangoinicialdian')->where('iddian', $resolucion_dian['numeroconsecutivo'])->first();
                $rango_final = model('dianModel')->select('rangofinaldian')->where('iddian', $resolucion_dian['numeroconsecutivo'])->first();

                // $printer->text("Resolucion DIAN N° " . $numero_resolucion_dian['numeroresoluciondian'] . "\n");
                // $printer->text("de " . $fecha_dian['fechadian'] . "\n");
                // $printer->text("Autoriza del " . $rango_inicial['rangoinicialdian'] . "al" . $rango_final['rangofinaldian'] . "\n");
                $texto_inicial = model('dianModel')->select('texto_inicial')->where('iddian', $resolucion_dian['numeroconsecutivo'])->first();
                $texto_final = model('dianModel')->select('texto_final')->where('iddian', $resolucion_dian['numeroconsecutivo'])->first();
                $prefijo  = model('dianModel')->select('inicialestatica')->where('iddian', $resolucion_dian['numeroconsecutivo'])->first();

                
                $printer->text($texto_inicial['texto_inicial'] ."  ".$numero_resolucion_dian['numeroresoluciondian']." De ".$fecha_dian['fechadian']. "\n");
                $printer->text($texto_final['texto_final'] ."Del ".$rango_inicial['rangoinicialdian']." al ".$rango_final['rangofinaldian']."Prefijo  ".$prefijo['inicialestatica'] ."\n");
            }
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->setTextSize(1, 1);
            $fk_usuario_mesero = model('facturaVentaModel')->select('fk_usuario_mesero')->where('id', $id_factura)->first();
            $fk_mesa = model('facturaVentaModel')->select('fk_mesa')->where('id', $id_factura)->first();

            $nombreusuario_sistema = model('usuariosModel')->select('nombresusuario_sistema')->where('idusuario_sistema', $fk_usuario_mesero['fk_usuario_mesero'])->first();
            if (!empty($nombreusuario_sistema)) {
                $printer->text("ATENDIDO POR:" . $nombreusuario_sistema['nombresusuario_sistema'] . "\n");
            }


            if (!empty($fk_mesa['fk_mesa'])) {
                $nombre_mesa = model('mesasModel')->select('nombre')->where('id', $fk_mesa['fk_mesa'])->first();
                $printer->text("MESA:" . $nombre_mesa['nombre'] . "\n");
                $id_salon = model('mesasModel')->select('fk_salon')->where('id', $fk_mesa['fk_mesa'])->first();
                $nombre_salon = model('salonesModel')->select('nombre')->where('id', $id_salon['fk_salon'])->first();
                $numero_pedido = model('facturaVentaModel')->select('numero_pedido')->where('id', $id_factura)->first();
                $printer->text("Numero de pedido " . $numero_pedido['numero_pedido'] . "\n");
                $printer->text("TIPO DE VENTA:" . $nombre_salon['nombre'] . "\n");
            }
            if (empty($fk_mesa['fk_mesa']) || $fk_mesa['fk_mesa'] == 0) {
                $printer->text("TIPO DE VENTA: VENTAS DE MOSTRADOR" . "\n");
            }


            $observaciones_genereles = model('facturaVentaModel')->select('observaciones_generales')->where('id', $id_factura)->first();

            if (!empty($observaciones_genereles['observaciones_generales'])) {
                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->setTextSize(1, 2);
                $printer->text("OBSERVACIONES GENERALES\n");
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->setTextSize(1, 1);
                $printer->text($observaciones_genereles['observaciones_generales'] . "\n");
                $printer->text("-----------------------------------------------" . "\n");
            }

            $printer->text("-----------------------------------------------" . "\n");
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setTextSize(1, 1);
            $printer->text("SOFTWARE DFPYME INTREDETE" . "\n");

            $printer->text("comercial@intredete.com" . "\n");

            $printer->text("-----------------------------------------------" . "\n");
            $printer->text("GRACIAS POR SU VISITA " . "\n");

            $printer->feed(1);
            $printer->cut();
            //$printer->pulse();
            $printer->close();
            $returnData = array(
                "resultado" => 1
            );
            echo  json_encode($returnData);
        }
    }
}
