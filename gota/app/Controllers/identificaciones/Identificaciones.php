<?php

namespace App\Controllers\identificaciones;

use App\Controllers\BaseController;

class Identificaciones extends BaseController
{
    public function get_todos()
    {

        if (!isset($_GET['palabraClave'])) {
            $identificaciones = model('Identificaciones')->findAll();
        } else {
            $buscar = $_GET['palabraClave'];
            $identificaciones = model('tercerosModel')->buscar_identificaciones($buscar);
        }
        $response = [];

        foreach ($identificaciones as $detalle) {
            $response[] = [
                'id' => $detalle['id'],
                'text' => $detalle['nombre'],
            ];
        }

        echo json_encode($response);
    }
}
