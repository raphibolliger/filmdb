<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Movie extends CI_Controller
{
    public function index()
    {
        $this->overview();
    }

    public function overview()
    {
        $this->load->view('movie/overview');
    }

    public function tmdbsearch($movieName = false)
    {
        // first set title and load header
        $data['title'] = "Search Movie in TMDB";
        $this->load->view('template/header', $data);

        // initialize tmdb class
        $params = array('apikey' => 'API_KEY');
        $this->load->library('tmdb', $params);



        // finaly load the view with all the data
        $this->load->view('movie/tmdbsearch', $data);
        $this->load->view('template/footer', $data);
    }
}