<!-- Content Wrapper. Contains page content -->
<?php
date_default_timezone_set('Asia/Jakarta');
$currentMonthName = date('F');
$currentYear = date('Y');
$currentDate = date('d F Y');
?>
<div class="content-wrapper modern-dashboard">

	<style>
		/* AdminLTE 3 Dashboard Styles */
		.modern-dashboard {
			background: #f4f6f9;
			min-height: 100vh;
		}

		.content-wrapper {
			background: #f4f6f9 !important;
		}

		.content-header {
			background: #ffffff;
			padding: 15px 30px;
			margin-bottom: 30px;
			border-bottom: 1px solid #dee2e6;
		}

		.dashboard-title {
			color: #495057;
			font-weight: 600;
			font-size: 1.8rem;
			margin: 0;
		}

		.dashboard-subtitle {
			color: #6c757d;
			font-size: 0.9rem;
			margin: 5px 0 0 0;
		}

		.breadcrumb {
			background: transparent;
			padding: 0;
			margin-bottom: 0;
		}

		.breadcrumb-item a {
			color: #007bff;
			text-decoration: none;
		}

		.breadcrumb-item a:hover {
			color: #0056b3;
		}

		.breadcrumb-item.active {
			color: #6c757d;
		}

		/* Welcome Card AdminLTE 3 */
		.welcome-card {
			background: #ffffff;
			border-radius: 0.375rem;
			padding: 30px;
			margin: 0 0 30px 0;
			box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
			border: 0;
		}



		@keyframes float {

			0%,
			100% {
				transform: translateY(0px) rotate(0deg);
			}

			50% {
				transform: translateY(-15px) rotate(180deg);
			}
		}

		.welcome-content {
			display: flex;
			justify-content: space-between;
			align-items: center;
			position: relative;
			z-index: 2;
		}

		.welcome-title {
			font-size: 1.8rem;
			font-weight: 600;
			margin-bottom: 10px;
			color: #495057;
		}

		.welcome-subtitle {
			font-size: 1.1rem;
			color: #6c757d;
			margin: 0;
		}

		.welcome-icon {
			font-size: 3rem;
			color: #007bff;
		}

		@keyframes pulse {

			0%,
			100% {
				transform: scale(1);
			}

			50% {
				transform: scale(1.05);
			}
		}

		/* Statistics Cards */
		.stat-card {
			background: rgba(255, 255, 255, 0.95);
			backdrop-filter: blur(20px);
			border-radius: 20px;
			border: 1px solid rgba(255, 255, 255, 0.3);
			box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
			transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
			overflow: hidden;
			position: relative;
			height: 100%;
		}

		.stat-card::before {
			content: '';
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			height: 5px;
			transition: height 0.3s ease;
		}

		.stat-card:hover {
			transform: translateY(-15px) scale(1.02);
			box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
		}

		.stat-card:hover::before {
			height: 8px;
		}

		.stat-card-primary::before {
			background: linear-gradient(90deg, #667eea, #764ba2);
		}

		.stat-card-success::before {
			background: linear-gradient(90deg, #56ab2f, #a8e6cf);
		}

		.stat-card-warning::before {
			background: linear-gradient(90deg, #f093fb, #f5576c);
		}

		.stat-card-danger::before {
			background: linear-gradient(90deg, #4facfe, #00f2fe);
		}

		.stat-card-body {
			padding: 20px;
			display: flex;
			align-items: center;
			justify-content: space-between;
			position: relative;
		}

		.stat-card-icon {
			font-size: 2.5rem;
			color: rgba(255, 255, 255, .8);
			margin-left: auto;
		}



		.stat-card-primary {
			background: #007bff;
			color: #ffffff;
		}

		.stat-card-success .stat-card-icon {
			background: linear-gradient(135deg, #56ab2f, #a8e6cf);
		}

		.stat-card-warning {
			background: #ffc107;
			color: #212529;
		}

		.stat-card-danger {
			background: #dc3545;
			color: #ffffff;
		}

		.stat-card-content {
			flex: 1;
		}

		.stat-card-number {
			font-size: 2rem;
			font-weight: 700;
			margin: 0;
			line-height: 1;
			color: inherit;
		}

		.stat-card-label {
			font-size: 0.9rem;
			font-weight: 500;
			color: inherit;
			margin: 5px 0 0 0;
			opacity: 0.8;
		}

		.stat-card-breakdown {
			margin: 10px 0;
			padding: 10px;
			background: rgba(102, 126, 234, 0.05);
			border-radius: 8px;
		}

		.breakdown-item {
			display: flex;
			justify-content: space-between;
			margin-bottom: 5px;
			font-size: 0.85rem;
		}

		.breakdown-label {
			color: #6c757d;
			font-weight: 500;
		}

		.breakdown-value {
			color: #2c3e50;
			font-weight: 700;
		}

		.stat-card-progress {
			margin-top: 15px;
		}

		.stat-card-progress .progress {
			height: 8px;
			border-radius: 10px;
			background: rgba(0, 0, 0, 0.1);
			overflow: hidden;
			position: relative;
		}

		.stat-card-progress .progress-bar {
			border-radius: 10px;
			transition: width 2s cubic-bezier(0.4, 0, 0.2, 1);
			position: relative;
			overflow: hidden;
		}

		.stat-card-progress .progress-bar::before {
			content: '';
			position: absolute;
			top: 0;
			left: -100%;
			width: 100%;
			height: 100%;
			background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
			animation: progressShine 2s infinite;
		}

		@keyframes progressShine {
			0% {
				left: -100%;
			}

			100% {
				left: 100%;
			}
		}

		.stat-card-primary .progress-bar {
			background: linear-gradient(90deg, #667eea, #764ba2);
		}

		.stat-card-success .progress-bar {
			background: linear-gradient(90deg, #56ab2f, #a8e6cf);
		}

		.stat-card-warning .progress-bar {
			background: linear-gradient(90deg, #f093fb, #f5576c);
		}

		.stat-card-danger .progress-bar {
			background: linear-gradient(90deg, #4facfe, #00f2fe);
		}

		/* Chart Cards */
		.chart-card {
			background: rgba(255, 255, 255, 0.95);
			backdrop-filter: blur(20px);
			border-radius: 25px;
			box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
			overflow: hidden;
			transition: all 0.3s ease;
			border: 1px solid rgba(255, 255, 255, 0.3);
			margin: 0 20px;
		}

		.chart-card:hover {
			transform: translateY(-8px);
			box-shadow: 0 25px 70px rgba(0, 0, 0, 0.15);
		}

		.chart-card-header {
			padding: 15px 20px;
			background: #ffffff;
			border-bottom: 1px solid #dee2e6;
			display: flex;
			justify-content: space-between;
			align-items: center;
			border-radius: 6px 6px 0 0;
		}

		.chart-card-title {
			font-size: 1.2rem;
			font-weight: 500;
			margin: 0;
			color: #495057;
			font-family: 'Source Sans Pro', sans-serif;
		}

		.chart-card-body {
			padding: 20px;
			height: 300px;
			position: relative;
			background: #ffffff;
			border-radius: 0 0 6px 6px;
		}

		/* Performance Card */
		.performance-card {
			background: #ffffff;
			border-radius: 6px;
			box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
			border: 0;
			transition: all 0.3s ease;
			margin: 0 20px;
			position: relative;
		}



		.performance-card:hover {
			box-shadow: 0 2px 8px rgba(0, 0, 0, .15);
		}

		.performance-header {
			padding: 25px 30px 20px 30px;
			text-align: center;
		}

		.performance-title {
			font-size: 1.4rem;
			font-weight: 700;
			margin: 0 0 10px 0;
			background: linear-gradient(135deg, #667eea, #764ba2);
			-webkit-background-clip: text;
			-webkit-text-fill-color: transparent;
			background-clip: text;
		}

		.performance-subtitle {
			color: #6c757d;
			font-size: 0.9rem;
			margin: 0;
		}

		.performance-body {
			padding: 0 30px 30px 30px;
		}

		.performance-circle {
			width: 200px;
			height: 200px;
			margin: 0 auto 20px auto;
			position: relative;
		}

		.performance-stats {
			display: grid;
			grid-template-columns: repeat(2, 1fr);
			gap: 15px;
			margin-top: 20px;
		}

		.performance-stat {
			text-align: center;
			padding: 15px;
			background: #f8f9fa;
			border-radius: 6px;
			border: 1px solid #dee2e6;
		}

		.performance-stat-number {
			font-size: 1.5rem;
			font-weight: 600;
			margin: 0 0 5px 0;
			color: #495057;
			font-family: 'Source Sans Pro', sans-serif;
		}

		.performance-stat-label {
			font-size: 0.8rem;
			color: #6c757d;
			margin: 0;
			text-transform: uppercase;
			letter-spacing: 0.5px;
		}

		/* Responsive Design */
		@media (max-width: 768px) {
			.content-header {
				margin: 10px;
				padding: 20px;
			}

			.welcome-card {
				margin: 0 10px 20px 10px;
				padding: 25px;
			}

			.welcome-content {
				flex-direction: column;
				text-align: center;
			}

			.welcome-icon {
				margin-top: 20px;
				font-size: 4rem;
			}

			.chart-card {
				margin: 0 10px;
			}

			.stat-card-body {
				padding: 25px;
			}

			.stat-card-number {
				font-size: 2.2rem;
			}

			.dashboard-title {
				font-size: 2rem;
			}
		}

		/* Loading Animation */
		.loading {
			opacity: 0;
			animation: fadeInUp 0.8s ease forwards;
		}

		@keyframes fadeInUp {
			from {
				opacity: 0;
				transform: translateY(30px);
			}

			to {
				opacity: 1;
				transform: translateY(0);
			}
		}

		.stat-card:nth-child(1) {
			animation-delay: 0.1s;
		}

		.stat-card:nth-child(2) {
			animation-delay: 0.2s;
		}

		.stat-card:nth-child(3) {
			animation-delay: 0.3s;
		}

		.stat-card:nth-child(4) {
			animation-delay: 0.4s;
		}
	</style>

	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="dashboard-title">
						<i class="fas fa-chart-line mr-3"></i>Dashboard
					</h1>
					<p class="dashboard-subtitle">Sistem Laporan Perkara PA Amuntai</p>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Home</a></li>
						<li class="breadcrumb-item active">Dashboard</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<!-- Welcome Section -->
			<div class="row mb-4">
				<div class="col-12">
					<div class="welcome-card loading">
						<div class="welcome-content">
							<div class="welcome-text">
								<h2 class="welcome-title">
									<i class="fas fa-calendar-alt mr-2"></i>
									Dashboard PA Amuntai - <?php echo $currentYear; ?>
								</h2>
								<p class="welcome-subtitle">
									<i class="fas fa-clock mr-2"></i>
									Update terakhir: <?php echo date('d F Y H:i'); ?> WITA
								</p>
							</div>
							<div class="welcome-icon">
								<i class="fas fa-balance-scale"></i>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Simplified Statistics Cards -->
			<div class="row">
				<div class="col-lg-4 col-md-6 col-sm-12 mb-4">
					<div class="stat-card stat-card-primary loading">
						<div class="stat-card-body">
							<div class="stat-card-icon">
								<i class="fas fa-gavel"></i>
							</div>
							<div class="stat-card-content">
								<h3 class="stat-card-number" data-target="<?php echo $statistics->total_perkara; ?>">0</h3>
								<p class="stat-card-label">Total Perkara</p>
								<div class="stat-card-breakdown">
									<div class="breakdown-item">
										<span class="breakdown-label">e-Court:</span>
										<span class="breakdown-value">
											<?php echo $statistics->total_perkara_ecourt; ?>
											<span class="text-success font-weight-bold ml-1">
												(<?php echo number_format($statistics->persen_perkara_ecourt, 1); ?>%)
											</span>
										</span>
									</div>
									<div class="breakdown-item">
										<span class="breakdown-label">Non e-Court:</span>
										<span class="breakdown-value">
											<?php echo $statistics->total_perkara_non_ecourt; ?>
											<span class="text-info font-weight-bold ml-1">
												(<?php echo number_format(100 - $statistics->persen_perkara_ecourt, 1); ?>%)
											</span>
										</span>
									</div>
								</div>
								<div class="stat-card-progress">
									<div class="progress">
										<div class="progress-bar" data-width="100"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-4 col-md-6 col-sm-12 mb-4">
					<div class="stat-card stat-card-success loading">
						<div class="stat-card-body">
							<div class="stat-card-icon">
								<i class="fas fa-stamp"></i>
							</div>
							<div class="stat-card-content">
								<h3 class="stat-card-number" data-target="<?php echo isset($daily_statistics->perkara_putus_hari_ini) ? $daily_statistics->perkara_putus_hari_ini : 0; ?>">0</h3>
								<p class="stat-card-label">Perkara Putus</p>
								<div class="stat-card-breakdown">
									<div class="breakdown-item">
										<span class="breakdown-label">Hari Ini:</span>
										<span class="breakdown-value"><?php echo isset($daily_statistics->perkara_putus_hari_ini) ? $daily_statistics->perkara_putus_hari_ini : 0; ?></span>
									</div>
									<div class="breakdown-item">
										<span class="breakdown-label">Bulan Ini:</span>
										<span class="breakdown-value"><?php echo isset($monthly_statistics->perkara_putus_bulan_ini) ? $monthly_statistics->perkara_putus_bulan_ini : 0; ?></span>
									</div>
									<div class="breakdown-item">
										<span class="breakdown-label">Tahun Ini:</span>
										<span class="breakdown-value"><?php echo isset($yearly_statistics->perkara_putus_tahun_ini) ? $yearly_statistics->perkara_putus_tahun_ini : 0; ?></span>
									</div>
								</div>
								<div class="stat-card-progress">
									<div class="progress">
										<div class="progress-bar" data-width="75"></div>
									</div>
								</div>
								<small class="text-muted mt-2"><?php echo date('d F Y'); ?></small>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-4 col-md-6 col-sm-12 mb-4">
					<div class="stat-card stat-card-warning loading">
						<div class="stat-card-body">
							<div class="stat-card-icon">
								<i class="fas fa-file-signature"></i>
							</div>
							<div class="stat-card-content">
								<h3 class="stat-card-number" data-target="<?php echo isset($daily_statistics->perkara_minutasi_hari_ini) ? $daily_statistics->perkara_minutasi_hari_ini : 0; ?>">0</h3>
								<p class="stat-card-label">Minutasi</p>
								<div class="stat-card-breakdown">
									<div class="breakdown-item">
										<span class="breakdown-label">Hari Ini:</span>
										<span class="breakdown-value"><?php echo isset($daily_statistics->perkara_minutasi_hari_ini) ? $daily_statistics->perkara_minutasi_hari_ini : 0; ?></span>
									</div>
									<div class="breakdown-item">
										<span class="breakdown-label">Bulan Ini:</span>
										<span class="breakdown-value"><?php echo isset($monthly_statistics->perkara_minutasi_bulan_ini) ? $monthly_statistics->perkara_minutasi_bulan_ini : 0; ?></span>
									</div>
									<div class="breakdown-item">
										<span class="breakdown-label">Tahun Ini:</span>
										<span class="breakdown-value"><?php echo isset($yearly_statistics->perkara_minutasi_tahun_ini) ? $yearly_statistics->perkara_minutasi_tahun_ini : 0; ?></span>
									</div>
								</div>
								<div class="stat-card-progress">
									<div class="progress">
										<div class="progress-bar" data-width="60"></div>
									</div>
								</div>
								<small class="text-muted mt-2"><?php echo date('d F Y'); ?></small>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Enhanced Charts Section -->
			<div class="row">
				<div class="col-lg-6 col-12 mb-4">
					<div class="chart-card loading">
						<div class="chart-card-header">
							<h3 class="chart-card-title">
								<i class="fas fa-chart-line mr-2"></i>
								Pertumbuhan Perkara per Tahun
							</h3>
						</div>
						<div class="chart-card-body">
							<canvas id="yearlyGrowthChart"></canvas>
						</div>
					</div>
				</div>

				<div class="col-lg-6 col-12 mb-4">
					<div class="chart-card loading">
						<div class="chart-card-header">
							<h3 class="chart-card-title">
								<i class="fas fa-chart-pie mr-2"></i>
								Komposisi Jenis Perkara
							</h3>
						</div>
						<div class="chart-card-body">
							<canvas id="caseTypeChart"></canvas>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-8 col-12 mb-4">
					<div class="chart-card loading">
						<div class="chart-card-header">
							<h3 class="chart-card-title">
								<i class="fas fa-chart-bar mr-2"></i>
								Perkara Masuk per Klasifikasi (Bulanan)
							</h3>
						</div>
						<div class="chart-card-body">
							<canvas id="monthlyClassificationChart"></canvas>
						</div>
					</div>
				</div>

				<div class="col-lg-4 col-12 mb-4">
					<div class="performance-card loading">
						<div class="performance-header">
							<h3 class="performance-title">
								<i class="fas fa-tachometer-alt mr-2"></i>
								Kinerja PA Amuntai
							</h3>
							<p class="performance-subtitle">Tahun <?php echo $currentYear; ?></p>
						</div>
						<div class="performance-body">
							<div class="performance-circle">
								<canvas id="performanceChart"></canvas>
							</div>
							<div class="performance-stats">
								<div class="performance-stat">
									<div class="performance-stat-number"><?php echo isset($kinerja_pn->masuk) ? number_format($kinerja_pn->masuk) : '0'; ?></div>
									<div class="performance-stat-label">Masuk</div>
								</div>
								<div class="performance-stat">
									<div class="performance-stat-number"><?php echo isset($kinerja_pn->minutasi) ? number_format($kinerja_pn->minutasi) : '0'; ?></div>
									<div class="performance-stat-label">Minutasi</div>
								</div>
								<div class="performance-stat">
									<div class="performance-stat-number"><?php echo isset($kinerja_pn->sisa) ? number_format($kinerja_pn->sisa) : '0'; ?></div>
									<div class="performance-stat-label">Sisa Perkara Tahun Lalu</div>
								</div>
								<div class="performance-stat">
									<div class="performance-stat-number"><?php echo isset($kinerja_pn->putusan) ? number_format($kinerja_pn->putusan) : '0'; ?></div>
									<div class="performance-stat-label">Putusan</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<script>
	// Animation for numbers
	function animateNumbers() {
		$('.stat-card-number').each(function() {
			const $this = $(this);
			const target = parseFloat($this.data('target'));

			$({
				counter: 0
			}).animate({
				counter: target
			}, {
				duration: 2000,
				easing: 'easeOutQuart',
				step: function() {
					$this.text(Math.ceil(this.counter).toLocaleString());
				},
				complete: function() {
					$this.text(target.toLocaleString());
				}
			});
		});
	}

	// Animation for progress bars
	function animateProgressBars() {
		$('.progress-bar').each(function() {
			const $this = $(this);
			const width = $this.data('width');

			setTimeout(() => {
				$this.css('width', width + '%');
			}, 500);
		});
	}

	// Chart configurations
	const chartOptions = {
		responsive: true,
		maintainAspectRatio: false,
		plugins: {
			legend: {
				position: 'bottom',
				labels: {
					font: {
						size: 12,
						weight: 'bold'
					},
					padding: 20,
					usePointStyle: true
				}
			},
			tooltip: {
				backgroundColor: 'rgba(0, 0, 0, 0.8)',
				titleColor: '#fff',
				bodyColor: '#fff',
				borderColor: 'rgba(255, 255, 255, 0.2)',
				borderWidth: 1,
				cornerRadius: 8
			}
		},
		animation: {
			animateRotate: true,
			animateScale: true,
			duration: 2000,
			easing: 'easeOutQuart'
		}
	};

	// Initialize Charts Data
	const kinerjaPN = <?php echo isset($kinerja_pn->kinerjaPN) ? $kinerja_pn->kinerjaPN : 0; ?>;
	const warnaPN = '<?php echo isset($kinerja_pn->warnaPN) ? $kinerja_pn->warnaPN : '#def30c'; ?>';

	// Sample data for yearly growth (replace with actual data from backend)
	const yearlyGrowthData = {
		labels: ['2020', '2021', '2022', '2023', '2024', '2025'],
		data: [<?php echo isset($yearly_growth) ? implode(',', $yearly_growth) : '850,920,1150,1280,1420,1350'; ?>]
	};

	// Sample data for case types (replace with actual data from backend)
	const caseTypeData = {
		labels: ['Gugatan', 'Permohonan'],
		data: [<?php echo isset($case_types->gugatan) ? $case_types->gugatan : 420; ?>, <?php echo isset($case_types->permohonan) ? $case_types->permohonan : 930; ?>]
	};

	// Sample data for monthly classification (replace with actual data from backend)
	const monthlyClassificationData = {
		labels: <?php echo json_encode($monthly_classification->labels); ?>,
		datasets: <?php echo json_encode($monthly_classification->datasets); ?>
	};

	// Yearly Growth Chart
	const yearlyGrowthChart = new Chart(document.getElementById('yearlyGrowthChart'), {
		type: 'line',
		data: {
			labels: yearlyGrowthData.labels,
			datasets: [{
				label: 'Total Perkara',
				data: yearlyGrowthData.data,
				backgroundColor: 'rgba(102, 126, 234, 0.1)',
				borderColor: 'rgba(102, 126, 234, 1)',
				borderWidth: 4,
				fill: true,
				tension: 0.4,
				pointBackgroundColor: 'rgba(102, 126, 234, 1)',
				pointBorderColor: '#fff',
				pointBorderWidth: 3,
				pointRadius: 8,
				pointHoverRadius: 10
			}]
		},
		options: {
			...chartOptions,
			scales: {
				y: {
					beginAtZero: false,
					grid: {
						color: 'rgba(0, 0, 0, 0.1)'
					},
					ticks: {
						color: '#6c757d',
						callback: function(value) {
							return value.toLocaleString();
						}
					}
				},
				x: {
					grid: {
						display: false
					},
					ticks: {
						color: '#6c757d'
					}
				}
			}
		}
	});

	// Case Type Composition Chart
	const caseTypeChart = new Chart(document.getElementById('caseTypeChart'), {
		type: 'doughnut',
		data: {
			labels: caseTypeData.labels,
			datasets: [{
				data: caseTypeData.data,
				backgroundColor: [
					'rgba(255, 118, 117, 0.8)',
					'rgba(74, 144, 226, 0.8)'
				],
				borderColor: [
					'rgba(255, 118, 117, 1)',
					'rgba(74, 144, 226, 1)'
				],
				borderWidth: 3,
				hoverBackgroundColor: [
					'rgba(255, 118, 117, 1)',
					'rgba(74, 144, 226, 1)'
				]
			}]
		},
		options: {
			...chartOptions,
			plugins: {
				...chartOptions.plugins,
				datalabels: {
					formatter: function(value, context) {
						const total = caseTypeData.data.reduce((a, b) => a + b, 0);
						const percentage = ((value / total) * 100).toFixed(1);
						return percentage + '%';
					},
					color: '#fff',
					font: {
						weight: 'bold',
						size: 16
					}
				}
			}
		},
		plugins: [ChartDataLabels]
	});

	// Monthly Classification Chart
	const monthlyClassificationChart = new Chart(document.getElementById('monthlyClassificationChart'), {
		type: 'bar',
		data: {
			labels: monthlyClassificationData.labels,
			datasets: monthlyClassificationData.datasets
		},
		options: {
			...chartOptions,
			responsive: true,
			scales: {
				y: {
					beginAtZero: true,
					grid: {
						color: 'rgba(0, 0, 0, 0.1)'
					},
					ticks: {
						color: '#6c757d',
						stepSize: 5
					}
				},
				x: {
					grid: {
						display: false
					},
					ticks: {
						color: '#6c757d'
					}
				}
			},
			plugins: {
				legend: {
					position: 'top',
					labels: {
						font: {
							size: 11,
							weight: 'bold'
						},
						padding: 15,
						usePointStyle: true
					}
				}
			}
		}
	});

	// Performance Chart
	const performanceChart = new Chart(document.getElementById('performanceChart'), {
		type: 'doughnut',
		data: {
			datasets: [{
				data: [kinerjaPN, 100 - kinerjaPN],
				backgroundColor: [warnaPN, 'rgba(0, 0, 0, 0.1)'],
				borderWidth: 0,
				cutout: '75%'
			}]
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			plugins: {
				legend: {
					display: false
				},
				tooltip: {
					enabled: false
				}
			},
			animation: {
				animateRotate: true,
				duration: 2000
			}
		},
		plugins: [{
			id: 'centerText',
			beforeDatasetsDraw: function(chart) {
				const ctx = chart.ctx;
				const centerX = chart.chartArea.left + (chart.chartArea.right - chart.chartArea.left) / 2;
				const centerY = chart.chartArea.top + (chart.chartArea.bottom - chart.chartArea.top) / 2;

				ctx.save();
				ctx.font = 'bold 24px Arial';
				ctx.fillStyle = warnaPN;
				ctx.textAlign = 'center';
				ctx.textBaseline = 'middle';
				ctx.fillText(kinerjaPN.toFixed(1) + '%', centerX, centerY - 5);

				ctx.font = '12px Arial';
				ctx.fillStyle = '#6c757d';
				ctx.fillText('Kinerja', centerX, centerY + 15);
				ctx.restore();
			}
		}]
	});

	// Initialize animations when page loads
	document.addEventListener('DOMContentLoaded', function() {
		setTimeout(() => {
			animateNumbers();
			animateProgressBars();
		}, 500);
	});
</script>