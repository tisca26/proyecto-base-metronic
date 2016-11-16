<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users_model extends CI_Model
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
     * Return all item of users table
     *
     * @access public
     * @return Array of rows
     */
    function get_all()
    {
        $data = array();

        $this->db->select('u.ID, u.NICKNAME, u.NOMBRE, u.APELLIDO, u.EMAIL, 
                            u.rfc, u.CELULAR, u.CREATEDATE, s.nombre, u.ENABLE,
                            g.NAME AS GRUPO, u.SUCURSAL_ID');
        $this->db->from('users u, groups g, usersgroups ug, sucursal s');
        $this->db->where('u.SUCURSAL_ID = s.sucursal_id
                            and u.ID = ug.USERID
                            and ug.GROUPID = g.ID');
        $this->db->order_by('u.ID', 'asc');
        /*
        $this->db->select('users.*');
        $this->db->from('users');
        $this->db->order_by('ID', 'asc');
        */
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }

        return $data;
    }

    /**
     * Return users by filter
     *
     * @access public
     * @return Array of rows
     */
    function get_users($enabled = '')
    {
        $data = array();

        $filter = array();
        if ($enabled !== '') $filter['ENABLE'] = $enabled;

        $this->db->select('users.*');
        $this->db->from('users');
        $query = $this->db->where($filter)->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }

        return $data;
    }

    /**
     * Return one item of users table
     *
     * @access public
     * @param  int
     * @return One row of users table
     */
    function get_user($id)
    {
        $data = array();

        $this->db->select('users.*');
        $this->db->from('users');
        $query = $this->db->where('users.ID', $id)->get();

        if ($query->num_rows() > 0) {
            $data = $query->row();
        }

        return $data;
    }

    function getUserByRfc($rfc)
    {
        $data = array();

        $this->db->select('users.*');
        $this->db->from('users');
        $query = $this->db->where('users.RFC', $rfc)->get();

        if ($query->num_rows() > 0) {
            $data = $query->row();
        }

        return $data;
    }

    /**
     * Return image path by type
     *
     * @access public
     * @param int , user id
     * @param string , image type
     * @return One row of users table
     */
    function get_image($id, $type)
    {
        $data = "";
        $query = $this->db->where(array('USERID' => $id, 'TYPE' => $type))->get('usersimages');

        if ($query->num_rows() > 0) {
            $data = $query->row()->IMAGESRC;
        }

        return $data;
    }

    /**
     * Insert an item into users table
     *
     * @access public
     * @param  string , Nick name
     * @param  string , User password
     * @param  string , User Name
     * @param  string , User surename
     * @param  string , email
     * @param  string , cellular number
     * @param  int , department id
     * @param  bool , available status
     * @return int, identity number inside users table
     */
    function insert($nick, $paswd, $name, $surename, $email, $cellular, $subsecretary, /* $department,*/
                    $enable, $rfc)
    {

        $data = array(
            'NICKNAME' => $nick,
            'NOMBRE' => $name,
            'APELLIDO' => $surename,
            'EMAIL' => $email,
            'PASSWORD' => $paswd,
            'ENABLE' => $enable,
            'CREATEDATE' => date(DATE_ATOM),
            'CELULAR' => $cellular,
            'SUCURSAL_ID' => $subsecretary,
            'RFC' => $rfc,
        );

        $this->db->insert('users', $data);
        $id = $this->identity();

//        $this->update_user_department($id, $department);
        return $id;
    }

    /**
     * Delete an item from users table
     *
     * @access public
     * @param  int , user id
     * @return
     */
    function delete($id)
    {
        $this->db->delete('usersgroups', array('USERID' => $id));
        //  $this->db->delete('usersdepartments', array('USERID' => $id));
        $this->db->delete('accesscontrollist', array('TARGETID' => $id, 'TYPEID' => 2));
        $this->db->delete('users', array('ID' => $id));
    }

    /**
     * Update all field (except ID field and password) of an item in users table
     * Password field will be updated by 'update_password' function
     *
     * @access public
     * @param  int , user id
     * @param  string , Nick name
     * @param  string , User Name
     * @param  string , User surename
     * @param  string , email
     * @param  string , cellular number
     * @param  int , department id
     * @param  bool , available status
     */
    function update_all($id, $nick, $name, $surname, $email, $cellular, $subsecretary, $enable, $rfc)
    {

        $data = array(
            'NICKNAME' => $nick,
            'NOMBRE' => $name,
            'APELLIDO' => $surname,
            'EMAIL' => $email,
            'ENABLE' => $enable,
            'CELULAR' => $cellular,
            'SUCURSAL_ID' => $subsecretary,
            'RFC' => $rfc,
        );

        $this->db->update('users', $data, array('ID' => $id));
    }

    /**
     * Update Password field of an item in users table
     * Password field will be updated by 'update_password' function
     *
     * @access public
     * @param  int , user id
     * @param  string , Password
     */
    function update_password($id, $password)
    {

        $data = array('PASSWORD' => $password);

        $this->db->update('users', $data, array('ID' => $id));
    }

    /**
     * Update user images
     *
     * @access public
     * @param int , user id
     * @param string , image type
     * @param string , image path
     */
//    function update_image($id, $type, $imagepath){
//
//        $this->delete_image($id, $type);
//
//        $data = array(
//            'USERID' => $id,
//            'TYPE' => $type,
//            'IMAGESRC' => $imagepath
//            );
//
//        $this->db->insert('usersimages', $data);
//    }

    /**
     * delete user images by type
     *
     * @access public
     * @param  int , user id
     * @param  string , image type
     */
//    function delete_image($id, $type){
//
//        $this->db->delete('usersimages', array('USERID' => $id, 'TYPE' => $type));
//    }

    /**
     * Update all field of users table included in array parameter
     * Ex: array('field_name' => 'content_of_field')
     *
     * @access public
     * @param  int , User id
     * @param  array , Array of user property to update
     * @return
     */
    function update_custom($id, $data)
    {

        $this->db->update('users', $data, array('ID' => $id));
    }

    /**
     * Get user - groups relation
     *
     * @access public
     * @param  int
     * @return
     */
    function get_user_group($id)
    {

        $data = array();

        $query = $this->db->where(array('USERID' => $id))->get('usersgroups');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }

        return $data;
    }

    /**
     * check if user nick exist
     *
     * @access public
     * @param  string , user nick
     * @return bool, return TRUE if nick exist otherwise return FALSE
     */
    function nick_exist($nick, $id = -1)
    {
        if ($id < 0)
            $query = $this->db->where(array('NICKNAME' => $nick))->get('users');
        else {
            $query = $this->db->where(array('NICKNAME' => $nick, 'ID !=' => $id))->get('users');
        }
        return ($query->num_rows() > 0) ? TRUE : FALSE;
    }

    /**
     * check if user has email
     *
     * @access public
     * @param  string , user nick
     * @return string, email address
     */
    function has_email($nick)
    {

        $query = $this->db->where(array('NICKNAME' => $nick))->get('users');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->EMAIL;
        } else
            return '';
    }

    /**
     * Insert user - group relation
     *
     * @access public
     * @param  int , user id
     * @param  int , group id
     * @return
     */
    function insert_group_relation($id, $groupid)
    {

        $data = array(
            'USERID' => $id,
            'GROUPID' => $groupid
        );

        $this->db->insert('usersgroups', $data);
    }

    /**
     * Update user - groups relations
     *
     * @access public
     * @param  int , user id
     * @param  array of group ids
     */
    function update_group_relation($id, $groups)
    {

        $this->db->delete('usersgroups', array('USERID' => $id));

        foreach ($groups as $groupid) {
            $this->insert_group_relation($id, $groupid);
        }
    }

    /**
     * Update user - department relation
     *
     * @access public
     * @param  int , user id
     * @param  array of department id
     */
//    function update_user_department($id, $department){
//        if (is_numeric($department)){
//            $this->db->delete('usersdepartments', array('USERID' => $id));
//            
//            $data = array(
//               'USERID' => $id,
//                'DEPARTMENTID' => $department
//                );
//            $this->db->insert('usersdepartments', $data);
//        }
//        elseif (empty($department))
//            $this->db->delete('usersdepartments', array('USERID' => $id));
//
//    }

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