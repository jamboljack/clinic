<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Unit_model extends CI_Model {
	function __construct() {
		parent::__construct();	
	}

	function select_all() {
		$this->db->select('u.*, k.k_unit_name');
		$this->db->from('clinic_unit u');
		$this->db->join('clinic_kelompok_unit k', 'u.k_unit_id=k.k_unit_id');
		$this->db->order_by('u.unit_id','asc');
		
		return $this->db->get();
	}

	function select_kelompok_unit() {
		$this->db->select('*');
		$this->db->from('clinic_kelompok_unit');
		$this->db->order_by('k_unit_id','asc');
		
		return $this->db->get();
	}
	
	function insert_data() {		
		$data = array(
				'unit_name'			=> strtoupper(trim($this->input->post('name'))),
				'k_unit_id'			=> trim($this->input->post('lstKelompok')),
		   		'unit_date_update' 	=> date('Y-m-d'),
		   		'unit_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->insert('clinic_unit', $data);
	}	

	function update_data() {
		$unit_id     = $this->input->post('id');
		
		$data = array(
				'unit_name'			=> strtoupper(trim($this->input->post('name'))),
				'k_unit_id'			=> trim($this->input->post('lstKelompok')),
		   		'unit_date_update' 	=> date('Y-m-d'),
		   		'unit_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->where('unit_id', $unit_id);
		$this->db->update('clinic_unit', $data);
	}

	function delete_data($kode) {		
		$this->db->where('unit_id', $kode);
		$this->db->delete('clinic_unit');
	}
}
/* Location: ./application/model/admin/Unit_model.php */