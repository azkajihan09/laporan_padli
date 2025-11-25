<body class="hold-transition sidebar-mini">
	<div class="wrapper">
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h5>PERKARA BANDING</h5>
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
									<form action="<?php echo base_url() ?>index.php/Perkara_Banding" method="post">

										Laporan Bulan :
										<select name="lap_bulan" required="">
											<option value="01" <?php echo (isset($_POST['lap_bulan']) && $_POST['lap_bulan'] === '01') ? 'selected' : ''; ?>>Januari</option>
											<option value="02" <?php echo (isset($_POST['lap_bulan']) && $_POST['lap_bulan'] === '02') ? 'selected' : ''; ?>>Februari</option>
											<option value="03" <?php echo (isset($_POST['lap_bulan']) && $_POST['lap_bulan'] === '03') ? 'selected' : ''; ?>>Maret</option>
											<option value="04" <?php echo (isset($_POST['lap_bulan']) && $_POST['lap_bulan'] === '04') ? 'selected' : ''; ?>>April</option>
											<option value="05" <?php echo (isset($_POST['lap_bulan']) && $_POST['lap_bulan'] === '05') ? 'selected' : ''; ?>>Mei</option>
											<option value="06" <?php echo (isset($_POST['lap_bulan']) && $_POST['lap_bulan'] === '06') ? 'selected' : ''; ?>>Juni</option>
											<option value="07" <?php echo (isset($_POST['lap_bulan']) && $_POST['lap_bulan'] === '07') ? 'selected' : ''; ?>>Juli</option>
											<option value="08" <?php echo (isset($_POST['lap_bulan']) && $_POST['lap_bulan'] === '08') ? 'selected' : ''; ?>>Agustus</option>
											<option value="09" <?php echo (isset($_POST['lap_bulan']) && $_POST['lap_bulan'] === '09') ? 'selected' : ''; ?>>September</option>
											<option value="10" <?php echo (isset($_POST['lap_bulan']) && $_POST['lap_bulan'] === '10') ? 'selected' : ''; ?>>Oktober</option>
											<option value="11" <?php echo (isset($_POST['lap_bulan']) && $_POST['lap_bulan'] === '11') ? 'selected' : ''; ?>>Nopember</option>
											<option value="12" <?php echo (isset($_POST['lap_bulan']) && $_POST['lap_bulan'] === '12') ? 'selected' : ''; ?>>Desember</option>
										</select>
										Tahun :
										<select name="lap_tahun" required="">
											<option value="2016" <?php echo (isset($_POST['lap_tahun']) && $_POST['lap_tahun'] === '2016') ? 'selected' : ''; ?>>2016</option>
											<option value="2017" <?php echo (isset($_POST['lap_tahun']) && $_POST['lap_tahun'] === '2017') ? 'selected' : ''; ?>>2017</option>
											<option value="2018" <?php echo (isset($_POST['lap_tahun']) && $_POST['lap_tahun'] === '2018') ? 'selected' : ''; ?>>2018</option>
											<option value="2019" <?php echo (isset($_POST['lap_tahun']) && $_POST['lap_tahun'] === '2019') ? 'selected' : ''; ?>>2019</option>
											<option value="2020" <?php echo (isset($_POST['lap_tahun']) && $_POST['lap_tahun'] === '2020') ? 'selected' : ''; ?>>2020</option>
											<option value="2021" <?php echo (isset($_POST['lap_tahun']) && $_POST['lap_tahun'] === '2021') ? 'selected' : ''; ?>>2021</option>
											<option value="2022" <?php echo (isset($_POST['lap_tahun']) && $_POST['lap_tahun'] === '2022') ? 'selected' : ''; ?>>2022</option>
											<option value="2023" <?php echo (isset($_POST['lap_tahun']) && $_POST['lap_tahun'] === '2023') ? 'selected' : ''; ?>>2023</option>
											<option value="2024" <?php echo (isset($_POST['lap_tahun']) && $_POST['lap_tahun'] === '2024') ? 'selected' : ''; ?>>2024</option>
											<option value="2025" <?php echo (isset($_POST['lap_tahun']) && $_POST['lap_tahun'] === '2025') ? 'selected' : ''; ?>>2025</option>
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
												<th>Putusan PA</th>
												<th>Permohonan Banding</th>
												<th>Pemberitahuan Inzage</th>
												<th>Pengiriman  berkas Ke PTA</th>
												<th>Putusan Banding</th>
												<th>Penerimaan kembali ke PA </th>
												<th>Pemberitahuan ke Para Pihak</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$no = 1;  // Initialize $no
											foreach ($results as $row) : ?>
												<tr>
													<td><?php echo $no++ ?></td>
													<td><?php echo $row->nomor_perkara_pn ?></td>
													<td><?php echo $row->putusan_pn ?></td>
													<td><?php echo $row->permohonan_banding ?></td>
													<td><?php echo $row->pemberitahuan_inzage ?></td>
													<td><?php echo $row->pengiriman_berkas_banding ?></td>
													<td><?php echo $row->putusan_banding ?></td>
													<td><?php echo $row->penerimaan_kembali_berkas_banding ?></td>
													<td><?php echo $row->pemberitahuan_putusan_banding ?></td>
												</tr>
											<?php endforeach; ?>
											<?php if (empty($results)) : ?>
												<tr><td colspan="9=" class="text-center">NIHIL</td></tr>
											
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
