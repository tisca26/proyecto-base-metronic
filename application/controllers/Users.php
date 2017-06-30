<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "Privy.php";

class Users extends Privy
{
    public function __construct()
    {
        parent::__construct();
        $this->set_read_list(array('index'));
        $this->set_insert_list(array('insertar', 'frm_insertar'));
        $this->set_update_list(array('editar', 'frm_editar'));
        $this->set_delete_list(array('borrar', 'borrado_final'));
        $this->check_access();
        $this->load->library('business/User');
    }

    public function index()
    {
        $data['usuarios'] = $this->user->usuarios_todos();
        $this->load->view('users/users_index', $data);
    }

    public function insertar()
    {
        $this->load->library('business/Group');
        $data['grupos'] = $this->group->grupos_todos();
        $this->load->view('users/users_insertar', $data);
    }

    public function frm_insertar()
    {
        $this->form_validation->set_rules('nombre', 'Nombre', 'required|min_length[3]');
        $this->form_validation->set_rules('apellido_paterno', 'Apellido Paterno', 'required|min_length[3]');
        $this->form_validation->set_rules('apellido_materno', 'Apellido Materno', 'required|min_length[3]');
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        if ($this->form_validation->run() == FALSE) {
            $this->insertar();
        } else {
            $usuario = $this->input->post();
            $grupos = $usuario['groups'];
            unset($usuario['groups']);
            unset($usuario['repasswd']);
            $usuario['passwd'] = $this->_genera_contraseña($usuario['passwd']);
            $usuario['estatus'] = isset($usuario['estatus']) ? 1 : 0;
            if ($this->user->insertar_con_grupos($usuario, $grupos)) {
                $msg = "El usuario se guardó con éxito, inserte otro o <strong><a href='" . base_url('users') . "'>vuela al inicio</a></strong>";
                set_bootstrap_alert($msg, BOOTSTRAP_ALERT_SUCCESS);
            } else {
                $msg = "Error al guardar el usuario, intente nuevamente";
                set_bootstrap_alert($msg, BOOTSTRAP_ALERT_DANGER);
            }
            redirect('users/insertar');
        }
    }

    public function editar($id = 0)
    {
        if (!valid_id($id)) {
            $msg = 'Error en el identificador';
            set_bootstrap_alert($msg, BOOTSTRAP_ALERT_DANGER);
            redirect('users');
        }
        $this->load->library('business/Group');
        $data['grupos'] = $this->group->grupos_todos();
        $data['usuario'] = $this->user->usuario_por_id($id);
        $this->load->view('users/users_editar', $data);
    }

    public function frm_editar()
    {
        $this->form_validation->set_rules('usuarios_id', 'Identificador', 'required|integer');
        $this->form_validation->set_rules('nombre', 'Nombre', 'required|min_length[3]');
        $this->form_validation->set_rules('apellido_paterno', 'Apellido Paterno', 'required|min_length[3]');
        $this->form_validation->set_rules('apellido_materno', 'Apellido Materno', 'required|min_length[3]');
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        if ($this->form_validation->run() == FALSE) {
            $this->editar($this->input->post('usuarios_id'));
        } else {
            $usuario = $this->input->post();
            $grupos = $usuario['groups'];
            unset($usuario['groups']);
            unset($usuario['repasswd']);
            $usuario['estatus'] = isset($usuario['estatus']) ? 1 : 0;
            if ($usuario['passwd'] !== '') {
                $usuario['passwd'] = $this->_genera_contraseña($usuario['passwd']);
            } else {
                unset($usuario['passwd']);
            }
            if ($this->user->editar_con_grupos($usuario, $grupos)) {
                $msg = "El usuario se guardó con éxito";
                set_bootstrap_alert($msg, BOOTSTRAP_ALERT_SUCCESS);
                redirect('users');
            } else {
                $msg = "Error al guardar el usuario, intente nuevamente";
                set_bootstrap_alert($msg, BOOTSTRAP_ALERT_DANGER);
                redirect('users/editar/' . $usuario['usuarios_id']);
            }
        }
    }

    private function _genera_contraseña($passwd = '')
    {
        $opciones = [
            'cost' => 10,
        ];
        return password_hash($passwd, PASSWORD_BCRYPT, $opciones);
    }

    public function borrar($id = 0)
    {
        if (!valid_id($id)) {
            return redirect('users');
        }
        if ($this->user->editar(array('usuarios_id' => $id, 'estatus' => '0')) !== false) {
            $msg = 'Se borró el registro con éxito';
            set_bootstrap_alert($msg, BOOTSTRAP_ALERT_SUCCESS);
        } else {
            $msg = 'Error al borrar el registro, intente nuevamente';
            set_bootstrap_alert($msg, BOOTSTRAP_ALERT_DANGER);
        }
        redirect('users');
    }

    public function borrado_final($id = 0)
    {
        if (!valid_id($id)) {
            return redirect('users');
        }
        if ($this->user->borrado_final(array('usuarios_id' => $id))) {
            $msg = 'Se borró el registro con éxito';
            set_bootstrap_alert($msg, BOOTSTRAP_ALERT_SUCCESS);
        } else {
            $msg = 'Error al borrar el registro, intente nuevamente';
            set_bootstrap_alert($msg, BOOTSTRAP_ALERT_DANGER);
        }
        redirect('users');
    }
}