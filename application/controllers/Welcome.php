<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include("Acl_controller.php");

class Welcome extends Acl_controller
{

    function __construct()
    {
        parent::__construct();
        log_message('debug', '------- ENTRAMOS A WELCOME -------');
        $this->set_read_list(array('index', 'otro'));
        $this->check_access();

    }

    public function index()
    {
        //$this->session->set_userdata('idioma_del_sitio', $this->encrypt->encode('english'));
        $this->cargar_idioma->carga_lang('welcome/inicio');
        //$data['line'] = $this->lang->line('inicio_msg');
        $data['line'] = trans_line('inicio_msg');
        $this->load->view('index', $data);
    }

    public function otro()
    {
        //$this->session->set_userdata('idioma_del_sitio', $this->encrypt->encode('english'));
        $this->cargar_idioma->carga_lang('welcome/inicio');
        //$data['line'] = $this->lang->line('inicio_msg');
        $data['line'] = trans_line('inicio_msg');
        $this->load->view('welcome_message', $data);
    }
}
