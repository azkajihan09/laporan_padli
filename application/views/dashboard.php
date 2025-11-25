<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Dashboard</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
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
			<!-- Small boxes (Stat box) -->
			<?php
			$currentYear = date('Y');
			echo "<h4 style='text-align: center;'>Perkara Tahun : $currentYear</h4>";
			?>
			<div class="row">
				<div class="col-lg-3 col-6">
					<!-- small box -->
					<style>
						.rounded-box {
							border-radius: 50%;
							padding: 20px;
							text-align: center;
							height: 200px;
							width: 200px;
							display: flex;
							align-items: center;
							justify-content: center;
							flex-direction: column;
						}
					</style>


					<div class="col-lg-3 col-6">
						<!-- small box -->
						<div class="small-box bg-info rounded-box">
							<div class="inner">
								<?php
								// Load the database configuration
								$this->load->database();
								// Now you can use $this->db to interact with the database
								$query = $this->db->query('SELECT * FROM perkara');
								$currentYear = date('Y');
								$query = $this->db->query("SELECT * FROM perkara WHERE YEAR(tanggal_pendaftaran) = '$currentYear'");
								$row = $query->num_rows();
								echo '<h3>' . $row . '</h3>Perkara';
								?>
								<p>Diterima</p>
							</div>
						</div>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-3 col-6">
					<!-- small box -->
					<div class="small-box bg-success rounded-box">
						<div class="inner">
							<?php
							$this->load->database();
							$query = $this->db->query('SELECT * FROM perkara_putusan');
							$currentYear = date('Y');
							$query = $this->db->query("SELECT * FROM perkara_putusan WHERE YEAR(tanggal_putusan) = '$currentYear'");
							$row = $query->num_rows();
							echo '<h3>' . $row . '</h3>Perkara';

							?>
							<p>Putus</p>
						</div>

					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-3 col-6">
					<!-- small box -->
					<div class="small-box bg-warning rounded-box">
						<div class="inner">
							<?php
							$this->load->database();
							$query = $this->db->query('SELECT * FROM perkara_putusan');
							$currentYear = date('Y');
							$query = $this->db->query("SELECT * FROM perkara_putusan WHERE YEAR(tanggal_minutasi) = '$currentYear'");
							$row = $query->num_rows();
							echo '<h3>' . $row . '</h3>Perkara';
							?>
							<p>Minutasi</p>
						</div>

					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-3 col-6">
					<!-- small box -->
					<div class="small-box bg-danger rounded-box">
						<div class="inner">
							<?php
							$this->load->database();
							$query = $this->db->query('SELECT * FROM perkara');

							$currentYear = date('Y');
							$query = $this->db->query("SELECT * FROM perkara left join perkara_putusan on perkara.perkara_id = perkara_putusan.perkara_id where tanggal_putusan is null and year(tanggal_pendaftaran) = '$currentYear'");
							$row = $query->num_rows();
							echo '<h3>' . $row . '</h3>Perkara';
							?>
							<p>Sisa</p>
						</div>

					</div>
				</div>

			</div><!-- /.container-fluid -->
			<?php
			$this->load->database();
			// require 'connectdb_dashboard.php';
			$currentYear = date('Y');
			$currentMonth = date('m');
			$currentMonthName = date('F'); //
			// Fetch data from database
			$queries = [
				"SELECT * FROM perkara WHERE MONTH(tanggal_pendaftaran) = '$currentMonth' AND YEAR(tanggal_pendaftaran) = '$currentYear'",
				"SELECT * FROM perkara_putusan WHERE MONTH(tanggal_putusan) = '$currentMonth' AND YEAR(tanggal_putusan) = '$currentYear'",
				"SELECT * FROM perkara_putusan WHERE MONTH(tanggal_minutasi) = '$currentMonth' AND YEAR(tanggal_minutasi) = '$currentYear'",
				"SELECT * FROM perkara LEFT JOIN perkara_putusan ON perkara.perkara_id = perkara_putusan.perkara_id WHERE tanggal_putusan IS NULL AND MONTH(tanggal_pendaftaran) = '$currentMonth' AND YEAR(tanggal_pendaftaran) = '$currentYear'",

				// 				SELECT COUNT(*) AS sisa_bulan_ini
				// FROM perkara
				// INNER JOIN perkara_penetapan ON perkara.`perkara_id`=perkara_penetapan.`perkara_id`
				// LEFT JOIN perkara_putusan ON perkara.`perkara_id` = perkara_putusan.`perkara_id`
				// WHERE (tanggal_putusan IS NULL OR(tanggal_putusan > '2024-02-31')) AND tanggal_pendaftaran<='2024-02-31'

				"SELECT * FROM perkara INNER JOIN perkara_penetapan ON perkara.`perkara_id`=perkara_penetapan.`perkara_id` LEFT JOIN perkara_putusan ON perkara.`perkara_id` = perkara_putusan.`perkara_id` WHERE (tanggal_putusan IS NULL OR(tanggal_putusan > '$currentYear-$currentMonth-31')) AND tanggal_pendaftaran<='$currentYear-$currentMonth-31'"

			];
			$data = [];
			foreach ($queries as $query) {
				$result = $this->db->query($query);
				$data[] = $result->num_rows();
			}
			echo "<h5 style='text-align: center;'>Perkara Bulan $currentMonthName</h5>";
			?>
			<!-- Include Chart.js -->

			<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
			<canvas id="myChart" width="200" height="100"></canvas>
			<script>
				// Initialize a new Chart.js object
				var ctx = document.getElementById('myChart').getContext('2d');
				var myChart = new Chart(ctx, {
					type: 'bar', // Change this to the type of chart you want
					data: {
						labels: ['Diterima', 'Putus', 'Minutasi', 'Sisa'],
						datasets: [{
							label: 'Perkara Bulan Ini',
							data: <?php echo json_encode($data); ?>,
							backgroundColor: [
								'rgba(54, 162, 235, 0.2)',
								'rgba(75, 192, 192, 0.2)',
								'rgba(255, 206, 86, 0.2)',
								'rgba(255, 99, 132, 0.2)',
								'rgba(153, 102, 255, 0.2)'
							],
							borderColor: [
								'rgba(54, 162, 235, 1)',
								'rgba(75, 192, 192, 1)',
								'rgba(255, 206, 86, 1)',
								'rgba(255, 99, 132, 1)',
								'rgba(153, 102, 255, 1)'
							],
							borderWidth: 1
						}]
					},
					options: {
						scales: {
							y: {
								beginAtZero: true
							}
						}
					}
				});
			</script>
	</section>
	<!-- /.content -->


</div>
<!-- /.
content-wrapper -->

</body>

</html>
