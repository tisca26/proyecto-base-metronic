<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_manager
{

    private $CI;

    function __construct()
    {
        $this->CI = &get_instance();
    }

    public function generar_menu($menu = 'menu_web_1')
    {
        global $URI;
        $this->CI->cargar_idioma->carga_lang('menus/' . $menu);
        $menuCurrent = (strlen($URI->segment(1)) > 2) ? $URI->segment(1) : $URI->segment(2);
        $data['menu_root'] = str_replace(" ", "-", strtolower($menuCurrent));
        $this->CI->load->view('menus/' . $menu, $data);
    }

    public function generar_menu_db()
    {
        $tree = array();

        $this->CI->load->model('menu_model');

        $tree = $this->CI->menu_model->generateallActiveTreeArrayByUser(get_attr_session('usr_id'));

        $output = "";

        if (!empty($tree)) {
            $output = '<!-- INICIO GENERACION DE MENUS --><ul class="nav navbar-nav">';
            $this->generarMenuPorNivel($tree, $output);
            $output .= '<!-- FIN GENERACION DE MENUS --></ul>';
        }
        return $output;
    }

    protected function generarMenuPorNivel($tree, &$output, $parent = 0, &$flag = 0, &$level = 1)
    {
        if (isset($tree[$parent])) {
            foreach ($tree[$parent] as $row) {
                if (isset($tree[$row->menu_id]) && $level == 1) {
                    $inner_li = "aria-haspopup='true' class='menu-dropdown classic-menu-dropdown '";
                } elseif (isset($tree[$row->menu_id]) && $level > 1) {
                    $inner_li = "aria-haspopup='true' class='dropdown-submenu '";
                } else {
                    $inner_li = "aria-haspopup='true' class=''";
                }
                $output .= "<li " . $inner_li . ">";

                if (isset($tree[$row->menu_id])) { // revisa si tiene hijos, avanza hasta llegar a la hoja
                    $aux = "";
                    $flag1 = 0;
                    $level_aux = $level;
                    $level_aux++;
                    $this->generarMenuPorNivel($tree, $aux, $row->menu_id, $flag1, $level_aux); //Como si tuvo un hijo avanzamos, esto seguirá hasta llegar a la hoja
                    if ($flag1 == 1) {//si tiene hijo
                        $flag = 1;
                        $icono = '<i class=" ' . $row->icon . '"></i> ';
                        $arrow = '';
                        if ($flag1 == 1) {//Si tiene hijo, le asignamos la flecha de que hay un submenu
                            $arrow = '<span class="arrow"></span>';
                        }
                        $contenido_name = $row->nombre;
                        $class_content = '';
                        if ($level > 1) {
                            $class_content = 'class="nav-link nav-toggle"';
                        }
                        $content = '<a href="javascript:;" ' . $class_content . '>' . $icono . $contenido_name . $arrow . '</a>';
                        $output .= $content;
                        if ($level == 1) {
                            $sub_ul_class = 'class="dropdown-menu pull-left"';
                        } else {
                            $sub_ul_class = 'class="dropdown-menu"';
                        }
                        $output .= "<ul " . $sub_ul_class . ">";
                        $output .= $aux;
                        $output .= "</ul>";
                    } elseif (!empty($row->page_uri)) { //No tiene hijo y si tiene url asignada
                        $icono = '<i class=" ' . $row->icon . '"></i> ';
                        $contenido_name = $row->nombre;
                        $output .= '<a class="btn_loading_page" href="' . base_url() . $row->page_uri . '" >' . $icono . $contenido_name . '</a>';
                        $flag = 1;
                        $level--;
                    }
                } elseif (!empty($row->page_uri)) { // genera contenido del <li> si es que tiene enlace (recurso), YA LLEGAMOS A LA HOJA
                    $icono = $icono = '<i class=" ' . $row->icon . '"></i> ';
                    $contenido_name = $row->nombre;
                    $output .= '<a class="nav-link" href="' . base_url() . $row->page_uri . '">' . $icono . $contenido_name . '</a>';
                    $flag = 1;
                }
                $output .= "</li>";
            }
        }
    }


}

?>
