<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kasir extends CI_Controller {
	function __construct() {
		parent::__construct();
		if(!$this->session->userdata('logged_in_clinic')) redirect(base_url());
		$this->load->library('template_rawat');
		$this->load->model('rawat/kasir_model');
	}

	public function index()
	{
		if($this->session->userdata('logged_in_clinic'))
		{			
			$data['listPasien'] 	= $this->kasir_model->select_all()->result();
			$this->template_rawat->display('rawat/kasir_view', $data);
		} else {
			$this->session->sess_destroy();
			redirect(base_url());
		}
	}

	public function id()
	{
		$pasien_id 					= $this->uri->segment(4);
		$data['Kwitansi'] 			= $this->kasir_model->getKwitansi();
		$totaltindakanopen			= $this->kasir_model->select_total_tindakan_open($pasien_id)->row(); // Total Tindakan Belum Dibayar
		$Total_A 					= $totaltindakanopen->total;
		$data['TotalA']				= $Total_A;
		$totalresepopen				= $this->kasir_model->select_total_resep_open($pasien_id)->row(); // Total Resep Belum Dibayar
		$Total_B 					= $totalresepopen->total;
		$data['TotalB']				= $Total_B;
		$totaltindakanclose			= $this->kasir_model->select_total_tindakan_close($pasien_id)->row(); // Total Tindakan Belum Dibayar
		$Total_AC 					= $totaltindakanclose->total;
		$data['TotalAC']				= $Total_AC;
		$totalresepclose			= $this->kasir_model->select_total_resep_close($pasien_id)->row(); // Total Resep Belum Dibayar
		$Total_BC 					= $totalresepclose->total;
		$data['TotalBC']				= $Total_BC;

		$data['DiBayar']			= ($Total_AC+$Total_BC);
		$data['GrandTotal']			= (($Total_A+$Total_B)+($Total_AC+$Total_BC));
		$data['Sisa']				= (($Total_A+$Total_B)-($Total_AC+$Total_BC));

		$data['detail']				= $this->kasir_model->select_pasien($pasien_id)->row(); // Data Pasien
		$data['listTindakan']		= $this->kasir_model->select_tindakan($pasien_id)->result(); // Daftar Tindakan Pasien 
		$data['listResep']			= $this->kasir_model->select_resep($pasien_id)->result(); // Daftar Resep Pasien

		$this->template_rawat->display('rawat/kasir_detail_view', $data);
	}

	public function pembayaran() {
		$pasien_id 		= $this->uri->segment(4);
		$jenisbayar 	= $this->input->post('lstJenisBayar');
		$Kwitansi 		= $this->kasir_model->getKwitansi();
		// Update Semua Tindakan
		$listTindakan	= $this->kasir_model->select_tindakan_open($pasien_id)->result(); // Daftar Tindakan Pasien Open 
		foreach($listTindakan as $t) {
			$rawat_id = $t->rawat_id;
			$total    = $t->rawat_total;

			// Update Tindakan dengan No. Kwitansi dan Jenis Bayar
			if ($jenisbayar == 'Cash') {
				$data = array(
						'rawat_no_kwitansi'	=> $Kwitansi,
						'rawat_debet' 		=> $total,
						'rawat_jns_bayar' 	=> $jenisbayar,
						'rawat_tgl_bayar' 	=> date('Y-m-d'),
						'rawat_st_bayar' 	=> 'Close',
						'rawat_date_update' => date('Y-m-d'),
		   				'rawat_time_update' => date('Y-m-d H:i:s'),
		   				'user_username' 	=> trim($this->session->userdata('username'))
					);
			} else {
				$data = array(
						'rawat_no_kwitansi'	=> $Kwitansi,
						'rawat_kredit' 		=> $total,
						'rawat_jns_bayar' 	=> $jenisbayar,
						'rawat_tgl_bayar' 	=> date('Y-m-d'),
						'rawat_st_bayar' 	=> 'Close',
						'rawat_date_update' => date('Y-m-d'),
		   				'rawat_time_update' => date('Y-m-d H:i:s'),
		   				'user_username' 	=> trim($this->session->userdata('username'))
					);
			}

			$this->db->where('rawat_id', $rawat_id);
			$this->db->update('clinic_rawat', $data);
		}

		// Update Semua Resep
		$listResep	= $this->kasir_model->select_resep_open($pasien_id)->result(); // Daftar Resep Pasien Open 
		foreach($listResep as $r) {
			$jual_id = $r->jual_id;
			$total    = $r->jual_total;

			// Update Tindakan dengan No. Kwitansi dan Jenis Bayar
			if ($jenisbayar == 'Cash') {
				$data = array(
						'jual_no_kwitansi'	=> $Kwitansi,
						'jual_debet' 		=> $total,
						'jual_pay_type' 	=> $jenisbayar,
						'jual_date_bayar' 	=> date('Y-m-d'),
						'jual_st_bayar' 	=> 'Close',
						'jual_date_update' 	=> date('Y-m-d'),
		   				'jual_time_update' 	=> date('Y-m-d H:i:s'),
		   				'user_username' 	=> trim($this->session->userdata('username'))
					);
			} else {
				$data = array(
						'jual_no_kwitansi'	=> $Kwitansi,
						'jual_kredit' 		=> $total,
						'jual_pay_type' 	=> $jenisbayar,
						'jual_date_bayar' 	=> date('Y-m-d'),
						'jual_st_bayar' 	=> 'Close',
						'jual_date_update' 	=> date('Y-m-d'),
		   				'jual_time_update' 	=> date('Y-m-d H:i:s'),
		   				'user_username' 	=> trim($this->session->userdata('username'))
					);
			}

			$this->db->where('jual_id', $jual_id);
			$this->db->update('clinic_jual', $data);
		}
	}

}
/* Location: ./application/controller/rawat/Kasir.php */
