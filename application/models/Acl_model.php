<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Acl_model extends CI_Model
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

    /**
     * Return all permision for a group or user
     *
     * @param int , group or user ID
     * @param int , group (1) or user (2) type
     * @return Array of rows
     */
    public function get_acl($targetid = 0, $targettype = 0)
    {
        $data = array();
        $sql = 'SELECT r.resources_id, r.resource, acl.*, 0 as R_G, 0 as I_G, 0 as U_G, 0 as D_G ' .
            'FROM resources r ' .
            'LEFT JOIN accesscontrollist acl ON acl.RESOURCEID = r.resources_id AND acl.TARGETID = ? AND acl.TYPEID = ? ';
        $query = $this->db->query($sql, array($targetid, $targettype));
        if ($query->num_rows() > 0) {
            $data = $query->result();
        }
        return $data;
    }

    /**
     * Return groups acl for an user
     *
     * @param int , user ID
     * @return Array of rows
     */
    public function get_acl_group($userid = 0)
    {
        $data = array();
        $sql = 'SELECT acl.RESOURCEID, bit_or(acl.R) as R, bit_or(acl.I) as I, bit_or(acl.U) as U, bit_or(acl.U) as D ' .
            'FROM usersgroups ug ' .
            'INNER JOIN accesscontrollist acl ON acl.TARGETID = ug.groups_id AND acl.TYPEID=1 ' .
            'WHERE ug.usuarios_id = ? ' .
            'GROUP BY acl.RESOURCEID ' .
            'ORDER BY acl.RESOURCEID';
        $query = $this->db->query($sql, array($userid));
        if ($query->num_rows() > 0) {
            $data = $query->result();
        }
        return $data;
    }

    /**
     * Update the name of an item in resources table
     *
     * @access public
     * @param int , group or user ID
     * @param int , group (1) or user (2) type
     * @param array [RESOURCEID][R,I,U,D], Matrix of permissions
     */
    public function update($targetid, $targettype, $data)
    {
        $this->db->delete('accesscontrollist', array('TARGETID' => $targetid, 'TYPEID' => $targettype));
        foreach ($data as $key => $value) {
            $data = array(
                'TARGETID' => $targetid,
                'TYPEID' => $targettype,
                'RESOURCEID' => $key,
                'R' => $value['R'],
                'I' => $value['I'],
                'U' => $value['U'],
                'D' => $value['D']
            );
            $this->db->insert('accesscontrollist', $data);
        }
    }
}