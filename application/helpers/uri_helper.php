<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('lang_segment')) {
    function lang_segment()
    {
        $CI =& get_instance();
        return $CI->config->item('language_abbr') . '/';
    }
}

if (!function_exists('base_url_lang')) {
    function base_url_lang()
    {
        $CI =& get_instance();
        return base_url() . $CI->config->item('language_abbr') . '/';
    }
}