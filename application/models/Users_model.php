<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model
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

    public function usuarios_todos($order_by = 'usuarios_id')
    {
        $res = array();
        $q = $this->db->order_by($order_by)->get('v_usuarios');
        if ($q->num_rows() > 0) {
            $res = $q->result();
        }
        return $res;
    }

    public function usuario_por_id($id = 0)
    {
        $obj = null;
        $q = $this->db->where('usuarios_id', $id)->get('v_usuarios');
        if ($q->num_rows() > 0) {
            $obj = $q->row();
        }
        return $obj;
    }

    public function insertar($user = array())
    {
        return $this->db->insert('usuarios', $user);
    }

    public function insertar_relacion_grupos($usuarios_id = 0, $grupos_id = 0)
    {
        return $this->db->insert('usersgroups', array('usuarios_id' => $usuarios_id, 'groups_id' => $grupos_id));
    }

    public function editar($user = array())
    {
        return $this->db->update('usuarios', $user, array('usuarios_id' => $user['usuarios_id']));
    }

    public function borrar_relacion_usuario_grupo($data = array())
    {
        return $this->db->delete('usersgroups', $data);
    }

    public function borrar($user = array())
    {
        return $this->db->delete('usuarios', $user);
    }

    public function borrar_con_acl($user = array())
    {
        if ($this->db->delete('usersgroups', array('usuarios_id' => $user['usuarios_id'])) !== false) {
            if ($this->db->delete('accesscontrollist', array('TARGETID' => $user['usuarios_id'], 'TYPEID' => 2)) !== false) {
                return $this->db->delete('usuarios', $user);
            }
        }
        return false;
    }
}