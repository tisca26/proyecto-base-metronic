<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include("Acl_controller.php");

class Proveedores extends Acl_controller
{
    private $template_base = 'index';

    function __construct()
    {
        parent::__construct();

        $this->set_read_list(array('index'));
        $this->set_insert_list(array('insertar_proveedor', 'form_insert'));
        $this->set_update_list(array('editar_proveedor', 'form_edit'));
        $this->set_delete_list(array('borrar_proveedor'));

        $this->check_access();

        $this->load->model('proveedores_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->cargar_idioma->carga_lang('proveedores/proveedores_index');
        $data = array();
        $data['rows'] = $this->proveedores_model->proveedores_todos();
        $template['_B'] = 'proveedores/proveedores_index.php';
        $this->load->template_view($this->template_base, $data, $template);
    }

    public function form_insert()
    {
        $this->cargar_idioma->carga_lang('proveedores/proveedores_insertar');
        $data = array();
        $template['_B'] = 'proveedores/proveedores_insertar.php';
        $this->load->template_view($this->template_base, $data, $template);
    }

    public function insertar_proveedor()
    {
        $this->cargar_idioma->carga_lang('proveedores/proveedores_insertar');
        $this->form_validation->set_rules('razon_social', trans_line('razon_social'), 'required|trim|min_length[3]');
        $this->form_validation->set_rules('email', trans_line('email'), 'required|trim|min_length[3]|valid_email');
        if ($this->form_validation->run() == FALSE) {
            $this->form_insert();
        } else {
            $proveedor = $this->input->post();
            if ($this->proveedores_model->insertar_proveedor($proveedor) == TRUE) {
                set_bootstrap_alert(trans_line('alerta_exito'), BOOTSTRAP_ALERT_SUCCESS);
                return redirect('proveedores/form_insert');
            } else {
                $error = $this->resources_model->error_consulta();
                $mensajes_error = array(trans_line('alerta_error'), trans_line('alerta_error_codigo') . base64_encode($error['message']));
                set_bootstrap_alert($mensajes_error, BOOTSTRAP_ALERT_DANGER);
                return $this->form_insert();
            }
        }
    }

    public function form_edit($id = 0)
    {
        $this->cargar_idioma->carga_lang('proveedores/proveedores_editar');
        $data = array();
        $data['prov'] = $this->proveedores_model->proveedor_por_id($id);
        $template['_B'] = 'proveedores/proveedores_editar.php';
        $this->load->template_view($this->template_base, $data, $template);
    }

    public function editar_proveedor()
    {
        $this->cargar_idioma->carga_lang('proveedores/proveedores_editar');
        $this->form_validation->set_rules('razon_social', trans_line('razon_social'), 'required|trim|min_length[3]');
        $this->form_validation->set_rules('email', trans_line('email'), 'required|trim|min_length[3]|valid_email');
        $id = $this->input->post('proveedores_id');
        if ($this->form_validation->run() == FALSE) {
            $this->form_edit($id);
        } else {
            $proveedor = $this->input->post();
            if ($this->proveedores_model->editar_proveedor($proveedor) == TRUE) {
                set_bootstrap_alert(trans_line('alerta_exito'), BOOTSTRAP_ALERT_SUCCESS);
                return redirect('proveedores');
            } else {
                $error = $this->resources_model->error_consulta();
                $mensajes_error = array(trans_line('alerta_error'), trans_line('alerta_error_codigo') . base64_encode($error['message']));
                set_bootstrap_alert($mensajes_error, BOOTSTRAP_ALERT_DANGER);
                return $this->form_edit($id);
            }
        }
    }

    public function borrar_proveedor($id = 0)
    {
        $this->cargar_idioma->carga_lang('proveedores/proveedores_index');
        if ($this->proveedores_model->borrar_proveedor($id) != FALSE) {
            set_bootstrap_alert(trans_line('alerta_borrado'), BOOTSTRAP_ALERT_SUCCESS);
            return redirect('proveedores');
        } else {
            $error = $this->resources_model->error_consulta();
            $mensajes_error = array(trans_line('alerta_borrado_fail'), trans_line('alerta_error_codigo') . base64_encode($error['message']));
            set_bootstrap_alert($mensajes_error, BOOTSTRAP_ALERT_DANGER);
        }
        redirect('proveedores');
    }
}