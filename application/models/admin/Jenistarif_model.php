<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jenistarif_model extends CI_Model {
	function __construct() {
		parent::__construct();	
	}

	function select_all() {
		$this->db->select('*');
		$this->db->from('clinic_jenis_tarif');
		$this->db->order_by('jenis_id','asc');
		
		return $this->db->get();
	}
	
	function insert_data() {		
		$data = array(
				'jenis_name'			=> strtoupper(trim($this->input->post('name'))),
				'jenis_name_seo'		=> seo_title($this->input->post('name')),
		   		'jenis_date_update' 	=> date('Y-m-d'),
		   		'jenis_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->insert('clinic_jenis_tarif', $data);
	}	

	function update_data() {
		$jenis_id     = $this->input->post('id');
		
		$data = array(
				'jenis_name'			=> strtoupper(trim($this->input->post('name'))),
				'jenis_name_seo'		=> seo_title($this->input->post('name')),
		   		'jenis_date_update' 	=> date('Y-m-d'),
		   		'jenis_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->where('jenis_id', $jenis_id);
		$this->db->update('clinic_jenis_tarif', $data);
	}

	function delete_data($kode) {		
		$this->db->where('jenis_id', $kode);
		$this->db->delete('clinic_jenis_tarif');
	}
}
/* Location: ./application/model/admin/Jenistarif_model.php */