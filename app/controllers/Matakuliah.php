<?php

namespace App\Controllers;

use App\Core\CrudController;

class Matakuliah extends CrudController
{
	protected string $route     = 'matakuliah';
	protected string $judul     = 'mata kuliah';
	protected string $kolomId   = 'matkul_id';
	protected string $kolomNama = 'matkul_nama';
	protected string $kolomUnik = 'matkul_kode';
	protected string $labelUnik = 'Kode mata kuliah';

	public function __construct()
	{
		$this->model = new \App\Models\Matakuliah();
	}

	protected function ambil(): array
	{
		return [
			'matkul_kode'     => $this->masukan('matkul_kode'),
			'matkul_nama'     => $this->masukan('matkul_nama'),
			'matkul_sks'      => $this->masukan('matkul_sks'),
			'matkul_semester' => $this->masukan('matkul_semester'),
		];
	}

	protected function validasi(array $in, int $id = 0): array
	{
		$e = [];

		if ($in['matkul_kode'] === '') {
			$e['matkul_kode'] = 'Kode mata kuliah wajib diisi.';
		} elseif (panjang($in['matkul_kode']) > 25) {
			$e['matkul_kode'] = 'Kode maksimal 25 karakter.';
		} elseif (!preg_match('/^[A-Za-z0-9._\-]+$/', $in['matkul_kode'])) {
			$e['matkul_kode'] = 'Kode hanya boleh berisi huruf, angka, titik, garis bawah, dan tanda hubung.';
		} elseif ($this->model->unikTerpakai($in['matkul_kode'], $id)) {
			$e['matkul_kode'] = 'Kode mata kuliah sudah digunakan.';
		}

		if ($in['matkul_nama'] === '') {
			$e['matkul_nama'] = 'Nama mata kuliah wajib diisi.';
		} elseif (panjang($in['matkul_nama']) > 100) {
			$e['matkul_nama'] = 'Nama mata kuliah maksimal 100 karakter.';
		}

		if (!ctype_digit($in['matkul_sks']) || (int) $in['matkul_sks'] < 1 || (int) $in['matkul_sks'] > 6) {
			$e['matkul_sks'] = 'SKS harus berupa angka 1 sampai 6.';
		}

		if (!ctype_digit($in['matkul_semester']) || (int) $in['matkul_semester'] < 1 || (int) $in['matkul_semester'] > 14) {
			$e['matkul_semester'] = 'Semester harus berupa angka 1 sampai 14.';
		}

		return $e;
	}
}
