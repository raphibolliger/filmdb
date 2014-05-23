<?php

class Model_admin extends CI_Model
{
    public function add_initial_movieList($movieItem)
    {
        return $this->db->insert('updated_movie_list', $movieItem);
    }

    public function delete_movieList_table()
    {
        return $this->db->empty_table('updated_movie_list');
    }
}