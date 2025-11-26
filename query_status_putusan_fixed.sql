-- Query untuk menampilkan data lengkap dengan status putusan
-- Versi 1: Menampilkan semua data dengan status putusan
SELECT
    p.perkara_id,
    p.nomor_perkara,
    p.tanggal_pendaftaran,
    p.jenis_perkara_nama,
    p.pihak1_text AS penggugat,
    p.pihak2_text AS tergugat,
    pp.tanggal_putusan,
    sp.nama AS status_putusan,
    pp.status_putusan_nama,
    p.tahapan_terakhir_text,
    p.proses_terakhir_text
FROM
    perkara p
    LEFT JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
    LEFT JOIN status_putusan sp ON pp.status_putusan_id = sp.id
WHERE
    p.jenis_perkara_nama IS NOT NULL
ORDER BY p.tanggal_pendaftaran DESC;

-- Versi 2: Hanya perkara yang sudah ada putusannya
SELECT
    p.perkara_id,
    p.nomor_perkara,
    p.tanggal_pendaftaran,
    p.jenis_perkara_nama,
    p.pihak1_text AS penggugat,
    p.pihak2_text AS tergugat,
    pp.tanggal_putusan,
    sp.nama AS status_putusan,
    pp.status_putusan_nama,
    p.tahapan_terakhir_text,
    p.proses_terakhir_text
FROM
    perkara p
    INNER JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
    LEFT JOIN status_putusan sp ON pp.status_putusan_id = sp.id
WHERE
    p.jenis_perkara_nama IS NOT NULL
    AND pp.tanggal_putusan IS NOT NULL
ORDER BY pp.tanggal_putusan DESC;

-- Versi 3: Dengan filter tahun 2025
SELECT
    p.perkara_id,
    p.nomor_perkara,
    p.tanggal_pendaftaran,
    p.jenis_perkara_nama,
    p.pihak1_text AS penggugat,
    p.pihak2_text AS tergugat,
    pp.tanggal_putusan,
    sp.nama AS status_putusan,
    pp.status_putusan_nama,
    pp.status_putusan_id,
    p.tahapan_terakhir_text,
    p.proses_terakhir_text
FROM
    perkara p
    INNER JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
    LEFT JOIN status_putusan sp ON pp.status_putusan_id = sp.id
WHERE
    p.jenis_perkara_nama IS NOT NULL
    AND YEAR(pp.tanggal_putusan) = 2025
ORDER BY pp.tanggal_putusan DESC;

-- Versi 4: Cek data status_putusan yang tersedia
SELECT DISTINCT
    sp.id,
    sp.nama as status_putusan,
    COUNT(*) as jumlah_perkara
FROM
    status_putusan sp
    INNER JOIN perkara_putusan pp ON sp.id = pp.status_putusan_id
GROUP BY
    sp.id,
    sp.nama
ORDER BY sp.id;

-- Versi 5: Analisis masalah data
SELECT
    p.perkara_id,
    p.nomor_perkara,
    p.jenis_perkara_nama,
    pp.status_putusan_id,
    pp.status_putusan_nama,
    sp.nama as status_master,
    CASE
        WHEN pp.status_putusan_id IS NULL THEN 'Tidak ada status_putusan_id'
        WHEN sp.id IS NULL THEN 'Status ID tidak ditemukan di master'
        ELSE 'OK'
    END as status_check
FROM
    perkara p
    LEFT JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
    LEFT JOIN status_putusan sp ON pp.status_putusan_id = sp.id
WHERE
    p.jenis_perkara_nama IS NOT NULL
LIMIT 10;