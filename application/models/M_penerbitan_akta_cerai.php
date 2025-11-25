<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_penerbitan_akta_cerai extends CI_Model
{

	public function get_penerbitan_akta_cerai($lap_tahun, $lap_bulan)
	{
		$sql = "SELECT 
				pac.nomor_akta_cerai,
				pac.tgl_akta_cerai,
				pac.no_seri_akta_cerai,
				pac.jenis_cerai,
				p.nomor_perkara,
				p.tanggal_pendaftaran,
				p.jenis_perkara_nama,
				pp.tanggal_putusan,
				pp.tanggal_bht,
				pp.status_putusan_nama,
				pit.tgl_ikrar_talak,
				COALESCE(p.pihak1_text, 'Tidak Ada Data') as penggugat,
				COALESCE(p.pihak2_text, 'Tidak Ada Data') as tergugat,
				fc.nama as faktor_perceraian
			FROM perkara_akta_cerai pac
			INNER JOIN perkara p ON pac.perkara_id = p.perkara_id
			LEFT JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
			LEFT JOIN perkara_ikrar_talak pit ON p.perkara_id = pit.perkara_id
			LEFT JOIN faktor_perceraian fc ON pac.faktor_perceraian_id = fc.id
			WHERE YEAR(pac.tgl_akta_cerai) = ? 
			  AND MONTH(pac.tgl_akta_cerai) = ?
			  AND pac.nomor_akta_cerai IS NOT NULL
			ORDER BY pac.tgl_akta_cerai DESC, p.nomor_perkara";
			
		$query = $this->db->query($sql, array($lap_tahun, $lap_bulan));
		return $query->result();
	}
	
	public function get_penerbitan_akta_cerai_tahunan($lap_tahun)
	{
		$sql = "SELECT 
				pac.nomor_akta_cerai,
				pac.tgl_akta_cerai,
				pac.no_seri_akta_cerai,
				pac.jenis_cerai,
				p.nomor_perkara,
				p.tanggal_pendaftaran,
				p.jenis_perkara_nama,
				pp.tanggal_putusan,
				pp.tanggal_bht,
				pp.status_putusan_nama,
				pit.tgl_ikrar_talak,
				COALESCE(p.pihak1_text, 'Tidak Ada Data') as penggugat,
				COALESCE(p.pihak2_text, 'Tidak Ada Data') as tergugat,
				fc.nama as faktor_perceraian
			FROM perkara_akta_cerai pac
			INNER JOIN perkara p ON pac.perkara_id = p.perkara_id
			LEFT JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
			LEFT JOIN perkara_ikrar_talak pit ON p.perkara_id = pit.perkara_id
			LEFT JOIN faktor_perceraian fc ON pac.faktor_perceraian_id = fc.id
			WHERE YEAR(pac.tgl_akta_cerai) = ?
			  AND pac.nomor_akta_cerai IS NOT NULL
			ORDER BY pac.tgl_akta_cerai DESC, p.nomor_perkara";
			
		$query = $this->db->query($sql, array($lap_tahun));
		return $query->result();
	}
	
	public function get_penerbitan_akta_cerai_custom($tanggal_mulai, $tanggal_akhir)
	{
		$sql = "SELECT 
				pac.nomor_akta_cerai,
				pac.tgl_akta_cerai,
				pac.no_seri_akta_cerai,
				pac.jenis_cerai,
				p.nomor_perkara,
				p.tanggal_pendaftaran,
				p.jenis_perkara_nama,
				pp.tanggal_putusan,
				pp.tanggal_bht,
				pp.status_putusan_nama,
				pit.tgl_ikrar_talak,
				COALESCE(p.pihak1_text, 'Tidak Ada Data') as penggugat,
				COALESCE(p.pihak2_text, 'Tidak Ada Data') as tergugat,
				fc.nama as faktor_perceraian
			FROM perkara_akta_cerai pac
			INNER JOIN perkara p ON pac.perkara_id = p.perkara_id
			LEFT JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
			LEFT JOIN perkara_ikrar_talak pit ON p.perkara_id = pit.perkara_id
			LEFT JOIN faktor_perceraian fc ON pac.faktor_perceraian_id = fc.id
			WHERE pac.tgl_akta_cerai BETWEEN ? AND ?
			  AND pac.nomor_akta_cerai IS NOT NULL
			ORDER BY pac.tgl_akta_cerai DESC, p.nomor_perkara";
			
		$query = $this->db->query($sql, array($tanggal_mulai, $tanggal_akhir));
		return $query->result();
	}
	
	public function get_summary_statistics($lap_tahun, $lap_bulan, $jenis_laporan = 'bulanan')
	{
		$where_clause = "";
		$params = array();
		
		switch ($jenis_laporan) {
			case 'tahunan':
				$where_clause = "YEAR(pac.tgl_akta_cerai) = ?";
				$params = array($lap_tahun);
				break;
			default: // bulanan
				$where_clause = "YEAR(pac.tgl_akta_cerai) = ? AND MONTH(pac.tgl_akta_cerai) = ?";
				$params = array($lap_tahun, $lap_bulan);
				break;
		}
		
		$sql = "SELECT 
				COUNT(*) as total_akta_cerai,
				SUM(CASE WHEN pac.jenis_cerai = 'Cerai Talak' THEN 1 ELSE 0 END) as cerai_talak,
				SUM(CASE WHEN pac.jenis_cerai = 'Cerai Gugat' THEN 1 ELSE 0 END) as cerai_gugat,
				SUM(CASE WHEN pac.tgl_penyerahan_akta_cerai IS NOT NULL THEN 1 ELSE 0 END) as sudah_diserahkan,
				SUM(CASE WHEN pac.tgl_penyerahan_akta_cerai IS NULL THEN 1 ELSE 0 END) as belum_diserahkan
			FROM perkara_akta_cerai pac
			INNER JOIN perkara p ON pac.perkara_id = p.perkara_id
			WHERE {$where_clause}
			  AND pac.nomor_akta_cerai IS NOT NULL";
			
		$query = $this->db->query($sql, $params);
		return $query->row();
	}
	
	public function get_monthly_summary($tahun)
	{
		$sql = "SELECT 
				MONTH(pac.tgl_akta_cerai) as bulan,
				MONTHNAME(pac.tgl_akta_cerai) as nama_bulan,
				COUNT(*) as jumlah
			FROM perkara_akta_cerai pac
			INNER JOIN perkara p ON pac.perkara_id = p.perkara_id
			WHERE YEAR(pac.tgl_akta_cerai) = ?
			  AND pac.nomor_akta_cerai IS NOT NULL
			GROUP BY MONTH(pac.tgl_akta_cerai)
			ORDER BY MONTH(pac.tgl_akta_cerai)";
			
		$query = $this->db->query($sql, array($tahun));
		return $query->result();
	}
}
