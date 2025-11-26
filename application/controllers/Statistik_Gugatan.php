<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Statistik_Gugatan extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("M_statistik_gugatan");
		$this->load->helper('url');
	}

	public function index()
	{
		// Get filter parameters
		$lap_bulan = $this->input->post('lap_bulan') ?: date('m');
		$lap_tahun = $this->input->post('lap_tahun') ?: date('Y');
		$analisis_type = $this->input->post('analisis_type') ?: 'tren_bulanan';

		$data = array();
		$data['selected_bulan'] = $lap_bulan;
		$data['selected_tahun'] = $lap_tahun;
		$data['selected_analisis'] = $analisis_type;

		// Get data based on analysis type
		switch ($analisis_type) {
			case 'tren_bulanan':
				$data['chart_data'] = $this->M_statistik_gugatan->get_tren_bulanan($lap_tahun);
				$data['summary_data'] = $this->M_statistik_gugatan->get_summary_stats($lap_bulan, $lap_tahun);
				break;
			case 'perbandingan_wilayah':
				$data['chart_data'] = $this->M_statistik_gugatan->get_perbandingan_wilayah($lap_tahun);
				$data['summary_data'] = $this->M_statistik_gugatan->get_summary_by_region($lap_tahun);
				break;
			case 'tingkat_keberhasilan':
				$data['chart_data'] = $this->M_statistik_gugatan->get_tingkat_keberhasilan($lap_tahun);
				$data['summary_data'] = $this->M_statistik_gugatan->get_keberhasilan_summary($lap_tahun);
				break;
			case 'waktu_penyelesaian':
				$data['chart_data'] = $this->M_statistik_gugatan->get_waktu_penyelesaian($lap_tahun);
				$data['summary_data'] = $this->M_statistik_gugatan->get_waktu_summary($lap_tahun);
				break;
			case 'demografis_penggugat':
				$data['chart_data'] = $this->M_statistik_gugatan->get_demografis_penggugat($lap_tahun);
				$data['summary_data'] = $this->M_statistik_gugatan->get_demografis_summary($lap_tahun);
				break;
			case 'analisis_tahunan':
				$tahun_mulai = $this->input->post('tahun_mulai') ?: (date('Y') - 4);
				$tahun_akhir = $this->input->post('tahun_akhir') ?: date('Y');
				$data['chart_data'] = $this->M_statistik_gugatan->get_analisis_tahunan($tahun_mulai, $tahun_akhir);
				$data['summary_data'] = $this->M_statistik_gugatan->get_tahunan_summary($tahun_mulai, $tahun_akhir);
				$data['tahun_mulai'] = $tahun_mulai;
				$data['tahun_akhir'] = $tahun_akhir;
				break;
			default:
				$data['chart_data'] = $this->M_statistik_gugatan->get_tren_bulanan($lap_tahun);
				$data['summary_data'] = $this->M_statistik_gugatan->get_summary_stats($lap_bulan, $lap_tahun);
				break;
		}

		// Calculate additional metrics
		$data['total_gugatan'] = $this->M_statistik_gugatan->get_total_gugatan($lap_tahun);
		$data['total_dikabulkan'] = $this->M_statistik_gugatan->get_total_dikabulkan($lap_tahun);
		$data['total_ditolak'] = $this->M_statistik_gugatan->get_total_ditolak($lap_tahun);
		$data['rata_waktu'] = $this->M_statistik_gugatan->get_rata_waktu_penyelesaian($lap_tahun);

		// Load template
		$this->load->view('template/new_header');
		$this->load->view('template/new_sidebar');
		$this->load->view('v_statistik_gugatan', $data);
		$this->load->view('template/new_footer');
	}

	public function export_excel()
	{
		// Get filter parameters
		$lap_tahun = $this->input->post('lap_tahun') ?: date('Y');
		$analisis_type = $this->input->post('analisis_type') ?: 'tren_bulanan';

		// Load PHPExcel library
		require_once APPPATH . 'PHPExcel-1.8/Classes/PHPExcel.php';

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getActiveSheet()->setTitle('Statistik Gugatan');

		// Set headers
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'LAPORAN STATISTIK GUGATAN');
		$objPHPExcel->getActiveSheet()->setCellValue('A2', 'PENGADILAN AGAMA AMUNTAI');
		$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Tahun: ' . $lap_tahun);

		// Get data for export
		$export_data = $this->M_statistik_gugatan->get_export_data($analisis_type, $lap_tahun);

		// Set column headers based on analysis type
		$row = 5;
		switch ($analisis_type) {
			case 'tren_bulanan':
				$objPHPExcel->getActiveSheet()->setCellValue('A' . $row, 'Bulan');
				$objPHPExcel->getActiveSheet()->setCellValue('B' . $row, 'Total Gugatan');
				$objPHPExcel->getActiveSheet()->setCellValue('C' . $row, 'Dikabulkan');
				$objPHPExcel->getActiveSheet()->setCellValue('D' . $row, 'Ditolak');
				$objPHPExcel->getActiveSheet()->setCellValue('E' . $row, 'Dicabut');
				break;
			case 'tingkat_keberhasilan':
				$objPHPExcel->getActiveSheet()->setCellValue('A' . $row, 'Status');
				$objPHPExcel->getActiveSheet()->setCellValue('B' . $row, 'Jumlah');
				$objPHPExcel->getActiveSheet()->setCellValue('C' . $row, 'Persentase');
				break;
			case 'demografis_penggugat':
				$objPHPExcel->getActiveSheet()->setCellValue('A' . $row, 'Jenis Kelamin');
				$objPHPExcel->getActiveSheet()->setCellValue('B' . $row, 'Kategori Usia');
				$objPHPExcel->getActiveSheet()->setCellValue('C' . $row, 'Pekerjaan');
				$objPHPExcel->getActiveSheet()->setCellValue('D' . $row, 'Jumlah');
				break;
			case 'waktu_penyelesaian':
				$objPHPExcel->getActiveSheet()->setCellValue('A' . $row, 'Kategori Waktu');
				$objPHPExcel->getActiveSheet()->setCellValue('B' . $row, 'Jumlah');
				$objPHPExcel->getActiveSheet()->setCellValue('C' . $row, 'Rata-rata Hari');
				$objPHPExcel->getActiveSheet()->setCellValue('D' . $row, 'Persentase');
				break;
				// Add more cases as needed
		}

		// Fill data
		$row++;
		if (!empty($export_data)) {
			foreach ($export_data as $item) {
				$col = 'A';
				foreach ($item as $value) {
					$objPHPExcel->getActiveSheet()->setCellValue($col . $row, $value);
					$col++;
				}
				$row++;
			}
		}

		// Set column widths
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

		// Create Excel Writer
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		// Set headers for download
		$filename = 'Statistik_Gugatan_' . $lap_tahun . '.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		// Save to output
		$objWriter->save('php://output');
	}

	public function get_chart_data()
	{
		// AJAX endpoint for dynamic chart updates
		$tahun = $this->input->post('tahun');
		$analisis_type = $this->input->post('analisis_type');

		$result = array();
		switch ($analisis_type) {
			case 'tren_bulanan':
				$result = $this->M_statistik_gugatan->get_tren_bulanan($tahun);
				break;
			case 'perbandingan_wilayah':
				$result = $this->M_statistik_gugatan->get_perbandingan_wilayah($tahun);
				break;
			case 'tingkat_keberhasilan':
				$result = $this->M_statistik_gugatan->get_tingkat_keberhasilan($tahun);
				break;
			case 'demografis_penggugat':
				$result = $this->M_statistik_gugatan->get_demografis_penggugat($tahun);
				break;
			case 'waktu_penyelesaian':
				$result = $this->M_statistik_gugatan->get_waktu_penyelesaian($tahun);
				break;
			default:
				$result = $this->M_statistik_gugatan->get_tren_bulanan($tahun);
				break;
		}

		header('Content-Type: application/json');
		echo json_encode($result);
	}
}
