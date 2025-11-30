<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Data Perkara Gugatan</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo site_url('Dashboard') ?>">Home</a></li>
						<li class="breadcrumb-item active">Data Perkara Gugatan</li>
					</ol>
				</div>
			</div>
		</div>
	</div>

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">

			<!-- Filter Form -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">
								<i class="fas fa-filter"></i>
								Filter Laporan
							</h3>
						</div>
						<form method="post" action="<?php echo site_url('Data_Perkara_Gugatan') ?>" id="filterForm">
							<div class="card-body">
								<div class="row">
									<!-- Wilayah -->
									<div class="col-md-3">
										<div class="form-group">
											<label>Wilayah</label>
											<select name="wilayah" class="form-control" id="wilayah">
												<option value="HSU" <?php echo ($selected_wilayah == 'HSU') ? 'selected' : ''; ?>>Hulu Sungai Utara</option>
												<option value="Balangan" <?php echo ($selected_wilayah == 'Balangan') ? 'selected' : ''; ?>>Balangan</option>
												<option value="Semua" <?php echo ($selected_wilayah == 'Semua') ? 'selected' : ''; ?>>Semua</option>
											</select>
										</div>
									</div>

									<!-- Bulan -->
									<div class="col-md-2">
										<div class="form-group">
											<label>Bulan</label>
											<select name="lap_bulan" class="form-control" id="lap_bulan">
												<option value="01" <?php echo ($selected_bulan == '01') ? 'selected' : ''; ?>>Januari</option>
												<option value="02" <?php echo ($selected_bulan == '02') ? 'selected' : ''; ?>>Februari</option>
												<option value="03" <?php echo ($selected_bulan == '03') ? 'selected' : ''; ?>>Maret</option>
												<option value="04" <?php echo ($selected_bulan == '04') ? 'selected' : ''; ?>>April</option>
												<option value="05" <?php echo ($selected_bulan == '05') ? 'selected' : ''; ?>>Mei</option>
												<option value="06" <?php echo ($selected_bulan == '06') ? 'selected' : ''; ?>>Juni</option>
												<option value="07" <?php echo ($selected_bulan == '07') ? 'selected' : ''; ?>>Juli</option>
												<option value="08" <?php echo ($selected_bulan == '08') ? 'selected' : ''; ?>>Agustus</option>
												<option value="09" <?php echo ($selected_bulan == '09') ? 'selected' : ''; ?>>September</option>
												<option value="10" <?php echo ($selected_bulan == '10') ? 'selected' : ''; ?>>Oktober</option>
												<option value="11" <?php echo ($selected_bulan == '11') ? 'selected' : ''; ?>>November</option>
												<option value="12" <?php echo ($selected_bulan == '12') ? 'selected' : ''; ?>>Desember</option>
											</select>
										</div>
									</div>

									<!-- Tahun -->
									<div class="col-md-2">
										<div class="form-group">
											<label>Tahun</label>
											<select name="lap_tahun" class="form-control" id="lap_tahun">
												<?php for ($i = date('Y'); $i >= 2020; $i--): ?>
													<option value="<?php echo $i; ?>" <?php echo ($selected_tahun == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
												<?php endfor; ?>
											</select>
										</div>
									</div>

									<!-- Jenis Perkara -->
									<div class="col-md-2">
										<div class="form-group">
											<label>Jenis Perkara</label>
											<select name="jenis_perkara" class="form-control" id="jenis_perkara">
												<option value="Cerai Gugat" <?php echo ($selected_jenis == 'Cerai Gugat') ? 'selected' : ''; ?>>Cerai Gugat</option>
												<?php if (isset($jenis_perkara_list) && count($jenis_perkara_list) > 0): ?>
													<?php foreach ($jenis_perkara_list as $item): ?>
														<?php if ($item->jenis_perkara_nama !== 'Cerai Gugat'): // Hindari duplikasi 
														?>
															<option value="<?php echo $item->jenis_perkara_nama; ?>" <?php echo ($selected_jenis == $item->jenis_perkara_nama) ? 'selected' : ''; ?>>
																<?php echo $item->jenis_perkara_nama; ?>
															</option>
														<?php endif; ?>
													<?php endforeach; ?>
												<?php else: ?>
													<option value="Cerai Talak" <?php echo ($selected_jenis == 'Cerai Talak') ? 'selected' : ''; ?>>Cerai Talak</option>
												<?php endif; ?>
											</select>
										</div>
									</div>

									<!-- Tipe Laporan -->
									<div class="col-md-3">
										<div class="form-group">
											<label>Tipe Laporan</label>
											<select name="report_type" class="form-control" id="report_type">
												<option value="summary" <?php echo ($selected_report == 'summary') ? 'selected' : ''; ?>>Ringkasan Bulanan</option>
												<option value="yearly" <?php echo ($selected_report == 'yearly') ? 'selected' : ''; ?>>Laporan Tahunan</option>
												<!-- <option value="monthly" <?php echo ($selected_report == 'monthly') ? 'selected' : ''; ?>>Breakdown Bulanan</option> -->
												<option value="comparison" <?php echo ($selected_report == 'comparison') ? 'selected' : ''; ?>>Perbandingan Gugat vs Talak</option>
											</select>
										</div>
									</div>
								</div>

								<!-- Filter tambahan untuk faktor perceraian -->
								<div class="row" id="gender_filter" style="<?php echo ($selected_report == 'faktor') ? 'display:block;' : 'display:none;'; ?>">
									<div class="col-md-3">
										<div class="form-group">
											<label>Jenis Kelamin</label>
											<select name="jenis_kelamin" class="form-control">
												<option value="L" <?php echo (isset($selected_gender) && $selected_gender == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
												<option value="P" <?php echo (isset($selected_gender) && $selected_gender == 'P') ? 'selected' : ''; ?>>Perempuan</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer">
								<button type="submit" class="btn btn-primary">
									<i class="fas fa-search"></i> Tampilkan Data
								</button>
								<button type="button" class="btn btn-success" onclick="exportExcel()">
									<i class="fas fa-file-excel"></i> Export Excel
								</button>
								<button type="button" class="btn btn-info" onclick="printReport()">
									<i class="fas fa-print"></i> Print
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>

			<?php if ($selected_report == 'summary' || $selected_report == 'yearly'): ?>
				<!-- Summary Cards -->
				<div class="row">
					<?php
					// Calculate totals for summary cards
					$card_total_masuk = 0;
					$card_total_putus = 0;
					$card_total_bht = 0;
					$card_total_akta = 0;

					if (!empty($datafilter)) {
						foreach ($datafilter as $row) {
							$card_total_masuk += $row->PERKARA_MASUK;
							$card_total_putus += $row->PERKARA_PUTUS;
							$card_total_bht += $row->PERKARA_TELAH_BHT;
							$card_total_akta += $row->JUMLAH_AKTA_CERAI;
						}
					}

					// Calculate percentage for BHT completion rate
					$persentase_bht = $card_total_putus > 0 ? round(($card_total_bht / $card_total_putus) * 100, 1) : 0;
					?>

					<div class="col-lg-3 col-6">
						<div class="small-box bg-info">
							<div class="inner">
								<h3><?php echo number_format($card_total_masuk); ?></h3>
								<p>Perkara Masuk</p>
							</div>
							<div class="icon">
								<i class="fas fa-file-plus"></i>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-6">
						<div class="small-box bg-warning">
							<div class="inner">
								<h3><?php echo number_format($card_total_putus); ?></h3>
								<p>Perkara Putus</p>
							</div>
							<div class="icon">
								<i class="fas fa-gavel"></i>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-6">
						<div class="small-box bg-success">
							<div class="inner">
								<h3><?php echo number_format($card_total_bht); ?></h3>
								<p>Perkara Telah BHT</p>
							</div>
							<div class="icon">
								<i class="fas fa-check-circle"></i>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-6">
						<div class="small-box bg-danger">
							<div class="inner">
								<h3><?php echo $persentase_bht; ?>%</h3>
								<p>Persentase BHT</p>
							</div>
							<div class="icon">
								<i class="fas fa-percentage"></i>
							</div>
						</div>
					</div>
				</div>
			<?php elseif ($selected_report == 'comparison'): ?>
				<!-- Comparison Summary Cards -->
				<div class="row">
					<?php
					// Calculate totals for comparison cards
					$card_total_gugat = 0;
					$card_total_talak = 0;
					$card_grand_total = 0;

					if (!empty($datafilter)) {
						foreach ($datafilter as $row) {
							$card_total_gugat += $row->CERAI_GUGAT;
							$card_total_talak += $row->CERAI_TALAK;
							$card_grand_total += $row->TOTAL;
						}
					}

					// Calculate percentages
					$persentase_gugat = $card_grand_total > 0 ? round(($card_total_gugat / $card_grand_total) * 100, 1) : 0;
					$persentase_talak = $card_grand_total > 0 ? round(($card_total_talak / $card_grand_total) * 100, 1) : 0;
					?>

					<div class="col-lg-3 col-6">
						<div class="small-box bg-info">
							<div class="inner">
								<h3><?php echo number_format($card_total_gugat); ?></h3>
								<p>Total Cerai Gugat</p>
							</div>
							<div class="icon">
								<i class="fas fa-female"></i>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-6">
						<div class="small-box bg-warning">
							<div class="inner">
								<h3><?php echo number_format($card_total_talak); ?></h3>
								<p>Total Cerai Talak</p>
							</div>
							<div class="icon">
								<i class="fas fa-male"></i>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-6">
						<div class="small-box bg-success">
							<div class="inner">
								<h3><?php echo number_format($card_grand_total); ?></h3>
								<p>Total Keseluruhan</p>
							</div>
							<div class="icon">
								<i class="fas fa-users"></i>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-6">
						<div class="small-box bg-danger">
							<div class="inner">
								<h3><?php echo $persentase_gugat; ?>%</h3>
								<p>Persentase Gugat</p>
							</div>
							<div class="icon">
								<i class="fas fa-percentage"></i>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<?php if ($selected_report == 'monthly'): ?>
				<!-- Monthly Summary Cards -->
				<div class="row">
					<?php
					// Calculate totals for monthly cards
					$card_total_monthly = 0;
					$max_monthly = 0;
					$min_monthly = PHP_INT_MAX;
					$bulan_tertinggi = '';

					if (!empty($datafilter)) {
						foreach ($datafilter as $row) {
							$card_total_monthly += $row->JUMLAH;
							if ($row->JUMLAH > $max_monthly) {
								$max_monthly = $row->JUMLAH;
								$bulan_tertinggi = $row->NAMA_BULAN;
							}
							if ($row->JUMLAH < $min_monthly) {
								$min_monthly = $row->JUMLAH;
							}
						}
						if ($min_monthly == PHP_INT_MAX) $min_monthly = 0;
					}

					$rata_rata = count($datafilter) > 0 ? round($card_total_monthly / count($datafilter), 0) : 0;
					?>

					<div class="col-lg-3 col-6">
						<div class="small-box bg-info">
							<div class="inner">
								<h3><?php echo number_format($card_total_monthly); ?></h3>
								<p>Total Perkara</p>
							</div>
							<div class="icon">
								<i class="fas fa-calendar-alt"></i>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-6">
						<div class="small-box bg-warning">
							<div class="inner">
								<h3><?php echo number_format($max_monthly); ?></h3>
								<p>Tertinggi (<?php echo $bulan_tertinggi; ?>)</p>
							</div>
							<div class="icon">
								<i class="fas fa-arrow-up"></i>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-6">
						<div class="small-box bg-success">
							<div class="inner">
								<h3><?php echo number_format($rata_rata); ?></h3>
								<p>Rata-rata per Bulan</p>
							</div>
							<div class="icon">
								<i class="fas fa-chart-line"></i>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-6">
						<div class="small-box bg-danger">
							<div class="inner">
								<h3><?php echo number_format($min_monthly); ?></h3>
								<p>Terendah</p>
							</div>
							<div class="icon">
								<i class="fas fa-arrow-down"></i>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<!-- Data Table -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">
								<i class="fas fa-table"></i>
								<?php
								switch ($selected_report) {
									case 'yearly':
										echo 'Laporan Tahunan ' . $selected_tahun;
										break;
									case 'monthly':
										echo 'Breakdown Bulanan ' . $selected_tahun;
										break;
									case 'comparison':
										echo 'Perbandingan Cerai Gugat vs Cerai Talak';
										break;
									case 'faktor':
										echo 'Faktor Perceraian Berdasarkan Usia';
										break;
									case 'faktor_detail':
										echo 'Detail Faktor Perceraian';
										break;
									default:
										echo 'Ringkasan Data Perkara ' . date('F Y', mktime(0, 0, 0, $selected_bulan, 1, $selected_tahun));
								}
								?>
							</h3>
						</div>
						<div class="card-body">
							<?php if ($selected_report == 'summary' || $selected_report == 'yearly'): ?>
								<!-- Tabel Summary/Yearly -->
								<div class="table-responsive">
									<table id="dataTable" class="table table-bordered table-striped">
										<thead>
											<tr class="bg-primary">
												<th>Kecamatan</th>
												<th>Perkara Masuk</th>
												<th>Perkara Putus</th>
												<th>Perkara Telah BHT</th>
												<th>Jumlah Akta Cerai</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$total_masuk = 0;
											$total_putus = 0;
											$total_bht = 0;
											$total_akta = 0;

											if (!empty($datafilter)):
												foreach ($datafilter as $row):
													$total_masuk += $row->PERKARA_MASUK;
													$total_putus += $row->PERKARA_PUTUS;
													$total_bht += $row->PERKARA_TELAH_BHT;
													$total_akta += $row->JUMLAH_AKTA_CERAI;
											?>
													<tr>
														<td><?php echo $row->KECAMATAN; ?></td>
														<td class="text-center"><?php echo number_format($row->PERKARA_MASUK); ?></td>
														<td class="text-center"><?php echo number_format($row->PERKARA_PUTUS); ?></td>
														<td class="text-center"><?php echo number_format($row->PERKARA_TELAH_BHT); ?></td>
														<td class="text-center"><?php echo number_format($row->JUMLAH_AKTA_CERAI); ?></td>
													</tr>
												<?php
												endforeach;
											else:
												?>
												<tr>
													<td colspan="5" class="text-center">Tidak ada data</td>
												</tr>
											<?php endif; ?>
										</tbody>
										<tfoot>
											<tr class="bg-light font-weight-bold">
												<th>TOTAL</th>
												<th class="text-center"><?php echo number_format($total_masuk); ?></th>
												<th class="text-center"><?php echo number_format($total_putus); ?></th>
												<th class="text-center"><?php echo number_format($total_bht); ?></th>
												<th class="text-center"><?php echo number_format($total_akta); ?></th>
											</tr>
										</tfoot>
									</table>
								</div>

							<?php elseif ($selected_report == 'monthly'): ?>
								<!-- Tabel Monthly Breakdown -->
								<div class="table-responsive">
									<table id="dataTable" class="table table-bordered table-striped">
										<thead>
											<tr class="bg-primary">
												<th>Bulan</th>
												<th>Jumlah Perkara</th>
												<th>Persentase</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$total_monthly = 0;
											if (!empty($datafilter)):
												foreach ($datafilter as $row):
													$total_monthly += $row->JUMLAH;
												endforeach;
											endif;

											if (!empty($datafilter)):
												foreach ($datafilter as $row):
													$persentase = $total_monthly > 0 ? round(($row->JUMLAH / $total_monthly) * 100, 2) : 0;
											?>
													<tr>
														<td><?php echo $row->NAMA_BULAN; ?></td>
														<td class="text-center"><?php echo number_format($row->JUMLAH); ?></td>
														<td class="text-center"><?php echo $persentase; ?>%</td>
													</tr>
												<?php
												endforeach;
											else:
												?>
												<tr>
													<td colspan="3" class="text-center">Tidak ada data</td>
												</tr>
											<?php endif; ?>
										</tbody>
										<tfoot>
											<tr class="bg-light font-weight-bold">
												<th>TOTAL</th>
												<th class="text-center"><?php echo number_format($total_monthly); ?></th>
												<th class="text-center">100%</th>
											</tr>
										</tfoot>
									</table>
								</div>

							<?php elseif ($selected_report == 'comparison'): ?>
								<!-- Tabel Comparison -->
								<div class="table-responsive">
									<table id="dataTable" class="table table-bordered table-striped">
										<thead>
											<tr class="bg-primary">
												<th>Kecamatan</th>
												<th>Cerai Gugat</th>
												<th>Cerai Talak</th>
												<th>Total</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$total_gugat = 0;
											$total_talak = 0;
											$grand_total = 0;

											if (!empty($datafilter)):
												foreach ($datafilter as $row):
													$total_gugat += $row->CERAI_GUGAT;
													$total_talak += $row->CERAI_TALAK;
													$grand_total += $row->TOTAL;
											?>
													<tr>
														<td><?php echo $row->KECAMATAN; ?></td>
														<td class="text-center"><?php echo number_format($row->CERAI_GUGAT); ?></td>
														<td class="text-center"><?php echo number_format($row->CERAI_TALAK); ?></td>
														<td class="text-center font-weight-bold"><?php echo number_format($row->TOTAL); ?></td>
													</tr>
												<?php
												endforeach;
											else:
												?>
												<tr>
													<td colspan="4" class="text-center">Tidak ada data</td>
												</tr>
											<?php endif; ?>
										</tbody>
										<tfoot>
											<tr class="bg-light font-weight-bold">
												<th>TOTAL</th>
												<th class="text-center"><?php echo number_format($total_gugat); ?></th>
												<th class="text-center"><?php echo number_format($total_talak); ?></th>
												<th class="text-center"><?php echo number_format($grand_total); ?></th>
											</tr>
										</tfoot>
									</table>
								</div>

							<?php elseif ($selected_report == 'faktor_detail'): ?>
								<!-- Tabel Faktor Detail -->
								<div class="table-responsive">
									<table id="dataTable" class="table table-bordered table-striped">
										<thead>
											<tr class="bg-primary">
												<th>Faktor Perceraian</th>
												<th>Jumlah Kasus</th>
												<th>Persentase</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$total_faktor = 0;
											if (!empty($datafilter)):
												foreach ($datafilter as $row):
													$total_faktor += $row->JUMLAH;
												endforeach;
											endif;

											if (!empty($datafilter)):
												foreach ($datafilter as $row):
											?>
													<tr>
														<td><?php echo $row->FAKTOR; ?></td>
														<td class="text-center"><?php echo number_format($row->JUMLAH); ?></td>
														<td class="text-center"><?php echo $row->PERSENTASE; ?>%</td>
													</tr>
												<?php
												endforeach;
											else:
												?>
												<tr>
													<td colspan="3" class="text-center">Tidak ada data</td>
												</tr>
											<?php endif; ?>
										</tbody>
										<tfoot>
											<tr class="bg-light font-weight-bold">
												<th>TOTAL</th>
												<th class="text-center"><?php echo number_format($total_faktor); ?></th>
												<th class="text-center">100%</th>
											</tr>
										</tfoot>
									</table>
								</div>

							<?php elseif ($selected_report == 'faktor'): ?>
								<!-- Tabel Faktor Berdasarkan Usia -->
								<div class="table-responsive">
									<table id="dataTable" class="table table-bordered table-striped">
										<thead>
											<tr class="bg-primary">
												<th>Faktor Perceraian</th>
												<th>16-19 Tahun</th>
												<th>20-25 Tahun</th>
												<th>26-30 Tahun</th>
												<th>31-35 Tahun</th>
												<th>36+ Tahun</th>
												<th>Total</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$total_usia_16_19 = 0;
											$total_usia_20_25 = 0;
											$total_usia_26_30 = 0;
											$total_usia_31_35 = 0;
											$total_usia_36_plus = 0;
											$grand_total_faktor = 0;

											if (!empty($datafilter)):
												$gender_suffix = isset($selected_gender) ? "($selected_gender)" : "(L)";

												// Calculate totals first
												foreach ($datafilter as $row):
													$total_usia_16_19 += isset($row->{"Usia 16-19 $gender_suffix"}) ? $row->{"Usia 16-19 $gender_suffix"} : 0;
													$total_usia_20_25 += isset($row->{"Usia 20-25 $gender_suffix"}) ? $row->{"Usia 20-25 $gender_suffix"} : 0;
													$total_usia_26_30 += isset($row->{"Usia 26-30 $gender_suffix"}) ? $row->{"Usia 26-30 $gender_suffix"} : 0;
													$total_usia_31_35 += isset($row->{"Usia 31-35 $gender_suffix"}) ? $row->{"Usia 31-35 $gender_suffix"} : 0;
													$total_usia_36_plus += isset($row->{"Usia 36+ $gender_suffix"}) ? $row->{"Usia 36+ $gender_suffix"} : 0;
													$grand_total_faktor += isset($row->{"Total $gender_suffix"}) ? $row->{"Total $gender_suffix"} : 0;
												endforeach;

												// Display rows
												foreach ($datafilter as $row):
											?>
													<tr>
														<td><?php echo $row->FaktorPerceraian; ?></td>
														<td class="text-center"><?php echo isset($row->{"Usia 16-19 $gender_suffix"}) ? number_format($row->{"Usia 16-19 $gender_suffix"}) : '0'; ?></td>
														<td class="text-center"><?php echo isset($row->{"Usia 20-25 $gender_suffix"}) ? number_format($row->{"Usia 20-25 $gender_suffix"}) : '0'; ?></td>
														<td class="text-center"><?php echo isset($row->{"Usia 26-30 $gender_suffix"}) ? number_format($row->{"Usia 26-30 $gender_suffix"}) : '0'; ?></td>
														<td class="text-center"><?php echo isset($row->{"Usia 31-35 $gender_suffix"}) ? number_format($row->{"Usia 31-35 $gender_suffix"}) : '0'; ?></td>
														<td class="text-center"><?php echo isset($row->{"Usia 36+ $gender_suffix"}) ? number_format($row->{"Usia 36+ $gender_suffix"}) : '0'; ?></td>
														<td class="text-center font-weight-bold"><?php echo isset($row->{"Total $gender_suffix"}) ? number_format($row->{"Total $gender_suffix"}) : '0'; ?></td>
													</tr>
												<?php
												endforeach;
											else:
												?>
												<tr>
													<td colspan="7" class="text-center">Tidak ada data</td>
												</tr>
											<?php endif; ?>
										</tbody>
										<tfoot>
											<tr class="bg-light font-weight-bold">
												<th>TOTAL</th>
												<th class="text-center"><?php echo number_format($total_usia_16_19); ?></th>
												<th class="text-center"><?php echo number_format($total_usia_20_25); ?></th>
												<th class="text-center"><?php echo number_format($total_usia_26_30); ?></th>
												<th class="text-center"><?php echo number_format($total_usia_31_35); ?></th>
												<th class="text-center"><?php echo number_format($total_usia_36_plus); ?></th>
												<th class="text-center"><?php echo number_format($grand_total_faktor); ?></th>
											</tr>
										</tfoot>
									</table>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>

		</div>
	</section>
</div>

<!-- JavaScript -->
<script>
	$(document).ready(function() {
		// Initialize DataTable
		$('#dataTable').DataTable({
			"responsive": true,
			"lengthChange": false,
			"autoWidth": false,
			"paging": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"pageLength": 25,
			"language": {
				"search": "Cari:",
				"lengthMenu": "Tampilkan _MENU_ data per halaman",
				"zeroRecords": "Data tidak ditemukan",
				"info": "Menampilkan halaman _PAGE_ dari _PAGES_",
				"infoEmpty": "Tidak ada data tersedia",
				"infoFiltered": "(difilter dari _MAX_ total data)",
				"paginate": {
					"first": "Pertama",
					"last": "Terakhir",
					"next": "Selanjutnya",
					"previous": "Sebelumnya"
				}
			}
		});

		// Show/hide gender filter
		$('#report_type').change(function() {
			if ($(this).val() == 'faktor') {
				$('#gender_filter').show();
			} else {
				$('#gender_filter').hide();
			}
		});

		// Auto submit when filter changes
		$('#wilayah, #lap_bulan, #lap_tahun, #jenis_perkara, #report_type').change(function() {
			// Optional: auto submit form
			// $('#filterForm').submit();
		});
	});

	// Export Excel function
	function exportExcel() {
		var formData = $('#filterForm').serialize();
		var form = $('<form method="post" action="<?php echo site_url('Data_Perkara_Gugatan/export_excel') ?>">');

		// Add all form fields to export form
		$('#filterForm').serializeArray().forEach(function(item) {
			form.append($('<input type="hidden" name="' + item.name + '" value="' + item.value + '">'));
		});

		$('body').append(form);
		form.submit();
		form.remove();
	}

	// Print function
	function printReport() {
		window.print();
	}
</script>

<!-- Print styles -->
<style>
	@media print {

		.sidebar,
		.main-header,
		.content-header .breadcrumb,
		.card-header .card-tools,
		.btn,
		.content-wrapper .content-header,
		.main-footer {
			display: none !important;
		}

		.content-wrapper {
			margin-left: 0 !important;
		}

		.card {
			border: none !important;
			box-shadow: none !important;
		}

		table {
			font-size: 12px !important;
		}
	}

	.table th {
		background-color: #007bff !important;
		color: white !important;
	}

	.bg-light th {
		background-color: #f8f9fa !important;
		color: #495057 !important;
		font-weight: bold !important;
		border-top: 2px solid #dee2e6 !important;
	}

	.table tfoot th {
		background-color: #e9ecef !important;
		color: #495057 !important;
		font-weight: bold !important;
		font-size: 14px !important;
		border-top: 2px solid #dee2e6 !important;
	}

	.table tbody tr:hover {
		background-color: #f5f5f5;
	}

	.card-title i {
		margin-right: 8px;
	}

	/* Enhanced total row styling */
	tfoot tr.bg-light th {
		background-color: #e9ecef !important;
		font-weight: 700 !important;
		color: #333 !important;
		border-top: 3px solid #007bff !important;
		font-size: 14px !important;
	}

	/* Summary Cards Enhancements */
	.small-box {
		border-radius: 10px !important;
		box-shadow: 0 0 10px rgba(0, 0, 0, 0.1) !important;
		transition: transform 0.2s ease-in-out !important;
	}

	.small-box:hover {
		transform: translateY(-5px) !important;
	}

	.small-box .inner h3 {
		font-size: 2.2rem !important;
		font-weight: bold !important;
		margin-bottom: 5px !important;
	}

	.small-box .inner p {
		font-size: 0.9rem !important;
		margin-bottom: 0 !important;
	}

	.small-box .icon {
		font-size: 50px !important;
	}

	/* Custom colors for cards */
	.bg-info {
		background: linear-gradient(45deg, #17a2b8, #20c997) !important;
	}

	.bg-warning {
		background: linear-gradient(45deg, #ffc107, #fd7e14) !important;
	}

	.bg-success {
		background: linear-gradient(45deg, #28a745, #20c997) !important;
	}

	.bg-danger {
		background: linear-gradient(45deg, #dc3545, #e83e8c) !important;
	}

	.table tbody tr:hover {
		background-color: #f5f5f5;
	}

	.card-title i {
		margin-right: 8px;
	}
</style>
