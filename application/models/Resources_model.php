<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Resources_model extends CI_Model
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

    public function recursos_todos($order_by = 'resources_id')
    {
        $res = array();
        $q = $this->db->order_by($order_by)->get('resources');
        if ($q->num_rows() > 0) {
            $res = $q->result();
        }
        return $res;
    }

    public function recursos_todos_sel($order_by = 'resources_id')
    {
        $recs = $this->recursos_todos($order_by);
        $res = array();
        foreach ($recs as $rec) {
            $res[$rec->resources_id] = $rec->resource;
        }
        return $res;
    }

    public function recursos_por_id($id = 0)
    {
        $obj = null;
        $q = $this->db->where('resources_id', $id)->get('resources');
        if ($q->num_rows() > 0) {
            $obj = $q->row();
        }
        return $obj;
    }

    public function insertar($data = array())
    {
        return $this->db->insert('resources', $data);
    }

    public function editar($data = array())
    {
        return $this->db->update('resources', $data, array('resources_id' => $data['resources_id']));
    }

    public function borrar($id = 0)
    {
        return $this->db->delete('resources', array('resources_id' => $id));
    }
}