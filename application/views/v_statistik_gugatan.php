<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-chart-line"></i> Statistik Gugatan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo site_url('Dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Statistik Gugatan</li>
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
                    <h3 class="card-title"><i class="fas fa-filter"></i> Filter Analisis</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo site_url('Statistik_Gugatan') ?>" id="filterForm">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="lap_tahun">Tahun</label>
                                    <select class="form-control" name="lap_tahun" id="lap_tahun">
                                        <?php for ($i = date('Y'); $i >= 2020; $i--) { ?>
                                            <option value="<?php echo $i; ?>" <?php echo ($selected_tahun == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="analisis_type">Jenis Analisis</label>
                                    <select class="form-control" name="analisis_type" id="analisis_type">
                                        <option value="tren_bulanan" <?php echo ($selected_analisis == 'tren_bulanan') ? 'selected' : ''; ?>>Tren Bulanan</option>
                                        <option value="perbandingan_wilayah" <?php echo ($selected_analisis == 'perbandingan_wilayah') ? 'selected' : ''; ?>>Perbandingan Wilayah</option>
                                        <option value="tingkat_keberhasilan" <?php echo ($selected_analisis == 'tingkat_keberhasilan') ? 'selected' : ''; ?>>Tingkat Keberhasilan</option>
                                        <option value="waktu_penyelesaian" <?php echo ($selected_analisis == 'waktu_penyelesaian') ? 'selected' : ''; ?>>Waktu Penyelesaian</option>
                                        <option value="demografis_penggugat" <?php echo ($selected_analisis == 'demografis_penggugat') ? 'selected' : ''; ?>>Demografis Penggugat</option>
                                        <option value="analisis_tahunan" <?php echo ($selected_analisis == 'analisis_tahunan') ? 'selected' : ''; ?>>Analisis 5 Tahun</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label><br>
                                    <button type="submit" class="btn btn-primary mr-2">
                                        <i class="fas fa-search"></i> Analisis
                                    </button>
                                    <button type="button" class="btn btn-success" onclick="exportExcel()">
                                        <i class="fas fa-file-excel"></i> Excel
                                    </button>
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
                            <h3><?php echo number_format($total_gugatan); ?></h3>
                            <p>Total Gugatan <?php echo $selected_tahun; ?></p>
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
                            <p>Gugatan Dikabulkan</p>
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
                            <p>Gugatan Ditolak</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?php echo number_format($rata_waktu); ?></h3>
                            <p>Rata-rata Hari Proses</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Chart Section -->
                <div class="col-md-8">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-line mr-2"></i>
                                <?php 
                                switch($selected_analisis) {
                                    case 'tren_bulanan': echo 'Tren Gugatan Bulanan ' . $selected_tahun; break;
                                    case 'perbandingan_wilayah': echo 'Perbandingan Antar Wilayah ' . $selected_tahun; break;
                                    case 'tingkat_keberhasilan': echo 'Tingkat Keberhasilan Gugatan ' . $selected_tahun; break;
                                    case 'waktu_penyelesaian': echo 'Distribusi Waktu Penyelesaian ' . $selected_tahun; break;
                                    case 'demografis_penggugat': echo 'Demografis Penggugat ' . $selected_tahun; break;
                                    case 'analisis_tahunan': echo 'Analisis Trend 5 Tahun Terakhir'; break;
                                    default: echo 'Statistik Gugatan';
                                }
                                ?>
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" onclick="printChart()">
                                    <i class="fas fa-print"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="mainChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Panel -->
                <div class="col-md-4">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-info-circle"></i> Informasi Analisis</h3>
                        </div>
                        <div class="card-body">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary"><i class="fas fa-calendar"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Periode</span>
                                    <span class="info-box-number"><?php echo $selected_tahun; ?></span>
                                </div>
                            </div>
                            
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-building"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Pengadilan</span>
                                    <span class="info-box-number">PA Amuntai</span>
                                </div>
                            </div>

                            <?php if ($selected_analisis == 'tingkat_keberhasilan'): ?>
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-percentage"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Tingkat Keberhasilan</span>
                                    <span class="info-box-number">
                                        <?php echo $total_gugatan > 0 ? round(($total_dikabulkan / $total_gugatan) * 100, 1) : 0; ?>%
                                    </span>
                                </div>
                            </div>
                            <?php endif; ?>

                            <hr>
                            <h5>Keterangan:</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-circle text-success mr-2"></i>Dikabulkan: Gugatan diterima pengadilan</li>
                                <li><i class="fas fa-circle text-danger mr-2"></i>Ditolak: Gugatan ditolak pengadilan</li>
                                <li><i class="fas fa-circle text-warning mr-2"></i>Dicabut: Gugatan dicabut pemohon</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-table"></i> Data Detail</h3>
                    <div class="card-tools">
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
                                    <?php if ($selected_analisis == 'tren_bulanan'): ?>
                                        <th>Bulan</th>
                                        <th>Total Gugatan</th>
                                        <th>Dikabulkan</th>
                                        <th>Ditolak</th>
                                        <th>Dicabut</th>
                                        <th>% Keberhasilan</th>
                                    <?php elseif ($selected_analisis == 'perbandingan_wilayah'): ?>
                                        <th>Wilayah</th>
                                        <th>Total Gugatan</th>
                                        <th>Dikabulkan</th>
                                        <th>Ditolak</th>
                                        <th>Dicabut</th>
                                        <th>% Keberhasilan</th>
                                    <?php elseif ($selected_analisis == 'tingkat_keberhasilan'): ?>
                                        <th>Status Putusan</th>
                                        <th>Jumlah</th>
                                        <th>Persentase</th>
                                    <?php elseif ($selected_analisis == 'waktu_penyelesaian'): ?>
                                        <th>Kategori Waktu</th>
                                        <th>Jumlah Perkara</th>
                                        <th>Rata-rata Hari</th>
                                        <th>Persentase</th>
                                    <?php elseif ($selected_analisis == 'analisis_tahunan'): ?>
                                        <th>Tahun</th>
                                        <th>Total Gugatan</th>
                                        <th>Dikabulkan</th>
                                        <th>Ditolak</th>
                                        <th>Rata-rata Hari</th>
                                        <th>% Keberhasilan</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($chart_data)): ?>
                                    <?php foreach ($chart_data as $row): ?>
                                        <tr>
                                            <?php if ($selected_analisis == 'tren_bulanan'): ?>
                                                <td><?php echo isset($row->nama_bulan) ? $row->nama_bulan : 'Bulan ' . $row->bulan; ?></td>
                                                <td><?php echo number_format($row->total_gugatan); ?></td>
                                                <td><?php echo number_format($row->dikabulkan); ?></td>
                                                <td><?php echo number_format($row->ditolak); ?></td>
                                                <td><?php echo number_format($row->dicabut); ?></td>
                                                <td><?php echo $row->total_gugatan > 0 ? round(($row->dikabulkan / $row->total_gugatan) * 100, 1) : 0; ?>%</td>
                                            <?php elseif ($selected_analisis == 'perbandingan_wilayah'): ?>
                                                <td><?php echo $row->wilayah; ?></td>
                                                <td><?php echo number_format($row->total_gugatan); ?></td>
                                                <td><?php echo number_format($row->dikabulkan); ?></td>
                                                <td><?php echo number_format($row->ditolak); ?></td>
                                                <td><?php echo number_format($row->dicabut); ?></td>
                                                <td><?php echo $row->persentase_berhasil; ?>%</td>
                                            <?php elseif ($selected_analisis == 'tingkat_keberhasilan'): ?>
                                                <td><?php echo $row->status_putusan; ?></td>
                                                <td><?php echo number_format($row->jumlah); ?></td>
                                                <td><?php echo $row->persentase; ?>%</td>
                                            <?php elseif ($selected_analisis == 'waktu_penyelesaian'): ?>
                                                <td><?php echo $row->kategori_waktu; ?></td>
                                                <td><?php echo number_format($row->jumlah); ?></td>
                                                <td><?php echo $row->rata_hari; ?> hari</td>
                                                <td><?php echo $row->persentase; ?>%</td>
                                            <?php elseif ($selected_analisis == 'analisis_tahunan'): ?>
                                                <td><?php echo $row->tahun; ?></td>
                                                <td><?php echo number_format($row->total_gugatan); ?></td>
                                                <td><?php echo number_format($row->dikabulkan); ?></td>
                                                <td><?php echo number_format($row->ditolak); ?></td>
                                                <td><?php echo $row->rata_waktu_hari; ?> hari</td>
                                                <td><?php echo $row->tingkat_keberhasilan; ?>%</td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data untuk periode yang dipilih</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Tunggu sampai document ready
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTable
    if (typeof $ !== 'undefined' && typeof $.fn.DataTable !== 'undefined' && $('#dataTable').length) {
        $('#dataTable').DataTable({
            "responsive": true,
            "lengthChange": true,
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
    }

    // Create Chart
    const ctx = document.getElementById('mainChart');
    if (ctx) {
        createChart();
    }
});

function createChart() {
    const ctx = document.getElementById('mainChart').getContext('2d');
    const analisisType = '<?php echo $selected_analisis; ?>';
    
    let chartConfig = {};
    
    <?php if ($selected_analisis == 'tren_bulanan'): ?>
        // Tren Bulanan Chart
        chartConfig = {
            type: 'line',
            data: {
                labels: [
                    <?php 
                    if (!empty($chart_data)) {
                        foreach ($chart_data as $row) {
                            echo "'" . (isset($row->nama_bulan) ? $row->nama_bulan : 'Bulan ' . $row->bulan) . "',";
                        }
                    }
                    ?>
                ],
                datasets: [{
                    label: 'Total Gugatan',
                    data: [<?php if (!empty($chart_data)) { foreach ($chart_data as $row) { echo $row->total_gugatan . ','; } } ?>],
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Dikabulkan',
                    data: [<?php if (!empty($chart_data)) { foreach ($chart_data as $row) { echo $row->dikabulkan . ','; } } ?>],
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    tension: 0.4
                }, {
                    label: 'Ditolak',
                    data: [<?php if (!empty($chart_data)) { foreach ($chart_data as $row) { echo $row->ditolak . ','; } } ?>],
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                }
            }
        };
    
    <?php elseif ($selected_analisis == 'tingkat_keberhasilan'): ?>
        // Tingkat Keberhasilan Chart
        chartConfig = {
            type: 'doughnut',
            data: {
                labels: [
                    <?php 
                    if (!empty($chart_data)) {
                        foreach ($chart_data as $row) {
                            echo "'" . $row->status_putusan . "',";
                        }
                    }
                    ?>
                ],
                datasets: [{
                    data: [<?php if (!empty($chart_data)) { foreach ($chart_data as $row) { echo $row->jumlah . ','; } } ?>],
                    backgroundColor: ['#28a745', '#dc3545', '#ffc107', '#6c757d'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        };
    
    <?php elseif ($selected_analisis == 'perbandingan_wilayah'): ?>
        // Perbandingan Wilayah Chart
        chartConfig = {
            type: 'bar',
            data: {
                labels: [
                    <?php 
                    if (!empty($chart_data)) {
                        foreach ($chart_data as $row) {
                            echo "'" . $row->wilayah . "',";
                        }
                    }
                    ?>
                ],
                datasets: [{
                    label: 'Total Gugatan',
                    data: [<?php if (!empty($chart_data)) { foreach ($chart_data as $row) { echo $row->total_gugatan . ','; } } ?>],
                    backgroundColor: '#007bff',
                    borderColor: '#0056b3',
                    borderWidth: 1
                }, {
                    label: 'Dikabulkan',
                    data: [<?php if (!empty($chart_data)) { foreach ($chart_data as $row) { echo $row->dikabulkan . ','; } } ?>],
                    backgroundColor: '#28a745',
                    borderColor: '#1e7e34',
                    borderWidth: 1
                }, {
                    label: 'Ditolak', 
                    data: [<?php if (!empty($chart_data)) { foreach ($chart_data as $row) { echo $row->ditolak . ','; } } ?>],
                    backgroundColor: '#dc3545',
                    borderColor: '#c82333',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        };
        
    <?php else: ?>
        // Default Chart
        chartConfig = {
            type: 'bar',
            data: {
                labels: ['Data'],
                datasets: [{
                    label: 'No Data',
                    data: [0],
                    backgroundColor: '#6c757d'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        };
    <?php endif; ?>

    new Chart(ctx, chartConfig);
}

// Export Excel function
function exportExcel() {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?php echo site_url('Statistik_Gugatan/export_excel'); ?>';
    
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
function printChart() {
    window.print();
}
</script>

<!-- Print styles -->
<style>
.chart-container {
    position: relative;
    height: 400px;
    width: 100%;
    margin-bottom: 20px;
}

#mainChart {
    max-width: 100% !important;
    max-height: 400px !important;
}

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
