<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suplier extends CI_Controller {
	function __construct() {
		parent::__construct();
		if(!$this->session->userdata('logged_in_clinic')) redirect(base_url());
		$this->load->library('template_apotek');
		$this->load->model('apotek/suplier_model');
	}

	public function index()
	{
		if($this->session->userdata('logged_in_clinic'))
		{
			$data['daftarlist'] = $this->suplier_model->select_all()->result();
			$this->template_apotek->display('apotek/suplier_view', $data);
		} else {
			$this->session->sess_destroy();
			redirect(base_url());
		} 
	}

	public function adddata() {
		$data['error']				= false;
		$data['listProvinsi'] 		= $this->suplier_model->select_provinsi()->result();
		$data['listKabupaten'] 		= $this->suplier_model->select_kabupaten()->result();
		$this->template_apotek->display('apotek/suplier_add_view', $data);
	}

	public function savedata() {
		$this->form_validation->set_rules('name','<b>Nama Suplier</b>','trim|required|is_unique[clinic_suplier.suplier_name]');		

		if ($this->form_validation->run() == FALSE) {
			$data['error']				= true;
			$data['listProvinsi'] 		= $this->suplier_model->select_provinsi()->result();
			$data['listKabupaten'] 		= $this->suplier_model->select_kabupaten()->result();
			$this->template_apotek->display('apotek/suplier_add_view', $data);
		} else {			
			$this->suplier_model->insert_data();
			$this->session->set_flashdata('notification','Simpan Data Sukses.');
	 		redirect(site_url('apotek/suplier'));
	 	}
	}

	public function editdata($suplier_id) {		
		$data['listProvinsi'] 		= $this->suplier_model->select_provinsi()->result();
		$data['listKabupaten'] 		= $this->suplier_model->select_kabupaten()->result();
		$data['detail'] 			= $this->suplier_model->select_by_id($suplier_id)->row();
		$this->template_apotek->display('apotek/suplier_edit_view', $data);
	}
	
	public function updatedata() {		
		$this->suplier_model->update_data();
		$this->session->set_flashdata('notification','Update Data Sukses.');
		redirect(site_url('apotek/suplier'));
	}
	
	public function deletedata($kode) {
		$kode = $this->security->xss_clean($this->uri->segment(4));
		
		if ($kode == null) {
			redirect(site_url('apotek/suplier'));
		} else {
			$this->suplier_model->delete_data($kode);
			$this->session->set_flashdata('notification','Hapus Data Sukses.');
			echo "<meta http-equiv=refresh content=0;url=\"".site_url()."apotek/suplier\">";
		}
	}	
}
/* Location: ./application/controller/apotek/Suplier.php */