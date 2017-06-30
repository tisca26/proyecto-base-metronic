<?php defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_attr_session')) {
    function get_attr_session($var = '', $is_obj = false)
    {
        $result = NULL;
        $CI =& get_instance();
        if (isset($_SESSION[$var])) {
            $result = $CI->encryption->decrypt($_SESSION[$var]);
            if ($is_obj) {
                return unserialize($result);
            }
        }
        return $result;
    }
}

if (!function_exists('set_attr_session')) {
    function set_attr_session($var = '', $val = '')
    {
        $CI =& get_instance();
        if (is_array($var)) {
            foreach ($var as $k => $v) {
                if (is_object($v)) {
                    $v = serialize($v);
                }
                $sess_val = $CI->encryption->encrypt($v);
                $_SESSION[$var] = $sess_val;
            }
        }
        if (is_string($var)) {
            if ($var !== '' && $val !== '') {
                if (is_object($val)) {
                    $val = serialize($val);
                }
                $sess_val = $CI->encryption->encrypt($val);
                $_SESSION[$var] = $sess_val;
            }
        }
    }
}

if (!function_exists('del_attr_session')) {
    function del_attr_session($var = '')
    {
        $CI =& get_instance();
        unset($_SESSION[$var]);
    }
}