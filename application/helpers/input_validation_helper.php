<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Input Validation Helper
 * 
 * Helper functions untuk validasi input form laporan perkara peradilan agama
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
        if ($tahun < $min_year || $tahun > $max_year) show_error("Tahun tidak valid. Harus antara {$min_year} - {$max_year}", 400);
        return $tahun;
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
    /**
     * CRITICAL FIX: Ensure $tahun variable is always defined at line 109
     */
    function validate_filter_form() {
        $CI =& get_instance();
        $filter_data = [];
        
        // ✅ FIX: Handle $tahun properly - checks multiple sources before any comparison
        if (isset($_POST['tahun'])) {
            $tahun = $_POST['tahun'];
        } elseif (isset($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } elseif (isset($_SESSION['filter_tahun'])) {
            $tahun = $_SESSION['filter_tahun'];
        } else {
            $tahun = date('Y'); // Default year
        }
        
        // Now $tahun is ALWAYS defined before use
        $filter_data['tahun'] = validasi_tahun($tahun);
        
        if (isset($_POST['wilayah']) && !empty($_POST['wilayah'])) {
            $wilayah = validasi_wilayah($_POST['wilayah']);
            if ($wilayah !== NULL) {
                $filter_data['wilayah_code'] = $wilayah['id'];
            }
        }
        
        return $filter_data;
    }
}

// Global constants
global $ALLOWED_WILAYAH, $JENIS_PERKARA;
$ALLOWED_WILAYAH = ['BAL', 'HSU', 'HST', 'HSS', 'BK', 'TBG', 'BMN', 'KBR', 'MHB'];
$JENIS_PERKARA = ['PERCERAIAN', 'GUGATAN', 'PERMOHANAN', 'BANDING', 'PIDANA', 'LAINNYA'];
