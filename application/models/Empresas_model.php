<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Empresas_model extends CI_Model
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

    public function empresas_todos($order = 'empresas_id')
    {
        $result = array();
        $query = $this->db->order_by($order)->get('empresas');
        if ($query->num_rows() > 0) {
            $result = $query->result();
        }
        return $result;
    }

    public function insertar_empresa($empresa = array())
    {
        return $this->db->insert('empresas', $empresa);
    }

    public function empresa_por_id($empresa_id = 0)
    {
        $result = new stdClass();
        $query = $this->db->where('empresas_id', $empresa_id)->get('empresas');
        if ($query->num_rows() > 0) {
            $result = $query->row();
        }
        return $result;
    }

    public function editar_empresa($empresa = array())
    {
        return $this->db->update('empresas', $empresa, array('empresas_id' => $empresa['empresas_id']));
    }

    public function borrar_empresa($empresas_id = 0)
    {
        return $this->db->delete('empresas', array('empresas_id' => $empresas_id));
    }

}