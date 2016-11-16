<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Acl_model extends CI_Model
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

    /**
     * Return all permision for a group or user
     *
     * @param int , group or user ID
     * @param int , group (1) or user (2) type
     * @return Array of rows
     */
    function get_acl($targetid, $targettype)
    {
        $data = array();

        $sql = 'SELECT r.ID, r.RESOURCE, acl.*, 0 as R_G, 0 as I_G, 0 as U_G, 0 as D_G FROM resources r left join accesscontrollist acl on acl.RESOURCEID = r.ID and acl.TARGETID = ? and acl.TYPEID = ? ';

        $query = $this->db->query($sql, array($targetid, $targettype));
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    /**
     * Return groups acl for an user
     *
     * @param int , user ID
     * @return Array of rows
     */
    function get_acl_group($userid)
    {
        $data = array();

        $sql = 'SELECT acl.RESOURCEID, bit_or(acl.R) as R, bit_or(acl.I) as I, bit_or(acl.U) as U, bit_or(acl.U) as D FROM usersgroups ug inner join accesscontrollist acl on acl.TARGETID = ug.GROUPID and acl.TYPEID=1 WHERE ug.USERID = ? GROUP BY acl.RESOURCEID ORDER BY RESOURCEID';

        $query = $this->db->query($sql, array($userid));
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
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
    function update($targetid, $targettype, $data)
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


?>