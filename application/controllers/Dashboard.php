<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
		$this->load->model('Dashboard_model');
		$currentYear = date('Y');
		$currentMonth = date('m');
		
		// Get enhanced dashboard data
		$data['statistics'] = $this->Dashboard_model->get_statistics($currentYear);
		$data['daily_statistics'] = $this->Dashboard_model->get_daily_statistics();
		$data['yearly_growth'] = $this->Dashboard_model->get_yearly_growth();
		$data['case_types'] = $this->Dashboard_model->get_case_types();
		$data['monthly_classification'] = $this->Dashboard_model->get_monthly_case_classification();
		$data['kinerja_pn'] = $this->Dashboard_model->get_kinerja_pn();
		$data['daily_trend'] = $this->Dashboard_model->get_daily_trend();
		
		$data['currentYear'] = $currentYear;
		$data['currentMonth'] = $currentMonth;
		$data['currentMonthName'] = date('F');

		$this->load->view('template/new_header');
		$this->load->view('template/new_sidebar');
		$this->load->view('dashboard', $data);
		$this->load->view('template/new_footer');
	}
	
	public function get_monthly_data()
	{
		$this->load->model('Dashboard_model');
		$year = $this->input->post('year') ? $this->input->post('year') : date('Y');
		
		$data = [
			'monthly_classification' => $this->Dashboard_model->get_monthly_case_classification(),
			'yearly_growth' => $this->Dashboard_model->get_yearly_growth(),
			'case_types' => $this->Dashboard_model->get_case_types()
		];
		
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	// AJAX endpoint untuk update daily statistics
	public function get_daily_statistics()
	{
		$this->load->model('Dashboard_model');
		$data = $this->Dashboard_model->get_daily_statistics();
		
		header('Content-Type: application/json');
		echo json_encode($data);
	}
} 
?>

