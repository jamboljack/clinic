<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Retur_beli extends CI_Controller {
	function __construct() {
		parent::__construct();
		if(!$this->session->userdata('logged_in_clinic')) redirect(base_url());
		$this->load->library('template_apotek');
		$this->load->model('apotek/retur_beli_model');
	}

	public function index()
	{
		if($this->session->userdata('logged_in_clinic'))
		{
			$data['daftarlist'] = $this->retur_beli_model->select_all()->result();
			$this->template_apotek->display('apotek/retur_beli_view', $data);
		} else {
			$this->session->sess_destroy();
			redirect(base_url());
		} 
	}

	public function adddata() {		
		$data['listSuplier'] 	= $this->retur_beli_model->select_suplier()->result();		
		$data['listObat'] 		= $this->retur_beli_model->select_obat()->result();

		$ID_Retur				= $this->uri->segment(4);
		if (empty($ID_Retur) || $ID_Retur == '') {
			$data['KodeRB'] 	= $this->retur_beli_model->getkodeunik();
			$data['Total']		= 0;
		} else {
			$CekPO 				= $this->retur_beli_model->check_transaksi($ID_Retur)->row();
			$data['KodeRB'] 	= $CekPO->retur_no_rpb;
			$Total 				= $this->retur_beli_model->select_total($ID_Retur)->row();
			$data['Total']		= $Total->total; // Total PO
		}
		$data['listItem'] 		= $this->retur_beli_model->select_item($ID_Retur)->result();
		$this->template_apotek->display('apotek/retur_beli_add_view', $data);
	}

	public function savedataitem() {
		$ID_Retur				= $this->uri->segment(4);
		
		if (empty($ID_Retur) || $ID_Retur == '') {
			// Insert Baru ke retur_beli
			$CodeRB = $this->retur_beli_model->getkodeunik(); //Cek lagi jika ada 2 Nota lewat Jaringan
			$data = array(
				'retur_no_rpb'			=> $CodeRB,
		   		'retur_date' 			=> date('Y-m-d'),
		   		'retur_date_update' 	=> date('Y-m-d'),
		   		'retur_time_update' 	=> date('Y-m-d H:i:s'),
		   		'user_username' 		=> trim($this->session->userdata('username')),
		   		'retur_status' 			=> 0
			);

			$this->db->insert('clinic_retur_beli', $data);
			$id = $this->db->insert_id();
		} else {
			$id = $ID_Retur;			
		}

		// Insert Item
		// Cek jika ada Item yang Sama dimasukkan
		// Variabel Obat
		$CodeObat 	= trim($this->input->post('code'));
		$kemasan 	= strtoupper(trim($this->input->post('satuan'))); // Kemasan
		$satuan 	= strtoupper(trim($this->input->post('satuankecil'))); // Satuan Kecil
		$isi 		= $this->input->post('isikecil'); // Isi Satuan Kecil		
		$stokakhir 	= $this->input->post('stokakhir'); // Stok Terakhir	

		// Konversi String ke Integer
		$Qty 		= $this->input->post('qty');
		$Harga 		= intval(str_replace(",", "", $this->input->post('harga')));
		$Diskon 	= intval($this->input->post('disc'));			
		$TotalNoDisc= ($Qty * $Harga);
		$DiscRp		= (($Diskon * $TotalNoDisc)/100);
		$SubTotal 	= intval(str_replace(",", "", $this->input->post('subtotal')));
		$HPP 		= 0;
		// Update Stok Barang ke Obat
		if ($kemasan == $satuan) { // Jika Kemasan = Satuan
			$Disc1 		= (($Harga*$Diskon)/100); // Nominal Disc Harga Satuan
			$HPP 		= ($Harga - $Disc1); // HPP Obat
			$Hrg_sat	= $Harga; // Harga Satuan Kecil
			$Stok   	= ($stokakhir - $Qty); // Stok terakhir - Qty
		} else {			
			$Hrg_sat	= ($Harga/$isi); // Harga Kecil
			$Disc1 		= (($Hrg_sat*$Diskon)/100); // Nominal Disc Harga Satuan
			$HPP 		= ($Hrg_sat-$Disc1); // HPP Obat			
			$Convert	= ($Qty*$isi); // Qty x Isi Satuan (karena stok = satuan kecil)
			$Stok   	= ($stokakhir - $Convert); // Stok terakhir - Konversi qty
		}		

		$data = array(
				'obat_hrg_kms' 		=> $Harga, // Harga Beli Kemasan Obat
				'obat_hrg_kcl' 		=> $Hrg_sat, // Harga Beli Kemasan Obat
				'obat_hpp' 			=> $HPP, // HPP				
				'obat_stok'			=> $Stok // Stok Obat
			);

		$this->db->where('obat_code', $CodeObat);
		$this->db->update('clinic_obat', $data);
		// Cek Item		
		$CekItem  = $this->retur_beli_model->check_item($CodeObat)->row();		
		if (count($CekItem) > 0) { // Jika Ada, Maka Update Item			
			$Qty 		= $CekItem->detail_qty;
			$Disc 		= $CekItem->detail_disc;
			$Diskon 	= intval($this->input->post('disc'));
			$Sub 		= $CekItem->detail_total;
			$SubTotal 	= intval(str_replace(",", "", $this->input->post('subtotal')));

			$data = array(
					'detail_qty'			=> ($Qty + $this->input->post('qty')),
					'detail_disc'			=> ($Disc + $Diskon),
					'detail_total'			=> ($Sub + $SubTotal),					
			   		'detail_date_update' 	=> date('Y-m-d'),
			   		'detail_time_update' 	=> date('Y-m-d H:i:s')
			);

			$this->db->where('obat_code', $CodeObat);
			$this->db->update('clinic_retur_beli_detail', $data);			
		} else { // Jika belum, Insert Data Item Baru			
			$data = array(
					'retur_id'				=> $id,				
					'obat_code'				=> trim($this->input->post('code')),
					'detail_name'			=> trim($this->input->post('name')),
					'detail_qty'			=> $this->input->post('qty'),
					'detail_isi_kcl'		=> $isi,
					'detail_satuan'			=> trim($this->input->post('satuan')),
					'detail_sat_kcl'		=> $satuan,
					'detail_harga'			=> $Harga,
					'detail_hpp'			=> $HPP,
					'detail_disc'			=> $Diskon,
					'detail_disc_nominal'	=> $DiscRp,
					'detail_total'			=> $SubTotal,
			   		'detail_date_update' 	=> date('Y-m-d'),
			   		'detail_time_update' 	=> date('Y-m-d H:i:s')
			);
			$this->db->insert('clinic_retur_beli_detail', $data);			
		}		
		
		// Update Total Purchase
		$Total 		= $this->retur_beli_model->select_total($ID_Retur)->row();
		$TotalRB	= $Total->total; // Total PO

		$data = array(
			'retur_bruto'			=> $TotalRB,
			'retur_netto'			=> $TotalRB,
		   	'retur_date_update' 	=> date('Y-m-d'),
		   	'retur_time_update' 	=> date('Y-m-d H:i:s'),
		   	'user_username' 		=> trim($this->session->userdata('username'))		   		
		);

		$this->db->where('retur_id', $id);
		$this->db->update('clinic_retur_beli', $data);		

		// Redirect ke Halaman Adddata
		redirect(site_url('apotek/retur_beli/adddata/'.$id));		
	}

	public function savedataitemedit() {
		$ID_Retur		= $this->uri->segment(4);

		// Variabel Obat
		$CodeObat 	= trim($this->input->post('code'));
		$kemasan 	= strtoupper(trim($this->input->post('satuan'))); // Kemasan
		$satuan 	= strtoupper(trim($this->input->post('satuankecil'))); // Satuan Kecil
		$isi 		= $this->input->post('isikecil'); // Isi Satuan Kecil		
		$stokakhir 	= $this->input->post('stokakhir'); // Stok Terakhir	
		// Konversi String ke Integer
		$Qty 		= $this->input->post('qty');
		$Harga 		= intval(str_replace(",", "", $this->input->post('harga')));
		$Diskon 	= intval($this->input->post('disc'));			
		$TotalNoDisc= ($Qty * $Harga);
		$DiscRp		= (($Diskon * $TotalNoDisc)/100);
		$SubTotal 	= intval(str_replace(",", "", $this->input->post('subtotal')));
		$HPP 		= 0;
				
		// Update Stok Barang ke Obat
		if ($kemasan == $satuan) { // Jika Kemasan = Satuan
			$Disc1 		= (($Harga*$Diskon)/100); // Nominal Disc Harga Satuan
			$HPP 		= ($Harga - $Disc1); // HPP Obat
			$Hrg_sat	= $Harga; // Harga Satuan Kecil
			$Stok   	= ($stokakhir - $Qty); // Stok terakhir + Qty
		} else {			
			$Hrg_sat	= ($Harga/$isi); // Harga Kecil
			$Disc1 		= (($Hrg_sat*$Diskon)/100); // Nominal Disc Harga Satuan
			$HPP 		= ($Hrg_sat-$Disc1); // HPP Obat			
			$Convert	= ($Qty*$isi); // Qty x Isi Satuan (karena stok = satuan kecil)
			$Stok   	= ($stokakhir - $Convert); // Stok terakhir + Konversi qty
		}		

		$data = array(
				'obat_hrg_kms' 		=> $Harga, // Harga Beli Kemasan Obat
				'obat_hrg_kcl' 		=> $Hrg_sat, // Harga Beli Kemasan Obat
				'obat_hpp' 			=> $HPP, // HPP				
				'obat_stok'			=> $Stok // Stok Obat
			);

		$this->db->where('obat_code', $CodeObat);
		$this->db->update('clinic_obat', $data);

		// Cek jika ada Item yang Sama dimasukkan
		$CekItem  = $this->retur_beli_model->check_item($CodeObat)->row();		
		if (count($CekItem) > 0) { // Jika Ada, Maka Update Item			
			$Qty 		= $CekItem->detail_qty;
			$Disc 		= $CekItem->detail_disc;
			$Diskon 	= intval($this->input->post('disc'));
			$Sub 		= $CekItem->detail_total;
			$SubTotal 	= intval(str_replace(",", "", $this->input->post('subtotal')));

			$data = array(
					'detail_qty'			=> ($Qty + $this->input->post('qty')),					
					'detail_disc'			=> ($Disc + $Diskon),
					'detail_total'			=> ($Sub + $SubTotal),					
			   		'detail_date_update' 	=> date('Y-m-d'),
			   		'detail_time_update' 	=> date('Y-m-d H:i:s')
			);

			$this->db->where('obat_code', $CodeObat);
			$this->db->update('clinic_retur_beli_detail', $data);		
		} else {			
			$data = array(
					'retur_id'				=> $ID_Retur,				
					'obat_code'				=> trim($this->input->post('code')),
					'detail_name'			=> trim($this->input->post('name')),
					'detail_qty'			=> $this->input->post('qty'),
					'detail_isi_kcl'		=> $isi,
					'detail_satuan'			=> trim($this->input->post('satuan')),
					'detail_sat_kcl'		=> $satuan,
					'detail_harga'			=> $Harga,
					'detail_hpp'			=> $HPP,
					'detail_disc'			=> $Diskon,
					'detail_disc_nominal'	=> $DiscRp,
					'detail_total'			=> $SubTotal,					
			   		'detail_date_update' 	=> date('Y-m-d'),
			   		'detail_time_update' 	=> date('Y-m-d H:i:s')
			);
			$this->db->insert('clinic_retur_beli_detail', $data);
		}		
		
		// Update Total Invoice
		$Total 		= $this->retur_beli_model->select_total($ID_Retur)->row();
		$TotalRB	= $Total->total; // Total PO

		$data = array(
			'retur_bruto'			=> $TotalRB,
			'retur_netto'			=> $TotalRB,
		   	'retur_date_update' 	=> date('Y-m-d'),
		   	'retur_time_update' 	=> date('Y-m-d H:i:s'),
		   	'user_username' 		=> trim($this->session->userdata('username'))		   		
		);

		$this->db->where('retur_id', $id);
		$this->db->update('clinic_retur_beli', $data);

		// Redirect ke Halaman EditData
		redirect(site_url('apotek/retur_beli/editdata/'.$ID_Retur));		
	}

	public function editdata($ID_Retur) {		
		$data['listSuplier'] 	= $this->retur_beli_model->select_suplier()->result();
		$data['listObat'] 		= $this->retur_beli_model->select_obat()->result();
		$data['detail'] 		= $this->retur_beli_model->select_by_id($ID_Retur)->row();
		$data['listItem'] 		= $this->retur_beli_model->select_item($ID_Retur)->result();
		$Total 					= $this->retur_beli_model->select_total($ID_Retur)->row();
		$data['Total']			= $Total->total; // Total PO
		$this->template_apotek->display('apotek/retur_beli_edit_view', $data);
	}
	
	public function updatedataitem() {		
		$this->retur_beli_model->update_data_item();
		$this->session->set_flashdata('notification','Data Item Tersimpan.');
		redirect(site_url('apotek/retur_beli/adddata/'.$this->uri->segment(4)));
	}

	public function updatedataitemedit() {		
		$this->retur_beli_model->update_data_item();
		$this->session->set_flashdata('notification','Data Item Tersimpan.');
		redirect(site_url('apotek/retur_beli/editdata/'.$this->uri->segment(4)));
	}

	public function updatedata() {		
		$this->retur_beli_model->update_data();
		$this->session->set_flashdata('notification','Data Purchase Tersimpan.');
		redirect(site_url('apotek/retur_beli'));
	}
	
	public function deletedata($kode) {
		$kode = $this->security->xss_clean($this->uri->segment(4));
		
		if ($kode == null) {
			redirect(site_url('apotek/retur_beli'));
		} else {
			$this->retur_beli_model->delete_data($kode);
			$this->session->set_flashdata('notification','Hapus Data Purchase Sukses.');
			redirect(site_url('apotek/retur_beli'));
		}
	}

	public function deletedataitem($kode) {
		$kode = $this->security->xss_clean($this->uri->segment(5));
		
		if ($kode == null) {
			redirect(site_url('apotek/retur_beli/adddata/'.$this->uri->segment(4)));
		} else {
			$this->retur_beli_model->delete_data_item($kode);
			$this->session->set_flashdata('notification','Hapus Item Sukses.');
			redirect(site_url('apotek/retur_beli/adddata/'.$this->uri->segment(4)));
		}
	}

	public function deletedataitemedit($kode) {
		$kode = $this->security->xss_clean($this->uri->segment(5));
		
		if ($kode == null) {
			redirect(site_url('apotek/retur_beli/editdata/'.$this->uri->segment(4)));
		} else {
			$this->retur_beli_model->delete_data_item($kode);
			$this->session->set_flashdata('notification','Hapus Item Sukses.');
			redirect(site_url('apotek/retur_beli/editdata/'.$this->uri->segment(4)));
		}
	}
}
/* Location: ./application/controller/apotek/Retur_beli.php */