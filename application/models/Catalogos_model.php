<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Catalogos_model extends CI_Model
{

    /**
     * Constructor
     *
     * @access public
     */
    function __construct()
    {
        parent::__construct();
    }

    public function loadUsuarioPerfil($id)
    {
        $data = array();
        $query = $this->db->where('v_usuarios.usuario', $id)->get('v_usuarios');
        if ($query->num_rows() > 0) {
            $data = $query->row();
        }
        return $data;
    }
}

?>