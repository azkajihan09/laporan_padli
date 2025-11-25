<?php
// class M_P_Banding extends CI_Model {

//     public function __construct()
//     {
//         $this->load->database();
//     }

//     public function get_perkara()
//     {
//         $this->db->select('
//             perkara_banding.nomor_perkara_pn,
//             perkara_banding.permohonan_banding,
//             perkara_banding.pemberitahuan_inzage,
//             perkara_banding.pengiriman_berkas_banding,
//             perkara_banding.putusan_banding,
//             perkara_banding.pemberitahuan_putusan_banding,
//             perkara_putusan.tanggal_putusan
//         ');
//         $this->db->from('perkara');
//         $this->db->join('perkara_banding', 'perkara.perkara_id = perkara_banding.perkara_id', 'left');
//         $this->db->join('perkara_putusan', 'perkara.perkara_id = perkara_putusan.perkara_id', 'left');
//         $this->db->where('YEAR(perkara_banding.permohonan_banding)', '2023');
//         $this->db->where('MONTH(perkara_banding.permohonan_banding)', '11');
//         $this->db->order_by('perkara.perkara_id');

//         $query = $this->db->get();
//         return $query->result_array();
//     }
// }
defined('BASEPATH') or exit('No direct script access allowed');

class M_P_Banding extends CI_Model
{
	public function getData($lap_tahun, $lap_bulan)
	{
		
		$query = $this->db->query("SELECT nomor_perkara_pn, putusan_pn, permohonan_banding, pemberitahuan_inzage, pengiriman_berkas_banding, putusan_banding, penerimaan_kembali_berkas_banding,  pemberitahuan_putusan_banding FROM perkara
			LEFT JOIN perkara_banding ON perkara.perkara_id = perkara_banding.perkara_id
			LEFT JOIN perkara_putusan ON perkara.perkara_id = perkara_putusan.perkara_id
			WHERE (
				YEAR(perkara_banding.permohonan_banding)='$lap_tahun' AND MONTH(perkara_banding.permohonan_banding)='$lap_bulan'
				OR YEAR(perkara_banding.pemberitahuan_inzage)='$lap_tahun' AND MONTH(perkara_banding.pemberitahuan_inzage)='$lap_bulan'
				OR YEAR(perkara_banding.pengiriman_berkas_banding)='$lap_tahun' AND MONTH(perkara_banding.pengiriman_berkas_banding)='$lap_bulan'
				OR YEAR(perkara_banding.putusan_banding)='$lap_tahun' AND MONTH(perkara_banding.putusan_banding)='$lap_bulan'
				OR YEAR(perkara_banding.pemberitahuan_putusan_banding)='$lap_tahun' AND MONTH(perkara_banding.pemberitahuan_putusan_banding)='$lap_bulan'
			)
			ORDER BY perkara.perkara_id
		");
		return $query->result();
		
	}
}
