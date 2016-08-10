<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Purchasing_model extends CI_Model {
	function __construct() {
		parent::__construct();	
	}

	function select_all() {
		$this->db->select('p.*, s.suplier_name');
		$this->db->from('clinic_purchase p');
		$this->db->join('clinic_suplier s', 'p.suplier_id=s.suplier_id', 'left');
		$this->db->order_by('p.purchase_id','desc');
		
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
				
        $q 	= $this->db->query("SELECT MAX(purchase_id) AS idmax FROM clinic_purchase");
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

        return 'PO'.$mkd.$tgl.$bln.$thn;
   	}

   	function check_purchase($ID_Purchase) {
		$this->db->select('*');
		$this->db->from('clinic_purchase');
		$this->db->where('purchase_id', $ID_Purchase);		
		
		return $this->db->get();
	}

	function select_total($ID_Purchase) {
		$this->db->select('SUM(purc_detail_subtotal) as total');
		$this->db->from('clinic_purchase_detail');
		$this->db->where('purchase_id', $ID_Purchase);		
		
		return $this->db->get();
	}

   	function select_item($ID_Purchase) {
		$this->db->select('*');
		$this->db->from('clinic_purchase_detail');
		$this->db->where('purchase_id', $ID_Purchase);
		$this->db->order_by('purc_detail_id','asc');
		
		return $this->db->get();
	}

	function check_item($CodeObat) {
		$ID_Purchase	= $this->uri->segment(4);

		$this->db->select('*');
		$this->db->from('clinic_purchase_detail');
		$this->db->where('obat_code', $CodeObat);
		$this->db->where('purchase_id', $ID_Purchase);
		
		return $this->db->get();
	}

	function select_by_id($ID_Purchase) {
		$this->db->select('p.*, s.suplier_name,s.suplier_address,s.suplier_city,s.suplier_phone');
		$this->db->from('clinic_purchase p');
		$this->db->join('clinic_suplier s', 'p.suplier_id=s.suplier_id', 'left');
		$this->db->where('p.purchase_id', $ID_Purchase);
		
		return $this->db->get();
	}

	function update_data_item() {		
		$purc_detail_id = $this->input->post('id');		
		$SubTotal 		= intval(str_replace(",", "", $this->input->post('subtotal')));

		$data = array(
				'purc_detail_qty'			=> $this->input->post('qty'),
		   		'purc_detail_subtotal'		=> $SubTotal,
			   	'purc_detail_date_update' 	=> date('Y-m-d'),
			   	'purc_detail_time_update' 	=> date('Y-m-d H:i:s')
			);

		$this->db->where('purc_detail_id', $purc_detail_id);
		$this->db->update('clinic_purchase_detail', $data);

		// Update Total Purchase
		$ID_Purchase= $this->uri->segment(4);
		$Total 		= $this->purchasing_model->select_total($ID_Purchase)->row();
		$TotalPO	= $Total->total; // Total PO

		$data = array(
			'purchase_total'			=> $TotalPO,
		   	'purchase_date_update' 		=> date('Y-m-d'),
		   	'purchase_time_update' 		=> date('Y-m-d H:i:s'),
		   	'user_username' 			=> trim($this->session->userdata('username'))		   		
		);

		$this->db->where('purchase_id', $ID_Purchase);
		$this->db->update('clinic_purchase', $data);
	}	

	function update_data() {
		$purchase_id    = $this->uri->segment(4);

		$tgl1 			= $this->input->post('date');
		$xtg1 			= explode("-",$tgl1);
		$thn1 			= $xtg1[2];
		$bln1 			= $xtg1[1];
		$tgl1 			= $xtg1[0];

		$tanggal 		= $thn1.'-'.$bln1.'-'.$tgl1;
		$termin 		= $this->input->post('termin');
		$tempo 			= (date('Y-m-d')+$termin);

		$ID_Purchase= $this->uri->segment(4);
		$Total 		= $this->purchasing_model->select_total($ID_Purchase)->row();
		$TotalPO	= $Total->total; // Total PO

		$data = array(
				'purchase_date'				=> $tanggal,
				'suplier_id'				=> trim($this->input->post('lstSuplier')),
				'purchase_termin'			=> $this->input->post('termin'),
				'purchase_tgl_tempo'		=> $tempo,
				'purchase_ket'				=> $this->input->post('keterangan'),
				'purchase_total'			=> $TotalPO,				
		   		'purchase_date_update' 		=> date('Y-m-d'),
		   		'purchase_time_update' 		=> date('Y-m-d H:i:s'),
		   		'user_username' 			=> trim($this->session->userdata('username')),
		   		'purchase_status' 			=> 1
			);

		$this->db->where('purchase_id', $purchase_id);
		$this->db->update('clinic_purchase', $data);
	}

	function delete_data($kode) {
		// Hapus Detail
		$this->db->where('purchase_id', $kode);
		$this->db->delete('clinic_purchase_detail');
		// Hapus Transaksi
		$this->db->where('purchase_id', $kode);
		$this->db->delete('clinic_purchase');		
	}

	function delete_data_item($kode) {		
		$this->db->where('purc_detail_id', $kode);
		$this->db->delete('clinic_purchase_detail');
		// Update Total Purchase
		$ID_Purchase= $this->uri->segment(4);
		$Total 		= $this->purchasing_model->select_total($ID_Purchase)->row();
		$TotalPO	= $Total->total; // Total PO

		$data = array(
			'purchase_total'			=> $TotalPO,		   		
		   	'purchase_date_update' 		=> date('Y-m-d'),
		   	'purchase_time_update' 		=> date('Y-m-d H:i:s'),
		   	'user_username' 			=> trim($this->session->userdata('username'))		   		
		);

		$this->db->where('purchase_id', $ID_Purchase);
		$this->db->update('clinic_purchase', $data);
	}
}
/* Location: ./application/model/apotek/Purchasing_model.php */