<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Group
{
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('groups_model');
    }

    public function grupo_por_id($id = 0)
    {
        return $this->CI->groups_model->grupo_por_id($id);
    }

    public function grupos_todos($order_by = 'groups_id')
    {
        $res = $this->CI->groups_model->grupos_todos($order_by);
        return $res;
    }

    public function insertar($grupo = array())
    {
        return $this->CI->groups_model->insertar($grupo);
    }

    public function editar($grupo = array())
    {
        return $this->CI->groups_model->editar($grupo);
    }

    public function borrado_final($grupo = array())
    {
        return (isset($grupo['groups_id'])) ? $this->CI->groups_model->borrar_con_acl($grupo) : $this->CI->groups_model->borrar($grupo);
    }
}