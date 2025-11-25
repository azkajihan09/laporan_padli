<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Faktor_perceraian_detail extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_faktor_perceraian_detail');
	}

	public function index()
	{
		// Set default values jika tidak ada POST data
		$lap_tahun = $this->input->post('lap_tahun');
		$wilayah = $this->input->post('wilayah');
		
		if(empty($lap_tahun)) {
			$lap_tahun = date('Y');
		}
		if(empty($wilayah)) {
			$wilayah = 'Balangan';
		}
		
		// Prepare data for view
		$data = array();
		$data['datafilter'] = $this->M_faktor_perceraian_detail->data_faktor_perceraian_detail($lap_tahun, $wilayah);
		$data['selected_tahun'] = $lap_tahun;
		$data['selected_wilayah'] = $wilayah;
		
		// Load views
		$this->load->view('template/new_header');
		$this->load->view('template/new_sidebar');
		$this->load->view('v_faktor_perceraian_detail', $data);
		$this->load->view('template/new_footer');
	}
}
