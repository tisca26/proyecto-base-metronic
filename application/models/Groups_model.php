<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Groups_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function ultimo_id()
    {
        return $this->db->insert_id();
    }

    public function error_consulta()
    {
        return $this->db->error();
    }

    public function grupo_por_id($id = 0)
    {
        $obj = null;
        $q = $this->db->where('groups_id', $id)->get('groups');
        if ($q->num_rows() > 0) {
            $obj = $q->row();
        }
        return $obj;
    }

    public function grupos_todos($order_by = 'groups_id')
    {
        $res = array();
        $q = $this->db->order_by($order_by)->get('groups');
        if ($q->num_rows() > 0) {
            $res = $q->result();
        }
        return $res;
    }

    public function insertar($grupo = array())
    {
        return $this->db->insert('groups', $grupo);
    }

    public function editar($grupo = array())
    {
        return $this->db->update('groups', $grupo, array('groups_id' => $grupo['groups_id']));
    }

    public function borrar($grupo = array())
    {
        return $this->db->delete('groups', $grupo);
    }

    public function borrar_con_acl($grupo = array())
    {
        if ($this->db->delete('groups', $grupo) !== false) {
            return $this->db->delete('accesscontrollist', array('TARGETID' => $grupo['groups_id'], 'TYPEID' => 1));
        }
        return false;
    }
}