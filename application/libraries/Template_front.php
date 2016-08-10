<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template_front {	
	protected $_ci;
	function __construct(){
		$this->_ci = &get_instance();
	}
	
	function display($template_front, $data = null) {
		$data['content'] 	= $this->_ci->load->view($template_front, $data,true);
		$data['_header'] 	= $this->_ci->load->view('template_front/header', $data,true);		
		$data['_footer'] 	= $this->_ci->load->view('template_front/footer', $data,true);
		
		$this->_ci->load->view('/template_front.php', $data);
	}
}
/* Location: ./application/libraries/Template_front.php */