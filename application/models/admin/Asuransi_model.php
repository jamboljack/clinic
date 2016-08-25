<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Asuransi_model extends CI_Model {
	function __construct() {
		parent::__construct();	
	}

	function select_all() {
		$this->db->select('*');
		$this->db->from('clinic_asuransi');
		$this->db->order_by('asuransi_id','asc');
		
		return $this->db->get();
	}
	
	function insert_data() {		
		$data = array(
				'asuransi_name'			=> strtoupper(trim($this->input->post('name'))),
				'asuransi_name_seo'		=> seo_title($this->input->post('name')),
		   		'asuransi_date_update' 	=> date('Y-m-d'),
		   		'asuransi_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->insert('clinic_asuransi', $data);
	}	

	function update_data() {
		$asuransi_id     = $this->input->post('id');
		
		$data = array(
				'asuransi_name'			=> strtoupper(trim($this->input->post('name'))),
				'asuransi_name_seo'		=> seo_title($this->input->post('name')),
		   		'asuransi_date_update' 	=> date('Y-m-d'),
		   		'asuransi_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->where('asuransi_id', $asuransi_id);
		$this->db->update('clinic_asuransi', $data);
	}

	function delete_data($kode) {		
		$this->db->where('asuransi_id', $kode);
		$this->db->delete('clinic_asuransi');
	}
}
/* Location: ./application/model/admin/Asuransi_model.php */