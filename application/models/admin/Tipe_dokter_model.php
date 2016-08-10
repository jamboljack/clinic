<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tipe_dokter_model extends CI_Model {
	function __construct() {
		parent::__construct();	
	}

	function select_all() {
		$this->db->select('*');
		$this->db->from('clinic_tipe_dokter');
		$this->db->order_by('tipe_id','asc');
		
		return $this->db->get();
	}
	
	function insert_data() {		
		$data = array(
				'tipe_name'			=> strtoupper(trim($this->input->post('name'))),
				'tipe_name_seo'		=> seo_title($this->input->post('name')),
		   		'tipe_date_update' 	=> date('Y-m-d'),
		   		'tipe_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->insert('clinic_tipe_dokter', $data);
	}	

	function update_data() {
		$tipe_id     = $this->input->post('id');
		
		$data = array(
				'tipe_name'			=> strtoupper(trim($this->input->post('name'))),
				'tipe_name_seo'		=> seo_title($this->input->post('name')),
		   		'tipe_date_update' 	=> date('Y-m-d'),
		   		'tipe_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->where('tipe_id', $tipe_id);
		$this->db->update('clinic_tipe_dokter', $data);
	}

	function delete_data($kode) {		
		$this->db->where('tipe_id', $kode);
		$this->db->delete('clinic_tipe_dokter');
	}
}
/* Location: ./application/model/admin/Tipe_dokter.php */