<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resep_model extends CI_Model {
	function __construct() {
		parent::__construct();	
	}	
	
	function select_all() {
		$this->db->select('r.*, p.pasien_nama, l.poliklinik_name, d.dokter_name');
		$this->db->from('clinic_rawat r');
		$this->db->join('clinic_pasien p', 'r.pasien_id=p.pasien_id');
		$this->db->join('clinic_poliklinik l', 'r.poliklinik_id=l.poliklinik_id');
		$this->db->join('clinic_dokter d', 'r.dokter_id=d.dokter_id');
		$this->db->where('r.rawat_st_bayar', 'Open');
		$this->db->order_by('r.rawat_id', 'desc');		
		
		return $this->db->get();
	}

	function select_dokter() {
		$this->db->select('*');
		$this->db->from('clinic_dokter');
		$this->db->order_by('dokter_name', 'asc');		
		
		return $this->db->get();
	}

	function select_total($rawat_id) {
		$this->db->select('SUM(detail_total) as total');
		$this->db->from('clinic_rawat_detail');
		$this->db->where('rawat_id', $rawat_id);		
		
		return $this->db->get();
	}

	function select_produk($jenis_tarif) {
		$this->db->select('p.*, u.unit_name');
		$this->db->from('clinic_produk p');
		$this->db->join('clinic_unit u', 'p.unit_id = u.unit_id');
		$this->db->where('p.jenis_id', $jenis_tarif);
		$this->db->order_by('u.unit_id', 'asc');
		
		return $this->db->get();
	}

	function select_detail_pasien($rawat_id) {
		$this->db->select('r.*, p.pasien_no_rm, p.pasien_nama, p.pasien_alamat, d.dokter_name,
						j.jenis_name, k.kelompok_name, k.kelompok_hrg_obat, l.pelanggan_name, n.poliklinik_name');
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

	function select_list_tindakan($rawat_id) {
		$this->db->select('d.*, p.produk_js_tempat, p.produk_js_dokter, p.produk_js_perawat, p.produk_js_lain,
							j.jual_no_faktur');
		$this->db->from('clinic_rawat_detail d');
		$this->db->join('clinic_produk p', 'd.produk_id=p.produk_id');
		$this->db->join('clinic_jual j', 'd.jual_id=j.jual_id', 'left');
		$this->db->where('d.rawat_id', $rawat_id);
		
		return $this->db->get();
	}

	function check_item($CodeProduk) {
		$rawat_id	= $this->uri->segment(4);

		$this->db->select('d.*, k.js_tempat, k.js_dokter, k.js_perawat, k.js_lain');
		$this->db->from('clinic_rawat_detail d');
		$this->db->join('clinic_komponen k', 'k.produk_id=d.produk_id');
		$this->db->where('d.produk_id', $CodeProduk);
		$this->db->where('d.rawat_id', $rawat_id);
		
		return $this->db->get();
	}

	function check_jasa_dokter($CodeProduk) {
		$rawat_id	= $this->uri->segment(4);
		$dokter_id 	= trim($this->input->post('dokter_id'));

		$this->db->select('*');
		$this->db->from('clinic_jasa_dokter');		
		$this->db->where('produk_id', $CodeProduk);
		$this->db->where('dokter_id', $dokter_id);
		$this->db->where('rawat_id', $rawat_id);
		
		return $this->db->get();
	}

	function update_data_item() {		
		$detail_id 		= $this->input->post('id');
		$CodeProduk 	= trim($this->input->post('code'));	
		$rawat_id		= $this->uri->segment(4);
		$dokter_id 		= trim($this->input->post('dokter_id'));

		$Qty 			= $this->input->post('qty');
		$Harga 			= intval(str_replace(",", "", $this->input->post('harga')));		
		$SubTotal 		= intval(str_replace(",", "", $this->input->post('subtotal')));		

		$tgl_trans 		= $this->input->post('tgl_trans');
		$xtg1ex 		= explode("-",$tgl_trans);
		$thn1 			= $xtg1ex[2];
		$bln1 			= $xtg1ex[1];
		$tgl1 			= $xtg1ex[0];
		$tanggal_tr 	= $thn1.'-'.$bln1.'-'.$tgl1;
				
		// Update Item Detail (Rawat Detail)
		$data = array(
				'detail_date'			=> $tanggal_tr,
				'detail_qty'			=> $this->input->post('qty'),
				'detail_harga'			=> $Harga,
				'detail_total'			=> $SubTotal,
			   	'detail_date_update' 	=> date('Y-m-d'),
			   	'detail_time_update' 	=> date('Y-m-d H:i:s')
			);
		$this->db->where('detail_id', $detail_id);
		$this->db->update('clinic_rawat_detail', $data);

		// Update Komponen
		$data = array(
				'js_tempat'				=> $this->input->post('total_jasa_tempat'),
				'js_dokter'				=> $this->input->post('total_jasa_dokter'),
				'js_perawat'			=> $this->input->post('total_jasa_perawat'),
				'js_lain'				=> $this->input->post('total_jasa_lain')
			);
		$this->db->where('produk_id', $CodeProduk);
		$this->db->where('rawat_id', $rawat_id);
		$this->db->update('clinic_komponen', $data);

		// Insert ke Jasa Dokter
		if ($this->input->post('total_jasa_dokter') <> 0) {			
			$data = array(
					'qty'				=> $Qty,
					'total'				=> $this->input->post('total_jasa_dokter')
			);

			$this->db->where('produk_id', $CodeProduk);
			$this->db->where('dokter_id', $dokter_id);
			$this->db->where('rawat_id', $rawat_id);
			$this->db->update('clinic_jasa_dokter', $data);			
		}

		// Update Total Tindakan
		$Total 		= $this->tindakan_model->select_total($rawat_id)->row();
		$Total		= $Total->total; // Total Harga Tindakan Pasien		

		$data = array(
			'rawat_total'			=> $Total,			
		   	'rawat_date_update' 	=> date('Y-m-d'),
		   	'rawat_time_update' 	=> date('Y-m-d H:i:s'),
		   	'user_username' 		=> trim($this->session->userdata('username'))
		);

		$this->db->where('rawat_id', $rawat_id);
		$this->db->update('clinic_rawat', $data);
	}

	function update_data() {
		$rawat_id     	= $this->uri->segment(4);
		$JenisBayar		= trim($this->input->post('lstJenisBayar'));

		if ($JenisBayar == '-') {
			$data = array(					
					'rawat_perawatan'		=> trim($this->input->post('lstPerawatan')),
					'rawat_tindakan'		=> trim($this->input->post('lstTindakan')),
					'user_username' 		=> trim($this->session->userdata('username')),
			   		'rawat_date_update' 	=> date('Y-m-d'),
			   		'rawat_time_update' 	=> date('Y-m-d H:i:s')
			);
		} else {
			$data = array(
					'rawat_tgl_bayar' 		=> date('Y-m-d'),
					'rawat_jns_bayar'		=> trim($this->input->post('lstJenisBayar')),
					'rawat_perawatan'		=> trim($this->input->post('lstPerawatan')),
					'rawat_tindakan'		=> trim($this->input->post('lstTindakan')),
					'rawat_st_bayar'		=> 'Close',
					'user_username' 		=> trim($this->session->userdata('username')),
			   		'rawat_date_update' 	=> date('Y-m-d'),
			   		'rawat_time_update' 	=> date('Y-m-d H:i:s')
			);
		}

		$this->db->where('rawat_id', $rawat_id);
		$this->db->update('clinic_rawat', $data);
	}

	function delete_data($kode) {		
		$this->db->where('suplier_id', $kode);
		$this->db->delete('clinic_suplier');
	}

	function select_item($kode) {		
		$this->db->select('produk_id, dokter_id, jual_id');
		$this->db->from('clinic_rawat_detail');
		$this->db->where('detail_id', $kode);

		return $this->db->get();
	}

	function delete_data_item($kode) {
		$rawat_id 	= $this->uri->segment(4);		

		$checkdata_item_delete = $this->tindakan_model->select_item($kode)->row();
		$produk_id = $checkdata_item_delete->produk_id;
		$dokter_id = $checkdata_item_delete->dokter_id;
		
		// Hapus Komponen
		$this->db->where('rawat_id', $rawat_id);
		$this->db->where('produk_id', $produk_id);
		$this->db->delete('clinic_komponen');

		// Hapus Jasa Dokter
		$this->db->where('rawat_id', $rawat_id);
		$this->db->where('produk_id', $produk_id);
		$this->db->where('dokter_id', $dokter_id);
		$this->db->delete('clinic_jasa_dokter');

		// Hapus Data Item Pembelian
		$this->db->where('detail_id', $kode);
		$this->db->delete('clinic_rawat_detail');

		// Update Total
		$Total 		= $this->tindakan_model->select_total($rawat_id)->row();
		$Total		= $Total->total; // Total Harga Tindakan Pasien		

		$data = array(
			'rawat_total'			=> $Total,			
		   	'rawat_date_update' 	=> date('Y-m-d'),
		   	'rawat_time_update' 	=> date('Y-m-d H:i:s'),
		   	'user_username' 		=> trim($this->session->userdata('username'))
		);

		$this->db->where('rawat_id', $rawat_id);
		$this->db->update('clinic_rawat', $data);
	}

	function select_detail_obat($obat_code) {
		$this->db->select('obat_stok');
		$this->db->from('clinic_obat');
		$this->db->where('obat_code', $obat_code);		
		
		return $this->db->get();
	}

	function delete_data_item_alkes($kode) {
		$rawat_id 	= $this->uri->segment(4);		

		$checkdata_item_delete = $this->tindakan_model->select_item($kode)->row();
		$jual_id 	= $checkdata_item_delete->jual_id;

		// Kembalikan Stok Barang
		$list_item 	= $this->tindakan_model->select_item_bhp($jual_id)->result();
		foreach ($list_item as $i) {
			// Variabel Detail Obat
			$obat_code	= $i->obat_code;
			$qty		= $i->detail_qty;

			// Cari Data Obat + Stok Terakhir
			$check_stok = $this->tindakan_model->select_detail_obat($obat_code)->row();
			$stokakhir 	= $check_stok->obat_stok;

			$data = array(
					'obat_stok' => ($stokakhir + $qty) // Stok Akhir + Qty BHP
				); 

			// Update Stok
			$this->db->where('obat_code', $obat_code);
			$this->db->update('clinic_obat', $data);
		}

		// Hapus Data Detail Penjualan
		$this->db->where('jual_id', $jual_id);
		$this->db->delete('clinic_jual_detail');

		// Hapus Data Penjualan
		$this->db->where('jual_id', $jual_id);
		$this->db->delete('clinic_jual');		

		// Hapus Data Item Tindakan
		$this->db->where('detail_id', $kode);
		$this->db->delete('clinic_rawat_detail');		

		// Update Total
		$Total 		= $this->tindakan_model->select_total($rawat_id)->row();
		$Total		= $Total->total; // Total Harga Tindakan Pasien		

		$data = array(
			'rawat_total'			=> $Total,			
		   	'rawat_date_update' 	=> date('Y-m-d'),
		   	'rawat_time_update' 	=> date('Y-m-d H:i:s'),
		   	'user_username' 		=> trim($this->session->userdata('username'))
		);

		$this->db->where('rawat_id', $rawat_id);
		$this->db->update('clinic_rawat', $data);
	}

	function getkodeunikbhp() {
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

   	function select_total_bhp($jual_id) {
		$this->db->select('SUM(detail_total) as total');
		$this->db->from('clinic_jual_detail');
		$this->db->where('jual_id', $jual_id);		
		
		return $this->db->get();
	}

	function select_detail_bhp($jual_id) {
		$this->db->select('*');
		$this->db->from('clinic_jual');		
		$this->db->where('jual_id', $jual_id);
		
		return $this->db->get();
	}

	function select_item_bhp($jual_id) {
		$this->db->select('d.*, o.obat_stok');
		$this->db->from('clinic_jual_detail d');
		$this->db->join('clinic_obat o', 'd.obat_code=o.obat_code');
		$this->db->where('d.jual_id', $jual_id);
		$this->db->order_by('d.detail_id','asc');
		
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

	function check_item_bhp($CodeObat) {
		$jual_id	= $this->uri->segment(7);

		$this->db->select('*');
		$this->db->from('clinic_jual_detail');
		$this->db->where('obat_code', $CodeObat);
		$this->db->where('jual_id', $jual_id);
		
		return $this->db->get();
	}

	function update_data_item_bhp() {
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

		// Update Total BHP		
		$TotalBHP 		= $this->tindakan_model->select_total_bhp($jual_id)->row();
		$TotalBHP		= $TotalBHP->total; // Total PO

		$data = array(
			'jual_total'		=> $TotalBHP,			
		   	'jual_date_update' 	=> date('Y-m-d'),
		   	'jual_time_update' 	=> date('Y-m-d H:i:s'),
		   	'user_username' 	=> trim($this->session->userdata('username'))		   		
		);

		$this->db->where('jual_id', $jual_id);
		$this->db->update('clinic_jual', $data);

		// Update Harga & Total dari BHP di Rawat Detail
		$data = array(
				'detail_harga'			=> $TotalBHP,
				'detail_total'			=> $TotalBHP
		);
		
		$this->db->where('jual_id', $jual_id);
		$this->db->update('clinic_rawat_detail', $data);

		// Update Total Tindakan
		$Total 		= $this->tindakan_model->select_total($rawat_id)->row();
		$Total		= $Total->total; // Total Harga Tindakan Pasien		
		
		$data = array(
			'rawat_total'			=> $Total,			
		   	'rawat_date_update' 	=> date('Y-m-d'),
		   	'rawat_time_update' 	=> date('Y-m-d H:i:s'),
		   	'user_username' 		=> trim($this->session->userdata('username'))
		);

		$this->db->where('rawat_id', $rawat_id);
		$this->db->update('clinic_rawat', $data);
	}

	function delete_data_item_bhp($kode) {
		$rawat_id 	= $this->uri->segment(4);
		$jual_id 	= $this->uri->segment(7);

		// Hapus Data Item Pembelian
		$this->db->where('detail_id', $kode);
		$this->db->delete('clinic_jual_detail');

		// Update Total BHP
		$TotalBHP 		= $this->tindakan_model->select_total_bhp($jual_id)->row();
		$TotalBHP		= $TotalBHP->total; // Total PO

		$data = array(
			'jual_total'		=> $TotalBHP,			
		   	'jual_date_update' 	=> date('Y-m-d'),
		   	'jual_time_update' 	=> date('Y-m-d H:i:s'),
		   	'user_username' 	=> trim($this->session->userdata('username'))		   		
		);

		$this->db->where('jual_id', $jual_id);
		$this->db->update('clinic_jual', $data);

		// Update Harga & Total dari BHP di Rawat Detail
		$data = array(
				'detail_harga'			=> $TotalBHP,
				'detail_total'			=> $TotalBHP
		);
		
		$this->db->where('jual_id', $jual_id);
		$this->db->update('clinic_rawat_detail', $data);
		
		// Update Total Tindakan
		$Total 		= $this->tindakan_model->select_total($rawat_id)->row();
		$Total		= $Total->total; // Total Harga Tindakan Pasien		
		
		$data = array(
			'rawat_total'			=> $Total,			
		   	'rawat_date_update' 	=> date('Y-m-d'),
		   	'rawat_time_update' 	=> date('Y-m-d H:i:s'),
		   	'user_username' 		=> trim($this->session->userdata('username'))
		);

		$this->db->where('rawat_id', $rawat_id);
		$this->db->update('clinic_rawat', $data);
	}

	function update_data_bhp() {
		$jual_id     = $this->uri->segment(7);
		
		$data = array(
				'dokter_id'				=> trim($this->input->post('lstDokter')),
				'jual_resep'			=> trim($this->input->post('lstStatusObat'))
		);

		$this->db->where('jual_id', $jual_id);
		$this->db->update('clinic_jual', $data);
	}
}
/* Location: ./application/model/rawat/Resep_model.php */