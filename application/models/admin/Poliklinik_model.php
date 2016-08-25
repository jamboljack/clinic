<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Poliklinik_model extends CI_Model {
	function __construct() {
		parent::__construct();	
	}

	function select_all() {
		$this->db->select('*');
		$this->db->from('clinic_poliklinik');
		$this->db->order_by('poliklinik_id','asc');
		
		return $this->db->get();
	}
	
	function insert_data() {		
		$data = array(
				'poliklinik_name'			=> strtoupper(trim($this->input->post('name'))),
				'poliklinik_name_seo'		=> seo_title($this->input->post('name')),
		   		'poliklinik_date_update' 	=> date('Y-m-d'),
		   		'poliklinik_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->insert('clinic_poliklinik', $data);
	}	

	function update_data() {
		$poliklinik_id     = $this->input->post('id');
		
		$data = array(
				'poliklinik_name'			=> strtoupper(trim($this->input->post('name'))),
				'poliklinik_name_seo'		=> seo_title($this->input->post('name')),
		   		'poliklinik_date_update' 	=> date('Y-m-d'),
		   		'poliklinik_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->where('poliklinik_id', $poliklinik_id);
		$this->db->update('clinic_poliklinik', $data);
	}

	function delete_data($kode) {		
		$this->db->where('poliklinik_id', $kode);
		$this->db->delete('clinic_poliklinik');
	}
}
/* Location: ./application/model/admin/Poliklinik_model.php */