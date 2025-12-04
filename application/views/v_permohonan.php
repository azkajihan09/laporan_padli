<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Data Permohonan Per Wilayah | Pengadilan Agama Kandangan</title>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/build/css/adminlte.min.css">

	<!-- jQuery -->
	<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- DataTables & Plugins -->
	<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/jszip/jszip.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo base_url(); ?>assets/build/js/adminlte.min.js"></script>
</head>

<body class="hold-transition sidebar-mini">
	<div class="wrapper">
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1><i class="fas fa-map-marked-alt"></i> Data Permohonan Per Wilayah</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item active">Data Permohonan</li>
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
							<div class="col-lg-4 col-6">
								<div class="small-box bg-info">
									<div class="inner">
										<h3><?php echo isset($summary->total_masuk) ? $summary->total_masuk : 0; ?></h3>
										<p>Total Perkara Masuk</p>
									</div>
									<div class="icon">
										<i class="fas fa-inbox"></i>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-6">
								<div class="small-box bg-success">
									<div class="inner">
										<h3><?php echo isset($summary->total_putus) ? $summary->total_putus : 0; ?></h3>
										<p>Total Perkara Putus</p>
									</div>
									<div class="icon">
										<i class="fas fa-gavel"></i>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-6">
								<div class="small-box bg-warning">
									<div class="inner">
										<h3>
											<?php
											$total_masuk = isset($summary->total_masuk) ? $summary->total_masuk : 0;
											$total_putus = isset($summary->total_putus) ? $summary->total_putus : 0;
											$persentase = ($total_masuk > 0) ? round(($total_putus / $total_masuk) * 100, 1) : 0;
											echo $persentase;
											?>%
										</h3>
										<p>Tingkat Penyelesaian</p>
									</div>
									<div class="icon">
										<i class="fas fa-chart-pie"></i>
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
									<form action="<?php echo base_url() ?>index.php/Data_Permohonan" method="POST" id="filterForm">
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
											<div class="col-md-3">
												<div class="form-group">
													<label>Jenis Perkara:</label>
													<select name="jenis_perkara" class="form-control">
														<?php if (isset($jenis_perkara_list) && !empty($jenis_perkara_list)): ?>
															<?php foreach ($jenis_perkara_list as $perkara): ?>
																<option value="<?php echo htmlspecialchars($perkara->jenis_perkara_nama); ?>"
																	<?php echo (isset($selected_jenis_perkara) && $selected_jenis_perkara === $perkara->jenis_perkara_nama) ? 'selected' : ''; ?>>
																	<?php echo htmlspecialchars($perkara->jenis_perkara_nama); ?>
																</option>
															<?php endforeach; ?>
														<?php else: ?>
															<option value="Dispensasi Kawin">Dispensasi Kawin</option>
															<option value="Istbat Nikah">Istbat Nikah</option>
															<option value="P3HP/Penetapan Ahli Waris">P3HP/Penetapan Ahli Waris</option>
														<?php endif; ?>
													</select>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label>Jenis Laporan:</label>
													<select name="jenis_laporan" class="form-control" id="jenisLaporan" onchange="toggleFilter()">
														<option value="bulanan" <?php echo (isset($selected_jenis_laporan) && $selected_jenis_laporan === 'bulanan') ? 'selected' : ''; ?>>Bulanan</option>
														<option value="tahunan" <?php echo (isset($selected_jenis_laporan) && $selected_jenis_laporan === 'tahunan') ? 'selected' : ''; ?>>Tahunan</option>
														<option value="custom" <?php echo (isset($selected_jenis_laporan) && $selected_jenis_laporan === 'custom') ? 'selected' : ''; ?>>Custom Range</option>
													</select>
												</div>
											</div>
											<div class="col-md-1" id="filterBulan">
												<div class="form-group">
													<label>Bulan:</label>
													<select name="lap_bulan" class="form-control">
														<option value="01" <?php echo (isset($selected_bulan) && $selected_bulan === '01') ? 'selected' : ''; ?>>Jan</option>
														<option value="02" <?php echo (isset($selected_bulan) && $selected_bulan === '02') ? 'selected' : ''; ?>>Feb</option>
														<option value="03" <?php echo (isset($selected_bulan) && $selected_bulan === '03') ? 'selected' : ''; ?>>Mar</option>
														<option value="04" <?php echo (isset($selected_bulan) && $selected_bulan === '04') ? 'selected' : ''; ?>>Apr</option>
														<option value="05" <?php echo (isset($selected_bulan) && $selected_bulan === '05') ? 'selected' : ''; ?>>Mei</option>
														<option value="06" <?php echo (isset($selected_bulan) && $selected_bulan === '06') ? 'selected' : ''; ?>>Jun</option>
														<option value="07" <?php echo (isset($selected_bulan) && $selected_bulan === '07') ? 'selected' : ''; ?>>Jul</option>
														<option value="08" <?php echo (isset($selected_bulan) && $selected_bulan === '08') ? 'selected' : ''; ?>>Agu</option>
														<option value="09" <?php echo (isset($selected_bulan) && $selected_bulan === '09') ? 'selected' : ''; ?>>Sep</option>
														<option value="10" <?php echo (isset($selected_bulan) && $selected_bulan === '10') ? 'selected' : ''; ?>>Okt</option>
														<option value="11" <?php echo (isset($selected_bulan) && $selected_bulan === '11') ? 'selected' : ''; ?>>Nov</option>
														<option value="12" <?php echo (isset($selected_bulan) && $selected_bulan === '12') ? 'selected' : ''; ?>>Des</option>
													</select>
												</div>
											</div>
											<div class="col-md-1" id="filterTahun">
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
											<div class="col-md-2">
												<div class="form-group">
													<label>&nbsp;</label><br>
													<button type="submit" class="btn btn-primary btn-block">
														<i class="fas fa-search"></i> Tampilkan
													</button>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label>&nbsp;</label><br>
													<button type="button" class="btn btn-success btn-block" onclick="exportExcel()">
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
									<h3 class="card-title"><i class="fas fa-table"></i> Data Per Kecamatan</h3>
								</div>
								<!-- /.card-header -->
								<div class="card-body">
									<div class="table-responsive">
										<table id="example1" class="table table-bordered table-striped">
											<thead class="thead-dark">
												<tr>
													<th>No</th>
													<th>Kecamatan</th>
													<th>Sisa Bulan Lalu</th>
													<th>Sisa Tahun Lalu</th>
													<th>Perkara Masuk</th>
													<th>Perkara Putus</th>
													<th>Sisa Perkara</th>
													<th>Tingkat Penyelesaian (%)</th>
												</tr>
											</thead>
											<tbody>
												<?php if (isset($datafilter) && !empty($datafilter)): ?>
													<?php $no = 1;
													foreach ($datafilter as $row): ?>
														<tr>
															<td><?php echo $no++; ?></td>
															<td><strong><?php echo $row->KECAMATAN; ?></strong></td>
															<td class="text-center">
																<span class="badge badge-secondary"><?php echo isset($row->SISA_BULAN_LALU) ? number_format($row->SISA_BULAN_LALU, 0, ',', '.') : '0'; ?></span>
															</td>
															<td class="text-center">
																<span class="badge badge-light"><?php echo isset($row->SISA_TAHUN_LALU) ? number_format($row->SISA_TAHUN_LALU, 0, ',', '.') : '0'; ?></span>
															</td>
															<td class="text-center">
																<span class="badge badge-info"><?php echo number_format($row->PERKARA_MASUK, 0, ',', '.'); ?></span>
															</td>
															<td class="text-center">
																<span class="badge badge-success"><?php echo number_format($row->PERKARA_PUTUS, 0, ',', '.'); ?></span>
															</td>
															<td class="text-center">
																<?php
																// Calculate sisa using formula: sisa bulan lalu + perkara masuk - perkara putus
																$sisa_bulan_lalu = isset($row->SISA_BULAN_LALU) ? $row->SISA_BULAN_LALU : 0;
																$sisa = $sisa_bulan_lalu + $row->PERKARA_MASUK - $row->PERKARA_PUTUS;
																?>
																<span class="badge <?php echo ($sisa > 0) ? 'badge-warning' : 'badge-secondary'; ?>">
																	<?php echo number_format($sisa, 0, ',', '.'); ?>
																</span>
															</td>
															<td class="text-center">
																<?php
																$total_perkara = $sisa_bulan_lalu + $row->PERKARA_MASUK;
																$persentase = ($total_perkara > 0) ? round(($row->PERKARA_PUTUS / $total_perkara) * 100, 1) : 0;
																$badge_class = '';
																if ($persentase >= 90) $badge_class = 'badge-success';
																elseif ($persentase >= 70) $badge_class = 'badge-info';
																elseif ($persentase >= 50) $badge_class = 'badge-warning';
																else $badge_class = 'badge-danger';
																?>
																<span class="badge <?php echo $badge_class; ?>"><?php echo $persentase; ?>%</span>
															</td>
														</tr>
													<?php endforeach; ?>
												<?php else: ?>
													<tr>
														<td colspan="8" class="text-center">
															<div class="alert alert-info">
																<i class="fas fa-info-circle"></i> Tidak ada data untuk filter yang dipilih
															</div>
														</td>
													</tr>
												<?php endif; ?>
											</tbody>
											<?php if (isset($datafilter) && !empty($datafilter)): ?>
												<?php
												$total_masuk = array_sum(array_column($datafilter, 'PERKARA_MASUK'));
												$total_putus = array_sum(array_column($datafilter, 'PERKARA_PUTUS'));
												$total_sisa = $total_masuk - $total_putus;
												$total_persentase = ($total_masuk > 0) ? round(($total_putus / $total_masuk) * 100, 1) : 0;
												?>
												<!-- <tfoot class="bg-light">
													<tr class="font-weight-bold">
														<th colspan="2">TOTAL KESELURUHAN 1</th>
														<th class="text-center"><?php echo number_format($total_masuk, 0, ',', '.'); ?></th>
														<th class="text-center"><?php echo number_format($total_putus, 0, ',', '.'); ?></th>
														<th class="text-center"><?php echo number_format($total_sisa, 0, ',', '.'); ?></th>
														<th class="text-center">
															<?php
															$total_badge_class = '';
															if ($total_persentase >= 90) $total_badge_class = 'badge-success';
															elseif ($total_persentase >= 70) $total_badge_class = 'badge-info';
															elseif ($total_persentase >= 50) $total_badge_class = 'badge-warning';
															else $total_badge_class = 'badge-danger';
															?>
															<span class="badge <?php echo $total_badge_class; ?>"><?php echo $total_persentase; ?>%</span>
														</th>
													</tr>
												</tfoot> -->
											<?php endif; ?>
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

	<!-- Page specific script -->
	<script>
		// Variabel global untuk menyimpan instance DataTable
		var dataTable;

		$(document).ready(function() {
			initializeDataTable();
		});

		function initializeDataTable() {
			// Destroy existing DataTable completely
			if ($.fn.DataTable.isDataTable('#example1')) {
				$('#example1').DataTable().clear().destroy();
				$('#example1').empty();
			}

			// Clear any existing HTML
			$('#example1').removeData();

			// Re-initialize DataTable
			setTimeout(function() {
				dataTable = $("#example1").DataTable({
					"destroy": true, // Allow reinitialization
					"responsive": true,
					"lengthChange": true,
					"autoWidth": false,
					"paging": true,
					"ordering": true,
					"info": true,
					"searching": true,
					"pageLength": 10,
					"lengthMenu": [
						[10, 25, 50, -1],
						[10, 25, 50, "Semua"]
					],
					"language": {
						"search": "Pencarian:",
						"lengthMenu": "Tampilkan _MENU_ data per halaman",
						"zeroRecords": "Data tidak ditemukan",
						"info": "Menampilkan halaman _PAGE_ dari _PAGES_",
						"infoEmpty": "Tidak ada data yang tersedia",
						"infoFiltered": "(difilter dari _MAX_ total data)",
						"paginate": {
							"first": "Pertama",
							"last": "Terakhir",
							"next": "Selanjutnya",
							"previous": "Sebelumnya"
						}
					},
					"buttons": [{
							extend: 'copy',
							text: '<i class="fas fa-copy"></i> Copy',
							className: 'btn btn-primary btn-sm'
						},
						{
							extend: 'csv',
							text: '<i class="fas fa-file-csv"></i> CSV',
							className: 'btn btn-success btn-sm'
						},
						{
							extend: 'excel',
							text: '<i class="fas fa-file-excel"></i> Excel',
							className: 'btn btn-success btn-sm'
						},
						{
							extend: 'pdf',
							text: '<i class="fas fa-file-pdf"></i> PDF',
							className: 'btn btn-danger btn-sm',
							orientation: 'landscape',
							pageSize: 'A4'
						},
						{
							extend: 'print',
							text: '<i class="fas fa-print"></i> Print',
							className: 'btn btn-info btn-sm'
						}
					]
				});

				// Add buttons to wrapper after table is ready
				if (dataTable.buttons && dataTable.buttons().container) {
					dataTable.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
				}
			}, 100);
		}

		// Toggle filter based on report type
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

		// Export to Excel function
		function exportExcel() {
			// Clone form and add export parameter
			const form = document.getElementById('filterForm').cloneNode(true);
			const exportInput = document.createElement('input');
			exportInput.type = 'hidden';
			exportInput.name = 'export_excel';
			exportInput.value = '1';
			form.appendChild(exportInput);

			// Temporarily modify action for export
			form.action = '<?php echo base_url(); ?>index.php/Data_Permohonan/export_excel';

			// Submit form
			document.body.appendChild(form);
			form.submit();
			document.body.removeChild(form);
		}

		// Initialize filter on page load
		document.addEventListener('DOMContentLoaded', function() {
			toggleFilter();
		});

		// Auto-submit form when filter changes (removed confirmation dialog)
		$(document).ready(function() {
			// Optional: Auto-submit on wilayah change only
			// $('select[name="wilayah"]').on('change', function() {
			// 	$('#filterForm').submit();
			// });
		});
	</script>

	<style>
		.thead-dark th {
			background-color: #343a40 !important;
			color: white !important;
		}

		.small-box .icon {
			transition: all 0.3s;
		}

		.small-box:hover .icon {
			transform: scale(1.1);
		}

		.badge {
			font-size: 0.9em;
			padding: 0.5em 0.75em;
		}

		.table-responsive {
			border: 1px solid #dee2e6;
			border-radius: 0.375rem;
		}

		.card-header {
			background: linear-gradient(45deg, #007bff, #6610f2);
			color: white;
		}

		.btn-block {
			border-radius: 0.375rem;
		}

		.alert {
			border-radius: 0.5rem;
		}
	</style>

</body>

</html>