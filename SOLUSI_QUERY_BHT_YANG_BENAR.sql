-- ============================================
-- SOLUSI QUERY BHT YANG BENAR
-- Mengatasi masalah Persentase BHT > 100%
-- ============================================

-- MASALAH SAAT INI:
-- Query menggunakan 2 subquery terpisah yang bisa menghasilkan:
-- PERKARA_PUTUS = 25, PERKARA_TELAH_BHT = 30 (tidak logis!)

-- SOLUSI YANG BENAR:
-- BHT harus dihitung dari perkara yang sudah memiliki tanggal_putusan

-- 1. QUERY YANG BENAR - Single Query Approach
SELECT
    locations.KECAMATAN,
    COUNT(
        DISTINCT CASE
            WHEN p.tanggal_pendaftaran IS NOT NULL THEN p.perkara_id
        END
    ) AS PERKARA_MASUK,
    COUNT(
        DISTINCT CASE
            WHEN pp.tanggal_putusan IS NOT NULL THEN pp.perkara_id
        END
    ) AS PERKARA_PUTUS,
    COUNT(
        DISTINCT CASE
            WHEN pp.tanggal_putusan IS NOT NULL
            AND pp.tanggal_bht IS NOT NULL THEN pp.perkara_id
        END
    ) AS PERKARA_TELAH_BHT,
    COUNT(
        DISTINCT CASE
            WHEN pac.tgl_akta_cerai IS NOT NULL THEN pac.perkara_id
        END
    ) AS JUMLAH_AKTA_CERAI
FROM (
        -- Daftar kecamatan berdasarkan wilayah
        SELECT 'Amuntai Selatan' AS KECAMATAN
        UNION ALL
        SELECT 'Amuntai Tengah'
        UNION ALL
        SELECT 'Amuntai Utara'
        UNION ALL
        SELECT 'Babirik'
        UNION ALL
        SELECT 'Danau Panggang'
        UNION ALL
        SELECT 'Haur Gading'
        UNION ALL
        SELECT 'Paminggir'
        UNION ALL
        SELECT 'Sungai Pandan'
        UNION ALL
        SELECT 'Sungai Tabukan'
    ) AS locations

-- Main joins
LEFT JOIN perkara p ON (
    CASE
        WHEN SUBSTRING_INDEX(p.alamat_pihak1, ',', -1) LIKE '%Amuntai Selatan%' THEN 'Amuntai Selatan'
        WHEN SUBSTRING_INDEX(p.alamat_pihak1, ',', -1) LIKE '%Amuntai Tengah%' THEN 'Amuntai Tengah'
        WHEN SUBSTRING_INDEX(p.alamat_pihak1, ',', -1) LIKE '%Amuntai Utara%' THEN 'Amuntai Utara'
        WHEN SUBSTRING_INDEX(p.alamat_pihak1, ',', -1) LIKE '%Babirik%' THEN 'Babirik'
        WHEN SUBSTRING_INDEX(p.alamat_pihak1, ',', -1) LIKE '%Danau Panggang%' THEN 'Danau Panggang'
        WHEN SUBSTRING_INDEX(p.alamat_pihak1, ',', -1) LIKE '%Haur Gading%' THEN 'Haur Gading'
        WHEN SUBSTRING_INDEX(p.alamat_pihak1, ',', -1) LIKE '%Paminggir%' THEN 'Paminggir'
        WHEN SUBSTRING_INDEX(p.alamat_pihak1, ',', -1) LIKE '%Sungai Pandan%' THEN 'Sungai Pandan'
        WHEN SUBSTRING_INDEX(p.alamat_pihak1, ',', -1) LIKE '%Sungai Tabukan%' THEN 'Sungai Tabukan'
        ELSE 'Lainnya'
    END
) = locations.KECAMATAN
AND p.jenis_perkara_nama = 'Cerai Gugat'
AND (
    (
        YEAR(p.tanggal_pendaftaran) = 2025
        AND MONTH(p.tanggal_pendaftaran) = 11
    )
    OR p.tanggal_pendaftaran IS NULL
)

-- Join dengan tabel putusan
LEFT JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
AND (
    (
        YEAR(pp.tanggal_putusan) = 2025
        AND MONTH(pp.tanggal_putusan) = 11
    )
    OR (
        YEAR(pp.tanggal_bht) = 2025
        AND MONTH(pp.tanggal_bht) = 11
    )
    OR pp.tanggal_putusan IS NULL
)

-- Join dengan akta cerai
LEFT JOIN perkara_akta_cerai pac ON p.perkara_id = pac.perkara_id
AND (
    (
        YEAR(pac.tgl_akta_cerai) = 2025
        AND MONTH(pac.tgl_akta_cerai) = 11
    )
    OR pac.tgl_akta_cerai IS NULL
)

-- Join dengan pihak1 untuk urutan
LEFT JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id
AND pp1.urutan = '1'
GROUP BY
    locations.KECAMATAN
ORDER BY locations.KECAMATAN;

-- ============================================
-- 2. ALTERNATIVE: Perbaikan Query Existing
-- ============================================

-- Ubah logic untuk memastikan BHT tidak lebih dari Putus
SELECT
    locations.KECAMATAN,
    COALESCE(
        SUM(
            CASE
                WHEN subquery.date_type = 'tanggal_pendaftaran' THEN subquery.COUNT
                ELSE 0
            END
        ),
        0
    ) AS PERKARA_MASUK,
    COALESCE(
        SUM(
            CASE
                WHEN subquery.date_type = 'tanggal_putusan' THEN subquery.COUNT
                ELSE 0
            END
        ),
        0
    ) AS PERKARA_PUTUS,

-- BHT tidak boleh lebih dari PUTUS
LEAST(
    COALESCE(
        SUM(
            CASE
                WHEN subquery.date_type = 'tanggal_bht' THEN subquery.COUNT
                ELSE 0
            END
        ),
        0
    ),
    COALESCE(
        SUM(
            CASE
                WHEN subquery.date_type = 'tanggal_putusan' THEN subquery.COUNT
                ELSE 0
            END
        ),
        0
    )
) AS PERKARA_TELAH_BHT,
COALESCE(
    SUM(
        CASE
            WHEN subquery.date_type = 'tgl_akta_cerai' THEN subquery.COUNT
            ELSE 0
        END
    ),
    0
) AS JUMLAH_AKTA_CERAI
FROM (
        -- Daftar kecamatan
    ) AS locations
    LEFT JOIN (
        -- Subqueries yang ada...
        -- Tapi tambahkan DISTINCT pada JOIN untuk menghindari duplikasi
    ) AS subquery ON locations.KECAMATAN = subquery.KECAMATAN
GROUP BY
    locations.KECAMATAN
ORDER BY locations.KECAMATAN;

-- ============================================
-- 3. LANGKAH DEBUGGING
-- ============================================

-- Query untuk mengecek data yang bermasalah
SELECT
    'DEBUG: Data Inconsistent' AS status,
    COUNT(*) AS total_perkara,
    COUNT(
        CASE
            WHEN tanggal_putusan IS NOT NULL THEN 1
        END
    ) AS putus,
    COUNT(
        CASE
            WHEN tanggal_bht IS NOT NULL THEN 1
        END
    ) AS bht,
    COUNT(
        CASE
            WHEN tanggal_bht IS NOT NULL
            AND tanggal_putusan IS NULL THEN 1
        END
    ) AS bht_tanpa_putusan
FROM perkara_putusan pp
    LEFT JOIN perkara p ON pp.perkara_id = p.perkara_id
WHERE
    p.jenis_perkara_nama = 'Cerai Gugat'
    AND (
        YEAR(
            COALESCE(
                pp.tanggal_putusan,
                pp.tanggal_bht
            )
        ) = 2025
        AND MONTH(
            COALESCE(
                pp.tanggal_putusan,
                pp.tanggal_bht
            )
        ) = 11
    );

-- Cari duplikasi perkara_id dalam perkara_putusan
SELECT
    perkara_id,
    COUNT(*) as jumlah_record,
    GROUP_CONCAT(tanggal_putusan) as tanggal_putusan_list,
    GROUP_CONCAT(tanggal_bht) as tanggal_bht_list
FROM perkara_putusan
GROUP BY
    perkara_id
HAVING
    COUNT(*) > 1
LIMIT 10;