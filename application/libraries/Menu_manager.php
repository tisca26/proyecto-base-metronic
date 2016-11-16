<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * This library is used for generate dynamic menu trees
 */
class Menu_manager
{

    /**
     * Constructor
     *
     * @access public
     */
    function __construct()
    {
        $this->CI = &get_instance();
    }

    /**
     * Generate menu site
     */
    function generate_menu()
    {
        $tree = array();

        $CI = get_instance();
        $CI->load->model('menu_model');
        $su = $CI->config->item('su_name');
        $suid = $CI->config->item('su_id');

        if (get_attr_session('usuario') != $su or get_attr_session('ID') != $suid) {
            $tree = $CI->menu_model->generateallActiveTreeArrayByUser(get_attr_session('ID'));
        } else {
            $tree = $CI->menu_model->generateallActiveTreeArray();
        }

        $output = "";

        if (!empty($tree)) {
            $output = '<!-- INICIO GENERACION DE MENUS -->';
            $this->generateMenuByLevel($tree, $output);
            $output .= '<!-- FIN GENERACION DE MENUS -->';
        }
        return $output;
    }

    /**
     * Generate menu by levels
     *
     * @access public
     * @param array , List of menu entries
     * @param string , return html script of menu
     * @param int , depth level in menu tree
     * @param int , return 1 or 0 if exist childs to level returned
     * @param int , level
     */
    function generateMenuByLevel($tree, &$output, $parent = 0, &$flag = 0, &$level = 1)
    {
        if (isset($tree[$parent])) {
            foreach ($tree[$parent] as $row) {
                if (isset($tree[$row->id]) && $level == 1) {
                    $inner_li = "aria-haspopup='true' class='menu-dropdown classic-menu-dropdown '";
                } elseif (isset($tree[$row->id]) && $level > 1) {
                    $inner_li = "aria-haspopup='true' class='dropdown-submenu '";
                }else{
                    $inner_li = "aria-haspopup='true' class=''";
                }
                $output .= "<li " . $inner_li . ">";

                if (isset($tree[$row->id])) { // revisa si tiene hijos, avanza hasta llegar a la hoja
                    $aux = "";
                    $flag1 = 0;
                    $level_aux = $level;
                    $level_aux++;
                    $this->generateMenuByLevel($tree, $aux, $row->id, $flag1, $level_aux); //Como si tuvo un hijo avanzamos, esto seguirá hasta llegar a la hoja
                    if ($flag1 == 1) {//si tiene hijo
                        $flag = 1;
                        $icono = '<i class=" ' . $row->icon . '"></i> ';
                        $arrow = '';
                        if ($flag1 == 1) {//Si tiene hijo, le asignamos la flecha de que hay un submenu
                            $arrow = '<span class="arrow"></span>';
                        }
                        $contenido_name = $row->name;
                        $content = '<a href="javascript:;">' . $icono . $contenido_name . $arrow . '</a>';
                        $output .= $content;
                        if ($level == 1){
                            $sub_ul_class = 'class="dropdown-menu pull-left"';
                        }else{
                            $sub_ul_class = 'class="dropdown-menu"';
                        }
                        $output .= "<ul " . $sub_ul_class . ">";
                        $output .= $aux;
                        $output .= "</ul>";
                    } elseif (!empty($row->page_uri)) { //No tiene hijo y si tiene url asignada
                        $icono = '<i class=" ' . $row->icon . '"></i> ';
                        $contenido_name = $row->name;
                        $output .= '<a href="' . base_url_lang() . $row->page_uri . '" >' . $icono . $contenido_name . '</a>';
                        $flag = 1;
                        $level--;
                    }
                } elseif (!empty($row->page_uri)) { // genera contenido del <li> si es que tiene enlace (recurso), YA LLEGAMOS A LA HOJA
                    $icono = $icono = '<i class=" ' . $row->icon . '"></i> ';
                    $contenido_name = $row->name;
                    $output .= '<a href="' . base_url_lang() . $row->page_uri . '">' . $icono . $contenido_name . '</a>';
                    $flag = 1;
                }
                $output .= "</li>";
            }
        }
    }
}

?>
