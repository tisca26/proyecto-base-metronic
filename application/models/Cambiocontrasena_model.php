<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CambioContrasena_model extends CI_Model
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

    function insertCambioContrasena($pass_final)
    {
        $data = [
            'PASSWORD' => $pass_final
        ];
        return $this->db->update('users', $data, array('ID' => $this->session->userdata('ID')));
    }

}

?>
