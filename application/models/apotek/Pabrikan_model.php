<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pabrikan_model extends CI_Model {
	function __construct() {
		parent::__construct();	
	}

	function select_all() {
		$this->db->select('*');
		$this->db->from('clinic_pabrikan');
		$this->db->order_by('pabrikan_id','asc');
		
		return $this->db->get();
	}

	function select_provinsi() {
		$this->db->select('*');
		$this->db->from('clinic_provinsi');
		$this->db->order_by('provinsi_name','asc');
		
		return $this->db->get();
	}

	function select_kabupaten() {
		$this->db->select('*');
		$this->db->from('clinic_kab');
		$this->db->order_by('kab_name','asc');
		
		return $this->db->get();
	}
	
	function insert_data() {		
		$data = array(
				'pabrikan_name'			=> strtoupper(trim($this->input->post('name'))),
				'pabrikan_address'		=> trim($this->input->post('address')),
				'provinsi_id'			=> trim($this->input->post('lstProvinsi')),
				'kab_id'				=> trim($this->input->post('lstKabupaten')),
				'pabrikan_phone'		=> trim($this->input->post('phone')),
				'pabrikan_email'		=> trim($this->input->post('email')),
				'pabrikan_contact'		=> trim($this->input->post('contact')),
		   		'pabrikan_date_update' 	=> date('Y-m-d'),
		   		'pabrikan_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->insert('clinic_pabrikan', $data);
	}

	function select_by_id($pabrikan_id) {
		$this->db->select('*');
		$this->db->from('clinic_pabrikan');
		$this->db->where('pabrikan_id', $pabrikan_id);
		
		return $this->db->get();
	}	

	function update_data() {
		$pabrikan_id     = $this->input->post('id');
		
		$data = array(
				'pabrikan_name'			=> strtoupper(trim($this->input->post('name'))),
				'pabrikan_address'		=> trim($this->input->post('address')),
				'provinsi_id'			=> trim($this->input->post('lstProvinsi')),
				'kab_id'				=> trim($this->input->post('lstKabupaten')),
				'pabrikan_phone'		=> trim($this->input->post('phone')),
				'pabrikan_email'		=> trim($this->input->post('email')),
				'pabrikan_contact'		=> trim($this->input->post('contact')),
		   		'pabrikan_date_update' 	=> date('Y-m-d'),
		   		'pabrikan_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->where('pabrikan_id', $pabrikan_id);
		$this->db->update('clinic_pabrikan', $data);
	}

	function delete_data($kode) {		
		$this->db->where('pabrikan_id', $kode);
		$this->db->delete('clinic_pabrikan');
	}
}
/* Location: ./application/model/apotek/Pabrikan_model.php */