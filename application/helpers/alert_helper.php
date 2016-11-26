<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('set_bootstrap_alert')) {
    function set_bootstrap_alert($text_input, $type = BOOTSTRAP_ALERT_SUCCESS)
    {
        $text = '';
        if(is_array($text_input)){
            foreach ($text_input as $val) {
                $text .= "<p>" . $val . "</p>";
            }
        }else{
            $text = print_r($text_input, true);
        }
        $CI =& get_instance();
        $alert_bootstrap_array = $CI->session->flashdata('alert_bootstrap_array') === NULL ? array() : $CI->session->flashdata('alert_bootstrap_array');
        $alert_obj = new stdClass();
        $alert_obj->type = $type;
        $alert_obj->text = $text;
        $alert_bootstrap_array[] = $alert_obj;
        $CI->session->set_flashdata('alert_bootstrap_array', $alert_bootstrap_array);
    }
}

if (!function_exists('exist_bootstrap_alert')) {
    function exist_bootstrap_alert()
    {
        $CI =& get_instance();
        if ($CI->session->flashdata('alert_bootstrap_array') === NULL) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
}

if (!function_exists('get_bootstrap_alert')) {
    function get_bootstrap_alert()
    {
        $html = '';
        $CI =& get_instance();
        $alert_bootstrap_array = $CI->session->flashdata('alert_bootstrap_array');
        if (is_array($alert_bootstrap_array)) {
            foreach ($alert_bootstrap_array as $alert){
                $html .= "<div class='alert alert-" . $alert->type . "'>" . $alert->text . "</div>";
            }
        }
        $CI->session->set_flashdata('alert_bootstrap_array', NULL);
        return $html;
    }
}

if (!function_exists('get_bootstrap_alert_dismiss')) {
    function get_bootstrap_alert_dismiss()
    {
        $html = '';
        $CI =& get_instance();
        $alert_bootstrap_array = $CI->session->flashdata('alert_bootstrap_array');
        if (is_array($alert_bootstrap_array)) {
            foreach ($alert_bootstrap_array as $alert){
                $html .= "<div class='alert alert-" . $alert->type . " alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button>" . $alert->text . "</div>";
            }
        }
        $CI->session->set_flashdata('alert_bootstrap_array', NULL);
        return $html;
    }
}
