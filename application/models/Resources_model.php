<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Resources_model extends CI_Model
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
     * Return all item of resources table
     *
     * @access public
     * @return Array of rows
     */
    function get_all()
    {
        $data = array();

        $query = $this->db->get('resources');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }

        return $data;
    }

    /**
     * Return one item of resources table
     *
     * @access public
     * @param  int
     * @return One row of resources table
     */
    function get_resource($id)
    {
        $data = array();

        $query = $this->db->where('ID', $id)->get('resources');

        if ($query->num_rows() > 0) {
            $data = $query->row();
        }

        return $data;
    }

    /**
     * Insert an item into resources table
     *
     * @access public
     * @param  string
     * @return
     */
    function insert($name)
    {

        $data = array(
            'RESOURCE' => $name
        );

        $this->db->insert('resources', $data);
        return $this->identity();

    }

    /**
     * Delete an item from resources table
     *
     * @access public
     * @param  int
     * @return
     */
    function delete($id)
    {
        $this->db->delete('accesscontrollist', array('RESOURCEID' => $id));
        $this->db->delete('resources', array('ID' => $id));
    }

    /**
     * Update the name of an item in resources table
     *
     * @access public
     * @param  int , string
     * @return
     */
    function update($id, $name)
    {

        $data = array(
            'RESOURCE' => $name
        );

        $this->db->update('resources', $data, array('ID' => $id));
    }

    /**
     * Return last id inserted
     *
     * @access public
     * @param
     * @return int
     */
    function identity()
    {
        return $this->db->insert_id();
    }
}


?>