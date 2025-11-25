<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_delegasi_k extends CI_Model
{
	function delegasi_k($lap_bulan, $lap_tahun)
	{

	
		$this->db->select('
		dm.perkara_id,
		dm.pn_tujuan_text,
		dm.`nomor_perkara`,
		dm.pihak,
		dm.`nomor_surat`,
		tanggal_pendaftaran,
		dm.`tgl_surat`,
		dm.`tgl_sidang`,
		dm.`tgl_delegasi`,
		dpm.`tgl_surat_diterima`,
		dpm.`tgl_pengiriman_relaas`,
		dpm.`tgl_resi`,
		dpm.`diinput_tanggal`,
		pe.`jurusita_text`,
		dm.`jenis_delegasi_text`
		');
		$this->db->from('perkara da');
		
		$this->db->join('perkara_penetapan pe', 'da.`perkara_id` = pe.perkara_id', 'LEFT');	
		$this->db->join('delegasi_keluar dm', 'da.`perkara_id` = dm.perkara_id', 'LEFT');
		$this->db->join('delegasi_proses_keluar dpm', 'dm.id = dpm.`delegasi_id`', 'LEFT');
		$this->db->where('dm.tgl_surat >=', $lap_tahun . '-' . $lap_bulan . '-01');
		$this->db->where('dm.tgl_surat <=', $lap_tahun . '-' . $lap_bulan . '-31');
		// $this->db->where('dm.pn_tujuan_text', 'PENGADILAN AGAMA PENAJAM');
		$this->db->group_by('dm.tgl_surat, dm.nomor_surat');
		$this->db->order_by('dm.perkara_id', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}
}
