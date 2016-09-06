<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pendaftaran extends CI_Controller {
	function __construct() {
		parent::__construct();
		if(!$this->session->userdata('logged_in_clinic')) redirect(base_url());
		$this->load->library('template_rawat');
		$this->load->model('rawat/pendaftaran_model');
	}

	public function index()
	{
		if($this->session->userdata('logged_in_clinic'))
		{
			$data['error']			= false;
			$data['No_RM'] 			= $this->pendaftaran_model->getkodeunik(); // No. RM
			$data['listPelanggan'] 	= $this->pendaftaran_model->select_pelanggan()->result();
			$data['listPoliklinik'] = $this->pendaftaran_model->select_poliklinik()->result();						
			$data['listDokter'] 	= $this->pendaftaran_model->select_dokter()->result();
			$data['listAsuransi'] 	= $this->pendaftaran_model->select_asuransi()->result();
			$data['listIdentitas'] 	= $this->pendaftaran_model->select_identitas()->result();
			$data['listAgama'] 		= $this->pendaftaran_model->select_agama()->result();
			$data['listStatus'] 	= $this->pendaftaran_model->select_status()->result();
			$data['listDidik'] 		= $this->pendaftaran_model->select_pendidikan()->result();
			$data['listKerja'] 		= $this->pendaftaran_model->select_pekerjaan()->result();
			$data['listDarah'] 		= $this->pendaftaran_model->select_darah()->result();
			$data['listAlamat'] 	= $this->pendaftaran_model->select_alamat();
			$this->template_rawat->display('rawat/pendaftaran_baru_view', $data);
		} else {
			$this->session->sess_destroy();
			redirect(base_url());
		}
	}

	public function pasienlama() {
		$data['error']				= false;
		$data['listProvinsi'] 		= $this->pendaftaran_model->select_provinsi()->result();
		$data['listKabupaten'] 		= $this->pendaftaran_model->select_kabupaten()->result();
		$this->template_rawat->display('rawat/pendaftaran_add_view', $data);
	}

	public function savedatabaru() {		
		// Simpan ke Table Pasien
		$No_RM 			= $this->pendaftaran_model->getkodeunik(); // No. RM Jika Pakai Jaringan harus Cek Dahulu
		$Jenis_Tarif	= trim($this->input->post('jenis_id'));

		$tgl_lahir 		= $this->input->post('tgl_lahir');
		$xtgl 			= explode("-",$tgl_lahir);
		$thn 			= $xtgl[2];
		$bln 			= $xtgl[1];
		$tgl 			= $xtgl[0];
		$tanggal_lhr 	= $thn.'-'.$bln.'-'.$tgl;

		$data = array(
				'pasien_no_rm'			=> trim($No_RM),
				'pasien_nama'			=> strtoupper(trim($this->input->post('nama'))),
				'pasien_keluarga'		=> strtoupper(trim($this->input->post('nama_keluarga'))),
				'pasien_jk'				=> trim($this->input->post('lstJK')),
				'pasien_tmpt_lhr'		=> strtoupper(trim($this->input->post('tmpt_lahir'))),
				'pasien_tgl_lhr'		=> $tanggal_lhr,
				'pasien_alamat'			=> trim($this->input->post('alamat')),
				'provinsi_id'			=> $this->input->post('provinsi_id'),
				'kab_id'				=> $this->input->post('kab_id'),
				'kec_id'				=> $this->input->post('kec_id'),
				'desa_id'				=> $this->input->post('desa_id'),
				'pasien_kodepos'		=> trim($this->input->post('kodepos')),
				'pasien_warga'			=> $this->input->post('lstWarga'),
				'pasien_telp'			=> $this->input->post('telp'),
				'kelompok_id'			=> trim($this->input->post('kelompok_id')),
				'pelanggan_id'			=> trim($this->input->post('lstPelanggan')),
				'asuransi_id'			=> trim($this->input->post('lstAsuransi')),
				'pasien_no_asuransi'	=> trim($this->input->post('no_asuransi')),
				'identitas_id'			=> trim($this->input->post('lstIdentitas')),
				'pasien_no_identitas'	=> trim($this->input->post('no_identitas')),
				'jenis_id'				=> trim($this->input->post('jenis_id')),
				'agama_id'				=> $this->input->post('lstAgama'),
				'status_id'				=> $this->input->post('lstStatus'),
				'pendidikan_id'			=> $this->input->post('lstDidik'),
				'pekerjaan_id'			=> $this->input->post('lstKerja'),
				'darah_id'				=> $this->input->post('lstDarah'),
				'pasien_nama_ayah'		=> strtoupper(trim($this->input->post('nm_ayah'))),
				'pasien_nama_ibu'		=> strtoupper(trim($this->input->post('nm_ibu'))),
				'pasien_telp_hubungi'	=> trim($this->input->post('telp_hub')),
				'pasien_tgl_akhir'		=> date('Y-m-d'),
		   		'pasien_date_update' 	=> date('Y-m-d'),
		   		'pasien_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->insert('clinic_pasien', $data);
		$id_pasien = $this->db->insert_id(); // ID Pasien Baru

		$No_Transaksi	= $this->pendaftaran_model->getnotransaksi(); // No. Transaksi Baru
		// Add Baru ke Table Transaksi Rawat		
		$data = array(
				'pasien_id'				=> $id_pasien,
				'rawat_no_trans'		=> $No_Transaksi,
		   		'pelanggan_id' 			=> trim($this->input->post('lstPelanggan')),
		   		'poliklinik_id' 		=> trim($this->input->post('lstPoliklinik')),
		   		'jenis_id' 				=> trim($this->input->post('jenis_id')),
		   		'dokter_id' 			=> trim($this->input->post('lstDokter')),
		   		'rawat_no_kwitansi'		=> '',
		   		'rawat_date' 			=> date('Y-m-d'),
		   		'user_username' 		=> trim($this->session->userdata('username')),
		   		'rawat_date_update' 	=> date('Y-m-d'),
		   		'rawat_time_update' 	=> date('Y-m-d H:i:s')
			);

		$this->db->insert('clinic_rawat', $data);
		$id_rawat = $this->db->insert_id(); // ID Rawat Baru

		// Simpan ke Table Kunjungan
		$data = array(
				'pasien_id'				=> $id_pasien,
				'rawat_id'				=> $id_rawat,
		   		'kunjungan_tgl_masuk' 	=> date('Y-m-d'),
		   		'kunjungan_jam_masuk' 	=> date('Y-m-d'),
		   		'pelanggan_id' 			=> trim($this->input->post('lstPelanggan')),
		   		'poliklinik_id' 		=> trim($this->input->post('lstPoliklinik')),		   		
		   		'dokter_id' 			=> trim($this->input->post('lstDokter')),
		   		'kunjungan_status'		=> 1,
		   		'kunjungan_date_update' => date('Y-m-d'),
		   		'kunjungan_time_update' => date('Y-m-d H:i:s')
			);

		$this->db->insert('clinic_kunjungan', $data);

		$this->session->set_flashdata('notification','Pendaftaran Pasien Baru Sukses.');
	 	redirect(site_url('rawat/tindakan/id/'.$id_rawat.'/'.$Jenis_Tarif.'/'.$No_Transaksi));
	}	
}
/* Location: ./application/controller/rawat/Pendaftaran.php */
