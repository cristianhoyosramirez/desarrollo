<?php

namespace App\Controllers\Boletas;

use App\Controllers\BaseController;

require APPPATH . "Controllers/phpqrcode/qrlib.php";

use QRcode;



class Boletas extends BaseController
{
    public function boletas()
    {

        $localidad = model('localidadModel')->where('estado', true)->findAll();
        return view('boletas/boletas', [
            'localidad' => $localidad
        ]);
    }


    function set_boletas()
    {



        if (!$this->validate([
            'clientes_factura_pos' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato necesario',
                ]
            ],
            'localidad' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato necesario',
                ]
            ],

        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $nombre_localidad = model('localidadModel')->select('nombre')->where('id', $_POST['localidad'])->first();



        $data = [

            'nitcliente' => $_POST['id_cliente_factura_pos'],
            'fecha_generacion' => date('Y-m-d'),
            'hora_generacion' => date("H:i:s"),
            'estado' => 'Generada',
            'fecha_ingreso' => date('Y-m-d'),
            'hora_ingreso' => date("H:i:s"),
            'observaciones' => '',
            'localidad' => $nombre_localidad['nombre']
        ];


        $insert = model('BoletasModel')->insert($data);


        //$ultimoID = model('BoletasModel')->insertID();

        $ultimoID = (string) model('BoletasModel')->insertID();

        $qrtext = $ultimoID;

        $path = 'images/';
        $qrcode = $path .  1 . ".png";
        $qrimage = time() . ".png";

        $model = model('boletasModel');
        $numero_factura = $model->set('nombre_qr', $qrtext . ".png");
        $numero_factura = $model->where('id', $ultimoID);
        $numero_factura = $model->update();


        if ($_POST['localidad'] != "General") {
            /* $borrar_localidad = model('localidadModel')->where('id', $_POST['localidad']);
            $borrar_localidad->delete(); */

            $num_fact = model('localidadModel');
            $numero_factura = $num_fact->set('estado', 'f');
            $numero_factura = $num_fact->where('id', $_POST['localidad']);
            $numero_factura = $num_fact->update();
        }



        QRcode::png($qrtext, $qrcode, 'H', 10, 10);



        return view('boletas/listado');
    }


    function consultar_boleta()
    {
        return view('boletas/consultar_codigo');
    }


    function cliente()
    {


        $data = [
            'nitcliente' => $this->request->getPost('cedula'),
            'idregimen' => 2,
            'nombrescliente' => $this->request->getPost('nombre'),
            'telefonocliente' => $this->request->getPost('telefono'),
            'celularcliente' => $this->request->getPost('telefono'),
            'emailcliente' => "",
            'idciudad' => 317,
            'direccioncliente' => "",
            'estadocliente' => true,
            'idtipo_cliente' => 1,
            'punto' => 0,
            'id_clasificacion' => 1
        ];


        $insert = model('clientesModel')->insert($data);


        $returnData = array(
            "resultado" => 1, //Falta plata 
            "nit_cliente" => $this->request->getPost('cedula'),
            "nombre_cliente" => $this->request->getPost('nombre')
        );
        echo  json_encode($returnData);
    }


    function actualizar_producto_porcentaje()
    {
        $id_producto = $this->request->getPost('id_producto_pedido');

        $id_usuario = $this->request->getPost('id_usuario');


        $porcentaje_producto = $this->request->getPost('valor');
        $codigo_interno = model('productoPedidoModel')->select('codigointernoproducto')->where('id', $id_producto)->first();

        $valor_unitario = model('productoModel')->select('valorventaproducto')->where('codigointernoproducto',  $codigo_interno['codigointernoproducto'])->first();
        $cantidad = model('productoPedidoModel')->select('cantidad_producto')->where('id', $id_producto)->first();

        // Calcula el valor total usando la fórmula
        $valor_total = $valor_unitario['valorventaproducto'] * (1 - ($porcentaje_producto / 100));
        $total =  $valor_total * $cantidad['cantidad_producto'];

        $model = model('productoPedidoModel');
        $actualizar = $model->set('valor_unitario', $total);
        $actualizar = $model->set('valor_total', $total * $cantidad['cantidad_producto']);
        $actualizar = $model->where('id', $id_producto);
        $actualizar = $model->update();


        $numero_pedido = model('productoPedidoModel')->select('numero_de_pedido')->where('id', $id_producto)->first();

        $total_pedido = model('productoPedidoModel')->selectSum('valor_total')->where('numero_de_pedido', $numero_pedido['numero_de_pedido'])->findAll();

        $model = model('pedidoModel');
        $actualizar = $model->set('valor_total', $total_pedido[0]['valor_total']);
        $actualizar = $model->where('id',  $numero_pedido['numero_de_pedido']);
        $actualizar = $model->update();

        $returnData = array(
            "resultado" => 1, //Falta plata 
            "total" => number_format($total, 0, ',', '.')
        );
        echo  json_encode($returnData);
    }

    function editar_precio_producto()
    {
        $id_producto = $this->request->getPost('id_producto_pedido');
        $precio  = $this->request->getPost('valor');





        if ($precio >= 0) {


            $cantidad = model('productoPedidoModel')->select('cantidad_producto')->where('id', $id_producto)->first();


            $model = model('productoPedidoModel');
            $actualizar = $model->set('valor_unitario', $precio);
            $actualizar = $model->set('valor_total', $precio * $cantidad['cantidad_producto']);
            $actualizar = $model->where('id', $id_producto);
            $actualizar = $model->update();

            $numero_pedido = model('productoPedidoModel')->select('numero_de_pedido')->where('id', $id_producto)->first();

            $total_pedido = model('productoPedidoModel')->selectSum('valor_total')->where('numero_de_pedido', $numero_pedido['numero_de_pedido'])->findAll();

            $model = model('pedidoModel');
            $actualizar = $model->set('valor_total', $total_pedido[0]['valor_total']);
            $actualizar = $model->where('id',  $numero_pedido['numero_de_pedido']);
            $actualizar = $model->update();

            $returnData = array(
                "resultado" => 1, //Falta plata 
                "precio_producto" => number_format($precio, 0, ',', '.')
            );
            echo  json_encode($returnData);
        }
    }


    function lista_precios()
    {
        $id_producto = $this->request->getPost('id_producto_pedido');
        $codigo_interno = model('productoPedidoModel')->select('codigointernoproducto')->where('id', $id_producto)->first();

        $valor_venta = model('productoModel')->select('valorventaproducto')->where('codigointernoproducto', $codigo_interno['codigointernoproducto'])->first();
        $descto_mayor = model('productoModel')->select('descto_mayor')->where('codigointernoproducto', $codigo_interno['codigointernoproducto'])->first();

        $temp_precio_2 = ($descto_mayor['descto_mayor'] * $valor_venta['valorventaproducto']) / 100;
        $precio_2 = $valor_venta['valorventaproducto'] - $temp_precio_2;

        $returnData = array(
            "resultado" => 1, //Falta plata 
            "precio_1" => "$ " . number_format($valor_venta['valorventaproducto'], 0, ',', '.'),
            "precio_2" => "$ " . number_format($precio_2, 0, ',', '.')
        );
        echo  json_encode($returnData);
    }

    function cortesia()
    {
        $id_producto = $this->request->getPost('id_producto_pedido');
        $codigo_interno = model('productoPedidoModel')->select('codigointernoproducto')->where('id', $id_producto)->first();

        $returnData = array(
            "resultado" => 1, //Falta plata 

        );
        echo  json_encode($returnData);
    }

    function cerrar_modal()
    {
        $id_mesa = $this->request->getPost('id_mesa');

        $numero_pedido = model('pedidoModel')->select('id')->where('fk_mesa', $id_mesa)->first();

        $productos_pedido = model('productoPedidoModel')->producto_pedido($numero_pedido['id']);
        $total_pedido = model('pedidoModel')->select('valor_total')->where('id', $numero_pedido['id'])->first();


        $returnData = array(
            "resultado" => 1,

            "productos" => view('pedidos/productos_pedido', [
                "productos" => $productos_pedido,
            ]),
            "total_pedido" =>  "$" . number_format($total_pedido['valor_total'], 0, ',', '.'),


        );
        echo  json_encode($returnData);
    }


    function descontar_dinero()
    {
        $id_producto = $this->request->getPost('id_producto_pedido');
        $valor_descontar = $this->request->getPost('valor');
        $codigo_interno = model('productoPedidoModel')->select('codigointernoproducto')->where('id', $id_producto)->first();
        $valor_unitario = model('productoModel')->select('valorventaproducto')->where('codigointernoproducto',  $codigo_interno['codigointernoproducto'])->first();
        $cantidad = model('productoPedidoModel')->select('cantidad_producto')->where('id', $id_producto)->first();

        if ($valor_descontar > 0 && $valor_descontar <= $valor_unitario['valorventaproducto']) {
            $nuevo_precio = $valor_unitario['valorventaproducto'] - $valor_descontar;

            $model = model('productoPedidoModel');
            $actualizar = $model->set('valor_unitario', $nuevo_precio);
            $actualizar = $model->set('valor_total', $nuevo_precio * $cantidad['cantidad_producto']);
            $actualizar = $model->where('id',  $id_producto);
            $actualizar = $model->update();


            $numero_pedido = model('productoPedidoModel')->select('numero_de_pedido')->where('id', $id_producto)->first();

            $total = model('productoPedidoModel')->selectSum('valor_total')->where('numero_de_pedido', $numero_pedido['numero_de_pedido'])->findAll();


            $model = model('pedidoModel');
            $pedido = $model->set('valor_total', $total[0]['valor_total']);
            $pedido = $model->where('id', $numero_pedido['numero_de_pedido']);
            $pedido = $model->update();


            $returnData = array(
                "resultado" => 1, //Falta plata 
                "precio_producto" => number_format($nuevo_precio, 0, ',', '.')
            );
            echo  json_encode($returnData);
        }
    }


    function nombre_producto()
    {
        $id_producto = $this->request->getPost('id_producto_pedido');
        $codigo_interno = model('productoPedidoModel')->select('codigointernoproducto')->where('id', $id_producto)->first();
        $nombre_producto = model('productoModel')->select('nombreproducto')->where('codigointernoproducto',  $codigo_interno['codigointernoproducto'])->first();
        $returnData = array(
            "resultado" => 1, //Falta plata 
            "nombre_producto" => "¿Esta seguro de generar cortesia para el producto: " . $nombre_producto['nombreproducto'] . "?"
        );
        echo  json_encode($returnData);
    }


    function generar_cortesia()
    {

        $id_producto = $this->request->getPost('id_producto_pedido');
        $codigo_interno = model('productoPedidoModel')->select('codigointernoproducto')->where('id', $id_producto)->first();
        $nombre_producto = model('productoModel')->select('nombreproducto')->where('codigointernoproducto',  $codigo_interno['codigointernoproducto'])->first();

        $model = model('productoPedidoModel');
        $actualizar = $model->set('valor_unitario', 0);
        $actualizar = $model->set('valor_total', 0);
        $actualizar = $model->where('id',  $id_producto);
        $actualizar = $model->update();

        $numero_pedido = model('productoPedidoModel')->select('numero_de_pedido')->where('id', $id_producto)->first();

        $total = model('productoPedidoModel')->selectSum('valor_total')->where('numero_de_pedido', $numero_pedido['numero_de_pedido'])->findAll();


        $model = model('pedidoModel');
        $pedido = $model->set('valor_total', $total[0]['valor_total']);
        $pedido = $model->where('id', $numero_pedido['numero_de_pedido']);
        $pedido = $model->update();

        $productos_pedido = model('productoPedidoModel')->producto_pedido($numero_pedido['numero_de_pedido']);
        $total_pedido = model('pedidoModel')->select('valor_total')->where('id', $numero_pedido['numero_de_pedido'])->first();


        $returnData = array(
            "resultado" => 1, //Falta plata 
            "nombre_producto" => "¿Esta seguro de generar cortesia para el producto: " . $nombre_producto['nombreproducto'] . "?",
            "productos" => view('pedidos/productos_pedido', [
                "productos" => $productos_pedido,
            ]),
            "total_pedido" =>  "$" . number_format($total_pedido['valor_total'], 0, ',', '.'),
        );
        echo  json_encode($returnData);
    }

    function asignar_p1()
    {

        $valor = $this->request->getPost('valor');
        $id_producto = $this->request->getPost('id_producto_pedido');
        $codigo_interno = model('productoPedidoModel')->select('codigointernoproducto')->where('id', $id_producto)->first();

        $valor_venta = model('productoModel')->select('valorventaproducto')->where('codigointernoproducto', $codigo_interno['codigointernoproducto'])->first();
        $descto_mayor = model('productoModel')->select('descto_mayor')->where('codigointernoproducto', $codigo_interno['codigointernoproducto'])->first();
        $cantidad = model('productoPedidoModel')->select('cantidad_producto')->where('id', $id_producto)->first();


        $temp_precio_2 = ($descto_mayor['descto_mayor'] * $valor_venta['valorventaproducto']) / 100;
        $precio_2 = $valor_venta['valorventaproducto'] - $temp_precio_2;
        $numero_pedido = model('productoPedidoModel')->select('numero_de_pedido')->where('id', $id_producto)->first();
        $model = model('productoPedidoModel');
        if ($valor == 1) {

            $actualizar = $model->set('valor_unitario', $valor_venta['valorventaproducto']);
            $actualizar = $model->set('valor_total', $valor_venta['valorventaproducto'] * $cantidad['cantidad_producto']);
            $actualizar = $model->where('id',  $id_producto);
            $actualizar = $model->update();
        }
        if ($valor == 2) {

            $actualizar = $model->set('valor_unitario', $precio_2);
            $actualizar = $model->set('valor_total', $precio_2 * $cantidad['cantidad_producto']);
            $actualizar = $model->where('id',  $id_producto);
            $actualizar = $model->update();
        }

        $total_pedido = model('productoPedidoModel')->selectSum('valor_total')->where('numero_de_pedido', $numero_pedido['numero_de_pedido'])->findAll();
        $model = model('pedidoModel');
        $actualizar = $model->set('valor_total', $total_pedido[0]['valor_total']);
        $actualizar = $model->where('id',  $numero_pedido['numero_de_pedido']);
        $actualizar = $model->update();

        $returnData = array(
            "resultado" => 1, //Falta plata 

        );
        echo  json_encode($returnData);
    }

    function municipios()
    {
        //$id_departamento = '749';
        //$id_departamento = 751; 
        $id_departamento = $this->request->getPost('valorSelect1');
        // $id_departamento = strval($id_departamento);


        $code_depto = model('departamentoModel')->select('code')->where('iddepartamento', $id_departamento)->first();

        //dd( $id_depto);

        // Supongamos que tienes un modelo que obtiene las opciones en función del valor seleccionado.
        $municipios = model('municipiosModel')->where('code_depto', $code_depto['code'])->orderBy('nombre', 'asc')->findAll();

        $ciudad = model('ciudadModel')->where('iddepartamento', $id_departamento)->orderBy('nombreciudad', 'asc')->findAll();



        $returnData = array(
            "resultado" => 1, //Falta plata
            'municipios' => view('municipios/municipios', [
                'municipios' => $municipios
            ]),
            'ciudad' => view('municipios/ciudad', [
                'ciudad' => $ciudad
            ])

        );
        echo  json_encode($returnData);




        /* 
       $data = array(
            'municipios' => view('municipios/municipios', [
                'municipios' => $municipios
            ]),
            'ciudad' => view('municipios/ciudad', [
                'ciudad' => $ciudad
            ])
        );  */

        /*  $data = array();

        foreach ($municipios as $opcion) {
            $data[] = array(
                'value' => $opcion['idciudad'], // Reemplaza 'id' con el campo adecuado de tu base de datos.
                'text' => $opcion['nombreciudad'], // Reemplaza 'nombre' con el campo adecuado de tu base de datos.
            );
        } */

        //return $this->response->setJSON($data);

    }

    function ciudad()
    {
        $code_departamento = $this->request->getPost('valorSelect1');

        // Supongamos que tienes un modelo que obtiene las opciones en función del valor seleccionado.
        $municipios = model('municipiosModel')->where('iddepartamento', $code_departamento)->findAll();

        $data = array();

        foreach ($municipios as $opcion) {
            $data[] = array(
                'value' => $opcion['idciudad'], // Reemplaza 'id' con el campo adecuado de tu base de datos.
                'text' => $opcion['nombreciudad'], // Reemplaza 'nombre' con el campo adecuado de tu base de datos.
            );
        }

        return $this->response->setJSON($data);
    }


    function cancelar_descuentos()
    {
        $id_producto = $this->request->getPost('id_producto_pedido');
        $codigo_interno = model('productoPedidoModel')->select('codigointernoproducto')->where('id', $id_producto)->first();

        $valor_venta = model('productoModel')->select('valorventaproducto')->where('codigointernoproducto', $codigo_interno['codigointernoproducto'])->first();
        $cantidad = model('productoPedidoModel')->select('cantidad_producto')->where('id', $id_producto)->first();
        $model = model('productoPedidoModel');
        $actualizar = $model->set('valor_unitario', $valor_venta['valorventaproducto']);
        $actualizar = $model->set('valor_total', $valor_venta['valorventaproducto'] * $cantidad['cantidad_producto']);
        $actualizar = $model->where('id',  $id_producto);
        $actualizar = $model->update();

        $returnData = array(
            "resultado" => 1, //Falta plata 

        );
        echo  json_encode($returnData);
    }

    function valor()
    {

        $id_mesa = $this->request->getPost('id_mesa');

        $propina = model('pedidoModel')->select('propina')->where('fk_mesa', $id_mesa)->first();
        $total = model('pedidoModel')->select('valor_total')->where('fk_mesa', $id_mesa)->first();


        $returnData = array(
            "resultado" => 1, //Falta plata 
            "propina" => number_format($propina['propina'], 0, ",", "."),
            "sub_total" => number_format($total['valor_total'], 0, ",", "."),
            "total" => number_format($total['valor_total'] + $propina['propina'], 0, ",", ".")
        );
        echo  json_encode($returnData);
    }

    function editar_cantidades()
    {
        //$id_tabla_producto= 2425;
        $id_tabla_producto = $this->request->getPost('id');

        $codigo_interno_producto = model('productoPedidoModel')->select('codigointernoproducto')->where('id', $id_tabla_producto)->first();
        $cantidad_producto = model('productoPedidoModel')->select('cantidad_producto')->where('id', $id_tabla_producto)->first();
        $valor_unitario = model('productoPedidoModel')->select('valor_unitario')->where('id', $id_tabla_producto)->first();
        $valor_total = model('productoPedidoModel')->select('valor_total')->where('id', $id_tabla_producto)->first();
        $nombre_producto = model('productoModel')->select('nombreproducto')->where('codigointernoproducto', $codigo_interno_producto['codigointernoproducto'])->first();

        $returnData = array(
            "resultado" => 1, //Falta plata 
            "producto_cantidad" => view('pedidos/editar_cantidades', [
                'cantidad' => $cantidad_producto['cantidad_producto'],
                'nombre_producto' => $nombre_producto['nombreproducto'],
                'valor_unitario' => "$ " . number_format($valor_unitario['valor_unitario'], 0, ",", "."),
                'valor_total' => "$ " . number_format($valor_total['valor_total'], 0, ",", "."),
                'id_tabla_producto' => $id_tabla_producto
            ])
        );
        echo  json_encode($returnData);
    }

    /*  function actualizar_cantidades()
    {
        $id_tabla_producto = $this->request->getPost('id_producto');
        $cantidad_actualizar = $this->request->getPost('cantidad_producto');
        $id_usuario = $this->request->getPost('id_usuario');
        $numero_pedido = model('productoPedidoModel')->select('numero_de_pedido')->where('id', $id_tabla_producto)->first();
        $tipo_usuario = model('usuariosModel')->select('idtipo')->where('idusuario_sistema', $id_usuario)->first();

        $cantidad_producto = model('productoPedidoModel')->select('cantidad_producto')->where('id', $id_tabla_producto)->first();
        $cantidad_impresos = model('productoPedidoModel')->select('numero_productos_impresos_en_comanda')->where('id', $id_tabla_producto)->first();
        $valor_unitario  = model('productoPedidoModel')->select('valor_unitario')->where('id', $id_tabla_producto)->first();

       // echo $cantidad_impresos['numero_productos_impresos_en_comanda'] . "</br>";
        //echo $cantidad_producto['cantidad_producto'] . "</br>";

        if ($cantidad_actualizar > $cantidad_producto['cantidad_producto']) {


            $model = model('productoPedidoModel');
            $actualizar = $model->set('valor_total', $valor_unitario['valor_unitario'] * $cantidad_actualizar);
            $actualizar = $model->set('cantidad_producto', $cantidad_actualizar);
            $actualizar = $model->where('id', $id_tabla_producto);
            $actualizar = $model->update();
        }

        if ($cantidad_actualizar < $cantidad_producto['cantidad_producto']) {
            if ($cantidad_actualizar  > 0) {

                $actualizar = $cantidad_impresos['numero_productos_impresos_en_comanda'] - $cantidad_actualizar;
                echo $actualizar;
                exit();
            }
        }

        if ($cantidad_impresos['numero_productos_impresos_en_comanda'] == $cantidad_producto['cantidad_producto']) {
            $returnData = array(
                "resultado" => 0,  // Se actulizo el registro 
            );
            echo  json_encode($returnData);
        }

        $productos_pedido = model('productoPedidoModel')->producto_pedido($numero_pedido['numero_de_pedido']);
        $total_pedido = model('pedidoModel')->select('valor_total')->where('id', $numero_pedido['numero_de_pedido'])->first();
        $cantidad_de_productos = model('pedidoModel')->select('cantidad_de_productos')->where('id', $numero_pedido['numero_de_pedido'])->first();
        $productos_del_pedido = view('pedidos/productos_pedido', [
            "productos" => $productos_pedido,
            "pedido" => $numero_pedido['numero_de_pedido']
        ]);

        $returnData = array(
            "resultado" => 1,  // Se actulizo el registro 
            "productos" => $productos_del_pedido,
            "total_pedido" =>  "$" . number_format($total_pedido['valor_total'], 0, ',', '.'),
            "cantidad_de_pruductos" => $cantidad_de_productos['cantidad_de_productos']
        );
        echo  json_encode($returnData);
    } */



    function actualizar_cantidades()
    {
        $id_tabla_producto = $this->request->getPost('id_producto');
        $cantidad_actualizar = $this->request->getPost('cantidad_producto');
        $id_usuario = $this->request->getPost('id_usuario');
        $numero_pedido = model('productoPedidoModel')->select('numero_de_pedido')->where('id', $id_tabla_producto)->first();
        $tipo_usuario = model('usuariosModel')->select('idtipo')->where('idusuario_sistema', $id_usuario)->first();

        $cantidad_producto = model('productoPedidoModel')->select('cantidad_producto')->where('id', $id_tabla_producto)->first();
        $cantidad_impresos = model('productoPedidoModel')->select('numero_productos_impresos_en_comanda')->where('id', $id_tabla_producto)->first();
        $valor_unitario  = model('productoPedidoModel')->select('valor_unitario')->where('id', $id_tabla_producto)->first();

        // echo $cantidad_impresos['numero_productos_impresos_en_comanda'] . "</br>";
        //echo $cantidad_producto['cantidad_producto'] . "</br>";
        $model_pedido = model('pedidoModel');

        if ($cantidad_actualizar > $cantidad_producto['cantidad_producto']) {


            $model = model('productoPedidoModel');
            /*  $actualizar = $model->set('valor_total', $valor_unitario['valor_unitario'] * $cantidad_actualizar);
            $actualizar = $model->set('cantidad_producto', $cantidad_actualizar);
            $actualizar = $model->where('id', $id_tabla_producto);
            $actualizar = $model->update(); */

            $cantidades = [
                'valor_total' => $cantidad_actualizar * $valor_unitario['valor_unitario'],
                'cantidad_producto' => $cantidad_actualizar
            ];

            $actualizar = model('productoPedidoModel')->actualizacion_cantidad_producto($id_tabla_producto, $cantidades);


            $total_pedido = $model->selectSum('valor_total')->where('numero_de_pedido', $numero_pedido['numero_de_pedido'])->find();


            $actualizacion = $model_pedido->set('valor_total', $total_pedido[0]['valor_total']);

            $actualizacion = $model_pedido->where('id', $numero_pedido['numero_de_pedido']);
            $actualizacion = $model_pedido->update();

            $resultado = 1;
        }

        if ($cantidad_actualizar < $cantidad_producto['cantidad_producto']) {



            if ($tipo_usuario['idtipo'] == 1 || $tipo_usuario['idtipo'] == 0) {
                $cantidades = [
                    'valor_total' => $cantidad_actualizar * $valor_unitario['valor_unitario'],
                    'cantidad_producto' => $cantidad_actualizar
                ];

                $actualizar = model('productoPedidoModel')->actualizacion_cantidad_producto($id_tabla_producto, $cantidades);
                $model = model('productoPedidoModel');
                $total_pedido = $model->selectSum('valor_total')->where('numero_de_pedido', $numero_pedido['numero_de_pedido'])->find();

                $model_pedido = model('pedidoModel');
                $actualizacion = $model_pedido->set('valor_total', $total_pedido[0]['valor_total']);

                $actualizacion = $model_pedido->where('id', $numero_pedido['numero_de_pedido']);
                $actualizacion = $model_pedido->update();

                $resultado = 1;
            }

            if ($tipo_usuario['idtipo'] == 2) {

                if ($cantidad_actualizar > $cantidad_impresos['numero_productos_impresos_en_comanda']) {

                    $cantidades = [
                        'valor_total' => $cantidad_actualizar * $valor_unitario['valor_unitario'],
                        'cantidad_producto' => $cantidad_actualizar
                    ];

                    $actualizar = model('productoPedidoModel')->actualizacion_cantidad_producto($id_tabla_producto, $cantidades);
                    $model = model('productoPedidoModel');
                    $total_pedido = $model->selectSum('valor_total')->where('numero_de_pedido', $numero_pedido['numero_de_pedido'])->find();

                    $model_pedido = model('pedidoModel');
                    $actualizacion = $model_pedido->set('valor_total', $total_pedido[0]['valor_total']);

                    $actualizacion = $model_pedido->where('id', $numero_pedido['numero_de_pedido']);
                    $actualizacion = $model_pedido->update();

                    $resultado = 1;
                }
                if ($cantidad_actualizar < $cantidad_impresos['numero_productos_impresos_en_comanda']) {
                    $resultado = 0;
                }
            }
        }

        if ($cantidad_impresos['numero_productos_impresos_en_comanda'] == $cantidad_producto['cantidad_producto']) {
            $resultado = 0;
        }

        if ($resultado == 1) {
            $productos_pedido = model('productoPedidoModel')->producto_pedido($numero_pedido['numero_de_pedido']);
            $total_pedido = model('pedidoModel')->select('valor_total')->where('id', $numero_pedido['numero_de_pedido'])->first();
            $cantidad_de_productos = model('pedidoModel')->select('cantidad_de_productos')->where('id', $numero_pedido['numero_de_pedido'])->first();
            $productos_del_pedido = view('pedidos/productos_pedido', [
                "productos" => $productos_pedido,
                "pedido" => $numero_pedido['numero_de_pedido']
            ]);

            $returnData = array(
                "resultado" => 1,  // Se actulizo el registro 
                "productos_pedido" => $productos_del_pedido,
                "total_pedido" =>  "$" . number_format($total_pedido['valor_total'], 0, ',', '.'),
                "cantidad_de_pruductos" => $cantidad_de_productos['cantidad_de_productos'],
                "numero_pedido" => $numero_pedido['numero_de_pedido']
            );
            echo  json_encode($returnData);
        }
        if ($resultado == 0) {
            $returnData = array(
                "resultado" => 0,  // Se actulizo el registro 

            );
            echo  json_encode($returnData);
        }
    }

    function consultar_ventas()
    {


        $estado = model('estadoModel')->where('estado', 'true')->orderBy('orden', 'asc')->findAll();
        //$estado = model('estadoModel')->findAll();
        return view('ventas/ventas', [
            'estado' => $estado
        ]);
    }

    function documento()
    {
        $id_documento = $this->request->getPost('tipo_documento');
        // $id_documento = 8;

        $nombre_documento = model('estadoModel')->select('descripcionestado')->where('idestado', $id_documento)->first();

        $fecha_inicial = $this->request->getPost('fecha_inicial');
        $fecha_final = $this->request->getPost('fecha_final');


        if ($id_documento == 2) {  //Documento credito
            $consulta = "select * from pagos where id_estado= $id_documento and saldo > 0 
           ";
        }
        if ($id_documento != 2) {  //Documentos de contado 
            $consulta = "select * from pagos where id_estado= $id_documento 
           ";
        }

        if ($id_documento == 8) {  //Documento electronico 
            $consulta = "select * from documento_electronico  
           ";
        }


        $documentos = model('pagosModel')->get_ventas_credito($consulta);



        $saldo = model('pagosModel')->get_saldo($id_documento);


        if ($id_documento != 8) {
            $returnData = array(
                "resultado" => 1,  // Se actulizo el registro 
                "datos" => view('consultar_ventas/documento', [
                    'documentos' => $documentos,
                    'titulo' => "LISTADO COMPLETO DE VENTAS " . $nombre_documento['descripcionestado'],
                    'id_estado' => $id_documento,
                    'saldo' => "$ " . number_format($saldo[0]['saldo'], 0, ",", ".")
                ])

            );
            echo  json_encode($returnData);
        }
        if ($id_documento == 8) {
            $returnData = array(
                "resultado" => 1,  // Se actulizo el registro 
                "datos" => view('consultar_ventas/documento_electronico', [
                    'documentos' => $documentos,
                    'titulo' => "LISTADO COMPLETO DE VENTAS " . $nombre_documento['descripcionestado'],
                    'id_estado' => $id_documento,
                    'saldo' => "$ " . number_format($saldo[0]['saldo'], 0, ",", ".")
                ])

            );
            echo  json_encode($returnData);
        }



    }

    function numero_documento()
    {
        $numero_documento = $this->request->getPost('numero_factura');

        $factura = model('pagosModel')->get_documento($numero_documento);


        if (!empty($factura)) {
            $returnData = array(
                "resultado" => 1,  // Se actulizo el registro 


            );
            echo  json_encode($returnData);
        }
        if (empty($factura)) {
            $returnData = array(
                "resultado" => 0,  // Se actulizo el registro 

            );
            echo  json_encode($returnData);
        }
    }

    function get_cliente()
    {

        echo "Hola mundo ";
    }
}
