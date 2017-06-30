<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mensajes_sys extends CI_Controller
{

    public function index()
    {
        return $this->denegado();
    }

    public function denegado()
    {
        $this->load->view('mensajes_sys/mensajes_sys_400');
    }
}