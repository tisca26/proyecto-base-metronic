<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Cargar_elementos_manager
{
    private $CI;

    function __construct()
    {
        $this->CI = &get_instance();
    }

    function carga_simple($dir = '', $attr = array())
    {
        $this->CI->load->view($dir, $attr);
    }
}