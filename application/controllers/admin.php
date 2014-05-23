<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function index()
    {
        $this->start();
    }

    public function start()
    {
        $this->load->view('admin/start');
    }

    public function initialize_new_movie_list()
    {
        $this->load->model('model_admin');

        // first delete the movie list table
        $this->model_admin->delete_movieList_table();

        // add all movies from filmlist to the table
        $movies = $this->prepareInputFilmTextFile(file(base_url()."filmlist.txt"));
        foreach ($movies as $movie)
        {
            if($this->model_admin->add_initial_movieList(array('name' => $movie)))
            {
                $dbmessage = "Filmliste erfolgreich neu eingelesen.";
            }
            else
            {
                $dbmessage = "Fehler: Filmliste konnte nicht neu eingelesen werden.";
            }
        }

        // set the date to send to the view
        $data['dbmessage'] = $dbmessage;

        // load the view;
        $this->load->view('admin/initialize_new_movie_list', $data);
    }

    public function compare_movies()
    {
        $this->load->view('admin/compare_movies');
    }

    protected  function prepareInputFilmTextFile($inputTextFile)
    {
        foreach($inputTextFile as $data)
        {
            $array[] = substr((string)$data,0,-1);
        }

        foreach ($array as $key => $value)
        {
            if ($value == "@eaDir" OR $value == ".DS_Store" OR $value == "...und dann kam Polly")
            {
                $remove[] = $key;
            }
        }

        unset($array[0]);
        unset($array[1]);

        foreach ($remove as $key => $value)
        {
            unset($array[$value]);
        }

        foreach ($array as $key => $value)
        {
            $array2[] = $value;
        }

        return $array2;
    }
}