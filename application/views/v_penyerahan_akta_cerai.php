<body class="hold-transition sidebar-mini">
	<div class="wrapper">
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1><i class="fas fa-handshake"></i> Laporan Penyerahan Akta Cerai
								<?php if (isset($selected_wilayah) && $selected_wilayah !== 'Semua'): ?>
									<span class="badge badge-info">
										<?php echo ($selected_wilayah === 'HSU') ? 'Hulu Sungai Utara' : $selected_wilayah; ?>
									</span>
								<?php endif; ?>
							</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item active">Penyerahan Akta Cerai</li>
							</ol>
						</div>
					</div>
				</div>
			</section>

			<!-- Summary Statistics -->
			<?php if (isset($summary)): ?>
				<section class="content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-2 col-6">
								<div class="small-box bg-info">
									<div class="inner">
										<h3><?php echo isset($summary->total_akta) ? $summary->total_akta : 0; ?></h3>
										<p>Total Penyerahan</p>
									</div>
									<div class="icon">
										<i class="fas fa-handshake"></i>
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-6">
								<div class="small-box bg-success">
									<div class="inner">
										<h3><?php echo isset($summary->cerai_talak) ? $summary->cerai_talak : 0; ?></h3>
										<p>Cerai Talak</p>
									</div>
									<div class="icon">
										<i class="fas fa-male"></i>
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-6">
								<div class="small-box bg-warning">
									<div class="inner">
										<h3><?php echo isset($summary->cerai_gugat) ? $summary->cerai_gugat : 0; ?></h3>
										<p>Cerai Gugat</p>
									</div>
									<div class="icon">
										<i class="fas fa-female"></i>
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-6">
								<div class="small-box bg-primary">
									<div class="inner">
										<h3><?php echo isset($summary->diserahkan_pihak1) ? $summary->diserahkan_pihak1 : 0; ?></h3>
										<p>Pihak Pertama</p>
									</div>
									<div class="icon">
										<i class="fas fa-user"></i>
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-6">
								<div class="small-box bg-secondary">
									<div class="inner">
										<h3><?php echo isset($summary->diserahkan_pihak2) ? $summary->diserahkan_pihak2 : 0; ?></h3>
										<p>Pihak Kedua</p>
									</div>
									<div class="icon">
										<i class="fas fa-users"></i>
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-6">
								<div class="small-box bg-success">
									<div class="inner">
										<h3><?php echo isset($summary->kedua_pihak_selesai) ? $summary->kedua_pihak_selesai : 0; ?></h3>
										<p>Selesai Semua</p>
									</div>
									<div class="icon">
										<i class="fas fa-check-double"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			<?php endif; ?>

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-12">
							<div class="card filter-card">
								<div class="card-header">
									<h3 class="card-title"><i class="fas fa-filter"></i> Filter Laporan</h3>
								</div>
								<div class="card-body">
									<form action="<?php echo base_url() ?>index.php/Penyerahan_akta_cerai" method="POST" id="filterForm">
										<div class="row">
											<div class="col-md-2">
												<div class="form-group">
													<label>Wilayah:</label>
													<select name="wilayah" class="form-control">
														<option value="Semua" <?php echo (isset($selected_wilayah) && $selected_wilayah === 'Semua') ? 'selected' : ''; ?>>Semua Wilayah</option>
														<option value="HSU" <?php echo (isset($selected_wilayah) && $selected_wilayah === 'HSU') ? 'selected' : ''; ?>>Hulu Sungai Utara</option>
														<option value="Balangan" <?php echo (isset($selected_wilayah) && $selected_wilayah === 'Balangan') ? 'selected' : ''; ?>>Balangan</option>
													</select>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label>Jenis Laporan:</label>
													<select name="jenis_laporan" class="form-control" id="jenisLaporan" onchange="toggleFilter()">
														<option value="bulanan" <?php echo (isset($selected_jenis) && $selected_jenis === 'bulanan') ? 'selected' : ''; ?>>Bulanan</option>
														<option value="tahunan" <?php echo (isset($selected_jenis) && $selected_jenis === 'tahunan') ? 'selected' : ''; ?>>Tahunan</option>
														<option value="custom" <?php echo (isset($selected_jenis) && $selected_jenis === 'custom') ? 'selected' : ''; ?>>Custom Range</option>
													</select>
												</div>
											</div>
											<div class="col-md-2" id="filterBulan">
												<div class="form-group">
													<label>Bulan:</label>
													<select name="lap_bulan" class="form-control">
														<option value="01" <?php echo (isset($selected_bulan) && $selected_bulan === '01') ? 'selected' : ''; ?>>Januari</option>
														<option value="02" <?php echo (isset($selected_bulan) && $selected_bulan === '02') ? 'selected' : ''; ?>>Februari</option>
														<option value="03" <?php echo (isset($selected_bulan) && $selected_bulan === '03') ? 'selected' : ''; ?>>Maret</option>
														<option value="04" <?php echo (isset($selected_bulan) && $selected_bulan === '04') ? 'selected' : ''; ?>>April</option>
														<option value="05" <?php echo (isset($selected_bulan) && $selected_bulan === '05') ? 'selected' : ''; ?>>Mei</option>
														<option value="06" <?php echo (isset($selected_bulan) && $selected_bulan === '06') ? 'selected' : ''; ?>>Juni</option>
														<option value="07" <?php echo (isset($selected_bulan) && $selected_bulan === '07') ? 'selected' : ''; ?>>Juli</option>
														<option value="08" <?php echo (isset($selected_bulan) && $selected_bulan === '08') ? 'selected' : ''; ?>>Agustus</option>
														<option value="09" <?php echo (isset($selected_bulan) && $selected_bulan === '09') ? 'selected' : ''; ?>>September</option>
														<option value="10" <?php echo (isset($selected_bulan) && $selected_bulan === '10') ? 'selected' : ''; ?>>Oktober</option>
														<option value="11" <?php echo (isset($selected_bulan) && $selected_bulan === '11') ? 'selected' : ''; ?>>November</option>
														<option value="12" <?php echo (isset($selected_bulan) && $selected_bulan === '12') ? 'selected' : ''; ?>>Desember</option>
													</select>
												</div>
											</div>
											<div class="col-md-2" id="filterTahun">
												<div class="form-group">
													<label>Tahun:</label>
													<select name="lap_tahun" class="form-control">
														<?php for ($year = 2016; $year <= date('Y') + 1; $year++): ?>
															<option value="<?php echo $year; ?>" <?php echo (isset($selected_tahun) && $selected_tahun == $year) ? 'selected' : ''; ?>>
																<?php echo $year; ?>
															</option>
														<?php endfor; ?>
													</select>
												</div>
											</div>
											<div class="col-md-2" id="filterTanggalMulai" style="display:none;">
												<div class="form-group">
													<label>Tanggal Mulai:</label>
													<input type="date" name="tanggal_mulai" class="form-control" value="<?php echo $this->input->post('tanggal_mulai') ?: date('Y-m-01'); ?>">
												</div>
											</div>
											<div class="col-md-2" id="filterTanggalAkhir" style="display:none;">
												<div class="form-group">
													<label>Tanggal Akhir:</label>
													<input type="date" name="tanggal_akhir" class="form-control" value="<?php echo $this->input->post('tanggal_akhir') ?: date('Y-m-t'); ?>">
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label>&nbsp;</label><br>
													<button type="submit" class="btn btn-primary">
														<i class="fas fa-search"></i> Tampilkan
													</button>
													<button type="button" class="btn btn-success" onclick="exportExcel()">
														<i class="fas fa-file-excel"></i> Export Excel
													</button>
													<button type="button" class="btn btn-info" onclick="printReport()">
														<i class="fas fa-print"></i> Print
													</button>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>

							<div class="card">
								<div class="card-header">
									<h3 class="card-title"><i class="fas fa-list"></i> Data Penyerahan Akta Cerai</h3>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-bordered table-striped table-hover" id="example1">
											<thead>
												<tr>
													<th>No</th>
													<th>Nomor Perkara</th>
													<th>Jenis Perkara</th>
													<th>Nomor Akta Cerai</th>
													<th>Tanggal Akta Cerai</th>
													<th>Tanggal Putusan</th>
													<th>Tanggal BHT</th>
													<th>Tanggal Ikrar Talak</th>
													<th>Penyerahan Kepada Suami</th>
													<th>Penyerahan Kepada Istri</th>
													<th>Nama Suami</th>
													<th>Nama Istri</th>
												</tr>
											</thead>
											<tbody>
												<?php if (isset($datafilter) && count($datafilter) > 0): ?>
													<?php $no = 1;
													foreach ($datafilter as $row) : ?>
														<tr>
															<td><?php echo $no++; ?></td>
															<td><strong><?php echo $row->nomor_perkara; ?></strong></td>
															<td>
																<span class="badge badge-<?php echo ($row->jenis_perkara_nama == 'Cerai Talak') ? 'success' : 'warning'; ?>">
																	<?php echo $row->jenis_perkara_nama; ?>
																</span>
															</td>
															<td><?php echo $row->nomor_akta_cerai ?: '-'; ?></td>
															<td><?php echo $row->tgl_akta_cerai ? date('d/m/Y', strtotime($row->tgl_akta_cerai)) : '-'; ?></td>
															<td><?php echo $row->tanggal_putusan ? date('d/m/Y', strtotime($row->tanggal_putusan)) : '-'; ?></td>
															<td><?php echo $row->tanggal_bht ? date('d/m/Y', strtotime($row->tanggal_bht)) : '-'; ?></td>
															<td><?php echo $row->tgl_ikrar_talak ? date('d/m/Y', strtotime($row->tgl_ikrar_talak)) : '-'; ?></td>
															<td>
																<?php
																// Penyerahan Kepada Suami berdasarkan jenis perkara
																if ($row->jenis_perkara_nama == 'Cerai Talak') {
																	// Cerai Talak: Suami = Penggugat (pihak1)
																	$tgl_suami = $row->tgl_penyerahan_akta_cerai;
																} else {
																	// Cerai Gugat: Suami = Tergugat (pihak2)
																	$tgl_suami = $row->tgl_penyerahan_akta_cerai_pihak2;
																}

																if ($tgl_suami) {
																	echo '<span class="badge badge-success">' . date('d/m/Y', strtotime($tgl_suami)) . '</span>';
																} else {
																	echo '<span class="badge badge-secondary">Belum</span>';
																}
																?>
															</td>
															<td>
																<?php
																// Penyerahan Kepada Istri berdasarkan jenis perkara
																if ($row->jenis_perkara_nama == 'Cerai Talak') {
																	// Cerai Talak: Istri = Tergugat (pihak2)
																	$tgl_istri = $row->tgl_penyerahan_akta_cerai_pihak2;
																} else {
																	// Cerai Gugat: Istri = Penggugat (pihak1)
																	$tgl_istri = $row->tgl_penyerahan_akta_cerai;
																}

																if ($tgl_istri) {
																	echo '<span class="badge badge-success">' . date('d/m/Y', strtotime($tgl_istri)) . '</span>';
																} else {
																	echo '<span class="badge badge-secondary">Belum</span>';
																}
																?>
															</td>
															<td>
																<?php
																// Nama Suami berdasarkan jenis perkara
																if ($row->jenis_perkara_nama == 'Cerai Talak') {
																	// Cerai Talak: Suami = Penggugat
																	echo '<i class="fas fa-male text-primary"></i> ' . character_limiter($row->nama_penggugat, 25);
																} else {
																	// Cerai Gugat: Suami = Tergugat
																	echo '<i class="fas fa-male text-primary"></i> ' . character_limiter($row->nama_tergugat, 25);
																}
																?>
															</td>
															<td>
																<?php
																// Nama Istri berdasarkan jenis perkara
																if ($row->jenis_perkara_nama == 'Cerai Talak') {
																	// Cerai Talak: Istri = Tergugat
																	echo '<i class="fas fa-female text-danger"></i> ' . character_limiter($row->nama_tergugat, 25);
																} else {
																	// Cerai Gugat: Istri = Penggugat
																	echo '<i class="fas fa-female text-danger"></i> ' . character_limiter($row->nama_penggugat, 25);
																}
																?>
															</td>
														</tr>
													<?php endforeach; ?>
												<?php else: ?>
													<tr>
														<td colspan="12" class="text-center">
															<div class="alert alert-info">
																<i class="fas fa-info-circle"></i> Tidak ada data penyerahan akta cerai untuk periode ini
															</div>
														</td>
													</tr>
												<?php endif; ?>
											</tbody>
										</table>
									</div>
								</div>
								<!-- /.card-body -->
							</div>
							<!-- /.card -->
						</div>
						<!-- /.col -->
					</div>
					<!-- /.row -->
				</div>
				<!-- /.container-fluid -->
			</section>
			<!-- /.content -->
		</div>
	</div>
	<!-- ./wrapper -->

	<script>
		function toggleFilter() {
			const jenisLaporan = document.getElementById('jenisLaporan').value;
			const filterBulan = document.getElementById('filterBulan');
			const filterTahun = document.getElementById('filterTahun');
			const filterTanggalMulai = document.getElementById('filterTanggalMulai');
			const filterTanggalAkhir = document.getElementById('filterTanggalAkhir');

			if (jenisLaporan === 'bulanan') {
				filterBulan.style.display = 'block';
				filterTahun.style.display = 'block';
				filterTanggalMulai.style.display = 'none';
				filterTanggalAkhir.style.display = 'none';
			} else if (jenisLaporan === 'tahunan') {
				filterBulan.style.display = 'none';
				filterTahun.style.display = 'block';
				filterTanggalMulai.style.display = 'none';
				filterTanggalAkhir.style.display = 'none';
			} else if (jenisLaporan === 'custom') {
				filterBulan.style.display = 'none';
				filterTahun.style.display = 'none';
				filterTanggalMulai.style.display = 'block';
				filterTanggalAkhir.style.display = 'block';
			}
		}

		function exportExcel() {
			const form = document.getElementById('filterForm');
			const originalAction = form.action;
			form.action = '<?php echo base_url(); ?>index.php/Penyerahan_akta_cerai/export_excel';
			form.submit();
			form.action = originalAction;
		}

		function printReport() {
			window.print();
		}

		$(document).ready(function() {
			// Initialize filter display
			toggleFilter();

			// Initialize DataTable with enhanced configuration
			$("#example1").DataTable({
				"responsive": true,
				"lengthChange": true,
				"autoWidth": false,
				"pageLength": 25,
				"lengthMenu": [
					[10, 25, 50, 100, -1],
					[10, 25, 50, 100, "Semua"]
				],
				"language": {
					"url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
				},
				"columnDefs": [{
						"width": "3%",
						"targets": 0
					},
					{
						"width": "12%",
						"targets": [1, 3]
					},
					{
						"width": "8%",
						"targets": [2, 4, 5, 6, 7]
					},
					{
						"width": "10%",
						"targets": [8, 9]
					},
					{
						"width": "15%",
						"targets": [10, 11]
					}
				],
				"order": [
					[0, "asc"]
				],
				"dom": 'Bfrtip',
				"buttons": [{
						extend: 'copy',
						text: '<i class="fas fa-copy"></i> Copy',
						className: 'btn btn-default'
					},
					{
						extend: 'csv',
						text: '<i class="fas fa-file-csv"></i> CSV',
						className: 'btn btn-default'
					},
					{
						extend: 'print',
						text: '<i class="fas fa-print"></i> Print',
						className: 'btn btn-default'
					}
				]
			});
		});
	</script>

	<!-- Custom Styles -->
	<style>
		.form-group label {
			font-weight: 600;
			color: #495057;
		}

		.small-box {
			border-radius: 10px;
			box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
			transition: transform 0.2s ease-in-out;
		}

		.small-box:hover {
			transform: translateY(-2px);
		}

		.small-box .inner h3 {
			font-weight: bold;
		}

		.badge {
			font-size: 0.8rem;
		}

		.table th {
			background-color: #007bff !important;
			color: white !important;
		}

		.card-header {
			background: linear-gradient(45deg, #007bff, #0056b3);
			color: white;
		}

		.btn {
			border-radius: 5px;
		}

		.filter-card {
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
		}

		.breadcrumb-item a {
			color: #007bff;
		}
	</style>

</body>

</html>
