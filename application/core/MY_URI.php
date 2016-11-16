<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Extending CodeIgniter URI Class
 * To Adjust the Languages
 *
 * @author Hani Ibrahim <hani.ibrahim.2010@gmail.com>
 */

class MY_URI extends CI_URI
{
    var $available_lang = array();

    function __construct()
    {
        parent::__construct();
        // Load the Available Languages form the config file
        $this->available_lang = $this->config->item('languages');
    }

    function _explode_segments()
    {
        foreach (explode("/", preg_replace("|/*(.+?)/*$|", "\\1", $this->uri_string)) as $val) {
            // Filter segments for security
            $val = trim($this->_filter_uri($val));

            if ($val != '') {
                $this->segments[] = $val;
            }
        }

        // Check the first item in the url array
        if (isset($this->segments[0]) AND array_key_exists($this->segments[0], $this->available_lang)) {
            // setting the current language
            $this->config->set_item('language', $this->available_lang[$this->segments[0]]);

            // setting the lang config-item (The language Abbreviation)
            $this->config->set_item('lang', $this->segments[0]);

            // Remove the first element form the url array to load the needed controller
            array_shift($this->segments);

            // setting the direction
            if (in_array($this->config->item('language'), $this->config->item('rtl_lang'))) {
                $this->config->set_item('direction', 'rtl');
            } else {
                $this->config->set_item('direction', 'ltr');
            }
        }
    }
}