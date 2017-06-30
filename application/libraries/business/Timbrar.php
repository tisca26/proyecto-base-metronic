<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

use SWServices\Authentication\AuthenticationService as Authentication;

class Timbrar
{
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->library('business/Convertidor_pem');
        $this->CI->load->library('business/Genera_estructura_cfdi33', null, 'estructura');
        $this->CI->load->library('business/Generar_xml');
    }

    public function timbrar($Comprobante = array(), $CfdiRelacionados = array(),
                            $Emisor = array(), $Receptor = array(), $Conceptos = array(),
                            $Impuestos = array(), $Complemento = array(), $Addenda = array())
    {
        $xml_arr = $this->CI->estructura->generar_estructura_cfdi33($Comprobante, $CfdiRelacionados, $Emisor, $Receptor, $Conceptos, $Impuestos, $Complemento, $Addenda);
        $xml_sellado = $this->CI->generar_xml->genera_cfdi33($xml_arr);
//        return $xml_sellado;
        $params = array(
            "url" => "http://services.test.sw.com.mx",
            "user" => "gerardo.tiscareno@icognitis.com",
            "password" => "Bianconeri26!"
        );
        try {
            $auth = Authentication::auth($params);
            $token = $auth::Token();

            $stamp = \SWServices\Stamp\StampService::Set($params);
            $result = $stamp::StampV4($xml_sellado);

        } catch (Exception $e) {
            $token = 'Caught exception: ' . $e->getMessage();
        }
        return $result;
    }


}