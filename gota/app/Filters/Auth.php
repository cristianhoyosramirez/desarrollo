<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
    
        // Do something here
        if(!session('logged_in') == 'true') {
            $session = session();
            $session->setFlashdata('iconoMensaje', 'warning');
        	return redirect()->to(base_url('/'))->with('mensaje', 'Debes estar loguedo');
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}