<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('validate_tahun')) {
	function validate_tahun($tahun)
	{
		$tahun = trim($tahun);
		if (preg_match('/^\d{4}$/', $tahun)) {
			$year = (int) $tahun;
			if ($year >= 2000 && $year <= (int) date('Y') + 1) {
				return $tahun;
			}
		}
		return date('Y');
	}
}

if (!function_exists('validate_bulan')) {
	function validate_bulan($bulan)
	{
		$bulan = trim($bulan);
		if (preg_match('/^\d{1,2}$/', $bulan)) {
			$month = (int) $bulan;
			if ($month >= 1 && $month <= 12) {
				return str_pad($month, 2, '0', STR_PAD_LEFT);
			}
		}
		return date('m');
	}
}

if (!function_exists('validate_wilayah')) {
	function validate_wilayah($wilayah, $default = 'HSU')
	{
		$allowed = array('HSU', 'Balangan', 'Semua', 'Semua Wilayah');
		return in_array($wilayah, $allowed) ? $wilayah : $default;
	}
}

if (!function_exists('validate_jenis_laporan')) {
	function validate_jenis_laporan($jenis_laporan)
	{
		$allowed = array('bulanan', 'tahunan', 'custom');
		return in_array($jenis_laporan, $allowed) ? $jenis_laporan : 'bulanan';
	}
}

if (!function_exists('validate_report_type')) {
	function validate_report_type($report_type)
	{
		$allowed = array('summary', 'yearly', 'monthly', 'comparison', 'faktor', 'faktor_detail', 'custom_range', 'yearly_comparison');
		return in_array($report_type, $allowed) ? $report_type : 'summary';
	}
}

if (!function_exists('validate_jenis_kelamin')) {
	function validate_jenis_kelamin($jenis_kelamin)
	{
		return in_array($jenis_kelamin, array('L', 'P')) ? $jenis_kelamin : 'L';
	}
}

if (!function_exists('validate_tanggal')) {
	function validate_tanggal($tanggal, $default = null)
	{
		if ($default === null) {
			$default = date('Y-m-d');
		}
		$tanggal = trim($tanggal);
		if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) {
			$parts = explode('-', $tanggal);
			if (checkdate((int) $parts[1], (int) $parts[2], (int) $parts[0])) {
				return $tanggal;
			}
		}
		return $default;
	}
}

if (!function_exists('validate_jenis_perkara')) {
	function validate_jenis_perkara($jenis_perkara, $default = 'Cerai Gugat')
	{
		$jenis_perkara = trim($jenis_perkara);
		if (empty($jenis_perkara)) {
			return $default;
		}
		if (preg_match('/^[a-zA-Z0-9\s\.\-\/]+$/', $jenis_perkara)) {
			return $jenis_perkara;
		}
		return $default;
	}
}

if (!function_exists('validate_perkara_pattern')) {
	function validate_perkara_pattern($pattern, $default = 'Pdt.G')
	{
		$pattern = trim($pattern);
		if (empty($pattern)) {
			return $default;
		}
		if (preg_match('/^[a-zA-Z0-9\.\-\/]+$/', $pattern)) {
			return $pattern;
		}
		return $default;
	}
}

{
	$tahun = trim($tahun);
	if (preg_match('/^\d{4}$/', $tahun)) {
		$year = (int) $tahun;
		if ($year >= 2000 && $year <= (int) date('Y') + 1) {
			return $tahun;
		}
	}
	return date('Y');
}

if (!function_exists('validate_status_putusan')) {
	function validate_status_putusan($status)
	{
		$status = trim($status);
		if (empty($status)) {
			return 'semua';
		}
		if ($status === 'semua' || preg_match('/^\d+$/', $status)) {
			return $status;
		}
		return 'semua';
	}
}
