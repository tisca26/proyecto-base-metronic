<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "Privy.php";

class Groups extends Privy
{
    public function __construct()
    {
        parent::__construct();
        $this->set_read_list(array('index'));
        $this->set_insert_list(array('insertar', 'frm_insertar'));
        $this->set_update_list(array('editar', 'frm_editar'));
        $this->set_delete_list(array('borrar', 'borrado_final'));
        $this->check_access();
        $this->load->library('business/Group');
    }

    public function index()
    {
        $data['grupos'] = $this->group->grupos_todos();
        $this->load->view('groups/groups_index', $data);
    }

    public function insertar()
    {
        $this->load->view('groups/groups_insertar');
    }

    public function frm_insertar()
    {
        $this->form_validation->set_rules('nombre', 'Nombre', 'required|min_length[3]');
        if ($this->form_validation->run() == FALSE) {
            $this->insertar();
        } else {
            $grupo = $this->input->post();
            $grupo['estatus'] = isset($grupo['estatus']) ? 1 : 0;
            if ($this->group->insertar($grupo)) {
                $msg = "El grupo se guardó con éxito, inserte otro o <strong><a href='" . base_url('groups') . "'>vuela al inicio</a></strong>";
                set_bootstrap_alert($msg, BOOTSTRAP_ALERT_SUCCESS);
            } else {
                $msg = "Error al guardar el grupo, intente nuevamente";
                set_bootstrap_alert($msg, BOOTSTRAP_ALERT_DANGER);
            }
            redirect('groups/insertar');
        }
    }

    public function editar($id = 0)
    {
        if (!valid_id($id)) {
            $msg = 'Error en el identificador';
            set_bootstrap_alert($msg, BOOTSTRAP_ALERT_DANGER);
            redirect('groups');
        }
        $data['grupo'] = $this->group->grupo_por_id($id);
        $this->load->view('groups/groups_editar', $data);
    }

    public function frm_editar()
    {
        $this->form_validation->set_rules('groups_id', 'Identificador', 'required|integer');
        $this->form_validation->set_rules('nombre', 'Nombre', 'required|min_length[3]');
        if ($this->form_validation->run() == FALSE) {
            $this->editar($this->input->post('groups-id'));
        } else {
            $grupo = $this->input->post();
            $grupo['estatus'] = isset($grupo['estatus']) ? 1 : 0;
            if ($this->group->editar($grupo)) {
                $msg = "El grupo se guardó con éxito";
                set_bootstrap_alert($msg, BOOTSTRAP_ALERT_SUCCESS);
            } else {
                $msg = "Error al guardar el grupo, intente nuevamente";
                set_bootstrap_alert($msg, BOOTSTRAP_ALERT_DANGER);
            }
            redirect('groups');
        }
    }

    public function borrar($id = 0)
    {
        if (!valid_id($id)) {
            return redirect('groups');
        }
        if ($this->group->editar(array('groups_id' => $id, 'estatus' => '0')) !== false) {
            $msg = 'Se borró el registro con éxito';
            set_bootstrap_alert($msg, BOOTSTRAP_ALERT_SUCCESS);
        } else {
            $msg = 'Error al borrar el registro, intente nuevamente';
            set_bootstrap_alert($msg, BOOTSTRAP_ALERT_DANGER);
        }
        redirect('groups');
    }

    public function borrado_final($id = 0)
    {
        if (!valid_id($id)) {
            return redirect('groups');
        }

        if ($this->group->borrado_final(array('groups_id' => $id))) {
            $msg = 'Se borró el registro con éxito';
            set_bootstrap_alert($msg, BOOTSTRAP_ALERT_SUCCESS);
        } else {
            $msg = 'Error al borrar el registro, intente nuevamente';
            set_bootstrap_alert($msg, BOOTSTRAP_ALERT_DANGER);
        }
        redirect('groups');
    }
}