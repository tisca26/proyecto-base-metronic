<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include("Acl_controller.php");

class Clientes extends Acl_controller
{
    private $template_base = 'index';

    function __construct()
    {
        parent::__construct();

        $this->set_read_list(array('index'));
        $this->set_insert_list(array('insertar_cliente', 'form_insert'));
        $this->set_update_list(array('editar_cliente', 'form_edit'));
        $this->set_delete_list(array('borrar_cliente'));

        $this->check_access();

        $this->load->model('clientes_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->cargar_idioma->carga_lang('clientes/clientes_index');
        $data = array();
        $data['rows'] = $this->clientes_model->clientes_todos();
        $template['_B'] = 'clientes/clientes_index.php';
        $this->load->template_view($this->template_base, $data, $template);
    }

    public function form_insert()
    {
        $this->cargar_idioma->carga_lang('clientes/clientes_insertar');
        $data = array();
        $template['_B'] = 'clientes/clientes_insertar.php';
        $this->load->template_view($this->template_base, $data, $template);
    }

    public function insertar_cliente()
    {
        $this->cargar_idioma->carga_lang('clientes/clientes_insertar');
        $this->form_validation->set_rules('razon_social', trans_line('razon_social'), 'required|trim|min_length[3]');
        $this->form_validation->set_rules('email', trans_line('email'), 'required|trim|min_length[3]|valid_email');
        if ($this->form_validation->run() == FALSE) {
            $this->form_insert();
        } else {
            $cliente = $this->input->post();
            if ($this->clientes_model->insertar_cliente($cliente) == TRUE) {
                set_bootstrap_alert(trans_line('alerta_exito'), BOOTSTRAP_ALERT_SUCCESS);
                return redirect('clientes/form_insert');
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
        $this->cargar_idioma->carga_lang('clientes/clientes_editar');
        $data = array();
        $data['cli'] = $this->clientes_model->cliente_por_id($id);
        $template['_B'] = 'clientes/clientes_editar.php';
        $this->load->template_view($this->template_base, $data, $template);
    }

    public function editar_cliente()
    {
        $this->cargar_idioma->carga_lang('clientes/clientes_editar');
        $this->form_validation->set_rules('razon_social', trans_line('razon_social'), 'required|trim|min_length[3]');
        $this->form_validation->set_rules('email', trans_line('email'), 'required|trim|min_length[3]|valid_email');
        $id = $this->input->post('clientes_id');
        if ($this->form_validation->run() == FALSE) {
            $this->form_edit($id);
        } else {
            $cliente = $this->input->post();
            if ($this->clientes_model->editar_cliente($cliente) == TRUE) {
                set_bootstrap_alert(trans_line('alerta_exito'), BOOTSTRAP_ALERT_SUCCESS);
                return redirect('clientes');
            } else {
                $error = $this->resources_model->error_consulta();
                $mensajes_error = array(trans_line('alerta_error'), trans_line('alerta_error_codigo') . base64_encode($error['message']));
                set_bootstrap_alert($mensajes_error, BOOTSTRAP_ALERT_DANGER);
                return $this->form_edit($id);
            }
        }
    }

    public function borrar_cliente($id = 0)
    {
        $this->cargar_idioma->carga_lang('clientes/clientes_index');
        if ($this->clientes_model->borrar_cliente($id) != FALSE){
            set_bootstrap_alert(trans_line('alerta_borrado'), BOOTSTRAP_ALERT_SUCCESS);
            return redirect('clientes');
        }else{
            $error = $this->resources_model->error_consulta();
            $mensajes_error = array(trans_line('alerta_borrado_fail'), trans_line('alerta_error_codigo') . base64_encode($error['message']));
            set_bootstrap_alert($mensajes_error, BOOTSTRAP_ALERT_DANGER);
        }
        redirect('clientes');
    }
}