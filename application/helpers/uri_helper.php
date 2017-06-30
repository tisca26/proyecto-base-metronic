<?php defined('BASEPATH') OR exit('No direct script access allowed');


if (!function_exists('cdn_assets')) {
    function cdn_assets()
    {
        $CI =& get_instance();
        return $CI->config->item('cdn_assets');
    }
}

