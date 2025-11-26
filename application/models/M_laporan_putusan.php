<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_laporan_putusan extends CI_Model
{

    // Get laporan putusan bulanan
    public function get_laporan_putusan_bulanan($lap_tahun, $lap_bulan, $status_putusan = 'semua', $wilayah = 'Semua', $jenis_perkara = 'semua')
    {
        $where_wilayah = $this->_get_wilayah_condition($wilayah);
        $where_status = $this->_get_status_condition($status_putusan);
        $where_jenis = $this->_get_jenis_perkara_condition($jenis_perkara);

        $sql = "SELECT 
				p.nomor_perkara,
				p.jenis_perkara_nama,
				p.pihak1_text AS pihak1,
				p.pihak2_text AS pihak2,
				DATE_FORMAT(pp.tanggal_putusan, '%d-%m-%Y') AS tanggal_putusan,
				pp.status_putusan_nama,
				LEFT(pp.amar_putusan, 400) AS ringkasan_amar,
				DATEDIFF(CURDATE(), pp.tanggal_putusan) AS hari_sejak_putusan
			FROM perkara p
			JOIN perkara_putusan pp ON pp.perkara_id = p.perkara_id
			LEFT JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id
			WHERE p.jenis_perkara_nama IS NOT NULL
				AND YEAR(pp.tanggal_putusan) = ?
				AND MONTH(pp.tanggal_putusan) = ?
				$where_status
				$where_wilayah
				$where_jenis
			ORDER BY pp.tanggal_putusan DESC";

        $query = $this->db->query($sql, array($lap_tahun, $lap_bulan));
        return $query->result();
    }

    // Get laporan putusan tahunan
    public function get_laporan_putusan_tahunan($lap_tahun, $status_putusan = 'semua', $wilayah = 'Semua', $jenis_perkara = 'semua')
    {
        $where_wilayah = $this->_get_wilayah_condition($wilayah);
        $where_status = $this->_get_status_condition($status_putusan);
        $where_jenis = $this->_get_jenis_perkara_condition($jenis_perkara);

        $sql = "SELECT 
				p.nomor_perkara,
				p.jenis_perkara_nama,
				p.pihak1_text AS pihak1,
				p.pihak2_text AS pihak2,
				DATE_FORMAT(pp.tanggal_putusan, '%d-%m-%Y') AS tanggal_putusan,
				pp.status_putusan_nama,
				LEFT(pp.amar_putusan, 400) AS ringkasan_amar,
				DATEDIFF(CURDATE(), pp.tanggal_putusan) AS hari_sejak_putusan
			FROM perkara p
			JOIN perkara_putusan pp ON pp.perkara_id = p.perkara_id
			LEFT JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id
			WHERE p.jenis_perkara_nama IS NOT NULL
				AND YEAR(pp.tanggal_putusan) = ?
				$where_status
				$where_wilayah
				$where_jenis
			ORDER BY pp.tanggal_putusan DESC";

        $query = $this->db->query($sql, array($lap_tahun));
        return $query->result();
    }

    // Get laporan putusan custom date range
    public function get_laporan_putusan_custom($tanggal_mulai, $tanggal_akhir, $status_putusan = 'semua', $wilayah = 'Semua', $jenis_perkara = 'semua')
    {
        $where_wilayah = $this->_get_wilayah_condition($wilayah);
        $where_status = $this->_get_status_condition($status_putusan);
        $where_jenis = $this->_get_jenis_perkara_condition($jenis_perkara);

        $sql = "SELECT 
				p.nomor_perkara,
				p.jenis_perkara_nama,
				p.pihak1_text AS pihak1,
				p.pihak2_text AS pihak2,
				DATE_FORMAT(pp.tanggal_putusan, '%d-%m-%Y') AS tanggal_putusan,
				pp.status_putusan_nama,
				LEFT(pp.amar_putusan, 400) AS ringkasan_amar,
				DATEDIFF(CURDATE(), pp.tanggal_putusan) AS hari_sejak_putusan
			FROM perkara p
			JOIN perkara_putusan pp ON pp.perkara_id = p.perkara_id
			LEFT JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id
			WHERE p.jenis_perkara_nama IS NOT NULL
				AND pp.tanggal_putusan BETWEEN ? AND ?
				$where_status
				$where_wilayah
				$where_jenis
			ORDER BY pp.tanggal_putusan DESC";

        $query = $this->db->query($sql, array($tanggal_mulai, $tanggal_akhir));
        return $query->result();
    }

    // Get summary putusan bulanan
    public function get_summary_putusan_bulanan($lap_tahun, $lap_bulan, $wilayah = 'Semua', $jenis_perkara = 'semua')
    {
        $where_wilayah = $this->_get_wilayah_condition($wilayah);
        $where_jenis = $this->_get_jenis_perkara_condition($jenis_perkara);

        $sql = "SELECT 
				COUNT(*) as total_putusan,
				SUM(CASE WHEN pp.status_putusan_nama LIKE '%Dikabulkan%' 
					OR LOWER(pp.amar_putusan) LIKE '%dikabulkan%'
					OR LOWER(pp.amar_putusan) LIKE '%mengabulkan%' THEN 1 ELSE 0 END) as dikabulkan,
				SUM(CASE WHEN pp.status_putusan_nama LIKE '%Ditolak%'
					OR LOWER(pp.amar_putusan) LIKE '%ditolak%'
					OR LOWER(pp.amar_putusan) LIKE '%menolak%' THEN 1 ELSE 0 END) as ditolak,
				SUM(CASE WHEN pp.status_putusan_nama LIKE '%Tidak Dapat Diterima%'
					OR pp.status_putusan_nama LIKE '%Putusan NO%'
					OR LOWER(pp.amar_putusan) LIKE '%tidak dapat diterima%' THEN 1 ELSE 0 END) as tidak_dapat_diterima,
				SUM(CASE WHEN pp.status_putusan_nama LIKE '%Dicabut%'
					OR LOWER(pp.amar_putusan) LIKE '%dicabut%' THEN 1 ELSE 0 END) as dicabut,
				SUM(CASE WHEN pp.status_putusan_nama LIKE '%Gugur%'
					OR pp.status_putusan_nama LIKE '%Digugurkan%'
					OR LOWER(pp.amar_putusan) LIKE '%gugur%' THEN 1 ELSE 0 END) as digugurkan
			FROM perkara p
			JOIN perkara_putusan pp ON pp.perkara_id = p.perkara_id
			LEFT JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id
			WHERE p.jenis_perkara_nama IS NOT NULL
				AND YEAR(pp.tanggal_putusan) = ?
				AND MONTH(pp.tanggal_putusan) = ?
				$where_wilayah
				$where_jenis";

        $query = $this->db->query($sql, array($lap_tahun, $lap_bulan));
        return $query->row();
    }

    // Get summary putusan tahunan
    public function get_summary_putusan_tahunan($lap_tahun, $wilayah = 'Semua', $jenis_perkara = 'semua')
    {
        $where_wilayah = $this->_get_wilayah_condition($wilayah);
        $where_jenis = $this->_get_jenis_perkara_condition($jenis_perkara);

        $sql = "SELECT 
				COUNT(*) as total_putusan,
				SUM(CASE WHEN pp.status_putusan_nama LIKE '%Dikabulkan%' 
					OR LOWER(pp.amar_putusan) LIKE '%dikabulkan%'
					OR LOWER(pp.amar_putusan) LIKE '%mengabulkan%' THEN 1 ELSE 0 END) as dikabulkan,
				SUM(CASE WHEN pp.status_putusan_nama LIKE '%Ditolak%'
					OR LOWER(pp.amar_putusan) LIKE '%ditolak%'
					OR LOWER(pp.amar_putusan) LIKE '%menolak%' THEN 1 ELSE 0 END) as ditolak,
				SUM(CASE WHEN pp.status_putusan_nama LIKE '%Tidak Dapat Diterima%'
					OR pp.status_putusan_nama LIKE '%Putusan NO%'
					OR LOWER(pp.amar_putusan) LIKE '%tidak dapat diterima%' THEN 1 ELSE 0 END) as tidak_dapat_diterima,
				SUM(CASE WHEN pp.status_putusan_nama LIKE '%Dicabut%'
					OR LOWER(pp.amar_putusan) LIKE '%dicabut%' THEN 1 ELSE 0 END) as dicabut,
				SUM(CASE WHEN pp.status_putusan_nama LIKE '%Gugur%'
					OR pp.status_putusan_nama LIKE '%Digugurkan%'
					OR LOWER(pp.amar_putusan) LIKE '%gugur%' THEN 1 ELSE 0 END) as digugurkan
			FROM perkara p
			JOIN perkara_putusan pp ON pp.perkara_id = p.perkara_id
			LEFT JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id
			WHERE p.jenis_perkara_nama IS NOT NULL
				AND YEAR(pp.tanggal_putusan) = ?
				$where_wilayah
				$where_jenis";

        $query = $this->db->query($sql, array($lap_tahun));
        return $query->row();
    }

    // Get summary putusan custom
    public function get_summary_putusan_custom($tanggal_mulai, $tanggal_akhir, $wilayah = 'Semua', $jenis_perkara = 'semua')
    {
        $where_wilayah = $this->_get_wilayah_condition($wilayah);
        $where_jenis = $this->_get_jenis_perkara_condition($jenis_perkara);

        $sql = "SELECT 
				COUNT(*) as total_putusan,
				SUM(CASE WHEN pp.status_putusan_nama LIKE '%Dikabulkan%' 
					OR LOWER(pp.amar_putusan) LIKE '%dikabulkan%'
					OR LOWER(pp.amar_putusan) LIKE '%mengabulkan%' THEN 1 ELSE 0 END) as dikabulkan,
				SUM(CASE WHEN pp.status_putusan_nama LIKE '%Ditolak%'
					OR LOWER(pp.amar_putusan) LIKE '%ditolak%'
					OR LOWER(pp.amar_putusan) LIKE '%menolak%' THEN 1 ELSE 0 END) as ditolak,
				SUM(CASE WHEN pp.status_putusan_nama LIKE '%Tidak Dapat Diterima%'
					OR pp.status_putusan_nama LIKE '%Putusan NO%'
					OR LOWER(pp.amar_putusan) LIKE '%tidak dapat diterima%' THEN 1 ELSE 0 END) as tidak_dapat_diterima,
				SUM(CASE WHEN pp.status_putusan_nama LIKE '%Dicabut%'
					OR LOWER(pp.amar_putusan) LIKE '%dicabut%' THEN 1 ELSE 0 END) as dicabut,
				SUM(CASE WHEN pp.status_putusan_nama LIKE '%Gugur%'
					OR pp.status_putusan_nama LIKE '%Digugurkan%'
					OR LOWER(pp.amar_putusan) LIKE '%gugur%' THEN 1 ELSE 0 END) as digugurkan
			FROM perkara p
			JOIN perkara_putusan pp ON pp.perkara_id = p.perkara_id
			LEFT JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id
			WHERE p.jenis_perkara_nama IS NOT NULL
				AND pp.tanggal_putusan BETWEEN ? AND ?
				$where_wilayah
				$where_jenis";

        $query = $this->db->query($sql, array($tanggal_mulai, $tanggal_akhir));
        return $query->row();
    }

    // Get daftar jenis perkara yang tersedia
    public function get_jenis_perkara_list()
    {
        $sql = "SELECT DISTINCT p.jenis_perkara_nama 
                FROM perkara p 
                JOIN perkara_putusan pp ON pp.perkara_id = p.perkara_id
                WHERE p.jenis_perkara_nama IS NOT NULL 
                  AND p.jenis_perkara_nama != ''
                ORDER BY p.jenis_perkara_nama";

        $query = $this->db->query($sql);
        return $query->result();
    }

    // Private helper methods
    private function _get_wilayah_condition($wilayah)
    {
        if ($wilayah === 'Semua') return '';

        if ($wilayah === 'HSU') {
            return " AND (pp1.alamat LIKE '%Hulu Sungai Utara%' OR pp1.alamat LIKE '%HSU%' 
					   OR pp1.alamat LIKE '%Amuntai%' OR pp1.alamat LIKE '%Haur Gading%' 
					   OR pp1.alamat LIKE '%Banjang%' OR pp1.alamat LIKE '%Paminggir%' 
					   OR pp1.alamat LIKE '%Babirik%' OR pp1.alamat LIKE '%Sungai Pandan%' 
					   OR pp1.alamat LIKE '%Danau Panggang%' OR pp1.alamat LIKE '%Sungai Tabukan%')";
        } else if ($wilayah === 'Balangan') {
            return " AND (pp1.alamat LIKE '%Balangan%' OR pp1.alamat LIKE '%Paringin%' 
					   OR pp1.alamat LIKE '%Awayan%' OR pp1.alamat LIKE '%Tebing Tinggi%' 
					   OR pp1.alamat LIKE '%Juai%' OR pp1.alamat LIKE '%Lampihong%' 
					   OR pp1.alamat LIKE '%Halong%' OR pp1.alamat LIKE '%Batumandi%')";
        }

        return '';
    }

    private function _get_jenis_perkara_condition($jenis_perkara)
    {
        if ($jenis_perkara === 'semua' || empty($jenis_perkara)) return '';

        return " AND p.jenis_perkara_nama = '" . $this->db->escape_str($jenis_perkara) . "'";
    }

    private function _get_status_condition($status_putusan)
    {
        switch ($status_putusan) {
            case 'dikabulkan':
                return " AND (pp.status_putusan_nama LIKE '%Dikabulkan%' 
						OR LOWER(pp.amar_putusan) LIKE '%dikabulkan%'
						OR LOWER(pp.amar_putusan) LIKE '%mengabulkan%')";

            case 'ditolak':
                return " AND (pp.status_putusan_nama LIKE '%Ditolak%'
						OR LOWER(pp.amar_putusan) LIKE '%ditolak%'
						OR LOWER(pp.amar_putusan) LIKE '%menolak%')";

            case 'tidak_dapat_diterima':
                return " AND (pp.status_putusan_nama LIKE '%Tidak Dapat Diterima%'
						OR pp.status_putusan_nama LIKE '%Putusan NO%'
						OR LOWER(pp.amar_putusan) LIKE '%tidak dapat diterima%')";

            case 'dicabut':
                return " AND (pp.status_putusan_nama LIKE '%Dicabut%'
						OR LOWER(pp.amar_putusan) LIKE '%dicabut%')";

            case 'digugurkan':
                return " AND (pp.status_putusan_nama LIKE '%Gugur%'
						OR pp.status_putusan_nama LIKE '%Digugurkan%'
						OR LOWER(pp.amar_putusan) LIKE '%gugur%')";

            default:
                return ''; // semua status
        }
    }
}
