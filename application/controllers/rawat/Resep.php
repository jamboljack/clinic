<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resep extends CI_Controller {
	function __construct() {
		parent::__construct();
		if(!$this->session->userdata('logged_in_clinic')) redirect(base_url());
		$this->load->library('template_rawat');
		$this->load->model('rawat/resep_model');
	}

	public function index()
	{
		if($this->session->userdata('logged_in_clinic'))
		{			
			$data['listResep'] 	= $this->resep_model->select_all()->result();
			$this->template_rawat->display('rawat/resep_view', $data);
		} else {
			$this->session->sess_destroy();
			redirect(base_url());
		}
	}
	
	public function pilihpasien() {		
		$data['listPasien'] 	= $this->resep_model->select_pasien()->result();		
		$this->template_rawat->display('rawat/list_pasien_resep_view', $data);
	}

	public function addresep($rawat_id) {
		$rawat_id 				= $this->uri->segment(4); // ID Perawatan						
		$jenis_tarif			= $this->uri->segment(5); // ID Jual
		$jual_id				= $this->uri->segment(7); // ID Jual
		
		if (empty($jual_id) || $jual_id == '') {
			$data['KodePJ'] 	= $this->resep_model->getkodeunikresep();
			$data['Total']		= 0;
		} else {			
			$CekTrans 			= $this->resep_model->check_transaksi($jual_id)->row();
			$data['KodePJ'] 	= $CekTrans->jual_no_faktur;
			$Total 				= $this->resep_model->select_total_resep($jual_id)->row();
			$data['Total']		= $Total->total; // Total Harga Tindakan Pasien			
		}

		$data['detail_pasien'] 	= $this->resep_model->select_detail_pasien($rawat_id)->row();
		$data['listDokter'] 	= $this->resep_model->select_dokter()->result();
		$data['listObat'] 		= $this->resep_model->select_obat($jenis_tarif)->result();
		$data['listItem'] 		= $this->resep_model->select_item_resep($jual_id)->result();
		$this->template_rawat->display('rawat/add_resep_view', $data);
	}

	public function savedata() {
		$rawat_id			= $this->uri->segment(4); // Rawat ID
		$jual_id			= $this->uri->segment(7); // ID Jual		

		if (empty($jual_id) || $jual_id == '') {
			// Insert Baru ke Penjualan
			$CodePJ 		= $this->resep_model->getkodeunikresep(); //Cek lagi jika ada 2 Nota lewat Jaringan
			$data = array(
				'jual_no_faktur'			=> $CodePJ,
		   		'jual_date' 				=> date('Y-m-d'),
		   		'rawat_id'					=> $this->uri->segment(4),
		   		'jenis_id'					=> $this->uri->segment(5),
		   		'dokter_id'					=> $this->input->post('dokter_id'),
		   		'pasien_id'					=> $this->input->post('pasien_id'),		   		
		   		'jual_date_update' 			=> date('Y-m-d'),
		   		'jual_time_update' 			=> date('Y-m-d H:i:s'),
		   		'user_username' 			=> trim($this->session->userdata('username')),
		   		'jual_status' 				=> 'JUAL'
			);

			$this->db->insert('clinic_jual', $data);
			$id = $this->db->insert_id();			
		} else {
			$CodePJ  		= $this->uri->segment(6); // No Faktur Jual
			$id = $jual_id;
		}		
		
		// Insert Item
		// Cek jika ada Item yang Sama dimasukkan
		// Variabel Obat
		$CodeObat 	= trim($this->input->post('code'));		
		$stokakhir 	= $this->input->post('stokakhir'); // Stok Terakhir	
		// Konversi String ke Integer
		$Qty 		= $this->input->post('qty');
		$Harga 		= intval(str_replace(",", "", $this->input->post('harga')));
		$Diskon 	= intval($this->input->post('disc'));			
		$TotalNoDisc= ($Qty * $Harga);
		$DiscRp		= (($Diskon * $TotalNoDisc)/100);
		$SubTotal 	= intval(str_replace(",", "", $this->input->post('subtotal')));
		$HPP 		= $this->input->post('hrg_pokok'); // Harga Pokok Obat
		// Update Stok Barang ke Obat		
		$Disc1 		= (($Harga*$Diskon)/100); // Nominal Disc Harga Satuan		
		$Stok   	= ($stokakhir - $Qty); // Stok terakhir + Qty
		$data = array(				
				'obat_stok'			=> $Stok // Stok Obat
			);

		$this->db->where('obat_code', $CodeObat);
		$this->db->update('clinic_obat', $data);
		// Selesai Update Stok

		// Cek Item		
		$CekItem  = $this->resep_model->check_item_resep($CodeObat)->row();		
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
			$this->db->where('jual_id', $id);
			$this->db->update('clinic_jual_detail', $data);			
		} else { // Jika belum, Insert Data Item Baru			
			$data = array(
					'jual_id'				=> $id,				
					'obat_code'				=> trim($this->input->post('code')),
					'detail_name'			=> trim($this->input->post('name')),
					'detail_qty'			=> $this->input->post('qty'),					
					'detail_satuan'			=> trim($this->input->post('satuan')),					
					'detail_harga'			=> $Harga,
					'detail_hpp'			=> $HPP,
					'detail_disc'			=> $Diskon,
					'detail_disc_nominal'	=> $DiscRp,
					'detail_total'			=> $SubTotal,					
			   		'detail_date_update' 	=> date('Y-m-d'),
			   		'detail_time_update' 	=> date('Y-m-d H:i:s')
			);
			$this->db->insert('clinic_jual_detail', $data);			
		}		
		
		$jual_id = $id;
		// Update Total Resep
		$Total 				= $this->resep_model->select_total_resep($jual_id)->row();
		$Total				= $Total->total; // Total Harga Tindakan Pasien			

		$data = array(
			'jual_total'		=> $Total,
		   	'jual_date_update' 	=> date('Y-m-d'),
		   	'jual_time_update' 	=> date('Y-m-d H:i:s'),
		   	'user_username' 	=> trim($this->session->userdata('username'))		   		
		);

		$this->db->where('jual_id', $id);
		$this->db->update('clinic_jual', $data);
						
		// Redirect ke Halaman Adddata BHP
		redirect(site_url('rawat/resep/addresep/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$CodePJ.'/'.$id));		
	}

	public function updatedataitem() {		
		$this->resep_model->update_data_item();
		$this->session->set_flashdata('notification','Data Item Tersimpan.');
		redirect(site_url('rawat/resep/addresep/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$this->uri->segment(7)));
	}

	public function deletedataitem($kode) {
		$kode = $this->security->xss_clean($this->uri->segment(8));
		
		if ($kode == null) {
			redirect(site_url('rawat/resep/addresep/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$this->uri->segment(7)));
		} else {
			$this->resep_model->delete_data_item($kode);
			$this->session->set_flashdata('notification','Hapus Item Sukses.');
			redirect(site_url('rawat/resep/addresep/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$this->uri->segment(7)));
		}
	}

	public function updatedata() {
		$this->resep_model->update_data();
		$this->session->set_flashdata('notification','Simpan Data Sukses.');
		redirect(site_url('rawat/resep'));
	}

	public function deletedata($kode) {
		$kode = $this->security->xss_clean($this->uri->segment(4));
		
		if ($kode == null) {
			redirect(site_url('rawat/resep'));
		} else {
			$this->resep_model->delete_data($kode);
			$this->session->set_flashdata('notification','Hapus Data Sukses.');
			redirect(site_url('rawat/resep'));
		}
	}

	public function pembayaran() {
		$this->resep_model->pembayaran_data();
		$this->session->set_flashdata('notification','Pembayaran Billing Sukses.');
		redirect(site_url('rawat/resep'));
	}

	public function editresep($rawat_id) {
		$rawat_id 				= $this->uri->segment(4); // ID Perawatan						
		$jenis_tarif			= $this->uri->segment(5); // ID Jual
		$jual_id				= $this->uri->segment(7); // ID Jual
				
		$Total 					= $this->resep_model->select_total_resep($jual_id)->row();
		$data['Total']			= $Total->total; // Total Harga Tindakan Pasien					
		$data['detail'] 		= $this->resep_model->check_transaksi($jual_id)->row();
		$data['detail_pasien'] 	= $this->resep_model->select_detail_pasien($rawat_id)->row();
		$data['listDokter'] 	= $this->resep_model->select_dokter()->result();
		$data['listObat'] 		= $this->resep_model->select_obat($jenis_tarif)->result();
		$data['listItem'] 		= $this->resep_model->select_item_resep($jual_id)->result();
		$this->template_rawat->display('rawat/edit_resep_view', $data);
	}

	public function savedataedit() {
		$rawat_id			= $this->uri->segment(4); // Rawat ID
		$jual_id			= $this->uri->segment(7); // ID Jual		

		// Insert Item
		// Cek jika ada Item yang Sama dimasukkan
		// Variabel Obat
		$CodeObat 	= trim($this->input->post('code'));		
		$stokakhir 	= $this->input->post('stokakhir'); // Stok Terakhir	
		// Konversi String ke Integer
		$Qty 		= $this->input->post('qty');
		$Harga 		= intval(str_replace(",", "", $this->input->post('harga')));
		$Diskon 	= intval($this->input->post('disc'));			
		$TotalNoDisc= ($Qty * $Harga);
		$DiscRp		= (($Diskon * $TotalNoDisc)/100);
		$SubTotal 	= intval(str_replace(",", "", $this->input->post('subtotal')));
		$HPP 		= $this->input->post('hrg_pokok'); // Harga Pokok Obat
		// Update Stok Barang ke Obat		
		$Disc1 		= (($Harga*$Diskon)/100); // Nominal Disc Harga Satuan		
		$Stok   	= ($stokakhir - $Qty); // Stok terakhir + Qty
		$data = array(				
				'obat_stok'			=> $Stok // Stok Obat
			);

		$this->db->where('obat_code', $CodeObat);
		$this->db->update('clinic_obat', $data);
		// Selesai Update Stok

		// Cek Item		
		$CekItem  = $this->resep_model->check_item_resep($CodeObat)->row();		
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
			$this->db->where('jual_id', $jual_id);
			$this->db->update('clinic_jual_detail', $data);			
		} else { // Jika belum, Insert Data Item Baru			
			$data = array(
					'jual_id'				=> $jual_id,				
					'obat_code'				=> trim($this->input->post('code')),
					'detail_name'			=> trim($this->input->post('name')),
					'detail_qty'			=> $this->input->post('qty'),					
					'detail_satuan'			=> trim($this->input->post('satuan')),					
					'detail_harga'			=> $Harga,
					'detail_hpp'			=> $HPP,
					'detail_disc'			=> $Diskon,
					'detail_disc_nominal'	=> $DiscRp,
					'detail_total'			=> $SubTotal,					
			   		'detail_date_update' 	=> date('Y-m-d'),
			   		'detail_time_update' 	=> date('Y-m-d H:i:s')
			);
			$this->db->insert('clinic_jual_detail', $data);			
		}		
		
		// Update Total Resep
		$Total 				= $this->resep_model->select_total_resep($jual_id)->row();
		$Total				= $Total->total; // Total Harga Tindakan Pasien			

		$data = array(
			'jual_total'		=> $Total,
		   	'jual_date_update' 	=> date('Y-m-d'),
		   	'jual_time_update' 	=> date('Y-m-d H:i:s'),
		   	'user_username' 	=> trim($this->session->userdata('username'))		   		
		);

		$this->db->where('jual_id', $jual_id);
		$this->db->update('clinic_jual', $data);
						
		// Redirect ke Halaman Adddata BHP
		redirect(site_url('rawat/resep/editresep/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$this->uri->segment(7)));		
	}

	public function updatedataitemedit() {		
		$this->resep_model->update_data_item();
		$this->session->set_flashdata('notification','Data Item Tersimpan.');
		redirect(site_url('rawat/resep/editresep/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$this->uri->segment(7)));
	}

	public function deletedataitemedit($kode) {
		$kode = $this->security->xss_clean($this->uri->segment(8));
		
		if ($kode == null) {
			redirect(site_url('rawat/resep/addresep/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$this->uri->segment(7)));
		} else {
			$this->resep_model->delete_data_item($kode);
			$this->session->set_flashdata('notification','Hapus Item Sukses.');
			redirect(site_url('rawat/resep/editresep/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$this->uri->segment(7)));
		}
	}
}
/* Location: ./application/controller/rawat/Resep.php */
