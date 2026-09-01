<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_laporan_perceraian extends CI_Model
{

	/**
	 * ============================================================
	 * LAPORAN PERKARA BULANAN
	 * ============================================================
	 *
	 * Cerai:
	 *   Menggunakan tanggal Akta Cerai
	 *
	 * Istbat Nikah:
	 *   Menggunakan tanggal Putusan
	 */
	public function get_laporan_perceraian_bulanan(
		$lap_tahun,
		$lap_bulan,
		$wilayah = 'Semua',
		$jenis_perkara = 'semua'
	) {
		$where_wilayah = $this->_get_wilayah_condition($wilayah);
		$where_jenis = $this->_get_jenis_perkara_condition($jenis_perkara);

		$sql = "SELECT
				P.nomor_perkara,
				P.jenis_perkara_nama,

				P.pihak1_text AS nama_pihak_1,
				PHK1.nomor_indentitas AS nik_pihak_1,
				PHK1.pekerjaan AS pekerjaan_pihak_1,
				PP1.alamat AS alamat_pihak_1,

				P.pihak2_text AS nama_pihak_2,
				PHK2.nomor_indentitas AS nik_pihak_2,
				PHK2.pekerjaan AS pekerjaan_pihak_2,
				PP2.alamat AS alamat_pihak_2,

				DATE_FORMAT(A.tanggal_putusan, '%d-%m-%Y') AS tanggal_putusan,
				DATE_FORMAT(A.tanggal_bht, '%d-%m-%Y') AS tanggal_bht,

				SP.nama AS status_putusan,

				C.nomor_akta_cerai,
				C.no_seri_akta_cerai,
				DATE_FORMAT(C.tgl_akta_cerai, '%d-%m-%Y') AS tgl_akta_cerai,

				CASE
					WHEN P.jenis_perkara_nama LIKE '%Cerai Gugat%'
						OR P.jenis_perkara_nama LIKE '%Cerai Talak%'
					THEN C.tgl_akta_cerai
					ELSE A.tanggal_putusan
				END AS tanggal_laporan

			FROM perkara AS P

			INNER JOIN perkara_putusan AS A
				ON A.perkara_id = P.perkara_id

			LEFT JOIN perkara_akta_cerai AS C
				ON C.perkara_id = P.perkara_id

			LEFT JOIN status_putusan AS SP
				ON SP.id = A.status_putusan_id

			LEFT JOIN perkara_pihak1 AS PP1
				ON PP1.perkara_id = P.perkara_id

			LEFT JOIN pihak AS PHK1
				ON PHK1.id = PP1.pihak_id

			LEFT JOIN perkara_pihak2 AS PP2
				ON PP2.perkara_id = P.perkara_id

			LEFT JOIN pihak AS PHK2
				ON PHK2.id = PP2.pihak_id

			WHERE
				(
					(
						(
							P.jenis_perkara_nama LIKE '%Cerai Gugat%'
							OR P.jenis_perkara_nama LIKE '%Cerai Talak%'
						)
						AND C.tgl_akta_cerai IS NOT NULL
						AND YEAR(C.tgl_akta_cerai) = ?
						AND MONTH(C.tgl_akta_cerai) = ?
					)

					OR

					(
						(
							P.jenis_perkara_nama LIKE '%Pengesahan Perkawinan%'
							OR P.jenis_perkara_nama LIKE '%Istbat Nikah%'
							OR P.jenis_perkara_nama LIKE '%Itsbat Nikah%'
						)
						AND P.nomor_perkara NOT LIKE '%/Pdt.P/%'
						AND YEAR(A.tanggal_putusan) = ?
						AND MONTH(A.tanggal_putusan) = ?
					)
				)

				$where_wilayah
				$where_jenis

			ORDER BY tanggal_laporan DESC, A.tanggal_putusan DESC";

		$query = $this->db->query(
			$sql,
			array(
				$lap_tahun,
				$lap_bulan,
				$lap_tahun,
				$lap_bulan
			)
		);

		return $query->result();
	}


	/**
	 * ============================================================
	 * LAPORAN PERKARA TAHUNAN
	 * ============================================================
	 */
	public function get_laporan_perceraian_tahunan(
		$lap_tahun,
		$wilayah = 'Semua',
		$jenis_perkara = 'semua'
	) {
		$where_wilayah = $this->_get_wilayah_condition($wilayah);
		$where_jenis = $this->_get_jenis_perkara_condition($jenis_perkara);

		$sql = "SELECT
				P.nomor_perkara,
				P.jenis_perkara_nama,

				P.pihak1_text AS nama_pihak_1,
				PHK1.nomor_indentitas AS nik_pihak_1,
				PHK1.pekerjaan AS pekerjaan_pihak_1,
				PP1.alamat AS alamat_pihak_1,

				P.pihak2_text AS nama_pihak_2,
				PHK2.nomor_indentitas AS nik_pihak_2,
				PHK2.pekerjaan AS pekerjaan_pihak_2,
				PP2.alamat AS alamat_pihak_2,

				DATE_FORMAT(A.tanggal_putusan, '%d-%m-%Y') AS tanggal_putusan,
				DATE_FORMAT(A.tanggal_bht, '%d-%m-%Y') AS tanggal_bht,

				SP.nama AS status_putusan,

				C.nomor_akta_cerai,
				C.no_seri_akta_cerai,
				DATE_FORMAT(C.tgl_akta_cerai, '%d-%m-%Y') AS tgl_akta_cerai,

				CASE
					WHEN P.jenis_perkara_nama LIKE '%Cerai Gugat%'
						OR P.jenis_perkara_nama LIKE '%Cerai Talak%'
					THEN C.tgl_akta_cerai
					ELSE A.tanggal_putusan
				END AS tanggal_laporan

			FROM perkara AS P

			INNER JOIN perkara_putusan AS A
				ON A.perkara_id = P.perkara_id

			LEFT JOIN perkara_akta_cerai AS C
				ON C.perkara_id = P.perkara_id

			LEFT JOIN status_putusan AS SP
				ON SP.id = A.status_putusan_id

			LEFT JOIN perkara_pihak1 AS PP1
				ON PP1.perkara_id = P.perkara_id

			LEFT JOIN pihak AS PHK1
				ON PHK1.id = PP1.pihak_id

			LEFT JOIN perkara_pihak2 AS PP2
				ON PP2.perkara_id = P.perkara_id

			LEFT JOIN pihak AS PHK2
				ON PHK2.id = PP2.pihak_id

			WHERE
				(
					(
						(
							P.jenis_perkara_nama LIKE '%Cerai Gugat%'
							OR P.jenis_perkara_nama LIKE '%Cerai Talak%'
						)
						AND C.tgl_akta_cerai IS NOT NULL
						AND YEAR(C.tgl_akta_cerai) = ?
					)

					OR

					(
						(
							P.jenis_perkara_nama LIKE '%Pengesahan Perkawinan%'
							OR P.jenis_perkara_nama LIKE '%Istbat Nikah%'
							OR P.jenis_perkara_nama LIKE '%Itsbat Nikah%'
						)
						AND P.nomor_perkara NOT LIKE '%/Pdt.P/%'
						AND YEAR(A.tanggal_putusan) = ?
					)
				)

				$where_wilayah
				$where_jenis

			ORDER BY tanggal_laporan DESC, A.tanggal_putusan DESC";

		$query = $this->db->query(
			$sql,
			array(
				$lap_tahun,
				$lap_tahun
			)
		);

		return $query->result();
	}


	/**
	 * ============================================================
	 * LAPORAN CUSTOM DATE RANGE
	 * ============================================================
	 */
	public function get_laporan_perceraian_custom(
		$tanggal_mulai,
		$tanggal_akhir,
		$wilayah = 'Semua',
		$jenis_perkara = 'semua'
	) {
		$where_wilayah = $this->_get_wilayah_condition($wilayah);
		$where_jenis = $this->_get_jenis_perkara_condition($jenis_perkara);

		$sql = "SELECT
				P.nomor_perkara,
				P.jenis_perkara_nama,

				P.pihak1_text AS nama_pihak_1,
				PHK1.nomor_indentitas AS nik_pihak_1,
				PHK1.pekerjaan AS pekerjaan_pihak_1,
				PP1.alamat AS alamat_pihak_1,

				P.pihak2_text AS nama_pihak_2,
				PHK2.nomor_indentitas AS nik_pihak_2,

				PHK2.pekerjaan AS pekerjaan_pihak_2,
				PP2.alamat AS alamat_pihak_2,

				DATE_FORMAT(A.tanggal_putusan, '%d-%m-%Y') AS tanggal_putusan,
				DATE_FORMAT(A.tanggal_bht, '%d-%m-%Y') AS tanggal_bht,

				SP.nama AS status_putusan,

				C.nomor_akta_cerai,
				C.no_seri_akta_cerai,
				DATE_FORMAT(C.tgl_akta_cerai, '%d-%m-%Y') AS tgl_akta_cerai,

				CASE
					WHEN P.jenis_perkara_nama LIKE '%Cerai Gugat%'
						OR P.jenis_perkara_nama LIKE '%Cerai Talak%'
					THEN C.tgl_akta_cerai
					ELSE A.tanggal_putusan
				END AS tanggal_laporan

			FROM perkara AS P

			INNER JOIN perkara_putusan AS A
				ON A.perkara_id = P.perkara_id

			LEFT JOIN perkara_akta_cerai AS C
				ON C.perkara_id = P.perkara_id

			LEFT JOIN status_putusan AS SP
				ON SP.id = A.status_putusan_id

			LEFT JOIN perkara_pihak1 AS PP1
				ON PP1.perkara_id = P.perkara_id

			LEFT JOIN pihak AS PHK1
				ON PHK1.id = PP1.pihak_id

			LEFT JOIN perkara_pihak2 AS PP2
				ON PP2.perkara_id = P.perkara_id

			LEFT JOIN pihak AS PHK2
				ON PHK2.id = PP2.pihak_id

			WHERE
				(
					(
						(
							P.jenis_perkara_nama LIKE '%Cerai Gugat%'
							OR P.jenis_perkara_nama LIKE '%Cerai Talak%'
						)
						AND C.tgl_akta_cerai IS NOT NULL
						AND DATE(C.tgl_akta_cerai) BETWEEN ? AND ?
					)

					OR

					(
						(
							P.jenis_perkara_nama LIKE '%Pengesahan Perkawinan%'
							OR P.jenis_perkara_nama LIKE '%Istbat Nikah%'
							OR P.jenis_perkara_nama LIKE '%Itsbat Nikah%'
						)
						AND P.nomor_perkara NOT LIKE '%/Pdt.P/%'
						AND DATE(A.tanggal_putusan) BETWEEN ? AND ?
					)
				)

				$where_wilayah
				$where_jenis

			ORDER BY tanggal_laporan DESC, A.tanggal_putusan DESC";

		$query = $this->db->query(
			$sql,
			array(
				$tanggal_mulai,
				$tanggal_akhir,
				$tanggal_mulai,
				$tanggal_akhir
			)
		);

		return $query->result();
	}


	/**
	 * ============================================================
	 * SUMMARY BULANAN
	 * ============================================================
	 */
	public function get_summary_perceraian_bulanan(
		$lap_tahun,
		$lap_bulan,
		$wilayah = 'Semua',
		$jenis_perkara = 'semua'
	) {
		$where_wilayah = $this->_get_wilayah_condition($wilayah);
		$where_jenis = $this->_get_jenis_perkara_condition($jenis_perkara);

		$sql = "SELECT

				COUNT(*) AS total_perceraian,

				SUM(
					CASE
						WHEN P.jenis_perkara_nama LIKE '%Cerai Gugat%'
						THEN 1
						ELSE 0
					END
				) AS cerai_gugat,

				SUM(
					CASE
						WHEN P.jenis_perkara_nama LIKE '%Cerai Talak%'
						THEN 1
						ELSE 0
					END
				) AS cerai_talak,

				SUM(
					CASE
						WHEN P.jenis_perkara_nama LIKE '%Pengesahan Perkawinan%'
							OR P.jenis_perkara_nama LIKE '%Istbat Nikah%'
							OR P.jenis_perkara_nama LIKE '%Itsbat Nikah%'
						THEN 1
						ELSE 0
					END
				) AS pengesahan_perkawinan

			FROM perkara AS P

			INNER JOIN perkara_putusan AS A
				ON A.perkara_id = P.perkara_id

			LEFT JOIN perkara_akta_cerai AS C
				ON C.perkara_id = P.perkara_id

			LEFT JOIN perkara_pihak1 AS PP1
				ON PP1.perkara_id = P.perkara_id

			WHERE
				(
					(
						(
							P.jenis_perkara_nama LIKE '%Cerai Gugat%'
							OR P.jenis_perkara_nama LIKE '%Cerai Talak%'
						)
						AND C.tgl_akta_cerai IS NOT NULL
						AND YEAR(C.tgl_akta_cerai) = ?
						AND MONTH(C.tgl_akta_cerai) = ?
					)

					OR

					(
						(
							P.jenis_perkara_nama LIKE '%Pengesahan Perkawinan%'
							OR P.jenis_perkara_nama LIKE '%Istbat Nikah%'
							OR P.jenis_perkara_nama LIKE '%Itsbat Nikah%'
						)
						AND P.nomor_perkara NOT LIKE '%/Pdt.P/%'
						AND YEAR(A.tanggal_putusan) = ?
						AND MONTH(A.tanggal_putusan) = ?
					)
				)

				$where_wilayah
				$where_jenis";

		$query = $this->db->query(
			$sql,
			array(
				$lap_tahun,
				$lap_bulan,
				$lap_tahun,
				$lap_bulan
			)
		);

		return $query->row();
	}


	/**
	 * ============================================================
	 * SUMMARY TAHUNAN
	 * ============================================================
	 */
	public function get_summary_perceraian_tahunan(
		$lap_tahun,
		$wilayah = 'Semua',
		$jenis_perkara = 'semua'
	) {
		$where_wilayah = $this->_get_wilayah_condition($wilayah);
		$where_jenis = $this->_get_jenis_perkara_condition($jenis_perkara);

		$sql = "SELECT

				COUNT(*) AS total_perceraian,

				SUM(
					CASE
						WHEN P.jenis_perkara_nama LIKE '%Cerai Gugat%'
						THEN 1
						ELSE 0
					END
				) AS cerai_gugat,

				SUM(
					CASE
						WHEN P.jenis_perkara_nama LIKE '%Cerai Talak%'
						THEN 1
						ELSE 0
					END
				) AS cerai_talak,

				SUM(
					CASE
						WHEN P.jenis_perkara_nama LIKE '%Pengesahan Perkawinan%'
							OR P.jenis_perkara_nama LIKE '%Istbat Nikah%'
							OR P.jenis_perkara_nama LIKE '%Itsbat Nikah%'
						THEN 1
						ELSE 0
					END
				) AS pengesahan_perkawinan

			FROM perkara AS P

			INNER JOIN perkara_putusan AS A
				ON A.perkara_id = P.perkara_id

			LEFT JOIN perkara_akta_cerai AS C
				ON C.perkara_id = P.perkara_id

			LEFT JOIN perkara_pihak1 AS PP1
				ON PP1.perkara_id = P.perkara_id

			WHERE
				(
					(
						(
							P.jenis_perkara_nama LIKE '%Cerai Gugat%'
							OR P.jenis_perkara_nama LIKE '%Cerai Talak%'
						)
						AND C.tgl_akta_cerai IS NOT NULL
						AND YEAR(C.tgl_akta_cerai) = ?
					)

					OR

					(
						(
							P.jenis_perkara_nama LIKE '%Pengesahan Perkawinan%'
							OR P.jenis_perkara_nama LIKE '%Istbat Nikah%'
							OR P.jenis_perkara_nama LIKE '%Itsbat Nikah%'
						)
						AND P.nomor_perkara NOT LIKE '%/Pdt.P/%'
						AND YEAR(A.tanggal_putusan) = ?
					)
				)

				$where_wilayah
				$where_jenis";

		$query = $this->db->query(
			$sql,
			array(
				$lap_tahun,
				$lap_tahun
			)
		);

		return $query->row();
	}


	/**
	 * ============================================================
	 * SUMMARY CUSTOM
	 * ============================================================
	 */
	public function get_summary_perceraian_custom(
		$tanggal_mulai,
		$tanggal_akhir,
		$wilayah = 'Semua',
		$jenis_perkara = 'semua'
	) {
		$where_wilayah = $this->_get_wilayah_condition($wilayah);
		$where_jenis = $this->_get_jenis_perkara_condition($jenis_perkara);

		$sql = "SELECT

				COUNT(*) AS total_perceraian,

				SUM(
					CASE
						WHEN P.jenis_perkara_nama LIKE '%Cerai Gugat%'
						THEN 1
						ELSE 0
					END
				) AS cerai_gugat,

				SUM(
					CASE
						WHEN P.jenis_perkara_nama LIKE '%Cerai Talak%'
						THEN 1
						ELSE 0
					END
				) AS cerai_talak,

				SUM(
					CASE
						WHEN P.jenis_perkara_nama LIKE '%Pengesahan Perkawinan%'
							OR P.jenis_perkara_nama LIKE '%Istbat Nikah%'
							OR P.jenis_perkara_nama LIKE '%Itsbat Nikah%'
						THEN 1
						ELSE 0
					END
				) AS pengesahan_perkawinan

			FROM perkara AS P

			INNER JOIN perkara_putusan AS A
				ON A.perkara_id = P.perkara_id

			LEFT JOIN perkara_akta_cerai AS C
				ON C.perkara_id = P.perkara_id

			LEFT JOIN perkara_pihak1 AS PP1
				ON PP1.perkara_id = P.perkara_id

			WHERE
				(
					(
						(
							P.jenis_perkara_nama LIKE '%Cerai Gugat%'
							OR P.jenis_perkara_nama LIKE '%Cerai Talak%'
						)
						AND C.tgl_akta_cerai IS NOT NULL
						AND DATE(C.tgl_akta_cerai) BETWEEN ? AND ?
					)

					OR

					(
						(
							P.jenis_perkara_nama LIKE '%Pengesahan Perkawinan%'
							OR P.jenis_perkara_nama LIKE '%Istbat Nikah%'
							OR P.jenis_perkara_nama LIKE '%Itsbat Nikah%'
						)
						AND P.nomor_perkara NOT LIKE '%/Pdt.P/%'
						AND DATE(A.tanggal_putusan) BETWEEN ? AND ?
					)
				)

				$where_wilayah
				$where_jenis";

		$query = $this->db->query(
			$sql,
			array(
				$tanggal_mulai,
				$tanggal_akhir,
				$tanggal_mulai,
				$tanggal_akhir
			)
		);

		return $query->row();
	}


	/**
	 * ============================================================
	 * GET JENIS PERKARA
	 * ============================================================
	 */
	public function get_jenis_perkara_perceraian()
	{
		$sql = "SELECT DISTINCT
					P.jenis_perkara_nama

				FROM perkara AS P

				WHERE P.jenis_perkara_nama IS NOT NULL
				AND P.jenis_perkara_nama != ''

				AND (
					P.jenis_perkara_nama LIKE '%Cerai Gugat%'
					OR P.jenis_perkara_nama LIKE '%Cerai Talak%'
					OR P.jenis_perkara_nama LIKE '%Pengesahan Perkawinan%'
					OR P.jenis_perkara_nama LIKE '%Istbat Nikah%'
					OR P.jenis_perkara_nama LIKE '%Itsbat Nikah%'
				)

				ORDER BY P.jenis_perkara_nama";

		$query = $this->db->query($sql);

		return $query->result();
	}


	/**
	 * ============================================================
	 * FILTER WILAYAH
	 * ============================================================
	 */
	private function _get_wilayah_condition($wilayah)
	{
		if ($wilayah === 'Semua') {
			return '';
		}

		$hsu_condition = "
			(
				PP1.alamat LIKE '%Hulu Sungai Utara%'
				OR PP1.alamat LIKE '%HSU%'
				OR PP1.alamat LIKE '%Amuntai%'
				OR PP1.alamat LIKE '%Haur Gading%'
				OR PP1.alamat LIKE '%Banjang%'
				OR PP1.alamat LIKE '%Paminggir%'
				OR PP1.alamat LIKE '%Babirik%'
				OR PP1.alamat LIKE '%Sungai Pandan%'
				OR PP1.alamat LIKE '%Danau Panggang%'
				OR PP1.alamat LIKE '%Sungai Tabukan%'
			)
		";

		$balangan_condition = "
			(
				PP1.alamat LIKE '%Balangan%'
				OR PP1.alamat LIKE '%Paringin%'
				OR PP1.alamat LIKE '%Awayan%'
				OR PP1.alamat LIKE '%Tebing Tinggi%'
				OR PP1.alamat LIKE '%Juai%'
				OR PP1.alamat LIKE '%Lampihong%'
				OR PP1.alamat LIKE '%Halong%'
				OR PP1.alamat LIKE '%Batumandi%'
			)
		";

		if ($wilayah === 'HSU') {
			return " AND {$hsu_condition}";
		}

		if ($wilayah === 'Balangan') {
			return " AND {$balangan_condition} AND NOT {$hsu_condition}";
		}

		return '';
	}


	/**
	 * ============================================================
	 * FILTER JENIS PERKARA
	 * ============================================================
	 */
	private function _get_jenis_perkara_condition($jenis_perkara)
	{
		if (
			$jenis_perkara === 'semua'
			|| empty($jenis_perkara)
			|| strtolower($jenis_perkara) === 'semua'
		) {
			return '';
		}

		$jenis_perkara = $this->db->escape_str($jenis_perkara);

		return " AND P.jenis_perkara_nama = '{$jenis_perkara}'";
	}
}
