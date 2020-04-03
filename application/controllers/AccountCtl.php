<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AccountCtl extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index()
    {
        $data['title'] = 'eReview Login Page';
        $this->load->view('templates/AccountCtl_header', $data);
        $this->load->view('AccountCtl/login');
        $this->load->view('templates/AccountCtl_footer');
    }

    public function registration()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim|callback_alpha_dash_space|is_unique[users.username]');
        $this->form_validation->set_rules('username', 'Userame', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'password dont match!',
            'min_length' => 'Password too short!',
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'eReview User Registration';
            $this->load->view('templates/AccountCtl_header', $data);
            $this->load->view('AccountCtl/registration');
            $this->load->view('templates/AccountCtl_footer');
        } else {
            $data = [
                'nama' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 1,
                'date_created' => time()
            ];
            echo 'data berhasil ditambahkan!';
        }
    }
}
