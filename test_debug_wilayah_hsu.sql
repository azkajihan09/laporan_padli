-- Query Test untuk Debug Wilayah HSU di Faktor Perceraian Detail
-- Jalankan query ini untuk melihat data alamat yang tersedia

-- 1. Cek data alamat di perkara_pihak1 untuk identifikasi pattern
SELECT 'Sample Alamat di Database:' AS info;

SELECT DISTINCT
    SUBSTRING(pp1.alamat, 1, 50) AS sample_alamat,
    COUNT(*) as jumlah
FROM perkara_pihak1 pp1
WHERE
    pp1.alamat IS NOT NULL
    AND pp1.alamat != ''
GROUP BY
    SUBSTRING(pp1.alamat, 1, 50)
ORDER BY jumlah DESC
LIMIT 20;

-- 2. Cek khusus alamat yang mengandung kata kunci HSU
SELECT 'Alamat dengan Pattern HSU:' AS info;

SELECT DISTINCT
    pp1.alamat,
    COUNT(*) as jumlah
FROM perkara_pihak1 pp1
WHERE (
        pp1.alamat LIKE '%Hulu Sungai Utara%'
        OR pp1.alamat LIKE '%HSU%'
        OR pp1.alamat LIKE '%Amuntai%'
        OR pp1.alamat LIKE '%Haur Gading%'
        OR pp1.alamat LIKE '%Banjang%'
        OR pp1.alamat LIKE '%Paminggir%'
        OR pp1.alamat LIKE '%Babirik%'
        OR pp1.alamat LIKE '%Sungai Pandan%'
        OR pp1.alamat LIKE '%Danau Panggang%'
        OR pp1.alamat LIKE '%Sungai Tabukan%'
    )
GROUP BY
    pp1.alamat
ORDER BY jumlah DESC;

-- 3. Cek data di perkara_akta_cerai dengan JOIN ke alamat HSU
SELECT 'Data Akta Cerai untuk HSU:' AS info;

SELECT
    pac.faktor_perceraian_id,
    fp.nama as faktor_nama,
    COUNT(*) as total_kasus,
    SUM(
        CASE
            WHEN pd.jenis_kelamin = 'L' THEN 1
            ELSE 0
        END
    ) as laki_laki,
    SUM(
        CASE
            WHEN pd.jenis_kelamin = 'P' THEN 1
            ELSE 0
        END
    ) as perempuan
FROM
    perkara_akta_cerai pac
    JOIN perkara p ON pac.perkara_id = p.perkara_id
    JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id
    JOIN pihak pd ON pp1.pihak_id = pd.id
    LEFT JOIN faktor_perceraian fp ON pac.faktor_perceraian_id = fp.id
WHERE
    YEAR(pac.tgl_akta_cerai) = YEAR(CURDATE())
    AND (
        pp1.alamat LIKE '%Hulu Sungai Utara%'
        OR pp1.alamat LIKE '%HSU%'
        OR pp1.alamat LIKE '%Amuntai%'
        OR pp1.alamat LIKE '%Haur Gading%'
        OR pp1.alamat LIKE '%Banjang%'
        OR pp1.alamat LIKE '%Paminggir%'
        OR pp1.alamat LIKE '%Babirik%'
        OR pp1.alamat LIKE '%Sungai Pandan%'
        OR pp1.alamat LIKE '%Danau Panggang%'
        OR pp1.alamat LIKE '%Sungai Tabukan%'
    )
GROUP BY
    pac.faktor_perceraian_id,
    fp.nama
ORDER BY total_kasus DESC;

-- 4. Bandingkan dengan Balangan
SELECT 'Data Akta Cerai untuk Balangan:' AS info;

SELECT
    pac.faktor_perceraian_id,
    fp.nama as faktor_nama,
    COUNT(*) as total_kasus,
    SUM(
        CASE
            WHEN pd.jenis_kelamin = 'L' THEN 1
            ELSE 0
        END
    ) as laki_laki,
    SUM(
        CASE
            WHEN pd.jenis_kelamin = 'P' THEN 1
            ELSE 0
        END
    ) as perempuan
FROM
    perkara_akta_cerai pac
    JOIN perkara p ON pac.perkara_id = p.perkara_id
    JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id
    JOIN pihak pd ON pp1.pihak_id = pd.id
    LEFT JOIN faktor_perceraian fp ON pac.faktor_perceraian_id = fp.id
WHERE
    YEAR(pac.tgl_akta_cerai) = YEAR(CURDATE())
    AND (
        pp1.alamat LIKE '%Balangan%'
        OR pp1.alamat LIKE '%Paringin%'
        OR pp1.alamat LIKE '%Awayan%'
        OR pp1.alamat LIKE '%Tebing Tinggi%'
        OR pp1.alamat LIKE '%Juai%'
        OR pp1.alamat LIKE '%Lampihong%'
        OR pp1.alamat LIKE '%Halong%'
        OR pp1.alamat LIKE '%Batumandi%'
    )
GROUP BY
    pac.faktor_perceraian_id,
    fp.nama
ORDER BY total_kasus DESC;

-- 5. Test Query Full seperti di aplikasi untuk HSU
SELECT 'Test Query Full HSU (seperti di aplikasi):' AS info;

SELECT
    faktor.nama AS FaktorPerceraian,
    COALESCE(agg.`Laki-Laki`, 0) AS `Laki-Laki`,
    COALESCE(agg.`Perempuan`, 0) AS `Perempuan`,
    COALESCE(agg.`Total`, 0) AS `Total`
FROM
    faktor_perceraian faktor
    LEFT JOIN (
        SELECT
            pac.faktor_perceraian_id,
            SUM(
                CASE
                    WHEN pd.jenis_kelamin = 'L' THEN 1
                    ELSE 0
                END
            ) AS `Laki-Laki`,
            SUM(
                CASE
                    WHEN pd.jenis_kelamin = 'P' THEN 1
                    ELSE 0
                END
            ) AS `Perempuan`,
            COUNT(*) AS `Total`
        FROM
            perkara_akta_cerai pac
            JOIN perkara p ON pac.perkara_id = p.perkara_id
            JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id
            JOIN pihak pd ON pp1.pihak_id = pd.id
        WHERE
            YEAR(pac.tgl_akta_cerai) = YEAR(CURDATE())
            AND (
                pp1.alamat LIKE '%Hulu Sungai Utara%'
                OR pp1.alamat LIKE '%HSU%'
                OR pp1.alamat LIKE '%Amuntai%'
                OR pp1.alamat LIKE '%Haur Gading%'
                OR pp1.alamat LIKE '%Banjang%'
                OR pp1.alamat LIKE '%Paminggir%'
                OR pp1.alamat LIKE '%Babirik%'
                OR pp1.alamat LIKE '%Sungai Pandan%'
                OR pp1.alamat LIKE '%Danau Panggang%'
                OR pp1.alamat LIKE '%Sungai Tabukan%'
            )
        GROUP BY
            pac.faktor_perceraian_id
    ) AS agg ON faktor.id = agg.faktor_perceraian_id
WHERE
    faktor.aktif = 'Y'
ORDER BY faktor.nama;

-- 6. Cek apakah ada data yang tidak match filter
SELECT 'Total Data Tanpa Filter Wilayah:' AS info;

SELECT COUNT(*) as total_semua_data
FROM
    perkara_akta_cerai pac
    JOIN perkara p ON pac.perkara_id = p.perkara_id
    JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id
    JOIN pihak pd ON pp1.pihak_id = pd.id
WHERE
    YEAR(pac.tgl_akta_cerai) = YEAR(CURDATE());