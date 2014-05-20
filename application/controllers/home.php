<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function index()
    {
        $this->home();
    }

    public function home()
    {
        $this->load->view('home');
    }
}