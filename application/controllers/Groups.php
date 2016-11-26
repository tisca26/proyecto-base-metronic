<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

include("Acl_controller.php");

class Groups extends Acl_controller
{

    private $template_base = 'index';

    function __construct()
    {
        parent::__construct();

        $this->set_read_list(array('index'));
        $this->set_insert_list(array('insert_group', 'form_insert'));
        $this->set_update_list(array('edit_group', 'form_edit'));
        $this->set_delete_list(array('delete_group'));

        $this->check_access();

        $this->load->model('groups_model');
        $this->load->library('form_validation');
    }

    function index()
    {
        $this->cargar_idioma->carga_lang('groups/groups_index');
        $data['rows'] = $this->groups_model->get_all();
        $template['_B'] = 'groups/groups_index.php';
        $this->load->template_view($this->template_base, $data, $template);

    }

    function insert_group()
    {
        $this->cargar_idioma->carga_lang('groups/groups_insertar');
        $this->form_validation->set_rules('groupname', trans_line('groupname'), 'required|trim|min_length[3]');
        if ($this->form_validation->run() == FALSE) {
            $this->form_insert();
        } else {
            $name = $this->input->post('groupname');
            $enable = ((bool)$this->input->post('enablegroup') == FALSE) ? FALSE : TRUE;
            if ($this->groups_model->insert($name, $enable) == TRUE) {
                set_bootstrap_alert(trans_line('alerta_exito'), BOOTSTRAP_ALERT_SUCCESS);
                return redirect('groups/form_insert');
            } else {
                $error = $this->groups_model->error_consulta();
                $mensajes_error = array(trans_line('alerta_error'), trans_line('alerta_error_codigo') . base64_encode($error['message']));
                set_bootstrap_alert($mensajes_error, BOOTSTRAP_ALERT_DANGER);
                return $this->form_insert();
            }
        }
    }

    function edit_group()
    {
        $this->cargar_idioma->carga_lang('groups/groups_editar');
        $this->form_validation->set_rules('groupname', trans_line('groupname'), 'required|trim|min_length[3]');
        $id = $this->input->post('groupid');
        if ($this->form_validation->run() == FALSE) {
            $this->form_edit($id);
        } else {

            $name = $this->input->post('groupname');
            $enable = ((bool)$this->input->post('enablegroup') == FALSE) ? FALSE : TRUE;

            if($this->groups_model->update_all($id, $name, $enable)  != FALSE){
                set_bootstrap_alert(trans_line('alerta_exito'), BOOTSTRAP_ALERT_SUCCESS);
                return redirect('groups');
            }else{
                $error = $this->groups_model->error_consulta();
                $mensajes_error = array(trans_line('alerta_error'), trans_line('alerta_error_codigo') . base64_encode($error['message']));
                set_bootstrap_alert($mensajes_error, BOOTSTRAP_ALERT_DANGER);
                return $this->form_edit($id);
            }
        }

    }

    function delete_group($id = 0)
    {
        $this->cargar_idioma->carga_lang('groups/groups_index');
        if ($this->groups_model->delete($id) != FALSE) {
            set_bootstrap_alert(trans_line('alerta_borrado'), BOOTSTRAP_ALERT_SUCCESS);
            return redirect('groups');
        } else {
            set_bootstrap_alert(trans_line('alerta_borrado_fail'), BOOTSTRAP_ALERT_DANGER);
            return redirect('groups');
        }
    }

    function form_insert()
    {
        $this->cargar_idioma->carga_lang('groups/groups_insertar');
        $template['_B'] = 'groups/groups_insertar.php';
        $this->load->template_view($this->template_base, $template);
    }

    function form_edit($id = 0)
    {
        $this->cargar_idioma->carga_lang('groups/groups_editar');
        $data['grp'] = $this->groups_model->get_group($id);
        $template['_B'] = 'groups/groups_editar.php';
        $this->load->template_view($this->template_base, $data, $template);
    }
}


?>