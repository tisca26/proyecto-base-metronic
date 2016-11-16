<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cargar_idioma
{
    protected $CI;
    protected $config;

    // We'll use a constructor, as you can't directly call a function
    // from a property definition.
    public function __construct()
    {
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        global $URI, $CFG, $IN;
        $this->config =& $CFG->config;
    }

    public function carga_lang($archivo = '')
    {
        $f_archivo = 'welcome/inicio';
        $f_idioma = 'spanish';
        //$idioma = $this->CI->session->idioma_del_sitio === NULL ? 'spanish' : $this->CI->encrypt->decode($this->CI->session->idioma_del_sitio);
        $idioma = $this->config['language'];
        if (is_dir(APPPATH . 'language/' . $idioma)){
            $f_idioma = $idioma;
        }
        if (file_exists(APPPATH . 'language/' . $f_idioma . '/' . $archivo . '_lang.php')) {
            $f_archivo = $archivo;
        }
        $this->CI->lang->load($f_archivo, $f_idioma);
    }
}