<?php

defined('BASEPATH') or exit('No direct script access allowed');

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


	/**
	 * ============================================================
	 * HALAMAN LAPORAN
	 * ============================================================
	 */
	public function index()
	{
		$lap_bulan = validate_bulan(
			$this->input->post('lap_bulan')
		);

		$lap_tahun = validate_tahun(
			$this->input->post('lap_tahun')
		);

		$jenis_laporan = validate_jenis_laporan(
			$this->input->post('jenis_laporan')
		);

		$wilayah = validate_wilayah(
			$this->input->post('wilayah'),
			'Semua'
		);

		$jenis_perkara = validate_jenis_perkara(
			$this->input->post('jenis_perkara'),
			'semua'
		);


		/**
		 * ========================================================
		 * AMBIL DATA SESUAI JENIS LAPORAN
		 * ========================================================
		 */

		switch ($jenis_laporan) {

			/**
			 * LAPORAN TAHUNAN
			 */
			case 'tahunan':

				$data['datafilter'] =
					$this->M_laporan_perceraian
						->get_laporan_perceraian_tahunan(
							$lap_tahun,
							$wilayah,
							$jenis_perkara
						);

				$data['summary'] =
					$this->M_laporan_perceraian
						->get_summary_perceraian_tahunan(
							$lap_tahun,
							$wilayah,
							$jenis_perkara
						);

				break;


			/**
			 * LAPORAN CUSTOM
			 */
			case 'custom':

				$tanggal_mulai = validate_tanggal(
					$this->input->post('tanggal_mulai'),
					date('Y-m-01')
				);

				$tanggal_akhir = validate_tanggal(
					$this->input->post('tanggal_akhir'),
					date('Y-m-t')
				);

				$data['datafilter'] =
					$this->M_laporan_perceraian
						->get_laporan_perceraian_custom(
							$tanggal_mulai,
							$tanggal_akhir,
							$wilayah,
							$jenis_perkara
						);

				$data['summary'] =
					$this->M_laporan_perceraian
						->get_summary_perceraian_custom(
							$tanggal_mulai,
							$tanggal_akhir,
							$wilayah,
							$jenis_perkara
						);

				$data['selected_tanggal_mulai'] =
					$tanggal_mulai;

				$data['selected_tanggal_akhir'] =
					$tanggal_akhir;

				break;


			/**
			 * LAPORAN BULANAN
			 */
			default:

				$data['datafilter'] =
					$this->M_laporan_perceraian
						->get_laporan_perceraian_bulanan(
							$lap_tahun,
							$lap_bulan,
							$wilayah,
							$jenis_perkara
						);

				$data['summary'] =
					$this->M_laporan_perceraian
						->get_summary_perceraian_bulanan(
							$lap_tahun,
							$lap_bulan,
							$wilayah,
							$jenis_perkara
						);

				break;
		}


		/**
		 * ========================================================
		 * JENIS PERKARA UNTUK DROPDOWN
		 * ========================================================
		 */
		$data['jenis_perkara_list'] =
			$this->M_laporan_perceraian
				->get_jenis_perkara_perceraian();


		/**
		 * ========================================================
		 * NILAI FILTER TERPILIH
		 * ========================================================
		 */
		$data['selected_bulan'] =
			$lap_bulan;

		$data['selected_tahun'] =
			$lap_tahun;

		$data['selected_jenis'] =
			$jenis_laporan;

		$data['selected_wilayah'] =
			$wilayah;

		$data['selected_jenis_perkara'] =
			$jenis_perkara;


		/**
		 * ========================================================
		 * LOAD VIEW
		 * ========================================================
		 */
		$this->load->view(
			'template/new_header'
		);

		$this->load->view(
			'template/new_sidebar'
		);

		$this->load->view(
			'v_laporan_perceraian',
			$data
		);

		$this->load->view(
			'template/new_footer'
		);
	}


	/**
	 * ============================================================
	 * EXPORT EXCEL
	 * ============================================================
	 */
	public function export_excel()
	{
		$lap_bulan = validate_bulan(
			$this->input->post('lap_bulan')
		);

		$lap_tahun = validate_tahun(
			$this->input->post('lap_tahun')
		);

		$jenis_laporan = validate_jenis_laporan(
			$this->input->post('jenis_laporan')
		);

		$wilayah = validate_wilayah(
			$this->input->post('wilayah'),
			'Semua'
		);

		$jenis_perkara = validate_jenis_perkara(
			$this->input->post('jenis_perkara'),
			'semua'
		);


		/**
		 * ========================================================
		 * LOAD PHP EXCEL
		 * ========================================================
		 */
		require_once APPPATH .
			'PHPExcel-1.8/Classes/PHPExcel.php';


		$excel = new PHPExcel();


		/**
		 * ========================================================
		 * INFORMASI FILE
		 * ========================================================
		 */
		$excel->getProperties()
			->setCreator('Laporan PADLI')
			->setLastModifiedBy('System')
			->setTitle('Laporan Perceraian dan Istbat Nikah')
			->setSubject('Laporan Perceraian dan Istbat Nikah')
			->setDescription(
				'Laporan Perceraian dan Pengesahan Perkawinan/Istbat Nikah'
			);


		/**
		 * ========================================================
		 * SHEET
		 * ========================================================
		 */
		$sheet = $excel->setActiveSheetIndex(0);

		$sheet->setTitle(
			'Laporan Perkara'
		);


		/**
		 * ========================================================
		 * HEADER EXCEL
		 * ========================================================
		 */
		$headers = array(

			'No',

			'Nomor Perkara',

			'Jenis Perkara',

			'Nama Pihak 1',

			'NIK Pihak 1',

			'Pekerjaan Pihak 1',

			'Nama Pihak 2',

			'NIK Pihak 2',

			'Pekerjaan Pihak 2',

			'Tanggal Putusan',

			'Tanggal BHT',

			'Status Putusan',

			'Nomor Akta Cerai',

			'No Seri Akta Cerai',

			'Tanggal Akta Cerai',

			'Tanggal Laporan'

		);


		$col = 'A';

		foreach ($headers as $header) {

			$sheet->setCellValue(
				$col . '1',
				$header
			);

			$sheet->getStyle(
				$col . '1'
			)->getFont()->setBold(true);

			$col++;
		}


		/**
		 * ========================================================
		 * AMBIL DATA
		 * ========================================================
		 */
		switch ($jenis_laporan) {

			/**
			 * TAHUNAN
			 */
			case 'tahunan':

				$data =
					$this->M_laporan_perceraian
						->get_laporan_perceraian_tahunan(
							$lap_tahun,
							$wilayah,
							$jenis_perkara
						);

				break;


			/**
			 * CUSTOM
			 */
			case 'custom':

				$tanggal_mulai =
					validate_tanggal(
						$this->input->post('tanggal_mulai'),
						date('Y-m-01')
					);

				$tanggal_akhir =
					validate_tanggal(
						$this->input->post('tanggal_akhir'),
						date('Y-m-t')
					);

				$data =
					$this->M_laporan_perceraian
						->get_laporan_perceraian_custom(
							$tanggal_mulai,
							$tanggal_akhir,
							$wilayah,
							$jenis_perkara
						);

				break;


			/**
			 * BULANAN
			 */
			default:

				$data =
					$this->M_laporan_perceraian
						->get_laporan_perceraian_bulanan(
							$lap_tahun,
							$lap_bulan,
							$wilayah,
							$jenis_perkara
						);

				break;
		}


		/**
		 * ========================================================
		 * ISI DATA EXCEL
		 * ========================================================
		 */
		$row = 2;

		$no = 1;


		foreach ($data as $item) {

			/**
			 * Nomor
			 */
			$sheet->setCellValue(
				'A' . $row,
				$no++
			);


			/**
			 * Nomor Perkara
			 */
			$sheet->setCellValue(
				'B' . $row,
				$item->nomor_perkara
			);


			/**
			 * Jenis Perkara
			 */
			$sheet->setCellValue(
				'C' . $row,
				$item->jenis_perkara_nama
			);


			/**
			 * Pihak 1
			 */
			$sheet->setCellValue(
				'D' . $row,
				$item->nama_pihak_1
			);


			/**
			 * NIK Pihak 1
			 */
			$sheet->setCellValueExplicit(
				'E' . $row,
				$item->nik_pihak_1,
				PHPExcel_Cell_DataType::TYPE_STRING
			);


			/**
			 * Pekerjaan Pihak 1
			 */
			$sheet->setCellValue(
				'F' . $row,
				$item->pekerjaan_pihak_1
			);


			/**
			 * Pihak 2
			 */
			$sheet->setCellValue(
				'G' . $row,
				$item->nama_pihak_2
			);


			/**
			 * NIK Pihak 2
			 */
			$sheet->setCellValueExplicit(
				'H' . $row,
				$item->nik_pihak_2,
				PHPExcel_Cell_DataType::TYPE_STRING
			);


			/**
			 * Pekerjaan Pihak 2
			 */
			$sheet->setCellValue(
				'I' . $row,
				$item->pekerjaan_pihak_2
			);


			/**
			 * Tanggal Putusan
			 */
			$sheet->setCellValue(
				'J' . $row,
				$item->tanggal_putusan
			);


			/**
			 * Tanggal BHT
			 */
			$sheet->setCellValue(
				'K' . $row,
				$item->tanggal_bht
			);


			/**
			 * Status Putusan
			 */
			$sheet->setCellValue(
				'L' . $row,
				$item->status_putusan
			);


			/**
			 * Nomor Akta Cerai
			 */
			$sheet->setCellValue(
				'M' . $row,
				$item->nomor_akta_cerai
			);


			/**
			 * No Seri Akta Cerai
			 */
			$sheet->setCellValue(
				'N' . $row,
				$item->no_seri_akta_cerai
			);


			/**
			 * Tanggal Akta Cerai
			 */
			$sheet->setCellValue(
				'O' . $row,
				$item->tgl_akta_cerai
			);


			/**
			 * Tanggal Laporan
			 *
			 * Cerai:
			 *     Tanggal Akta Cerai
			 *
			 * Istbat:
			 *     Tanggal Putusan
			 */
			if (
				stripos(
					$item->jenis_perkara_nama,
					'Cerai Gugat'
				) !== false
				||
				stripos(
					$item->jenis_perkara_nama,
					'Cerai Talak'
				) !== false
			) {

				$tanggal_laporan =
					$item->tgl_akta_cerai;

			} else {

				$tanggal_laporan =
					$item->tanggal_putusan;
			}


			$sheet->setCellValue(
				'P' . $row,
				$tanggal_laporan
			);


			$row++;
		}


		/**
		 * ========================================================
		 * STYLE HEADER
		 * ========================================================
		 */
		$sheet
			->getStyle('A1:P1')
			->getFont()
			->setBold(true);


		/**
		 * ========================================================
		 * AUTO SIZE
		 * ========================================================
		 */
		foreach (
			range('A', 'P')
			as $columnID
		) {

			$sheet
				->getColumnDimension($columnID)
				->setAutoSize(true);
		}


		/**
		 * ========================================================
		 * FREEZE HEADER
		 * ========================================================
		 */
		$sheet->freezePane('A2');


		/**
		 * ========================================================
		 * OUTPUT EXCEL
		 * ========================================================
		 */
		$filename =
			'Laporan_Perceraian_' .
			date('Y-m-d') .
			'.xls';


		header(
			'Content-Type: application/vnd.ms-excel'
		);

		header(
			'Content-Disposition: attachment;filename="' .
			$filename .
			'"'
		);

		header(
			'Cache-Control: max-age=0'
		);


		$objWriter =
			PHPExcel_IOFactory::createWriter(
				$excel,
				'Excel5'
			);

		$objWriter->save(
			'php://output'
		);

		exit;
	}
}
