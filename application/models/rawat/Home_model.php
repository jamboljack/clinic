<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model {
	function __construct() {
		parent::__construct();	
	}

	function select_count_pasien() {
		$this->db->select('*');
		$this->db->from('clinic_pasien');		
		
		return $this->db->get();
	}

	function select_count_produk() {
		$this->db->select('*');
		$this->db->from('clinic_produk');		
		
		return $this->db->get();
	}

	function select_count_dokter() {
		$this->db->select('*');
		$this->db->from('clinic_dokter');		
		
		return $this->db->get();
	}

	function select_count_perawat() {
		$this->db->select('*');
		$this->db->from('clinic_perawat');		
		
		return $this->db->get();
	}
}
/* Location: ./application/model/apotek/Home_model.php */