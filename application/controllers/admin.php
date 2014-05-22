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

    public function update_movies()
    {

        $this->load->library('table');
        $test = file(base_url()."filmlist.txt");
        $test2 = $this->prepareInputFilmTextFile($test);

        echo "<pre>";

        echo "</pre>";

        echo $this->table->generate($test2);


        $this->load->view('admin/update_movies');
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