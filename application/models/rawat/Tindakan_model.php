<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tindakan_model extends CI_Model {
	function __construct() {
		parent::__construct();	
	}	
	
	function select_total($rawat_id) {
		$this->db->select('SUM(detail_total) as total');
		$this->db->from('clinic_rawat_detail');
		$this->db->where('rawat_id', $rawat_id);		
		
		return $this->db->get();
	}

	function select_produk($jenis_tarif) {
		$this->db->select('p.*, u.unit_name');
		$this->db->from('clinic_produk p');
		$this->db->join('clinic_unit u', 'p.unit_id = u.unit_id');
		$this->db->where('p.jenis_id', $jenis_tarif);
		$this->db->order_by('u.unit_id', 'asc');
		
		return $this->db->get();
	}

	function select_detail_pasien($rawat_id) {
		$this->db->select('r.*, p.pasien_no_rm, p.pasien_nama, p.pasien_alamat, d.dokter_name,
						j.jenis_name, k.kelompok_name, l.pelanggan_name, n.poliklinik_name');
		$this->db->from('clinic_rawat r');
		$this->db->join('clinic_pasien p', 'r.pasien_id = p.pasien_id');
		$this->db->join('clinic_dokter d', 'r.dokter_id = d.dokter_id');
		$this->db->join('clinic_poliklinik n', 'r.poliklinik_id = n.poliklinik_id');
		$this->db->join('clinic_pelanggan l', 'r.pelanggan_id = l.pelanggan_id');
		$this->db->join('clinic_kelompok k', 'l.kelompok_id = k.kelompok_id');
		$this->db->join('clinic_jenis_tarif j', 'k.jenis_id = j.jenis_id');
		$this->db->where('r.rawat_id', $rawat_id);
		
		return $this->db->get();
	}	

	function select_list_tindakan($rawat_id) {
		$this->db->select('*');
		$this->db->from('clinic_rawat_detail');		
		$this->db->where('rawat_id', $rawat_id);
		
		return $this->db->get();
	}

	function check_item($CodeProduk) {
		$rawat_id	= $this->uri->segment(4);

		$this->db->select('d.*, k.js_tempat, k.js_dokter, k.js_perawat, k.js_lain');
		$this->db->from('clinic_rawat_detail d');
		$this->db->join('clinic_komponen k', 'k.produk_id=d.produk_id');
		$this->db->where('d.produk_id', $CodeProduk);
		$this->db->where('d.rawat_id', $rawat_id);
		
		return $this->db->get();
	}

	function update_data() {
		$suplier_id     = $this->input->post('id');
		
		$data = array(
				'suplier_name'			=> strtoupper(trim($this->input->post('name'))),
				'suplier_address'		=> trim($this->input->post('address')),
				'provinsi_id'			=> trim($this->input->post('lstProvinsi')),
				'kab_id'				=> trim($this->input->post('lstKabupaten')),
				'suplier_city'			=> strtoupper(trim($this->input->post('city'))),
				'suplier_zipcode'		=> trim($this->input->post('zipcode')),
				'suplier_phone'			=> trim($this->input->post('phone')),
				'suplier_fax'			=> trim($this->input->post('fax')),
				'suplier_email'			=> trim($this->input->post('email')),
				'suplier_contact'		=> trim($this->input->post('contact')),
				'suplier_npwp'			=> trim($this->input->post('npwp')),
				'suplier_termin'		=> $this->input->post('termin'),
				'suplier_limit'			=> $this->input->post('limit'),
				'suplier_saldo_awal'	=> $this->input->post('saldo'),
		   		'suplier_date_update' 	=> date('Y-m-d'),
		   		'suplier_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->where('suplier_id', $suplier_id);
		$this->db->update('clinic_suplier', $data);
	}

	function delete_data($kode) {		
		$this->db->where('suplier_id', $kode);
		$this->db->delete('clinic_suplier');
	}
}
/* Location: ./application/model/rawat/Tindakan_model.php */