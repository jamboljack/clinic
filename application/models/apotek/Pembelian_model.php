<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pembelian_model extends CI_Model {
	function __construct() {
		parent::__construct();	
	}

	function select_all() {
		$this->db->select('p.*, s.suplier_name');
		$this->db->from('clinic_pembelian p');
		$this->db->join('clinic_suplier s', 'p.suplier_id=s.suplier_id', 'left');
		$this->db->order_by('p.pembelian_id','desc');
		
		return $this->db->get();
	}

	function select_suplier() {
		$this->db->select('*');
		$this->db->from('clinic_suplier');
		$this->db->order_by('suplier_name','asc');

		return $this->db->get();
	}

	function select_obat() {
		$this->db->select('obat_code, obat_name, obat_hrg_kms, obat_sat_kms, obat_hrg_kcl, obat_hrg_kms,
							obat_isi_kcl, obat_sat_kcl, obat_stok');
		$this->db->from('clinic_obat');
		$this->db->where('obat_st_aktif', 1);
		$this->db->order_by('obat_name','asc');
		
		return $this->db->get();
	}

	function getkodeunik() {
		$tgl_sekarang = date('Y-m-d');			
		$xtg = explode("-",$tgl_sekarang);
		$thn = $xtg[0];
		$bln = $xtg[1];
		$tgl = $xtg[2];		
				
        $q 	= $this->db->query("SELECT MAX(pembelian_id) AS idmax FROM clinic_pembelian");
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

        return 'PB'.$mkd.$tgl.$bln.$thn;
   	}

   	function check_transaksi($ID_Pembelian) {
		$this->db->select('*');
		$this->db->from('clinic_pembelian');
		$this->db->where('pembelian_id', $ID_Pembelian);		
		
		return $this->db->get();
	}

	function select_total($ID_Pembelian) {
		$this->db->select('SUM(detail_total) as total');
		$this->db->from('clinic_pembelian_detail');
		$this->db->where('pembelian_id', $ID_Pembelian);		
		
		return $this->db->get();
	}

   	function select_item($ID_Pembelian) {
		$this->db->select('*');
		$this->db->from('clinic_pembelian_detail');
		$this->db->where('pembelian_id', $ID_Pembelian);
		$this->db->order_by('detail_id','asc');
		
		return $this->db->get();
	}

	function check_item($CodeObat) {
		$ID_Pembelian	= $this->uri->segment(4);

		$this->db->select('*');
		$this->db->from('clinic_pembelian_detail');
		$this->db->where('obat_code', $CodeObat);
		$this->db->where('pembelian_id', $ID_Pembelian);
		
		return $this->db->get();
	}

	function select_by_id($ID_Pembelian) {
		$this->db->select('p.*, s.suplier_name, s.suplier_address');
		$this->db->from('clinic_pembelian p');
		$this->db->join('clinic_suplier s', 'p.suplier_id=s.suplier_id', 'left');
		$this->db->where('p.pembelian_id', $ID_Pembelian);
		
		return $this->db->get();
	}

	function update_data_item() {		
		$detail_id 		= $this->input->post('id');
		$Qty 			= $this->input->post('qty');
		$Harga 			= intval(str_replace(",", "", $this->input->post('harga')));
		$Diskon 		= intval($this->input->post('disc'));
		$TotalNoDisc	= ($Qty * $Harga);
		$DiscRp			= (($Diskon*$TotalNoDisc)/100);
		$SubTotal 		= intval(str_replace(",", "", $this->input->post('subtotal')));

		$tgl_expired 	= $this->input->post('tgl_expired');
		$xtg1ex 		= explode("-",$tgl_expired);
		$thn1 			= $xtg1ex[2];
		$bln1 			= $xtg1ex[1];
		$tgl1 			= $xtg1ex[0];
		$tanggal_ex 	= $thn1.'-'.$bln1.'-'.$tgl1;
		
		$data = array(
				'detail_qty'			=> $this->input->post('qty'),				
		   		'detail_disc'			=> $Diskon,
				'detail_disc_nominal'	=> $DiscRp,
				'detail_total'			=> $SubTotal,
				'detail_date_expired'	=> $tanggal_ex,
			   	'detail_date_update' 	=> date('Y-m-d'),
			   	'detail_time_update' 	=> date('Y-m-d H:i:s')
			);

		$this->db->where('detail_id', $detail_id);
		$this->db->update('clinic_pembelian_detail', $data);

		// Update Total pembelian
		$ID_Pembelian	= $this->uri->segment(4);
		$Total 		= $this->pembelian_model->select_total($ID_Pembelian)->row();
		$TotalPB	= $Total->total; // Total PO

		$data = array(
			'pembelian_netto'			=> $TotalPB,		   		
		   	'pembelian_date_update' 	=> date('Y-m-d'),
		   	'pembelian_time_update' 	=> date('Y-m-d H:i:s'),
		   	'user_username' 			=> trim($this->session->userdata('username'))		   		
		);

		$this->db->where('pembelian_id', $ID_Pembelian);
		$this->db->update('clinic_pembelian', $data);
	}	

	function update_data() {
		$pembelian_id    = $this->uri->segment(4);

		$tgl1 			= $this->input->post('tgl_faktur');
		$xtg1 			= explode("-",$tgl1);
		$thn1 			= $xtg1[2];
		$bln1 			= $xtg1[1];
		$tgl1 			= $xtg1[0];
		$tanggal 		= $thn1.'-'.$bln1.'-'.$tgl1;

		$tgl2 			= $this->input->post('tgl_jatuh_tempo');
		$xtg2 			= explode("-",$tgl2);
		$thn2 			= $xtg2[2];
		$bln2 			= $xtg2[1];
		$tgl2 			= $xtg2[0];
		$tanggal_tempo	= $thn2.'-'.$bln2.'-'.$tgl2;

		$tgl3 			= $this->input->post('tgl_pajak');
		$xtg3 			= explode("-",$tgl3);
		$thn3 			= $xtg3[2];
		$bln3 			= $xtg3[1];
		$tgl3 			= $xtg3[0];
		$tanggal_pajak	= $thn3.'-'.$bln3.'-'.$tgl3;

		// Total Invoice
		$ID_Pembelian 	= $this->uri->segment(4);
		$Total 			= $this->pembelian_model->select_total($ID_Pembelian)->row();
		$TotalPB		= $Total->total; // Total PO

		$Bruto 			= intval(str_replace(",", "", $this->input->post('total_bruto')));
		$PPN 			= intval($this->input->post('ppn')); // PPN
		$TotalPPN		= (($Bruto*$PPN)/100);
		$Netto 			= intval(str_replace(",", "", $this->input->post('total_netto')));

		$data = array(
				'pembelian_no_lpb'			=> trim($this->input->post('no_lpb')),
				'pembelian_no_invoice'		=> trim($this->input->post('no_faktur')),
				'pembelian_no_tax'			=> trim($this->input->post('no_pajak')),
				'pembelian_date_in'			=> $tanggal,
				'suplier_id'				=> trim($this->input->post('lstSuplier')),
				'pembelian_date_tax'		=> $tanggal_pajak,
				'pembelian_date_tempo'		=> $tanggal_tempo,
				'pembelian_ket'				=> trim($this->input->post('keterangan')),
				'pembelian_bruto'			=> $Bruto,
				'pembelian_ppn'				=> $PPN,
				'pembelian_ppn_nominal'		=> $TotalPPN,
				'pembelian_pay_type'		=> trim($this->input->post('lstJenisBayar')),
				'pembelian_netto'			=> $Netto,				
		   		'pembelian_date_update' 	=> date('Y-m-d'),
		   		'pembelian_time_update' 	=> date('Y-m-d H:i:s'),
		   		'user_username' 			=> trim($this->session->userdata('username')),
		   		'pembelian_status' 			=> 1
			);

		$this->db->where('pembelian_id', $pembelian_id);
		$this->db->update('clinic_pembelian', $data);
	}

	function delete_data($kode) {
		// Hapus Detail
		$this->db->where('pembelian_id', $kode);
		$this->db->delete('clinic_pembelian_detail');
		// Hapus Transaksi
		$this->db->where('pembelian_id', $kode);
		$this->db->delete('clinic_pembelian');		
	}

	function delete_data_item($kode) {		
		$this->db->where('detail_id', $kode);
		$this->db->delete('clinic_pembelian_detail');
		// Update Total pembelian
		$ID_Pembelian 	= $this->uri->segment(4);
		$Total 			= $this->pembelian_model->select_total($ID_Pembelian)->row();
		$TotalPB		= $Total->total; // Total PO

		$data = array(
			'pembelian_netto'			=> $TotalPB,		   		
		   	'pembelian_date_update' 	=> date('Y-m-d'),
		   	'pembelian_time_update' 	=> date('Y-m-d H:i:s'),
		   	'user_username' 			=> trim($this->session->userdata('username'))		   		
		);

		$this->db->where('pembelian_id', $ID_Pembelian);
		$this->db->update('clinic_pembelian', $data);
	}
}
/* Location: ./application/model/apotek/Pembelian_model.php */