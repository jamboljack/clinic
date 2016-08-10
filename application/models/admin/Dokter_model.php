<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dokter_model extends CI_Model {
	function __construct() {
		parent::__construct();	
	}

	function select_all() {
		$this->db->select('d.*, t.tipe_name');
		$this->db->from('clinic_dokter d');
		$this->db->join('clinic_tipe_dokter t', 'd.tipe_id=t.tipe_id');
		$this->db->order_by('d.dokter_id','asc');
		
		return $this->db->get();
	}

	function select_type() {
		$this->db->select('*');
		$this->db->from('clinic_tipe_dokter');
		$this->db->order_by('tipe_id','asc');
		
		return $this->db->get();
	}
	
	function insert_data() {
		$data = array(
				'dokter_name'			=> trim($this->input->post('name')),
				'tipe_id'				=> $this->input->post('lstTipe'),
				'dokter_address'		=> trim($this->input->post('address')),
				'dokter_city'			=> strtoupper(trim($this->input->post('city'))),				
				'dokter_phone'			=> trim($this->input->post('phone')),				
		   		'dokter_date_update' 	=> date('Y-m-d'),
		   		'dokter_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->insert('clinic_dokter', $data);
	}	

	function update_data() {
		$dokter_id     = $this->input->post('id');
		
		$data = array(
				'dokter_name'			=> trim($this->input->post('name')),
				'tipe_id'				=> $this->input->post('lstTipe'),
				'dokter_address'		=> trim($this->input->post('address')),
				'dokter_city'			=> strtoupper(trim($this->input->post('city'))),				
				'dokter_phone'			=> trim($this->input->post('phone')),				
		   		'dokter_date_update' 	=> date('Y-m-d'),
		   		'dokter_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->where('dokter_id', $dokter_id);
		$this->db->update('clinic_dokter', $data);
	}

	function delete_data($kode) {		
		$this->db->where('dokter_id', $kode);
		$this->db->delete('clinic_dokter');
	}
}
/* Location: ./application/model/admin/Dokter_model.php */