<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template_apotek {	
	protected $_ci;
	function __construct(){
		$this->_ci = &get_instance();
	}
	
	function display($template_apotek, $data = null) {		
		$data['content'] 	= $this->_ci->load->view($template_apotek, $data,true);
		$data['_header'] 	= $this->_ci->load->view('template_apotek/header', $data,true);
		$data['_sidebar'] 	= $this->_ci->load->view('template_apotek/sidebar', $data,true);
		$data['_footer'] 	= $this->_ci->load->view('template_apotek/footer', $data,true);
		
		$this->_ci->load->view('/template_apotek.php', $data);
	}
}
/* Location: ./application/libraries/Template_apotek.php */