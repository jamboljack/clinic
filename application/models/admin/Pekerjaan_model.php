<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pekerjaan_model extends CI_Model {
	function __construct() {
		parent::__construct();	
	}

	function select_all() {
		$this->db->select('*');
		$this->db->from('clinic_pekerjaan');
		$this->db->order_by('pekerjaan_id','asc');
		
		return $this->db->get();
	}
	
	function insert_data() {		
		$data = array(
				'pekerjaan_name'			=> strtoupper(trim($this->input->post('name'))),
				'pekerjaan_name_seo'		=> seo_title($this->input->post('name')),
		   		'pekerjaan_date_update' 	=> date('Y-m-d'),
		   		'pekerjaan_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->insert('clinic_pekerjaan', $data);
	}	

	function update_data() {
		$pekerjaan_id     = $this->input->post('id');
		
		$data = array(
				'pekerjaan_name'			=> strtoupper(trim($this->input->post('name'))),
				'pekerjaan_name_seo'		=> seo_title($this->input->post('name')),
		   		'pekerjaan_date_update' 	=> date('Y-m-d'),
		   		'pekerjaan_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->where('pekerjaan_id', $pekerjaan_id);
		$this->db->update('clinic_pekerjaan', $data);
	}

	function delete_data($kode) {		
		$this->db->where('pekerjaan_id', $kode);
		$this->db->delete('clinic_pekerjaan');
	}
}
/* Location: ./application/model/admin/Pekerjaan_model.php */