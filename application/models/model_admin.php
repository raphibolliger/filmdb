<?php

class Model_admin extends CI_Model
{

    // add one movie to the initial list
    public function add_initial_movieList($movieItem)
    {
        return $this->db->insert('updated_movie_list', $movieItem);
    }

    // delete the table
    public function delete_movieList_table()
    {
        return $this->db->empty_table('updated_movie_list');
    }

    // load all updated movies
    public function getAllUpdatedMovies()
    {
        $query =  $this->db->get('updated_movie_list');
        return $query->result_array();
    }

    public function checkIfMovieInUpdatedMovies($movieName)
    {
        $this->db->where('name', $movieName);
        $query = $this->db->get('updated_movie_list');

        if ($query->num_rows() == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    // load all existing movies
    public function getAllExistingMovies()
    {
        $query =  $this->db->get('movies');
        return $query->result_array();
    }

    public function checkIfMovieInExistingMovies($movieName)
    {
        $this->db->where('name', $movieName);
        $query = $this->db->get('movies');

        if ($query->num_rows() == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }


}