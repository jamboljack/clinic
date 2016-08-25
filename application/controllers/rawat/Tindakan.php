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
			$data['error']			= false;
			$data['No_RM'] 			= $this->tindakan_model->getkodeunik(); // No. RM
			$data['listPelanggan'] 	= $this->tindakan_model->select_pelanggan()->result();
			$data['listPoliklinik'] = $this->tindakan_model->select_poliklinik()->result();						
			$data['listDokter'] 	= $this->tindakan_model->select_dokter()->result();
			$data['listAsuransi'] 	= $this->tindakan_model->select_asuransi()->result();
			$data['listIdentitas'] 	= $this->tindakan_model->select_identitas()->result();
			$data['listAgama'] 		= $this->tindakan_model->select_agama()->result();
			$data['listStatus'] 	= $this->tindakan_model->select_status()->result();
			$data['listDidik'] 		= $this->tindakan_model->select_pendidikan()->result();
			$data['listKerja'] 		= $this->tindakan_model->select_pekerjaan()->result();
			$data['listDarah'] 		= $this->tindakan_model->select_darah()->result();
			$data['listAlamat'] 	= $this->tindakan_model->select_alamat();
			$this->template_rawat->display('rawat/pendaftaran_baru_view', $data);
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
		} else { // Jika belum, Insert Data Item Baru			
			$data = array(
					'rawat_id'				=> $rawat_id,				
					'produk_id'				=> trim($this->input->post('produk_id')),
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

	public function updatedata() {
		$this->tindakan_model->update_data();
		$this->session->set_flashdata('notification','Update Data Sukses.');
		redirect(site_url('rawat/pendaftaran'));
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
}
/* Location: ./application/controller/rawat/Tindakan.php */
