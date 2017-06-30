<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User
{
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('users_model');
    }

    public function usuarios_todos($order_by = 'usuarios_id')
    {
        $res = $this->CI->users_model->usuarios_todos($order_by);
        return $res;
    }

    public function insertar_con_grupos($user = array(), $grupos = array())
    {
        if ($this->CI->users_model->insertar($user)) {
            $id = $this->CI->users_model->ultimo_id();
            foreach ($grupos as $grupo) {
                if (!$this->CI->users_model->insertar_relacion_grupos($id, $grupo)) {
                    return false;
                }
            }
            return true;
        } else {
            return false;
        }
    }

    public function editar_con_grupos($user = array(), $grupos = array())
    {
        if ($this->CI->users_model->editar($user)) {
            if ($this->CI->users_model->borrar_relacion_usuario_grupo(array('usuarios_id' => $user['usuarios_id'])) !== false) {
                foreach ($grupos as $grupo) {
                    if (!$this->CI->users_model->insertar_relacion_grupos($user['usuarios_id'], $grupo)) {
                        return false;
                    }
                }
            }
        } else {
            return false;
        }
        return true;
    }

    public function usuario_por_id($id = 0)
    {
        return $this->CI->users_model->usuario_por_id($id);
    }

    public function editar($usuario = array())
    {
        return $this->CI->users_model->editar($usuario);
    }

    public function borrado_final($user = array())
    {
        return (isset($user['usuarios_id']))? $this->CI->users_model->borrar_con_acl($user) : $this->CI->users_model->borrar($user);
    }
}