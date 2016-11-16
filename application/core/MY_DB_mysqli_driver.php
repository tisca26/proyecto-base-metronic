<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Extending CodeIgniter DB query builder for extending DB queries
 *
 * @author GGTG
 */

class MY_DB_mysqli_driver extends CI_DB_mysqli_driver
{
    function __construct($params)
    {
        log_message('debug', '------------------ Entramos a my_mysql ------------------');
        parent::__construct($params);
    }

    /**
    Filtrado de visibilidad por sucursal
     **/
    function get_general($table = '', $nombreGrupo = '', $sucursal = '')
    {
        switch($nombreGrupo)
        {
            //Director puede ver todo
            case 'Director001':
            case 'Administrador001':
                return $this->get($table);
                break;

            default:
                $table_cve = $table.'.sucursal_id';
                return $this->where($table_cve, $sucursal)->get($table);
                //$this->get_where($table, $table.'cve_dependencia ='.$grupo);
                break;
        }
    }
}
