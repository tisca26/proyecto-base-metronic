<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include("Acl_controller.php");

class Empresas extends Acl_controller
{
    private $template_base = 'index';

    function __construct()
    {
        parent::__construct();

        $this->set_read_list(array('index'));
        $this->set_insert_list(array('insertar_empresa', 'form_insert'));
        $this->set_update_list(array('editar_empresa', 'form_edit'));
        $this->set_delete_list(array('borrar_empresa'));

        $this->check_access();

        $this->load->model('empresas_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->cargar_idioma->carga_lang('empresas/empresas_index');
        $data = array();
        $data['rows'] = $this->empresas_model->empresas_todos();
        $template['_B'] = 'empresas/empresas_index.php';
        $this->load->template_view($this->template_base, $data, $template);
    }

    public function form_insert()
    {
        $this->cargar_idioma->carga_lang('empresas/empresas_insertar');
        $data = array();
        $template['_B'] = 'empresas/empresas_insertar.php';
        $this->load->template_view($this->template_base, $data, $template);
    }

    public function insertar_empresa()
    {
        $this->cargar_idioma->carga_lang('empresas/empresas_insertar');
        $this->form_validation->set_rules('razon_social', trans_line('razon_social'), 'required|trim|min_length[3]');
        $this->form_validation->set_rules('email', trans_line('email'), 'required|trim|min_length[3]|valid_email');
        if ($this->form_validation->run() == FALSE) {
            $this->form_insert();
        } else {
            $empresa = $this->input->post();
            if ($this->empresas_model->insertar_empresa($empresa) == TRUE) {
                set_bootstrap_alert(trans_line('alerta_exito'), BOOTSTRAP_ALERT_SUCCESS);
                return redirect('empresas/form_insert');
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
        $this->cargar_idioma->carga_lang('empresas/empresas_editar');
        $data = array();
        $data['empr'] = $this->empresas_model->empresa_por_id($id);
        $template['_B'] = 'empresas/empresas_editar.php';
        $this->load->template_view($this->template_base, $data, $template);
    }

    public function editar_empresa()
    {
        $this->cargar_idioma->carga_lang('empresas/empresas_editar');
        $this->form_validation->set_rules('razon_social', trans_line('razon_social'), 'required|trim|min_length[3]');
        $this->form_validation->set_rules('email', trans_line('email'), 'required|trim|min_length[3]|valid_email');
        $id = $this->input->post('empresas_id');
        if ($this->form_validation->run() == FALSE) {
            $this->form_edit($id);
        } else {
            $empresa = $this->input->post();
            if ($this->empresas_model->editar_empresa($empresa) == TRUE) {
                set_bootstrap_alert(trans_line('alerta_exito'), BOOTSTRAP_ALERT_SUCCESS);
                return redirect('empresas');
            } else {
                $error = $this->resources_model->error_consulta();
                $mensajes_error = array(trans_line('alerta_error'), trans_line('alerta_error_codigo') . base64_encode($error['message']));
                set_bootstrap_alert($mensajes_error, BOOTSTRAP_ALERT_DANGER);
                return $this->form_edit($id);
            }
        }
    }

    public function borrar_empresa($id = 0)
    {
        $this->cargar_idioma->carga_lang('empresas/empresas_index');
        if ($this->empresas_model->borrar_empresa($id) != FALSE){
            set_bootstrap_alert(trans_line('alerta_borrado'), BOOTSTRAP_ALERT_SUCCESS);
            return redirect('empresas');
        }else{
            $error = $this->resources_model->error_consulta();
            $mensajes_error = array(trans_line('alerta_borrado_fail'), trans_line('alerta_error_codigo') . base64_encode($error['message']));
            set_bootstrap_alert($mensajes_error, BOOTSTRAP_ALERT_DANGER);
        }
        redirect('empresas');
    }
}