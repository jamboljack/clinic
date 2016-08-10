<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gol_obat_model extends CI_Model {
	function __construct() {
		parent::__construct();	
	}

	function select_all() {
		$this->db->select('*');
		$this->db->from('clinic_gol_obat');
		$this->db->order_by('gol_id','asc');
		
		return $this->db->get();
	}
	
	function insert_data() {		
		$data = array(
				'gol_name'			=> strtoupper(trim($this->input->post('name'))),
				'gol_name_seo'		=> seo_title($this->input->post('name')),
		   		'gol_date_update' 	=> date('Y-m-d'),
		   		'gol_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->insert('clinic_gol_obat', $data);
	}	

	function update_data() {
		$gol_id     = $this->input->post('id');
		
		$data = array(
				'gol_name'			=> strtoupper(trim($this->input->post('name'))),
				'gol_name_seo'		=> seo_title($this->input->post('name')),
		   		'gol_date_update' 	=> date('Y-m-d'),
		   		'gol_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->where('gol_id', $gol_id);
		$this->db->update('clinic_gol_obat', $data);
	}

	function delete_data($kode) {		
		$this->db->where('gol_id', $kode);
		$this->db->delete('clinic_gol_obat');
	}
}
/* Location: ./application/model/apotek/Gol_obat_model.php */