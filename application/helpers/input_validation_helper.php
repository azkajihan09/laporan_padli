<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Input Validation Helper - Lengkap untuk Laporan Pengadilan Agama
 */

if (!function_exists('validasi_tanggal')) {
    function validasi_tanggal($tanggal) {
        if (empty($tanggal)) return FALSE;
        $date = date_parse($tanggal);
        return !($date['error_count'] > 0 || $date['warning_count'] > 0);
    }
}

if (!function_exists('validasi_tahun')) {
    function validasi_tahun($tahun = NULL) {
        if ($tahun === NULL || $tahun === '') $tahun = date('Y');
        $tahun = intval($tahun);
        $min_year = 2000;
        $max_year = date('Y') + 1;
        if ($tahun < $min_year || $tahun > $max_year) show_error("Tahun tidak valid.", 400);
        return $tahun;
    }
}

if (!function_exists('validasi_bulan')) {
    /**
     * VALIDASI BULAN - Fix Error Undefined Function
     * @param string|int $bulan - Bulan (1-12 atau nama bulan)
     * @return array|null - Data bulan atau NULL jika invalid
     */
    function validasi_bulan($bulan = NULL) {
        $daftar_bulan = [
            1 => ['id' => '01', 'name' => 'Januari'],
            2 => ['id' => '02', 'name' => 'Februari'],
            3 => ['id' => '03', 'name' => 'Maret'],
            4 => ['id' => '04', 'name' => 'April'],
            5 => ['id' => '05', 'name' => 'Mei'],
            6 => ['id' => '06', 'name' => 'Juni'],
            7 => ['id' => '07', 'name' => 'Juli'],
            8 => ['id' => '08', 'name' => 'Agustus'],
            9 => ['id' => '09', 'name' => 'September'],
            10 => ['id' => '10', 'name' => 'Oktober'],
            11 => ['id' => '11', 'name' => 'November'],
            12 => ['id' => '12', 'name' => 'Desember'],
            'januari' => ['id' => '01', 'name' => 'Januari'],
            'februari' => ['id' => '02', 'name' => 'Februari'],
            'maret' => ['id' => '03', 'name' => 'Maret'],
            'april' => ['id' => '04', 'name' => 'April'],
            'mei' => ['id' => '05', 'name' => 'Mei'],
            'juni' => ['id' => '06', 'name' => 'Juni'],
            'juli' => ['id' => '07', 'name' => 'Juli'],
            'agustus' => ['id' => '08', 'name' => 'Agustus'],
            'september' => ['id' => '09', 'name' => 'September'],
            'oktober' => ['id' => '10', 'name' => 'Oktober'],
            'november' => ['id' => '11', 'name' => 'November'],
            'desember' => ['id' => '12', 'name' => 'Desember'],
        ];
        
        if (is_string($bulan)) {
            $bulan_upper = strtolower($bulan);
            if (isset($daftar_bulan[$bulan_upper])) {
                return $daftar_bulan[$bulan_upper];
            }
        } elseif (is_numeric($bulan)) {
            $bulan_int = intval($bulan);
            if ($bulan_int >= 1 && $bulan_int <= 12) {
                return $daftar_bulan[$bulan_int];
            }
        }
        
        return NULL;
    }
}

if (!function_exists('validasi_wilayah')) {
    function validasi_wilayah($wilayah) {
        $daftar_wilayah = [
            'BALANGAN' => ['id' => 'BAL', 'name' => 'Balangan'],
            'HSU' => ['id' => 'HSU', 'name' => 'Hulu Sungai Utara'],
            'HS TENGAH' => ['id' => 'HST', 'name' => 'Hulu Sungai Tengah'],
            'HS SELATAN' => ['id' => 'HSS', 'name' => 'Hulu Sungai Selatan'],
            'BARITO KUALA' => ['id' => 'BK', 'name' => 'Barito Kuala'],
            'TABALIONG' => ['id' => 'TBG', 'name' => 'Tabalong'],
            'KOTA BANJARMASIN' => ['id' => 'BMN', 'name' => 'Banjarbaru'],
            'KOTABARU' => ['id' => 'KBR', 'name' => 'Karang Intan'],
            'MARABAHAN' => ['id' => 'MHB', 'name' => 'Marabahan'],
        ];
        if (array_key_exists(strtoupper($wilayah), $daftar_wilayah)) return $daftar_wilayah[strtoupper($wilayah)];
        return NULL;
    }
}

if (!function_exists('validasi_perkara')) {
    function validasi_perkara($jenis_perkara) {
        if (empty($jenis_perkara)) return FALSE;
        $jenis_valid = ['PERCERAIAN', 'GUNGAN', 'PERMOHANAN', 'BANDING', 'PIDANA', 'LAINNYA'];
        return in_array(strtoupper($jenis_perkara), $jenis_valid);
    }
}

if (!function_exists('validate_filter_form')) {
    function validate_filter_form() {
        $CI =& get_instance();
        $filter_data = [];
        
        // FIX: Handle $tahun properly
        if (isset($_POST['tahun'])) {
            $tahun = $_POST['tahun'];
        } elseif (isset($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } elseif (isset($_SESSION['filter_tahun'])) {
            $tahun = $_SESSION['filter_tahun'];
        } else {
            $tahun = date('Y');
        }
        
        $filter_data['tahun'] = validasi_tahun($tahun);
        
        if (isset($_POST['bulan']) && !empty($_POST['bulan'])) {
            $bulan = validasi_bulan($_POST['bulan']);
            if ($bulan !== NULL) {
                $filter_data['bulan_id'] = $bulan['id'];
                $filter_data['bulan_name'] = $bulan['name'];
            }
        }
        
        if (isset($_POST['wilayah']) && !empty($_POST['wilayah'])) {
            $wilayah = validasi_wilayah($_POST['wilayah']);
            if ($wilayah !== NULL) {
                $filter_data['wilayah_code'] = $wilayah['id'];
                $filter_data['wilayah_name'] = $wilayah['name'];
            }
        }
        
        if (isset($_POST['jenis_perkara']) && !empty($_POST['jenis_perkara'])) {
            if (validasi_perkara($_POST['jenis_perkara'])) {
                $filter_data['jenis_perkara'] = strtoupper($_POST['jenis_perkara']);
            }
        }
        
        return $filter_data;
    }
}

// Global constants
global $ALLOWED_WILAYAH, $ALLOWED_BULAN, $JENIS_PERKARA;
$ALLOWED_WILAYAH = ['BAL', 'HSU', 'HST', 'HSS', 'BK', 'TBG', 'BMN', 'KBR', 'MHB'];
$ALLOWED_BULAN = range(1, 12);
$JENIS_PERKARA = ['PERCERAIAN', 'GUGATAN', 'PERMOHANAN', 'BANDING', 'PIDANA', 'LAINNYA'];
