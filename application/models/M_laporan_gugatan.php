<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_laporan_gugatan extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // Get monthly report data
    public function get_laporan_bulanan($bulan, $tahun, $format = 'lengkap')
    {
        $sql = "SELECT 
                    p.perkara_id,
                    p.nomor_perkara,
                    p.tanggal_pendaftaran,
                    p.jenis_perkara_nama,
                    p.pihak1_text as penggugat,
                    p.pihak2_text as tergugat,
                    pp.tanggal_putusan,
                    sp.nama as status_putusan,
                    pp.status_putusan_nama,
                    p.tahapan_terakhir_text,
                    p.proses_terakhir_text
                FROM perkara p
                LEFT JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
                LEFT JOIN status_putusan sp ON pp.status_putusan_id = sp.id
                WHERE MONTH(p.tanggal_pendaftaran) = ?
                AND YEAR(p.tanggal_pendaftaran) = ?
                AND p.jenis_perkara_nama LIKE '%Cerai Gugat%'";

        if ($format == 'ringkas') {
            $sql .= " AND pp.status_putusan_id IS NOT NULL";
        }

        $sql .= " ORDER BY p.tanggal_pendaftaran DESC, p.nomor_perkara";

        $result = $this->db->query($sql, array($bulan, $tahun));
        return $result->result();
    }

    // Get yearly report data
    public function get_laporan_tahunan($tahun, $format = 'lengkap')
    {
        $sql = "SELECT 
                    p.perkara_id,
                    p.nomor_perkara,
                    p.tanggal_pendaftaran,
                    p.jenis_perkara_nama,
                    p.pihak1_text as penggugat,
                    p.pihak2_text as tergugat,
                    pp.tanggal_putusan,
                    sp.nama as status_putusan,
                    pp.status_putusan_nama,
                    p.tahapan_terakhir_text,
                    p.proses_terakhir_text,
                    MONTH(p.tanggal_pendaftaran) as bulan
                FROM perkara p
                LEFT JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
                LEFT JOIN status_putusan sp ON pp.status_putusan_id = sp.id
                WHERE YEAR(p.tanggal_pendaftaran) = ?
                AND p.jenis_perkara_nama LIKE '%Cerai Gugat%'";

        if ($format == 'ringkas') {
            $sql .= " AND pp.status_putusan_id IS NOT NULL";
        }

        $sql .= " ORDER BY p.tanggal_pendaftaran DESC, p.nomor_perkara";

        $result = $this->db->query($sql, array($tahun));
        return $result->result();
    }

    // Get semester report data
    public function get_laporan_semester($semester, $tahun, $format = 'lengkap')
    {
        $start_month = ($semester == '1') ? 1 : 7;
        $end_month = ($semester == '1') ? 6 : 12;

        $sql = "SELECT 
                    p.perkara_id,
                    p.nomor_perkara,
                    p.tanggal_pendaftaran,
                    p.jenis_perkara_nama,
                    p.pihak1_text as penggugat,
                    p.pihak2_text as tergugat,
                    pp.tanggal_putusan,
                    sp.nama as status_putusan,
                    pp.status_putusan_nama,
                    p.tahapan_terakhir_text,
                    p.proses_terakhir_text,
                    MONTH(p.tanggal_pendaftaran) as bulan
                FROM perkara p
                LEFT JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
                LEFT JOIN status_putusan sp ON pp.status_putusan_id = sp.id
                WHERE YEAR(p.tanggal_pendaftaran) = ?
                AND MONTH(p.tanggal_pendaftaran) BETWEEN ? AND ?
                AND p.jenis_perkara_nama LIKE '%Cerai Gugat%'";

        if ($format == 'ringkas') {
            $sql .= " AND pp.status_putusan_id IS NOT NULL";
        }

        $sql .= " ORDER BY p.tanggal_pendaftaran DESC, p.nomor_perkara";

        $result = $this->db->query($sql, array($tahun, $start_month, $end_month));
        return $result->result();
    }

    // Get quarterly report data
    public function get_laporan_triwulan($triwulan, $tahun, $format = 'lengkap')
    {
        $start_month = (($triwulan - 1) * 3) + 1;
        $end_month = $triwulan * 3;

        $sql = "SELECT 
                    p.perkara_id,
                    p.nomor_perkara,
                    p.tanggal_pendaftaran,
                    p.jenis_perkara_nama,
                    p.pihak1_text as penggugat,
                    p.pihak2_text as tergugat,
                    pp.tanggal_putusan,
                    sp.nama as status_putusan,
                    pp.status_putusan_nama,
                    p.tahapan_terakhir_text,
                    p.proses_terakhir_text,
                    MONTH(p.tanggal_pendaftaran) as bulan
                FROM perkara p
                LEFT JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
                LEFT JOIN status_putusan sp ON pp.status_putusan_id = sp.id
                WHERE YEAR(p.tanggal_pendaftaran) = ?
                AND MONTH(p.tanggal_pendaftaran) BETWEEN ? AND ?
                AND p.jenis_perkara_nama LIKE '%Cerai Gugat%'";

        if ($format == 'ringkas') {
            $sql .= " AND pp.status_putusan_id IS NOT NULL";
        }

        $sql .= " ORDER BY p.tanggal_pendaftaran DESC, p.nomor_perkara";

        $result = $this->db->query($sql, array($tahun, $start_month, $end_month));
        return $result->result();
    }

    // Get custom date range report data
    public function get_laporan_custom($tanggal_mulai, $tanggal_akhir, $format = 'lengkap')
    {
        $sql = "SELECT 
                    p.perkara_id,
                    p.nomor_perkara,
                    p.tanggal_pendaftaran,
                    p.jenis_perkara_nama,
                    p.pihak1_text as penggugat,
                    p.pihak2_text as tergugat,
                    pp.tanggal_putusan,
                    sp.nama as status_putusan,
                    pp.status_putusan_nama,
                    p.tahapan_terakhir_text,
                    p.proses_terakhir_text
                FROM perkara p
                LEFT JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
                LEFT JOIN status_putusan sp ON pp.status_putusan_id = sp.id
                WHERE p.tanggal_pendaftaran BETWEEN ? AND ?
                AND p.jenis_perkara_nama LIKE '%Cerai Gugat%'";

        if ($format == 'ringkas') {
            $sql .= " AND pp.status_putusan_id IS NOT NULL";
        }

        $sql .= " ORDER BY p.tanggal_pendaftaran DESC, p.nomor_perkara";

        $result = $this->db->query($sql, array($tanggal_mulai, $tanggal_akhir));
        return $result->result();
    }

    // Get summary data for monthly report
    public function get_summary_bulanan($bulan, $tahun)
    {
        $sql = "SELECT 
                    COUNT(*) as total_perkara,
                    SUM(CASE WHEN pp.status_putusan_id = 1 THEN 1 ELSE 0 END) as dikabulkan,
                    SUM(CASE WHEN pp.status_putusan_id = 2 THEN 1 ELSE 0 END) as ditolak,
                    SUM(CASE WHEN pp.status_putusan_id = 7 THEN 1 ELSE 0 END) as dicabut,
                    COUNT(CASE WHEN pp.status_putusan_id IS NULL THEN 1 END) as belum_putusan,
                    ROUND(AVG(DATEDIFF(pp.tanggal_putusan, p.tanggal_pendaftaran)), 0) as rata_hari
                FROM perkara p
                LEFT JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
                WHERE MONTH(p.tanggal_pendaftaran) = ?
                AND YEAR(p.tanggal_pendaftaran) = ?
                AND p.jenis_perkara_nama LIKE '%Cerai Gugat%'";

        $result = $this->db->query($sql, array($bulan, $tahun));
        return $result->row();
    }

    // Get summary data for yearly report
    public function get_summary_tahunan($tahun)
    {
        $sql = "SELECT 
                    COUNT(*) as total_perkara,
                    SUM(CASE WHEN pp.status_putusan_id = 1 THEN 1 ELSE 0 END) as dikabulkan,
                    SUM(CASE WHEN pp.status_putusan_id = 2 THEN 1 ELSE 0 END) as ditolak,
                    SUM(CASE WHEN pp.status_putusan_id = 7 THEN 1 ELSE 0 END) as dicabut,
                    COUNT(CASE WHEN pp.status_putusan_id IS NULL THEN 1 END) as belum_putusan,
                    ROUND(AVG(DATEDIFF(pp.tanggal_putusan, p.tanggal_pendaftaran)), 0) as rata_hari
                FROM perkara p
                LEFT JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
                WHERE YEAR(p.tanggal_pendaftaran) = ?
                AND p.jenis_perkara_nama LIKE '%Cerai Gugat%'";

        $result = $this->db->query($sql, array($tahun));
        return $result->row();
    }

    // Get summary data for semester report
    public function get_summary_semester($semester, $tahun)
    {
        $start_month = ($semester == '1') ? 1 : 7;
        $end_month = ($semester == '1') ? 6 : 12;

        $sql = "SELECT 
                    COUNT(*) as total_perkara,
                    SUM(CASE WHEN pp.status_putusan_id = 1 THEN 1 ELSE 0 END) as dikabulkan,
                    SUM(CASE WHEN pp.status_putusan_id = 2 THEN 1 ELSE 0 END) as ditolak,
                    SUM(CASE WHEN pp.status_putusan_id = 7 THEN 1 ELSE 0 END) as dicabut,
                    COUNT(CASE WHEN pp.status_putusan_id IS NULL THEN 1 END) as belum_putusan,
                    ROUND(AVG(DATEDIFF(pp.tanggal_putusan, p.tanggal_pendaftaran)), 0) as rata_hari
                FROM perkara p
                LEFT JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
                WHERE YEAR(p.tanggal_pendaftaran) = ?
                AND MONTH(p.tanggal_pendaftaran) BETWEEN ? AND ?
                AND p.jenis_perkara_nama LIKE '%Cerai Gugat%'";

        $result = $this->db->query($sql, array($tahun, $start_month, $end_month));
        return $result->row();
    }

    // Get summary data for quarterly report
    public function get_summary_triwulan($triwulan, $tahun)
    {
        $start_month = (($triwulan - 1) * 3) + 1;
        $end_month = $triwulan * 3;

        $sql = "SELECT 
                    COUNT(*) as total_perkara,
                    SUM(CASE WHEN pp.status_putusan_id = 1 THEN 1 ELSE 0 END) as dikabulkan,
                    SUM(CASE WHEN pp.status_putusan_id = 2 THEN 1 ELSE 0 END) as ditolak,
                    SUM(CASE WHEN pp.status_putusan_id = 7 THEN 1 ELSE 0 END) as dicabut,
                    COUNT(CASE WHEN pp.status_putusan_id IS NULL THEN 1 END) as belum_putusan,
                    ROUND(AVG(DATEDIFF(pp.tanggal_putusan, p.tanggal_pendaftaran)), 0) as rata_hari
                FROM perkara p
                LEFT JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
                WHERE YEAR(p.tanggal_pendaftaran) = ?
                AND MONTH(p.tanggal_pendaftaran) BETWEEN ? AND ?
                AND p.jenis_perkara_nama LIKE '%Cerai Gugat%'";

        $result = $this->db->query($sql, array($tahun, $start_month, $end_month));
        return $result->row();
    }

    // Get summary data for custom date range
    public function get_summary_custom($tanggal_mulai, $tanggal_akhir)
    {
        $sql = "SELECT 
                    COUNT(*) as total_perkara,
                    SUM(CASE WHEN pp.status_putusan_id = 1 THEN 1 ELSE 0 END) as dikabulkan,
                    SUM(CASE WHEN pp.status_putusan_id = 2 THEN 1 ELSE 0 END) as ditolak,
                    SUM(CASE WHEN pp.status_putusan_id = 7 THEN 1 ELSE 0 END) as dicabut,
                    COUNT(CASE WHEN pp.status_putusan_id IS NULL THEN 1 END) as belum_putusan,
                    ROUND(AVG(DATEDIFF(pp.tanggal_putusan, p.tanggal_pendaftaran)), 0) as rata_hari
                FROM perkara p
                LEFT JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
                WHERE p.tanggal_pendaftaran BETWEEN ? AND ?
                AND p.jenis_perkara_nama LIKE '%Cerai Gugat%'";

        $result = $this->db->query($sql, array($tanggal_mulai, $tanggal_akhir));
        return $result->row();
    }

    // Helper methods for summary metrics
    public function get_total_perkara($bulan, $tahun, $jenis_laporan)
    {
        switch ($jenis_laporan) {
            case 'tahunan':
                $summary = $this->get_summary_tahunan($tahun);
                break;
            default:
                $summary = $this->get_summary_bulanan($bulan, $tahun);
                break;
        }
        return $summary ? $summary->total_perkara : 0;
    }

    public function get_total_dikabulkan($bulan, $tahun, $jenis_laporan)
    {
        switch ($jenis_laporan) {
            case 'tahunan':
                $summary = $this->get_summary_tahunan($tahun);
                break;
            default:
                $summary = $this->get_summary_bulanan($bulan, $tahun);
                break;
        }
        return $summary ? $summary->dikabulkan : 0;
    }

    public function get_total_ditolak($bulan, $tahun, $jenis_laporan)
    {
        switch ($jenis_laporan) {
            case 'tahunan':
                $summary = $this->get_summary_tahunan($tahun);
                break;
            default:
                $summary = $this->get_summary_bulanan($bulan, $tahun);
                break;
        }
        return $summary ? $summary->ditolak : 0;
    }

    public function get_total_dicabut($bulan, $tahun, $jenis_laporan)
    {
        switch ($jenis_laporan) {
            case 'tahunan':
                $summary = $this->get_summary_tahunan($tahun);
                break;
            default:
                $summary = $this->get_summary_bulanan($bulan, $tahun);
                break;
        }
        return $summary ? $summary->dicabut : 0;
    }

    // Export methods
    public function get_laporan_export($jenis_laporan, $bulan, $tahun)
    {
        switch ($jenis_laporan) {
            case 'tahunan':
                return $this->get_laporan_tahunan($tahun, 'lengkap');
            case 'semester':
                $semester = ($bulan <= 6) ? '1' : '2';
                return $this->get_laporan_semester($semester, $tahun, 'lengkap');
            case 'triwulan':
                $triwulan = ceil($bulan / 3);
                return $this->get_laporan_triwulan($triwulan, $tahun, 'lengkap');
            default:
                return $this->get_laporan_bulanan($bulan, $tahun, 'lengkap');
        }
    }

    public function get_laporan_pdf($jenis_laporan, $bulan, $tahun)
    {
        return $this->get_laporan_export($jenis_laporan, $bulan, $tahun);
    }

    public function get_laporan_print($jenis_laporan, $bulan, $tahun)
    {
        return $this->get_laporan_export($jenis_laporan, $bulan, $tahun);
    }
}
