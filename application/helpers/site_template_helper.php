<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Set Top template section
 *
 * @access    public
 * @param    string , file path
 */
if (!function_exists('template_top')) {
    function template_top($path = '')
    {
        if (!empty($path))
            return $path;
        else {
            $default = get_instance()->config->item('TEMPLATE');
            return $default['_T'];
        }

    }
}

// ------------------------------------------------------------------------

/**
 * Set Body template section
 *
 * @access    public
 * @param    string , file path
 */
if (!function_exists('template_body')) {
    function template_body($path = '')
    {
        if (!empty($path))
            return $path;
        else {
            $default = get_instance()->config->item('TEMPLATE');
            return $default['_B'];
        }
    }
}

// ------------------------------------------------------------------------

/**
 * Set Right template section
 *
 * @access    public
 * @param    string , file path
 */
if (!function_exists('template_right')) {
    function template_right($path = '')
    {
        if (!empty($path))
            return $path;
        else {
            $default = get_instance()->config->item('TEMPLATE');
            return $default['_R'];
        }
    }
}

// ------------------------------------------------------------------------

/**
 * Set Right template section
 *
 * @access    public
 * @param    string , file path
 */
if (!function_exists('template_left')) {
    function template_left($path = '')
    {
        if (!empty($path))
            return $path;
        else {
            $default = get_instance()->config->item('TEMPLATE');
            return $default['_L'];
        }
    }
}
// ------------------------------------------------------------------------

/**
 * Set Footer template section
 *
 * @access    public
 * @param    string , file path
 */
if (!function_exists('template_footer')) {
    function template_footer($path = '')
    {
        if (!empty($path))
            return $path;
        else {
            $default = get_instance()->config->item('TEMPLATE');
            return $default['_F'];
        }
    }
}



/* End of file site_template_helper.php */
/* Location: ./application/helpers/site_template_helper.php */