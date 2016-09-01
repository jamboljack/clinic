<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pendaftaran_model extends CI_Model {
	function __construct() {
		parent::__construct();	
	}

	function getkodeunik() {
		$tgl_sekarang = date('Y-m-d');			
		$xtg = explode("-",$tgl_sekarang);
		$thn = $xtg[0];
		$bln = $xtg[1];
		$tgl = $xtg[2];		
				
        $q 	= $this->db->query("SELECT MAX(pasien_id) AS idmax FROM clinic_pasien");
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
        
        return 'CM'.$mkd;
   	}

   	function getnotransaksi() {
		$tgl_sekarang = date('Y-m-d');			
		$xtg = explode("-",$tgl_sekarang);
		$thn = $xtg[0];
		$bln = $xtg[1];
		$tgl = $xtg[2];		
				
        $q 	= $this->db->query("SELECT MAX(rawat_id) AS idmax FROM clinic_rawat");
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

        return $mkd.'RJ'.$tgl.$bln.$thn;        
   	}

	function select_poliklinik() {
		$this->db->select('*');
		$this->db->from('clinic_poliklinik');
		$this->db->order_by('poliklinik_name','asc');
		
		return $this->db->get();
	}
	
	function select_pelanggan() {
		$this->db->select('p.pelanggan_id, p.kelompok_id, p.pelanggan_name, k.jenis_id, k.kelompok_name, j.jenis_name');
		$this->db->from('clinic_pelanggan p');
		$this->db->join('clinic_kelompok k', 'p.kelompok_id=k.kelompok_id');
		$this->db->join('clinic_jenis_tarif j', 'k.jenis_id=j.jenis_id');
		$this->db->order_by('p.pelanggan_name','asc');
		
		return $this->db->get();
	}

	function select_asuransi() {
		$this->db->select('*');
		$this->db->from('clinic_asuransi');
		$this->db->order_by('asuransi_name','asc');
		
		return $this->db->get();
	}

	function select_identitas() {
		$this->db->select('*');
		$this->db->from('clinic_identitas');
		$this->db->order_by('identitas_name','asc');
		
		return $this->db->get();
	}

	function select_agama() {
		$this->db->select('*');
		$this->db->from('clinic_agama');
		$this->db->order_by('agama_name','asc');
		
		return $this->db->get();
	}

	function select_status() {
		$this->db->select('*');
		$this->db->from('clinic_status');
		$this->db->order_by('status_name','asc');
		
		return $this->db->get();
	}

	function select_pendidikan() {
		$this->db->select('*');
		$this->db->from('clinic_pendidikan');
		$this->db->order_by('pendidikan_id','asc');
		
		return $this->db->get();
	}	

	function select_pekerjaan() {
		$this->db->select('*');
		$this->db->from('clinic_pekerjaan');
		$this->db->order_by('pekerjaan_name','asc');
		
		return $this->db->get();
	}

	function select_darah() {
		$this->db->select('*');
		$this->db->from('clinic_darah');
		$this->db->order_by('darah_name','asc');
		
		return $this->db->get();
	}

	function select_dokter() {
		$this->db->select('*');
		$this->db->from('clinic_dokter');
		$this->db->order_by('dokter_name','asc');
		
		return $this->db->get();
	}

	function select_alamat() {
		$sql= "SELECT p.*, k.kab_id, k.kab_name, c.kec_id, c.kec_name, d.desa_id, d.desa_name 
				FROM clinic_desa d 
				JOIN clinic_kec c ON d.kec_id=c.kec_id 
				JOIN clinic_kab k ON c.kab_id=k.kab_id
				JOIN clinic_provinsi p ON k.provinsi_id=p.provinsi_id
				WHERE k.provinsi_id = '33' 
				AND k.kab_id = '3319' 
				OR k.kab_id = '3320' 
				OR k.kab_id = '3321' 
				ORDER BY d.desa_name ASC";

		$query = $this->db->query($sql);
		return $query->result();		
	}	
}
/* Location: ./application/model/rawat/Pendaftaran_model.php */