<?php

namespace App\Controllers\fechas;
use App\Controllers\BaseController;

class Fechas extends BaseController
{
    public function Mostrar_dias_cobrables()
    {
        
        return view('dias_no_cobro/dias_no_cobro');
    }
}
