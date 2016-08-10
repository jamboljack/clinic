<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {
	function __construct() {
		parent::__construct();
		if(!$this->session->userdata('logged_in_clinic')) redirect(base_url());
		$this->load->library('template');
		$this->load->model('admin/produk_model');
	}

	public function index()
	{
		if($this->session->userdata('logged_in_clinic'))
		{
			$data['daftarlist'] 	= $this->produk_model->select_all()->result();			
			$this->template->display('admin/produk_view', $data);
		} else {
			$this->session->sess_destroy();
			redirect(base_url());
		} 
	}

	public function adddata() {
		$data['listJenis'] 		= $this->produk_model->select_jenis()->result();
		$data['listUnit'] 		= $this->produk_model->select_unit()->result();
		$this->template->display('admin/produk_add_view', $data);
	}

	public function savedata() {						
		$this->produk_model->insert_data();
		$this->session->set_flashdata('notification','Simpan Data Sukses.');
 		redirect(site_url('admin/produk'));
	}

	public function editdata($produk_id) {
		$data['listJenis'] 	= $this->produk_model->select_jenis()->result();
		$data['listUnit'] 	= $this->produk_model->select_unit()->result();		
		$data['detail'] 	= $this->produk_model->select_by_id($produk_id)->row();
		$this->template->display('admin/produk_edit_view', $data);
	}
	
	public function updatedata() {		
		$this->produk_model->update_data();
		$this->session->set_flashdata('notification','Update Data Sukses.');
		redirect(site_url('admin/produk'));
	}
	
	public function deletedata($kode) {
		$kode = $this->security->xss_clean($this->uri->segment(4));
		
		if ($kode == null) {
			redirect(site_url('admin/produk'));
		} else {
			$this->produk_model->delete_data($kode);
			$this->session->set_flashdata('notification','Hapus Data Sukses.');
			echo "<meta http-equiv=refresh content=0;url=\"".site_url()."admin/produk\">";
		}
	}	
}
/* Location: ./application/controller/admin/Produk.php */