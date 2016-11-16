<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

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
     * List of paths to load libraries from
     *
     * @var    array
     */
    protected $_ci_business_paths = array(APPPATH, BASEPATH);

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

    /**
     * Business Loader
     *
     * Loads and instantiates business classes.
     * Designed to be called from application controllers.
     *
     * @param    string $business Business Class name
     * @param    string $object_name An optional object name to assign to
     * @return    object
     */
    public function business($business, $object_name = NULL)
    {
        if (empty($business)) {
            return $this;
        } elseif (is_array($business)) {
            foreach ($business as $key => $value) {
                if (is_int($key)) {
                    $this->business($value);
                } else {
                    $this->business($key, $value);
                }
            }

            return $this;
        }

        $this->_ci_load_business($business, $object_name);
        return $this;
    }

    /**
     * Internal CI Business Loader
     *
     * @param    string $class Class name to load
     * @param    mixed $params Optional parameters to pass to the class constructor
     * @param    string $object_name Optional object name to assign to
     * @return    void
     */
    protected function _ci_load_business($class, $object_name = NULL)
    {
        // Get the class name, and while we're at it trim any slashes.
        // The directory path can be included as part of the class name,
        // but we don't want a leading slash
        $class = str_replace('.php', '', trim($class, '/'));

        // Was the path included with the class name?
        // We look for a slash to determine this
        if (($last_slash = strrpos($class, '/')) !== FALSE) {
            // Extract the path
            $subdir = substr($class, 0, ++$last_slash);

            // Get the filename from the path
            $class = substr($class, $last_slash);
        } else {
            $subdir = '';
        }

        $class = ucfirst($class);

//        // Is this a stock library? There are a few special conditions if so ...
//        if (file_exists(BASEPATH . 'business/' . $subdir . $class . '.php')) {
//            return $this->_ci_load_stock_library($class, $subdir, $params, $object_name);
//        }
        // Let's search for the requested library file and load it.
        foreach ($this->_ci_business_paths as $path) {
            // BASEPATH has already been checked for
            if ($path === BASEPATH) {
                continue;
            }

            $filepath = $path . 'business/' . $subdir . $class . '.php';
            log_message('debug', $filepath . " - filepath");
            // Safety: Was the class already loaded by a previous call?
            if (class_exists($class, FALSE)) {
                // Before we deem this to be a duplicate request, let's see
                // if a custom object name is being supplied. If so, we'll
                // return a new instance of the object
                if ($object_name !== NULL) {
                    $CI = &get_instance();
                    if (!isset($CI->$object_name)) {
                        return $this->_ci_init_business($class, '', '', $object_name);
                    }
                }

                log_message('debug', $class . ' class already loaded. Second attempt ignored.');
                return;
            } // Does the file exist? No? Bummer...
            elseif (!file_exists($filepath)) {
                continue;
            }

            include_once($filepath);
            return $this->_ci_init_business($class, '', '', $object_name);
        }

        // One last attempt. Maybe the library is in a subdirectory, but it wasn't specified?
        if ($subdir === '') {
            return $this->_ci_init_business($class . '/' . $class, '', $object_name);
        }

        // If we got this far we were unable to find the requested class.
        log_message('error', 'Unable to load the requested class: ' . $class);
        show_error('Unable to load the requested class: ' . $class);
    }

    /**
     * Internal CI Business Instantiator
     *
     * @param    string $class Class name
     * @param    string $prefix Class name prefix
     * @param    array|null|bool $config Optional configuration to pass to the class constructor:
     *                        FALSE to skip;
     *                        NULL to search in config paths;
     *                        array containing configuration data
     * @param    string $object_name Optional object name to assign to
     * @return    void
     */
    protected function _ci_init_business($class, $prefix, $config = FALSE, $object_name = NULL)
    {
        // Is there an associated config file for this class? Note: these should always be lowercase
        if ($config === NULL) {
            // Fetch the config paths containing any package paths
            $config_component = $this->_ci_get_component('config');

            if (is_array($config_component->_config_paths)) {
                $found = FALSE;
                foreach ($config_component->_config_paths as $path) {
                    // We test for both uppercase and lowercase, for servers that
                    // are case-sensitive with regard to file names. Load global first,
                    // override with environment next
                    if (file_exists($path . 'config/' . strtolower($class) . '.php')) {
                        include($path . 'config/' . strtolower($class) . '.php');
                        $found = TRUE;
                    } elseif (file_exists($path . 'config/' . ucfirst(strtolower($class)) . '.php')) {
                        include($path . 'config/' . ucfirst(strtolower($class)) . '.php');
                        $found = TRUE;
                    }

                    if (file_exists($path . 'config/' . ENVIRONMENT . '/' . strtolower($class) . '.php')) {
                        include($path . 'config/' . ENVIRONMENT . '/' . strtolower($class) . '.php');
                        $found = TRUE;
                    } elseif (file_exists($path . 'config/' . ENVIRONMENT . '/' . ucfirst(strtolower($class)) . '.php')) {
                        include($path . 'config/' . ENVIRONMENT . '/' . ucfirst(strtolower($class)) . '.php');
                        $found = TRUE;
                    }

                    // Break on the first found configuration, thus package
                    // files are not overridden by default paths
                    if ($found === TRUE) {
                        break;
                    }
                }
            }
        }

        $class_name = $prefix . $class;

        // Is the class name valid?
        if (!class_exists($class_name, FALSE)) {
            log_message('error', 'Non-existent class: ' . $class_name);
            show_error('Non-existent class: ' . $class_name);
        }

        // Set the variable name we will assign the class to
        // Was a custom class name supplied? If so we'll use it
        if (empty($object_name)) {
            $object_name = strtolower($class);
            if (isset($this->_ci_varmap[$object_name])) {
                $object_name = $this->_ci_varmap[$object_name];
            }
        }

        // Don't overwrite existing properties
        $CI = &get_instance();
        if (isset($CI->$object_name)) {
            if ($CI->$object_name instanceof $class_name) {
                log_message('debug', $class_name . " has already been instantiated as '" . $object_name . "'. Second attempt aborted.");
                return;
            }

            show_error("Resource '" . $object_name . "' already exists and is not a " . $class_name . " instance.");
        }

        // Save the class name and object name
        $this->_ci_classes[$object_name] = $class;

        // Instantiate the class
        $CI->$object_name = isset($config) ? new $class_name($config) : new $class_name();
    }

    /**
     * Database Loader
     *
     * @param	mixed	$params		Database configuration options
     * @param	bool	$return 	Whether to return the database object
     * @param	bool	$query_builder	Whether to enable Query Builder
     *					(overrides the configuration setting)
     *
     * @return	object|bool	Database object if $return is set to TRUE,
     *					FALSE on failure, CI_Loader instance in any other case
     */
    public function database($params = '', $return = FALSE, $query_builder = NULL)
    {
        // Grab the super object
        $CI =& get_instance();

        // Do we even need to load the database class?
        if ($return === FALSE && $query_builder === NULL && isset($CI->db) && is_object($CI->db) && ! empty($CI->db->conn_id))
        {
            return FALSE;
        }

        require_once(BASEPATH.'database/DB.php');

        /*
         * aqui
         */
        $db = DB($params, $query_builder);

        // Load extended DB driver
        $custom_db_driver = config_item('subclass_prefix').'DB_'.$db->dbdriver.'_driver';
        $custom_db_driver_file = APPPATH.'core/'.$custom_db_driver.'.php';

        if (file_exists($custom_db_driver_file))
        {
            require_once($custom_db_driver_file);

            $db = new $custom_db_driver(get_object_vars($db));
        }
        /*
         * fin
         */

        if ($return === TRUE)
        {
            return $db;
        }

        // Initialize the db variable. Needed to prevent
        // reference errors with some configurations
        $CI->db = '';

        // Load the DB class
        $CI->db =& $db;
        return $this;
    }
}

// END MY_Loader Class

/* End of file MY_Loader.php */
/* Location: ./Application/core/My_Loader.php */