-- Query untuk test dropdown jenis perkara gugatan
-- Jalankan query ini di database untuk melihat data yang tersedia

-- 1. Cek semua jenis perkara yang tersedia
SELECT 'Semua Jenis Perkara:' AS info;

SELECT DISTINCT
    jenis_perkara_nama,
    COUNT(*) as jumlah_perkara
FROM perkara p
    JOIN perkara_putusan pp ON pp.perkara_id = p.perkara_id
WHERE
    p.jenis_perkara_nama IS NOT NULL
    AND p.jenis_perkara_nama != ''
GROUP BY
    jenis_perkara_nama
ORDER BY jenis_perkara_nama;

-- 2. Cek khusus jenis perkara gugatan (sesuai method baru dengan filter Pdt.Gt)
SELECT 'Jenis Perkara Gugatan Saja (Filter Pdt.Gt):' AS info;

SELECT DISTINCT
    p.jenis_perkara_nama,
    COUNT(*) as jumlah_perkara
FROM perkara p
    JOIN perkara_putusan pp ON pp.perkara_id = p.perkara_id
WHERE
    p.jenis_perkara_nama IS NOT NULL
    AND p.jenis_perkara_nama != ''
    AND (
        p.nomor_perkara LIKE '%Pdt.Gt%'
        OR p.jenis_perkara_nama LIKE '%Cerai Gugat%'
    )
GROUP BY
    p.jenis_perkara_nama
ORDER BY p.jenis_perkara_nama;

-- 2b. Cek contoh nomor perkara gugatan
SELECT 'Contoh Nomor Perkara Gugatan:' AS info;

SELECT p.nomor_perkara, p.jenis_perkara_nama
FROM perkara p
WHERE
    p.nomor_perkara LIKE '%Pdt.Gt%'
LIMIT 10;

-- 3. Test query lengkap untuk laporan putusan dengan status putusan
SELECT 'Test Query Laporan Putusan:' AS info;

SELECT
    p.nomor_perkara,
    p.jenis_perkara_nama,
    p.pihak1_text AS pihak1,
    p.pihak2_text AS pihak2,
    DATE_FORMAT(
        pp.tanggal_putusan,
        '%d-%m-%Y'
    ) AS tanggal_putusan,
    pp.status_putusan_id,
    COALESCE(
        sp.nama,
        pp.status_putusan_nama
    ) AS status_putusan_nama,
    LEFT(pp.amar_putusan, 100) AS ringkasan_amar_pendek
FROM
    perkara p
    INNER JOIN perkara_putusan pp ON pp.perkara_id = p.perkara_id
    LEFT JOIN status_putusan sp ON pp.status_putusan_id = sp.id
    LEFT JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id
WHERE
    p.jenis_perkara_nama IS NOT NULL
    AND pp.tanggal_putusan IS NOT NULL
    AND (
        p.nomor_perkara LIKE '%Pdt.Gt%'
        OR p.jenis_perkara_nama LIKE '%Cerai Gugat%'
    )
    AND YEAR(pp.tanggal_putusan) = YEAR(CURDATE())
    AND MONTH(pp.tanggal_putusan) = MONTH(CURDATE())
ORDER BY pp.tanggal_putusan DESC
LIMIT 10;

-- 4. Cek apakah ada data status putusan yang muncul
SELECT 'Status Putusan yang Tersedia:' AS info;

SELECT
    pp.status_putusan_id,
    pp.status_putusan_nama as status_dari_perkara_putusan,
    sp.nama as status_dari_tabel_status_putusan,
    COUNT(*) as jumlah_kasus
FROM
    perkara_putusan pp
    LEFT JOIN status_putusan sp ON pp.status_putusan_id = sp.id
WHERE
    pp.tanggal_putusan IS NOT NULL
GROUP BY
    pp.status_putusan_id,
    pp.status_putusan_nama,
    sp.nama
ORDER BY jumlah_kasus DESC;

-- 5. Debug query untuk bulan ini
SELECT 'Data Bulan Ini:' AS info;

SELECT COUNT(*) as total_putusan_bulan_ini
FROM perkara p
    INNER JOIN perkara_putusan pp ON pp.perkara_id = p.perkara_id
WHERE
    pp.tanggal_putusan IS NOT NULL
    AND YEAR(pp.tanggal_putusan) = YEAR(CURDATE())
    AND MONTH(pp.tanggal_putusan) = MONTH(CURDATE());