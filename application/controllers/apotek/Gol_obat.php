<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gol_obat extends CI_Controller {
	function __construct() {
		parent::__construct();
		if(!$this->session->userdata('logged_in_clinic')) redirect(base_url());
		$this->load->library('template_apotek');
		$this->load->model('apotek/gol_obat_model');
	}

	public function index()
	{
		if($this->session->userdata('logged_in_clinic'))
		{
			$data['daftarlist'] = $this->gol_obat_model->select_all()->result();
			$this->template_apotek->display('apotek/gol_obat_view', $data);
		} else {
			$this->session->sess_destroy();
			redirect(base_url());
		} 
	}

	public function savedata() {		
		$this->gol_obat_model->insert_data();
		$this->session->set_flashdata('notification','Simpan Data Sukses.');
 		redirect(site_url('apotek/gol_obat'));
	}
	
	public function updatedata() {		
		$this->gol_obat_model->update_data();
		$this->session->set_flashdata('notification','Update Data Sukses.');
		redirect(site_url('apotek/gol_obat'));
	}
	
	public function deletedata($kode) {
		$kode = $this->security->xss_clean($this->uri->segment(4));
		
		if ($kode == null) {
			redirect(site_url('apotek/gol_obat'));
		} else {
			$this->gol_obat_model->delete_data($kode);
			$this->session->set_flashdata('notification','Hapus Data Sukses.');
			echo "<meta http-equiv=refresh content=0;url=\"".site_url()."apotek/gol_obat\">";
		}
	}	
}
/* Location: ./application/controller/apotek/Gol_obat.php */