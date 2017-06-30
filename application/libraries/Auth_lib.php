<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_lib
{
    private $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function login($usr, $pass)
    {
        $res = false;
        //Verify common user data
        $query = $this->CI->db->where(array('username' => $usr, 'estatus' => 1))->get('usuarios');
        if ($query->num_rows() > 0) {
            $dbpassword = $query->row()->passwd;
            if (password_verify($pass, $dbpassword)) {
                set_attr_session('logged_in', 'OK_LOGIN');
                set_attr_session('usr_id', $query->row()->usuarios_id);
                set_attr_session('usr_nombre', $query->row()->nombre);
                set_attr_session('usr_apellidos', $query->row()->apellido_paterno . ' ' . $query->row()->apellido_materno);
                $obj = new stdClass();
                $obj->name = 'Gerry';
                $obj->last = "Tisca";
                $obj->age = 26;
                set_attr_session('obj', $obj);
                $res = true;
            }
        }
        return $res;
    }

    public function logout()
    {
        $this->CI->session->sess_destroy();
    }

    public function check_access()
    {
        if (!get_attr_session('logged_in')) {
            $actual_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            set_attr_session('intento_url', $actual_url);
            return redirect('admin_sys');
        } else {
            set_attr_session('intento_url', '');
            return true;
        }
    }

    public function get_acl($userid = 0)
    {
        $data = array();

        $sql =
            'SELECT r.resource, acl.* ' .
            'FROM usersgroups ug ' .
            'INNER JOIN accesscontrollist acl ON ug.groups_id = acl.TARGETID and acl.TYPEID = 1 ' .
            'INNER JOIN resources r ON r.resources_id = acl.RESOURCEID ' .
            'INNER JOIN groups g ON g.groups_id = ug.groups_id ' .
            'WHERE ug.usuarios_id = ? and g.estatus = 1 ' .
            'UNION ' .
            'SELECT r.resource, acl.* ' .
            'FROM accesscontrollist acl ' .
            'INNER JOIN resources r ON r.resources_id = acl.RESOURCEID ' .
            'INNER JOIN usuarios u ON u.usuarios_id = acl.TARGETID ' .
            'WHERE acl.TARGETID = ? and acl.TYPEID = 2 and u.estatus = 1';

        $query = $this->CI->db->query($sql, array($userid, $userid));
        if ($query->num_rows() > 0) {
            $data = $query->result();
        }
        return $data;
    }
}