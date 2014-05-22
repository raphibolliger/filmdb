<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller
{
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
        if ($this->session->userdata('is_logged_in'))
        {
            $this->load->view('members');
        }
        else
        {
            $this->load->view('restricted');
        }
    }

    public function signup()
    {
        $this->load->view('login/signup');
    }

    public function login_validation()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|callback_validate_credentials');
        $this->form_validation->set_rules('password', 'Password', 'required|md5');
        $this->form_validation->set_rules('');

        if($this->form_validation->run())
        {
            redirect('main/members');
        }
        else
        {
            $this->load->view('login');
        }
    }

    public function signup_validation()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|trim|matches[password]');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run())
        {
            // generate a random key
            $key = md5(uniqid());

            $this->load->library('email', array('mailtype'=>'html'));
            $this->load->model('model_users');

            $this->email->from('me@mywebsite.com', "CodeIgniter Tutorial");
            $this->email->to($this->input->post('email'));
            $this->email->subject("Confirm your account.");

            $message = "<p>Thank you for signing up!</p>";
            $message .= "<p><a href='".base_url()."main/register_user/".$key."'>Click here</a> to confirm your account</p>";

            $this->email->message($message);

            if ($this->email->send())
            {
                echo "The email has been sent.";
            }
            else
            {
                echo "could not send the email.";
            }

            $this->model_users->add_user($key);

        }
        else
        {
            $this->load->view('login/signup.php');
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

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('home');
    }
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */