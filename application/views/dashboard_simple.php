<!-- Content Wrapper. Contains page content -->
<?php
date_default_timezone_set('Asia/Jakarta');
$currentMonthName = date('F');
$currentYear = date('Y');
$currentDate = date('d F Y');
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-tachometer-alt"></i> Dashboard Simple</h1>
                    <small class="text-muted">Sistem Laporan Perkara PA Amuntai - Tampilan Sederhana</small>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item active">Dashboard Simple</li>
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
            <div class="row">
                <!-- Total Perkara -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?php echo isset($statistics->total_perkara) ? number_format($statistics->total_perkara) : '0'; ?></h3>
                            <p>Total Perkara <?php echo $currentYear; ?></p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                
                <!-- E-Court -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?php echo isset($statistics->total_perkara_ecourt) ? number_format($statistics->total_perkara_ecourt) : '0'; ?></h3>
                            <p>Perkara E-Court</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-laptop"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                
                <!-- Putusan Hari Ini -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?php echo isset($daily_statistics->perkara_putus_hari_ini) ? $daily_statistics->perkara_putus_hari_ini : '0'; ?></h3>
                            <p>Putusan Hari Ini</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-gavel"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                
                <!-- Kinerja PN -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?php echo isset($kinerja_pn->kinerjaPN) ? number_format($kinerja_pn->kinerjaPN, 1) . '%' : '0%'; ?></h3>
                            <p>Kinerja PN</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->

            <!-- Info boxes -->
            <div class="row">
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-calendar-day"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Perkara Masuk Hari Ini</span>
                            <span class="info-box-number"><?php echo isset($daily_statistics->perkara_masuk_hari_ini) ? $daily_statistics->perkara_masuk_hari_ini : '0'; ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-edit"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Minutasi Hari Ini</span>
                            <span class="info-box-number"><?php echo isset($daily_statistics->perkara_minutasi_hari_ini) ? $daily_statistics->perkara_minutasi_hari_ini : '0'; ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Sisa Perkara</span>
                            <span class="info-box-number"><?php echo isset($kinerja_pn->sisa) ? $kinerja_pn->sisa : '0'; ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fas fa-laptop-code"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">E-Court Hari Ini</span>
                            <span class="info-box-number"><?php echo isset($daily_statistics->ecourt_hari_ini) ? $daily_statistics->ecourt_hari_ini : '0'; ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->

            <div class="row">
                <!-- Tren Perkara -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-line mr-1"></i>
                                Tren Perkara Tahunan
                            </h3>
                        </div>
                        <div class="card-body">
                            <canvas id="yearlyTrendChart" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Komposisi Jenis Perkara -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Komposisi Jenis Perkara
                            </h3>
                        </div>
                        <div class="card-body">
                            <canvas id="caseTypeChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->

            <div class="row">
                <!-- Klasifikasi Perkara Bulanan -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-bar mr-1"></i>
                                Klasifikasi Perkara Bulanan <?php echo $currentYear; ?>
                            </h3>
                        </div>
                        <div class="card-body">
                            <canvas id="monthlyClassificationChart" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->

            <!-- Progress Bars -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Progress Penyelesaian Perkara</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <span class="float-left">Perkara Putus</span>
                                <span class="float-right"><?php echo isset($kinerja_pn->putusan) ? $kinerja_pn->putusan : '0'; ?>/<?php echo isset($statistics->total_perkara) ? $statistics->total_perkara : '0'; ?></span>
                                <div class="progress mb-3">
                                    <div class="progress-bar bg-primary" role="progressbar" 
                                         style="width: <?php 
                                         $putus_persen = isset($kinerja_pn->putusan) && isset($statistics->total_perkara) && $statistics->total_perkara > 0 
                                             ? ($kinerja_pn->putusan / $statistics->total_perkara) * 100 
                                             : 0; 
                                         echo number_format($putus_persen, 1); 
                                         ?>%" 
                                         aria-valuenow="<?php echo number_format($putus_persen, 1); ?>" 
                                         aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <span class="float-left">Minutasi</span>
                                <span class="float-right"><?php echo isset($kinerja_pn->minutasi) ? $kinerja_pn->minutasi : '0'; ?>/<?php echo isset($statistics->total_perkara) ? $statistics->total_perkara : '0'; ?></span>
                                <div class="progress mb-3">
                                    <div class="progress-bar bg-success" role="progressbar" 
                                         style="width: <?php 
                                         $minutasi_persen = isset($kinerja_pn->minutasi) && isset($statistics->total_perkara) && $statistics->total_perkara > 0 
                                             ? ($kinerja_pn->minutasi / $statistics->total_perkara) * 100 
                                             : 0; 
                                         echo number_format($minutasi_persen, 1); 
                                         ?>%" 
                                         aria-valuenow="<?php echo number_format($minutasi_persen, 1); ?>" 
                                         aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <span class="float-left">E-Court</span>
                                <span class="float-right"><?php echo isset($statistics->persen_perkara_ecourt) ? number_format($statistics->persen_perkara_ecourt, 1) . '%' : '0%'; ?></span>
                                <div class="progress mb-3">
                                    <div class="progress-bar bg-warning" role="progressbar" 
                                         style="width: <?php echo isset($statistics->persen_perkara_ecourt) ? number_format($statistics->persen_perkara_ecourt, 1) : '0'; ?>%" 
                                         aria-valuenow="<?php echo isset($statistics->persen_perkara_ecourt) ? number_format($statistics->persen_perkara_ecourt, 1) : '0'; ?>" 
                                         aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Performance Ring -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Kinerja Pengadilan</h3>
                        </div>
                        <div class="card-body text-center">
                            <div style="position: relative; height: 200px;">
                                <canvas id="performanceChart" height="200"></canvas>
                            </div>
                            <div class="row mt-3">
                                <div class="col-6">
                                    <div class="description-block border-right">
                                        <span class="description-percentage text-success">
                                            <i class="fas fa-caret-up"></i> <?php echo isset($kinerja_pn->kinerjaPN) ? number_format($kinerja_pn->kinerjaPN, 1) . '%' : '0%'; ?>
                                        </span>
                                        <h5 class="description-header"><?php echo isset($kinerja_pn->masuk) ? number_format($kinerja_pn->masuk) : '0'; ?></h5>
                                        <span class="description-text">MASUK</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="description-block">
                                        <span class="description-percentage text-info">
                                            <i class="fas fa-caret-up"></i> <?php echo isset($kinerja_pn->minutasi) ? number_format($kinerja_pn->minutasi) : '0'; ?>
                                        </span>
                                        <h5 class="description-header"><?php echo isset($kinerja_pn->putusan) ? number_format($kinerja_pn->putusan) : '0'; ?></h5>
                                        <span class="description-text">SELESAI</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
$(document).ready(function() {
    
    // Chart data from PHP
    const yearlyGrowthData = [<?php 
        if (isset($yearly_growth) && is_array($yearly_growth) && count($yearly_growth) > 0) {
            echo implode(',', $yearly_growth);
        } else {
            echo '0,0,0,0,0,0';
        }
    ?>];
    const caseTypeData = {
        gugatan: <?php echo isset($case_types->gugatan) ? $case_types->gugatan : 0; ?>,
        permohonan: <?php echo isset($case_types->permohonan) ? $case_types->permohonan : 0; ?>
    };
    const monthlyClassificationData = <?php echo isset($monthly_classification) ? json_encode($monthly_classification) : 'null'; ?>;
    const kinerjaPN = <?php echo isset($kinerja_pn->kinerjaPN) ? $kinerja_pn->kinerjaPN : 72.5; ?>;
    
    // Debug data
    console.log('Statistics:', <?php echo json_encode(isset($statistics) ? $statistics : null); ?>);
    console.log('Daily Statistics:', <?php echo json_encode(isset($daily_statistics) ? $daily_statistics : null); ?>);
    console.log('Kinerja PN:', <?php echo json_encode(isset($kinerja_pn) ? $kinerja_pn : null); ?>);
    console.log('Case Types:', <?php echo json_encode(isset($case_types) ? $case_types : null); ?>);
    
    // Yearly Trend Chart
    const yearlyTrendCtx = document.getElementById('yearlyTrendChart').getContext('2d');
    new Chart(yearlyTrendCtx, {
        type: 'line',
        data: {
            labels: ['2020', '2021', '2022', '2023', '2024', '2025'],
            datasets: [{
                label: 'Total Perkara',
                data: yearlyGrowthData,
                backgroundColor: 'rgba(60,141,188,0.1)',
                borderColor: 'rgba(60,141,188,1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    
    // Case Type Chart
    const caseTypeCtx = document.getElementById('caseTypeChart').getContext('2d');
    new Chart(caseTypeCtx, {
        type: 'doughnut',
        data: {
            labels: ['Gugatan', 'Permohonan'],
            datasets: [{
                data: [caseTypeData.gugatan, caseTypeData.permohonan],
                backgroundColor: ['#f56954', '#00a65a'],
                borderWidth: 0
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
    
    // Monthly Classification Chart
    const monthlyClassificationCtx = document.getElementById('monthlyClassificationChart').getContext('2d');
    
    let monthlyData;
    if (monthlyClassificationData && monthlyClassificationData.datasets) {
        monthlyData = monthlyClassificationData;
    } else {
        // Fallback data
        monthlyData = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [
                {
                    label: 'Cerai Gugat',
                    data: [45, 48, 36, 39, 52, 47, 63, 57, 43, 45, 31, 0],
                    backgroundColor: '#f56954'
                },
                {
                    label: 'Istbat Nikah',
                    data: [7, 19, 1, 22, 24, 10, 46, 28, 42, 26, 9, 0],
                    backgroundColor: '#00a65a'
                },
                {
                    label: 'Cerai Talak',
                    data: [19, 6, 2, 8, 12, 4, 7, 12, 11, 9, 6, 0],
                    backgroundColor: '#3c8dbc'
                }
            ]
        };
    }
    
    new Chart(monthlyClassificationCtx, {
        type: 'bar',
        data: monthlyData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top'
                }
            },
            scales: {
                x: {
                    stacked: false
                },
                y: {
                    beginAtZero: true,
                    stacked: false
                }
            }
        }
    });
    
    // Performance Chart (Doughnut)
    const performanceCtx = document.getElementById('performanceChart').getContext('2d');
    new Chart(performanceCtx, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [kinerjaPN, 100 - kinerjaPN],
                backgroundColor: ['#00a65a', '#f0f0f0'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: false
                }
            }
        },
        plugins: [{
            id: 'centerText',
            beforeDatasetsDraw: function(chart) {
                const width = chart.width;
                const height = chart.height;
                const ctx = chart.ctx;
                
                ctx.restore();
                const fontSize = (height / 114).toFixed(2);
                ctx.font = fontSize + "em sans-serif";
                ctx.textBaseline = "middle";
                ctx.fillStyle = "#000";
                
                const text = kinerjaPN.toFixed(1) + "%";
                const textX = Math.round((width - ctx.measureText(text).width) / 2);
                const textY = height / 2;
                
                ctx.fillText(text, textX, textY);
                ctx.save();
            }
        }]
    });
    
});
</script>
