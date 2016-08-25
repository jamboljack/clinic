<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template_rawat {	
	protected $_ci;
	function __construct(){
		$this->_ci = &get_instance();
	}
	
	function display($template_rawat, $data = null) {		
		$data['content'] 	= $this->_ci->load->view($template_rawat, $data,true);
		$data['_header'] 	= $this->_ci->load->view('template_rawat/header', $data,true);
		$data['_sidebar'] 	= $this->_ci->load->view('template_rawat/sidebar', $data,true);
		$data['_footer'] 	= $this->_ci->load->view('template_rawat/footer', $data,true);
		
		$this->_ci->load->view('/template_rawat.php', $data);
	}
}
/* Location: ./application/libraries/Template_rawat.php */