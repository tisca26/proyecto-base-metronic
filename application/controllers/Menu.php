<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

include("Acl_controller.php");

class Menu extends Acl_controller
{


    private $template_base = 'index';

    function __construct()
    {
        parent::__construct();

        $this->set_read_list(array('index', 'export', 'icons'));
        $this->set_insert_list(array('insert_menu'));
        $this->set_update_list(array('edit_menu', 'change_menu_status'));
        $this->set_delete_list(array('delete_menu'));

        $this->check_access();

        // load modules/menus/model/mmenus
        $this->load->model('menu_model');
    }

    function index()
    {
        $this->cargar_idioma->carga_lang('menu/menu_index');
        $tree = array();
        $parentid = 0;
        $this->menu_model->generateallTree($tree, $parentid);
        $data['navlist'] = $tree;
        $template['_B'] = 'menu/menu_index.php';
        $this->load->template_view($this->template_base, $data, $template);
    }

    function insert_menu()
    {
        $this->cargar_idioma->carga_lang('menu/menu_insertar');
        // This is used in menu/menus, when you click Create new menu, then this is called
        // 'parentid' ,'0' is in hidden in views/admin_menu_create.php
        if ($this->input->post('name')) {
            $name = $this->input->post('name');
            $shortdesc = $this->input->post('shortdesc');
            $status = ((bool)$this->input->post('status') == FALSE) ? 'inactive' : 'active';
            $parentid = $this->input->post('parentid');
            $order = $this->input->post('order');
            $icon = $this->input->post('icon');

            $radiourl = $this->input->post('radiourl');
            if ($radiourl == 0) {
                $res = $this->input->post('resource');
                $page_res = $this->input->post('page_res');
                $resource = $this->resource_name($res);
                $page_uri = $resource . '/' . $page_res;
            } else {
                $page_uri = $this->input->post('page_uri');
                $res = null;
            }
            if ($this->menu_model->addMenu($name, $shortdesc, $status, $parentid, $order, $page_uri, $res, $icon)) {
                set_bootstrap_alert(trans_line('alerta_exito'), BOOTSTRAP_ALERT_SUCCESS);
                return redirect('menu/insert_menu');
            } else {
                $error = $this->menu_model->error_consulta();
                $mensajes_error = array(trans_line('alerta_error'), trans_line('alerta_error_codigo') . base64_encode($error['message']));
                set_bootstrap_alert($mensajes_error, BOOTSTRAP_ALERT_DANGER);
                return redirect('menu/insert_menu');
            }
        } else {
            $data['menus'] = $this->menu_model->getAllMenusDisplay();
            $data['resources'] = $this->load_resources_options();
            $template['_B'] = 'menu/menu_insertar.php';
            $this->load->template_view($this->template_base, $data, $template);
        }
    }

    function edit_menu($id = 0)
    {
        $this->cargar_idioma->carga_lang('menu/menu_editar');
        // This is for editing Menu, such as Main menu etc
        if ($this->input->post('name')) {
            $menuid = $this->input->post('menuid');
            $name = $this->input->post('name');
            $shortdesc = $this->input->post('shortdesc');
            $status = ((bool)$this->input->post('status') == FALSE) ? 'inactive' : 'active';
            $parentid = $this->input->post('parentid');
            $order = $this->input->post('order');
            $icon = $this->input->post('icon');
            $radiourl = $this->input->post('radiourl');
            if ($radiourl == 0) {
                $res = $this->input->post('resource');
                $page_res = $this->input->post('page_res');
                $resource = $this->resource_name($res);
                $page_uri = $resource . '/' . $page_res;
            } else {
                $page_uri = $this->input->post('page_uri');
                $res = null;
            }
            if ($this->menu_model->updateMenu($menuid, $name, $shortdesc, $status, $parentid, $order, $page_uri, $res, $icon)) {
                set_bootstrap_alert(trans_line('alerta_exito'), BOOTSTRAP_ALERT_SUCCESS);
                return redirect('menu/');
            } else {
                $error = $this->menu_model->error_consulta();
                $mensajes_error = array(trans_line('alerta_error'), trans_line('alerta_error_codigo') . base64_encode($error['message']));
                set_bootstrap_alert($mensajes_error, BOOTSTRAP_ALERT_DANGER);
                return redirect('menu/edit_menu' . $menuid);
            }
        } else {
            $data['menu'] = $this->menu_model->getMenu($id);
            $data['menus'] = $this->menu_model->getAllMenusDisplay();
            $data['resources'] = $this->load_resources_options();
            if (!empty($data['menu'])) {
                $data['menu']['status'] = (strcmp($data['menu']['status'], 'inactive') == 0) ? FALSE : TRUE;
                $data['menu']['page_res'] = '';
                $data['menu']['radio_res'] = FALSE;
                $data['menu']['radio_url'] = FALSE;
                if (!empty ($data['menu']['resourceid'])) {
                    $segment = $this->divide_uri($data['menu']['page_uri'], $data['menu']['resourceid']);
                    if (!is_null($segment)) {
                        $data['menu']['page_res'] = $segment;
                        $data['menu']['radio_res'] = TRUE;
                        $data['menu']['page_uri'] = '';
                    } else {
                        $data['menu']['radio_url'] = TRUE;
                    }
                } else {
                    $data['menu']['radio_url'] = TRUE;
                }
            }
            if (!count($data['menu'])) {
                $this->index();
            }
            $template['_B'] = 'menu/menu_editar.php';
            $this->load->template_view($this->template_base, $data, $template);
        }

    }

    function delete_menu($id = 0)
    {
        $this->cargar_idioma->carga_lang('menu/menu_index');
        $orphans = $this->menu_model->checkMenuOrphans($id);
        if (count($orphans)) {
            if (!$this->menu_model->changeMenuOrphansParent($id)) {
                $error = $this->menu_model->error_consulta();
                $mensajes_error = array(trans_line('alerta_borrar_error'), trans_line('alerta_borrar_error_codigo') . base64_encode($error['message']));
                set_bootstrap_alert($mensajes_error, BOOTSTRAP_ALERT_DANGER);
                return redirect('menu/');
            }
        }
        if ($this->menu_model->deleteMenu($id) != FALSE) {
            set_bootstrap_alert(trans_line('alerta_borrar_exito'), BOOTSTRAP_ALERT_SUCCESS);
            return redirect('menu/');
        } else {
            if ($this->menu_model->revertChangeMenuOrphansParent($id, $orphans)) {
                $error = $this->menu_model->error_consulta();
                $mensajes_error = array(trans_line('alerta_borrar_error'), trans_line('alerta_borrar_error_codigo') . base64_encode($error['message']));
                set_bootstrap_alert($mensajes_error, BOOTSTRAP_ALERT_DANGER);
                return redirect('menu/');
            } else {
                $error = $this->menu_model->error_consulta();
                $mensajes_error = array(trans_line('alerta_revert_orphans_error'), trans_line('alerta_borrar_error_codigo') . base64_encode($error['message']));
                set_bootstrap_alert($mensajes_error, BOOTSTRAP_ALERT_DANGER);
                return redirect('menu/');
            }
        }
    }

    function change_menu_status($id = 0)
    {
        $this->cargar_idioma->carga_lang('menu/menu_index');
        $orphans = $this->menu_model->checkMenuOrphans($id);
        if (count($orphans)) {
            $this->menu_model->changeMenuOrphansStatus($id);
        }
        $this->menu_model->changeMenuStatus($id);

        set_bootstrap_alert(trans_line('alerta_estatus_exito'), BOOTSTRAP_ALERT_SUCCESS);
        return redirect('menu/');

    }

    function export()
    {
        $this->load->helper('download');
        $csv = $this->menu_model->exportCsv();
        $name = "Menu_export.csv";
        force_download($name, $csv);

    }

    function reassign($id = 0)
    {
        // This is called when you delete one of menu from deleteMenu() function above.
        if ($_POST) {

            $this->menu_model->reassignMenus();
            $this->session->set_flashdata('message', 'Menu deleted and sub-menus reassigned');
            redirect('menu/');
        } else {
            //$id = $this->uri->segment(4);

            $data['menu'] = $this->menu_model->getMenu($id);
            $data['title'] = "Reassign Sub-menus";
            $data['menus'] = $this->menu_model->getrootMenus();
            $this->menu_model->deleteMenu($id);

            // Set breadcrumb
            ///     $this->bep_site->set_crumb($this->lang->line('userlib_menu_reassign'),'menus/menu/reassign');

            $data['header'] = $this->lang->line('backendpro_access_control');
            $data['page'] = $this->config->item('backendpro_template_admin') . "admin_submenu_reassign";
            $data['module'] = 'menus';
            $this->load->view($this->_container, $data);
        }
    }

    private function load_resources_options()
    {
        $this->load->model('resources_model');
        $resources = $this->resources_model->get_all();
        $options = array();
        foreach ($resources as $res) {
            $options[$res->ID] = $res->RESOURCE;
        }
        return $options;
    }

    private function resource_name($id = 0)
    {
        $this->load->model('resources_model');
        $resource = $this->resources_model->get_resource($id);
        if (!empty($resource)) {
            return $resource->RESOURCE;
        } else {
            return '';
        }
    }

    public function divide_uri($uri, $resourceid)
    {
        $res = $this->resource_name($resourceid);
        $r = substr($uri, 0, strlen($res));
        if (strcmp($res, $r) == 0) {
            $seg = substr($uri, strlen($res) + 1);
            return (is_null($seg)) ? '' : $seg;
        } else {
            return NULL;
        }
    }

    public function icons(){
        $this->cargar_idioma->carga_lang('menu/menu_icons');
        $template['_B'] = 'menu/menu_icons.php';
        $this->load->template_view($this->template_base, '', $template);
    }
}

?>