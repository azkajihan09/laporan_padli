<body class="hold-transition sidebar-mini">
	<div class="wrapper">
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1><i class="fas fa-certificate"></i> Laporan Penerbitan Akta Cerai</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item active">Penerbitan Akta Cerai</li>
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
						<div class="col-lg-3 col-6">
							<div class="small-box bg-info">
								<div class="inner">
									<h3><?php echo isset($summary->total_akta_cerai) ? $summary->total_akta_cerai : 0; ?></h3>
									<p>Total Akta Cerai</p>
								</div>
								<div class="icon">
									<i class="fas fa-certificate"></i>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-6">
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
						<div class="col-lg-3 col-6">
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
						<div class="col-lg-3 col-6">
							<div class="small-box bg-primary">
								<div class="inner">
									<h3><?php echo isset($summary->sudah_diserahkan) ? $summary->sudah_diserahkan : 0; ?></h3>
									<p>Sudah Diserahkan</p>
								</div>
								<div class="icon">
									<i class="fas fa-check-circle"></i>
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
							<div class="card">
								<div class="card-header">
									<h3 class="card-title"><i class="fas fa-filter"></i> Filter Laporan</h3>
								</div>
								<div class="card-body">
									<form action="<?php echo base_url() ?>index.php/Penerbitan_akta_cerai" method="POST" id="filterForm">
										<div class="row">
											<div class="col-md-3">
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
														<?php for($year = 2016; $year <= date('Y')+1; $year++): ?>
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
											<div class="col-md-3">
												<div class="form-group">
													<label>&nbsp;</label><br>
													<button type="submit" class="btn btn-primary">
														<i class="fas fa-search"></i> Tampilkan
													</button>
													<button type="button" class="btn btn-success" onclick="exportExcel()">
														<i class="fas fa-file-excel"></i> Export Excel
													</button>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>

							<div class="card">
								<div class="card-header">
									<h3 class="card-title"><i class="fas fa-list"></i> Data Penerbitan Akta Cerai</h3>
								</div>
								<div class="card-body">
									<table class="table table-bordered table-striped" id="example1">
										<thead>
											<tr>
												<th>No</th>
												<th>Nomor Akta Cerai</th>
												<th>Tanggal Terbit</th>
												<th>No. Seri</th>
												<th>Nomor Perkara</th>
												<th>Penggugat</th>
												<th>Tergugat</th>
												<th>Jenis Perkara</th>
												<th>Tanggal Putusan</th>
												<th>Tanggal BHT</th>
												<th>Tanggal Ikrar Talak</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$no = 1;
											foreach ($datafilter as $row) : ?>
												<tr>
													<td><?php echo $no++; ?></td>
													<td><strong><?php echo $row->nomor_akta_cerai; ?></strong></td>
													<td><?php echo date('d/m/Y', strtotime($row->tgl_akta_cerai)); ?></td>
													<td><?php echo $row->no_seri_akta_cerai; ?></td>
													<td><?php echo $row->nomor_perkara; ?></td>
													<td><?php echo character_limiter($row->penggugat, 30); ?></td>
													<td><?php echo character_limiter($row->tergugat, 30); ?></td>
													<td><?php echo $row->jenis_perkara_nama; ?></td>
													<td><?php echo $row->tanggal_putusan ? date('d/m/Y', strtotime($row->tanggal_putusan)) : '-'; ?></td>
													<td><?php echo $row->tanggal_bht ? date('d/m/Y', strtotime($row->tanggal_bht)) : '-'; ?></td>
													<td><?php echo $row->tgl_ikrar_talak ? date('d/m/Y', strtotime($row->tgl_ikrar_talak)) : '-'; ?></td>
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
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
	<!-- Page specific script -->
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
			form.action = '<?php echo base_url(); ?>index.php/Penerbitan_akta_cerai/export_excel';
			form.submit();
			form.action = originalAction;
		}

		$(document).ready(function() {
			// Initialize filter display
			toggleFilter();
			
			// Initialize DataTable
			$("#example1").DataTable({
				"responsive": true,
				"lengthChange": false,
				"autoWidth": false,
				"pageLength": 25,
				"language": {
					"url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
				},
				"columnDefs": [
					{ "width": "5%", "targets": 0 },
					{ "width": "15%", "targets": [1, 4] },
					{ "width": "10%", "targets": [2, 3] },
					{ "width": "20%", "targets": [5, 6] },
					{ "width": "10%", "targets": [7, 8, 9, 10] }
				]
			});
		});
	</script>

</body>

</html>
