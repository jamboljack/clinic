<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct() {
		parent::__construct();		
		$this->load->model('login_model');		
	}

	public function index()
	{
		$session = $this->session->userdata('logged_in_clinic');
		if ($session == FALSE) 
		{
			$this->load->view('login_view');
		} 
		else 
		{						
			redirect(site_url('dashboard/home'));
		}
	}

	public function validasi() 
	{
		$username 	= trim($this->input->post('username', 'true'));
		$password 	= trim($this->input->post('password', 'true'));
		
		$temp_user 	= $this->login_model->get_user($username)->row();
		$num_user 	= count($temp_user);
		
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		
		if ($this->form_validation->run() == FALSE) 
		{
			$this->load->view('login_view');
		} 
		else 
		{
			if ($num_user == 0) 
			{
				$this->session->set_flashdata('notification','<b>Maaf !! Username Anda Tidak Terdaftar.</b>');
				redirect(site_url('login'));				
			} 
			elseif ($num_user > 0) 
			{
				$temp_account = $this->login_model->check_user_account($username, sha1($password))->row();
				$num_account = count($temp_account);
		
				if ($num_account > 0) 
				{	
					$array_item = array('username' 			=> $temp_account->user_username, 
										'nama' 				=> $temp_account->user_name,
										'avatar' 			=> $temp_account->user_image,
										'logged_in_clinic' 	=> TRUE
										);
					
					$this->session->set_userdata($array_item);
					redirect(site_url('dashboard/home'));
				}
				else
				{
					$this->session->set_flashdata('notification','<b>Login Gagal, Username atau Password Salah.</b>');
					redirect(site_url('login'));					
				}				
			}
		}		
	}	

	public function logout() {
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . 'GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-chace');
		$this->session->sess_destroy();
		redirect(base_url());
	}
}
/* Location: ./application/controller/Login.php */