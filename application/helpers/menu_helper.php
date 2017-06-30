<?php defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('menu_lang_sel')) {
    function menu_lang_sel()
    {
        $CI =& get_instance();
        $langs = $CI->config->item('lang_uri_abbr');

        $actual_lang = lang_segment();
        $result = '<div id="lang-sel" class="btn-group nomargin pull-right visible-lg visible-md">';
        $result .= '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">';
        $result .= '<img src="' . cdn_assets() . 'images/icons/flags/' . $actual_lang .'.png" alt="' . $langs[$actual_lang] . '">';
        $result .= '&nbsp;&nbsp;<span class="caret"></span></button><ul class="dropdown-menu dropdown-menu-right" role="menu">';

        foreach ($langs as $key => $lang){
            if ($key != $actual_lang){
                $result .= '<li><a class="text-uppercase" href="' . cambia_idioma($key) . '">';
                $result .= '<img src="' . cdn_assets() . 'images/icons/flags/' . $key .'.png" alt="' . $langs[$key] . '"> ' . $key . '</a></li>';
            }
        }
        $result .= '</ul></div>';
        return $result;
    }
}

if (!function_exists('genera_menu_idioma')) {
    function genera_menu_idioma()
    {
        $CI =& get_instance();
        $abbr = $CI->config->item('language_abbr');
        $idioma_actual = idioma_por_abbr($abbr);

        $result = '';

        $result .= '<ul class="nav nav-pills"><li><a href="#" class="dropdown-menu-toggle" id="dropdownLanguage" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">';
        $result .= $idioma_actual;
        $result .= '<i class="fa fa-sort-down"></i></a><ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownLanguage">';
        $result .= '<li><a href="' . cambia_idioma('es') . '"><img src="' . cdn_assets() . '/img/blank.gif" class="flag flag-es" alt="Español"> Español</a></li>';
        $result .= '<li><a href="' . cambia_idioma('en') . '"><img src="' . cdn_assets() . '/img/blank.gif" class="flag flag-us" alt="English"> English</a></li>';
        $result .= '</ul></li></ul>';

        return $result;
    }
}

if (!function_exists('genera_menu_datos_top')) {
    function genera_menu_datos_top()
    {
        $result = '';

        $result .= '<ul class="nav nav-pills"><li class="hidden-xs"><span class="ws-nowrap"><i class="icon-location-pin icons"></i> ' . EMPRESA_DIRECCION .'</span></li>';
        $result .= '<li><span class="ws-nowrap"><i class="icon-call-out icons"></i> ' . EMPRESA_TELEFONO . '</span></li>';
        $result .= '<li class="hidden-xs"><span class="ws-nowrap"><i class="icon-envelope-open icons"></i> ';
        $result .= '<a class="text-decoration-none" href="'. base_url_lang_slash() . 'contacto'. '">' . EMPRESA_MAIL . '</a>';
        $result .= '</span></li></ul>';

        return $result;
    }
}