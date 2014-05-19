<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->login();
	}

    public function login()
    {
        $this->load->view('login');
    }

    public function members()
    {
        if ($this->session->all_userdata->user_data('is_logged_in'))
        {
            $this->load->view('members');
        }
        else
        {
            $this->load->view('restricted');
        }
    }

    public function login_validation()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|callback_validate_credentials');
        $this->form_validation->set_rules('password', 'Password', 'required|md5');

        if($this->form_validation->run())
        {
            redirect('main/members');
        }
        else
        {
            $this->load->view('login');
        }
    }

    public function validate_credentials()
    {
        $this->load->model('model_users');

        if ($this->model_users->can_log_in())
        {
            $data = array(
                'email' => $this->input->post('email'),
                'is_logged_in' => 1
            );

            $this->session->set_userdata($data);
            return true;
        }
        else
        {
            $this->form_validation->set_message('validate_credentials', 'Benutzername oder Passwort ist falsch.');
            return false;
        }
    }
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */