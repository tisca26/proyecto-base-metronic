<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_sys extends CI_Controller
{
    private $pag_redirect = 'dashboard';
    public function index()
    {
        if (get_attr_session('logged_in') === 'OK_LOGIN') {
            redirect($this->pag_redirect);
        }
        $this->load->view('admin_sys/login_index');
    }

    public function login()
    {
        $usr = $this->input->post('nombre_usr');
        $pass = $this->input->post('pass_usr');
        if (!$this->auth_lib->login($usr, $pass)) {
            set_bootstrap_alert('Error en el usuario o contraseña', BOOTSTRAP_ALERT_DANGER);
            return $this->index();
        } else {
            $intento_url = get_attr_session('intento_url');
            return redirect(isset($intento_url)? $intento_url : $this->pag_redirect);
        }
    }

    public function salir()
    {
        if (get_attr_session('logged_in')) {
            $this->session->sess_destroy();
        }
        redirect('admin_sys');
    }
}