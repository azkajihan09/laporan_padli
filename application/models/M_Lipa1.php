<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_lipa1 extends CI_Model
{
    public function getData($lap_tahun, $lap_bulan, $jenis_perkara)
    {

		$query = $this->db->query("SELECT nomor_perkara, jenis_perkara_nama, majelis_hakim_nama, panitera_pengganti_text, tanggal_pendaftaran, penetapan_majelis_hakim, penetapan_hari_sidang, sidang_pertama, tanggal_putusan, status_putusan.`nama` AS amar, pekerjaan, perkara_pihak2.alamat as alamat_pihak2, prodeo, pihak.email as email_pihak1 FROM perkara
			LEFT JOIN perkara_penetapan ON perkara.perkara_id = perkara_penetapan.perkara_id
			LEFT JOIN perkara_putusan ON perkara.perkara_id = perkara_putusan.perkara_id
			LEFT JOIN status_putusan ON status_putusan.id = perkara_putusan.status_putusan_id 
			LEFT JOIN perkara_pihak1 ON perkara.perkara_id = perkara_pihak1.perkara_id
			LEFT JOIN perkara_pihak2 ON perkara.perkara_id = perkara_pihak2.perkara_id
			LEFT JOIN pihak ON perkara_pihak1.pihak_id = pihak.id
			LEFT JOIN perkara_efiling_id ON perkara.perkara_id = perkara_efiling_id.perkara_id
			WHERE (
				YEAR(tanggal_pendaftaran)='$lap_tahun' AND MONTH(tanggal_pendaftaran)='$lap_bulan'
				OR YEAR(penetapan_majelis_hakim)='$lap_tahun' AND MONTH(penetapan_majelis_hakim)='$lap_bulan'
				OR YEAR(penetapan_hari_sidang)='$lap_tahun' AND MONTH(penetapan_hari_sidang)='$lap_bulan'
				OR YEAR(sidang_pertama)='$lap_tahun' AND MONTH(sidang_pertama)='$lap_bulan'
				OR YEAR(tanggal_putusan)='$lap_tahun' AND MONTH(tanggal_putusan)='$lap_bulan'
				OR tanggal_pendaftaran IS NULL
			)
			AND perkara_pihak1.pihak_id != '1'
			AND perkara.nomor_perkara LIKE '%$jenis_perkara%'
			AND perkara_pihak1.urutan = '1'
			AND pekerjaan NOT LIKE '%Pensiunan%'
			ORDER BY tanggal_pendaftaran
		");
		return $query->result();

    }

	public function getJumlah($lap_tahun, $lap_bulan, $jenis_perkara)
	{
		$query = $this->db->query("SELECT COUNT(perkara.perkara_id) AS jumlah FROM perkara
			LEFT JOIN perkara_penetapan ON perkara.perkara_id = perkara_penetapan.perkara_id
			LEFT JOIN perkara_putusan ON perkara.perkara_id = perkara_putusan.perkara_id
			LEFT JOIN perkara_pihak1 ON perkara.perkara_id = perkara_pihak1.perkara_id
			LEFT JOIN perkara_pihak2 ON perkara.perkara_id = perkara_pihak2.perkara_id
			LEFT JOIN pihak ON perkara_pihak1.pihak_id = pihak.id
			LEFT JOIN perkara_efiling_id ON perkara.perkara_id = perkara_efiling_id.perkara_id
			WHERE (
				-- YEAR(tanggal_pendaftaran)='$lap_tahun' AND MONTH(tanggal_pendaftaran)='$lap_bulan'
				(YEAR(tanggal_pendaftaran) < '$lap_tahun' OR (YEAR(tanggal_pendaftaran) = '$lap_tahun' AND MONTH(tanggal_pendaftaran) < 'lap_bulan')) AND tanggal_putusan IS NULL
				OR YEAR(penetapan_majelis_hakim)='$lap_tahun' AND MONTH(penetapan_majelis_hakim)='$lap_bulan'
				OR YEAR(penetapan_hari_sidang)='$lap_tahun' AND MONTH(penetapan_hari_sidang)='$lap_bulan'
				OR YEAR(sidang_pertama)='$lap_tahun' AND MONTH(sidang_pertama)='$lap_bulan'
				OR YEAR(tanggal_putusan)='$lap_tahun' AND MONTH(tanggal_putusan)='$lap_bulan'
				OR tanggal_pendaftaran IS NULL
			)
			AND perkara_pihak1.pihak_id != '1'
			AND perkara.nomor_perkara LIKE '%$jenis_perkara%'
			AND perkara_pihak1.urutan = '1'
			AND pekerjaan NOT LIKE '%Pensiunan%'
			ORDER BY tanggal_pendaftaran
		");
		return $query->row();
	}

	public function getJumlahPensiunan($lap_tahun, $lap_bulan, $jenis_perkara)
	{
		$query = $this->db->query("SELECT COUNT(perkara.perkara_id) AS jumlah FROM perkara
			LEFT JOIN perkara_penetapan ON perkara.perkara_id = perkara_penetapan.perkara_id
			LEFT JOIN perkara_putusan ON perkara.perkara_id = perkara_putusan.perkara_id
			LEFT JOIN perkara_pihak1 ON perkara.perkara_id = perkara_pihak1.perkara_id
			LEFT JOIN perkara_pihak2 ON perkara.perkara_id = perkara_pihak2.perkara_id
			LEFT JOIN pihak ON perkara_pihak1.pihak_id = pihak.id
			LEFT JOIN perkara_efiling_id ON perkara.perkara_id = perkara_efiling_id.perkara_id
			WHERE (
				YEAR(tanggal_pendaftaran)='$lap_tahun' AND MONTH(tanggal_pendaftaran)='$lap_bulan'
				OR YEAR(penetapan_majelis_hakim)='$lap_tahun' AND MONTH(penetapan_majelis_hakim)='$lap_bulan'
				OR YEAR(penetapan_hari_sidang)='$lap_tahun' AND MONTH(penetapan_hari_sidang)='$lap_bulan'
				OR YEAR(sidang_pertama)='$lap_tahun' AND MONTH(sidang_pertama)='$lap_bulan'
				OR YEAR(tanggal_putusan)='$lap_tahun' AND MONTH(tanggal_putusan)='$lap_bulan'
				OR tanggal_pendaftaran IS NULL
			)
			AND perkara_pihak1.pihak_id != '1'
			AND perkara.nomor_perkara LIKE '%$jenis_perkara%'
			AND perkara_pihak1.urutan = '1'
			AND pekerjaan LIKE '%Pensiunan%'
			ORDER BY tanggal_pendaftaran
		");
		return $query->row();
	}

	public function getJumlahPNS($lap_tahun, $lap_bulan, $jenis_perkara)
	{
		$query = $this->db->query("SELECT COUNT(perkara.perkara_id) AS jumlah FROM perkara
			LEFT JOIN perkara_penetapan ON perkara.perkara_id = perkara_penetapan.perkara_id
			LEFT JOIN perkara_putusan ON perkara.perkara_id = perkara_putusan.perkara_id
			LEFT JOIN perkara_pihak1 ON perkara.perkara_id = perkara_pihak1.perkara_id
			LEFT JOIN perkara_pihak2 ON perkara.perkara_id = perkara_pihak2.perkara_id
			LEFT JOIN pihak ON perkara_pihak1.pihak_id = pihak.id
			LEFT JOIN perkara_efiling_id ON perkara.perkara_id = perkara_efiling_id.perkara_id
			WHERE (
				YEAR(tanggal_pendaftaran)='$lap_tahun' AND MONTH(tanggal_pendaftaran)='$lap_bulan'
				OR YEAR(penetapan_majelis_hakim)='$lap_tahun' AND MONTH(penetapan_majelis_hakim)='$lap_bulan'
				OR YEAR(penetapan_hari_sidang)='$lap_tahun' AND MONTH(penetapan_hari_sidang)='$lap_bulan'
				OR YEAR(sidang_pertama)='$lap_tahun' AND MONTH(sidang_pertama)='$lap_bulan'
				OR YEAR(tanggal_putusan)='$lap_tahun' AND MONTH(tanggal_putusan)='$lap_bulan'
				OR tanggal_pendaftaran IS NULL
			)
			AND perkara_pihak1.pihak_id != '1'
			AND perkara.nomor_perkara LIKE '%$jenis_perkara%'
			AND perkara_pihak1.urutan = '1'
			AND pekerjaan LIKE '%PNS%'
			ORDER BY tanggal_pendaftaran
		");
		return $query->row();
	}
	                                                                             
}
