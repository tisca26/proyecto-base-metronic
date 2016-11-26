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

        $this->db->select('u.ID, u.NICKNAME, u.NOMBRE, u.APELLIDOS, u.EMAIL, 
                            u.CREATEDATE, u.ENABLE,
                            g.NAME AS GRUPO');
        $this->db->from('users u, groups g, usersgroups ug');
        $this->db->where('u.ID = ug.USERID and ug.GROUPID = g.ID');
        $this->db->order_by('u.ID', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->result();
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
        $data = NULL;
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

    function insert($nick, $paswd, $name, $surename, $email, $enable)
    {

        $data = array(
            'NICKNAME' => $nick,
            'NOMBRE' => $name,
            'APELLIDOS' => $surename,
            'EMAIL' => $email,
            'PASSWORD' => $paswd,
            'ENABLE' => $enable,
            'CREATEDATE' => date('Y-m-d H:i:s'),
            'EDITDATE' => date('Y-m-d H:i:s')
        );

        $this->db->insert('users', $data);
        $id = $this->identity();

//        $this->update_user_department($id, $department);
        return $id;
    }

    function delete($id)
    {
        $this->db->delete('usersgroups', array('USERID' => $id));
        $this->db->delete('accesscontrollist', array('TARGETID' => $id, 'TYPEID' => 2));
        $this->db->delete('users', array('ID' => $id));
    }

    function update_all($id, $nick, $name, $surname, $email, $enable)
    {
        $data = array(
            'NICKNAME' => $nick,
            'NOMBRE' => $name,
            'APELLIDOS' => $surname,
            'EMAIL' => $email,
            'ENABLE' => $enable,
            'EDITDATE' => date('Y-m-d H:i:s')
        );

        return $this->db->update('users', $data, array('ID' => $id));
    }

    function update_password($id, $password)
    {

        $data = array('PASSWORD' => $password);

        $this->db->update('users', $data, array('ID' => $id));
    }

    function update_custom($id, $data)
    {

        $this->db->update('users', $data, array('ID' => $id));
    }

    function get_user_group($id)
    {
        $data = NULL;
        $query = $this->db->where(array('USERID' => $id))->get('usersgroups');
        if ($query->num_rows() > 0) {
            $data = $query->row();
        }
        return $data;
    }

    function nick_exist($nick, $id = -1)
    {
        if ($id < 0)
            $query = $this->db->where(array('NICKNAME' => $nick))->get('users');
        else {
            $query = $this->db->where(array('NICKNAME' => $nick, 'ID !=' => $id))->get('users');
        }
        return ($query->num_rows() > 0) ? TRUE : FALSE;
    }

    function has_email($nick)
    {

        $query = $this->db->where(array('NICKNAME' => $nick))->get('users');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->EMAIL;
        } else
            return '';
    }

    function insert_group_relation($id, $groupid)
    {
        $data = array(
            'USERID' => $id,
            'GROUPID' => $groupid
        );
        return $this->db->insert('usersgroups', $data);
    }

    function update_group_relation($id = 0, $groupid = '')
    {
        $this->db->delete('usersgroups', array('USERID' => $id));
        $data = array(
            'USERID' => $id,
            'GROUPID' => $groupid
        );
        return $this->db->insert('usersgroups', $data);
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