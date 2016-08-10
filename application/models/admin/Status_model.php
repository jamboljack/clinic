<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Status_model extends CI_Model {
	function __construct() {
		parent::__construct();	
	}

	function select_all() {
		$this->db->select('*');
		$this->db->from('clinic_status');
		$this->db->order_by('status_id','asc');
		
		return $this->db->get();
	}
	
	function insert_data() {		
		$data = array(
				'status_name'			=> strtoupper(trim($this->input->post('name'))),
				'status_name_seo'		=> seo_title($this->input->post('name')),
		   		'status_date_update' 	=> date('Y-m-d'),
		   		'status_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->insert('clinic_status', $data);
	}	

	function update_data() {
		$status_id     = $this->input->post('id');
		
		$data = array(
				'status_name'			=> strtoupper(trim($this->input->post('name'))),
				'status_name_seo'		=> seo_title($this->input->post('name')),
		   		'status_date_update' 	=> date('Y-m-d'),
		   		'status_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->where('status_id', $status_id);
		$this->db->update('clinic_status', $data);
	}

	function delete_data($kode) {		
		$this->db->where('status_id', $kode);
		$this->db->delete('clinic_status');
	}
}
/* Location: ./application/model/admin/Status_model.php */