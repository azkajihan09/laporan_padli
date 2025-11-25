<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Penyerahan_akta_cerai extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_penyerahan_akta_cerai');
		$this->load->helper('url');
		$this->load->helper('text');
		$this->load->helper('date');
	}

	public function index()
	{
		// Set default values
		$lap_bulan = $this->input->post('lap_bulan') ?: date('m');
		$lap_tahun = $this->input->post('lap_tahun') ?: date('Y');
		
		$data['datafilter'] = $this->M_penyerahan_akta_cerai->get_penyerahan_akta_cerai($lap_tahun, $lap_bulan);
		$data['summary'] = $this->M_penyerahan_akta_cerai->get_summary_penyerahan($lap_tahun, $lap_bulan);
		$data['selected_bulan'] = $lap_bulan;
		$data['selected_tahun'] = $lap_tahun;
		
		$this->load->view('template/new_header');
		$this->load->view('template/new_sidebar');
		$this->load->view('v_penyerahan_akta_cerai', $data);
		$this->load->view('template/new_footer');
	}
}
