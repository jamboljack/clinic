<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipe_dokter extends CI_Controller {
	function __construct() {
		parent::__construct();
		if(!$this->session->userdata('logged_in_clinic')) redirect(base_url());
		$this->load->library('template');
		$this->load->model('admin/tipe_dokter_model');
	}

	public function index()
	{
		if($this->session->userdata('logged_in_clinic'))
		{
			$data['daftarlist'] = $this->tipe_dokter_model->select_all()->result();
			$this->template->display('admin/tipe_dokter_view', $data);
		} else {
			$this->session->sess_destroy();
			redirect(base_url());
		} 
	}

	public function savedata() {		
		$this->tipe_dokter_model->insert_data();
		$this->session->set_flashdata('notification','Simpan Data Sukses.');
 		redirect(site_url('admin/tipe_dokter'));
	}
	
	public function updatedata() {		
		$this->tipe_dokter_model->update_data();
		$this->session->set_flashdata('notification','Update Data Sukses.');
		redirect(site_url('admin/tipe_dokter'));
	}
	
	public function deletedata($kode) {
		$kode = $this->security->xss_clean($this->uri->segment(4));
		
		if ($kode == null) {
			redirect(site_url('admin/tipe_dokter'));
		} else {
			$this->tipe_dokter_model->delete_data($kode);
			$this->session->set_flashdata('notification','Hapus Data Sukses.');
			echo "<meta http-equiv=refresh content=0;url=\"".site_url()."admin/tipe_dokter\">";
		}
	}	
}
/* Location: ./application/controller/admin/Tipe_dokter.php */