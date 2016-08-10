<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perawat extends CI_Controller {
	function __construct() {
		parent::__construct();
		if(!$this->session->userdata('logged_in_clinic')) redirect(base_url());
		$this->load->library('template');
		$this->load->model('admin/perawat_model');
	}

	public function index()
	{
		if($this->session->userdata('logged_in_clinic'))
		{
			$data['daftarlist'] 	= $this->perawat_model->select_all()->result();			
			$this->template->display('admin/perawat_view', $data);
		} else {
			$this->session->sess_destroy();
			redirect(base_url());
		} 
	}

	public function savedata() {		
		$this->perawat_model->insert_data();
		$this->session->set_flashdata('notification','Simpan Data Sukses.');
 		redirect(site_url('admin/perawat'));
	}
	
	public function updatedata() {		
		$this->perawat_model->update_data();
		$this->session->set_flashdata('notification','Update Data Sukses.');
		redirect(site_url('admin/perawat'));
	}
	
	public function deletedata($kode) {
		$kode = $this->security->xss_clean($this->uri->segment(4));
		
		if ($kode == null) {
			redirect(site_url('admin/perawat'));
		} else {
			$this->perawat_model->delete_data($kode);
			$this->session->set_flashdata('notification','Hapus Data Sukses.');
			echo "<meta http-equiv=refresh content=0;url=\"".site_url()."admin/perawat\">";
		}
	}	
}
/* Location: ./application/controller/admin/Perawat.php */