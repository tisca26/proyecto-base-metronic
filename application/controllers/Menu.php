<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "Privy.php";

class Menu extends Privy
{
    public function __construct()
    {
        parent::__construct();
        $this->set_read_list(array('index'));
        $this->set_insert_list(array('insertar', 'frm_insertar'));
        $this->set_update_list(array('editar', 'frm_editar', 'cambiar_estatus'));
        $this->set_delete_list(array('borrar'));
        $this->check_access();
        $this->load->model('menu_model');
    }

    public function index()
    {
        $tree = array();
        $this->menu_model->generateallTree($tree, 0); // Parent = Root
        $data['navlist'] = $tree;
        $this->load->view('menu/menu_index', $data);
    }

    public function insertar()
    {
        $this->load->model('resources_model');
        $data['recursos'] = $this->resources_model->recursos_todos_sel();
        $data['menus'] = $this->menu_model->getAllMenusDisplay();
        $this->load->view('menu/menu_insertar', $data);
    }

    public function frm_insertar()
    {
        $this->form_validation->set_rules('nombre', 'Nombre', 'required|min_length[3]');
        $this->form_validation->set_rules('orden', 'Orden del menú', 'required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->insertar();
        } else {
            $menu_dto = $this->input->post();
            $menu_dto['estatus'] = (isset($menu_dto['estatus'])) ? 1 : 0;
            if (!(bool)$menu_dto['radio_url']) {
                $this->load->model('resources_model');
                $menu_dto['page_uri'] = $this->resources_model->recursos_por_id($menu_dto['resource_id'])->resource;
                $menu_dto['page_uri'] .= '/' . $menu_dto['page_res'];
                unset($menu_dto['page_res']);
            }
            unset($menu_dto['radio_url']);
            if ($this->menu_model->insertar($menu_dto)) {
                set_bootstrap_alert("Se guardó el menú con éxito, inserte otro o <strong><a href='" . base_url('menu') . "'> vuelva al inicio</a></strong>", BOOTSTRAP_ALERT_SUCCESS);
            } else {
                set_bootstrap_alert("Error al guardar el menú, intente nuevamente", BOOTSTRAP_ALERT_SUCCESS);
            }
        }
        redirect('menu/insertar');
    }

    public function editar($id = 0)
    {
        if (!valid_id($id)) {
            redirect('menu');
        }
        $this->load->model('resources_model');
        $data['recursos'] = $this->resources_model->recursos_todos_sel();
        $data['menus'] = $this->menu_model->getAllMenusDisplay();
        $data['menu'] = $this->menu_model->menu_por_id($id);
        $this->load->view('menu/menu_editar', $data);
    }

    public function frm_editar()
    {
        $this->form_validation->set_rules('menu_id', 'Identificador', 'required|integer');
        $this->form_validation->set_rules('nombre', 'Nombre', 'required|min_length[3]');
        $this->form_validation->set_rules('orden', 'Orden del menú', 'required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->editar($this->input->post('menu_id'));
        } else {
            $menu_dto = $this->input->post();
            $menu_dto['estatus'] = (isset($menu_dto['estatus'])) ? 1 : 0;
            if (!(bool)$menu_dto['radio_url']) {
                $this->load->model('resources_model');
                $menu_dto['page_uri'] = $this->resources_model->recursos_por_id($menu_dto['resource_id'])->resource;
                $menu_dto['page_uri'] .= '/' . $menu_dto['page_res'];
                unset($menu_dto['page_res']);
            }
            unset($menu_dto['radio_url']);
            if ($this->menu_model->editar($menu_dto)) {
                set_bootstrap_alert("Se guardó el menú con éxito", BOOTSTRAP_ALERT_SUCCESS);
            } else {
                set_bootstrap_alert("Error al guardar el menú, intente nuevamente", BOOTSTRAP_ALERT_SUCCESS);
            }
        }
        redirect('menu/');
    }

    public function borrar($id = 0)
    {
        if (!valid_id($id)) {
            return redirect('menu');
        }
        $orphans = $this->menu_model->checkMenuOrphans($id);
        if (count($orphans)) {
            if (!$this->menu_model->changeMenuOrphansParent($id)) {
                $error = $this->menu_model->error_consulta();
                $mensajes_error = array('Error: ', $error['message']);
                set_bootstrap_alert($mensajes_error, BOOTSTRAP_ALERT_DANGER);
                return redirect('menu');
            }
        }
        if ($this->menu_model->borrar(array('menu_id' => $id)) != FALSE) {
            set_bootstrap_alert('Se borró el registro con éxito', BOOTSTRAP_ALERT_SUCCESS);
            return redirect('menu');
        } else {
            if ($this->menu_model->revertChangeMenuOrphansParent($id, $orphans)) {
                $error = $this->menu_model->error_consulta();
                $mensajes_error = array('Error: ', $error['message']);
                set_bootstrap_alert($mensajes_error, BOOTSTRAP_ALERT_DANGER);
                return redirect('menu');
            } else {
                $error = $this->menu_model->error_consulta();
                $mensajes_error = array('Error al revertir hijos: ', $error['message']);
                set_bootstrap_alert($mensajes_error, BOOTSTRAP_ALERT_DANGER);
                return redirect('menu');
            }
        }
    }

    public function cambiar_estatus($id = 0)
    {
        if (!valid_id($id)) {
            return redirect('menu');
        }
        $orphans = $this->menu_model->checkMenuOrphans($id);
        if (count($orphans)) {
            if ($this->menu_model->changeMenuOrphansStatus($id) === false) {
                set_bootstrap_alert('Error al cambiar el estatus, intente nuevamente', BOOTSTRAP_ALERT_DANGER);
                return redirect('menu');
            }
        }
        if ($this->menu_model->changeMenuStatus($id)) {
            set_bootstrap_alert('Se cambió el estatus con éxito', BOOTSTRAP_ALERT_SUCCESS);
            return redirect('menu');
        }
        set_bootstrap_alert('Error al cambiar el estatus, intente nuevamente', BOOTSTRAP_ALERT_DANGER);
        return redirect('menu');
    }
}