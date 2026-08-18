<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <div class="content-wrapper">

            <!-- Content Header -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">

                        <div class="col-sm-6">

                            <h1>
                                <i class="fas fa-file-alt"></i>
                                Laporan Perkara

                                <?php if (
                                    isset($selected_wilayah) &&
                                    $selected_wilayah !== 'Semua'
                                ): ?>

                                    <span class="badge badge-info">
                                        <?php
                                        echo ($selected_wilayah === 'HSU')
                                            ? 'Hulu Sungai Utara'
                                            : $selected_wilayah;
                                        ?>
                                    </span>

                                <?php endif; ?>


                                <?php if (
                                    isset($selected_jenis_perkara) &&
                                    $selected_jenis_perkara !== 'semua'
                                ): ?>

                                    <span class="badge badge-primary">
                                        <?php
                                        echo $selected_jenis_perkara;
                                        ?>
                                    </span>

                                <?php endif; ?>

                            </h1>

                        </div>


                        <div class="col-sm-6">

                            <ol class="breadcrumb float-sm-right">

                                <li class="breadcrumb-item">
                                    <a href="#">Home</a>
                                </li>

                                <li class="breadcrumb-item active">
                                    Laporan Perkara
                                </li>

                            </ol>

                        </div>

                    </div>
                </div>
            </section>


            <!-- ================================================= -->
            <!-- SUMMARY -->
            <!-- ================================================= -->

            <?php if (isset($summary)): ?>

                <section class="content">

                    <div class="container-fluid">

                        <div class="row">


                            <!-- TOTAL -->
                            <div class="col-lg-3 col-md-6 col-6">

                                <div class="small-box bg-info">

                                    <div class="inner">

                                        <h3>
                                            <?php
                                            echo isset($summary->total_perceraian)
                                                ? number_format($summary->total_perceraian)
                                                : 0;
                                            ?>
                                        </h3>

                                        <p>
                                            Total Perkara
                                        </p>

                                    </div>

                                    <div class="icon">
                                        <i class="fas fa-file-alt"></i>
                                    </div>

                                </div>

                            </div>


                            <!-- CERAI GUGAT -->
                            <div class="col-lg-3 col-md-6 col-6">

                                <div class="small-box bg-danger">

                                    <div class="inner">

                                        <h3>
                                            <?php
                                            echo isset($summary->cerai_gugat)
                                                ? number_format($summary->cerai_gugat)
                                                : 0;
                                            ?>
                                        </h3>

                                        <p>
                                            Cerai Gugat
                                        </p>

                                    </div>

                                    <div class="icon">
                                        <i class="fas fa-female"></i>
                                    </div>

                                </div>

                            </div>


                            <!-- CERAI TALAK -->
                            <div class="col-lg-3 col-md-6 col-6">

                                <div class="small-box bg-warning">

                                    <div class="inner">

                                        <h3>
                                            <?php
                                            echo isset($summary->cerai_talak)
                                                ? number_format($summary->cerai_talak)
                                                : 0;
                                            ?>
                                        </h3>

                                        <p>
                                            Cerai Talak
                                        </p>

                                    </div>

                                    <div class="icon">
                                        <i class="fas fa-male"></i>
                                    </div>

                                </div>

                            </div>


                            <!-- ISTBAT -->
                            <div class="col-lg-3 col-md-6 col-6">

                                <div class="small-box bg-success">

                                    <div class="inner">

                                        <h3>
                                            <?php
                                            echo isset($summary->pengesahan_perkawinan)
                                                ? number_format($summary->pengesahan_perkawinan)
                                                : 0;
                                            ?>
                                        </h3>

                                        <p>
                                            Pengesahan Perkawinan / Istbat Nikah
                                        </p>

                                    </div>

                                    <div class="icon">
                                        <i class="fas fa-ring"></i>
                                    </div>

                                </div>

                            </div>


                        </div>

                    </div>

                </section>

            <?php endif; ?>


            <!-- ================================================= -->
            <!-- FILTER -->
            <!-- ================================================= -->

            <section class="content">

                <div class="container-fluid">

                    <div class="row">

                        <div class="col-12">

                            <div class="card filter-card">

                                <div class="card-header">

                                    <h3 class="card-title">

                                        <i class="fas fa-filter"></i>

                                        Filter Laporan

                                    </h3>

                                </div>


                                <div class="card-body">

                                    <form
                                        action="<?php echo base_url(); ?>index.php/Laporan_perceraian"
                                        method="POST"
                                        id="filterForm"
                                    >

                                        <div class="row">


                                            <!-- WILAYAH -->
                                            <div class="col-md-2">

                                                <div class="form-group">

                                                    <label>
                                                        Wilayah:
                                                    </label>

                                                    <select
                                                        name="wilayah"
                                                        class="form-control"
                                                    >

                                                        <option
                                                            value="Semua"
                                                            <?php
                                                            echo (
                                                                isset($selected_wilayah) &&
                                                                $selected_wilayah === 'Semua'
                                                            )
                                                                ? 'selected'
                                                                : '';
                                                            ?>
                                                        >
                                                            Semua Wilayah
                                                        </option>


                                                        <option
                                                            value="HSU"
                                                            <?php
                                                            echo (
                                                                isset($selected_wilayah) &&
                                                                $selected_wilayah === 'HSU'
                                                            )
                                                                ? 'selected'
                                                                : '';
                                                            ?>
                                                        >
                                                            Hulu Sungai Utara
                                                        </option>


                                                        <option
                                                            value="Balangan"
                                                            <?php
                                                            echo (
                                                                isset($selected_wilayah) &&
                                                                $selected_wilayah === 'Balangan'
                                                            )
                                                                ? 'selected'
                                                                : '';
                                                            ?>
                                                        >
                                                            Balangan
                                                        </option>

                                                    </select>

                                                </div>

                                            </div>


                                            <!-- JENIS PERKARA -->
                                            <div class="col-md-3">

                                                <div class="form-group">

                                                    <label>
                                                        Jenis Perkara:
                                                    </label>

                                                    <select
                                                        name="jenis_perkara"
                                                        class="form-control"
                                                    >

                                                        <option
                                                            value="semua"
                                                            <?php
                                                            echo (
                                                                isset($selected_jenis_perkara) &&
                                                                $selected_jenis_perkara === 'semua'
                                                            )
                                                                ? 'selected'
                                                                : '';
                                                            ?>
                                                        >
                                                            Semua Jenis
                                                        </option>


                                                        <?php if (
                                                            isset($jenis_perkara_list) &&
                                                            count($jenis_perkara_list) > 0
                                                        ): ?>


                                                            <?php foreach (
                                                                $jenis_perkara_list
                                                                as $item
                                                            ): ?>

                                                                <option
                                                                    value="<?php echo htmlspecialchars(
                                                                        $item->jenis_perkara_nama,
                                                                        ENT_QUOTES,
                                                                        'UTF-8'
                                                                    ); ?>"
                                                                    <?php
                                                                    echo (
                                                                        isset($selected_jenis_perkara) &&
                                                                        $selected_jenis_perkara ===
                                                                        $item->jenis_perkara_nama
                                                                    )
                                                                        ? 'selected'
                                                                        : '';
                                                                    ?>
                                                                >

                                                                    <?php
                                                                    echo htmlspecialchars(
                                                                        $item->jenis_perkara_nama,
                                                                        ENT_QUOTES,
                                                                        'UTF-8'
                                                                    );
                                                                    ?>

                                                                </option>

                                                            <?php endforeach; ?>

                                                        <?php endif; ?>

                                                    </select>

                                                </div>

                                            </div>


                                            <!-- JENIS LAPORAN -->
                                            <div class="col-md-2">

                                                <div class="form-group">

                                                    <label>
                                                        Jenis Laporan:
                                                    </label>

                                                    <select
                                                        name="jenis_laporan"
                                                        class="form-control"
                                                        id="jenisLaporan"
                                                        onchange="toggleFilter()"
                                                    >

                                                        <option
                                                            value="bulanan"
                                                            <?php
                                                            echo (
                                                                isset($selected_jenis) &&
                                                                $selected_jenis === 'bulanan'
                                                            )
                                                                ? 'selected'
                                                                : '';
                                                            ?>
                                                        >
                                                            Bulanan
                                                        </option>


                                                        <option
                                                            value="tahunan"
                                                            <?php
                                                            echo (
                                                                isset($selected_jenis) &&
                                                                $selected_jenis === 'tahunan'
                                                            )
                                                                ? 'selected'
                                                                : '';
                                                            ?>
                                                        >
                                                            Tahunan
                                                        </option>


                                                        <option
                                                            value="custom"
                                                            <?php
                                                            echo (
                                                                isset($selected_jenis) &&
                                                                $selected_jenis === 'custom'
                                                            )
                                                                ? 'selected'
                                                                : '';
                                                            ?>
                                                        >
                                                            Custom Range
                                                        </option>

                                                    </select>

                                                </div>

                                            </div>


                                            <!-- BULAN -->
                                            <div
                                                class="col-md-2"
                                                id="filterBulan"
                                            >

                                                <div class="form-group">

                                                    <label>
                                                        Bulan:
                                                    </label>

                                                    <select
                                                        name="lap_bulan"
                                                        class="form-control"
                                                    >

                                                        <?php

                                                        $bulan = array(
                                                            '01' => 'Januari',
                                                            '02' => 'Februari',
                                                            '03' => 'Maret',
                                                            '04' => 'April',
                                                            '05' => 'Mei',
                                                            '06' => 'Juni',
                                                            '07' => 'Juli',
                                                            '08' => 'Agustus',
                                                            '09' => 'September',
                                                            '10' => 'Oktober',
                                                            '11' => 'November',
                                                            '12' => 'Desember'
                                                        );

                                                        foreach (
                                                            $bulan as $kode => $nama
                                                        ):
                                                        ?>

                                                            <option
                                                                value="<?php echo $kode; ?>"
                                                                <?php
                                                                echo (
                                                                    isset($selected_bulan) &&
                                                                    $selected_bulan === $kode
                                                                )
                                                                    ? 'selected'
                                                                    : '';
                                                                ?>
                                                            >
                                                                <?php echo $nama; ?>
                                                            </option>

                                                        <?php endforeach; ?>

                                                    </select>

                                                </div>

                                            </div>


                                            <!-- TAHUN -->
                                            <div
                                                class="col-md-2"
                                                id="filterTahun"
                                            >

                                                <div class="form-group">

                                                    <label>
                                                        Tahun:
                                                    </label>

                                                    <select
                                                        name="lap_tahun"
                                                        class="form-control"
                                                    >

                                                        <?php
                                                        for (
                                                            $year = 2016;
                                                            $year <= date('Y') + 1;
                                                            $year++
                                                        ):
                                                        ?>

                                                            <option
                                                                value="<?php echo $year; ?>"
                                                                <?php
                                                                echo (
                                                                    isset($selected_tahun) &&
                                                                    $selected_tahun == $year
                                                                )
                                                                    ? 'selected'
                                                                    : '';
                                                                ?>
                                                            >
                                                                <?php echo $year; ?>
                                                            </option>

                                                        <?php endfor; ?>

                                                    </select>

                                                </div>

                                            </div>


                                            <!-- TANGGAL MULAI -->
                                            <div
                                                class="col-md-2"
                                                id="filterTanggalMulai"
                                                style="display:none;"
                                            >

                                                <div class="form-group">

                                                    <label>
                                                        Tanggal Mulai:
                                                    </label>

                                                    <input
                                                        type="date"
                                                        name="tanggal_mulai"
                                                        class="form-control"
                                                        value="<?php
                                                        echo isset($selected_tanggal_mulai)
                                                            ? $selected_tanggal_mulai
                                                            : (
                                                                $this->input->post('tanggal_mulai')
                                                                ?: date('Y-m-01')
                                                            );
                                                        ?>"
                                                    >

                                                </div>

                                            </div>


                                            <!-- TANGGAL AKHIR -->
                                            <div
                                                class="col-md-2"
                                                id="filterTanggalAkhir"
                                                style="display:none;"
                                            >

                                                <div class="form-group">

                                                    <label>
                                                        Tanggal Akhir:
                                                    </label>

                                                    <input
                                                        type="date"
                                                        name="tanggal_akhir"
                                                        class="form-control"
                                                        value="<?php
                                                        echo isset($selected_tanggal_akhir)
                                                            ? $selected_tanggal_akhir
                                                            : (
                                                                $this->input->post('tanggal_akhir')
                                                                ?: date('Y-m-t')
                                                            );
                                                        ?>"
                                                    >

                                                </div>

                                            </div>

                                        </div>


                                        <!-- BUTTON -->
                                        <div class="row">

                                            <div class="col-md-12">

                                                <div class="form-group">

                                                    <button
                                                        type="submit"
                                                        class="btn btn-primary"
                                                    >
                                                        <i class="fas fa-search"></i>
                                                        Tampilkan
                                                    </button>


                                                    <button
                                                        type="button"
                                                        class="btn btn-success"
                                                        onclick="exportExcel()"
                                                    >
                                                        <i class="fas fa-file-excel"></i>
                                                        Export Excel
                                                    </button>


                                                    <button
                                                        type="button"
                                                        class="btn btn-info"
                                                        onclick="printReport()"
                                                    >
                                                        <i class="fas fa-print"></i>
                                                        Print
                                                    </button>

                                                </div>

                                            </div>

                                        </div>

                                    </form>

                                </div>

                            </div>


                            <!-- ================================================= -->
                            <!-- DATA TABLE -->
                            <!-- ================================================= -->

                            <div class="card">

                                <div class="card-header">

                                    <h3 class="card-title">

                                        <i class="fas fa-list"></i>

                                        Data Perkara

                                    </h3>

                                </div>


                                <div class="card-body">

                                    <div class="table-responsive">

                                        <table
                                            class="table table-bordered table-striped table-hover"
                                            id="example1"
                                        >

                                            <thead>

                                                <tr>

                                                    <th>No</th>

                                                    <th>
                                                        Nomor Perkara
                                                    </th>

                                                    <th>
                                                        Jenis Perkara
                                                    </th>

                                                    <th>
                                                        Nama Pihak 1
                                                    </th>

                                                    <th>
                                                        NIK Pihak 1
                                                    </th>

                                                    <th>
                                                        Pekerjaan Pihak 1
                                                    </th>

                                                    <th>
                                                        Nama Pihak 2
                                                    </th>

                                                    <th>
                                                        NIK Pihak 2
                                                    </th>

                                                    <th>
                                                        Pekerjaan Pihak 2
                                                    </th>

                                                    <th>
                                                        Tgl Putusan
                                                    </th>

                                                    <th>
                                                        Tgl BHT
                                                    </th>

                                                    <th>
                                                        Status Putusan
                                                    </th>

                                                    <th>
                                                        No. Akta Cerai
                                                    </th>

                                                    <th>
                                                        No. Seri Akta Cerai
                                                    </th>

                                                    <th>
                                                        Tgl Akta Cerai
                                                    </th>

                                                    <th>
                                                        Tgl Laporan
                                                    </th>

                                                </tr>

                                            </thead>


                                            <tbody>

                                                <?php if (
                                                    isset($datafilter) &&
                                                    count($datafilter) > 0
                                                ): ?>


                                                    <?php
                                                    $no = 1;

                                                    foreach (
                                                        $datafilter
                                                        as $row
                                                    ):
                                                    ?>

                                                        <tr>


                                                            <!-- NO -->
                                                            <td>
                                                                <?php
                                                                echo $no++;
                                                                ?>
                                                            </td>


                                                            <!-- NOMOR PERKARA -->
                                                            <td>
                                                                <strong>
                                                                    <?php
                                                                    echo htmlspecialchars(
                                                                        $row->nomor_perkara
                                                                    );
                                                                    ?>
                                                                </strong>
                                                            </td>


                                                            <!-- JENIS -->
                                                            <td>

                                                                <?php

                                                                $jenis =
                                                                    $row->jenis_perkara_nama;

                                                                if (
                                                                    strpos(
                                                                        $jenis,
                                                                        'Cerai Gugat'
                                                                    ) !== false
                                                                ):

                                                                ?>

                                                                    <span class="badge badge-danger">

                                                                        <?php
                                                                        echo htmlspecialchars(
                                                                            $jenis
                                                                        );
                                                                        ?>

                                                                    </span>


                                                                <?php
                                                                elseif (
                                                                    strpos(
                                                                        $jenis,
                                                                        'Cerai Talak'
                                                                    ) !== false
                                                                ):

                                                                ?>

                                                                    <span class="badge badge-warning">

                                                                        <?php
                                                                        echo htmlspecialchars(
                                                                            $jenis
                                                                        );
                                                                        ?>

                                                                    </span>


                                                                <?php
                                                                elseif (
                                                                    stripos(
                                                                        $jenis,
                                                                        'Pengesahan Perkawinan'
                                                                    ) !== false
                                                                    ||
                                                                    stripos(
                                                                        $jenis,
                                                                        'Istbat Nikah'
                                                                    ) !== false
                                                                    ||
                                                                    stripos(
                                                                        $jenis,
                                                                        'Itsbat Nikah'
                                                                    ) !== false
                                                                ):

                                                                ?>

                                                                    <span class="badge badge-success">

                                                                        <?php
                                                                        echo htmlspecialchars(
                                                                            $jenis
                                                                        );
                                                                        ?>

                                                                    </span>


                                                                <?php else: ?>

                                                                    <span class="badge badge-primary">

                                                                        <?php
                                                                        echo htmlspecialchars(
                                                                            $jenis
                                                                        );
                                                                        ?>

                                                                    </span>

                                                                <?php endif; ?>

                                                            </td>


                                                            <!-- PIHAK 1 -->
                                                            <td>
                                                                <?php
                                                                echo htmlspecialchars(
                                                                    $row->nama_pihak_1
                                                                );
                                                                ?>
                                                            </td>


                                                            <!-- NIK 1 -->
                                                            <td>
                                                                <?php
                                                                echo htmlspecialchars(
                                                                    $row->nik_pihak_1
                                                                );
                                                                ?>
                                                            </td>


                                                            <!-- PEKERJAAN 1 -->
                                                            <td>
                                                                <?php
                                                                echo htmlspecialchars(
                                                                    $row->pekerjaan_pihak_1
                                                                );
                                                                ?>
                                                            </td>


                                                            <!-- PIHAK 2 -->
                                                            <td>
                                                                <?php
                                                                echo htmlspecialchars(
                                                                    $row->nama_pihak_2
                                                                );
                                                                ?>
                                                            </td>


                                                            <!-- NIK 2 -->
                                                            <td>
                                                                <?php
                                                                echo htmlspecialchars(
                                                                    $row->nik_pihak_2
                                                                );
                                                                ?>
                                                            </td>


                                                            <!-- PEKERJAAN 2 -->
                                                            <td>
                                                                <?php
                                                                echo htmlspecialchars(
                                                                    $row->pekerjaan_pihak_2
                                                                );
                                                                ?>
                                                            </td>


                                                            <!-- PUTUSAN -->
                                                            <td>
                                                                <?php
                                                                echo $row->tanggal_putusan;
                                                                ?>
                                                            </td>


                                                            <!-- BHT -->
                                                            <td>
                                                                <?php
                                                                echo $row->tanggal_bht;
                                                                ?>
                                                            </td>


                                                            <!-- STATUS -->
                                                            <td>

                                                                <?php if (
                                                                    !empty(
                                                                        $row->status_putusan
                                                                    )
                                                                ): ?>

                                                                    <span class="badge badge-success">

                                                                        <?php
                                                                        echo htmlspecialchars(
                                                                            $row->status_putusan
                                                                        );
                                                                        ?>

                                                                    </span>

                                                                <?php endif; ?>

                                                            </td>


                                                            <!-- AKTA CERAI -->
                                                            <td>

                                                                <?php if (
                                                                    !empty(
                                                                        $row->nomor_akta_cerai
                                                                    )
                                                                ): ?>

                                                                    <strong>
                                                                        <?php
                                                                        echo htmlspecialchars(
                                                                            $row->nomor_akta_cerai
                                                                        );
                                                                        ?>
                                                                    </strong>

                                                                <?php else: ?>

                                                                    -

                                                                <?php endif; ?>

                                                            </td>


                                                            <!-- SERI AKTA -->
                                                            <td>

                                                                <?php
                                                                echo !empty(
                                                                    $row->no_seri_akta_cerai
                                                                )
                                                                    ? htmlspecialchars(
                                                                        $row->no_seri_akta_cerai
                                                                    )
                                                                    : '-';
                                                                ?>

                                                            </td>


                                                            <!-- TGL AKTA -->
                                                            <td>

                                                                <?php
                                                                echo !empty(
                                                                    $row->tgl_akta_cerai
                                                                )
                                                                    ? $row->tgl_akta_cerai
                                                                    : '-';
                                                                ?>

                                                            </td>


                                                            <!-- TGL LAPORAN -->
                                                            <td>

                                                                <?php

                                                                if (
                                                                    !empty(
                                                                        $row->tanggal_laporan
                                                                    )
                                                                ):

                                                                    echo date(
                                                                        'd-m-Y',
                                                                        strtotime(
                                                                            $row->tanggal_laporan
                                                                        )
                                                                    );

                                                                else:

                                                                    echo '-';

                                                                endif;

                                                                ?>

                                                            </td>

                                                        </tr>

                                                    <?php endforeach; ?>


                                                <?php else: ?>

                                                    <tr>

                                                        <td
                                                            colspan="16"
                                                            class="text-center"
                                                        >

                                                            <div class="alert alert-info">

                                                                <i class="fas fa-info-circle"></i>

                                                                Tidak ada data perkara
                                                                untuk periode ini.

                                                            </div>

                                                        </td>

                                                    </tr>

                                                <?php endif; ?>

                                            </tbody>

                                        </table>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </section>

        </div>

    </div>


    <!-- ========================================================= -->
    <!-- JAVASCRIPT -->
    <!-- ========================================================= -->

    <script>

        function toggleFilter() {

            const jenisLaporan =
                document.getElementById('jenisLaporan').value;

            const filterBulan =
                document.getElementById('filterBulan');

            const filterTahun =
                document.getElementById('filterTahun');

            const filterTanggalMulai =
                document.getElementById('filterTanggalMulai');

            const filterTanggalAkhir =
                document.getElementById('filterTanggalAkhir');


            if (jenisLaporan === 'bulanan') {

                filterBulan.style.display = 'block';

                filterTahun.style.display = 'block';

                filterTanggalMulai.style.display = 'none';

                filterTanggalAkhir.style.display = 'none';

            }


            else if (jenisLaporan === 'tahunan') {

                filterBulan.style.display = 'none';

                filterTahun.style.display = 'block';

                filterTanggalMulai.style.display = 'none';

                filterTanggalAkhir.style.display = 'none';

            }


            else if (jenisLaporan === 'custom') {

                filterBulan.style.display = 'none';

                filterTahun.style.display = 'none';

                filterTanggalMulai.style.display = 'block';

                filterTanggalAkhir.style.display = 'block';

            }

        }


        function exportExcel() {

            const form =
                document.getElementById('filterForm');

            const originalAction =
                form.action;

            form.action =
                '<?php echo base_url(); ?>index.php/Laporan_perceraian/export_excel';

            form.submit();

            form.action =
                originalAction;

        }


        function printReport() {

            window.print();

        }


        $(document).ready(function() {

            toggleFilter();


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
                    "url":
                        "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
                },

                "order": [
                    [15, "desc"]
                ],

                "dom": 'Bfrtip',

                "buttons": [

                    {
                        extend: 'copy',
                        text:
                            '<i class="fas fa-copy"></i> Copy',
                        className:
                            'btn btn-default'
                    },

                    {
                        extend: 'csv',
                        text:
                            '<i class="fas fa-file-csv"></i> CSV',
                        className:
                            'btn btn-default'
                    },

                    {
                        extend: 'print',
                        text:
                            '<i class="fas fa-print"></i> Print',
                        className:
                            'btn btn-default'
                    }

                ]

            });

        });

    </script>


    <!-- ========================================================= -->
    <!-- STYLE -->
    <!-- ========================================================= -->

    <style>

        .form-group label {
            font-weight: 600;
            color: #495057;
        }


        .small-box {
            border-radius: 10px;
            box-shadow:
                0 2px 4px rgba(0, 0, 0, 0.1);

            transition:
                transform 0.2s ease-in-out;
        }


        .small-box:hover {
            transform:
                translateY(-2px);
        }


        .small-box .inner h3 {
            font-weight: bold;
        }


        .badge {
            font-size: 0.8rem;
            font-weight: 600;
            padding:
                0.375rem 0.75rem;

            border-radius:
                0.375rem;
        }


        .table th {
            background-color:
                #007bff !important;

            color:
                white !important;
        }


        .card-header {
            background:
                linear-gradient(
                    45deg,
                    #dc3545,
                    #c82333
                );

            color:
                white;
        }


        .btn {
            border-radius:
                5px;
        }


        .filter-card {
            box-shadow:
                0 2px 10px rgba(0, 0, 0, 0.1);
        }


        .filter-card .card-header {
            background:
                linear-gradient(
                    45deg,
                    #007bff,
                    #0056b3
                );
        }


        .table tbody tr:hover {
            background-color:
                #f8f9fa;
        }


        @media print {

            .filter-card,
            .btn,
            .breadcrumb,
            .card-header .card-tools {
                display:
                    none !important;
            }

        }

    </style>


</body>

</html>
