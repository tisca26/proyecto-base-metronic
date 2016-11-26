<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Clientes_model extends CI_Model
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

    public function clientes_todos($order = 'clientes_id')
    {
        $result = array();
        $query = $this->db->order_by($order)->get('clientes');
        if ($query->num_rows() > 0) {
            $result = $query->result();
        }
        return $result;
    }

    public function insertar_cliente($cliente = array())
    {
        return $this->db->insert('clientes', $cliente);
    }

    public function cliente_por_id($cliente_id = 0)
    {
        $result = new stdClass();
        $query = $this->db->where('clientes_id', $cliente_id)->get('clientes');
        if ($query->num_rows() > 0) {
            $result = $query->row();
        }
        return $result;
    }

    public function editar_cliente($cliente = array())
    {
        return $this->db->update('clientes', $cliente, array('clientes_id' => $cliente['clientes_id']));
    }

    public function borrar_cliente($clientes_id = 0)
    {
        return $this->db->delete('clientes', array('clientes_id' => $clientes_id));
    }

}