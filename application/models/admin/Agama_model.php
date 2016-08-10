<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agama_model extends CI_Model {
	function __construct() {
		parent::__construct();	
	}

	function select_all() {
		$this->db->select('*');
		$this->db->from('clinic_agama');
		$this->db->order_by('agama_id','asc');
		
		return $this->db->get();
	}
	
	function insert_data() {		
		$data = array(
				'agama_name'			=> strtoupper(trim($this->input->post('name'))),
				'agama_name_seo'		=> seo_title($this->input->post('name')),
		   		'agama_date_update' 	=> date('Y-m-d'),
		   		'agama_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->insert('clinic_agama', $data);
	}	

	function update_data() {
		$agama_id     = $this->input->post('id');
		
		$data = array(
				'agama_name'			=> strtoupper(trim($this->input->post('name'))),
				'agama_name_seo'		=> seo_title($this->input->post('name')),
		   		'agama_date_update' 	=> date('Y-m-d'),
		   		'agama_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->where('agama_id', $agama_id);
		$this->db->update('clinic_agama', $data);
	}

	function delete_data($kode) {		
		$this->db->where('agama_id', $kode);
		$this->db->delete('clinic_agama');
	}
}
/* Location: ./application/model/admin/Agama_model.php */