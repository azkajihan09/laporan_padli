<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

defined('BASEPATH') or exit('No direct script access allowed');


class Perkara_Banding extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('M_P_Banding');
		$this->excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
	}
	public function index()
	{
		$lap_tahun = $this->input->post('lap_tahun');
		$lap_bulan = $this->input->post('lap_bulan');
		
		// $data['results'] = $this->M_P_Banding->getData($lap_bulan, $lap_tahun);
		$data['results'] = $this->M_P_Banding->getData($lap_tahun, $lap_bulan);
	
		$this->load->view('template/new_header');
		$this->load->view('template/new_sidebar');
		$this->load->view('v_p_banding', $data);
		$this->load->view('template/new_footer');
	}

	public function generateExcelDocument()
	{
		ini_set('max_execution_time', '60'); //300 seconds = 5 minutes
		ini_set('memory_limit', '512M');
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);

		$lap_tahun = $this->input->post('tahun');
		$lap_bulan = $this->input->post('bulan');
		$data = $this->M_P_Banding->getData($lap_tahun, $lap_bulan);

		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		// Set document properties

		$spreadsheet->getActiveSheet()->setTitle('Laporan');
		$spreadsheet->getActiveSheet()->setCellValue('A1', 'Laporan Perkara Banding ' . $lap_bulan . '-' . $lap_tahun);
		$spreadsheet->getActiveSheet()->setCellValue('A2', 'No');
		$spreadsheet->getActiveSheet()->setCellValue('B2', 'NOMOR PERKARA');
		$spreadsheet->getActiveSheet()->setCellValue('C2', 'PUTUSAN PN');
		$spreadsheet->getActiveSheet()->setCellValue('D2', 'PERMOHONAN BANDING');
		$spreadsheet->getActiveSheet()->setCellValue('E2', 'PEMBERITAHUAN INZAGE');
		$spreadsheet->getActiveSheet()->setCellValue('F2', 'PENGIRIMAN BERKAS BANDING');
		$spreadsheet->getActiveSheet()->setCellValue('G2', 'PUTUSAN BANDING');
		$spreadsheet->getActiveSheet()->setCellValue('H2', 'PEMBERITAHUAN PUTUSAN BANDING');


		$spreadsheet->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
		$spreadsheet->getActiveSheet()->getStyle('A2:H2')->getFont()->setBold(true);
		$spreadsheet->getActiveSheet()->getStyle('A2:H2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFA07A');

		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(20);

		$spreadsheet->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('A2:H2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		foreach ($data as $key => $value) {
			$spreadsheet->getActiveSheet()->setCellValue('A' . ($key + 3), $key + 1);
			$spreadsheet->getActiveSheet()->setCellValue('B' . ($key + 3), $value->nomor_perkara_pn);
			$spreadsheet->getActiveSheet()->setCellValue('C' . ($key + 3), $value->putusan_pn);
			$spreadsheet->getActiveSheet()->setCellValue('D' . ($key + 3), $value->permohonan_banding);
			$spreadsheet->getActiveSheet()->setCellValue('E' . ($key + 3), $value->pemberitahuan_inzage);
			$spreadsheet->getActiveSheet()->setCellValue('F' . ($key + 3), $value->pengiriman_berkas_banding);
			$spreadsheet->getActiveSheet()->setCellValue('G' . ($key + 3), $value->putusan_banding);
			$spreadsheet->getActiveSheet()->setCellValue('H' . ($key + 3), $value->pemberitahuan_putusan_banding);
		}

		$filename = 'Laporan Perkara Banding ' . $lap_bulan . '-' . $lap_tahun . '.xlsx';
		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '"');

		$writer->save('php://output');
	}
}



