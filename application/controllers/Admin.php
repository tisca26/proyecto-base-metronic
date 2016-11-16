<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller
{

    /**
     * Constructor
     *
     * @access public
     */

    function __construct()
    {
        parent::__construct();
        $this->load->model('catalogos_model');
        $this->load->model('users_model');
        $this->load->model('logs_oe_model');
    }

    /**
     * Default Action. Show view of authentication form
     *
     * @access public
     */
    function index()
    {
        if (!get_attr_session('logged_in')) {
            $data = array();
            $csrf = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
            );
            $data['csrf'] = $csrf;
            $this->load->view('login_page', $data);
        } else {
            redirect(base_url());
        }
    }

    function login()
    {
        $username = $this->input->post('username');
        $username = str_replace("=", "", $username);

        if ($username == '' || $username == null || !is_string($username)) {
            redirect(base_url());
            return;
        }

        $password = $this->input->post('password');
        $password = str_replace("=", "", $password);
        if ($password == '' || $password == null || !is_string($password)) {
            redirect(base_url());
            return;
        }

        if (!$this->auth_acl->login($username, $password)) {
            redirect('admin/');
        } else {
            $perfil = $this->catalogos_model->loadUsuarioPerfil($username);

            if ($perfil->usuario == '' || $perfil->usuario == NULL) {
                redirect(base_url());
                return;
            }

            $datasession = array(
                'ID' => $perfil->ID,
                'usuario' => $perfil->usuario,
                'nombre' => $perfil->nombre,
                'apellidos' => $perfil->apellidos,
                'rol' => $perfil->nombregrupo
            );

            set_attr_session($datasession);

            if (get_attr_session('intento_url') != '' || get_attr_session('intento_url') != NULL) {
                redirect(get_attr_session('intento_url'));
            } else {
                redirect(base_url_lang());
            }
        }
    }

    /**
     * User logout
     *
     * @access public
     */
    function logout()
    {
        $this->auth_acl->logout();
        redirect(base_url_lang());
    }
}

?>