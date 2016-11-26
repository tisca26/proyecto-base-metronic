<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

include("Acl_controller.php");

class Acl extends Acl_controller
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

        $this->set_read_list(array('form_acl'));
        $this->set_update_list(array('edit_acl'));

        $this->check_access();

        $this->load->model('acl_model');
    }

    /**
     * Insert a new resource
     *
     * @access public
     * @return
     */
    function edit_acl()
    {
        $this->cargar_idioma->carga_lang('acl/acl_index');
        $acldata = array();
        $template = array('R' => 0, 'I' => 0, 'U' => 0, 'D' => 0);

        if (isset($_POST['R'])) {
            $data = $_POST['R'];
            foreach ($data as $item) {
                if (!array_key_exists($item, $acldata)) {
                    $acldata[$item] = $template;
                }
                $acldata[$item]['R'] = 1;
            }
        }
        if (isset($_POST['I'])) {
            $data = $_POST['I'];
            foreach ($data as $item) {
                if (!array_key_exists($item, $acldata)) {
                    $acldata[$item] = $template;
                }
                $acldata[$item]['I'] = 1;

            }
        }
        if (isset($_POST['U'])) {
            $data = $_POST['U'];
            foreach ($data as $item) {
                if (!array_key_exists($item, $acldata)) {
                    $acldata[$item] = $template;
                }
                $acldata[$item]['U'] = 1;
            }
        }
        if (isset($_POST['D'])) {
            $data = $_POST['D'];
            foreach ($data as $item) {
                if (!array_key_exists($item, $acldata)) {
                    $acldata[$item] = $template;
                }
                $acldata[$item]['D'] = 1;
            }
        }

        $targetid = $_POST['targetid'];
        $targettype = $_POST['targettype'];

        $this->acl_model->update($targetid, $targettype, $acldata);

        set_bootstrap_alert(trans_line('alerta_exito'), BOOTSTRAP_ALERT_SUCCESS);
        //Regresa al mismo lugar porque lo usan diferentes modulos (grupos y permisos de usuarios)
        redirect('acl/form_acl/' . $targetid . '/' . $targettype);
        //redirect('groups/');
    }

    /**
     * Load edit resource form
     *
     * @access public
     * @param int , group or user ID
     * @param int , group (1) or user (2) type
     * @return
     */
    function form_acl($targetid = 0, $targettype = 0)
    {
        $this->cargar_idioma->carga_lang('acl/acl_index');
        $target = array();
        if ($targettype == 1) {
            $this->load->model('groups_model');
            $target = $this->groups_model->get_group($targetid);
        } elseif ($targettype == 2) {
            $this->load->model('users_model');
            $target = $this->users_model->get_user($targetid);
        }
        if (count($target) > 0) {
            $data['targetid'] = $targetid;
            $data['targettype'] = $targettype;
            $data['rows'] = $this->acl_model->get_acl($targetid, $targettype);
            if ($targettype == 2) {
                $data['title'] = "(" . 'Usuario' . ": " . $target->NOMBRE . ")";
                $groupacl = $this->acl_model->get_acl_group($targetid);
                $data['groupacl'] = $groupacl;
                foreach ($data['rows'] as $row) {
                    foreach ($groupacl as $res) {
                        if ($row->ID == $res->RESOURCEID) {
                            if ($row->R == 0 and $res->R == 1) {
                                $row->R = 1;
                                $row->R_G = 1;
                            }
                            if ($row->I == 0 and $res->I == 1) {
                                $row->I = 1;
                                $row->I_G = 1;
                            }
                            if ($row->U == 0 and $res->U == 1) {
                                $row->U = 1;
                                $row->U_G = 1;
                            }
                            if ($row->D == 0 and $res->D == 1) {
                                $row->D = 1;
                                $row->D_G = 1;
                            }
                        }
                    }
                }

            } else {
                $data['title'] = "(" . 'Grupo' . ": " . $target->NAME . ")";
            }
            $template['_B'] = 'acl/acl_index.php';
            $this->load->template_view($this->template_base, $data, $template);
        }
    }
}


?>