<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CI_Controller{
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('logged_in_semar')) redirect(base_url());
		$this->load->library('template');		
		$this->load->model('admin/about_model');
	}
	
	public function index($menu_id = 1){
		if($this->session->userdata('logged_in_semar')) {
			$data['detail'] 	= $this->about_model->select_menu($menu_id)->row();
			$this->template->display('admin/about_view', $data);
		} else {
			$this->session->sess_destroy();
			redirect(base_url());
		} 
	}
	
	public function updatedata() {
		if (!empty($_FILES['userfile']['name'])) {
			$jam = time();			
				
			$config['file_name']    	= 'About_'.$jam.'.jpg';
			$config['upload_path'] 		= './img/';
			$config['allowed_types'] 	= 'jpg|png|gif|jpeg';		
			$config['overwrite'] 		= TRUE;
			$this->load->library('upload', $config);
			$this->upload->do_upload('userfile');
			$config['image_library'] 	= 'gd2';
			$config['source_image'] 	= $this->upload->upload_path.$this->upload->file_name;
			$config['maintain_ratio'] 	= TRUE;
											
			//$config['width'] 			= 1400;
			$config['height'] 			= 520;
			$this->load->library('image_lib',$config);
				 
			$this->image_lib->resize();
		} elseif (empty($_FILES['userfile']['name'])){
			$config['file_name'] = '';
		}
		
		$this->about_model->update_data();
		$this->session->set_flashdata('notification','Update Data Success.');
 		redirect(site_url().'admin/about');
	}	
}
/* Location: ./application/controllers/admin/About.php */