<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kelompok_model extends CI_Model {
	function __construct() {
		parent::__construct();	
	}

	function select_all() {
		$this->db->select('k.*, j.jenis_name');
		$this->db->from('clinic_kelompok k');
		$this->db->join('clinic_jenis_tarif j', 'k.jenis_id=j.jenis_id');
		$this->db->order_by('k.kelompok_id','asc');
		
		return $this->db->get();
	}

	function select_jenis_tarif() {
		$this->db->select('*');
		$this->db->from('clinic_jenis_tarif');
		$this->db->order_by('jenis_id','asc');
		
		return $this->db->get();
	}
	
	function insert_data() {		
		$data = array(
				'kelompok_name'			=> strtoupper(trim($this->input->post('name'))),
				'kelompok_name_seo'		=> seo_title($this->input->post('name')),
				'jenis_id'				=> $this->input->post('lstJenisTarif'),
				'kelompok_hrg_obat'		=> $this->input->post('lstHargaObat'),
		   		'kelompok_date_update' 	=> date('Y-m-d'),
		   		'kelompok_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->insert('clinic_kelompok', $data);
	}	

	function update_data() {
		$kelompok_id     = $this->input->post('id');
		
		$data = array(
				'kelompok_name'			=> strtoupper(trim($this->input->post('name'))),
				'kelompok_name_seo'		=> seo_title($this->input->post('name')),
				'jenis_id'				=> $this->input->post('lstJenisTarif'),
				'kelompok_hrg_obat'		=> $this->input->post('lstHargaObat'),
		   		'kelompok_date_update' 	=> date('Y-m-d'),
		   		'kelompok_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->where('kelompok_id', $kelompok_id);
		$this->db->update('clinic_kelompok', $data);
	}

	function delete_data($kode) {		
		$this->db->where('kelompok_id', $kode);
		$this->db->delete('clinic_kelompok');
	}
}
/* Location: ./application/model/admin/Kelompok_model.php */