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

    /**
     * Return all item of groups table
     *
     * @access public
     * @return Array of rows
     */
    function get_all()
    {
        $data = array();

        $query = $this->db->get('groups');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }

        return $data;
    }

    /**
     * Return one item of groups table
     *
     * @access public
     * @param  int
     * @return One row of groups table
     */
    function get_group($id)
    {
        $data = array();

        $query = $this->db->where('ID', $id)->get('groups');

        if ($query->num_rows() > 0) {
            $data = $query->row();
        }

        return $data;
    }

    /**
     * Return all item enabled of groups table
     *
     * @access public
     * @return Array of rows
     */
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

    /**
     * Insert an item into groups table
     *
     * @access public
     * @param  string , Group name
     * @param  boolean , available status
     * @return int, identity number inside group table
     */
    function insert($name, $enable)
    {

        $data = array(
            'NAME' => $name,
            'ENABLE' => $enable
        );

        $this->db->insert('groups', $data);
        return $this->identity();

    }

    /**
     * Delete an item from groups table
     *
     * @access public
     * @param  int
     * @return int, 0 (Successful) and 1 (Group asigned to any user)
     */
    function delete($id)
    {
        $query = $this->db->where('GROUPID', $id)->get('usersgroups');

        if ($query->num_rows() == 0) {
            $this->db->delete('accesscontrollist', array('TARGETID' => $id, 'TYPEID' => 1));
            $this->db->delete('groups', array('ID' => $id));
            return 0;
        } else
            return 1;
    }

    /**
     * Update all field (except ID field) of an item in groups table
     *
     * @access public
     * @param  int , Group id
     * @param  string , Group Name
     * @param  boolean , Available status
     */
    function update_all($id, $name, $enable)
    {

        $data = array(
            'NAME' => $name,
            'ENABLE' => $enable
        );

        $this->db->update('groups', $data, array('ID' => $id));
    }

    /**
     * Update all field of groups table included in array parameter
     * Ex: array('field_name' => 'content_of_field')
     *
     * @access public
     * @param  int , Group id
     * @param  array , Array of group property to update
     * @return
     */
    function update_custom($id, $data)
    {

        $this->db->update('groups', $data, array('ID' => $id));
    }

    /**
     * Return last id inserted
     *
     * @access public
     * @return int
     */
    function identity()
    {
        return $this->db->insert_id();
    }
}


?>