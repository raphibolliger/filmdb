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

        // initialize tmdb class and table class
        $this->load->library('tmdb');
        $this->load->library('table');

        if ($movieName != false)
        {
            $data['movietable'] = $this->_searchMoviesInTmdb($movieName);
        }
        elseif ($this->input->post('search') != "")
        {
            $data['movietable'] = $this->_searchMoviesInTmdb($this->input->post('search'));
        }
        else
        {
            $data['movietable'] = "Es wurden keine Filme in der TMDB Datenbank gefunden";
        }

        // finaly load the view with all the data
        $this->load->view('movie/tmdbsearch', $data);
        $this->load->view('template/footer', $data);
    }

    // serach movies in tmdb
    private function _searchMoviesInTmdb($movieName)
    {
        $searchResult = $this->tmdb->searchMovie($movieName, 'de');

        $raw_movies = $searchResult['results'];

        if (count($raw_movies) == 0) {
            $movies[] = array("Zu diesem Suchbegriff wurde kein Film gefunden.", "", "");
        }

        for ($i = 0; $i < count($raw_movies); $i++) {
            $id = $raw_movies[$i]['id'];
            $title = $raw_movies[$i]['title'];
            $action = '<a href="'.base_url().'movie/add/'.$id.'">Add to DB</a>';
            $movies[] = array($id, $title, $action);
        }

        // generate table
        $tmpl = array('table_open' => '<table class="table table-striped">');
        $this->table->set_template($tmpl);
        $this->table->set_heading('ID', 'Titel', 'Action');
        $data = $this->table->generate($movies);

        return $data;
    }
}