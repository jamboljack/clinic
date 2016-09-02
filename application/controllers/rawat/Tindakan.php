<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tindakan extends CI_Controller {
	function __construct() {
		parent::__construct();
		if(!$this->session->userdata('logged_in_clinic')) redirect(base_url());
		$this->load->library('template_rawat');
		$this->load->model('rawat/tindakan_model');
	}

	public function index()
	{
		if($this->session->userdata('logged_in_clinic'))
		{			
			$data['listPasien'] 	= $this->tindakan_model->select_all()->result();
			$this->template_rawat->display('rawat/tindakan_view', $data);
		} else {
			$this->session->sess_destroy();
			redirect(base_url());
		}
	}
	
	public function id($rawat_id) {
		$rawat_id 				= $this->uri->segment(4);
		$jenis_tarif 			= $this->uri->segment(5);
		$data['detail_pasien'] 	= $this->tindakan_model->select_detail_pasien($rawat_id)->row();		
		$data['listProduk'] 	= $this->tindakan_model->select_produk($jenis_tarif)->result();
		$data['listTindakan'] 	= $this->tindakan_model->select_list_tindakan($rawat_id)->result();
		$data['listDokter'] 	= $this->tindakan_model->select_dokter()->result();
		$Total 					= $this->tindakan_model->select_total($rawat_id)->row();
		$data['Total']			= $Total->total; // Total Harga Tindakan Pasien
		$this->template_rawat->display('rawat/tindakan_rawat_view', $data);
	}

	public function savedataitem() {
		$rawat_id			= $this->uri->segment(4);
		// Insert Item
		// Cek jika ada Item yang Sama dimasukkan
		// Variabel Produk
		$CodeProduk	= trim($this->input->post('produk_id'));
		// Konversi String ke Integer
		$Qty 		= $this->input->post('produk_qty');
		$Harga 		= intval(str_replace(",", "", $this->input->post('produk_harga')));		
		$SubTotal 	= intval(str_replace(",", "", $this->input->post('produk_subtotal')));		
		// Cek Item		
		$CekItem  	= $this->tindakan_model->check_item($CodeProduk)->row();
		if (count($CekItem) > 0) { // Jika Ada, Maka Update Item
			$QtyL 		= $CekItem->detail_qty;
			$SubTotalL	= $CekItem->detail_total;			

			$data = array(
					'detail_date' 			=> date('Y-m-d'),
					'detail_qty'			=> ($QtyL + $Qty),					
					'detail_total'			=> ($SubTotalL + $SubTotal),
					'user_username' 		=> trim($this->session->userdata('username')),					
			   		'detail_date_update' 	=> date('Y-m-d'),
			   		'detail_time_update' 	=> date('Y-m-d H:i:s')
			);

			$this->db->where('produk_id', $CodeProduk);
			$this->db->where('rawat_id', $rawat_id);
			$this->db->update('clinic_rawat_detail', $data);

			// Update ke Komponen
			$js_tempat 	= $CekItem->js_tempat;
			$js_dokter 	= $CekItem->js_dokter;
			$js_perawat = $CekItem->js_perawat;
			$js_lain 	= $CekItem->js_lain;			
			
			$data = array(
					'js_tempat'				=> ($js_tempat + $this->input->post('total_jasa_tempat')),
					'js_dokter'				=> ($js_dokter + $this->input->post('total_jasa_dokter')),
					'js_perawat'			=> ($js_perawat + $this->input->post('total_jasa_perawat')),
					'js_lain'				=> ($js_lain + $this->input->post('total_jasa_lain'))
			);
			
			$this->db->where('produk_id', $CodeProduk);
			$this->db->where('rawat_id', $rawat_id);
			$this->db->update('clinic_komponen', $data);

			// Update ke Jasa Dokter			
			if ($this->input->post('total_jasa_dokter') <> 0) {				
				$dokter_id 	= trim($this->input->post('dokter_id'));
				$CekJasa  	= $this->tindakan_model->check_jasa_dokter($CodeProduk)->row(); // Cek Jasa Dokter Lama

				if (count($CekJasa) > 0) {
					$Qty_jasa	= $CekJasa->qty;
					$Total_jasa = $CekJasa->total;

					$data = array(
							'qty'				=> ($Qty_jasa + $Qty),
							'total'				=> ($Total_jasa + $this->input->post('total_jasa_dokter'))
					);

					$this->db->where('produk_id', $CodeProduk);
					$this->db->where('dokter_id', $dokter_id);
					$this->db->where('rawat_id', $rawat_id);
					$this->db->update('clinic_jasa_dokter', $data);
				}
			}
		} else { // Jika belum, Insert Data Item Baru			
			$data = array(
					'rawat_id'				=> $rawat_id,				
					'produk_id'				=> trim($this->input->post('produk_id')),
					'detail_date' 			=> date('Y-m-d'),
					'dokter_id'				=> trim($this->input->post('dokter_id')),
					'detail_name'			=> trim($this->input->post('produk_name')),
					'detail_qty'			=> $this->input->post('produk_qty'),					
					'detail_harga'			=> $Harga,					
					'detail_total'			=> $SubTotal,
					'user_username' 		=> trim($this->session->userdata('username')),
			   		'detail_date_update' 	=> date('Y-m-d'),
			   		'detail_time_update' 	=> date('Y-m-d H:i:s')
			);
			
			$this->db->insert('clinic_rawat_detail', $data);

			// Insert ke Komponen Detail
			$data = array(
					'rawat_id'				=> $rawat_id,				
					'produk_id'				=> trim($this->input->post('produk_id')),					
					'js_tempat'				=> $this->input->post('total_jasa_tempat'),
					'js_dokter'				=> $this->input->post('total_jasa_dokter'),
					'js_perawat'			=> $this->input->post('total_jasa_perawat'),
					'js_lain'				=> $this->input->post('total_jasa_lain')
			);
						
			$this->db->insert('clinic_komponen', $data);

			// Insert ke Jasa Dokter
			if ($this->input->post('total_jasa_dokter') <> 0) {				
				$data = array(
						'rawat_id'			=> $rawat_id,				
						'produk_id'			=> trim($this->input->post('produk_id')),
						'dokter_id'			=> trim($this->input->post('dokter_id')),
						'qty'				=> $Qty,
						'total'				=> $this->input->post('total_jasa_dokter')
				);

				$this->db->insert('clinic_jasa_dokter', $data);
			}
		}

		// Update Total Tindakan
		$Total 		= $this->tindakan_model->select_total($rawat_id)->row();
		$Total		= $Total->total; // Total Harga Tindakan Pasien		

		$data = array(
			'rawat_total'			=> $Total,			
		   	'rawat_date_update' 	=> date('Y-m-d'),
		   	'rawat_time_update' 	=> date('Y-m-d H:i:s'),
		   	'user_username' 		=> trim($this->session->userdata('username'))
		);

		$this->db->where('rawat_id', $rawat_id);
		$this->db->update('clinic_rawat', $data);		

		// Redirect ke Halaman Transaksi
		redirect(site_url('rawat/tindakan/id/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6)));
	}

	public function updatedataitem() {		
		$this->tindakan_model->update_data_item();
		$this->session->set_flashdata('notification','Data Item Tersimpan.');
		redirect(site_url('rawat/tindakan/id/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6)));
	}

	public function updatedata() {
		$this->tindakan_model->update_data();
		$this->session->set_flashdata('notification','Simpan Billing Sukses.');
		redirect(site_url('rawat/tindakan/id/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6)));
	}

	public function pembayaran() {
		$this->tindakan_model->pembayaran_data();
		$this->session->set_flashdata('notification','Pembayaran Billing Sukses.');
		redirect(site_url('rawat/tindakan/id/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6)));
	}

	public function deletedata($kode) {
		$kode = $this->security->xss_clean($this->uri->segment(4));

		if ($kode == null) {
			redirect(site_url('rawat/pendaftaran'));
		} else {
			$this->tindakan_model->delete_data($kode);
			$this->session->set_flashdata('notification','Hapus Data Sukses.');
			echo "<meta http-equiv=refresh content=0;url=\"".site_url()."rawat/pendaftaran\">";
		}
	}

	public function deletedataitem($kode) {
		$kode = $this->security->xss_clean($this->uri->segment(7));
		
		if ($kode == null) {
			redirect(site_url('rawat/tindakan/id/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6)));
		} else {
			$this->tindakan_model->delete_data_item($kode);
			$this->session->set_flashdata('notification','Hapus Item Sukses.');
			redirect(site_url('rawat/tindakan/id/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6)));
		}
	}

	public function deletedataitemalkes($kode) {
		$kode = $this->security->xss_clean($this->uri->segment(7));
		
		if ($kode == null) {
			redirect(site_url('rawat/tindakan/id/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6)));
		} else {
			$this->tindakan_model->delete_data_item_alkes($kode);
			$this->session->set_flashdata('notification','Hapus Item Sukses.');
			redirect(site_url('rawat/tindakan/id/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6)));
		}
	}

	public function addbhp($rawat_id) {		
		$rawat_id 				= $this->uri->segment(4);
		$jenis_tarif 			= $this->uri->segment(5);
		$data['detail_pasien'] 	= $this->tindakan_model->select_detail_pasien($rawat_id)->row();
		$data['listDokter'] 	= $this->tindakan_model->select_dokter()->result();

		$jual_id				= $this->uri->segment(7); // ID Jual
		if (empty($jual_id) || $jual_id == '') {
			$data['KodePJ'] 	= $this->tindakan_model->getkodeunikbhp();
			$data['Total']		= 0;
		} else {			
			$CekTrans 			= $this->tindakan_model->check_transaksi($jual_id)->row();
			$data['KodePJ'] 	= $CekTrans->jual_no_faktur;
			$TotalBHP 			= $this->tindakan_model->select_total_bhp($jual_id)->row();
			$data['Total']		= $TotalBHP->total; // Total Harga Tindakan Pasien			
		}
		
		$data['listObat'] 		= $this->tindakan_model->select_obat($jenis_tarif)->result();
		$data['listItem'] 		= $this->tindakan_model->select_item_bhp($jual_id)->result();
		$this->template_rawat->display('rawat/add_bhp_view', $data);
	}

	public function savedatabhp() {
		$rawat_id			= $this->uri->segment(4); // Rawat ID
		$jual_id			= $this->uri->segment(7); // ID Jual		

		if (empty($jual_id) || $jual_id == '') {
			// Insert Baru ke Penjualan
			$CodePJ 		= $this->tindakan_model->getkodeunikbhp(); //Cek lagi jika ada 2 Nota lewat Jaringan
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
		   		'jual_status' 				=> 'BHP'
			);

			$this->db->insert('clinic_jual', $data);
			$id = $this->db->insert_id();

			// Insert ke Rawat Detail
			$data = array(
					'rawat_id'				=> $rawat_id,
					'jual_id'				=> $id,
					'produk_id'				=> 11, // ID Produk Biaya Obat & Alkes 
					'detail_date' 			=> date('Y-m-d'),
					'dokter_id'				=> trim($this->input->post('dokter_id')),
					'detail_name'			=> 'BIAYA OBAT & ALKES',
					'detail_qty'			=> 1,					
					'user_username' 		=> trim($this->session->userdata('username')),
			   		'detail_date_update' 	=> date('Y-m-d'),
			   		'detail_time_update' 	=> date('Y-m-d H:i:s')
			);
			
			$this->db->insert('clinic_rawat_detail', $data);
		} else {
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
		$CekItem  = $this->tindakan_model->check_item_bhp($CodeObat)->row();		
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
		
		// Update Total BHP
		$TotalBHP 		= $this->tindakan_model->select_total_bhp($jual_id)->row();
		$TotalBHP		= $TotalBHP->total; // Total PO

		$data = array(
			'jual_total'		=> $TotalBHP,			
		   	'jual_date_update' 	=> date('Y-m-d'),
		   	'jual_time_update' 	=> date('Y-m-d H:i:s'),
		   	'user_username' 	=> trim($this->session->userdata('username'))		   		
		);

		$this->db->where('jual_id', $id);
		$this->db->update('clinic_jual', $data);
		
		// Update Harga & Total dari BHP di Rawat Detail
		$data = array(
				'detail_harga'			=> $TotalBHP,
				'detail_total'			=> $TotalBHP
		);
		
		$this->db->where('jual_id', $id);
		$this->db->update('clinic_rawat_detail', $data);

		// Update Total Tindakan
		$Total 		= $this->tindakan_model->select_total($rawat_id)->row();
		$Total		= $Total->total; // Total Harga Tindakan Pasien		
		
		$data = array(
			'rawat_total'			=> $Total,			
		   	'rawat_date_update' 	=> date('Y-m-d'),
		   	'rawat_time_update' 	=> date('Y-m-d H:i:s'),
		   	'user_username' 		=> trim($this->session->userdata('username'))
		);

		$this->db->where('rawat_id', $rawat_id);
		$this->db->update('clinic_rawat', $data);		

		// Redirect ke Halaman Adddata BHP
		redirect(site_url('rawat/tindakan/addbhp/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$id));		
	}

	public function editbhp($rawat_id) {		
		$rawat_id 				= $this->uri->segment(4);
		$jenis_tarif 			= $this->uri->segment(5);
		$jual_id				= $this->uri->segment(7); // ID Jual
		$data['detail_pasien'] 	= $this->tindakan_model->select_detail_pasien($rawat_id)->row();		
		$data['listDokter'] 	= $this->tindakan_model->select_dokter()->result();
		$data['detail'] 		= $this->tindakan_model->check_transaksi($jual_id)->row();		
		$TotalBHP 				= $this->tindakan_model->select_total_bhp($jual_id)->row();
		$data['Total']			= $TotalBHP->total; // Total Harga Tindakan Pasien			
		$data['listObat'] 		= $this->tindakan_model->select_obat($jenis_tarif)->result();
		$data['listItem'] 		= $this->tindakan_model->select_item_bhp($jual_id)->result();
		$this->template_rawat->display('rawat/edit_bhp_view', $data);
	}

	public function savedatabhpedit() {
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
		$CekItem  = $this->tindakan_model->check_item_bhp($CodeObat)->row();		
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
		
		// Update Total BHP
		$TotalBHP 		= $this->tindakan_model->select_total_bhp($jual_id)->row();
		$TotalBHP		= $TotalBHP->total; // Total PO

		$data = array(
			'jual_total'		=> $TotalBHP,			
		   	'jual_date_update' 	=> date('Y-m-d'),
		   	'jual_time_update' 	=> date('Y-m-d H:i:s'),
		   	'user_username' 	=> trim($this->session->userdata('username'))		   		
		);

		$this->db->where('jual_id', $jual_id);
		$this->db->update('clinic_jual', $data);
		
		// Update Harga & Total dari BHP di Rawat Detail
		$data = array(
				'detail_harga'			=> $TotalBHP,
				'detail_total'			=> $TotalBHP
		);
		
		$this->db->where('jual_id', $jual_id);
		$this->db->update('clinic_rawat_detail', $data);

		// Update Total Tindakan
		$Total 		= $this->tindakan_model->select_total($rawat_id)->row();
		$Total		= $Total->total; // Total Harga Tindakan Pasien		
		
		$data = array(
			'rawat_total'			=> $Total,			
		   	'rawat_date_update' 	=> date('Y-m-d'),
		   	'rawat_time_update' 	=> date('Y-m-d H:i:s'),
		   	'user_username' 		=> trim($this->session->userdata('username'))
		);

		$this->db->where('rawat_id', $rawat_id);
		$this->db->update('clinic_rawat', $data);		

		// Redirect ke Halaman Adddata BHP
		redirect(site_url('rawat/tindakan/editbhp/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$this->uri->segment(7)));		
	}

	public function updatedataitembhp() {		
		$this->tindakan_model->update_data_item_bhp();
		$this->session->set_flashdata('notification','Data Item Tersimpan.');
		redirect(site_url('rawat/tindakan/addbhp/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$this->uri->segment(7)));
	}

	public function updatedataitembhpedit() {		
		$this->tindakan_model->update_data_item_bhp();
		$this->session->set_flashdata('notification','Data Item Tersimpan.');
		redirect(site_url('rawat/tindakan/editbhp/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$this->uri->segment(7)));
	}

	public function deletedataitembhp($kode) {
		$kode = $this->security->xss_clean($this->uri->segment(8));
		
		if ($kode == null) {
			redirect(site_url('rawat/tindakan/addbhp/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$this->uri->segment(7)));
		} else {
			$this->tindakan_model->delete_data_item_bhp($kode);
			$this->session->set_flashdata('notification','Hapus Item Sukses.');
			redirect(site_url('rawat/tindakan/addbhp/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$this->uri->segment(7)));
		}
	}

	public function deletedataitembhpedit($kode) {
		$kode = $this->security->xss_clean($this->uri->segment(8));
		
		if ($kode == null) {
			redirect(site_url('rawat/tindakan/editbhp/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$this->uri->segment(7)));
		} else {
			$this->tindakan_model->delete_data_item_bhp($kode);
			$this->session->set_flashdata('notification','Hapus Item Sukses.');
			redirect(site_url('rawat/tindakan/editbhp/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$this->uri->segment(7)));
		}
	}
	
	public function updatedatabhp() {		
		$this->tindakan_model->update_data_bhp();
		$this->session->set_flashdata('notification','Data BHP Tersimpan.');
		redirect(site_url('rawat/tindakan/id/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6)));
	}
}
/* Location: ./application/controller/rawat/Tindakan.php */
