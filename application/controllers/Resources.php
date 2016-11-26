<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

include("Acl_controller.php");

class Resources extends Acl_controller
{

    private $template_base = 'index';

    function __construct()
    {
        parent::__construct();

        $this->set_read_list(array('index'));
        $this->set_insert_list(array('insert_resource', 'form_insert'));
        $this->set_update_list(array('edit_resource', 'form_edit'));
        $this->set_delete_list(array('delete_resource'));
        $this->check_access();
        $this->load->model('resources_model');
        $this->load->library('form_validation');
    }

    function index()
    {
        $this->cargar_idioma->carga_lang('resources/resources_index');
        $data = array();
        $data['rows'] = $this->resources_model->get_all();
        $template['_B'] = 'resources/resources_index.php';
        $this->load->template_view($this->template_base, $data, $template);

    }

    function insert_resource()
    {
        $this->cargar_idioma->carga_lang('resources/resources_inserta');
        $this->form_validation->set_rules('resourcename', trans_line('nombre_recurso'), 'required|trim|min_length[3]');
        if ($this->form_validation->run() == FALSE) {
            $this->form_insert();
        } else {
            $name = $this->input->post('resourcename');
            if ($this->resources_model->insert($name) == TRUE) {
                set_bootstrap_alert(trans_line('alerta_exito'), BOOTSTRAP_ALERT_SUCCESS);
                return redirect('resources/form_insert');
            } else {
                $error = $this->resources_model->error_consulta();
                $mensajes_error = array(trans_line('alerta_error'), trans_line('alerta_error_codigo') . base64_encode($error['message']));
                set_bootstrap_alert($mensajes_error, BOOTSTRAP_ALERT_DANGER);
                return $this->form_insert();
            }
        }
    }

    function edit_resource()
    {
        $this->cargar_idioma->carga_lang('resources/resources_edita');
        $this->form_validation->set_rules('resourcename', trans_line('nombre_recurso'), 'required|trim|min_length[3]');
        $id = $this->input->post('resourceid');
        if ($this->form_validation->run() == FALSE) {
            $this->form_edit($id);
        } else {
            $name = $this->input->post('resourcename');
            if ($this->resources_model->update($id, $name) == TRUE) {
                set_bootstrap_alert(trans_line('alerta_exito'), BOOTSTRAP_ALERT_SUCCESS);
                return redirect('resources/');
            } else {
                $error = $this->resources_model->error_consulta();
                $mensajes_error = array(trans_line('alerta_error'), trans_line('alerta_error_codigo') . base64_encode($error['message']));
                set_bootstrap_alert($mensajes_error, BOOTSTRAP_ALERT_DANGER);
                return $this->form_edit($id);
            }
        }
    }

    function delete_resource($id = 0)
    {
        $this->cargar_idioma->carga_lang('resources/resources_index');
        $this->resources_model->delete($id);
        set_bootstrap_alert(trans_line('alerta_borrado'), BOOTSTRAP_ALERT_SUCCESS);
        redirect('resources/');
    }

    function form_insert()
    {
        $this->cargar_idioma->carga_lang('resources/resources_inserta');
        $template['_B'] = 'resources/resources_insertar.php';
        $this->load->template_view($this->template_base, $template);
    }

    function form_edit($id = 0)
    {
        $this->cargar_idioma->carga_lang('resources/resources_edita');
        $data['resource'] = $this->resources_model->get_resource($id);
        $tamplate['_B'] = 'resources/resources_editar.php';
        $this->load->template_view($this->template_base, $data, $tamplate);
    }
}


?>