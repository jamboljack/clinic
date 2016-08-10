<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Produk_model extends CI_Model {
	function __construct() {
		parent::__construct();	
	}

	function select_all() {
		$this->db->select('p.*, u.unit_name, j.jenis_name');
		$this->db->from('clinic_produk p');
		$this->db->join('clinic_unit u', 'p.unit_id=u.unit_id');
		$this->db->join('clinic_jenis_tarif j', 'p.jenis_id=j.jenis_id');
		$this->db->order_by('p.produk_id','asc');
		
		return $this->db->get();
	}

	function select_jenis() {
		$this->db->select('*');
		$this->db->from('clinic_jenis_tarif');
		$this->db->order_by('jenis_id','asc');
		
		return $this->db->get();
	}

	function select_unit() {
		$this->db->select('*');
		$this->db->from('clinic_unit');
		$this->db->order_by('unit_id','asc');
		
		return $this->db->get();
	}
	
	function insert_data() {
		// Konversi String ke Integer
		$Tempat 	= intval(str_replace(",", "", $this->input->post('js_tempat')));
		$Dokter 	= intval(str_replace(",", "", $this->input->post('js_dokter')));
		$Perawat 	= intval(str_replace(",", "", $this->input->post('js_perawat')));
		$Lain 		= intval(str_replace(",", "", $this->input->post('js_lain')));
		$Harga 		= intval(str_replace(",", "", $this->input->post('harga')));

		$data = array(
				'produk_name'			=> strtoupper(trim($this->input->post('name'))),
				'jenis_id'				=> trim($this->input->post('lstJenis')),
				'unit_id'				=> trim($this->input->post('lstUnit')),
				'produk_js_tempat'		=> $Tempat,
				'produk_js_dokter'		=> $Dokter,
				'produk_js_perawat'		=> $Perawat,
				'produk_js_lain'		=> $Lain,
				'produk_total'			=> $Harga,
		   		'produk_date_update' 	=> date('Y-m-d'),
		   		'produk_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->insert('clinic_produk', $data);
	}

	function select_by_id($produk_id) {
		$this->db->select('*');
		$this->db->from('clinic_produk');
		$this->db->where('produk_id', $produk_id);
		
		return $this->db->get();
	}

	function update_data() {
		$produk_id  = $this->input->post('id');
		// Konversi String ke Integer
		$Tempat 	= intval(str_replace(",", "", $this->input->post('js_tempat')));
		$Dokter 	= intval(str_replace(",", "", $this->input->post('js_dokter')));
		$Perawat 	= intval(str_replace(",", "", $this->input->post('js_perawat')));
		$Lain 		= intval(str_replace(",", "", $this->input->post('js_lain')));
		$Harga 		= intval(str_replace(",", "", $this->input->post('harga')));
		
		$data = array(
				'produk_name'			=> strtoupper(trim($this->input->post('name'))),
				'jenis_id'				=> trim($this->input->post('lstJenis')),
				'unit_id'				=> trim($this->input->post('lstUnit')),
				'produk_js_tempat'		=> $Tempat,
				'produk_js_dokter'		=> $Dokter,
				'produk_js_perawat'		=> $Perawat,
				'produk_js_lain'		=> $Lain,
				'produk_total'			=> $Harga,
		   		'produk_date_update' 	=> date('Y-m-d'),
		   		'produk_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->where('produk_id', $produk_id);
		$this->db->update('clinic_produk', $data);
	}

	function delete_data($kode) {		
		$this->db->where('produk_id', $kode);
		$this->db->delete('clinic_produk');
	}
}
/* Location: ./application/model/admin/Produk_model.php */