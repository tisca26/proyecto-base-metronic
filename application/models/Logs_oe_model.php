<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Logs_oe_model extends CI_Model
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

    function insertLogs($data)
    {
        $this->db->reconnect();
        $fecha = date('Y-m-d H:i:s');
        $data['fecha_registro'] = $fecha;
        $data['ip_usuario'] = $this->input->ip_address();
        $data['agente'] = $this->input->user_agent();
        $data['nickname'] = $this->session->userdata('usuario');
        $data['sucursal_id'] = $this->session->userdata('sucursal_id');
        $data['sucursal'] = $this->session->userdata('sucursal');
        $data['user_rol'] = $this->session->userdata('nombregrupo');
        $nickname = $this->session->userdata('usuario');
        $data['id_user'] = $this->getUsuarios($nickname);

        // Obtiene las instancias
        $ci =& get_instance();
        // Muestra el nombre del controlador
        $ci->router->fetch_class();
        // Muestra el nombre del metodo que se esta ejecutando
        $menu = $ci->router->fetch_method();
        $clase = $ci->router->fetch_class();
        $data['controller'] = $clase;
        $data['metodo'] = $menu;


        $this->db->insert('logs_oe', $data);
        return $this->db->insert_id();
    }

    function getUsuarios($val)
    {
        $query = $this->db->query('SELECT * FROM users WHERE nickname = ?', $val)->result();
        foreach ($query as $valor) {
            $valor_id = $valor->ID;
        }
        return $valor_id;
    }

}

?>
