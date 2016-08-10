<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Status extends CI_Controller {
	function __construct() {
		parent::__construct();
		if(!$this->session->userdata('logged_in_clinic')) redirect(base_url());
		$this->load->library('template');
		$this->load->model('admin/status_model');
	}

	public function index()
	{
		if($this->session->userdata('logged_in_clinic'))
		{
			$data['daftarlist'] = $this->status_model->select_all()->result();
			$this->template->display('admin/status_view', $data);
		} else {
			$this->session->sess_destroy();
			redirect(base_url());
		} 
	}

	public function savedata() {		
		$this->status_model->insert_data();
		$this->session->set_flashdata('notification','Simpan Data Sukses.');
 		redirect(site_url('admin/status'));
	}
	
	public function updatedata() {		
		$this->status_model->update_data();
		$this->session->set_flashdata('notification','Update Data Sukses.');
		redirect(site_url('admin/status'));
	}
	
	public function deletedata($kode) {
		$kode = $this->security->xss_clean($this->uri->segment(4));
		
		if ($kode == null) {
			redirect(site_url('admin/status'));
		} else {
			$this->status_model->delete_data($kode);
			$this->session->set_flashdata('notification','Hapus Data Sukses.');
			echo "<meta http-equiv=refresh content=0;url=\"".site_url()."admin/status\">";
		}
	}	
}
/* Location: ./application/controller/admin/Status.php */