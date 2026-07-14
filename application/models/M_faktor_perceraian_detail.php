<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_faktor_perceraian_detail extends CI_Model
{
    private $kecamatan = [
        'HSU' => [
            'Amuntai', 'Haur Gading', 'Banjang', 'Paminggir',
            'Babirik', 'Sungai Pandan', 'Danau Panggang', 'Sungai Tabukan',
        ],
        'Balangan' => [
            'Paringin', 'Awayan', 'Tebing Tinggi', 'Juai',
            'Lampihong', 'Halong', 'Batumandi',
        ],
    ];

    private function get_wilayah_condition($wilayah, $alias = 'pp1')
    {
        $list = null;
        if ($wilayah == 'Hulu Sungai Utara' || $wilayah == 'HSU') {
            $list = $this->kecamatan['HSU'];
        } elseif ($wilayah == 'Balangan') {
            $list = $this->kecamatan['Balangan'];
        }

        if ($list) {
            $likes = array_map(fn($k) => "{$alias}.alamat LIKE '%{$k}%'", $list);
            return ['sql' => ' AND (' . implode(' OR ', $likes) . ')', 'params' => []];
        }
        if ($wilayah == 'Semua Wilayah' || $wilayah == 'Semua') {
            return ['sql' => '', 'params' => []];
        }
        return ['sql' => " AND {$alias}.alamat LIKE ?", 'params' => ['%' . $wilayah . '%']];
    }

    private function _subquery_agg($where_alamat = '', $with_alias = false)
    {
        $sql = "SELECT pac.faktor_perceraian_id,
                    SUM(CASE WHEN pd.jenis_kelamin = 'L' THEN 1 ELSE 0 END) AS `Laki-Laki`,
                    SUM(CASE WHEN pd.jenis_kelamin = 'P' THEN 1 ELSE 0 END) AS `Perempuan`,
                    COUNT(*) AS `Total`
                FROM perkara_akta_cerai pac
                JOIN perkara p ON pac.perkara_id = p.perkara_id
                JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id
                JOIN pihak pd ON pp1.pihak_id = pd.id
                WHERE YEAR(pac.tgl_akta_cerai) = ? {$where_alamat}
                GROUP BY pac.faktor_perceraian_id";
        return $with_alias ? "({$sql}) AS agg ON faktor.id = agg.faktor_perceraian_id" : $sql;
    }

    public function data_faktor_perceraian_detail($lap_tahun = null, $wilayah = null)
    {
        $lap_tahun = $lap_tahun ?: date('Y');
        $wilayah = $wilayah ?: 'Balangan';

        $cond = $this->get_wilayah_condition($wilayah, 'pp1');
        $where_alamat = $cond['sql'];
        $params = array_merge([$lap_tahun], $cond['params'], [$lap_tahun], $cond['params']);

        $agg = $this->_subquery_agg($where_alamat, true);
        $agg_total = $this->_subquery_agg($where_alamat, false);

        $sql = "SELECT faktor.nama AS FaktorPerceraian,
                    COALESCE(agg.`Laki-Laki`, 0) AS `Laki-Laki`,
                    COALESCE(agg.`Perempuan`, 0) AS `Perempuan`,
                    COALESCE(agg.`Total`, 0) AS `Total`
                FROM faktor_perceraian faktor
                LEFT JOIN {$agg}
                WHERE faktor.aktif = 'Y'
                UNION ALL
                SELECT 'TOTAL' AS FaktorPerceraian,
                    SUM(COALESCE(agg2.`Laki-Laki`, 0)) AS `Laki-Laki`,
                    SUM(COALESCE(agg2.`Perempuan`, 0)) AS `Perempuan`,
                    SUM(COALESCE(agg2.`Total`, 0)) AS `Total`
                FROM faktor_perceraian faktor
                LEFT JOIN ({$agg_total}) AS agg2 ON faktor.id = agg2.faktor_perceraian_id
                WHERE faktor.aktif = 'Y'";

        return $this->db->query($sql, $params)->result();
    }

    public function data_faktor_perceraian_usia($lap_tahun = null, $wilayah = null, $jenis_kelamin = 'P')
    {
        $lap_tahun = $lap_tahun ?: date('Y');
        $wilayah = $wilayah ?: 'Balangan';
        $jenis_kelamin = in_array($jenis_kelamin, ['L', 'P']) ? $jenis_kelamin : 'P';
        $cond = $this->get_wilayah_condition($wilayah);

        $sql = "SELECT faktor.id, faktor.FaktorPerceraian,
                    COALESCE(agg.usia_16_19, 0) AS usia_16_19,
                    COALESCE(agg.usia_20_25, 0) AS usia_20_25,
                    COALESCE(agg.usia_26_30, 0) AS usia_26_30,
                    COALESCE(agg.usia_31_35, 0) AS usia_31_35,
                    COALESCE(agg.usia_36, 0) AS usia_36
                FROM (
                    SELECT '9' AS id, 'Perselisihan Terus Menerus' AS FaktorPerceraian
                    UNION ALL SELECT '10', 'Kawin Paksa'
                    UNION ALL SELECT '11', 'Murtad'
                    UNION ALL SELECT '12', 'Ekonomi'
                    UNION ALL SELECT '14', 'Lain-Lain'
                ) AS faktor
                LEFT JOIN (
                    SELECT pac.faktor_perceraian_id,
                        SUM(CASE WHEN TIMESTAMPDIFF(YEAR, pd.tanggal_lahir, p.tanggal_pendaftaran) BETWEEN 16 AND 19 AND pd.jenis_kelamin = ? THEN 1 ELSE 0 END) AS usia_16_19,
                        SUM(CASE WHEN TIMESTAMPDIFF(YEAR, pd.tanggal_lahir, p.tanggal_pendaftaran) BETWEEN 20 AND 25 AND pd.jenis_kelamin = ? THEN 1 ELSE 0 END) AS usia_20_25,
                        SUM(CASE WHEN TIMESTAMPDIFF(YEAR, pd.tanggal_lahir, p.tanggal_pendaftaran) BETWEEN 26 AND 30 AND pd.jenis_kelamin = ? THEN 1 ELSE 0 END) AS usia_26_30,
                        SUM(CASE WHEN TIMESTAMPDIFF(YEAR, pd.tanggal_lahir, p.tanggal_pendaftaran) BETWEEN 31 AND 35 AND pd.jenis_kelamin = ? THEN 1 ELSE 0 END) AS usia_31_35,
                        SUM(CASE WHEN TIMESTAMPDIFF(YEAR, pd.tanggal_lahir, p.tanggal_pendaftaran) >= 36 AND pd.jenis_kelamin = ? THEN 1 ELSE 0 END) AS usia_36
                    FROM perkara_akta_cerai pac
                    JOIN perkara p ON pac.perkara_id = p.perkara_id
                    JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id
                    JOIN pihak pd ON pp1.pihak_id = pd.id
                    WHERE YEAR(pac.tgl_akta_cerai) = ? {$cond['sql']}
                    GROUP BY pac.faktor_perceraian_id
                ) AS agg ON faktor.id = agg.faktor_perceraian_id
                ORDER BY CAST(faktor.id AS UNSIGNED)";

        $params = array_fill(0, 5, $jenis_kelamin);
        $params[] = $lap_tahun;
        if (!empty($cond['params'])) $params = array_merge($params, $cond['params']);

        return $this->db->query($sql, $params)->result();
    }
}
