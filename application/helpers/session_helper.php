<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('get_attr_session')) {
    function get_attr_session($var = '')
    {
        $result = NULL;
        $CI =& get_instance();
        $sess_var = $CI->session->userdata($var);
        $result = is_string($sess_var) ? $CI->encrypt->decode($sess_var) : NULL;
        return $result;
    }
}

if (!function_exists('set_attr_session')) {
    function set_attr_session($var = '', $val = '')
    {
        $CI =& get_instance();
        if (is_array($var)){
            foreach ($var as $k => $v){
                $sess_val = $CI->encrypt->encode($v);
                $CI->session->set_userdata($k, $sess_val);
            }
        }
        if (is_string($var)){
            if ($var !== '' && $val !== '') {
                $sess_val = $CI->encrypt->encode($val);
                $CI->session->set_userdata($var, $sess_val);
            }
        }
    }
}