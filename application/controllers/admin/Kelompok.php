<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelompok extends CI_Controller {
	function __construct() {
		parent::__construct();
		if(!$this->session->userdata('logged_in_clinic')) redirect(base_url());
		$this->load->library('template');
		$this->load->model('admin/kelompok_model');
	}

	public function index()
	{
		if($this->session->userdata('logged_in_clinic'))
		{
			$data['daftarlist'] 	= $this->kelompok_model->select_all()->result();
			$data['listJenisTarif'] = $this->kelompok_model->select_jenis_tarif()->result();
			$this->template->display('admin/kelompok_view', $data);
		} else {
			$this->session->sess_destroy();
			redirect(base_url());
		} 
	}

	public function savedata() {		
		$this->kelompok_model->insert_data();
		$this->session->set_flashdata('notification','Simpan Data Sukses.');
 		redirect(site_url('admin/kelompok'));
	}
	
	public function updatedata() {		
		$this->kelompok_model->update_data();
		$this->session->set_flashdata('notification','Update Data Sukses.');
		redirect(site_url('admin/kelompok'));
	}
	
	public function deletedata($kode) {
		$kode = $this->security->xss_clean($this->uri->segment(4));
		
		if ($kode == null) {
			redirect(site_url('admin/kelompok'));
		} else {
			$this->kelompok_model->delete_data($kode);
			$this->session->set_flashdata('notification','Hapus Data Sukses.');
			echo "<meta http-equiv=refresh content=0;url=\"".site_url()."admin/kelompok\">";
		}
	}	
}
/* Location: ./application/controller/admin/Kelompok.php */