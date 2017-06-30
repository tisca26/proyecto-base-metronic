<?php defined('BASEPATH') OR exit('No direct script access allowed');

include("Privy.php");

class Dashboard extends Privy
{
    public function __construct()
    {
        parent::__construct();
        $this->set_read_list(array('index'));
        $this->check_access();
    }

    public function index()
    {
        //$this->load->view('dashboard/dashboard_index');
        $this->load->view('blank_page');
    }
}