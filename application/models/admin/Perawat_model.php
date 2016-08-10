<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Perawat_model extends CI_Model {
	function __construct() {
		parent::__construct();	
	}

	function select_all() {
		$this->db->select('*');
		$this->db->from('clinic_perawat');		
		$this->db->order_by('perawat_id','asc');
		
		return $this->db->get();
	}

	function insert_data() {
		$data = array(
				'perawat_name'			=> trim($this->input->post('name')),				
				'perawat_address'		=> trim($this->input->post('address')),
				'perawat_city'			=> strtoupper(trim($this->input->post('city'))),				
				'perawat_phone'			=> trim($this->input->post('phone')),				
		   		'perawat_date_update' 	=> date('Y-m-d'),
		   		'perawat_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->insert('clinic_perawat', $data);
	}	

	function update_data() {
		$perawat_id     = $this->input->post('id');
		
		$data = array(
				'perawat_name'			=> trim($this->input->post('name')),				
				'perawat_address'		=> trim($this->input->post('address')),
				'perawat_city'			=> strtoupper(trim($this->input->post('city'))),				
				'perawat_phone'			=> trim($this->input->post('phone')),				
		   		'perawat_date_update' 	=> date('Y-m-d'),
		   		'perawat_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->where('perawat_id', $perawat_id);
		$this->db->update('clinic_perawat', $data);
	}

	function delete_data($kode) {		
		$this->db->where('perawat_id', $kode);
		$this->db->delete('clinic_perawat');
	}
}
/* Location: ./application/model/admin/Perawat_model.php */