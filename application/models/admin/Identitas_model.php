<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Identitas_model extends CI_Model {
	function __construct() {
		parent::__construct();	
	}

	function select_all() {
		$this->db->select('*');
		$this->db->from('clinic_identitas');
		$this->db->order_by('identitas_id','asc');
		
		return $this->db->get();
	}
	
	function insert_data() {		
		$data = array(
				'identitas_name'			=> strtoupper(trim($this->input->post('name'))),
				'identitas_name_seo'		=> seo_title($this->input->post('name')),
		   		'identitas_date_update' 	=> date('Y-m-d'),
		   		'identitas_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->insert('clinic_identitas', $data);
	}	

	function update_data() {
		$identitas_id     = $this->input->post('id');
		
		$data = array(
				'identitas_name'			=> strtoupper(trim($this->input->post('name'))),
				'identitas_name_seo'		=> seo_title($this->input->post('name')),
		   		'identitas_date_update' 	=> date('Y-m-d'),
		   		'identitas_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->where('identitas_id', $identitas_id);
		$this->db->update('clinic_identitas', $data);
	}

	function delete_data($kode) {		
		$this->db->where('identitas_id', $kode);
		$this->db->delete('clinic_identitas');
	}
}
/* Location: ./application/model/admin/Identitas_model.php */