<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Privy extends CI_Controller
{
    private $read_list = array();
    private $insert_list = array();
    private $update_list = array();
    private $delete_list = array();

    public function __construct()
    {
        parent::__construct();
    }

    protected function check_access()
    {
        if (get_attr_session('logged_in') !== 'OK_LOGIN') {
            $actual_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            set_attr_session('intento_url', $actual_url);
            return redirect('admin_sys');
        } else {
            set_attr_session('intento_url', '');
            $acl = $this->auth_lib->get_acl(get_attr_session('usr_id'));
            $route = $this->router->class . '/' . $this->router->method;
            $valid = FALSE;
            //In case of "controller_name/action_name" resource format
            foreach ($acl as $item) {
                if (strcasecmp(trim($item->resource), $route) == 0) {
                    if (in_array($this->router->method, $this->read_list)) {
                        $valid = ($item->R != 0);
                    }
                    if (in_array($this->router->method, $this->insert_list)) {
                        $valid = ($item->I != 0);
                    }
                    if (in_array($this->router->method, $this->update_list)) {
                        $valid = ($item->U != 0);
                    }
                    if (in_array($this->router->method, $this->delete_list)) {
                        $valid = ($item->D != 0);
                    }
                    if ($valid) {
                        break;
                    }
                }
            }
            if (!$valid) {
                $route = $this->router->class;
                //In case of "controller_name" resource format
                foreach ($acl as $item) {
                    if (strcasecmp(trim($item->resource), $route) == 0) {
                        if (in_array($this->router->method, $this->read_list))
                            $valid = ($item->R != 0);
                        if (in_array($this->router->method, $this->insert_list))
                            $valid = ($item->I != 0);
                        if (in_array($this->router->method, $this->update_list))
                            $valid = ($item->U != 0);
                        if (in_array($this->router->method, $this->delete_list))
                            $valid = ($item->D != 0);
                        if ($valid)
                            break;
                    }
                }
            }
            if (!$valid) {
                redirect('mensajes_sys/denegado');
            }
        }
    }

    /**
     * Set function name list for read propouses
     *
     * @access public
     */
    protected function set_read_list($list)
    {
        $this->read_list = $list;
    }

    /**
     * Set function name list for insert propouses
     *
     * @access public
     */
    protected function set_insert_list($list)
    {
        $this->insert_list = $list;
    }

    /**
     * Set function name list for update propouses
     *
     * @access public
     */
    protected function set_update_list($list)
    {
        $this->update_list = $list;
    }

    /**
     * Set function name list for delete propouses
     *
     * @access public
     */
    protected function set_delete_list($list)
    {
        $this->delete_list = $list;
    }
}