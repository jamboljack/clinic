<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit extends CI_Controller {
	function __construct() {
		parent::__construct();
		if(!$this->session->userdata('logged_in_clinic')) redirect(base_url());
		$this->load->library('template');
		$this->load->model('admin/unit_model');
	}

	public function index()
	{
		if($this->session->userdata('logged_in_clinic'))
		{
			$data['daftarlist'] 	= $this->unit_model->select_all()->result();
			$data['listKelompok'] 	= $this->unit_model->select_kelompok_unit()->result();
			$this->template->display('admin/unit_view', $data);
		} else {
			$this->session->sess_destroy();
			redirect(base_url());
		} 
	}

	public function savedata() {		
		$this->unit_model->insert_data();
		$this->session->set_flashdata('notification','Simpan Data Sukses.');
 		redirect(site_url('admin/unit'));
	}
	
	public function updatedata() {		
		$this->unit_model->update_data();
		$this->session->set_flashdata('notification','Update Data Sukses.');
		redirect(site_url('admin/unit'));
	}
	
	public function deletedata($kode) {
		$kode = $this->security->xss_clean($this->uri->segment(4));
		
		if ($kode == null) {
			redirect(site_url('admin/unit'));
		} else {
			$this->unit_model->delete_data($kode);
			$this->session->set_flashdata('notification','Hapus Data Sukses.');
			echo "<meta http-equiv=refresh content=0;url=\"".site_url()."admin/unit\">";
		}
	}	
}
/* Location: ./application/controller/admin/Unit.php */