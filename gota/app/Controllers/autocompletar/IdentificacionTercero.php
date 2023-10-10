<?php

namespace App\Controllers\autocompletar;

use App\Controllers\BaseController;

class IdentificacionTercero extends BaseController
{
    public function index()
    {
        $returnData = array();
        $valor = $this->request->getVar('term');

        $resultado = model('Tercero')->buscar_terceros($valor);

        if (!empty($resultado)) {
            foreach ($resultado as $row) {
                $data['value'] =  $row['numero_identificacion']." ".$row['nombres'];
                $data['id'] = $row['id'];
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
