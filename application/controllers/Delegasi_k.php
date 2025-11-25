<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Delegasi_k extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("M_delegasi_k");
	}

	public function index()
	{
		$lap_bulan = $this->input->post('lap_bulan');
		$lap_tahun = $this->input->post('lap_tahun');
		$data['datafilter'] = $this->M_delegasi_k->delegasi_k($lap_bulan, $lap_tahun);
		$this->load->view('template/new_header');
		$this->load->view('template/new_sidebar');
		$this->load->view('v_delegasi_k', $data);
		$this->load->view('template/new_footer');	
		$this->load->helper('url');
	}
}
