<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class User extends CI_Controller{


	public function __construct(){
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->model('Table');
	}

	public function index(){
		$this->load->helper('form');
		$this->load->view('welcome_message');
	}

	public function login(){
		$this->form_validation->set_rules('username', 'Username', 'required|max_length[100]');
		$this->form_validation->set_rules('password', 'Password', 'required|max_length[20]');
		if(!$this->form_validation->run()){
			$this->load->view('welcome_message');
			echo "Error, incorrect username or password";
		} else if ($this->ion_auth->login($this->input->post('username'), $this->input->post('password'))) {
			if (!$this->ion_auth->is_admin()) {
				redirect('User/dashboard');
			} else {
				redirect('User/adminPage');
			}
		} else {
			//Fix session DO NOT USE $_SESSION refer to ci manuals
			$_SESSION['auth_message'] = $this->ion_auth->errors();
                $this->session->mark_as_flash('auth_message');
                $this->load->view('welcome_message');

		}
		
	}

	public function dashboard(){
		$this->load->view('dashboard');
	}

	public function adminPage() {
		
		$data['user'] = $this->Table->getUsers();
		$this->load->view('adminDashboard', $data);
	}

	public function addUser(){
		$this->form_validation->set_rules('username', 'Username', 'required|max_length[100]');
		$this->form_validation->set_rules('password', 'Password', 'required|max_length[20]');
		$this->form_validation->set_rules('retypepassword', 'Retypepassword', 'required|max_length[20]');
		$this->form_validation->set_rules('email', 'Email', 'required|max_length[45]');
		$this->form_validation->set_rules('group[]', 'Group', 'required', 'integer');

		if (!$this->form_validation->run()) {
				$error = validation_errors();
			} else {
				$this->ion_auth->register(
					$this->input->post('username'),
					$this->input->post('password'),
					$this->input->post('email'),
					$this->input->post('group')
					);
				$this->session->set_flashdata('message',$this->ion_auth->messages());
    			redirect('User/adminPage','refresh');
			}

	}

	public function addCustomer(){

		if (!$this->form_validation->run()){
			
		}
	}

	public function logout(){
		$this->ion_auth->logout();
		$this->load->helper('form');
		$this->load->view('welcome_message');
	}

}



