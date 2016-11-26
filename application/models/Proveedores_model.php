<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Proveedores_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function ultimo_id()
    {
        return $this->db->insert_id();
    }

    function error_consulta()
    {
        return $this->db->error();
    }

    public function proveedores_todos($order = 'proveedores_id')
    {
        $result = array();
        $query = $this->db->order_by($order)->get('proveedores');
        if ($query->num_rows() > 0) {
            $result = $query->result();
        }
        return $result;
    }

    public function insertar_proveedor($proveedor = array())
    {
        return $this->db->insert('proveedores', $proveedor);
    }

    public function proveedor_por_id($proveedor_id = 0)
    {
        $result = new stdClass();
        $query = $this->db->where('proveedores_id', $proveedor_id)->get('proveedores');
        if ($query->num_rows() > 0) {
            $result = $query->row();
        }
        return $result;
    }

    public function editar_proveedor($proveedor = array())
    {
        return $this->db->update('proveedores', $proveedor, array('proveedores_id' => $proveedor['proveedores_id']));
    }

    public function borrar_proveedor($proveedores_id = 0)
    {
        return $this->db->delete('proveedores', array('proveedores_id' => $proveedores_id));
    }
}