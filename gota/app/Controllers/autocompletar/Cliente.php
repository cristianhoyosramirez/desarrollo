<?php

namespace App\Controllers\autocompletar;

use App\Controllers\BaseController;

class Cliente extends BaseController
{
    public function index()
    {
        $returnData = array();
        $valor = $this->request->getVar('term');

        $resultado = model('Cliente')->buscar_cliente($valor);

        if (!empty($resultado)) {
            foreach ($resultado as $row) {
                $data['value'] =  $row['numero_identificacion']." ".$row['nombres'];
                $data['id'] = $row['id_cliente'];
                array_push($returnData, $data);
            }
            echo json_encode($returnData);
        } else {
            $data['value'] = "No hay resultados";
            array_push($returnData, $data);
            echo json_encode($returnData);
        }
    }
}
