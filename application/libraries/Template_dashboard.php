<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template_dashboard {	
	protected $_ci;
	function __construct(){
		$this->_ci = &get_instance();
	}
	
	function display($template_dashboard, $data = null) {		
		$data['content'] = $this->_ci->load->view($template_dashboard, $data,true);
		$data['_header'] = $this->_ci->load->view('template_dashboard/header', $data,true);		
		$data['_footer'] = $this->_ci->load->view('template_dashboard/footer', $data,true);
		
		$this->_ci->load->view('/template_dashboard.php', $data);
	}
}
/* Location: ./application/libraries/Template_dashboard.php */
?>