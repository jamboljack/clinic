<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pendidikan_model extends CI_Model {
	function __construct() {
		parent::__construct();	
	}

	function select_all() {
		$this->db->select('*');
		$this->db->from('clinic_pendidikan');
		$this->db->order_by('pendidikan_id','asc');
		
		return $this->db->get();
	}
	
	function insert_data() {		
		$data = array(
				'pendidikan_name'			=> strtoupper(trim($this->input->post('name'))),
				'pendidikan_name_seo'		=> seo_title($this->input->post('name')),
		   		'pendidikan_date_update' 	=> date('Y-m-d'),
		   		'pendidikan_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->insert('clinic_pendidikan', $data);
	}	

	function update_data() {
		$pendidikan_id     = $this->input->post('id');
		
		$data = array(
				'pendidikan_name'			=> strtoupper(trim($this->input->post('name'))),
				'pendidikan_name_seo'		=> seo_title($this->input->post('name')),
		   		'pendidikan_date_update' 	=> date('Y-m-d'),
		   		'pendidikan_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->where('pendidikan_id', $pendidikan_id);
		$this->db->update('clinic_pendidikan', $data);
	}

	function delete_data($kode) {		
		$this->db->where('pendidikan_id', $kode);
		$this->db->delete('clinic_pendidikan');
	}
}
/* Location: ./application/model/admin/Pendidikan_model.php */