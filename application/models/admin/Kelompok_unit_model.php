<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kelompok_unit_model extends CI_Model {
	function __construct() {
		parent::__construct();	
	}

	function select_all() {
		$this->db->select('*');
		$this->db->from('clinic_kelompok_unit');
		$this->db->order_by('k_unit_id','asc');
		
		return $this->db->get();
	}
	
	function insert_data() {		
		$data = array(
				'k_unit_name'			=> strtoupper(trim($this->input->post('name'))),				
		   		'k_unit_date_update' 	=> date('Y-m-d'),
		   		'k_unit_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->insert('clinic_kelompok_unit', $data);
	}	

	function update_data() {
		$k_unit_id     = $this->input->post('id');
		
		$data = array(
				'k_unit_name'			=> strtoupper(trim($this->input->post('name'))),				
		   		'k_unit_date_update' 	=> date('Y-m-d'),
		   		'k_unit_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->where('k_unit_id', $k_unit_id);
		$this->db->update('clinic_kelompok_unit', $data);
	}

	function delete_data($kode) {		
		$this->db->where('k_unit_id', $kode);
		$this->db->delete('clinic_kelompok_unit');
	}
}
/* Location: ./application/model/admin/Kelompok_unit_model.php */