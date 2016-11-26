<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Groups_model extends CI_Model
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

    function get_all()
    {
        $data = array();
        $query = $this->db->get('groups');
        if ($query->num_rows() > 0) {
            $data = $query->result();
        }
        return $data;
    }

    function get_group($id)
    {
        $data = new stdClass();
        $query = $this->db->where('ID', $id)->get('groups');
        if ($query->num_rows() > 0) {
            $data = $query->row();
        }
        return $data;
    }

    function get_enables()
    {
        $data = array();

        $query = $this->db->where('ENABLE', 1)->get('groups');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }

        return $data;
    }

    function insert($name, $enable)
    {
        $data = array(
            'NAME' => $name,
            'ENABLE' => $enable
        );
        return $this->db->insert('groups', $data);
    }

    function delete($id)
    {
        $query = $this->db->where('GROUPID', $id)->get('usersgroups');
        if ($query->num_rows() == 0) {
            $this->db->delete('accesscontrollist', array('TARGETID' => $id, 'TYPEID' => 1));
            return $this->db->delete('groups', array('ID' => $id));
        } else {
            return FALSE;
        }
    }

    function update_all($id, $name, $enable)
    {
        $data = array(
            'NAME' => $name,
            'ENABLE' => $enable
        );

        return $this->db->update('groups', $data, array('ID' => $id));
    }

    function update_custom($id, $data)
    {

        $this->db->update('groups', $data, array('ID' => $id));
    }

    function identity()
    {
        return $this->db->insert_id();
    }

    function error_consulta()
    {
        return $this->db->error();
    }
}


?>