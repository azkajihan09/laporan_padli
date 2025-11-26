-- Query untuk test apakah data status putusan tersedia
-- Jalankan query ini di database untuk memastikan data ada

-- 1. Cek tabel status_putusan
SELECT 'Data di tabel status_putusan:' AS info;

SELECT id, nama, keterangan FROM status_putusan LIMIT 10;

-- 2. Cek data perkara_putusan dengan status_putusan_id
SELECT 'Data perkara_putusan dengan status_putusan_id:' AS info;

SELECT pp.perkara_id, pp.tanggal_putusan, pp.status_putusan_id, pp.status_putusan_nama
FROM perkara_putusan pp
WHERE
    pp.status_putusan_id IS NOT NULL
LIMIT 10;

-- 3. Test JOIN antara perkara_putusan dan status_putusan
SELECT 'Test JOIN perkara_putusan dengan status_putusan:' AS info;

SELECT
    pp.perkara_id,
    pp.tanggal_putusan,
    pp.status_putusan_id,
    pp.status_putusan_nama AS status_dari_perkara_putusan,
    sp.nama AS status_dari_tabel_status_putusan
FROM
    perkara_putusan pp
    LEFT JOIN status_putusan sp ON pp.status_putusan_id = sp.id
WHERE
    pp.tanggal_putusan IS NOT NULL
ORDER BY pp.tanggal_putusan DESC
LIMIT 10;

-- 4. Cek data tahun 2024 (sesuaikan tahun dengan kebutuhan)
SELECT 'Data putusan tahun 2024:' AS info;

SELECT
    p.nomor_perkara,
    DATE_FORMAT(
        pp.tanggal_putusan,
        '%d-%m-%Y'
    ) AS tanggal_putusan,
    pp.status_putusan_id,
    COALESCE(
        sp.nama,
        pp.status_putusan_nama
    ) AS status_putusan_nama
FROM
    perkara p
    INNER JOIN perkara_putusan pp ON pp.perkara_id = p.perkara_id
    LEFT JOIN status_putusan sp ON pp.status_putusan_id = sp.id
WHERE
    YEAR(pp.tanggal_putusan) = 2024
    AND pp.tanggal_putusan IS NOT NULL
ORDER BY pp.tanggal_putusan DESC
LIMIT 10;

-- 5. Cek apakah ada status_putusan_nama yang kosong
SELECT 'Cek data dengan status_putusan_nama kosong:' AS info;

SELECT COUNT(*) AS jumlah_status_kosong
FROM perkara_putusan pp
WHERE
    pp.tanggal_putusan IS NOT NULL
    AND (
        pp.status_putusan_nama IS NULL
        OR pp.status_putusan_nama = ''
    );

-- 6. Cek distribusi status putusan
SELECT 'Distribusi status putusan:' AS info;

SELECT COALESCE(
        sp.nama, pp.status_putusan_nama, 'Tidak Ada Status'
    ) AS status, COUNT(*) AS jumlah
FROM
    perkara_putusan pp
    LEFT JOIN status_putusan sp ON pp.status_putusan_id = sp.id
WHERE
    pp.tanggal_putusan IS NOT NULL
GROUP BY
    COALESCE(
        sp.nama,
        pp.status_putusan_nama
    )
ORDER BY jumlah DESC;