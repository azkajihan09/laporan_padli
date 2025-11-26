<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_penyerahan_akta_cerai extends CI_Model
{

	public function get_penyerahan_akta_cerai($lap_tahun, $lap_bulan, $wilayah = 'Semua')
	{
		$where_wilayah = '';
		if ($wilayah !== 'Semua') {
			if ($wilayah === 'HSU') {
				$where_wilayah = " AND (pp1.alamat LIKE '%Hulu Sungai Utara%' OR pp1.alamat LIKE '%HSU%' 
								   OR pp1.alamat LIKE '%Amuntai%' OR pp1.alamat LIKE '%Haur Gading%' 
								   OR pp1.alamat LIKE '%Banjang%' OR pp1.alamat LIKE '%Paminggir%' 
								   OR pp1.alamat LIKE '%Babirik%' OR pp1.alamat LIKE '%Sungai Pandan%' 
								   OR pp1.alamat LIKE '%Danau Panggang%' OR pp1.alamat LIKE '%Sungai Tabukan%')";
			} else if ($wilayah === 'Balangan') {
				$where_wilayah = " AND (pp1.alamat LIKE '%Balangan%' OR pp1.alamat LIKE '%Paringin%' 
								   OR pp1.alamat LIKE '%Awayan%' OR pp1.alamat LIKE '%Tebing Tinggi%' 
								   OR pp1.alamat LIKE '%Juai%' OR pp1.alamat LIKE '%Lampihong%' 
								   OR pp1.alamat LIKE '%Halong%' OR pp1.alamat LIKE '%Batumandi%')";
			}
		}

		$sql = "SELECT 
				p.nomor_perkara,
				p.jenis_perkara_nama,
				pac.nomor_akta_cerai,
				pac.tgl_akta_cerai,
				pp.tanggal_putusan,
				pit.tgl_ikrar_talak,
				pp.tanggal_bht,
				pac.tgl_penyerahan_akta_cerai,
				pac.tgl_penyerahan_akta_cerai_pihak2,
				COALESCE(p.pihak1_text, ph1.nama, 'Tidak Ada Data') as nama_penggugat,
				COALESCE(p.pihak2_text, ph2.nama, 'Tidak Ada Data') as nama_tergugat
			FROM perkara_akta_cerai pac
			INNER JOIN perkara p ON pac.perkara_id = p.perkara_id
			LEFT JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
			LEFT JOIN perkara_ikrar_talak pit ON p.perkara_id = pit.perkara_id
			LEFT JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id
			LEFT JOIN pihak ph1 ON pp1.pihak_id = ph1.id
			LEFT JOIN perkara_pihak2 pp2 ON p.perkara_id = pp2.perkara_id
			LEFT JOIN pihak ph2 ON pp2.pihak_id = ph2.id
			WHERE (
				(YEAR(pac.tgl_penyerahan_akta_cerai) = ? AND MONTH(pac.tgl_penyerahan_akta_cerai) = ?) OR
				(YEAR(pac.tgl_penyerahan_akta_cerai_pihak2) = ? AND MONTH(pac.tgl_penyerahan_akta_cerai_pihak2) = ?)
			) AND pac.nomor_akta_cerai IS NOT NULL $where_wilayah
			ORDER BY 
				COALESCE(pac.tgl_penyerahan_akta_cerai, pac.tgl_penyerahan_akta_cerai_pihak2) DESC,
				p.nomor_perkara";

		$query = $this->db->query($sql, array($lap_tahun, $lap_bulan, $lap_tahun, $lap_bulan));
		return $query->result();
	}

	public function get_penyerahan_akta_cerai_tahunan($lap_tahun, $wilayah = 'Semua')
	{
		$where_wilayah = '';
		if ($wilayah !== 'Semua') {
			if ($wilayah === 'HSU') {
				$where_wilayah = " AND (pp1.alamat LIKE '%Hulu Sungai Utara%' OR pp1.alamat LIKE '%HSU%' 
								   OR pp1.alamat LIKE '%Amuntai%' OR pp1.alamat LIKE '%Haur Gading%' 
								   OR pp1.alamat LIKE '%Banjang%' OR pp1.alamat LIKE '%Paminggir%' 
								   OR pp1.alamat LIKE '%Babirik%' OR pp1.alamat LIKE '%Sungai Pandan%' 
								   OR pp1.alamat LIKE '%Danau Panggang%' OR pp1.alamat LIKE '%Sungai Tabukan%')";
			} else if ($wilayah === 'Balangan') {
				$where_wilayah = " AND (pp1.alamat LIKE '%Balangan%' OR pp1.alamat LIKE '%Paringin%' 
								   OR pp1.alamat LIKE '%Awayan%' OR pp1.alamat LIKE '%Tebing Tinggi%' 
								   OR pp1.alamat LIKE '%Juai%' OR pp1.alamat LIKE '%Lampihong%' 
								   OR pp1.alamat LIKE '%Halong%' OR pp1.alamat LIKE '%Batumandi%')";
			}
		}

		$sql = "SELECT 
				p.nomor_perkara,
				p.jenis_perkara_nama,
				pac.nomor_akta_cerai,
				pac.tgl_akta_cerai,
				pp.tanggal_putusan,
				pit.tgl_ikrar_talak,
				pp.tanggal_bht,
				pac.tgl_penyerahan_akta_cerai,
				pac.tgl_penyerahan_akta_cerai_pihak2,
				COALESCE(p.pihak1_text, ph1.nama, 'Tidak Ada Data') as nama_penggugat,
				COALESCE(p.pihak2_text, ph2.nama, 'Tidak Ada Data') as nama_tergugat
			FROM perkara_akta_cerai pac
			INNER JOIN perkara p ON pac.perkara_id = p.perkara_id
			LEFT JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
			LEFT JOIN perkara_ikrar_talak pit ON p.perkara_id = pit.perkara_id
			LEFT JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id
			LEFT JOIN pihak ph1 ON pp1.pihak_id = ph1.id
			LEFT JOIN perkara_pihak2 pp2 ON p.perkara_id = pp2.perkara_id
			LEFT JOIN pihak ph2 ON pp2.pihak_id = ph2.id
			WHERE (
				(YEAR(pac.tgl_penyerahan_akta_cerai) = ?) OR
				(YEAR(pac.tgl_penyerahan_akta_cerai_pihak2) = ?)
			) AND pac.nomor_akta_cerai IS NOT NULL $where_wilayah
			ORDER BY 
				COALESCE(pac.tgl_penyerahan_akta_cerai, pac.tgl_penyerahan_akta_cerai_pihak2) DESC,
				p.nomor_perkara";

		$query = $this->db->query($sql, array($lap_tahun, $lap_tahun));
		return $query->result();
	}

	public function get_penyerahan_akta_cerai_custom($tanggal_mulai, $tanggal_akhir, $wilayah = 'Semua')
	{
		$where_wilayah = '';
		if ($wilayah !== 'Semua') {
			if ($wilayah === 'HSU') {
				$where_wilayah = " AND (pp1.alamat LIKE '%Hulu Sungai Utara%' OR pp1.alamat LIKE '%HSU%' 
								   OR pp1.alamat LIKE '%Amuntai%' OR pp1.alamat LIKE '%Haur Gading%' 
								   OR pp1.alamat LIKE '%Banjang%' OR pp1.alamat LIKE '%Paminggir%' 
								   OR pp1.alamat LIKE '%Babirik%' OR pp1.alamat LIKE '%Sungai Pandan%' 
								   OR pp1.alamat LIKE '%Danau Panggang%' OR pp1.alamat LIKE '%Sungai Tabukan%')";
			} else if ($wilayah === 'Balangan') {
				$where_wilayah = " AND (pp1.alamat LIKE '%Balangan%' OR pp1.alamat LIKE '%Paringin%' 
								   OR pp1.alamat LIKE '%Awayan%' OR pp1.alamat LIKE '%Tebing Tinggi%' 
								   OR pp1.alamat LIKE '%Juai%' OR pp1.alamat LIKE '%Lampihong%' 
								   OR pp1.alamat LIKE '%Halong%' OR pp1.alamat LIKE '%Batumandi%')";
			}
		}

		$sql = "SELECT 
				p.nomor_perkara,
				p.jenis_perkara_nama,
				pac.nomor_akta_cerai,
				pac.tgl_akta_cerai,
				pp.tanggal_putusan,
				pit.tgl_ikrar_talak,
				pp.tanggal_bht,
				pac.tgl_penyerahan_akta_cerai,
				pac.tgl_penyerahan_akta_cerai_pihak2,
				COALESCE(p.pihak1_text, ph1.nama, 'Tidak Ada Data') as nama_penggugat,
				COALESCE(p.pihak2_text, ph2.nama, 'Tidak Ada Data') as nama_tergugat
			FROM perkara_akta_cerai pac
			INNER JOIN perkara p ON pac.perkara_id = p.perkara_id
			LEFT JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
			LEFT JOIN perkara_ikrar_talak pit ON p.perkara_id = pit.perkara_id
			LEFT JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id
			LEFT JOIN pihak ph1 ON pp1.pihak_id = ph1.id
			LEFT JOIN perkara_pihak2 pp2 ON p.perkara_id = pp2.perkara_id
			LEFT JOIN pihak ph2 ON pp2.pihak_id = ph2.id
			WHERE (
				(pac.tgl_penyerahan_akta_cerai BETWEEN ? AND ?) OR
				(pac.tgl_penyerahan_akta_cerai_pihak2 BETWEEN ? AND ?)
			) AND pac.nomor_akta_cerai IS NOT NULL $where_wilayah
			ORDER BY 
				COALESCE(pac.tgl_penyerahan_akta_cerai, pac.tgl_penyerahan_akta_cerai_pihak2) DESC,
				p.nomor_perkara";

		$query = $this->db->query($sql, array($tanggal_mulai, $tanggal_akhir, $tanggal_mulai, $tanggal_akhir));
		return $query->result();
	}

	public function get_summary_penyerahan($lap_tahun, $lap_bulan, $wilayah = 'Semua')
	{
		$where_wilayah = '';
		if ($wilayah !== 'Semua') {
			if ($wilayah === 'HSU') {
				$where_wilayah = " AND (pp1.alamat LIKE '%Hulu Sungai Utara%' OR pp1.alamat LIKE '%HSU%' 
								   OR pp1.alamat LIKE '%Amuntai%' OR pp1.alamat LIKE '%Haur Gading%' 
								   OR pp1.alamat LIKE '%Banjang%' OR pp1.alamat LIKE '%Paminggir%' 
								   OR pp1.alamat LIKE '%Babirik%' OR pp1.alamat LIKE '%Sungai Pandan%' 
								   OR pp1.alamat LIKE '%Danau Panggang%' OR pp1.alamat LIKE '%Sungai Tabukan%')";
			} else if ($wilayah === 'Balangan') {
				$where_wilayah = " AND (pp1.alamat LIKE '%Balangan%' OR pp1.alamat LIKE '%Paringin%' 
								   OR pp1.alamat LIKE '%Awayan%' OR pp1.alamat LIKE '%Tebing Tinggi%' 
								   OR pp1.alamat LIKE '%Juai%' OR pp1.alamat LIKE '%Lampihong%' 
								   OR pp1.alamat LIKE '%Halong%' OR pp1.alamat LIKE '%Batumandi%')";
			}
		}

		$sql = "SELECT 
				COUNT(*) as total_akta,
				SUM(CASE WHEN pac.tgl_penyerahan_akta_cerai IS NOT NULL THEN 1 ELSE 0 END) as diserahkan_pihak1,
				SUM(CASE WHEN pac.tgl_penyerahan_akta_cerai_pihak2 IS NOT NULL THEN 1 ELSE 0 END) as diserahkan_pihak2,
				SUM(CASE WHEN p.jenis_perkara_nama LIKE '%Cerai Talak%' THEN 1 ELSE 0 END) as cerai_talak,
				SUM(CASE WHEN p.jenis_perkara_nama LIKE '%Cerai Gugat%' THEN 1 ELSE 0 END) as cerai_gugat,
				SUM(CASE WHEN pac.tgl_penyerahan_akta_cerai IS NOT NULL AND pac.tgl_penyerahan_akta_cerai_pihak2 IS NOT NULL THEN 1 ELSE 0 END) as kedua_pihak_selesai
			FROM perkara_akta_cerai pac
			INNER JOIN perkara p ON pac.perkara_id = p.perkara_id
			LEFT JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id
			WHERE (
				(YEAR(pac.tgl_penyerahan_akta_cerai) = ? AND MONTH(pac.tgl_penyerahan_akta_cerai) = ?) OR
				(YEAR(pac.tgl_penyerahan_akta_cerai_pihak2) = ? AND MONTH(pac.tgl_penyerahan_akta_cerai_pihak2) = ?)
			) AND pac.nomor_akta_cerai IS NOT NULL $where_wilayah";

		$query = $this->db->query($sql, array($lap_tahun, $lap_bulan, $lap_tahun, $lap_bulan));
		return $query->row();
	}

	public function get_summary_penyerahan_tahunan($lap_tahun, $wilayah = 'Semua')
	{
		$where_wilayah = '';
		if ($wilayah !== 'Semua') {
			if ($wilayah === 'HSU') {
				$where_wilayah = " AND (pp1.alamat LIKE '%Hulu Sungai Utara%' OR pp1.alamat LIKE '%HSU%' 
								   OR pp1.alamat LIKE '%Amuntai%' OR pp1.alamat LIKE '%Haur Gading%' 
								   OR pp1.alamat LIKE '%Banjang%' OR pp1.alamat LIKE '%Paminggir%' 
								   OR pp1.alamat LIKE '%Babirik%' OR pp1.alamat LIKE '%Sungai Pandan%' 
								   OR pp1.alamat LIKE '%Danau Panggang%' OR pp1.alamat LIKE '%Sungai Tabukan%')";
			} else if ($wilayah === 'Balangan') {
				$where_wilayah = " AND (pp1.alamat LIKE '%Balangan%' OR pp1.alamat LIKE '%Paringin%' 
								   OR pp1.alamat LIKE '%Awayan%' OR pp1.alamat LIKE '%Tebing Tinggi%' 
								   OR pp1.alamat LIKE '%Juai%' OR pp1.alamat LIKE '%Lampihong%' 
								   OR pp1.alamat LIKE '%Halong%' OR pp1.alamat LIKE '%Batumandi%')";
			}
		}

		$sql = "SELECT 
				COUNT(*) as total_akta,
				SUM(CASE WHEN pac.tgl_penyerahan_akta_cerai IS NOT NULL THEN 1 ELSE 0 END) as diserahkan_pihak1,
				SUM(CASE WHEN pac.tgl_penyerahan_akta_cerai_pihak2 IS NOT NULL THEN 1 ELSE 0 END) as diserahkan_pihak2,
				SUM(CASE WHEN p.jenis_perkara_nama LIKE '%Cerai Talak%' THEN 1 ELSE 0 END) as cerai_talak,
				SUM(CASE WHEN p.jenis_perkara_nama LIKE '%Cerai Gugat%' THEN 1 ELSE 0 END) as cerai_gugat,
				SUM(CASE WHEN pac.tgl_penyerahan_akta_cerai IS NOT NULL AND pac.tgl_penyerahan_akta_cerai_pihak2 IS NOT NULL THEN 1 ELSE 0 END) as kedua_pihak_selesai
			FROM perkara_akta_cerai pac
			INNER JOIN perkara p ON pac.perkara_id = p.perkara_id
			LEFT JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id
			WHERE (
				(YEAR(pac.tgl_penyerahan_akta_cerai) = ?) OR
				(YEAR(pac.tgl_penyerahan_akta_cerai_pihak2) = ?)
			) AND pac.nomor_akta_cerai IS NOT NULL $where_wilayah";

		$query = $this->db->query($sql, array($lap_tahun, $lap_tahun));
		return $query->row();
	}

	public function get_summary_penyerahan_custom($tanggal_mulai, $tanggal_akhir, $wilayah = 'Semua')
	{
		$where_wilayah = '';
		if ($wilayah !== 'Semua') {
			if ($wilayah === 'HSU') {
				$where_wilayah = " AND (pp1.alamat LIKE '%Hulu Sungai Utara%' OR pp1.alamat LIKE '%HSU%' 
								   OR pp1.alamat LIKE '%Amuntai%' OR pp1.alamat LIKE '%Haur Gading%' 
								   OR pp1.alamat LIKE '%Banjang%' OR pp1.alamat LIKE '%Paminggir%' 
								   OR pp1.alamat LIKE '%Babirik%' OR pp1.alamat LIKE '%Sungai Pandan%' 
								   OR pp1.alamat LIKE '%Danau Panggang%' OR pp1.alamat LIKE '%Sungai Tabukan%')";
			} else if ($wilayah === 'Balangan') {
				$where_wilayah = " AND (pp1.alamat LIKE '%Balangan%' OR pp1.alamat LIKE '%Paringin%' 
								   OR pp1.alamat LIKE '%Awayan%' OR pp1.alamat LIKE '%Tebing Tinggi%' 
								   OR pp1.alamat LIKE '%Juai%' OR pp1.alamat LIKE '%Lampihong%' 
								   OR pp1.alamat LIKE '%Halong%' OR pp1.alamat LIKE '%Batumandi%')";
			}
		}

		$sql = "SELECT 
				COUNT(*) as total_akta,
				SUM(CASE WHEN pac.tgl_penyerahan_akta_cerai IS NOT NULL THEN 1 ELSE 0 END) as diserahkan_pihak1,
				SUM(CASE WHEN pac.tgl_penyerahan_akta_cerai_pihak2 IS NOT NULL THEN 1 ELSE 0 END) as diserahkan_pihak2,
				SUM(CASE WHEN p.jenis_perkara_nama LIKE '%Cerai Talak%' THEN 1 ELSE 0 END) as cerai_talak,
				SUM(CASE WHEN p.jenis_perkara_nama LIKE '%Cerai Gugat%' THEN 1 ELSE 0 END) as cerai_gugat,
				SUM(CASE WHEN pac.tgl_penyerahan_akta_cerai IS NOT NULL AND pac.tgl_penyerahan_akta_cerai_pihak2 IS NOT NULL THEN 1 ELSE 0 END) as kedua_pihak_selesai
			FROM perkara_akta_cerai pac
			INNER JOIN perkara p ON pac.perkara_id = p.perkara_id
			LEFT JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id
			WHERE (
				(pac.tgl_penyerahan_akta_cerai BETWEEN ? AND ?) OR
				(pac.tgl_penyerahan_akta_cerai_pihak2 BETWEEN ? AND ?)
			) AND pac.nomor_akta_cerai IS NOT NULL $where_wilayah";

		$query = $this->db->query($sql, array($tanggal_mulai, $tanggal_akhir, $tanggal_mulai, $tanggal_akhir));
		return $query->row();
	}
}
