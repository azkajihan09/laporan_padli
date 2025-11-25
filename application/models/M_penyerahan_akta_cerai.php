<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_penyerahan_akta_cerai extends CI_Model
{


	public function get_penyerahan_akta_cerai($lap_tahun, $lap_bulan)
	{

		$sql = "SELECT nomor_perkara, jenis_perkara_nama, nomor_akta_cerai, tanggal_putusan, tgl_ikrar_talak, tanggal_bht, tgl_penyerahan_akta_cerai as tgl_AC_P, tgl_penyerahan_akta_cerai_pihak2 as tgl_AC_T, perkara_pihak1.`nama` as nama_p, perkara_pihak2.`nama` as nama_t
		 		FROM perkara
		 		LEFT JOIN perkara_putusan ON perkara.`perkara_id`=perkara_putusan.`perkara_id`
	 		LEFT JOIN perkara_ikrar_talak ON perkara.`perkara_id`=perkara_ikrar_talak.`perkara_id`
		 		LEFT JOIN perkara_akta_cerai ON perkara.`perkara_id`=perkara_akta_cerai.`perkara_id`
		 		LEFT JOIN perkara_pihak1 ON perkara.`perkara_id`=perkara_pihak1.`perkara_id`
		 		LEFT JOIN perkara_pihak2 ON perkara.`perkara_id`=perkara_pihak2.`perkara_id`
		WHERE (YEAR(tgl_penyerahan_akta_cerai)=? AND MONTH(tgl_penyerahan_akta_cerai)=?) OR (YEAR(tgl_penyerahan_akta_cerai_pihak2)=? AND MONTH(tgl_penyerahan_akta_cerai_pihak2)=?)
		ORDER BY perkara.perkara_id";
		$query = $this->db->query($sql, array($lap_tahun, $lap_bulan, $lap_tahun, $lap_bulan));
		return $query->result();
	}
}
