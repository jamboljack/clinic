<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kasir_model extends CI_Model {
	function __construct() {
		parent::__construct();	
	}	
	
	function select_all() {
		$this->db->select('r.*, p.pasien_nama, l.poliklinik_name, d.dokter_name');
		$this->db->from('clinic_rawat r');
		$this->db->join('clinic_pasien p', 'r.pasien_id=p.pasien_id');
		$this->db->join('clinic_poliklinik l', 'r.poliklinik_id=l.poliklinik_id');
		$this->db->join('clinic_dokter d', 'r.dokter_id=d.dokter_id');
		$this->db->where('r.rawat_date', date('Y-m-d')); // Hari Ini
		$this->db->order_by('r.rawat_id', 'desc');
		
		return $this->db->get();
	}

	function getKwitansi() {
		$tgl_sekarang = date('Y-m-d');			
		$xtg = explode("-",$tgl_sekarang);
		$thn = $xtg[0];
		$bln = $xtg[1];
		$tgl = $xtg[2];		
				
        $q 	= $this->db->query("SELECT MAX(rawat_no_kwitansi) AS idmax FROM clinic_rawat");
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
        
        return 'KW'.$tgl.'.'.$bln.'.'.$mkd;
   	}

	function select_pasien($pasien_id) {
		$this->db->select('p.pasien_id, p.pasien_no_rm, p.pasien_nama, p.pasien_alamat, k.kelompok_name, 
							l.pelanggan_name');		
		$this->db->from('clinic_pasien p');
		$this->db->join('clinic_kelompok k', 'p.kelompok_id=k.kelompok_id');
		$this->db->join('clinic_pelanggan l', 'p.pelanggan_id=l.pelanggan_id');
		$this->db->where('p.pasien_id', $pasien_id);
		
		return $this->db->get();
	}

	function select_tindakan($pasien_id) {
		$this->db->select('r.pasien_id, r.rawat_id, r.rawat_no_trans, r.rawat_date, d.dokter_name, r.rawat_total, 
						l.poliklinik_name, r.rawat_jns_bayar');		
		$this->db->from('clinic_rawat r');
		$this->db->join('clinic_pasien p', 'r.pasien_id=p.pasien_id');
		$this->db->join('clinic_dokter d', 'r.dokter_id=d.dokter_id');
		$this->db->join('clinic_poliklinik l', 'r.poliklinik_id=l.poliklinik_id');
		$this->db->where('r.pasien_id', $pasien_id);
		$this->db->where('r.rawat_date', date('Y-m-d'));
		$this->db->order_by('r.rawat_id', 'asc');
		
		return $this->db->get();
	}

	function select_resep($pasien_id) {
		$this->db->select('j.pasien_id, j.jual_id, j.jual_no_faktur, j.jual_date, d.dokter_name, 
						j.jual_total, j.jual_pay_type');		
		$this->db->from('clinic_jual j');
		$this->db->join('clinic_pasien p', 'j.pasien_id=p.pasien_id');
		$this->db->join('clinic_dokter d', 'j.dokter_id=d.dokter_id');		
		$this->db->where('j.pasien_id', $pasien_id);
		$this->db->where('j.jual_status', 'JUAL');
		$this->db->where('j.jual_date', date('Y-m-d'));
		
		return $this->db->get();
	}

	function select_total_tindakan_open($pasien_id) {
		$this->db->select('SUM(rawat_total) as total');
		$this->db->from('clinic_rawat');
		$this->db->where('pasien_id', $pasien_id);
		$this->db->where('rawat_st_bayar', 'Open');
		$this->db->where('rawat_date', date('Y-m-d'));

		return $this->db->get();
	}

	function select_total_resep_open($pasien_id) {
		$this->db->select('SUM(jual_total) as total');
		$this->db->from('clinic_jual');
		$this->db->where('pasien_id', $pasien_id);
		$this->db->where('jual_status', 'JUAL');
		$this->db->where('jual_st_bayar', 'Open');
		$this->db->where('jual_date', date('Y-m-d'));
		
		return $this->db->get();
	}

	function select_total_tindakan_close($pasien_id) {
		$this->db->select('SUM(rawat_total) as total');
		$this->db->from('clinic_rawat');
		$this->db->where('pasien_id', $pasien_id);
		$this->db->where('rawat_st_bayar', 'Close');
		$this->db->where('rawat_date', date('Y-m-d'));

		return $this->db->get();
	}

	function select_total_resep_close($pasien_id) {
		$this->db->select('SUM(jual_total) as total');
		$this->db->from('clinic_jual');
		$this->db->where('pasien_id', $pasien_id);
		$this->db->where('jual_status', 'JUAL');
		$this->db->where('jual_st_bayar', 'Close');
		$this->db->where('jual_date', date('Y-m-d'));
		
		return $this->db->get();
	}

	function select_tindakan_open($pasien_id) {
		$this->db->select('*');		
		$this->db->from('clinic_rawat');
		$this->db->where('pasien_id', $pasien_id);
		$this->db->where('rawat_st_bayar', 'Open');
		$this->db->where('rawat_date', date('Y-m-d'));
		$this->db->order_by('rawat_id', 'asc');
		
		return $this->db->get();
	}

	function select_resep_open($pasien_id) {
		$this->db->select('*');		
		$this->db->from('clinic_jual');
		$this->db->where('pasien_id', $pasien_id);
		$this->db->where('jual_status', 'JUAL');
		$this->db->where('jual_st_bayar', 'Open');
		$this->db->where('jual_date', date('Y-m-d'));
		$this->db->order_by('jual_id', 'asc');
		
		return $this->db->get();
	}
}
/* Location: ./application/model/rawat/Kasir_model.php */