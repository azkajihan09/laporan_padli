<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1><i class="fas fa-gavel"></i> Laporan Putusan Perkara
                                <?php if (isset($selected_wilayah) && $selected_wilayah !== 'Semua'): ?>
                                    <span class="badge badge-info">
                                        <?php echo ($selected_wilayah === 'HSU') ? 'Hulu Sungai Utara' : $selected_wilayah; ?>
                                    </span>
                                <?php endif; ?>
                                <?php if (isset($selected_status) && $selected_status !== 'semua'): ?>
                                    <span class="badge badge-success">
                                        <?php echo ucwords(str_replace('_', ' ', $selected_status)); ?>
                                    </span>
                                <?php endif; ?>
                                <?php if (isset($selected_jenis_perkara) && $selected_jenis_perkara !== 'semua'): ?>
                                    <span class="badge badge-primary">
                                        <?php echo $selected_jenis_perkara; ?>
                                    </span>
                                <?php endif; ?>
                            </h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Laporan Putusan</li>
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
                                        <h3><?php echo isset($summary->total_putusan) ? number_format($summary->total_putusan) : 0; ?></h3>
                                        <p>Total Putusan</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-gavel"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-6">
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3><?php echo isset($summary->dikabulkan) ? number_format($summary->dikabulkan) : 0; ?></h3>
                                        <p>Dikabulkan</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-6">
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3><?php echo isset($summary->ditolak) ? number_format($summary->ditolak) : 0; ?></h3>
                                        <p>Ditolak</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-times-circle"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-6">
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        <h3><?php echo isset($summary->tidak_dapat_diterima) ? number_format($summary->tidak_dapat_diterima) : 0; ?></h3>
                                        <p>NO / Tidak Diterima</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-ban"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-6">
                                <div class="small-box bg-secondary">
                                    <div class="inner">
                                        <h3><?php echo isset($summary->dicabut) ? number_format($summary->dicabut) : 0; ?></h3>
                                        <p>Dicabut</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-undo"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-6">
                                <div class="small-box bg-dark">
                                    <div class="inner">
                                        <h3><?php echo isset($summary->digugurkan) ? number_format($summary->digugurkan) : 0; ?></h3>
                                        <p>Digugurkan</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-trash-alt"></i>
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
                                    <form action="<?php echo base_url() ?>index.php/Laporan_putusan" method="POST" id="filterForm">
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
                                                    <label>Status Putusan:</label>
                                                    <select name="status_putusan" class="form-control">
                                                        <option value="semua" <?php echo (isset($selected_status) && $selected_status === 'semua') ? 'selected' : ''; ?>>Semua Status</option>
                                                        <?php if (isset($status_putusan_list) && count($status_putusan_list) > 0): ?>
                                                            <?php foreach ($status_putusan_list as $item): ?>
                                                                <option value="<?php echo $item->id; ?>" <?php echo (isset($selected_status) && $selected_status == $item->id) ? 'selected' : ''; ?>>
                                                                    <?php echo $item->status_putusan_nama; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <!-- Fallback options jika data tidak tersedia -->
                                                            <option value="1" <?php echo (isset($selected_status) && $selected_status === '1') ? 'selected' : ''; ?>>Dikabulkan</option>
                                                            <option value="2" <?php echo (isset($selected_status) && $selected_status === '2') ? 'selected' : ''; ?>>Ditolak</option>
                                                            <option value="3" <?php echo (isset($selected_status) && $selected_status === '3') ? 'selected' : ''; ?>>NO / Tidak Dapat Diterima</option>
                                                            <option value="7" <?php echo (isset($selected_status) && $selected_status === '7') ? 'selected' : ''; ?>>Dicabut</option>
                                                            <option value="5" <?php echo (isset($selected_status) && $selected_status === '5') ? 'selected' : ''; ?>>Gugur</option>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Jenis Perkara:</label>
                                                    <select name="jenis_perkara" class="form-control">
                                                        <option value="semua" <?php echo (isset($selected_jenis_perkara) && $selected_jenis_perkara === 'semua') ? 'selected' : ''; ?>>Semua Jenis</option>
                                                        <?php if (isset($jenis_perkara_list) && count($jenis_perkara_list) > 0): ?>
                                                            <?php foreach ($jenis_perkara_list as $item): ?>
                                                                <option value="<?php echo $item->jenis_perkara_nama; ?>" <?php echo (isset($selected_jenis_perkara) && $selected_jenis_perkara === $item->jenis_perkara_nama) ? 'selected' : ''; ?>>
                                                                    <?php echo $item->jenis_perkara_nama; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
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
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
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
                                    <h3 class="card-title"><i class="fas fa-list"></i> Data Putusan Perkara</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover" id="example1">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nomor Perkara</th>
                                                    <th>Jenis Perkara</th>
                                                    <th>Pihak 1</th>
                                                    <th>Pihak 2</th>
                                                    <th>Tanggal Putusan</th>
                                                    <th>Status Putusan</th>
                                                    <th>Ringkasan Amar</th>
                                                    <th>Hari Sejak Putusan</th>
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
                                                                <span class="badge badge-primary">
                                                                    <?php echo $row->jenis_perkara_nama; ?>
                                                                </span>
                                                            </td>
                                                            <td><?php echo character_limiter($row->pihak1, 30); ?></td>
                                                            <td><?php echo character_limiter($row->pihak2, 30); ?></td>
                                                            <td><?php echo $row->tanggal_putusan; ?></td>
                                                            <td>
                                                                <?php
                                                                // Set badge berdasarkan status putusan
                                                                if ($row->status_putusan_nama == 'Dikabulkan' || $row->status_putusan_id == 1): ?>
                                                                    <span class="badge badge-success"><?php echo $row->status_putusan_nama; ?></span>
                                                                <?php elseif ($row->status_putusan_nama == 'Ditolak' || $row->status_putusan_id == 2): ?>
                                                                    <span class="badge badge-danger"><?php echo $row->status_putusan_nama; ?></span>
                                                                <?php elseif (in_array($row->status_putusan_id, [3, 4]) || strpos($row->status_putusan_nama, 'Tidak') !== false): ?>
                                                                    <span class="badge badge-warning"><?php echo $row->status_putusan_nama; ?></span>
                                                                <?php elseif ($row->status_putusan_nama == 'Dicabut' || $row->status_putusan_id == 7): ?>
                                                                    <span class="badge badge-info"><?php echo $row->status_putusan_nama; ?></span>
                                                                <?php elseif (in_array($row->status_putusan_id, [5, 6]) || strpos($row->status_putusan_nama, 'Gugur') !== false): ?>
                                                                    <span class="badge badge-dark"><?php echo $row->status_putusan_nama; ?></span>
                                                                <?php else: ?>
                                                                    <span class="badge badge-secondary"><?php echo $row->status_putusan_nama; ?></span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td><?php echo character_limiter($row->ringkasan_amar, 50); ?></td>
                                                            <td>
                                                                <?php
                                                                $hari = $row->hari_sejak_putusan;
                                                                if ($hari < 30): ?>
                                                                    <span class="badge badge-success"><?php echo $hari . ' hari'; ?></span>
                                                                <?php elseif ($hari < 90): ?>
                                                                    <span class="badge badge-warning"><?php echo $hari . ' hari'; ?></span>
                                                                <?php elseif ($hari < 180): ?>
                                                                    <span class="badge badge-danger"><?php echo $hari . ' hari'; ?></span>
                                                                <?php else: ?>
                                                                    <span class="badge badge-dark"><?php echo $hari . ' hari'; ?></span>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="9" class="text-center">
                                                            <div class="alert alert-info">
                                                                <i class="fas fa-info-circle"></i> Tidak ada data putusan perkara untuk periode ini
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
            form.action = '<?php echo base_url(); ?>index.php/Laporan_putusan/export_excel';
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
                        "targets": [1, 2]
                    },
                    {
                        "width": "15%",
                        "targets": [3, 4]
                    },
                    {
                        "width": "10%",
                        "targets": [5, 6, 8]
                    },
                    {
                        "width": "25%",
                        "targets": 7
                    }
                ],
                "order": [
                    [5, "desc"]
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
            font-weight: 600;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
        }

        .badge-success {
            background-color: #28a745 !important;
            color: white !important;
        }

        .badge-danger {
            background-color: #dc3545 !important;
            color: white !important;
        }

        .badge-warning {
            background-color: #ffc107 !important;
            color: #212529 !important;
        }

        .badge-info {
            background-color: #17a2b8 !important;
            color: white !important;
        }

        .badge-dark {
            background-color: #343a40 !important;
            color: white !important;
        }

        .badge-secondary {
            background-color: #6c757d !important;
            color: white !important;
        }

        .badge-primary {
            background-color: #007bff !important;
            color: white !important;
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

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        @media print {

            .filter-card,
            .btn,
            .breadcrumb,
            .card-header .card-tools {
                display: none !important;
            }
        }
    </style>

</body>

</html>
