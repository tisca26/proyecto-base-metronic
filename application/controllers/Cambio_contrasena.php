<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include("Acl_controller.php");

class Cambio_contrasena extends Acl_controller
{

    private $template_base = 'index';

    function __construct()
    {
        parent::__construct();

        $this->set_read_list(array('index'));
        $this->set_insert_list(array('cambio'));
        $this->set_update_list(array(''));
        $this->set_delete_list(array(''));

        $this->check_access();
        $this->load->model('cambiocontrasena_model');
        $this->load->library('form_validation');
        $this->load->model('logs_oe_model');
    }

    function index($data)
    {
        $datos_log['accion'] = 'Cambio contrasena view';
        $datos_log['id_elemento'] = $this->session->userdata('ID');
        $this->logs_oe_model->insertLogs($datos_log);

        $template['_B'] = 'cambiocontrasena/cambiocontrasena_view.php';
        $this->load->template_view($this->template_base, $data, $template);
    }

    function cambio()
    {
        $pass = $this->input->post('password');
        $repass = $this->input->post('repassword');

        if ($pass != $repass) {
            $data['message'] = 'Las contraseñas no son iguales';
            return $this->index($data);
        }

        $pass_final = sha1($pass);

        if (($this->cambiocontrasena_model->insertCambioContrasena($pass_final)) != FALSE) {
            $datos_log['accion'] = 'Cambio contraseña ok';
            $datos_log['id_elemento'] = $this->session->userdata('ID');
            $this->logs_oe_model->insertLogs($datos_log);

            $data['m_tipo'] = 'Ok CAMBIO';
            $data['m_titulo'] = 'Cambio de contraseña';
            $data['m_mensaje'] = 'La contraseña se modificó con éxito';
            $this->session->set_flashdata('m_tipo', $data['m_tipo']);
            $this->session->set_flashdata('m_titulo', $data['m_titulo']);
            $this->session->set_flashdata('m_mensaje', $data['m_mensaje']);
            redirect('cambio_contrasena/');
        } else {
            $data['message'] = 'Error';
            return $this->insert($data);
        }
    }

}

?>
