
<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_data_permohonan extends CI_Model
{
	private function get_kecamatan_list($wilayah)
	{
		if ($wilayah == 'HSU') {
			return [
				'Danau Panggang',
				'Babirik',
				'Sungai Pandan',
				'Amuntai Selatan',
				'Amuntai Tengah',
				'Amuntai Utara',
				'Banjang',
				'Haur Gading',
				'Paminggir',
				'Sungai Tabukan'
			];
		} elseif ($wilayah == 'Balangan') {
			return [
				'Paringin',
				'Paringin Selatan',
				'Lampihong',
				'Batumandi',
				'Awayan',
				'Halong',
				'Tebing Tinggi',
				'Juai'
			];
		} else { // Semua wilayah
			return [
				// HSU
				'Danau Panggang',
				'Babirik',
				'Sungai Pandan',
				'Amuntai Selatan',
				'Amuntai Tengah',
				'Amuntai Utara',
				'Banjang',
				'Haur Gading',
				'Paminggir',
				'Sungai Tabukan',
				// Balangan
				'Paringin',
				'Paringin Selatan',
				'Lampihong',
				'Batumandi',
				'Awayan',
				'Halong',
				'Tebing Tinggi',
				'Juai'
			];
		}
	}

	private function build_case_when($wilayah, $fallback)
	{
		$kecamatan_list = $this->get_kecamatan_list($wilayah);
		$case_when = "CASE ";

		foreach ($kecamatan_list as $kecamatan) {
			$case_when .= "WHEN pp1.alamat LIKE '%{$kecamatan}%' THEN '{$kecamatan}' ";
		}

		$case_when .= "ELSE '{$fallback}' END";
		return $case_when;
	}

	public function data_permohonan($lap_bulan, $lap_tahun, $jenis_perkara, $wilayah = 'Semua')
	{
		$kecamatan_list = $this->get_kecamatan_list($wilayah);
		$locations_union = "";

		foreach ($kecamatan_list as $index => $kecamatan) {
			if ($index > 0) $locations_union .= " UNION ALL ";
			$locations_union .= "SELECT '{$kecamatan}' AS KECAMATAN";
		}

		$fallback = ($wilayah == 'HSU') ? 'HULU SUNGAI UTARA' : (($wilayah == 'Balangan') ? 'BALANGAN' : 'LAINNYA');
		$case_when = $this->build_case_when($wilayah, $fallback);
		$kecamatan_filter = "'" . implode("', '", $kecamatan_list) . "'";

		$sql = "SELECT 
			locations.KECAMATAN,
			COALESCE(SUM(CASE WHEN subquery.date_type = 'tanggal_pendaftaran' THEN subquery.COUNT ELSE 0 END), 0) AS PERKARA_MASUK,
			COALESCE(SUM(CASE WHEN subquery.date_type = 'tanggal_putusan' THEN subquery.COUNT ELSE 0 END), 0) AS PERKARA_PUTUS
		FROM ({$locations_union}) AS locations
		LEFT JOIN (
			SELECT 
				{$case_when} AS KECAMATAN,
				'tanggal_pendaftaran' AS date_type, COUNT(*) AS COUNT
			FROM perkara p
			INNER JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id AND pp1.urutan = 1
			WHERE YEAR(p.tanggal_pendaftaran) = ? 
				AND MONTH(p.tanggal_pendaftaran) = ? 
				AND p.jenis_perkara_nama LIKE ?
			GROUP BY KECAMATAN
			UNION ALL
			SELECT 
				{$case_when} AS KECAMATAN,
				'tanggal_putusan' AS date_type, COUNT(*) AS COUNT
			FROM perkara p
			INNER JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id AND pp1.urutan = 1
			INNER JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
			WHERE YEAR(pp.tanggal_putusan) = ? 
				AND MONTH(pp.tanggal_putusan) = ? 
				AND p.jenis_perkara_nama LIKE ?
			GROUP BY KECAMATAN
		) AS subquery ON locations.KECAMATAN = subquery.KECAMATAN
		GROUP BY locations.KECAMATAN
		
		UNION ALL
		
		SELECT 
			'TOTAL' AS KECAMATAN,
			SUM(CASE WHEN date_type = 'tanggal_pendaftaran' THEN COUNT ELSE 0 END) AS PERKARA_MASUK,
			SUM(CASE WHEN date_type = 'tanggal_putusan' THEN COUNT ELSE 0 END) AS PERKARA_PUTUS
		FROM (
			SELECT 
				{$case_when} AS KECAMATAN,
				'tanggal_pendaftaran' AS date_type, COUNT(*) AS COUNT
			FROM perkara p
			INNER JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id AND pp1.urutan = 1
			WHERE YEAR(p.tanggal_pendaftaran) = ? 
				AND MONTH(p.tanggal_pendaftaran) = ? 
				AND p.jenis_perkara_nama LIKE ?
			GROUP BY KECAMATAN
			UNION ALL
			SELECT 
				{$case_when} AS KECAMATAN,
				'tanggal_putusan' AS date_type, COUNT(*) AS COUNT
			FROM perkara p
			INNER JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id AND pp1.urutan = 1
			INNER JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
			WHERE YEAR(pp.tanggal_putusan) = ? 
				AND MONTH(pp.tanggal_putusan) = ? 
				AND p.jenis_perkara_nama LIKE ?
			GROUP BY KECAMATAN
		) AS subquery
		WHERE KECAMATAN IN ({$kecamatan_filter})
		ORDER BY CASE WHEN KECAMATAN = 'TOTAL' THEN 1 ELSE 0 END, KECAMATAN";

		$like_pattern = '%' . $jenis_perkara . '%';
		$params = [
			$lap_tahun,
			$lap_bulan,
			$like_pattern,
			$lap_tahun,
			$lap_bulan,
			$like_pattern,
			$lap_tahun,
			$lap_bulan,
			$like_pattern,
			$lap_tahun,
			$lap_bulan,
			$like_pattern
		];

		$query = $this->db->query($sql, $params);
		return $query->result();
	}

	public function data_permohonan_tahunan($lap_tahun, $jenis_perkara, $wilayah = 'Semua')
	{
		$kecamatan_list = $this->get_kecamatan_list($wilayah);
		$locations_union = "";

		foreach ($kecamatan_list as $index => $kecamatan) {
			if ($index > 0) $locations_union .= " UNION ALL ";
			$locations_union .= "SELECT '{$kecamatan}' AS KECAMATAN";
		}

		$fallback = ($wilayah == 'HSU') ? 'HULU SUNGAI UTARA' : (($wilayah == 'Balangan') ? 'BALANGAN' : 'LAINNYA');
		$case_when = $this->build_case_when($wilayah, $fallback);
		$kecamatan_filter = "'" . implode("', '", $kecamatan_list) . "'";

		$sql = "SELECT 
			locations.KECAMATAN,
			COALESCE(SUM(CASE WHEN subquery.date_type = 'tanggal_pendaftaran' THEN subquery.COUNT ELSE 0 END), 0) AS PERKARA_MASUK,
			COALESCE(SUM(CASE WHEN subquery.date_type = 'tanggal_putusan' THEN subquery.COUNT ELSE 0 END), 0) AS PERKARA_PUTUS
		FROM ({$locations_union}) AS locations
		LEFT JOIN (
			SELECT 
				{$case_when} AS KECAMATAN,
				'tanggal_pendaftaran' AS date_type, COUNT(*) AS COUNT
			FROM perkara p
			INNER JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id AND pp1.urutan = 1
			WHERE YEAR(p.tanggal_pendaftaran) = ? 
				AND p.jenis_perkara_nama LIKE ?
			GROUP BY KECAMATAN
			UNION ALL
			SELECT 
				{$case_when} AS KECAMATAN,
				'tanggal_putusan' AS date_type, COUNT(*) AS COUNT
			FROM perkara p
			INNER JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id AND pp1.urutan = 1
			INNER JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
			WHERE YEAR(pp.tanggal_putusan) = ? 
				AND p.jenis_perkara_nama LIKE ?
			GROUP BY KECAMATAN
		) AS subquery ON locations.KECAMATAN = subquery.KECAMATAN
		GROUP BY locations.KECAMATAN
		
		UNION ALL
		
		SELECT 
			'TOTAL' AS KECAMATAN,
			SUM(CASE WHEN date_type = 'tanggal_pendaftaran' THEN COUNT ELSE 0 END) AS PERKARA_MASUK,
			SUM(CASE WHEN date_type = 'tanggal_putusan' THEN COUNT ELSE 0 END) AS PERKARA_PUTUS
		FROM (
			SELECT 
				{$case_when} AS KECAMATAN,
				'tanggal_pendaftaran' AS date_type, COUNT(*) AS COUNT
			FROM perkara p
			INNER JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id AND pp1.urutan = 1
			WHERE YEAR(p.tanggal_pendaftaran) = ? 
				AND p.jenis_perkara_nama LIKE ?
			GROUP BY KECAMATAN
			UNION ALL
			SELECT 
				{$case_when} AS KECAMATAN,
				'tanggal_putusan' AS date_type, COUNT(*) AS COUNT
			FROM perkara p
			INNER JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id AND pp1.urutan = 1
			INNER JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
			WHERE YEAR(pp.tanggal_putusan) = ? 
				AND p.jenis_perkara_nama LIKE ?
			GROUP BY KECAMATAN
		) AS subquery
		WHERE KECAMATAN IN ({$kecamatan_filter})
		ORDER BY CASE WHEN KECAMATAN = 'TOTAL' THEN 1 ELSE 0 END, KECAMATAN";

		$like_pattern = '%' . $jenis_perkara . '%';
		$params = [
			$lap_tahun,
			$like_pattern,
			$lap_tahun,
			$like_pattern,
			$lap_tahun,
			$like_pattern,
			$lap_tahun,
			$like_pattern
		];

		$query = $this->db->query($sql, $params);
		return $query->result();
	}

	public function data_permohonan_custom($tanggal_mulai, $tanggal_akhir, $jenis_perkara, $wilayah = 'Semua')
	{
		$kecamatan_list = $this->get_kecamatan_list($wilayah);
		$locations_union = "";

		foreach ($kecamatan_list as $index => $kecamatan) {
			if ($index > 0) $locations_union .= " UNION ALL ";
			$locations_union .= "SELECT '{$kecamatan}' AS KECAMATAN";
		}

		$fallback = ($wilayah == 'HSU') ? 'HULU SUNGAI UTARA' : (($wilayah == 'Balangan') ? 'BALANGAN' : 'LAINNYA');
		$case_when = $this->build_case_when($wilayah, $fallback);
		$kecamatan_filter = "'" . implode("', '", $kecamatan_list) . "'";

		$sql = "SELECT 
			locations.KECAMATAN,
			COALESCE(SUM(CASE WHEN subquery.date_type = 'tanggal_pendaftaran' THEN subquery.COUNT ELSE 0 END), 0) AS PERKARA_MASUK,
			COALESCE(SUM(CASE WHEN subquery.date_type = 'tanggal_putusan' THEN subquery.COUNT ELSE 0 END), 0) AS PERKARA_PUTUS
		FROM ({$locations_union}) AS locations
		LEFT JOIN (
			SELECT 
				{$case_when} AS KECAMATAN,
				'tanggal_pendaftaran' AS date_type, COUNT(*) AS COUNT
			FROM perkara p
			INNER JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id AND pp1.urutan = 1
			WHERE p.tanggal_pendaftaran BETWEEN ? AND ? 
				AND p.jenis_perkara_nama LIKE ?
			GROUP BY KECAMATAN
			UNION ALL
			SELECT 
				{$case_when} AS KECAMATAN,
				'tanggal_putusan' AS date_type, COUNT(*) AS COUNT
			FROM perkara p
			INNER JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id AND pp1.urutan = 1
			INNER JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
			WHERE pp.tanggal_putusan BETWEEN ? AND ? 
				AND p.jenis_perkara_nama LIKE ?
			GROUP BY KECAMATAN
		) AS subquery ON locations.KECAMATAN = subquery.KECAMATAN
		GROUP BY locations.KECAMATAN
		
		UNION ALL
		
		SELECT 
			'TOTAL' AS KECAMATAN,
			SUM(CASE WHEN date_type = 'tanggal_pendaftaran' THEN COUNT ELSE 0 END) AS PERKARA_MASUK,
			SUM(CASE WHEN date_type = 'tanggal_putusan' THEN COUNT ELSE 0 END) AS PERKARA_PUTUS
		FROM (
			SELECT 
				{$case_when} AS KECAMATAN,
				'tanggal_pendaftaran' AS date_type, COUNT(*) AS COUNT
			FROM perkara p
			INNER JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id AND pp1.urutan = 1
			WHERE p.tanggal_pendaftaran BETWEEN ? AND ? 
				AND p.jenis_perkara_nama LIKE ?
			GROUP BY KECAMATAN
			UNION ALL
			SELECT 
				{$case_when} AS KECAMATAN,
				'tanggal_putusan' AS date_type, COUNT(*) AS COUNT
			FROM perkara p
			INNER JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id AND pp1.urutan = 1
			INNER JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
			WHERE pp.tanggal_putusan BETWEEN ? AND ? 
				AND p.jenis_perkara_nama LIKE ?
			GROUP BY KECAMATAN
		) AS subquery
		WHERE KECAMATAN IN ({$kecamatan_filter})
		ORDER BY CASE WHEN KECAMATAN = 'TOTAL' THEN 1 ELSE 0 END, KECAMATAN";

		$like_pattern = '%' . $jenis_perkara . '%';
		$params = [
			$tanggal_mulai,
			$tanggal_akhir,
			$like_pattern,
			$tanggal_mulai,
			$tanggal_akhir,
			$like_pattern,
			$tanggal_mulai,
			$tanggal_akhir,
			$like_pattern,
			$tanggal_mulai,
			$tanggal_akhir,
			$like_pattern
		];

		$query = $this->db->query($sql, $params);
		return $query->result();
	}

	public function get_summary_statistics($lap_bulan, $lap_tahun, $jenis_perkara, $wilayah, $jenis_laporan = 'bulanan')
	{
		$where_clause = "";
		$params = [];
		$like_pattern = '%' . $jenis_perkara . '%';

		switch ($jenis_laporan) {
			case 'tahunan':
				$where_clause = "YEAR(p.tanggal_pendaftaran) = ?";
				$where_clause_putusan = "YEAR(pp.tanggal_putusan) = ?";
				$params = [$lap_tahun, $like_pattern, $lap_tahun, $like_pattern];
				break;
			case 'custom':
				$tanggal_mulai = $this->input->post('tanggal_mulai') ?: date('Y-m-01');
				$tanggal_akhir = $this->input->post('tanggal_akhir') ?: date('Y-m-t');
				$where_clause = "p.tanggal_pendaftaran BETWEEN ? AND ?";
				$where_clause_putusan = "pp.tanggal_putusan BETWEEN ? AND ?";
				$params = [$tanggal_mulai, $tanggal_akhir, $like_pattern, $tanggal_mulai, $tanggal_akhir, $like_pattern];
				break;
			default: // bulanan
				$where_clause = "YEAR(p.tanggal_pendaftaran) = ? AND MONTH(p.tanggal_pendaftaran) = ?";
				$where_clause_putusan = "YEAR(pp.tanggal_putusan) = ? AND MONTH(pp.tanggal_putusan) = ?";
				$params = [$lap_tahun, $lap_bulan, $like_pattern, $lap_tahun, $lap_bulan, $like_pattern];
				break;
		}

		$sql = "SELECT 
			(
				SELECT COUNT(*) 
				FROM perkara p
				INNER JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id AND pp1.urutan = 1
				WHERE {$where_clause} AND p.jenis_perkara_nama LIKE ?
			) as total_masuk,
			(
				SELECT COUNT(*) 
				FROM perkara p
				INNER JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id AND pp1.urutan = 1
				INNER JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
				WHERE {$where_clause_putusan} AND p.jenis_perkara_nama LIKE ?
			) as total_putus";

		$query = $this->db->query($sql, $params);
		return $query->row();
	}

	public function get_jenis_perkara_list()
	{
		$sql = "SELECT DISTINCT jenis_perkara_nama 
				FROM perkara 
				WHERE jenis_perkara_nama LIKE '%Dispensasi%' 
					OR jenis_perkara_nama LIKE '%Istbat%' 
					OR jenis_perkara_nama LIKE '%P3HP%'
					OR jenis_perkara_nama LIKE '%Ahli Waris%'
				ORDER BY jenis_perkara_nama";

		$query = $this->db->query($sql);
		return $query->result();
	}

	public function get_jenis_perkara_permohonan()
	{
		// Query untuk mendapatkan jenis perkara permohonan (voluntair/non-contentiosa)
		// Biasanya perkara permohonan memiliki karakteristik tertentu dalam nama
		$sql = "SELECT DISTINCT jenis_perkara_nama 
				FROM perkara 
				WHERE (
					jenis_perkara_nama LIKE '%Dispensasi%' 
					OR jenis_perkara_nama LIKE '%Istbat%' 
					OR jenis_perkara_nama LIKE '%P3HP%'
					OR jenis_perkara_nama LIKE '%Ahli Waris%'
					OR jenis_perkara_nama LIKE '%Penetapan%'
					OR jenis_perkara_nama LIKE '%Permohonan%'
					OR jenis_perkara_nama LIKE '%Pengesahan%'
					OR jenis_perkara_nama LIKE '%Pengangkatan%'
					OR jenis_perkara_nama LIKE '%Perwalian%'
					OR jenis_perkara_nama LIKE '%Wali%'
					OR jenis_perkara_nama LIKE '%Itsbat%'
					OR jenis_perkara_nama LIKE '%Penunjukan%'
					OR jenis_perkara_nama LIKE '%Hibah%'
					OR jenis_perkara_nama LIKE '%Wakaf%'
					OR jenis_perkara_nama LIKE '%Wasiat%'
					OR jenis_perkara_nama LIKE '%Pembatalan%'
					OR jenis_perkara_nama LIKE '%Pencabutan%'
				)
				-- Exclude perkara gugatan (contentiosa)
				AND jenis_perkara_nama NOT LIKE '%Gugat%'
				AND jenis_perkara_nama NOT LIKE '%Cerai Talak%'
				AND jenis_perkara_nama NOT LIKE '%Cerai Gugat%'
				AND jenis_perkara_nama NOT LIKE '%Harta Bersama%'
				AND jenis_perkara_nama NOT LIKE '%Mut\'ah%'
				AND jenis_perkara_nama NOT LIKE '%Nafkah%'
				AND jenis_perkara_nama NOT LIKE '%Hadhanah%'
				ORDER BY jenis_perkara_nama";

		$query = $this->db->query($sql);
		return $query->result();
	}
}
