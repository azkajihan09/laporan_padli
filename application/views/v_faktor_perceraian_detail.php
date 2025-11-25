<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Faktor Perceraian Detail</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo site_url('Dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Data Perceraian</a></li>
                        <li class="breadcrumb-item active">Faktor Perceraian Detail</li>
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
                        <form method="post" action="<?php echo site_url('Faktor_perceraian_detail') ?>" id="filterForm">
                            <div class="card-body">
                                <div class="row">
                                    <!-- Tahun -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Tahun</label>
                                            <select name="lap_tahun" class="form-control" id="lap_tahun">
                                                <?php 
                                                    $selected_tahun = $this->input->post('lap_tahun') ?: date('Y');
                                                    for($i = date('Y'); $i >= 2020; $i--): 
                                                ?>
                                                    <option value="<?php echo $i; ?>" <?php echo ($selected_tahun == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Wilayah -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Wilayah</label>
                                            <select name="wilayah" class="form-control" id="wilayah">
                                                <?php $selected_wilayah = $this->input->post('wilayah') ?: 'Balangan'; ?>
                                                <option value="Balangan" <?php echo ($selected_wilayah == 'Balangan') ? 'selected' : ''; ?>>Balangan</option>
                                                <option value="HSU" <?php echo ($selected_wilayah == 'HSU') ? 'selected' : ''; ?>>Hulu Sungai Utara</option>
                                                <option value="Semua Wilayah" <?php echo ($selected_wilayah == 'Semua Wilayah') ? 'selected' : ''; ?>>Semua Wilayah</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Button -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div class="d-block">
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Data Summary Cards -->
            <div class="row">
                <?php 
                    $total_laki = 0;
                    $total_perempuan = 0;
                    $grand_total = 0;
                    if(!empty($datafilter)):
                        foreach($datafilter as $row):
                            if($row->FaktorPerceraian != 'TOTAL'):
                                $total_laki += $row->{'Laki-Laki'};
                                $total_perempuan += $row->Perempuan;
                                $grand_total += $row->Total;
                            endif;
                        endforeach;
                    endif;
                ?>
                
                <!-- Total Laki-laki Card -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?php echo number_format($total_laki); ?></h3>
                            <p>Total Laki-laki</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-mars"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Perempuan Card -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?php echo number_format($total_perempuan); ?></h3>
                            <p>Total Perempuan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-venus"></i>
                        </div>
                    </div>
                </div>

                <!-- Grand Total Card -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?php echo number_format($grand_total); ?></h3>
                            <p>Total Keseluruhan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>

                <!-- Persentase Perempuan Card -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?php echo $grand_total > 0 ? round(($total_perempuan / $grand_total) * 100, 1) : 0; ?>%</h3>
                            <p>Persentase Perempuan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-percentage"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-table"></i>
                                Laporan Faktor Perceraian Detail - <?php echo $selected_tahun; ?> - <?php echo $selected_wilayah; ?>
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="bg-primary">
                                            <th class="text-center">No</th>
                                            <th>Faktor Perceraian</th>
                                            <th class="text-center">Laki-laki</th>
                                            <th class="text-center">Perempuan</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">% Laki-laki</th>
                                            <th class="text-center">% Perempuan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            if(!empty($datafilter)): 
                                                $no = 1;
                                                foreach($datafilter as $row): 
                                                    if($row->FaktorPerceraian != 'TOTAL'):
                                                        $persen_laki = $row->Total > 0 ? round(($row->{'Laki-Laki'} / $row->Total) * 100, 1) : 0;
                                                        $persen_perempuan = $row->Total > 0 ? round(($row->Perempuan / $row->Total) * 100, 1) : 0;
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++; ?></td>
                                            <td><?php echo $row->FaktorPerceraian; ?></td>
                                            <td class="text-center"><?php echo number_format($row->{'Laki-Laki'}); ?></td>
                                            <td class="text-center"><?php echo number_format($row->Perempuan); ?></td>
                                            <td class="text-center font-weight-bold"><?php echo number_format($row->Total); ?></td>
                                            <td class="text-center"><?php echo $persen_laki; ?>%</td>
                                            <td class="text-center"><?php echo $persen_perempuan; ?>%</td>
                                        </tr>
                                        <?php 
                                                    endif;
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
                                            <th colspan="2" class="text-center">TOTAL</th>
                                            <th class="text-center"><?php echo number_format($total_laki); ?></th>
                                            <th class="text-center"><?php echo number_format($total_perempuan); ?></th>
                                            <th class="text-center"><?php echo number_format($grand_total); ?></th>
                                            <th class="text-center"><?php echo $grand_total > 0 ? round(($total_laki / $grand_total) * 100, 1) : 0; ?>%</th>
                                            <th class="text-center"><?php echo $grand_total > 0 ? round(($total_perempuan / $grand_total) * 100, 1) : 0; ?>%</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie"></i>
                                Distribusi Berdasarkan Jenis Kelamin
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="genderChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-bar"></i>
                                Top 5 Faktor Perceraian
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="faktorChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Debug function
function debugCharts() {
    console.log('Chart.js version:', Chart.version);
    console.log('Gender chart element:', document.getElementById('genderChart'));
    console.log('Faktor chart element:', document.getElementById('faktorChart'));
    console.log('Data - Total Laki:', <?php echo $total_laki; ?>);
    console.log('Data - Total Perempuan:', <?php echo $total_perempuan; ?>);
}

// Tunggu sampai document ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, starting chart creation...');
    debugCharts();
    
    // Initialize DataTable jika belum ada
    if (typeof $ !== 'undefined' && typeof $.fn.DataTable !== 'undefined' && $('#dataTable').length) {
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
    }

    // Create Gender Distribution Chart dengan delay
    setTimeout(function() {
        const genderCanvas = document.getElementById('genderChart');
        if (genderCanvas) {
            console.log('Creating gender chart...');
            try {
                new Chart(genderCanvas, {
                    type: 'doughnut',
                    data: {
                        labels: ['Laki-laki', 'Perempuan'],
                        datasets: [{
                            data: [<?php echo $total_laki; ?>, <?php echo $total_perempuan; ?>],
                            backgroundColor: ['#007bff', '#ffc107'],
                            borderColor: ['#0056b3', '#e0a800'],
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
                });
                console.log('Gender chart created successfully');
            } catch (error) {
                console.error('Error creating gender chart:', error);
            }
        } else {
            console.error('Gender chart canvas not found');
        }
    }, 100);

    // Create Top Factors Chart dengan delay
    setTimeout(function() {
        const faktorCanvas = document.getElementById('faktorChart');
        if (faktorCanvas) {
            console.log('Creating faktor chart...');
            try {
                <?php 
                    $chart_labels = array();
                    $chart_data = array();
                    if(!empty($datafilter)):
                        $chart_count = 0;
                        foreach($datafilter as $row):
                            if($row->FaktorPerceraian != 'TOTAL' && $chart_count < 5):
                                $chart_labels[] = "'" . addslashes($row->FaktorPerceraian) . "'";
                                $chart_data[] = $row->Total;
                                $chart_count++;
                            endif;
                        endforeach;
                    endif;
                ?>
                
                console.log('Chart labels:', [<?php echo implode(',', $chart_labels); ?>]);
                console.log('Chart data:', [<?php echo implode(',', $chart_data); ?>]);
                
                new Chart(faktorCanvas, {
                    type: 'bar',
                    data: {
                        labels: [<?php echo implode(',', $chart_labels); ?>],
                        datasets: [{
                            label: 'Jumlah Kasus',
                            data: [<?php echo implode(',', $chart_data); ?>],
                            backgroundColor: '#28a745',
                            borderColor: '#1e7e34',
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
                                display: false
                            }
                        }
                    }
                });
                console.log('Faktor chart created successfully');
            } catch (error) {
                console.error('Error creating faktor chart:', error);
            }
        } else {
            console.error('Faktor chart canvas not found');
        }
    }, 200);
});

// Export Excel function
function exportExcel() {
    alert('Fitur export Excel sedang dalam pengembangan');
}

// Print function
function printReport() {
    window.print();
}
</script>

<!-- Print styles -->
<style>
/* Chart container styling */
.chart-container {
    position: relative;
    height: 400px;
    width: 100%;
    margin-bottom: 20px;
}

#genderChart, #faktorChart {
    max-width: 100% !important;
    max-height: 400px !important;
    width: 100% !important;
    height: 400px !important;
}

/* Responsive chart styling */
@media (max-width: 768px) {
    .chart-container {
        height: 300px;
    }
    
    #genderChart, #faktorChart {
        height: 300px !important;
    }
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
        font-size: 12px !important;
    }
    
    .small-box {
        display: none !important;
    }
    
    canvas {
        display: none !important;
    }
}

.table th {
    background-color: #007bff !important;
    color: white !important;
}

.bg-light th {
    background-color: #f8f9fa !important;
    color: #495057 !important;
}

.small-box {
    border-radius: 0.25rem;
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
    display: block;
    margin-bottom: 20px;
    position: relative;
}

.small-box > .inner {
    padding: 10px;
}

.small-box .icon {
    color: rgba(0,0,0,.15);
    z-index: 0;
}

.small-box .icon > i {
    font-size: 70px;
    position: absolute;
    right: 15px;
    top: 15px;
    transition: transform .3s linear;
}

.small-box:hover .icon > i {
    transform: scale(1.1);
}
</style>
