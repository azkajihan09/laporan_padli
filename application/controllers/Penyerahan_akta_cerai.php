<?php

defined('BASEPATH') or exit('No direct script access allowed');



defined('BASEPATH') or exit('No direct script access allowed');

class Penyerahan_akta_cerai extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_penyerahan_akta_cerai');
	}

	public function index()
	{

		$lap_bulan = $this->input->post('lap_bulan');
		$lap_tahun = $this->input->post('lap_tahun');
		$data['datafilter'] = $this->M_penyerahan_akta_cerai->get_penyerahan_akta_cerai($lap_tahun, $lap_bulan);
		$this->load->view('template/new_header');
		$this->load->view('template/new_sidebar');
		$this->load->view('v_penyerahan_akta_cerai', $data);
		$this->load->view('template/new_footer');
		$this->load->helper('url');
	}
}
