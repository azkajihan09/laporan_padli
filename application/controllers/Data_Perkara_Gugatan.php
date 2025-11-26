<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Data_Perkara_Gugatan extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("M_data_perkara_gugatan");
		$this->load->helper('url');
	}

	public function index()
	{
		// Get filter parameters
		$wilayah = $this->input->post('wilayah') ?: 'HSU'; // Default HSU
		$lap_bulan = $this->input->post('lap_bulan') ?: date('m');
		$lap_tahun = $this->input->post('lap_tahun') ?: date('Y');
		$jenis_perkara = $this->input->post('jenis_perkara') ?: 'Cerai Gugat';
		$report_type = $this->input->post('report_type') ?: 'summary';

		$data = array();
		$data['selected_wilayah'] = $wilayah;
		$data['selected_bulan'] = $lap_bulan;
		$data['selected_tahun'] = $lap_tahun;
		$data['selected_jenis'] = $jenis_perkara;
		$data['selected_report'] = $report_type;

		// Get data based on report type and region
		switch ($report_type) {
			case 'summary':
				$data['datafilter'] = $this->M_data_perkara_gugatan->data_summary_perceraian($lap_bulan, $lap_tahun, $jenis_perkara, $wilayah);
				break;
			case 'yearly':
				$data['datafilter'] = $this->M_data_perkara_gugatan->data_yearly_perceraian($lap_tahun, $jenis_perkara, $wilayah);
				break;
			case 'monthly':
				$data['datafilter'] = $this->M_data_perkara_gugatan->data_monthly_perceraian($lap_tahun, $jenis_perkara, $wilayah);
				break;
			case 'comparison':
				$data['datafilter'] = $this->M_data_perkara_gugatan->data_comparison_gugat_talak($lap_bulan, $lap_tahun, $wilayah);
				break;
			case 'faktor':
				$jenis_kelamin = $this->input->post('jenis_kelamin') ?: '';
				$data['selected_gender'] = $jenis_kelamin;
				$data['datafilter'] = $this->M_data_perkara_gugatan->data_faktor_perceraian($lap_tahun, $wilayah, $jenis_kelamin);
				break;
			case 'faktor_detail':
				$data['datafilter'] = $this->M_data_perkara_gugatan->data_faktor_perceraian_detail($lap_bulan, $lap_tahun, $wilayah);
				break;
			default:
				$data['datafilter'] = $this->M_data_perkara_gugatan->data_summary_perceraian($lap_bulan, $lap_tahun, $jenis_perkara, $wilayah);
		}

		// Get dropdown data for view
		$data['jenis_perkara_list'] = $this->M_data_perkara_gugatan->get_jenis_perkara_gugatan();

		// Load views
		$this->load->view('template/new_header');
		$this->load->view('template/new_sidebar');
		$this->load->view('v_data_perkara_gugatan', $data);
		$this->load->view('template/new_footer');
	}

	// Export functions
	public function export_excel()
	{
		$wilayah = $this->input->post('wilayah') ?: 'HSU';
		$lap_bulan = $this->input->post('lap_bulan') ?: date('m');
		$lap_tahun = $this->input->post('lap_tahun') ?: date('Y');
		$jenis_perkara = $this->input->post('jenis_perkara') ?: 'Cerai Gugat';
		$report_type = $this->input->post('report_type') ?: 'summary';

		// Get data for export
		switch ($report_type) {
			case 'summary':
				$data = $this->M_data_perkara_gugatan->data_summary_perceraian($lap_bulan, $lap_tahun, $jenis_perkara, $wilayah);
				break;
			case 'yearly':
				$data = $this->M_data_perkara_gugatan->data_yearly_perceraian($lap_tahun, $jenis_perkara, $wilayah);
				break;
			case 'monthly':
				$data = $this->M_data_perkara_gugatan->data_monthly_perceraian($lap_tahun, $jenis_perkara, $wilayah);
				break;
			case 'comparison':
				$data = $this->M_data_perkara_gugatan->data_comparison_gugat_talak($lap_bulan, $lap_tahun, $wilayah);
				break;
			case 'faktor':
				$jenis_kelamin = $this->input->post('jenis_kelamin') ?: '';
				$data = $this->M_data_perkara_gugatan->data_faktor_perceraian($lap_tahun, $wilayah, $jenis_kelamin);
				break;
			case 'faktor_detail':
				$data = $this->M_data_perkara_gugatan->data_faktor_perceraian_detail($lap_bulan, $lap_tahun, $wilayah);
				break;
			default:
				$data = $this->M_data_perkara_gugatan->data_summary_perceraian($lap_bulan, $lap_tahun, $jenis_perkara, $wilayah);
		}

		// Load PHPExcel library and create export
		$this->load->library('PHPExcel');
		$excel = new PHPExcel();

		// Set document properties
		$excel->getProperties()
			->setCreator("PA Amuntai")
			->setTitle("Data Perkara Gugatan - " . ucwords(str_replace('_', ' ', $report_type)))
			->setDescription("Laporan Data Perkara Gugatan " . strtoupper($wilayah) . " - " . date('F Y', mktime(0, 0, 0, $lap_bulan, 1, $lap_tahun)));

		$sheet = $excel->getActiveSheet();

		// Set headers based on report type
		$this->_set_excel_headers($sheet, $report_type);

		// Add data to excel
		$this->_add_excel_data($sheet, $data, $report_type);

		// Set filename
		$filename = 'Data_Perkara_Gugatan_' . $wilayah . '_' . $report_type . '_' . $lap_bulan . '_' . $lap_tahun . '.xlsx';

		// Output file
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$writer->save('php://output');
	}

	private function _set_excel_headers($sheet, $report_type)
	{
		switch ($report_type) {
			case 'summary':
			case 'yearly':
			case 'monthly':
				$sheet->setCellValue('A1', 'Kecamatan');
				$sheet->setCellValue('B1', 'Perkara Masuk');
				$sheet->setCellValue('C1', 'Perkara Putus');
				$sheet->setCellValue('D1', 'Perkara Telah BHT');
				$sheet->setCellValue('E1', 'Jumlah Akta Cerai');
				break;
			case 'comparison':
				$sheet->setCellValue('A1', 'Kecamatan');
				$sheet->setCellValue('B1', 'Cerai Gugat');
				$sheet->setCellValue('C1', 'Cerai Talak');
				$sheet->setCellValue('D1', 'Total');
				break;
			case 'faktor':
			case 'faktor_detail':
				$sheet->setCellValue('A1', 'Faktor Perceraian');
				$sheet->setCellValue('B1', 'Jumlah Kasus');
				$sheet->setCellValue('C1', 'Persentase');
				break;
		}
	}

	private function _add_excel_data($sheet, $data, $report_type)
	{
		$row = 2;
		foreach ($data as $item) {
			switch ($report_type) {
				case 'summary':
				case 'yearly':
				case 'monthly':
					$sheet->setCellValue('A' . $row, $item->KECAMATAN);
					$sheet->setCellValue('B' . $row, $item->PERKARA_MASUK);
					$sheet->setCellValue('C' . $row, $item->PERKARA_PUTUS);
					$sheet->setCellValue('D' . $row, $item->PERKARA_TELAH_BHT);
					$sheet->setCellValue('E' . $row, $item->JUMLAH_AKTA_CERAI);
					break;
				case 'comparison':
					$sheet->setCellValue('A' . $row, $item->KECAMATAN);
					$sheet->setCellValue('B' . $row, $item->CERAI_GUGAT);
					$sheet->setCellValue('C' . $row, $item->CERAI_TALAK);
					$sheet->setCellValue('D' . $row, $item->TOTAL);
					break;
				case 'faktor':
				case 'faktor_detail':
					$sheet->setCellValue('A' . $row, isset($item->faktor_perceraian) ? $item->faktor_perceraian : $item->FAKTOR);
					$sheet->setCellValue('B' . $row, isset($item->jumlah) ? $item->jumlah : $item->JUMLAH);
					$sheet->setCellValue('C' . $row, isset($item->persentase) ? $item->persentase . '%' : (isset($item->PERSENTASE) ? $item->PERSENTASE . '%' : '0%'));
					break;
			}
			$row++;
		}
	}
}
