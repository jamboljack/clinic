<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resep_model extends CI_Model {
	function __construct() {
		parent::__construct();	
	}	
	
	function select_all() {
		$this->db->select('j.*, p.pasien_nama, l.poliklinik_name, d.dokter_name');
		$this->db->from('clinic_jual j');
		$this->db->join('clinic_pasien p', 'j.pasien_id=p.pasien_id');		
		$this->db->join('clinic_dokter d', 'j.dokter_id=d.dokter_id');
		$this->db->join('clinic_rawat r', 'j.rawat_id=r.rawat_id', 'left');
		$this->db->join('clinic_poliklinik l', 'r.poliklinik_id=l.poliklinik_id');
		$this->db->where('j.jual_status', 'JUAL'); // Penjualan
		$this->db->where('j.jual_date', date('Y-m-d')); // Hari Ini
		$this->db->order_by('j.jual_id', 'desc');
		
		return $this->db->get();
	}

	function select_pasien() {
		$this->db->select('r.*, p.pasien_nama, l.poliklinik_name, d.dokter_name');
		$this->db->from('clinic_rawat r');
		$this->db->join('clinic_pasien p', 'r.pasien_id=p.pasien_id');
		$this->db->join('clinic_poliklinik l', 'r.poliklinik_id=l.poliklinik_id');
		$this->db->join('clinic_dokter d', 'r.dokter_id=d.dokter_id');
		//$this->db->where('r.rawat_date', date('Y-m-d'));
		$this->db->order_by('r.rawat_id', 'desc');		
		
		return $this->db->get();
	}

	function select_detail_pasien($rawat_id) {
		$this->db->select('r.*, p.pasien_no_rm, p.pasien_nama, p.pasien_alamat, d.dokter_name,
						j.jenis_name, k.kelompok_name, k.kelompok_hrg_obat, 
						l.pelanggan_name, n.poliklinik_name');
		$this->db->from('clinic_rawat r');
		$this->db->join('clinic_pasien p', 'r.pasien_id = p.pasien_id');
		$this->db->join('clinic_dokter d', 'r.dokter_id = d.dokter_id');
		$this->db->join('clinic_poliklinik n', 'r.poliklinik_id = n.poliklinik_id');
		$this->db->join('clinic_pelanggan l', 'r.pelanggan_id = l.pelanggan_id');
		$this->db->join('clinic_kelompok k', 'l.kelompok_id = k.kelompok_id');
		$this->db->join('clinic_jenis_tarif j', 'k.jenis_id = j.jenis_id');
		$this->db->where('r.rawat_id', $rawat_id);
		
		return $this->db->get();
	}

	function getkodeunikresep() {
		$tgl_sekarang = date('Y-m-d');			
		$xtg = explode("-",$tgl_sekarang);
		$thn = $xtg[0];
		$bln = $xtg[1];
		$tgl = $xtg[2];		
				
        $q 	= $this->db->query("SELECT MAX(jual_id) AS idmax FROM clinic_jual");
        $kd = 0;
        if($q->num_rows() > 0)
        {
           	foreach($q->result() as $k)
           	{
                $mkd = ((int)$k->idmax)+1;
            }
        }
        else
        {
            $mkd  = 1;
        }
        
        return 'RJ'.$tgl.'.'.$bln.'.'.$mkd;
   	}
	
	function check_transaksi($jual_id) {
		$this->db->select('*');
		$this->db->from('clinic_jual');
		$this->db->where('jual_id', $jual_id);		
		
		return $this->db->get();
	}

	function select_total_resep($jual_id) {
		$this->db->select('SUM(detail_total) as total');
		$this->db->from('clinic_jual_detail');
		$this->db->where('jual_id', $jual_id);		
		
		return $this->db->get();
	}

	function select_item_resep($jual_id) {
		$this->db->select('d.*, o.obat_stok');
		$this->db->from('clinic_jual_detail d');
		$this->db->join('clinic_obat o', 'd.obat_code=o.obat_code');
		$this->db->where('d.jual_id', $jual_id);
		$this->db->order_by('d.detail_id','asc');
		
		return $this->db->get();
	}

	function select_dokter() {
		$this->db->select('*');
		$this->db->from('clinic_dokter');
		$this->db->order_by('dokter_name', 'asc');		
		
		return $this->db->get();
	}

	function select_obat($jenis_tarif) {
		$this->db->select('obat_code, obat_name, obat_sat_kcl, obat_stok, obat_hpp, obat_hrg_kcl_g, obat_hrg_kcl_e');
		$this->db->from('clinic_obat');
		$this->db->where('obat_st_aktif', 1);
		$this->db->where('obat_st_aktif', 1);
		$this->db->order_by('obat_name','asc');
		
		return $this->db->get();
	}

	function check_item_resep($CodeObat) {
		$jual_id	= $this->uri->segment(7);

		$this->db->select('*');
		$this->db->from('clinic_jual_detail');
		$this->db->where('obat_code', $CodeObat);
		$this->db->where('jual_id', $jual_id);
		
		return $this->db->get();
	}

	function update_data_item() {
		$rawat_id 		= $this->uri->segment(4);
		$jual_id 		= $this->uri->segment(7);
		$detail_id 		= $this->input->post('id');

		$Qty 			= $this->input->post('qty');
		$Harga 			= intval(str_replace(",", "", $this->input->post('harga')));
		$Diskon 		= intval($this->input->post('disc'));
		$TotalNoDisc	= ($Qty * $Harga);
		$DiscRp			= (($Diskon*$TotalNoDisc)/100);
		$SubTotal 		= intval(str_replace(",", "", $this->input->post('subtotal')));

		// Variabel Obat
		$CodeObat 		= trim($this->input->post('code'));
		$stokakhir 		= $this->input->post('stokakhir'); // Stok Terakhir
		$qtylama 		= $this->input->post('qtylama'); // Qty Lama

		// Update Stok Barang ke Obat		
		$Disc1 		= (($Harga*$Diskon)/100); // Nominal Disc Harga Satuan		
		$Hrg_sat	= $Harga; // Harga Satuan Kecil
		$Stok   	= (($stokakhir+$qtylama)-$Qty); // (Stok terakhir-Qty Lama) + Qty Sekarang)		
		
		$data = array(
				'obat_stok'			=> $Stok // Stok Obat
			);

		$this->db->where('obat_code', $CodeObat);
		$this->db->update('clinic_obat', $data);

		// Update Item
		$data = array(
				'detail_qty'			=> $this->input->post('qty'),
				'detail_harga'			=> $Harga,				
		   		'detail_disc'			=> $Diskon,
				'detail_disc_nominal'	=> $DiscRp,
				'detail_total'			=> $SubTotal,				
			   	'detail_date_update' 	=> date('Y-m-d'),
			   	'detail_time_update' 	=> date('Y-m-d H:i:s')
			);

		$this->db->where('detail_id', $detail_id);
		$this->db->update('clinic_jual_detail', $data);

		// Update Total Resep
		$Total 				= $this->resep_model->select_total_resep($jual_id)->row();
		$Total				= $Total->total; // Total Harga Tindakan Pasien			

		$data = array(
			'jual_total'		=> $Total,
		   	'jual_date_update' 	=> date('Y-m-d'),
		   	'jual_time_update' 	=> date('Y-m-d H:i:s'),
		   	'user_username' 	=> trim($this->session->userdata('username'))		   		
		);

		$this->db->where('jual_id', $jual_id);
		$this->db->update('clinic_jual', $data);
	}

	function select_item($kode) { // Cek Detail Item Jual
		$this->db->select('*');
		$this->db->from('clinic_jual_detail');
		$this->db->where('detail_id', $kode);		
		
		return $this->db->get();
	}

	function select_detail_obat($obat_code) { // Cek Stok Akhir Master Obat
		$this->db->select('*');
		$this->db->from('clinic_obat');
		$this->db->where('obat_code', $obat_code);		
		
		return $this->db->get();
	}

	function delete_data_item($kode) {
		$rawat_id 	= $this->uri->segment(4);
		$jual_id 	= $this->uri->segment(7);

		// Update Stok Obat Lagi
		$Checkdetail 	= $this->resep_model->select_item($kode)->row(); // Detail Resep Jual by Detail ID
		$obat_code 		= $Checkdetail->obat_code; // Kode Obat
		$qty 			= $Checkdetail->detail_qty; // Qty Jual
		// Cari Stok Terakhir
		$check_stok = $this->resep_model->select_detail_obat($obat_code)->row();
		$stokakhir 	= $check_stok->obat_stok;
		$data = array(
				'obat_stok' => ($stokakhir+$qty) // Stok Akhir + Qty Jual
			); 
		// Update Stok
		$this->db->where('obat_code', $obat_code);
		$this->db->update('clinic_obat', $data);

		// Hapus Data Item Pembelian
		$this->db->where('detail_id', $kode);
		$this->db->delete('clinic_jual_detail');

		// Update Total Resep
		$Total 				= $this->resep_model->select_total_resep($jual_id)->row();
		$Total				= $Total->total; // Total Harga Tindakan Pasien			

		$data = array(
			'jual_total'		=> $Total,
		   	'jual_date_update' 	=> date('Y-m-d'),
		   	'jual_time_update' 	=> date('Y-m-d H:i:s'),
		   	'user_username' 	=> trim($this->session->userdata('username'))		   		
		);

		$this->db->where('jual_id', $jual_id);
		$this->db->update('clinic_jual', $data);
	}

	function update_data() {
		$jual_id     	= $this->uri->segment(7);		
		$data = array(
				'jual_date' 			=> date('Y-m-d'),
				'dokter_id'				=> $this->input->post('lstDokter'),
				'jual_resep'			=> $this->input->post('lstStatusObat'),
				'user_username' 		=> trim($this->session->userdata('username')),
				'jual_date_update' 		=> date('Y-m-d'),
				'jual_time_update' 		=> date('Y-m-d H:i:s')
		);

		$this->db->where('jual_id', $jual_id);
		$this->db->update('clinic_jual', $data);
	}

	function delete_data($kode) {
		$this->db->where('jual_id', $kode);
		$this->db->delete('clinic_jual');
	}

	function pembayaran_data() {
		$jual_id     	= $this->uri->segment(7);

		$data = array(
				'jual_date_bayar' 		=> date('Y-m-d'),
				'jual_pay_type'			=> $this->input->post('lstJenisBayar'),
				'jual_st_bayar'			=> 'Close',
				'user_username' 		=> trim($this->session->userdata('username')),
				'jual_date_update' 		=> date('Y-m-d'),
				'jual_time_update' 		=> date('Y-m-d H:i:s')
		);

		$this->db->where('jual_id', $jual_id);
		$this->db->update('clinic_jual', $data);
	}
}
/* Location: ./application/model/rawat/Resep_model.php */