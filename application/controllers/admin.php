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

    /**
     * Add the Filmlist.txt to the database to compare the updated list with the existing
     * movies in the database.
     */
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

    /**
     * Compare the updated and the existing databases and display it as a table for the user with options
     * to import the differences into the existing movie table.
     */
    public function compare_movies()
    {
        // first set title and load header
        $data['title'] = "Compare Movies";
        $this->load->view('template/header', $data);

        $this->load->model('model_admin');
        $this->load->library('table');


        // get all movies
        $updatedMoviearray = $this->model_admin->getAllUpdatedMovies();
        $existingMoviearray = $this->model_admin->getAllExistingMovies();

        // generate movie not in db array
        for ($i = 0; $i < count($updatedMoviearray); $i++)
        {
            if (!$this->model_admin->checkIfMovieInExistingMovies($updatedMoviearray[$i]['name']))
            {
                $moviename = $updatedMoviearray[$i]['name'];
                $updatelink = "<a href=\"importmovie/".$moviename."\">Import in DB</a>";
                $movieNotInDb[] = array('Film' => $moviename, 'Action' => $updatelink);
            }
        }

        if (count($movieNotInDb == 0))
        {
            $tmpl = array ( 'table_open'  => '<table class="table table-striped">' );
            $this->table->set_template($tmpl);
            $this->table->set_heading('Film', 'Import');
            $data['allMovies'] = $this->table->generate($movieNotInDb);
        }
        else
        {
            $data['allMovies'] = "Es gibt keine neuen Filme zum Importieren";
        }

        // finaly load the view with all the data
        $this->load->view('admin/compare_movies', $data);
        $this->load->view('template/footer', $data);
    }

    public function importmovie($name)
    {

    }

    protected function prepareInputFilmTextFile($inputTextFile)
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