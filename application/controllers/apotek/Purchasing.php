<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchasing extends CI_Controller {
	function __construct() {
		parent::__construct();
		if(!$this->session->userdata('logged_in_clinic')) redirect(base_url());
		$this->load->library('template_apotek');
		$this->load->model('apotek/purchasing_model');
	}

	public function index()
	{
		if($this->session->userdata('logged_in_clinic'))
		{
			$data['daftarlist'] = $this->purchasing_model->select_all()->result();
			$this->template_apotek->display('apotek/purchasing_view', $data);
		} else {
			$this->session->sess_destroy();
			redirect(base_url());
		} 
	}

	public function adddata() {		
		$data['listSuplier'] 	= $this->purchasing_model->select_suplier()->result();		
		$data['listObat'] 		= $this->purchasing_model->select_obat()->result();		
		$ID_Purchase			= $this->uri->segment(4);
		if (empty($ID_Purchase) || $ID_Purchase == '') {
			$data['KodePO'] 	= $this->purchasing_model->getkodeunik();
			$data['Total']		= 0;
		} else {
			$CekPO 				= $this->purchasing_model->check_purchase($ID_Purchase)->row();
			$data['KodePO'] 	= $CekPO->purchase_no;
			$Total 				= $this->purchasing_model->select_total($ID_Purchase)->row();
			$data['Total']		= $Total->total; // Total PO
		}
		$data['listItem'] 		= $this->purchasing_model->select_item($ID_Purchase)->result();
		$this->template_apotek->display('apotek/purchasing_add_view', $data);
	}

	public function savedataitem() {
		$ID_Purchase			= $this->uri->segment(4);
		
		if (empty($ID_Purchase) || $ID_Purchase == '') {
			// Insert Baru ke Purchase
			$CodePO = $this->purchasing_model->getkodeunik(); //Cek lagi jika ada 2 PO lewat Jaringan
			$data = array(
				'purchase_no'				=> $CodePO,
		   		'purchase_date' 			=> date('Y-m-d'),
		   		'purchase_date_update' 		=> date('Y-m-d'),
		   		'purchase_time_update' 		=> date('Y-m-d H:i:s'),
		   		'user_username' 			=> trim($this->session->userdata('username')),
		   		'purchase_status' 			=> 0
			);

			$this->db->insert('clinic_purchase', $data);
			$id = $this->db->insert_id();
		} else {
			$id = $ID_Purchase;			
		}
				
		// Insert Item
		// Cek jika ada Item yang Sama dimasukkan
		$CodeObat = trim($this->input->post('code'));		
		$CekItem  = $this->purchasing_model->check_item($CodeObat)->row();		
		if (count($CekItem) > 0) { // Jika Ada, Maka Update Item			
			$Qty = $CekItem->purc_detail_qty;
			$Sub = $CekItem->purc_detail_subtotal;

			$SubTotal 	= intval(str_replace(",", "", $this->input->post('subtotal')));

			$data = array(
					'purc_detail_qty'			=> ($Qty + $this->input->post('qty')),
					'purc_detail_subtotal'		=> ($Sub + $SubTotal),
			   		'purc_detail_date_update' 	=> date('Y-m-d'),
			   		'purc_detail_time_update' 	=> date('Y-m-d H:i:s')
			);

			$this->db->where('obat_code', $CodeObat);
			$this->db->update('clinic_purchase_detail', $data);			
		} else {			
			// Konversi String ke Integer
			$Harga 		= intval(str_replace(",", "", $this->input->post('harga')));
			$SubTotal 	= intval(str_replace(",", "", $this->input->post('subtotal')));			

			$data = array(
					'purchase_id'				=> $id,				
					'obat_code'					=> trim($this->input->post('code')),
					'purc_detail_name'			=> trim($this->input->post('name')),
					'purc_detail_qty'			=> $this->input->post('qty'),
					'purc_detail_satuan'		=> trim($this->input->post('satuan')),
					'purc_detail_harga'			=> $Harga,
					'purc_detail_subtotal'		=> $SubTotal,
			   		'purc_detail_date_update' 	=> date('Y-m-d'),
			   		'purc_detail_time_update' 	=> date('Y-m-d H:i:s')
			);

			$this->db->insert('clinic_purchase_detail', $data);
		}		
		
		// Update Total Purchase
		$Total 		= $this->purchasing_model->select_total($ID_Purchase)->row();
		$TotalPO	= $Total->total; // Total PO

		$data = array(
			'purchase_total'			=> $TotalPO,		   		
		   	'purchase_date_update' 		=> date('Y-m-d'),
		   	'purchase_time_update' 		=> date('Y-m-d H:i:s'),
		   	'user_username' 			=> trim($this->session->userdata('username'))		   		
		);

		$this->db->where('purchase_id', $id);
		$this->db->update('clinic_purchase', $data);
		// Redirect ke Halaman Adddata
		redirect(site_url('apotek/purchasing/adddata/'.$id));		
	}

	public function savedataitemedit() {
		$ID_Purchase			= $this->uri->segment(4);		
		// Insert Item
		// Cek jika ada Item yang Sama dimasukkan
		$CodeObat = trim($this->input->post('code'));		
		$CekItem  = $this->purchasing_model->check_item($CodeObat)->row();		
		if (count($CekItem) > 0) { // Jika Ada, Maka Update Item			
			$Qty = $CekItem->purc_detail_qty;
			$Sub = $CekItem->purc_detail_subtotal;

			$SubTotal 	= intval(str_replace(",", "", $this->input->post('subtotal')));

			$data = array(
					'purc_detail_qty'			=> ($Qty + $this->input->post('qty')),
					'purc_detail_subtotal'		=> ($Sub + $SubTotal),
			   		'purc_detail_date_update' 	=> date('Y-m-d'),
			   		'purc_detail_time_update' 	=> date('Y-m-d H:i:s')
			);

			$this->db->where('obat_code', $CodeObat);
			$this->db->update('clinic_purchase_detail', $data);			
		} else {			
			// Konversi String ke Integer
			$Harga 		= intval(str_replace(",", "", $this->input->post('harga')));
			$SubTotal 	= intval(str_replace(",", "", $this->input->post('subtotal')));			

			$data = array(
					'purchase_id'				=> $ID_Purchase,				
					'obat_code'					=> trim($this->input->post('code')),
					'purc_detail_name'			=> trim($this->input->post('name')),
					'purc_detail_qty'			=> $this->input->post('qty'),
					'purc_detail_satuan'		=> trim($this->input->post('satuan')),
					'purc_detail_harga'			=> $Harga,
					'purc_detail_subtotal'		=> $SubTotal,
			   		'purc_detail_date_update' 	=> date('Y-m-d'),
			   		'purc_detail_time_update' 	=> date('Y-m-d H:i:s')
			);

			$this->db->insert('clinic_purchase_detail', $data);
		}		
		
		// Update Total Purchase
		$Total 		= $this->purchasing_model->select_total($ID_Purchase)->row();
		$TotalPO	= $Total->total; // Total PO

		$data = array(
			'purchase_total'			=> $TotalPO,		   		
		   	'purchase_date_update' 		=> date('Y-m-d'),
		   	'purchase_time_update' 		=> date('Y-m-d H:i:s'),
		   	'user_username' 			=> trim($this->session->userdata('username'))		   		
		);

		$this->db->where('purchase_id', $ID_Purchase);
		$this->db->update('clinic_purchase', $data);

		// Redirect ke Halaman EditData
		redirect(site_url('apotek/purchasing/editdata/'.$ID_Purchase));		
	}

	public function editdata($ID_Purchase) {		
		$data['listSuplier'] 	= $this->purchasing_model->select_suplier()->result();
		$data['listObat'] 		= $this->purchasing_model->select_obat()->result();
		$data['detail'] 		= $this->purchasing_model->select_by_id($ID_Purchase)->row();
		$data['listItem'] 		= $this->purchasing_model->select_item($ID_Purchase)->result();
		$Total 					= $this->purchasing_model->select_total($ID_Purchase)->row();
		$data['Total']			= $Total->total; // Total PO
		$this->template_apotek->display('apotek/purchasing_edit_view', $data);
	}
	
	public function updatedataitem() {		
		$this->purchasing_model->update_data_item();
		$this->session->set_flashdata('notification','Data Item Tersimpan.');
		redirect(site_url('apotek/purchasing/adddata/'.$this->uri->segment(4)));
	}

	public function updatedataitemedit() {		
		$this->purchasing_model->update_data_item();
		$this->session->set_flashdata('notification','Data Item Tersimpan.');
		redirect(site_url('apotek/purchasing/editdata/'.$this->uri->segment(4)));
	}

	public function updatedata() {		
		$this->purchasing_model->update_data();
		$this->session->set_flashdata('notification','Data Purchase Tersimpan.');
		redirect(site_url('apotek/purchasing'));
	}
	
	public function deletedata($kode) {
		$kode = $this->security->xss_clean($this->uri->segment(4));
		
		if ($kode == null) {
			redirect(site_url('apotek/purchasing'));
		} else {
			$this->purchasing_model->delete_data($kode);
			$this->session->set_flashdata('notification','Hapus Data Purchase Sukses.');
			redirect(site_url('apotek/purchasing'));
		}
	}

	public function deletedataitem($kode) {
		$kode = $this->security->xss_clean($this->uri->segment(5));
		
		if ($kode == null) {
			redirect(site_url('apotek/purchasing/adddata/'.$this->uri->segment(4)));
		} else {
			$this->purchasing_model->delete_data_item($kode);
			$this->session->set_flashdata('notification','Hapus Item Sukses.');
			redirect(site_url('apotek/purchasing/adddata/'.$this->uri->segment(4)));
		}
	}

	public function deletedataitemedit($kode) {
		$kode = $this->security->xss_clean($this->uri->segment(5));
		
		if ($kode == null) {
			redirect(site_url('apotek/purchasing/adddata/'.$this->uri->segment(4)));
		} else {
			$this->purchasing_model->delete_data_item($kode);
			$this->session->set_flashdata('notification','Hapus Item Sukses.');
			redirect(site_url('apotek/purchasing/editdata/'.$this->uri->segment(4)));
		}
	}
}
/* Location: ./application/controller/apotek/Purchasing.php */