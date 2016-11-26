<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include("Acl_controller.php");

class Users extends Acl_controller
{

    private $template_base = 'index';

    /**
     * Constructor
     *
     * @access public
     */
    function __construct()
    {
        parent::__construct();

        $this->set_read_list(array('index', 'nick_exist', 'sucursal_asociate'));
        $this->set_insert_list(array('insert_user', 'form_insert'));
        $this->set_update_list(array('edit_user', 'form_edit', 'change_password', 'form_password'));
        $this->set_delete_list(array('delete_user'));

        $this->check_access();

        $this->load->model('users_model');
        $this->load->library('form_validation');
        $this->load->model('catalogos_model');
    }

    /**
     * Default Action. Listing user collection
     *
     * @access public
     */
    function index()
    {
        $this->cargar_idioma->carga_lang('users/users_index');
        $data = array();
        $data['rows'] = $this->users_model->get_all();
        $template['_B'] = 'users/users_index.php';
        $this->load->template_view($this->template_base, $data, $template);
    }

    function insert_user()
    {
        $this->cargar_idioma->carga_lang('users/users_inserta');
        $name = $this->input->post('nombre');
        $apellido = $this->input->post('apellidos');
        $email = $this->input->post('correo');
        $nick = $this->input->post('nick');
        $opciones = [
            'cost' => 10,
        ];
        $paswd = password_hash($this->input->post('password'), PASSWORD_BCRYPT, $opciones);
        $enable = ($this->input->post('enableuser') == FALSE) ? FALSE : TRUE;
        $id = 0;
        if ($this->users_model->insert($nick, $paswd, $name, $apellido, $email, $enable) == TRUE) {
            $id = $this->users_model->identity();
            $group = $this->input->post('radio_group');
            if ($this->users_model->insert_group_relation($id, $group) == TRUE) {
                set_bootstrap_alert(trans_line('alerta_exito'), BOOTSTRAP_ALERT_SUCCESS);
                return redirect('users/form_insert');
            } else {
                $this->users_model->delete($id);
                $error = $this->users_model->error_consulta();
                $mensajes_error = array(trans_line('alerta_error'), trans_line('alerta_error_codigo') . base64_encode($error['message']));
                set_bootstrap_alert($mensajes_error, BOOTSTRAP_ALERT_DANGER);
                return $this->form_insert();
            }
        } else {
            $error = $this->users_model->error_consulta();
            $mensajes_error = array(trans_line('alerta_error'), trans_line('alerta_error_codigo') . base64_encode($error['message']));
            set_bootstrap_alert($mensajes_error, BOOTSTRAP_ALERT_DANGER);
            return $this->form_insert();
        }
    }

    function edit_user()
    {
        $this->cargar_idioma->carga_lang('users/users_edita');
        $id = $this->input->post('userid');
        $name = $this->input->post('nombre');
        $apellido = $this->input->post('apellidos');
        $email = $this->input->post('correo');
        $nick = $this->input->post('nick');
        $enable = ($this->input->post('enableuser') == FALSE) ? FALSE : TRUE;
        if ($this->users_model->update_all($id, $nick, $name, $apellido, $email, $enable) == TRUE){
            $group = $this->input->post('radio_group');
            if ($this->users_model->update_group_relation($id, $group) == TRUE){
                set_bootstrap_alert(trans_line('alerta_exito'), BOOTSTRAP_ALERT_SUCCESS);
                return redirect('users');
            }
        }
        $error = $this->users_model->error_consulta();
        $mensajes_error = array(trans_line('alerta_error'), trans_line('alerta_error_codigo') . base64_encode($error['message']));
        set_bootstrap_alert($mensajes_error, BOOTSTRAP_ALERT_DANGER);
        return $this->form_edit($id);
    }

    function change_password()
    {

        $this->form_validation->set_rules('password', lang('label_password'), 'required');
        $this->form_validation->set_rules('repassword', lang('label_repassword'), 'required|matches[password]');

        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $id = $this->input->post('userid');

        if ($this->form_validation->run() == FALSE) {
            $this->form_password($id);
        } else {

            $password = sha1($this->input->post('password'));

            $this->users_model->update_password($id, $password);

            $data['m_tipo'] = 'Ok edit pass';
            $data['m_titulo'] = 'Usuarios';
            $data['m_mensaje'] = 'La contraseña se editó con éxito';
            $this->session->set_flashdata('m_tipo', $data['m_tipo']);
            $this->session->set_flashdata('m_titulo', $data['m_titulo']);
            $this->session->set_flashdata('m_mensaje', $data['m_mensaje']);
            redirect('users/form_edit/' . $id);
        }
    }

    function delete_user($id)
    {

        $this->users_model->delete($id);

        $data['m_tipo'] = 'Ok delete';
        $data['m_titulo'] = 'Usuarios';
        $data['m_mensaje'] = 'El usuario se eliminó con éxito';
        $this->session->set_flashdata('m_tipo', $data['m_tipo']);
        $this->session->set_flashdata('m_titulo', $data['m_titulo']);
        $this->session->set_flashdata('m_mensaje', $data['m_mensaje']);
        redirect('users/');
    }

    function nick_exist()
    {
        $nick = $this->input->post('nick');
        $id = ($this->input->post('userid') == FALSE) ? -1 : $this->input->post('userid');
        echo $this->users_model->nick_exist($nick, $id);
    }

    function val_nick_exist($nick)
    {
        $id = ($this->input->post('userid') == FALSE) ? -1 : $this->input->post('userid');
        if ($this->users_model->nick_exist($nick, $id)) {
            $this->form_validation->set_message('val_nick_exist', lang('val_exist'));
            return FALSE;
        } else
            return TRUE;
    }

    function form_insert()
    {
        $this->cargar_idioma->carga_lang('users/users_inserta');
        $data['groups'] = $this->load_groups_options();
        $template['_B'] = 'users/users_insertar.php';
        $this->load->template_view($this->template_base, $data, $template);
    }

    function form_edit($id = 0)
    {
        $this->cargar_idioma->carga_lang('users/users_edita');
        $data['user'] = $this->users_model->get_user($id);
        $data['groups'] = $this->load_groups_options();
        $data['usergroups'] = $this->users_model->get_user_group($id);

        $tamplate['_B'] = 'users/users_editar.php';
        $this->load->template_view($this->template_base, $data, $tamplate);
    }

    function form_password($id = 0)
    {
        $data['id'] = $id;
        $data['submitdata'] = 'users/change_password';

        $tamplate['_B'] = 'users/change_password_view.php';
        $this->load->template_view($this->template_base, $data, $tamplate);
    }

    private function load_groups_options()
    {
        $this->load->model('groups_model');
        return $this->groups_model->get_all();
    }
}

?>