<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Extending CodeIgniter Loader Class
 *
 * Adding multiples views loder for use template view:
 * - Top view
 * - Body view
 * - Right view
 * - Footer view
 *
 * @package        Extended Core
 * @author        Fernando Jimenez Lopez; Gerardo Gabriel Tiscareño Gutiérrez
 * @category    Core Libraries
 */
class MY_Loader extends CI_Loader
{
    /**
     * Constructor
     *
     * Runs the route mapping function.
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Load View
     *
     * This function is used to load a "view" file.  It has three parameters:
     *
     * 1. The name of the "view" file to be included.
     * 2. An associative array of data to be extracted for use in the view.
     * 3. TRUE/FALSE - whether to return the data or load it.  In
     * some cases it's advantageous to be able to return data so that
     * a developer can process it in some way.
     *
     * @access    public
     * @param    string
     * @param    array
     * @param    array
     * @param    bool
     * @return    void
     */
    function template_view($view, $vars = array(), $template = array(), $return = FALSE)
    {
        if (array_key_exists('_T', $template))
            $vars['_T'] = $template['_T'];

        if (array_key_exists('_B', $template))
            $vars['_B'] = $template['_B'];

        if (array_key_exists('_L', $template))
            $vars['_L'] = $template['_L'];

        if (array_key_exists('_R', $template))
            $vars['_R'] = $template['_R'];

        if (array_key_exists('_F', $template))
            $vars['_F'] = $template['_F'];

        return $this->view($view, $vars, $return);
    }
}
// END MY_Loader Class

/* End of file MY_Loader.php */
/* Location: ./Application/core/My_Loader.php */