<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Suplier_model extends CI_Model {
	function __construct() {
		parent::__construct();	
	}

	function select_all() {
		$this->db->select('*');
		$this->db->from('clinic_suplier');
		$this->db->order_by('suplier_id','asc');
		
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
				'suplier_name'			=> strtoupper(trim($this->input->post('name'))),
				'suplier_address'		=> trim($this->input->post('address')),
				'provinsi_id'			=> trim($this->input->post('lstProvinsi')),
				'kab_id'				=> trim($this->input->post('lstKabupaten')),
				'suplier_city'			=> strtoupper(trim($this->input->post('city'))),
				'suplier_zipcode'		=> trim($this->input->post('zipcode')),
				'suplier_phone'			=> trim($this->input->post('phone')),
				'suplier_fax'			=> trim($this->input->post('fax')),
				'suplier_email'			=> trim($this->input->post('email')),
				'suplier_contact'		=> trim($this->input->post('contact')),
				'suplier_npwp'			=> trim($this->input->post('npwp')),
				'suplier_termin'		=> $this->input->post('termin'),
				'suplier_limit'			=> $this->input->post('limit'),
				'suplier_saldo_awal'	=> $this->input->post('saldo'),
		   		'suplier_date_update' 	=> date('Y-m-d'),
		   		'suplier_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->insert('clinic_suplier', $data);
	}

	function select_by_id($suplier_id) {
		$this->db->select('*');
		$this->db->from('clinic_suplier');
		$this->db->where('suplier_id', $suplier_id);
		
		return $this->db->get();
	}	

	function update_data() {
		$suplier_id     = $this->input->post('id');
		
		$data = array(
				'suplier_name'			=> strtoupper(trim($this->input->post('name'))),
				'suplier_address'		=> trim($this->input->post('address')),
				'provinsi_id'			=> trim($this->input->post('lstProvinsi')),
				'kab_id'				=> trim($this->input->post('lstKabupaten')),
				'suplier_city'			=> strtoupper(trim($this->input->post('city'))),
				'suplier_zipcode'		=> trim($this->input->post('zipcode')),
				'suplier_phone'			=> trim($this->input->post('phone')),
				'suplier_fax'			=> trim($this->input->post('fax')),
				'suplier_email'			=> trim($this->input->post('email')),
				'suplier_contact'		=> trim($this->input->post('contact')),
				'suplier_npwp'			=> trim($this->input->post('npwp')),
				'suplier_termin'		=> $this->input->post('termin'),
				'suplier_limit'			=> $this->input->post('limit'),
				'suplier_saldo_awal'	=> $this->input->post('saldo'),
		   		'suplier_date_update' 	=> date('Y-m-d'),
		   		'suplier_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->where('suplier_id', $suplier_id);
		$this->db->update('clinic_suplier', $data);
	}

	function delete_data($kode) {		
		$this->db->where('suplier_id', $kode);
		$this->db->delete('clinic_suplier');
	}
}
/* Location: ./application/model/apotek/Suplier_model.php */