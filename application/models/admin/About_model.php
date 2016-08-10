<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About_model extends CI_Model {
	
	function __construct() {
		parent::__construct();	
	}
	
	function select_menu($menu_id) {
		$this->db->select('*');
		$this->db->from('furn_menu');
		$this->db->where('menu_id', $menu_id);
		
		return $this->db->get();
	}

	function update_data($menu_id = 1) {	
		if (!empty($_FILES['userfile']['name'])) {
			$data = array(
				'menu_desc' 		=> trim($this->input->post('desc')),
				'menu_image' 		=> $this->upload->file_name,
				'menu_date_update' 	=> date('Y-m-d'),
	    		'menu_time_update' 	=> date('Y-m-d H:i:s')
			);
		} else {
			$data = array(
				'menu_desc' 		=> trim($this->input->post('desc')),				
				'menu_date_update' 	=> date('Y-m-d'),
	    		'menu_time_update' 	=> date('Y-m-d H:i:s')
	    	);
		}		

		$this->db->where('menu_id', $menu_id);
		$this->db->update('furn_menu', $data);
	}	
}
/* Location: ./application/model/admin/About_model.php */