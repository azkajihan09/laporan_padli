<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * ============================================================
 * MODEL LAPORAN PERKARA (v2 — versi bersih & lengkap)
 * ============================================================
 *
 * Perbaikan dibanding versi lama:
 *   1. Nangkep SEMUA varian istbat nikah:
 *        - Istbat Nikah / Itsbat Nikah
 *        - Pengesahan Perkawinan / Pengesahan Nikah
 *   2. Opsi "Istbat Nikah Saja" (token 'istbat_nikah') = hasil
 *      murni perkara permohonan istbat, semua varian.
 *   3. TIDAK lagi membuang nomor perkara '/Pdt.P/' di mode
 *      istbat — karena istbat memang sering register sebagai
 *      Perdata Permohonan (Pdt.P).
 *   4. Filter wilayah + jenis tetap jalan.
 *   5. Satu builder query, tidak duplikasi logika.
 */
class M_laporan_perceraian extends CI_Model
{

	/* ------------ KONDISI DASAR (dipakai semua query) ---------- */

	/**
	 * Kondisi "Gugatan": Cerai Gugat / Cerai Talak
	 */
	private function _gugatan_condition()
	{
		return "(
			P.jenis_perkara_nama LIKE '%Cerai Gugat%'
			OR P.jenis_perkara_nama LIKE '%Cerai Talak%'
		)";
	}

	/**
	 * Kondisi "Istbat / Pengesahan Perkawinan" — semua varian ejaan
	 */
	private function _istbat_condition()
	{
		return "(
			P.jenis_perkara_nama LIKE '%Pengesahan Perkawinan%'
			OR P.jenis_perkara_nama LIKE '%Pengesahan Nikah%'
			OR P.jenis_perkara_nama LIKE '%Istbat Nikah%'
			OR P.jenis_perkara_nama LIKE '%Itsbat Nikah%'
			OR P.jenis_perkara_nama LIKE '%Istbat%'
			OR P.jenis_perkara_nama LIKE '%Itsbat%'
		)";
	}

	/**
	 * Apakah mode "istbat saja" dipilih (token 'istbat_nikah')?
	 */
	private function _is_istbat_only($jenis_perkara)
	{
		return (strtolower(trim((string) $jenis_perkara)) === 'istbat_nikah');
	}

	/**
	 * Kondisi jenis perkara tambahan (selain cabang gugatan/istbat)
	 */
	private function _get_jenis_perkara_condition_adv($jenis_perkara, $istbat_only)
	{
		if ($istbat_only) {
			return ''; // sudah dibatasi ke istbat by _istbat_condition
		}

		$jenis_perkara = strtolower(trim((string) $jenis_perkara));

		if (
			$jenis_perkara === ''
			|| $jenis_perkara === 'semua'
			|| $jenis_perkara === 'semua jenis'
		) {
			return '';
		}

		// kembalikan nilai asli utk exact match
		$jenis = $this->db->escape_str(trim((string) $jenis_perkara));

		return " AND P.jenis_perkara_nama = '{$jenis}'";
	}

	/**
	 * Filter wilayah (HSU / Balangan), sama seperti versi lama
	 */
	private function _get_wilayah_condition($wilayah)
	{
		if ($wilayah === 'Semua' || $wilayah === '') {
			return '';
		}

		$hsu_condition = "(
			EXISTS (SELECT 1 FROM perkara_pihak1 wp
				WHERE wp.perkara_id = P.perkara_id
				AND (
					wp.alamat LIKE '%Hulu Sungai Utara%'
					OR wp.alamat LIKE '%HSU%'
					OR wp.alamat LIKE '%Amuntai%'
					OR wp.alamat LIKE '%Haur Gading%'
					OR wp.alamat LIKE '%Banjang%'
					OR wp.alamat LIKE '%Paminggir%'
					OR wp.alamat LIKE '%Babirik%'
					OR wp.alamat LIKE '%Sungai Pandan%'
					OR wp.alamat LIKE '%Danau Panggang%'
					OR wp.alamat LIKE '%Sungai Tabukan%'
				)
			)
		)";

		$balangan_condition = "(
			EXISTS (SELECT 1 FROM perkara_pihak1 wp
				WHERE wp.perkara_id = P.perkara_id
				AND (
					wp.alamat LIKE '%Balangan%'
					OR wp.alamat LIKE '%Paringin%'
					OR wp.alamat LIKE '%Awayan%'
					OR wp.alamat LIKE '%Tebing Tinggi%'
					OR wp.alamat LIKE '%Juai%'
					OR wp.alamat LIKE '%Lampihong%'
					OR wp.alamat LIKE '%Halong%'
					OR wp.alamat LIKE '%Batumandi%'
				)
			)
		)";

		if ($wilayah === 'HSU') {
			return " AND {$hsu_condition}";
		}

		if ($wilayah === 'Balangan') {
			return " AND {$balangan_condition} AND NOT {$hsu_condition}";
		}

		return '';
	}

	/* ------------ BUILDER WHERE + PARAMS (shared) ------------ */

	/**
	 * Menyusun klausa WHERE lengkap + mengisi $params.
	 * Cabang gugatan DI-SKIP ketika mode istbat_only.
	 */
	private function _where_from_filter(
		$mode,
		$lap_tahun,
		$lap_bulan,
		$tanggal_mulai,
		$tanggal_akhir,
		$wilayah,
		$jenis_perkara,
		&$params
	) {
		$istbat_only = $this->_is_istbat_only($jenis_perkara);

		$where_wilayah = $this->_get_wilayah_condition($wilayah);
		$where_jenis   = $this->_get_jenis_perkara_condition_adv($jenis_perkara, $istbat_only);

		$branch = array();

		// ----- Cabang GUGATAN (cerai) -----
		if (!$istbat_only) {
			$gugatan_date = $this->_date_fragment(
				'C.tgl_akta_cerai', $mode,
				$lap_tahun, $lap_bulan, $tanggal_mulai, $tanggal_akhir,
				$params
			);

			$branch[] = "(
				" . $this->_gugatan_condition() . "
				AND C.tgl_akta_cerai IS NOT NULL
				AND " . $gugatan_date . "
			)";
		}

		// ----- Cabang ISTBAT (permohonan) -----
		$istbat_date = $this->_date_fragment(
			'A.tanggal_putusan', $mode,
			$lap_tahun, $lap_bulan, $tanggal_mulai, $tanggal_akhir,
			$params
		);

		$istbat_cond = "(" . $this->_istbat_condition() . ")";

		// Hanya buang Pdt.P di mode CERAI normal; di mode istbat kita
		// TIDAK membuang Pdt.P (istbat memang register sebagai Pdt.P).
		if (!$istbat_only) {
			$istbat_cond .= " AND P.nomor_perkara NOT LIKE '%/Pdt.P/%'";
		}

		$branch[] = "(
			" . $istbat_cond . "
			AND " . $istbat_date . "
		)";

		$where = "(" . implode(" OR ", $branch) . ")"
			. $where_wilayah
			. $where_jenis;

		return $where;
	}

	/**
	 * Klausa tanggal sesuai mode, & ditambah param ke $params (by ref).
	 */
	private function _date_fragment(
		$col, $mode, $lap_tahun, $lap_bulan,
		$tanggal_mulai, $tanggal_akhir, &$params
	) {
		if ($mode === 'bulanan') {
			$params[] = $lap_tahun;
			$params[] = $lap_bulan;
			return "YEAR({$col}) = ? AND MONTH({$col}) = ?";
		}

		if ($mode === 'tahunan') {
			$params[] = $lap_tahun;
			return "YEAR({$col}) = ?";
		}

		// custom
		$params[] = $tanggal_mulai;
		$params[] = $tanggal_akhir;
		return "DATE({$col}) BETWEEN ? AND ?";
	}

	/* ------------ SELECT LIST (shared) ------------ */

	private function _select_list()
	{
		// GANTI: join tabel pihak1/pihak2 dengan SUBQUERY SCALAR.
		// Alasan: tabel pihak di DB ini multi-row per perkara, sehingga
		// JOIN ngelipet tiap perkara jadi >1 baris. Subquery LIMIT 1
		// memastikan SATU perkara = SATU baris.
		return "SELECT
				P.nomor_perkara,
				P.jenis_perkara_nama,

				P.pihak1_text AS nama_pihak_1,
				(SELECT ph1.nomor_indentitas FROM perkara_pihak1 pp1
					INNER JOIN pihak ph1 ON ph1.id = pp1.pihak_id
					WHERE pp1.perkara_id = P.perkara_id
					ORDER BY pp1.id LIMIT 1) AS nik_pihak_1,
				(SELECT ph1.pekerjaan FROM perkara_pihak1 pp1
					INNER JOIN pihak ph1 ON ph1.id = pp1.pihak_id
					WHERE pp1.perkara_id = P.perkara_id
					ORDER BY pp1.id LIMIT 1) AS pekerjaan_pihak_1,
				(SELECT pp1.alamat FROM perkara_pihak1 pp1
					WHERE pp1.perkara_id = P.perkara_id
					ORDER BY pp1.id LIMIT 1) AS alamat_pihak_1,

				P.pihak2_text AS nama_pihak_2,
				(SELECT ph2.nomor_indentitas FROM perkara_pihak2 pp2
					INNER JOIN pihak ph2 ON ph2.id = pp2.pihak_id
					WHERE pp2.perkara_id = P.perkara_id
					ORDER BY pp2.id LIMIT 1) AS nik_pihak_2,
				(SELECT ph2.pekerjaan FROM perkara_pihak2 pp2
					INNER JOIN pihak ph2 ON ph2.id = pp2.pihak_id
					WHERE pp2.perkara_id = P.perkara_id
					ORDER BY pp2.id LIMIT 1) AS pekerjaan_pihak_2,
				(SELECT pp2.alamat FROM perkara_pihak2 pp2
					WHERE pp2.perkara_id = P.perkara_id
					ORDER BY pp2.id LIMIT 1) AS alamat_pihak_2,

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
				ON SP.id = A.status_putusan_id";
	}

	/* ------------ API PUBLIK ------------ */

	public function get_laporan_perceraian_bulanan(
		$lap_tahun, $lap_bulan, $wilayah = 'Semua', $jenis_perkara = 'semua'
	) {
		$params = array();
		$where = $this->_where_from_filter(
			'bulanan', $lap_tahun, $lap_bulan, null, null,
			$wilayah, $jenis_perkara, $params
		);

		$sql = $this->_select_list()
			. " WHERE " . $where
			. " ORDER BY tanggal_laporan DESC, A.tanggal_putusan DESC";

		return $this->db->query($sql, $params)->result();
	}

	public function get_laporan_perceraian_tahunan(
		$lap_tahun, $wilayah = 'Semua', $jenis_perkara = 'semua'
	) {
		$params = array();
		$where = $this->_where_from_filter(
			'tahunan', $lap_tahun, null, null, null,
			$wilayah, $jenis_perkara, $params
		);

		$sql = $this->_select_list()
			. " WHERE " . $where
			. " ORDER BY tanggal_laporan DESC, A.tanggal_putusan DESC";

		return $this->db->query($sql, $params)->result();
	}

	public function get_laporan_perceraian_custom(
		$tanggal_mulai, $tanggal_akhir, $wilayah = 'Semua', $jenis_perkara = 'semua'
	) {
		$params = array();
		$where = $this->_where_from_filter(
			'custom', null, null, $tanggal_mulai, $tanggal_akhir,
			$wilayah, $jenis_perkara, $params
		);

		$sql = $this->_select_list()
			. " WHERE " . $where
			. " ORDER BY tanggal_laporan DESC, A.tanggal_putusan DESC";

		return $this->db->query($sql, $params)->result();
	}

	/* ------------ SUMMARY ------------ */

	public function get_summary_perceraian_bulanan(
		$lap_tahun, $lap_bulan, $wilayah = 'Semua', $jenis_perkara = 'semua'
	) {
		return $this->_run_summary(
			'bulanan', $lap_tahun, $lap_bulan, null, null,
			$wilayah, $jenis_perkara
		);
	}

	public function get_summary_perceraian_tahunan(
		$lap_tahun, $wilayah = 'Semua', $jenis_perkara = 'semua'
	) {
		return $this->_run_summary(
			'tahunan', $lap_tahun, null, null, null,
			$wilayah, $jenis_perkara
		);
	}

	public function get_summary_perceraian_custom(
		$tanggal_mulai, $tanggal_akhir, $wilayah = 'Semua', $jenis_perkara = 'semua'
	) {
		return $this->_run_summary(
			'custom', null, null, $tanggal_mulai, $tanggal_akhir,
			$wilayah, $jenis_perkara
		);
	}

	private function _run_summary(
		$mode, $lap_tahun, $lap_bulan, $tanggal_mulai, $tanggal_akhir,
		$wilayah, $jenis_perkara
	) {
		$params = array();
		$where = $this->_where_from_filter(
			$mode, $lap_tahun, $lap_bulan, $tanggal_mulai, $tanggal_akhir,
			$wilayah, $jenis_perkara, $params
		);

		$sql = "SELECT
				COUNT(*) AS total_perkara,
				SUM(CASE WHEN P.jenis_perkara_nama LIKE '%Cerai Gugat%' THEN 1 ELSE 0 END) AS cerai_gugat,
				SUM(CASE WHEN P.jenis_perkara_nama LIKE '%Cerai Talak%' THEN 1 ELSE 0 END) AS cerai_talak,
				SUM(CASE WHEN " . $this->_istbat_condition() . " THEN 1 ELSE 0 END) AS istbat_nikah

			FROM perkara AS P

			INNER JOIN perkara_putusan AS A
				ON A.perkara_id = P.perkara_id

			LEFT JOIN perkara_akta_cerai AS C
				ON C.perkara_id = P.perkara_id

			WHERE " . $where;

		return $this->db->query($sql, $params)->row();
	}

	/* ------------ JENIS PERKARA (dropdown) ------------ */

	public function get_jenis_perkara_perceraian()
	{
		$sql = "SELECT DISTINCT
					P.jenis_perkara_nama

				FROM perkara AS P

				WHERE P.jenis_perkara_nama IS NOT NULL
				AND P.jenis_perkara_nama != ''

				AND (
					" . $this->_gugatan_condition() . "
					OR " . $this->_istbat_condition() . "
				)

				ORDER BY P.jenis_perkara_nama";

		return $this->db->query($sql)->result();
	}
}
