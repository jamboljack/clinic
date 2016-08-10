<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Darah_model extends CI_Model {
	function __construct() {
		parent::__construct();	
	}

	function select_all() {
		$this->db->select('*');
		$this->db->from('clinic_darah');
		$this->db->order_by('darah_id','asc');
		
		return $this->db->get();
	}
	
	function insert_data() {		
		$data = array(
				'darah_name'			=> strtoupper(trim($this->input->post('name'))),
				'darah_name_seo'		=> seo_title($this->input->post('name')),
		   		'darah_date_update' 	=> date('Y-m-d'),
		   		'darah_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->insert('clinic_darah', $data);
	}	

	function update_data() {
		$darah_id     = $this->input->post('id');
		
		$data = array(
				'darah_name'			=> strtoupper(trim($this->input->post('name'))),
				'darah_name_seo'		=> seo_title($this->input->post('name')),
		   		'darah_date_update' 	=> date('Y-m-d'),
		   		'darah_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->where('darah_id', $darah_id);
		$this->db->update('clinic_darah', $data);
	}

	function delete_data($kode) {		
		$this->db->where('darah_id', $kode);
		$this->db->delete('clinic_darah');
	}
}
/* Location: ./application/model/admin/Darah_model.php */