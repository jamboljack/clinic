<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Obat_model extends CI_Model {
	function __construct() {
		parent::__construct();	
	}

	function select_all() {
		$this->db->select('o.obat_code,o.obat_name, o.obat_hrg_kcl_e, j.jenis_name, g.gol_name, p.pabrikan_name, s.suplier_name');
		$this->db->from('clinic_obat o');
		$this->db->join('clinic_jenis_obat j', 'o.jenis_id=j.jenis_id');
		$this->db->join('clinic_gol_obat g', 'o.gol_id=g.gol_id');
		$this->db->join('clinic_pabrikan p', 'o.pabrikan_id=p.pabrikan_id');
		$this->db->join('clinic_suplier s', 'o.suplier_id=s.suplier_id');
		$this->db->order_by('o.obat_name','asc');
		
		return $this->db->get();
	}

	function select_jenis_obat() {
		$this->db->select('*');
		$this->db->from('clinic_jenis_obat');
		$this->db->order_by('jenis_name','asc');
		
		return $this->db->get();
	}

	function select_gol_obat() {
		$this->db->select('*');
		$this->db->from('clinic_gol_obat');
		$this->db->order_by('gol_name','asc');
		
		return $this->db->get();
	}

	function select_pabrikan() {
		$this->db->select('*');
		$this->db->from('clinic_pabrikan');
		$this->db->order_by('pabrikan_name','asc');
		
		return $this->db->get();
	}

	function select_suplier() {
		$this->db->select('*');
		$this->db->from('clinic_suplier');
		$this->db->order_by('suplier_name','asc');
		
		return $this->db->get();
	}

	function getkodeunik() {
		$tgl_sekarang = date('Y-m-d');			
		$xtg = explode("-",$tgl_sekarang);
		$thn = $xtg[0];

		$Jenis 	= $this->input->post('lstJenis');
		$Gol 	= $this->input->post('lstGolongan');
		$Pabrik = $this->input->post('lstPabrikan');
		$Suplier= $this->input->post('lstSuplier');
				
        $q 	= $this->db->query("SELECT COUNT(obat_code) AS idmax FROM clinic_obat");
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
        
        return $mkd.$Jenis.$Gol.$Pabrik.$Suplier.$thn;
   	}
	
	function insert_data() {
		$Code 		= $this->obat_model->getkodeunik();

		$data = array(
				'obat_code'			=> trim($Code),
				'obat_name'			=> strtoupper(trim($this->input->post('name'))),
				'obat_merk'			=> strtoupper(trim($this->input->post('merk'))),
				'jenis_id'			=> $this->input->post('lstJenis'),
				'gol_id'			=> $this->input->post('lstGolongan'),
				'pabrikan_id'		=> $this->input->post('lstPabrikan'),
				'suplier_id'		=> $this->input->post('lstSuplier'),
				'obat_sat_kms'		=> strtoupper(trim($this->input->post('sat_kemasan'))),
				'obat_hrg_kms'		=> $this->input->post('hrg_kemasan'),
				'obat_sat_kcl'		=> strtoupper(trim($this->input->post('sat_kecil'))),
				'obat_isi_kcl'		=> $this->input->post('isi_sat_kecil'),
				'obat_hrg_kcl'		=> $this->input->post('hrg_kecil'),
				'obat_hpp'			=> $this->input->post('hrg_pokok'),
				'obat_min_qty'		=> $this->input->post('minimal'),
				'obat_max_qty'		=> $this->input->post('maximal'),
				'obat_st_generik'	=> $this->input->post('chkGenerik'),
				'obat_st_bpjs'		=> $this->input->post('chkBPJS'),
				'obat_st_adiktif'	=> $this->input->post('chkAditif'),
				'obat_st_drop'		=> $this->input->post('chkDrop'),
				'obat_st_aktif'		=> $this->input->post('chkStatus'),
				'obat_zat_aktif'	=> strtoupper(trim($this->input->post('zat_aktif'))),
				'obat_hrg_kms_g'	=> $this->input->post('kms_grosir'),
				'obat_hrg_kms_e'	=> $this->input->post('kcl_grosir'),
				'obat_hrg_kcl_g'	=> $this->input->post('kms_eceran'),
				'obat_hrg_kcl_e'	=> $this->input->post('kcl_eceran'),
		   		'obat_date_update' 	=> date('Y-m-d'),
		   		'obat_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->insert('clinic_obat', $data);
	}

	function select_by_id($obat_code) {
		$this->db->select('*');
		$this->db->from('clinic_obat');
		$this->db->where('obat_code', $obat_code);
		
		return $this->db->get();
	}	

	function update_data() {
		$obat_code     = $this->input->post('id');
		
		$data = array(				
				'obat_name'			=> strtoupper(trim($this->input->post('name'))),
				'obat_merk'			=> strtoupper(trim($this->input->post('merk'))),
				'jenis_id'			=> $this->input->post('lstJenis'),
				'gol_id'			=> $this->input->post('lstGolongan'),
				'pabrikan_id'		=> $this->input->post('lstPabrikan'),
				'suplier_id'		=> $this->input->post('lstSuplier'),
				'obat_sat_kms'		=> strtoupper(trim($this->input->post('sat_kemasan'))),
				'obat_hrg_kms'		=> $this->input->post('hrg_kemasan'),
				'obat_sat_kcl'		=> strtoupper(trim($this->input->post('sat_kecil'))),
				'obat_isi_kcl'		=> $this->input->post('isi_sat_kecil'),
				'obat_hrg_kcl'		=> $this->input->post('hrg_kecil'),
				'obat_hpp'			=> $this->input->post('hrg_pokok'),
				'obat_min_qty'		=> $this->input->post('minimal'),
				'obat_max_qty'		=> $this->input->post('maximal'),
				'obat_st_generik'	=> $this->input->post('chkGenerik'),
				'obat_st_bpjs'		=> $this->input->post('chkBPJS'),
				'obat_st_adiktif'	=> $this->input->post('chkAditif'),
				'obat_st_drop'		=> $this->input->post('chkDrop'),
				'obat_st_aktif'		=> $this->input->post('chkStatus'),
				'obat_zat_aktif'	=> strtoupper(trim($this->input->post('zat_aktif'))),
				'obat_hrg_kms_g'	=> $this->input->post('kms_grosir'),
				'obat_hrg_kms_e'	=> $this->input->post('kcl_grosir'),
				'obat_hrg_kcl_g'	=> $this->input->post('kms_eceran'),
				'obat_hrg_kcl_e'	=> $this->input->post('kcl_eceran'),
		   		'obat_date_update' 	=> date('Y-m-d'),
		   		'obat_time_update' 	=> date('Y-m-d H:i:s')
		);

		$this->db->where('obat_code', $obat_code);
		$this->db->update('clinic_obat', $data);
	}

	function delete_data($kode) {		
		$this->db->where('obat_code', $kode);
		$this->db->delete('clinic_obat');
	}
}
/* Location: ./application/model/apotek/Obat_model.php */