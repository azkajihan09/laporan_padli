<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_statistik_gugatan extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // Get monthly trend data
    public function get_tren_bulanan($tahun, $wilayah = 'HSU')
    {
        $sql = "SELECT 
                    MONTH(p.tanggal_pendaftaran) as bulan,
                    MONTHNAME(p.tanggal_pendaftaran) as nama_bulan,
                    COUNT(*) as total_gugatan,
                    SUM(CASE WHEN pp.status_putusan_id = 1 THEN 1 ELSE 0 END) as dikabulkan,
                    SUM(CASE WHEN pp.status_putusan_id = 2 THEN 1 ELSE 0 END) as ditolak,
                    SUM(CASE WHEN pp.status_putusan_id = 7 THEN 1 ELSE 0 END) as dicabut
                FROM perkara p
                LEFT JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
                WHERE YEAR(p.tanggal_pendaftaran) = ?
                AND p.jenis_perkara_nama LIKE '%Cerai Gugat%'
                GROUP BY MONTH(p.tanggal_pendaftaran) 
                ORDER BY bulan";
        
        $result = $this->db->query($sql, array($tahun));
        return $result->result();
    }

    // Get comparison data between regions
    public function get_perbandingan_wilayah($tahun)
    {
        $sql = "SELECT 
                    'SEMUA' as wilayah,
                    COUNT(*) as total_gugatan,
                    SUM(CASE WHEN pp.status_putusan_id = 1 THEN 1 ELSE 0 END) as dikabulkan,
                    SUM(CASE WHEN pp.status_putusan_id = 2 THEN 1 ELSE 0 END) as ditolak,
                    SUM(CASE WHEN pp.status_putusan_id = 7 THEN 1 ELSE 0 END) as dicabut,
                    ROUND((SUM(CASE WHEN pp.status_putusan_id = 1 THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as persentase_berhasil
                FROM perkara p
                LEFT JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
                WHERE YEAR(p.tanggal_pendaftaran) = ?
                AND p.jenis_perkara_nama LIKE '%Cerai Gugat%'";

        $result = $this->db->query($sql, array($tahun));
        return $result->result();
    }

    // Get success rate data
    public function get_tingkat_keberhasilan($tahun, $wilayah = 'HSU')
    {
        $sql = "SELECT 
                    sp.nama as status_putusan,
                    COUNT(*) as jumlah,
                    ROUND((COUNT(*) / (SELECT COUNT(*) FROM perkara p2 
                                       LEFT JOIN perkara_putusan pp2 ON p2.perkara_id = pp2.perkara_id
                                       WHERE YEAR(p2.tanggal_pendaftaran) = ? 
                                       AND p2.jenis_perkara_nama LIKE '%Cerai Gugat%'
                )) * 100, 2) as persentase
                FROM perkara p
                LEFT JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
                LEFT JOIN status_putusan sp ON pp.status_putusan_id = sp.id
                WHERE YEAR(p.tanggal_pendaftaran) = ?
                AND p.jenis_perkara_nama LIKE '%Cerai Gugat%'
                AND pp.status_putusan_id IS NOT NULL
                GROUP BY pp.status_putusan_id, sp.nama
                ORDER BY jumlah DESC";

        $result = $this->db->query($sql, array($tahun, $tahun));
        return $result->result();
    }

    // Get processing time analysis
    public function get_waktu_penyelesaian($tahun, $wilayah = 'HSU')
    {
        $sql = "SELECT 
                    CASE 
                        WHEN DATEDIFF(pp.tanggal_putusan, p.tanggal_pendaftaran) <= 30 THEN '≤ 1 Bulan'
                        WHEN DATEDIFF(pp.tanggal_putusan, p.tanggal_pendaftaran) <= 60 THEN '1-2 Bulan'
                        WHEN DATEDIFF(pp.tanggal_putusan, p.tanggal_pendaftaran) <= 90 THEN '2-3 Bulan'
                        WHEN DATEDIFF(pp.tanggal_putusan, p.tanggal_pendaftaran) <= 120 THEN '3-4 Bulan'
                        ELSE '> 4 Bulan'
                    END as kategori_waktu,
                    COUNT(*) as jumlah,
                    ROUND(AVG(DATEDIFF(pp.tanggal_putusan, p.tanggal_pendaftaran)), 0) as rata_hari,
                    ROUND((COUNT(*) / (SELECT COUNT(*) FROM perkara p2 
                                       LEFT JOIN perkara_putusan pp2 ON p2.perkara_id = pp2.perkara_id
                                       WHERE YEAR(p2.tanggal_pendaftaran) = ? 
                                       AND p2.jenis_perkara_nama LIKE '%Cerai Gugat%'
                                       AND pp2.tanggal_putusan IS NOT NULL
        )) * 100, 2) as persentase
                FROM perkara p
                LEFT JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
                WHERE YEAR(p.tanggal_pendaftaran) = ?
                AND p.jenis_perkara_nama LIKE '%Cerai Gugat%'
                AND pp.tanggal_putusan IS NOT NULL
                GROUP BY kategori_waktu
                ORDER BY rata_hari";

        $result = $this->db->query($sql, array($tahun, $tahun));
        return $result->result();
    }

    // Get demographic analysis of plaintiffs
    public function get_demografis_penggugat($tahun, $wilayah = 'HSU')
    {
        $sql = "SELECT 
                    ph.jenis_kelamin,
                    CASE 
                        WHEN TIMESTAMPDIFF(YEAR, ph.tanggal_lahir, CURDATE()) < 25 THEN '< 25 tahun'
                        WHEN TIMESTAMPDIFF(YEAR, ph.tanggal_lahir, CURDATE()) BETWEEN 25 AND 35 THEN '25-35 tahun'
                        WHEN TIMESTAMPDIFF(YEAR, ph.tanggal_lahir, CURDATE()) BETWEEN 36 AND 45 THEN '36-45 tahun'
                        WHEN TIMESTAMPDIFF(YEAR, ph.tanggal_lahir, CURDATE()) BETWEEN 46 AND 55 THEN '46-55 tahun'
                        ELSE '> 55 tahun'
                    END as usia_kategori,
                    ph.pekerjaan,
                    COUNT(*) as jumlah
                FROM perkara p
                JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id
                JOIN pihak ph ON pp1.pihak_id = ph.id
                WHERE YEAR(p.tanggal_pendaftaran) = ?
                AND p.jenis_perkara_nama LIKE '%Cerai Gugat%'
                GROUP BY ph.jenis_kelamin, usia_kategori, ph.pekerjaan
                ORDER BY jumlah DESC";

        $result = $this->db->query($sql, array($tahun));
        return $result->result();
    }

    // Get yearly analysis
    public function get_analisis_tahunan($tahun_mulai, $tahun_akhir, $wilayah = 'HSU')
    {
        $sql = "SELECT 
                    YEAR(p.tanggal_pendaftaran) as tahun,
                    COUNT(*) as total_gugatan,
                    SUM(CASE WHEN pp.status_putusan_id = 1 THEN 1 ELSE 0 END) as dikabulkan,
                    SUM(CASE WHEN pp.status_putusan_id = 2 THEN 1 ELSE 0 END) as ditolak,
                    ROUND(AVG(DATEDIFF(pp.tanggal_putusan, p.tanggal_pendaftaran)), 0) as rata_waktu_hari,
                    ROUND((SUM(CASE WHEN pp.status_putusan_id = 1 THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as tingkat_keberhasilan
                FROM perkara p
                LEFT JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
                WHERE YEAR(p.tanggal_pendaftaran) BETWEEN ? AND ?
                AND p.jenis_perkara_nama LIKE '%Cerai Gugat%'
                GROUP BY YEAR(p.tanggal_pendaftaran)
                ORDER BY tahun";

        $result = $this->db->query($sql, array($tahun_mulai, $tahun_akhir));
        return $result->result();
    }

    // Get summary statistics
    public function get_summary_stats($bulan, $tahun, $wilayah = 'HSU')
    {
        $sql = "SELECT 
                    COUNT(*) as total_gugatan,
                    SUM(CASE WHEN pp.status_putusan_id = 1 THEN 1 ELSE 0 END) as total_dikabulkan,
                    SUM(CASE WHEN pp.status_putusan_id = 2 THEN 1 ELSE 0 END) as total_ditolak,
                    SUM(CASE WHEN pp.status_putusan_id = 7 THEN 1 ELSE 0 END) as total_dicabut,
                    ROUND(AVG(DATEDIFF(pp.tanggal_putusan, p.tanggal_pendaftaran)), 0) as rata_waktu_hari
                FROM perkara p
                LEFT JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
                WHERE MONTH(p.tanggal_pendaftaran) = ?
                AND YEAR(p.tanggal_pendaftaran) = ?
                AND p.jenis_perkara_nama LIKE '%Cerai Gugat%'";

        $result = $this->db->query($sql, array($bulan, $tahun));
        return $result->row();
    }

    // Helper methods for summary data
    public function get_total_gugatan($tahun, $wilayah = 'HSU')
    {
        $sql = "SELECT COUNT(*) as total
                FROM perkara p
                WHERE YEAR(p.tanggal_pendaftaran) = ?
                AND p.jenis_perkara_nama LIKE '%Cerai Gugat%'";

        $result = $this->db->query($sql, array($tahun));
        $row = $result->row();
        return $row ? $row->total : 0;
    }

    public function get_total_dikabulkan($tahun, $wilayah = 'HSU')
    {
        $sql = "SELECT COUNT(*) as total
                FROM perkara p
                LEFT JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
                WHERE YEAR(p.tanggal_pendaftaran) = ?
                AND p.jenis_perkara_nama LIKE '%Cerai Gugat%'
                AND pp.status_putusan_id = 1";

        $result = $this->db->query($sql, array($tahun));
        $row = $result->row();
        return $row ? $row->total : 0;
    }

    public function get_total_ditolak($tahun, $wilayah = 'HSU')
    {
        $sql = "SELECT COUNT(*) as total
                FROM perkara p
                LEFT JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
                WHERE YEAR(p.tanggal_pendaftaran) = ?
                AND p.jenis_perkara_nama LIKE '%Cerai Gugat%'
                AND pp.status_putusan_id = 2";

        $result = $this->db->query($sql, array($tahun));
        $row = $result->row();
        return $row ? $row->total : 0;
    }

    public function get_rata_waktu_penyelesaian($tahun, $wilayah = 'HSU')
    {
        $sql = "SELECT ROUND(AVG(DATEDIFF(pp.tanggal_putusan, p.tanggal_pendaftaran)), 0) as rata_hari
                FROM perkara p
                LEFT JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
                WHERE YEAR(p.tanggal_pendaftaran) = ?
                AND p.jenis_perkara_nama LIKE '%Cerai Gugat%'
                AND pp.tanggal_putusan IS NOT NULL";

        $result = $this->db->query($sql, array($tahun));
        $row = $result->row();
        return $row ? $row->rata_hari : 0;
    }

    // Additional summary methods
    public function get_summary_by_region($tahun)
    {
        return $this->get_perbandingan_wilayah($tahun);
    }

    public function get_keberhasilan_summary($tahun)
    {
        return $this->get_tingkat_keberhasilan($tahun);
    }

    public function get_waktu_summary($tahun)
    {
        return $this->get_waktu_penyelesaian($tahun);
    }

    public function get_demografis_summary($tahun)
    {
        return $this->get_demografis_penggugat($tahun);
    }

    public function get_tahunan_summary($tahun_mulai, $tahun_akhir)
    {
        return $this->get_analisis_tahunan($tahun_mulai, $tahun_akhir);
    }

    // Export data methods
    public function get_export_data($analisis_type, $tahun)
    {
        switch ($analisis_type) {
            case 'tren_bulanan':
                return $this->get_tren_bulanan($tahun);
            case 'tingkat_keberhasilan':
                return $this->get_tingkat_keberhasilan($tahun);
            case 'waktu_penyelesaian':
                return $this->get_waktu_penyelesaian($tahun);
            default:
                return $this->get_tren_bulanan($tahun);
        }
    }
}
