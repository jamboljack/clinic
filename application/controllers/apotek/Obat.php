<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Obat extends CI_Controller {
	function __construct() {
		parent::__construct();
		if(!$this->session->userdata('logged_in_clinic')) redirect(base_url());
		$this->load->library('template_apotek');
		$this->load->model('apotek/obat_model');
	}

	public function index()
	{
		if($this->session->userdata('logged_in_clinic'))
		{
			$data['daftarlist'] = $this->obat_model->select_all()->result();
			$this->template_apotek->display('apotek/obat_view', $data);
		} else {
			$this->session->sess_destroy();
			redirect(base_url());
		} 
	}

	public function adddata() {
		$data['error']				= false;
		$data['listJenis'] 		= $this->obat_model->select_jenis_obat()->result();
		$data['listGolongan'] 	= $this->obat_model->select_gol_obat()->result();
		$data['listPabrikan'] 	= $this->obat_model->select_pabrikan()->result();
		$data['listSuplier'] 	= $this->obat_model->select_suplier()->result();		
		$this->template_apotek->display('apotek/obat_add_view', $data);
	}

	public function savedata() {		
		$this->form_validation->set_rules('name','<b>Nama Obat</b>','trim|required|is_unique[clinic_obat.obat_name]');

		if ($this->form_validation->run() == FALSE) {
			$data['error']				= true;
			$data['listProvinsi'] 		= $this->obat_model->select_provinsi()->result();
			$data['listKabupaten'] 		= $this->obat_model->select_kabupaten()->result();
			$this->template_apotek->display('apotek/obat_add_view', $data);
		} else {			
			$this->obat_model->insert_data();
			$this->session->set_flashdata('notification','Simpan Data Sukses.');
	 		redirect(site_url('apotek/obat'));
	 	}
	}

	public function editdata($obat_code) {		
		$data['listJenis'] 		= $this->obat_model->select_jenis_obat()->result();
		$data['listGolongan'] 	= $this->obat_model->select_gol_obat()->result();
		$data['listPabrikan'] 	= $this->obat_model->select_pabrikan()->result();
		$data['listSuplier'] 	= $this->obat_model->select_suplier()->result();
		$data['detail'] 		= $this->obat_model->select_by_id($obat_code)->row();
		$this->template_apotek->display('apotek/obat_edit_view', $data);
	}
	
	public function updatedata() {		
		$this->obat_model->update_data();
		$this->session->set_flashdata('notification','Update Data Sukses.');
		redirect(site_url('apotek/obat'));
	}
	
	public function deletedata($kode) {
		$kode = $this->security->xss_clean($this->uri->segment(4));
		
		if ($kode == null) {
			redirect(site_url('apotek/obat'));
		} else {
			$this->obat_model->delete_data($kode);
			$this->session->set_flashdata('notification','Hapus Data Sukses.');
			echo "<meta http-equiv=refresh content=0;url=\"".site_url()."apotek/obat\">";
		}
	}	
}
/* Location: ./application/controller/apotek/Obat.php */