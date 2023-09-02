<?php

namespace App\Controllers\pedidos;
use App\Controllers\BaseController;


class Inventarios extends BaseController
{
    public function ingreso()
    {
        return view('inventarios/ingreso');
    }
}
