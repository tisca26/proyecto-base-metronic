<?php defined('BASEPATH') OR exit('No direct script access allowed');
include 'Excel/Classes/PHPExcel/IOFactory.php';

class Lector_archivos
{
    private $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function leer_xlsx($file = '')
    {
        $inputFileType = PHPExcel_IOFactory::identify($file);

        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($file);

        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        return $sheetData;
    }
}