<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Input Validation Helper - COMPLETE untuk Laporan Pengadilan Agama
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
        if ($tahun === NULL || $tahun === '') {
            $tahun = date('Y');
        }
        
        $tahun = intval($tahun);
        $min_year = 2000;
        $max_year = date('Y') + 1;
        
        if ($tahun < $min_year || $tahun > $max_year) {
            show_error("Tahun tidak valid. Harus antara {$min_year} - {$max_year}", 400);
        }
        
        return $tahun;
    }
}

if (!function_exists('validasi_bulan')) {
    /**
     * ✅ FIX: validate_bulan() FUNCTION ADDED
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
            $bulan_lower = strtolower(trim($bulan));
            if (array_key_exists($bulan_lower, $daftar_bulan)) {
                return $daftar_bulan[$bulan_lower];
            }
        } elseif (is_numeric($bulan)) {
            $bulan_int = intval($bulan);
            if ($bulan_int >= 1 && $bulan_int <= 12 && array_key_exists($bulan_int, $daftar_bulan)) {
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
        
        $wilayah_upper = strtoupper(trim($wilayah));
        if (array_key_exists($wilayah_upper, $daftar_wilayah)) {
            return $daftar_wilayah[$wilayah_upper];
        }
        
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

if (!function_exists('validasi_status_putusan')) {
    function validasi_status_putusan($status) {
        $status_daftar = [
            'DENGAN' => ['code' => 'DGN', 'label' => 'Diberi Hak'],
            'TIDAK DENGAN' => ['code' => 'TDK DGN', 'label' => 'Tidak Diberi Hak'],
            'MEMBATAKAN' => ['code' => 'MBT', 'label' => 'Membatalkan'],
            'MENUNGGU' => ['code' => 'MTG', 'label' => 'Menunggu'],
            'SUDAH' => ['code' => 'SDH', 'label' => 'Sudah Eksekusi'],
            'BELUM' => ['code' => 'BLM', 'label' => 'Belum Eksekusi'],
        ];
        
        $status_upper = strtoupper(trim($status));
        foreach ($status_daftar as $key => $data) {
            if ($key === $status_upper || $data['code'] === $status_upper) {
                return $data;
            }
        }
        
        return FALSE;
    }
}

if (!function_exists('sanitize_input')) {
    function sanitize_input($input) {
        if (is_array($input)) {
            return array_map('sanitize_input', $input);
        }
        
        $CI =& get_instance();
        return $CI->security->clean($input);
    }
}

if (!function_exists('format_tanggalindo')) {
    function format_tanggalindo($tanggal, $full_name = TRUE) {
        if (empty($tanggal)) return '-';
        
        $date_obj = DateTime::createFromFormat('Y-m-d', $tanggal);
        if (!$date_obj) return $tanggal;
        
        $bulan = $full_name ? 'F' : 'M';
        return $date_obj->format('d ' . $bulan . ' Y');
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
        
        // FIX: Handle $bulan properly
        if (isset($_POST['bulan'])) {
            $bulan = $_POST['bulan'];
        } elseif (isset($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
        } elseif (isset($_SESSION['filter_bulan'])) {
            $bulan = $_SESSION['filter_bulan'];
        } else {
            $bulan = date('n');
        }
        
        $bulan_validated = validasi_bulan($bulan);
        if ($bulan_validated !== NULL) {
            $filter_data['bulan_id'] = $bulan_validated['id'];
            $filter_data['bulan_name'] = $bulan_validated['name'];
        }
        
        // Wilayah filter
        if (isset($_POST['wilayah']) && !empty($_POST['wilayah'])) {
            $wilayah = validasi_wilayah($_POST['wilayah']);
            if ($wilayah !== NULL) {
                $filter_data['wilayah_code'] = $wilayah['id'];
                $filter_data['wilayah_name'] = $wilayah['name'];
            }
        }
        
        // Jenis perkara filter
        if (isset($_POST['jenis_perkara']) && !empty($_POST['jenis_perkara'])) {
            if (validasi_perkara($_POST['jenis_perkara'])) {
                $filter_data['jenis_perkara'] = strtoupper($_POST['jenis_perkara']);
            }
        }
        
        return $filter_data;
    }
}

// Global constants
global $ALLOWED_WILAYAH, $ALLOWED_BULAN, $ALLOWED_JENIS_PERKARA;
$ALLOWED_WILAYAH = ['BAL', 'HSU', 'HST', 'HSS', 'BK', 'TBG', 'BMN', 'KBR', 'MHB'];
$ALLOWED_BULAN = range(1, 12);
$ALLOWED_JENIS_PERKARA = ['PERCERAIAN', 'GUNGAN', 'PERMOHANAN', 'BANDING', 'PIDANA', 'LAINNYA'];
