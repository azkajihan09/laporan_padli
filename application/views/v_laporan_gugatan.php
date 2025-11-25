<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-file-pdf"></i> Laporan Gugatan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo site_url('Dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Laporan Gugatan</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            
            <!-- Filter Card -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-filter"></i> Filter Laporan</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo site_url('Laporan_Gugatan') ?>" id="filterForm">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="jenis_laporan">Jenis Laporan</label>
                                    <select class="form-control" name="jenis_laporan" id="jenis_laporan" onchange="togglePeriode()">
                                        <option value="bulanan" <?php echo ($selected_jenis == 'bulanan') ? 'selected' : ''; ?>>Bulanan</option>
                                        <option value="triwulan" <?php echo ($selected_jenis == 'triwulan') ? 'selected' : ''; ?>>Triwulan</option>
                                        <option value="semester" <?php echo ($selected_jenis == 'semester') ? 'selected' : ''; ?>>Semester</option>
                                        <option value="tahunan" <?php echo ($selected_jenis == 'tahunan') ? 'selected' : ''; ?>>Tahunan</option>
                                        <option value="custom" <?php echo ($selected_jenis == 'custom') ? 'selected' : ''; ?>>Custom</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2" id="bulan_field">
                                <div class="form-group">
                                    <label for="lap_bulan">Bulan</label>
                                    <select class="form-control" name="lap_bulan" id="lap_bulan">
                                        <option value="1" <?php echo ($selected_bulan == 1) ? 'selected' : ''; ?>>Januari</option>
                                        <option value="2" <?php echo ($selected_bulan == 2) ? 'selected' : ''; ?>>Februari</option>
                                        <option value="3" <?php echo ($selected_bulan == 3) ? 'selected' : ''; ?>>Maret</option>
                                        <option value="4" <?php echo ($selected_bulan == 4) ? 'selected' : ''; ?>>April</option>
                                        <option value="5" <?php echo ($selected_bulan == 5) ? 'selected' : ''; ?>>Mei</option>
                                        <option value="6" <?php echo ($selected_bulan == 6) ? 'selected' : ''; ?>>Juni</option>
                                        <option value="7" <?php echo ($selected_bulan == 7) ? 'selected' : ''; ?>>Juli</option>
                                        <option value="8" <?php echo ($selected_bulan == 8) ? 'selected' : ''; ?>>Agustus</option>
                                        <option value="9" <?php echo ($selected_bulan == 9) ? 'selected' : ''; ?>>September</option>
                                        <option value="10" <?php echo ($selected_bulan == 10) ? 'selected' : ''; ?>>Oktober</option>
                                        <option value="11" <?php echo ($selected_bulan == 11) ? 'selected' : ''; ?>>November</option>
                                        <option value="12" <?php echo ($selected_bulan == 12) ? 'selected' : ''; ?>>Desember</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="lap_tahun">Tahun</label>
                                    <select class="form-control" name="lap_tahun" id="lap_tahun">
                                        <?php for ($i = date('Y'); $i >= 2020; $i--) { ?>
                                            <option value="<?php echo $i; ?>" <?php echo ($selected_tahun == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2" id="triwulan_field" style="display: none;">
                                <div class="form-group">
                                    <label for="triwulan">Triwulan</label>
                                    <select class="form-control" name="triwulan" id="triwulan">
                                        <option value="1" <?php echo (isset($selected_triwulan) && $selected_triwulan == 1) ? 'selected' : ''; ?>>Triwulan 1 (Jan-Mar)</option>
                                        <option value="2" <?php echo (isset($selected_triwulan) && $selected_triwulan == 2) ? 'selected' : ''; ?>>Triwulan 2 (Apr-Jun)</option>
                                        <option value="3" <?php echo (isset($selected_triwulan) && $selected_triwulan == 3) ? 'selected' : ''; ?>>Triwulan 3 (Jul-Sep)</option>
                                        <option value="4" <?php echo (isset($selected_triwulan) && $selected_triwulan == 4) ? 'selected' : ''; ?>>Triwulan 4 (Okt-Des)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2" id="semester_field" style="display: none;">
                                <div class="form-group">
                                    <label for="semester">Semester</label>
                                    <select class="form-control" name="semester" id="semester">
                                        <option value="1" <?php echo (isset($selected_semester) && $selected_semester == 1) ? 'selected' : ''; ?>>Semester 1 (Jan-Jun)</option>
                                        <option value="2" <?php echo (isset($selected_semester) && $selected_semester == 2) ? 'selected' : ''; ?>>Semester 2 (Jul-Des)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2" id="format_field">
                                <div class="form-group">
                                    <label for="format_laporan">Format</label>
                                    <select class="form-control" name="format_laporan" id="format_laporan">
                                        <option value="lengkap" <?php echo ($selected_format == 'lengkap') ? 'selected' : ''; ?>>Lengkap</option>
                                        <option value="ringkas" <?php echo ($selected_format == 'ringkas') ? 'selected' : ''; ?>>Ringkas</option>
                                    </select>
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
                        </div>
                        
                        <!-- Custom Date Range -->
                        <div class="row" id="custom_field" style="display: none;">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tanggal_mulai">Tanggal Mulai</label>
                                    <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai" value="<?php echo isset($tanggal_mulai) ? $tanggal_mulai : date('Y-m-01'); ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tanggal_akhir">Tanggal Akhir</label>
                                    <input type="date" class="form-control" name="tanggal_akhir" id="tanggal_akhir" value="<?php echo isset($tanggal_akhir) ? $tanggal_akhir : date('Y-m-t'); ?>">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?php echo number_format($total_perkara); ?></h3>
                            <p>Total Perkara Gugatan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?php echo number_format($total_dikabulkan); ?></h3>
                            <p>Dikabulkan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?php echo number_format($total_ditolak); ?></h3>
                            <p>Ditolak</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?php echo number_format($total_dicabut); ?></h3>
                            <p>Dicabut</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-ban"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-download"></i> Export & Print</h3>
                        </div>
                        <div class="card-body">
                            <button type="button" class="btn btn-success mr-2" onclick="exportExcel()">
                                <i class="fas fa-file-excel"></i> Export Excel
                            </button>
                            <button type="button" class="btn btn-danger mr-2" onclick="exportPDF()">
                                <i class="fas fa-file-pdf"></i> Export PDF
                            </button>
                            <button type="button" class="btn btn-info" onclick="printLaporan()">
                                <i class="fas fa-print"></i> Print
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-table"></i> Data Laporan Gugatan</h3>
                    <div class="card-tools">
                        <span class="badge badge-secondary">Total: <?php echo count($datafilter); ?> perkara</span>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-bordered table-striped">
                            <thead>
                                <tr class="bg-primary">
                                    <th width="3%">No</th>
                                    <th width="12%">Nomor Perkara</th>
                                    <th width="8%">Tgl Daftar</th>
                                    <th width="20%">Penggugat</th>
                                    <th width="20%">Tergugat</th>
                                    <th width="12%">Jenis Perkara</th>
                                    <th width="10%">Status</th>
                                    <th width="8%">Tgl Putusan</th>
                                    <th width="7%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($datafilter)): ?>
                                    <?php $no = 1; foreach ($datafilter as $row): ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><strong><?php echo $row->nomor_perkara; ?></strong></td>
                                            <td><?php echo date('d/m/Y', strtotime($row->tanggal_pendaftaran)); ?></td>
                                            <td><?php echo character_limiter(strip_tags($row->penggugat), 80); ?></td>
                                            <td><?php echo character_limiter(strip_tags($row->tergugat), 80); ?></td>
                                            <td><span class="badge badge-info"><?php echo $row->jenis_perkara_nama; ?></span></td>
                                            <td>
                                                <?php if ($row->status_putusan): ?>
                                                    <?php if ($row->status_putusan == 'Dikabulkan'): ?>
                                                        <span class="badge badge-success"><?php echo $row->status_putusan; ?></span>
                                                    <?php elseif ($row->status_putusan == 'Ditolak'): ?>
                                                        <span class="badge badge-danger"><?php echo $row->status_putusan; ?></span>
                                                    <?php else: ?>
                                                        <span class="badge badge-warning"><?php echo $row->status_putusan; ?></span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">Proses</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo $row->tanggal_putusan ? date('d/m/Y', strtotime($row->tanggal_putusan)) : '-'; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-xs btn-info" onclick="detailPerkara('<?php echo $row->perkara_id; ?>')" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center">Tidak ada data untuk periode yang dipilih</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Summary Statistics -->
            <?php if (!empty($summary_data)): ?>
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-bar"></i> Ringkasan Statistik</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Total Perkara:</strong></td>
                                    <td><?php echo number_format($summary_data->total_perkara); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Dikabulkan:</strong></td>
                                    <td><span class="text-success"><?php echo number_format($summary_data->dikabulkan); ?> (<?php echo $summary_data->total_perkara > 0 ? round(($summary_data->dikabulkan / $summary_data->total_perkara) * 100, 1) : 0; ?>%)</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Ditolak:</strong></td>
                                    <td><span class="text-danger"><?php echo number_format($summary_data->ditolak); ?> (<?php echo $summary_data->total_perkara > 0 ? round(($summary_data->ditolak / $summary_data->total_perkara) * 100, 1) : 0; ?>%)</span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Dicabut:</strong></td>
                                    <td><span class="text-warning"><?php echo number_format($summary_data->dicabut); ?> (<?php echo $summary_data->total_perkara > 0 ? round(($summary_data->dicabut / $summary_data->total_perkara) * 100, 1) : 0; ?>%)</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Belum Putusan:</strong></td>
                                    <td><span class="text-muted"><?php echo number_format($summary_data->belum_putusan); ?> (<?php echo $summary_data->total_perkara > 0 ? round(($summary_data->belum_putusan / $summary_data->total_perkara) * 100, 1) : 0; ?>%)</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Rata-rata Proses:</strong></td>
                                    <td><span class="text-info"><?php echo $summary_data->rata_hari ? $summary_data->rata_hari . ' hari' : '-'; ?></span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </section>
</div>

<!-- JavaScript -->
<script>
// Initialize DataTable
$(document).ready(function() {
    $('#dataTable').DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "pageLength": 25,
        "order": [[2, "desc"]], // Sort by tanggal daftar desc
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
    
    // Initialize periode visibility
    togglePeriode();
});

// Toggle periode fields based on jenis laporan
function togglePeriode() {
    var jenisLaporan = document.getElementById('jenis_laporan').value;
    
    // Hide all periode fields
    document.getElementById('bulan_field').style.display = 'none';
    document.getElementById('triwulan_field').style.display = 'none';
    document.getElementById('semester_field').style.display = 'none';
    document.getElementById('custom_field').style.display = 'none';
    
    // Show relevant fields
    switch(jenisLaporan) {
        case 'bulanan':
            document.getElementById('bulan_field').style.display = 'block';
            break;
        case 'triwulan':
            document.getElementById('triwulan_field').style.display = 'block';
            break;
        case 'semester':
            document.getElementById('semester_field').style.display = 'block';
            break;
        case 'custom':
            document.getElementById('custom_field').style.display = 'block';
            break;
    }
}

// Export Excel function
function exportExcel() {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?php echo site_url('Laporan_Gugatan/export_excel'); ?>';
    
    // Add form data
    const formData = new FormData(document.getElementById('filterForm'));
    for (let [key, value] of formData.entries()) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = value;
        form.appendChild(input);
    }
    
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

// Export PDF function
function exportPDF() {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?php echo site_url('Laporan_Gugatan/export_pdf'); ?>';
    
    // Add form data
    const formData = new FormData(document.getElementById('filterForm'));
    for (let [key, value] of formData.entries()) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = value;
        form.appendChild(input);
    }
    
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

// Print function
function printLaporan() {
    window.open('<?php echo site_url('Laporan_Gugatan/print_laporan'); ?>', '_blank');
}

// Detail perkara function
function detailPerkara(perkaraId) {
    alert('Fitur detail perkara akan dikembangkan untuk Perkara ID: ' + perkaraId);
}
</script>

<!-- Print styles -->
<style>
@media print {
    .sidebar, .main-header, .content-header .breadcrumb, .card-header .card-tools, 
    .btn, .content-wrapper .content-header, .main-footer {
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
        font-size: 11px !important;
    }
    
    .small-box {
        page-break-inside: avoid;
    }
}
</style>
