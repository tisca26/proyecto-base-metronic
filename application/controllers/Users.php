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

        $this->set_read_list(array('index', 'nick_exist', 'loadSubSecretary', 'sucursal_asociate'));
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
        $data['rows'] = $this->users_model->get_all();

        $data['sucursales'] = $this->loadSucursal();

        $template['_B'] = 'users/users_view.php';

        $this->load->template_view($this->template_base, $data, $template);
    }

    /**
     * Insert a new user
     *
     * @access public
     * @param
     * @return
     */
    function insert_user()
    {
        $name = $this->input->post('nombre');
        $apellido = $this->input->post('apellido');
        $email = $this->input->post('email');
        $nick = $this->input->post('nick');
        $opciones = [
            'cost' => 10,
        ];
        $paswd = password_hash($this->input->post('password'), PASSWORD_BCRYPT, $opciones);
        $celular = $this->input->post('celular');
        $sucursal = $this->input->post('sucursal');
        $rfc = $this->input->post('rfc');
        $enable = ($this->input->post('enableuser') == FALSE) ? FALSE : TRUE;
        $id = $this->users_model->insert($nick, $paswd, $name, $apellido, $email, $celular, $sucursal, $enable, $rfc);
        if (isset($_POST['checkgroup'])) {
            foreach ($_POST['checkgroup'] as $group) {
                $this->users_model->insert_group_relation($id, $group);
            }
        }
        $data['m_tipo'] = 'Ok insert';
        $data['m_titulo'] = 'Usuarios';
        $data['m_mensaje'] = 'El usuario se guardó con éxito';
        $this->session->set_flashdata('m_tipo', $data['m_tipo']);
        $this->session->set_flashdata('m_titulo', $data['m_titulo']);
        $this->session->set_flashdata('m_mensaje', $data['m_mensaje']);
        redirect('users/');

    }

    /**
     * Update user data
     *
     * @access public
     * @param
     * @return
     */
    function edit_user()
    {
        $id = $this->input->post('userid');
        $name = $this->input->post('nombre');
        $apellido = $this->input->post('apellido');
        $email = $this->input->post('email');
        $nick = $this->input->post('nick');
        $celular = $this->input->post('celular');
        $sucursal = $this->input->post('SUCURSAL_ID');
        $enable = ($this->input->post('enableuser') == FALSE) ? FALSE : TRUE;
        $rfc = $this->input->post('rfc');

        $this->users_model->update_all($id, $nick, $name, $apellido, $email, $celular, $sucursal, $enable, $rfc);

        if (isset($_POST['checkgroup'])) {
            $groups = $_POST['checkgroup'];
            $this->users_model->update_group_relation($id, $groups);
        } else {
            $this->users_model->update_group_relation($id, array());
        }

        $data['m_tipo'] = 'Ok edit';
        $data['m_titulo'] = 'Usuarios';
        $data['m_mensaje'] = 'El usuario se editó con éxito';
        $this->session->set_flashdata('m_tipo', $data['m_tipo']);
        $this->session->set_flashdata('m_titulo', $data['m_titulo']);
        $this->session->set_flashdata('m_mensaje', $data['m_mensaje']);
        redirect('users/');
    }

    /**
     * Update user password
     *
     * @access public
     * @param
     * @return
     */
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

    /**
     * delete user
     *
     * @access public
     * @param  int
     * @return
     */
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

    /**
     * Check if user nick exist (ajax method)
     *
     * @access public
     * @return
     */
    function nick_exist()
    {
        $nick = $this->input->post('nick');
        $id = ($this->input->post('userid') == FALSE) ? -1 : $this->input->post('userid');
        echo $this->users_model->nick_exist($nick, $id);
    }

    /**
     * Check if user nick exist to server side validate
     *
     * @access public
     * @return
     */
    function val_nick_exist($nick)
    {
        $id = ($this->input->post('userid') == FALSE) ? -1 : $this->input->post('userid');
        if ($this->users_model->nick_exist($nick, $id)) {
            $this->form_validation->set_message('val_nick_exist', lang('val_exist'));
            return FALSE;
        } else
            return TRUE;
    }

    /**
     * Load insert user form
     *
     * @access public
     * @param
     * @return
     */
    function form_insert()
    {

        $data['groups'] = $this->load_groups_options();
        $data['sucursales'] = $this->loadSucursal();
        // $data['departments'] = $this->load_departments_options();

        $tamplate['_B'] = 'users/insert_user_view.php';

        $this->load->template_view($this->template_base, $data, $tamplate);
    }

    /**
     * Load edit user form
     *
     * @access public
     * @param int , user id
     * @return
     */
    function form_edit($id = 0)
    {

        $data['data'] = $this->users_model->get_user($id);
        $data['groups'] = $this->load_groups_options();
        $data['usergroups'] = $this->users_model->get_user_group($id);
        $data['sucursales'] = $this->loadSucursal();

        $tamplate['_B'] = 'users/edit_user_view.php';
        $this->load->template_view($this->template_base, $data, $tamplate);
    }

    /**
     * Load form to chage user password
     *
     * @access public
     * @param int , user id
     * @return
     */
    function form_password($id = 0)
    {
        $data['id'] = $id;
        $data['submitdata'] = 'users/change_password';

        $tamplate['_B'] = 'users/change_password_view.php';
        $this->load->template_view($this->template_base, $data, $tamplate);
    }

    /**
     * Create group list to load multiselect component in views
     *
     * @access private
     * @param
     * @return array of groups data
     */
    private function load_groups_options()
    {

        $this->load->model('groups_model');

        $groups = $this->groups_model->get_all();
        $options = array();
        foreach ($groups as $group) {
            $option['ID'] = $group->ID;
            $option['NAME'] = $group->NAME;
            $options[] = $option;
        }

        return $options;
    }

    private function loadSucursal()
    {
        $nomenclador = $this->catalogos_model->loadSucursal();
        foreach ($nomenclador as $tipo) {
            $options[$tipo->sucursal_id] = $tipo->nombre;
        }
        return $options;
    }
}

?>