<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pabrikan extends CI_Controller {
	function __construct() {
		parent::__construct();
		if(!$this->session->userdata('logged_in_clinic')) redirect(base_url());
		$this->load->library('template_apotek');
		$this->load->model('apotek/pabrikan_model');
	}

	public function index()
	{
		if($this->session->userdata('logged_in_clinic'))
		{
			$data['daftarlist'] = $this->pabrikan_model->select_all()->result();
			$this->template_apotek->display('apotek/pabrikan_view', $data);
		} else {
			$this->session->sess_destroy();
			redirect(base_url());
		} 
	}

	public function adddata() {
		$data['error']				= false;
		$data['listProvinsi'] 		= $this->pabrikan_model->select_provinsi()->result();
		$data['listKabupaten'] 		= $this->pabrikan_model->select_kabupaten()->result();
		$this->template_apotek->display('apotek/pabrikan_add_view', $data);
	}

	public function savedata() {
		$this->form_validation->set_rules('name','<b>Nama Pabrikan</b>','trim|required|is_unique[clinic_pabrikan.pabrikan_name]');		

		if ($this->form_validation->run() == FALSE) {
			$data['error']				= true;
			$data['listProvinsi'] 		= $this->pabrikan_model->select_provinsi()->result();
			$data['listKabupaten'] 		= $this->pabrikan_model->select_kabupaten()->result();
			$this->template_apotek->display('apotek/pabrikan_add_view', $data);
		} else {			
			$this->pabrikan_model->insert_data();
			$this->session->set_flashdata('notification','Simpan Data Sukses.');
	 		redirect(site_url('apotek/pabrikan'));
	 	}
	}

	public function editdata($pabrikan_id) {		
		$data['listProvinsi'] 		= $this->pabrikan_model->select_provinsi()->result();
		$data['listKabupaten'] 		= $this->pabrikan_model->select_kabupaten()->result();
		$data['detail'] 			= $this->pabrikan_model->select_by_id($pabrikan_id)->row();
		$this->template_apotek->display('apotek/pabrikan_edit_view', $data);
	}
	
	public function updatedata() {		
		$this->pabrikan_model->update_data();
		$this->session->set_flashdata('notification','Update Data Sukses.');
		redirect(site_url('apotek/pabrikan'));
	}
	
	public function deletedata($kode) {
		$kode = $this->security->xss_clean($this->uri->segment(4));
		
		if ($kode == null) {
			redirect(site_url('apotek/pabrikan'));
		} else {
			$this->pabrikan_model->delete_data($kode);
			$this->session->set_flashdata('notification','Hapus Data Sukses.');
			echo "<meta http-equiv=refresh content=0;url=\"".site_url()."apotek/pabrikan\">";
		}
	}	
}
/* Location: ./application/controller/apotek/Pabrikan.php */