<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * ============================================================
 * CONTROLLER LAPORAN PERKARA (v3 — export EXCEL tanpa library)
 * ============================================================
 *
 * PERUBAHAN UTAMA (v3):
 *   - Export Excel PAKAI SpreadsheetML (XML Spreadsheet 2003).
 *     Ini format resmi Microsoft Excel, dibangkitkan murni dari
 *     string PHP. TIDAK butuh PHPExcel / PhpSpreadsheet / Composer.
 *     => Kompatibel PHP 8, tidak ada fatal error curly braces.
 *   - Tetap mengeluarkan SEMUA 18 kolom (termasuk Alamat Pihak 1 & 2).
 *   - NIK di-set sebagai String agar angka nol di depan tidak hilang.
 */
class Laporan_perceraian extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		if (!ini_get('date.timezone')) {
			date_default_timezone_set('Asia/Jakarta');
		}

		$this->load->model('M_laporan_perceraian');
		$this->load->helper('url');
		$this->load->helper('text');
		$this->load->helper('date');
	}

	/* ============================================================
	 * HALAMAN LAPORAN
	 * ============================================================ */
	public function index()
	{
		$lap_bulan = validate_bulan($this->input->post('lap_bulan'));
		$lap_tahun = validate_tahun($this->input->post('lap_tahun'));
		$jenis_laporan = validate_jenis_laporan($this->input->post('jenis_laporan'));
		$wilayah = validate_wilayah($this->input->post('wilayah'), 'Semua');
		$jenis_perkara = validate_jenis_perkara($this->input->post('jenis_perkara'), 'semua');

		$data['datafilter'] = array();
		$data['summary'] = null;

		switch ($jenis_laporan) {
			case 'tahunan':
				$data['datafilter'] = $this->M_laporan_perceraian
					->get_laporan_perceraian_tahunan($lap_tahun, $wilayah, $jenis_perkara);
				$data['summary'] = $this->M_laporan_perceraian
					->get_summary_perceraian_tahunan($lap_tahun, $wilayah, $jenis_perkara);
				break;

			case 'custom':
				$tanggal_mulai = validate_tanggal($this->input->post('tanggal_mulai'), date('Y-m-01'));
				$tanggal_akhir = validate_tanggal($this->input->post('tanggal_akhir'), date('Y-m-t'));

				$data['datafilter'] = $this->M_laporan_perceraian
					->get_laporan_perceraian_custom($tanggal_mulai, $tanggal_akhir, $wilayah, $jenis_perkara);
				$data['summary'] = $this->M_laporan_perceraian
					->get_summary_perceraian_custom($tanggal_mulai, $tanggal_akhir, $wilayah, $jenis_perkara);

				$data['selected_tanggal_mulai'] = $tanggal_mulai;
				$data['selected_tanggal_akhir'] = $tanggal_akhir;
				break;

			default: // bulanan
				$data['datafilter'] = $this->M_laporan_perceraian
					->get_laporan_perceraian_bulanan($lap_tahun, $lap_bulan, $wilayah, $jenis_perkara);
				$data['summary'] = $this->M_laporan_perceraian
					->get_summary_perceraian_bulanan($lap_tahun, $lap_bulan, $wilayah, $jenis_perkara);
				break;
		}

		$data['jenis_perkara_list'] = $this->M_laporan_perceraian->get_jenis_perkara_perceraian();

		$data['selected_bulan'] = $lap_bulan;
		$data['selected_tahun'] = $lap_tahun;
		$data['selected_jenis'] = $jenis_laporan;
		$data['selected_wilayah'] = $wilayah;
		$data['selected_jenis_perkara'] = $jenis_perkara;

		$this->load->view('template/new_header');
		$this->load->view('template/new_sidebar');
		$this->load->view('v_laporan_perceraian', $data);
		$this->load->view('template/new_footer');
	}

	/* ============================================================
	 * EXPORT EXCEL — SpreadsheetML (tanpa library)
	 * ============================================================ */
	public function export_excel()
	{
		$lap_bulan = validate_bulan($this->input->post('lap_bulan'));
		$lap_tahun = validate_tahun($this->input->post('lap_tahun'));
		$jenis_laporan = validate_jenis_laporan($this->input->post('jenis_laporan'));
		$wilayah = validate_wilayah($this->input->post('wilayah'), 'Semua');
		$jenis_perkara = validate_jenis_perkara($this->input->post('jenis_perkara'), 'semua');

		/* ---- Ambil data sama seperti tabel di halaman ---- */
		switch ($jenis_laporan) {
			case 'tahunan':
				$data = $this->M_laporan_perceraian
					->get_laporan_perceraian_tahunan($lap_tahun, $wilayah, $jenis_perkara);
				break;

			case 'custom':
				$tanggal_mulai = validate_tanggal($this->input->post('tanggal_mulai'), date('Y-m-01'));
				$tanggal_akhir = validate_tanggal($this->input->post('tanggal_akhir'), date('Y-m-t'));
				$data = $this->M_laporan_perceraian
					->get_laporan_perceraian_custom($tanggal_mulai, $tanggal_akhir, $wilayah, $jenis_perkara);
				break;

			default:
				$data = $this->M_laporan_perceraian
					->get_laporan_perceraian_bulanan($lap_tahun, $lap_bulan, $wilayah, $jenis_perkara);
				break;
		}

		$headers = array(
			'No', 'Nomor Perkara', 'Jenis Perkara',
			'Nama Pihak 1', 'NIK Pihak 1', 'Pekerjaan Pihak 1', 'Alamat Pihak 1',
			'Nama Pihak 2', 'NIK Pihak 2', 'Pekerjaan Pihak 2', 'Alamat Pihak 2',
			'Tanggal Putusan', 'Tanggal BHT', 'Status Putusan',
			'Nomor Akta Cerai', 'No Seri Akta Cerai', 'Tanggal Akta Cerai', 'Tanggal Laporan'
		);

		$rows = array();
		$no = 1;

		foreach ($data as $item) {
			$jenis = (string) $item->jenis_perkara_nama;

			if (
				stripos($jenis, 'Cerai Gugat') !== false
				|| stripos($jenis, 'Cerai Talak') !== false
			) {
				$tanggal_laporan = (string) $item->tgl_akta_cerai;
			} else {
				$tanggal_laporan = (string) $item->tanggal_putusan;
			}

			$rows[] = array(
				$no++,
				$item->nomor_perkara,
				$item->jenis_perkara_nama,
				$item->nama_pihak_1,
				$item->nik_pihak_1,           // string agar nol di depan terjaga
				$item->pekerjaan_pihak_1,
				$item->alamat_pihak_1,
				$item->nama_pihak_2,
				$item->nik_pihak_2,
				$item->pekerjaan_pihak_2,
				$item->alamat_pihak_2,
				$item->tanggal_putusan,
				$item->tanggal_bht,
				$item->status_putusan,
				$item->nomor_akta_cerai,
				$item->no_seri_akta_cerai,
				$item->tgl_akta_cerai,
				$tanggal_laporan,
			);
		}

		$this->_output_spreadsheet_xml('Laporan_Perkara_' . date('Y-m-d'), $headers, $rows);
	}

	/* ============================================================
	 * BUILDER SPREADSHEETML (XML Spreadsheet 2003) — tanpa library
	 * ============================================================ */
	private function _output_spreadsheet_xml($filename, $headers, $rows)
	{
		$xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
		$xml .= '<?mso-application progid="Excel.Sheet"?>' . "\n";
		$xml .= '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"' . "\n";
		$xml .= ' xmlns:o="urn:schemas-microsoft-com:office:office"' . "\n";
		$xml .= ' xmlns:x="urn:schemas-microsoft-com:office:excel"' . "\n";
		$xml .= ' xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"' . "\n";
		$xml .= ' xmlns:html="http://www.w3.org/TR/REC-html40">' . "\n";

		// Styles
		$xml .= ' <Styles>' . "\n";
		$xml .= '  <Style ss:ID="header"><Font ss:Bold="1" ss:Color="#FFFFFF"/><Interior ss:Color="#007BFF" ss:Pattern="Solid"/></Style>' . "\n";
		$xml .= '  <Style ss:ID="text"><Alignment ss:WrapText="1"/></Style>' . "\n";
		$xml .= ' </Styles>' . "\n";

		$count = count($headers);
		$xml .= ' <Worksheet ss:Name="Laporan Perkara">' . "\n";
		$xml .= '  <Table>' . "\n";

		// Header row
		$xml .= '   <Row>' . "\n";
		foreach ($headers as $h) {
			$xml .= '    <Cell ss:StyleID="header"><Data ss:Type="String">' . $this->_xml_escape($h) . '</Data></Cell>' . "\n";
		}
		$xml .= '   </Row>' . "\n";

		// Data rows
		foreach ($rows as $row) {
			$xml .= '   <Row>' . "\n";
			for ($i = 0; $i < $count; $i++) {
				$val = isset($row[$i]) ? $row[$i] : '';
				$isNo = ($i === 0 && is_numeric($val));
				if ($isNo) {
					// Kolom No = nominal
					$xml .= '    <Cell><Data ss:Type="Number">' . $val . '</Data></Cell>' . "\n";
				} else {
					// Semua lainnya string (termasuk NIK, nomor perkara, tanggal)
					$xml .= '    <Cell ss:StyleID="text"><Data ss:Type="String">' . $this->_xml_escape($val) . '</Data></Cell>' . "\n";
				}
			}
			$xml .= '   </Row>' . "\n";
		}

		$xml .= '  </Table>' . "\n";
		$xml .= ' </Worksheet>' . "\n";
		$xml .= '</Workbook>';

		$filename = preg_replace('/[^A-Za-z0-9_\-]/', '_', $filename) . '.xls';

		header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		header('Pragma: public');

		echo $xml;
		exit;
	}

	/**
	 * Escape aman untuk XML.
	 */
	private function _xml_escape($value)
	{
		if ($value === null || $value === '') {
			return '';
		}
		return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
	}
}

/* ============================================================
 * VALIDATOR HELPER (sama seperti versi lama)
 * ============================================================ */
if (!function_exists('validate_bulan')) {
	function validate_bulan($bulan)
	{
		$bulan = trim((string) $bulan);
		if (preg_match('/^\d{1,2}$/', $bulan)) {
			$m = (int) $bulan;
			if ($m >= 1 && $m <= 12) return str_pad($m, 2, '0', STR_PAD_LEFT);
		}
		return date('m');
	}
}

if (!function_exists('validate_tahun')) {
	function validate_tahun($tahun)
	{
		$tahun = trim((string) $tahun);
		if (preg_match('/^\d{4}$/', $tahun)) {
			$y = (int) $tahun;
			if ($y >= 2000 && $y <= (int) date('Y') + 1) return $tahun;
		}
		return date('Y');
	}
}

if (!function_exists('validate_jenis_laporan')) {
	function validate_jenis_laporan($val)
	{
		return in_array($val, array('bulanan', 'tahunan', 'custom')) ? $val : 'bulanan';
	}
}

if (!function_exists('validate_wilayah')) {
	function validate_wilayah($val, $default = 'Semua')
	{
		return in_array($val, array('HSU', 'Balangan', 'Semua')) ? $val : $default;
	}
}

if (!function_exists('validate_tanggal')) {
	function validate_tanggal($tanggal, $default = null)
	{
		if ($default === null) $default = date('Y-m-d');
		$tanggal = trim((string) $tanggal);
		if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) {
			$p = explode('-', $tanggal);
			if (checkdate((int) $p[1], (int) $p[2], (int) $p[0])) return $tanggal;
		}
		return $default;
	}
}

if (!function_exists('validate_jenis_perkara')) {
	function validate_jenis_perkara($val, $default = 'semua')
	{
		$val = trim((string) $val);
		if (empty($val)) return $default;
		if (strtolower($val) === 'istbat_nikah') return 'istbat_nikah';
		return preg_match('/^[a-zA-Z0-9\s\.\-\/]+$/', $val) ? $val : $default;
	}
}
