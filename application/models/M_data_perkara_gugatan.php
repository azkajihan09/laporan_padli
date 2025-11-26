<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_data_perkara_gugatan extends CI_Model
{

	// Data summary perceraian per kecamatan
	function data_summary_perceraian($lap_bulan, $lap_tahun, $jenis_perkara, $wilayah)
	{
		// Set default values
		if (empty($lap_bulan)) $lap_bulan = date('m');
		if (empty($lap_tahun)) $lap_tahun = date('Y');
		if (empty($jenis_perkara)) $jenis_perkara = 'Cerai Gugat';
		if (empty($wilayah)) $wilayah = 'HSU';

		// Define kecamatan based on wilayah
		$kecamatan_list = $this->_get_kecamatan_list($wilayah);

		$sql = "SELECT 
            locations.KECAMATAN,
            COALESCE(SUM(CASE WHEN subquery.date_type = 'tanggal_pendaftaran' THEN subquery.COUNT ELSE 0 END), 0) AS PERKARA_MASUK,
            COALESCE(SUM(CASE WHEN subquery.date_type = 'tanggal_putusan' THEN subquery.COUNT ELSE 0 END), 0) AS PERKARA_PUTUS,
            COALESCE(SUM(CASE WHEN subquery.date_type = 'tanggal_bht' THEN subquery.COUNT ELSE 0 END), 0) AS PERKARA_TELAH_BHT,
            COALESCE(SUM(CASE WHEN subquery.date_type = 'tgl_akta_cerai' THEN subquery.COUNT ELSE 0 END), 0) AS JUMLAH_AKTA_CERAI
        FROM ($kecamatan_list) AS locations
        LEFT JOIN (";

		// Add subqueries for each date type
		$subqueries = array();

		// Akta Cerai
		$subqueries[] = $this->_build_subquery('tgl_akta_cerai', 'perkara_akta_cerai', $lap_bulan, $lap_tahun, $jenis_perkara, $wilayah);

		// Tanggal Pendaftaran
		$subqueries[] = $this->_build_subquery('tanggal_pendaftaran', 'perkara', $lap_bulan, $lap_tahun, $jenis_perkara, $wilayah);

		// Tanggal Putusan
		$subqueries[] = $this->_build_subquery('tanggal_putusan', 'perkara_putusan', $lap_bulan, $lap_tahun, $jenis_perkara, $wilayah);

		// Tanggal BHT
		$subqueries[] = $this->_build_subquery('tanggal_bht', 'perkara_putusan', $lap_bulan, $lap_tahun, $jenis_perkara, $wilayah);

		$sql .= implode(' UNION ALL ', $subqueries);
		$sql .= ") AS subquery ON locations.KECAMATAN = subquery.KECAMATAN
        GROUP BY locations.KECAMATAN
        ORDER BY locations.KECAMATAN";

		return $this->db->query($sql)->result();
	}

	// Data yearly perceraian
	function data_yearly_perceraian($lap_tahun, $jenis_perkara, $wilayah)
	{
		// Set default values
		if (empty($lap_tahun)) $lap_tahun = date('Y');
		if (empty($jenis_perkara)) $jenis_perkara = 'Cerai Gugat';
		if (empty($wilayah)) $wilayah = 'HSU';

		$kecamatan_list = $this->_get_kecamatan_list($wilayah);

		$sql = "SELECT 
            locations.KECAMATAN,
            COALESCE(SUM(CASE WHEN subquery.date_type = 'tanggal_pendaftaran' THEN subquery.COUNT ELSE 0 END), 0) AS PERKARA_MASUK,
            COALESCE(SUM(CASE WHEN subquery.date_type = 'tanggal_putusan' THEN subquery.COUNT ELSE 0 END), 0) AS PERKARA_PUTUS,
            COALESCE(SUM(CASE WHEN subquery.date_type = 'tanggal_bht' THEN subquery.COUNT ELSE 0 END), 0) AS PERKARA_TELAH_BHT,
            COALESCE(SUM(CASE WHEN subquery.date_type = 'tgl_akta_cerai' THEN subquery.COUNT ELSE 0 END), 0) AS JUMLAH_AKTA_CERAI
        FROM ($kecamatan_list) AS locations
        LEFT JOIN (";

		$subqueries = array();
		$subqueries[] = $this->_build_yearly_subquery('tgl_akta_cerai', 'perkara_akta_cerai', $lap_tahun, $jenis_perkara, $wilayah);
		$subqueries[] = $this->_build_yearly_subquery('tanggal_pendaftaran', 'perkara', $lap_tahun, $jenis_perkara, $wilayah);
		$subqueries[] = $this->_build_yearly_subquery('tanggal_putusan', 'perkara_putusan', $lap_tahun, $jenis_perkara, $wilayah);
		$subqueries[] = $this->_build_yearly_subquery('tanggal_bht', 'perkara_putusan', $lap_tahun, $jenis_perkara, $wilayah);

		$sql .= implode(' UNION ALL ', $subqueries);
		$sql .= ") AS subquery ON locations.KECAMATAN = subquery.KECAMATAN
        GROUP BY locations.KECAMATAN
        ORDER BY locations.KECAMATAN";

		return $this->db->query($sql)->result();
	}

	// Data monthly breakdown
	function data_monthly_perceraian($lap_tahun, $jenis_perkara, $wilayah)
	{
		if (empty($lap_tahun)) $lap_tahun = date('Y');
		if (empty($jenis_perkara)) $jenis_perkara = 'Cerai Gugat';
		if (empty($wilayah)) $wilayah = 'HSU';

		$sql = "SELECT 
            MONTH(tanggal_pendaftaran) as BULAN,
            MONTHNAME(tanggal_pendaftaran) as NAMA_BULAN,
            COUNT(*) as JUMLAH
        FROM perkara
        LEFT JOIN perkara_pihak1 ON perkara.perkara_id = perkara_pihak1.perkara_id
        WHERE YEAR(tanggal_pendaftaran) = '$lap_tahun' 
            AND jenis_perkara_nama = '$jenis_perkara'
            AND perkara_pihak1.urutan = '1'";

		if ($wilayah !== 'Semua') {
			$sql .= $this->_get_alamat_condition($wilayah);
		}

		$sql .= " GROUP BY MONTH(tanggal_pendaftaran), MONTHNAME(tanggal_pendaftaran)
        ORDER BY BULAN";

		return $this->db->query($sql)->result();
	}

	// Comparison data cerai gugat vs cerai talak
	function data_comparison_gugat_talak($lap_bulan, $lap_tahun, $wilayah)
	{
		if (empty($lap_bulan)) $lap_bulan = date('m');
		if (empty($lap_tahun)) $lap_tahun = date('Y');
		if (empty($wilayah)) $wilayah = 'HSU';

		$kecamatan_list = $this->_get_kecamatan_list($wilayah);

		$sql = "SELECT 
            locations.KECAMATAN,
            COALESCE(gugat.JUMLAH, 0) AS CERAI_GUGAT,
            COALESCE(talak.JUMLAH, 0) AS CERAI_TALAK,
            (COALESCE(gugat.JUMLAH, 0) + COALESCE(talak.JUMLAH, 0)) AS TOTAL
        FROM ($kecamatan_list) AS locations
        LEFT JOIN (
            SELECT " . $this->_get_case_statement($wilayah) . " AS KECAMATAN, COUNT(*) AS JUMLAH
            FROM perkara
            LEFT JOIN perkara_pihak1 ON perkara.perkara_id = perkara_pihak1.perkara_id
            WHERE YEAR(tanggal_pendaftaran) = '$lap_tahun' 
                AND MONTH(tanggal_pendaftaran) = '$lap_bulan'
                AND jenis_perkara_nama = 'Cerai Gugat'
                AND perkara_pihak1.urutan = '1'
            GROUP BY KECAMATAN
        ) AS gugat ON locations.KECAMATAN = gugat.KECAMATAN
        LEFT JOIN (
            SELECT " . $this->_get_case_statement($wilayah) . " AS KECAMATAN, COUNT(*) AS JUMLAH
            FROM perkara
            LEFT JOIN perkara_pihak1 ON perkara.perkara_id = perkara_pihak1.perkara_id
            WHERE YEAR(tanggal_pendaftaran) = '$lap_tahun' 
                AND MONTH(tanggal_pendaftaran) = '$lap_bulan'
                AND jenis_perkara_nama = 'Cerai Talak'
                AND perkara_pihak1.urutan = '1'
            GROUP BY KECAMATAN
        ) AS talak ON locations.KECAMATAN = talak.KECAMATAN
        ORDER BY locations.KECAMATAN";

		return $this->db->query($sql)->result();
	}

	// Data faktor perceraian
	function data_faktor_perceraian($lap_tahun, $wilayah, $jenis_kelamin = 'L')
	{
		if (empty($lap_tahun)) $lap_tahun = date('Y');
		if (empty($wilayah)) $wilayah = 'HSU';
		if (empty($jenis_kelamin)) $jenis_kelamin = 'L';

		$where_clause = "YEAR(pac.tgl_akta_cerai) = '$lap_tahun'";
		if ($wilayah !== 'Semua') {
			$where_clause .= $this->_get_alamat_condition($wilayah, 'pp1');
		}

		$gender_suffix = "($jenis_kelamin)";

		$sql = "SELECT
            faktor.FaktorPerceraian,
            COALESCE(agg.`Usia 16-19 $gender_suffix`, 0) AS `Usia 16-19 $gender_suffix`,
            COALESCE(agg.`Usia 20-25 $gender_suffix`, 0) AS `Usia 20-25 $gender_suffix`,
            COALESCE(agg.`Usia 26-30 $gender_suffix`, 0) AS `Usia 26-30 $gender_suffix`,
            COALESCE(agg.`Usia 31-35 $gender_suffix`, 0) AS `Usia 31-35 $gender_suffix`,
            COALESCE(agg.`Usia 36+ $gender_suffix`, 0) AS `Usia 36+ $gender_suffix`,
            COALESCE(agg.`Total $gender_suffix`, 0) AS `Total $gender_suffix`
        FROM (
                SELECT '9' AS id, 'Perselisihan Terus Menerus' AS FaktorPerceraian
                UNION ALL
                SELECT '10', 'Kawin Paksa'
                UNION ALL
                SELECT '11', 'Murtad'
                UNION ALL
                SELECT '12', 'Ekonomi'
                UNION ALL
                SELECT '14', 'Lain-Lain'
            ) AS faktor
            LEFT JOIN (
                SELECT
                    pac.faktor_perceraian_id, 
                    SUM(CASE WHEN TIMESTAMPDIFF(YEAR, pd.tanggal_lahir, p.tanggal_pendaftaran) BETWEEN 16 AND 19 AND pd.jenis_kelamin = '$jenis_kelamin' THEN 1 ELSE 0 END) AS `Usia 16-19 $gender_suffix`,
                    SUM(CASE WHEN TIMESTAMPDIFF(YEAR, pd.tanggal_lahir, p.tanggal_pendaftaran) BETWEEN 20 AND 25 AND pd.jenis_kelamin = '$jenis_kelamin' THEN 1 ELSE 0 END) AS `Usia 20-25 $gender_suffix`,
                    SUM(CASE WHEN TIMESTAMPDIFF(YEAR, pd.tanggal_lahir, p.tanggal_pendaftaran) BETWEEN 26 AND 30 AND pd.jenis_kelamin = '$jenis_kelamin' THEN 1 ELSE 0 END) AS `Usia 26-30 $gender_suffix`,
                    SUM(CASE WHEN TIMESTAMPDIFF(YEAR, pd.tanggal_lahir, p.tanggal_pendaftaran) BETWEEN 31 AND 35 AND pd.jenis_kelamin = '$jenis_kelamin' THEN 1 ELSE 0 END) AS `Usia 31-35 $gender_suffix`,
                    SUM(CASE WHEN TIMESTAMPDIFF(YEAR, pd.tanggal_lahir, p.tanggal_pendaftaran) >= 36 AND pd.jenis_kelamin = '$jenis_kelamin' THEN 1 ELSE 0 END) AS `Usia 36+ $gender_suffix`,
                    SUM(CASE WHEN pd.jenis_kelamin = '$jenis_kelamin' THEN 1 ELSE 0 END) AS `Total $gender_suffix`
                FROM perkara_akta_cerai pac
                    JOIN perkara p ON pac.perkara_id = p.perkara_id
                    JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id
                    JOIN pihak pd ON pp1.pihak_id = pd.id
                WHERE $where_clause
                GROUP BY pac.faktor_perceraian_id
            ) AS agg ON faktor.id = agg.faktor_perceraian_id";

		return $this->db->query($sql)->result();
	}

	// Data faktor perceraian detail
	function data_faktor_perceraian_detail($lap_bulan, $lap_tahun, $wilayah)
	{
		if (empty($lap_bulan)) $lap_bulan = date('m');
		if (empty($lap_tahun)) $lap_tahun = date('Y');
		if (empty($wilayah)) $wilayah = 'HSU';

		$where_clause = "YEAR(pac.tgl_akta_cerai) = '$lap_tahun' AND MONTH(pac.tgl_akta_cerai) = '$lap_bulan'";
		if ($wilayah !== 'Semua') {
			$where_clause .= $this->_get_alamat_condition($wilayah, 'pp1');
		}

		$sql = "SELECT 
            CASE 
                WHEN pac.faktor_perceraian_id = '9' THEN 'Perselisihan Terus Menerus'
                WHEN pac.faktor_perceraian_id = '10' THEN 'Kawin Paksa'
                WHEN pac.faktor_perceraian_id = '11' THEN 'Murtad'
                WHEN pac.faktor_perceraian_id = '12' THEN 'Ekonomi'
                WHEN pac.faktor_perceraian_id = '14' THEN 'Lain-Lain'
                ELSE 'Tidak Diketahui'
            END AS FAKTOR,
            COUNT(*) AS JUMLAH,
            ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM perkara_akta_cerai pac2 
                JOIN perkara p2 ON pac2.perkara_id = p2.perkara_id 
                JOIN perkara_pihak1 pp12 ON p2.perkara_id = pp12.perkara_id 
                WHERE YEAR(pac2.tgl_akta_cerai) = '$lap_tahun' 
                    AND MONTH(pac2.tgl_akta_cerai) = '$lap_bulan'" .
			($wilayah !== 'Semua' ? $this->_get_alamat_condition($wilayah, 'pp12') : '') . ")), 2) AS PERSENTASE
        FROM perkara_akta_cerai pac
        JOIN perkara p ON pac.perkara_id = p.perkara_id
        JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id
        WHERE $where_clause
        GROUP BY pac.faktor_perceraian_id
        ORDER BY JUMLAH DESC";

		return $this->db->query($sql)->result();
	}

	// Private helper functions
	private function _get_kecamatan_list($wilayah)
	{
		switch ($wilayah) {
			case 'HSU':
				return "SELECT 'Danau Panggang' AS KECAMATAN
                    UNION ALL SELECT 'Babirik'
                    UNION ALL SELECT 'Sungai Pandan'
                    UNION ALL SELECT 'Amuntai Selatan'
                    UNION ALL SELECT 'Amuntai Tengah'
                    UNION ALL SELECT 'Amuntai Utara'
                    UNION ALL SELECT 'Banjang'
                    UNION ALL SELECT 'Haur Gading'
                    UNION ALL SELECT 'Paminggir'
                    UNION ALL SELECT 'Sungai Tabukan'";

			case 'Balangan':
				return "SELECT 'Awayan' AS KECAMATAN
                    UNION ALL SELECT 'Batu Mandi'
                    UNION ALL SELECT 'Halong'
                    UNION ALL SELECT 'Juai'
                    UNION ALL SELECT 'Lampihong'
                    UNION ALL SELECT 'Paringin'
                    UNION ALL SELECT 'Paringin Selatan'
                    UNION ALL SELECT 'Tebing Tinggi'";

			default:
				return "SELECT 'Danau Panggang' AS KECAMATAN
                    UNION ALL SELECT 'Babirik'
                    UNION ALL SELECT 'Sungai Pandan'
                    UNION ALL SELECT 'Amuntai Selatan'
                    UNION ALL SELECT 'Amuntai Tengah'
                    UNION ALL SELECT 'Amuntai Utara'
                    UNION ALL SELECT 'Banjang'
                    UNION ALL SELECT 'Haur Gading'
                    UNION ALL SELECT 'Paminggir'
                    UNION ALL SELECT 'Sungai Tabukan'
                    UNION ALL SELECT 'Awayan'
                    UNION ALL SELECT 'Batu Mandi'
                    UNION ALL SELECT 'Halong'
                    UNION ALL SELECT 'Juai'
                    UNION ALL SELECT 'Lampihong'
                    UNION ALL SELECT 'Paringin'
                    UNION ALL SELECT 'Paringin Selatan'
                    UNION ALL SELECT 'Tebing Tinggi'";
		}
	}

	private function _get_case_statement($wilayah)
	{
		switch ($wilayah) {
			case 'HSU':
				return "CASE 
                    WHEN perkara_pihak1.alamat LIKE '%Danau Panggang%' THEN 'Danau Panggang'
                    WHEN perkara_pihak1.alamat LIKE '%Babirik%' THEN 'Babirik'
                    WHEN perkara_pihak1.alamat LIKE '%Sungai Pandan%' THEN 'Sungai Pandan'
                    WHEN perkara_pihak1.alamat LIKE '%Amuntai Selatan%' THEN 'Amuntai Selatan'
                    WHEN perkara_pihak1.alamat LIKE '%Amuntai Tengah%' THEN 'Amuntai Tengah'
                    WHEN perkara_pihak1.alamat LIKE '%Amuntai Utara%' THEN 'Amuntai Utara'
                    WHEN perkara_pihak1.alamat LIKE '%Banjang%' THEN 'Banjang'
                    WHEN perkara_pihak1.alamat LIKE '%Haur Gading%' THEN 'Haur Gading'
                    WHEN perkara_pihak1.alamat LIKE '%Paminggir%' THEN 'Paminggir'
                    WHEN perkara_pihak1.alamat LIKE '%Sungai Tabukan%' THEN 'Sungai Tabukan'
                    ELSE 'Lainnya'
                END";

			case 'Balangan':
				return "CASE 
                    WHEN perkara_pihak1.alamat LIKE '%Awayan%' THEN 'Awayan'
                    WHEN perkara_pihak1.alamat LIKE '%Batu Mandi%' THEN 'Batu Mandi'
                    WHEN perkara_pihak1.alamat LIKE '%Halong%' THEN 'Halong'
                    WHEN perkara_pihak1.alamat LIKE '%Juai%' THEN 'Juai'
                    WHEN perkara_pihak1.alamat LIKE '%Lampihong%' THEN 'Lampihong'
                    WHEN perkara_pihak1.alamat LIKE '%Paringin%' THEN 'Paringin'
                    WHEN perkara_pihak1.alamat LIKE '%Paringin Selatan%' THEN 'Paringin Selatan'
                    WHEN perkara_pihak1.alamat LIKE '%Tebing Tinggi%' THEN 'Tebing Tinggi'
                    ELSE 'Lainnya'
                END";

			default:
				return "CASE 
                    WHEN perkara_pihak1.alamat LIKE '%Danau Panggang%' THEN 'Danau Panggang'
                    WHEN perkara_pihak1.alamat LIKE '%Babirik%' THEN 'Babirik'
                    WHEN perkara_pihak1.alamat LIKE '%Sungai Pandan%' THEN 'Sungai Pandan'
                    WHEN perkara_pihak1.alamat LIKE '%Amuntai Selatan%' THEN 'Amuntai Selatan'
                    WHEN perkara_pihak1.alamat LIKE '%Amuntai Tengah%' THEN 'Amuntai Tengah'
                    WHEN perkara_pihak1.alamat LIKE '%Amuntai Utara%' THEN 'Amuntai Utara'
                    WHEN perkara_pihak1.alamat LIKE '%Banjang%' THEN 'Banjang'
                    WHEN perkara_pihak1.alamat LIKE '%Haur Gading%' THEN 'Haur Gading'
                    WHEN perkara_pihak1.alamat LIKE '%Paminggir%' THEN 'Paminggir'
                    WHEN perkara_pihak1.alamat LIKE '%Sungai Tabukan%' THEN 'Sungai Tabukan'
                    WHEN perkara_pihak1.alamat LIKE '%Awayan%' THEN 'Awayan'
                    WHEN perkara_pihak1.alamat LIKE '%Batu Mandi%' THEN 'Batu Mandi'
                    WHEN perkara_pihak1.alamat LIKE '%Halong%' THEN 'Halong'
                    WHEN perkara_pihak1.alamat LIKE '%Juai%' THEN 'Juai'
                    WHEN perkara_pihak1.alamat LIKE '%Lampihong%' THEN 'Lampihong'
                    WHEN perkara_pihak1.alamat LIKE '%Paringin%' THEN 'Paringin'
                    WHEN perkara_pihak1.alamat LIKE '%Paringin Selatan%' THEN 'Paringin Selatan'
                    WHEN perkara_pihak1.alamat LIKE '%Tebing Tinggi%' THEN 'Tebing Tinggi'
                    ELSE 'Lainnya'
                END";
		}
	}

	private function _get_alamat_condition($wilayah, $alias = 'perkara_pihak1')
	{
		switch ($wilayah) {
			case 'HSU':
				return " AND ($alias.alamat LIKE '%Danau Panggang%' OR $alias.alamat LIKE '%Babirik%' OR $alias.alamat LIKE '%Sungai Pandan%' OR $alias.alamat LIKE '%Amuntai%' OR $alias.alamat LIKE '%Banjang%' OR $alias.alamat LIKE '%Haur Gading%' OR $alias.alamat LIKE '%Paminggir%' OR $alias.alamat LIKE '%Sungai Tabukan%')";
			case 'Balangan':
				return " AND ($alias.alamat LIKE '%Awayan%' OR $alias.alamat LIKE '%Batu Mandi%' OR $alias.alamat LIKE '%Halong%' OR $alias.alamat LIKE '%Juai%' OR $alias.alamat LIKE '%Lampihong%' OR $alias.alamat LIKE '%Paringin%' OR $alias.alamat LIKE '%Tebing Tinggi%')";
			default:
				return "";
		}
	}

	private function _build_subquery($date_field, $table, $lap_bulan, $lap_tahun, $jenis_perkara, $wilayah)
	{
		$join_clause = "";
		if ($table !== 'perkara') {
			$join_clause = "LEFT JOIN perkara ON " . $table . ".perkara_id = perkara.perkara_id ";
		}
		if ($table === 'perkara_putusan') {
			$join_clause = "LEFT JOIN perkara ON perkara_putusan.perkara_id = perkara.perkara_id ";
		}
		if ($table === 'perkara_akta_cerai') {
			$join_clause = "LEFT JOIN perkara ON perkara_akta_cerai.perkara_id = perkara.perkara_id ";
		}

		return "SELECT " . $this->_get_case_statement($wilayah) . " AS KECAMATAN,
            '$date_field' AS date_type, COUNT(*) AS COUNT
        FROM $table
        $join_clause
        LEFT JOIN perkara_pihak1 ON perkara.perkara_id = perkara_pihak1.perkara_id
        WHERE YEAR($date_field) = '$lap_tahun' 
            AND MONTH($date_field) = '$lap_bulan' 
            AND jenis_perkara_nama = '$jenis_perkara'
            AND perkara_pihak1.urutan = '1'
        GROUP BY KECAMATAN";
	}

	private function _build_yearly_subquery($date_field, $table, $lap_tahun, $jenis_perkara, $wilayah)
	{
		$join_clause = "";
		if ($table !== 'perkara') {
			$join_clause = "LEFT JOIN perkara ON " . $table . ".perkara_id = perkara.perkara_id ";
		}
		if ($table === 'perkara_putusan') {
			$join_clause = "LEFT JOIN perkara ON perkara_putusan.perkara_id = perkara.perkara_id ";
		}
		if ($table === 'perkara_akta_cerai') {
			$join_clause = "LEFT JOIN perkara ON perkara_akta_cerai.perkara_id = perkara.perkara_id ";
		}

		return "SELECT " . $this->_get_case_statement($wilayah) . " AS KECAMATAN,
            '$date_field' AS date_type, COUNT(*) AS COUNT
        FROM $table
        $join_clause
        LEFT JOIN perkara_pihak1 ON perkara.perkara_id = perkara_pihak1.perkara_id
        WHERE YEAR($date_field) = '$lap_tahun' 
            AND jenis_perkara_nama = '$jenis_perkara'
            AND perkara_pihak1.urutan = '1'
        GROUP BY KECAMATAN";
	}

	// Get daftar jenis perkara gugatan untuk dropdown
	public function get_jenis_perkara_gugatan()
	{
		$sql = "SELECT DISTINCT p.jenis_perkara_nama 
                FROM perkara p 
                WHERE p.jenis_perkara_nama IS NOT NULL 
                  AND p.jenis_perkara_nama != ''
                  AND (p.nomor_perkara LIKE '%Pdt.Gt%' 
                       OR p.nomor_perkara LIKE '%Pdt.G/%' 
                       OR p.nomor_perkara LIKE '%PDT.G%'
                       OR p.jenis_perkara_nama LIKE '%Cerai Gugat%'
                       OR p.jenis_perkara_nama = 'Cerai Gugat')
                ORDER BY p.jenis_perkara_nama";

		$query = $this->db->query($sql);
		return $query->result();
	}
}
