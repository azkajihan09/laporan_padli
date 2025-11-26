-- Query Test untuk Filter Perkara Gugatan menggunakan Pdt.Gt
-- Jalankan query ini untuk memverifikasi filter yang benar

-- 1. Cek format nomor perkara di database
SELECT 'Format Nomor Perkara yang Ada:' AS info;

SELECT DISTINCT
    SUBSTRING_INDEX(
        SUBSTRING_INDEX(nomor_perkara, '/', 1),
        '/',
        -1
    ) AS format_nomor,
    COUNT(*) as jumlah
FROM perkara
WHERE
    nomor_perkara IS NOT NULL
    AND nomor_perkara != ''
GROUP BY
    format_nomor
ORDER BY jumlah DESC
LIMIT 20;

-- 2. Cek khusus perkara dengan format Pdt.Gt
SELECT 'Perkara dengan Format Pdt.Gt:' AS info;

SELECT p.nomor_perkara, p.jenis_perkara_nama, p.tanggal_pendaftaran
FROM perkara p
WHERE
    p.nomor_perkara LIKE '%Pdt.Gt%'
ORDER BY p.tanggal_pendaftaran DESC
LIMIT 10;

-- 3. Cek perkara dengan format lain yang mungkin gugatan
SELECT 'Perkara Gugatan Format Lain:' AS info;

SELECT p.nomor_perkara, p.jenis_perkara_nama, COUNT(*) as jumlah
FROM perkara p
WHERE (
        p.nomor_perkara LIKE '%Pdt.G%'
        OR p.nomor_perkara LIKE '%PDT.G%'
        OR p.nomor_perkara LIKE '%/Pdt.G/%'
        OR p.jenis_perkara_nama LIKE '%Cerai Gugat%'
        OR p.jenis_perkara_nama LIKE '%Gugat%'
    )
    AND p.nomor_perkara NOT LIKE '%Pdt.Gt%' -- Exclude yang sudah dicek
GROUP BY
    p.nomor_perkara,
    p.jenis_perkara_nama
LIMIT 15;

-- 4. Filter yang lebih komprehensif untuk perkara gugatan
SELECT 'Filter Komprehensif Perkara Gugatan:' AS info;

SELECT DISTINCT
    p.jenis_perkara_nama,
    COUNT(*) as jumlah
FROM perkara p
WHERE (
        p.nomor_perkara LIKE '%Pdt.Gt%'
        OR p.nomor_perkara LIKE '%Pdt.G/%'
        OR p.nomor_perkara LIKE '%PDT.G%'
        OR p.jenis_perkara_nama LIKE '%Cerai Gugat%'
        OR p.jenis_perkara_nama = 'Cerai Gugat'
    )
GROUP BY
    p.jenis_perkara_nama
ORDER BY jumlah DESC;

-- 5. Test dengan JOIN ke perkara_putusan untuk dropdown
SELECT 'Test untuk Dropdown Jenis Perkara Gugatan:' AS info;

SELECT DISTINCT
    p.jenis_perkara_nama,
    COUNT(*) as jumlah_dengan_putusan
FROM perkara p
    JOIN perkara_putusan pp ON pp.perkara_id = p.perkara_id
WHERE
    p.jenis_perkara_nama IS NOT NULL
    AND p.jenis_perkara_nama != ''
    AND (
        p.nomor_perkara LIKE '%Pdt.Gt%'
        OR p.nomor_perkara LIKE '%Pdt.G/%'
        OR p.nomor_perkara LIKE '%PDT.G%'
        OR p.jenis_perkara_nama LIKE '%Cerai Gugat%'
    )
GROUP BY
    p.jenis_perkara_nama
ORDER BY p.jenis_perkara_nama;

-- 6. Statistik format nomor perkara gugatan
SELECT 'Statistik Format Nomor Perkara Gugatan:' AS info;

SELECT
    CASE
        WHEN p.nomor_perkara LIKE '%Pdt.Gt%' THEN 'Pdt.Gt'
        WHEN p.nomor_perkara LIKE '%Pdt.G/%' THEN 'Pdt.G'
        WHEN p.nomor_perkara LIKE '%PDT.G%' THEN 'PDT.G'
        WHEN p.jenis_perkara_nama LIKE '%Cerai Gugat%' THEN 'Berdasarkan Jenis'
        ELSE 'Lainnya'
    END as kategori_filter,
    COUNT(*) as jumlah
FROM perkara p
WHERE (
        p.nomor_perkara LIKE '%Pdt.Gt%'
        OR p.nomor_perkara LIKE '%Pdt.G/%'
        OR p.nomor_perkara LIKE '%PDT.G%'
        OR p.jenis_perkara_nama LIKE '%Cerai Gugat%'
    )
GROUP BY
    kategori_filter
ORDER BY jumlah DESC;