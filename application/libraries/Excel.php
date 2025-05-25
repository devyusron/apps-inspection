<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Excel {

    public function __construct() {
        require_once APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php';
    }

    public function createSpreadsheet() {
        return new PHPExcel();
    }

    public function createWriter($spreadsheet) {
        return PHPExcel_IOFactory::createWriter($spreadsheet, 'Excel5'); // format .xls
    }
}
