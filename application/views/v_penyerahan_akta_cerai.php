<body class="hold-transition sidebar-mini">
	<div class="wrapper">
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h5>LAPORAN PENYERAHAN AKTA CERAI</h5>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item active">#</li>
							</ol>
						</div>
					</div>
				</div><!-- /.container-fluid -->
			</section>
			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<form action="<?php echo base_url() ?>index.php/Penyerahan_akta_cerai" method="POST">
										Laporan Bulan :
										<select name="lap_bulan" required="">
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
											<option value="11" <?php echo (isset($selected_bulan) && $selected_bulan === '11') ? 'selected' : ''; ?>>Nopember</option>
											<option value="12" <?php echo (isset($selected_bulan) && $selected_bulan === '12') ? 'selected' : ''; ?>>Desember</option>
										</select>
										Tahun :
										<select name="lap_tahun" required="">
											<?php for($i = 2016; $i <= date('Y'); $i++): ?>
												<option value="<?php echo $i; ?>" <?php echo (isset($selected_tahun) && $selected_tahun == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
											<?php endfor; ?>
										</select>
										<input class="btn btn-primary" type="submit" name="btn" value="Tampilkan" />
									</div>
								<!-- /.card-header -->
								<div class="card-body">
									<table class="table table-bordered table-striped" id="example1">
										<thead>
											<tr>
												<th>Nomor</th>
												<th>Nomor Perkara</th>
												<th>Tanggal Akta Cerai</th>
												<th>Tanggal Putus</th>
												<th>Tanggal Ikrar Talak</th>
												<th>BHT</th>
												<th>Penyerahan Kepada Suami</th>
												<th>Penyerahan Kepada Istri</th>
												<th>Nama Suami</th>
												<th>Nama Istri</th>
											</tr>
										</thead>
										<tbody>
											<?php if(isset($datafilter) && count($datafilter) > 0): ?>
												<?php $no = 1; foreach ($datafilter as $row) : ?>
													<tr>
														<td><?php echo $no++; ?></td>
														<td><?php echo $row->nomor_perkara; ?></td>
														<td><?php echo $row->nomor_akta_cerai ?: '-'; ?></td>
														<td><?php echo $row->tanggal_putusan ? date('d/m/Y', strtotime($row->tanggal_putusan)) : '-'; ?></td>
														<td><?php echo $row->tgl_ikrar_talak ? date('d/m/Y', strtotime($row->tgl_ikrar_talak)) : '-'; ?></td>
														<td><?php echo $row->tanggal_bht ? date('d/m/Y', strtotime($row->tanggal_bht)) : '-'; ?></td>
														<td>
															<?php 
															// Penyerahan Kepada Suami
															if ($row->jenis_perkara_nama == 'Cerai Talak') {
																// Cerai Talak: Suami = Penggugat (pihak1)
																echo $row->tgl_penyerahan_akta_cerai ? date('d/m/Y', strtotime($row->tgl_penyerahan_akta_cerai)) : '-';
															} else {
																// Cerai Gugat: Suami = Tergugat (pihak2)
																echo $row->tgl_penyerahan_akta_cerai_pihak2 ? date('d/m/Y', strtotime($row->tgl_penyerahan_akta_cerai_pihak2)) : '-';
															}
															?>
														</td>
														<td>
															<?php 
															// Penyerahan Kepada Istri
															if ($row->jenis_perkara_nama == 'Cerai Talak') {
																// Cerai Talak: Istri = Tergugat (pihak2)
																echo $row->tgl_penyerahan_akta_cerai_pihak2 ? date('d/m/Y', strtotime($row->tgl_penyerahan_akta_cerai_pihak2)) : '-';
															} else {
																// Cerai Gugat: Istri = Penggugat (pihak1)
																echo $row->tgl_penyerahan_akta_cerai ? date('d/m/Y', strtotime($row->tgl_penyerahan_akta_cerai)) : '-';
															}
															?>
														</td>
														<td>
															<?php 
															// Nama Suami
															if ($row->jenis_perkara_nama == 'Cerai Talak') {
																// Cerai Talak: Suami = Penggugat
																echo character_limiter($row->nama_penggugat, 30);
															} else {
																// Cerai Gugat: Suami = Tergugat
																echo character_limiter($row->nama_tergugat, 30);
															}
															?>
														</td>
														<td>
															<?php 
															// Nama Istri
															if ($row->jenis_perkara_nama == 'Cerai Talak') {
																// Cerai Talak: Istri = Tergugat
																echo character_limiter($row->nama_tergugat, 30);
															} else {
																// Cerai Gugat: Istri = Penggugat
																echo character_limiter($row->nama_penggugat, 30);
															}
															?>
														</td>
													</tr>
												<?php endforeach; ?>
											<?php else: ?>
												<tr>
													<td colspan="10" class="text-center">Tidak ada data</td>
												</tr>
											<?php endif; ?>
										</tbody>
									</table>
								</div>
								<!-- /.card-body -->
								</form>
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
		$(function() {
			$("#example1").DataTable({
				"responsive": true,
				"lengthChange": false,
				"autoWidth": false,
				"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
			}).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
		});
	</script>

</body>

</html>
