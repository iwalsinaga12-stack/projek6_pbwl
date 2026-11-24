<?php

namespace App\Controllers;

use App\Core\CrudController;

class Mahasiswa extends CrudController
{
	protected string $route     = 'mahasiswa';
	protected string $judul     = 'mahasiswa';
	protected string $kolomId   = 'mhsw_id';
	protected string $kolomNama = 'mhsw_nama';
	protected string $kolomUnik = 'mhsw_nim';
	protected string $labelUnik = 'NIM';

	public function __construct()
	{
		$this->model = new \App\Models\Mahasiswa();
	}

	protected function ambil(): array
	{
		return [
			'mhsw_nim'    => $this->masukan('mhsw_nim'),
			'mhsw_nama'   => $this->masukan('mhsw_nama'),
			'mhsw_alamat' => $this->masukan('mhsw_alamat'),
		];
	}

	protected function validasi(array $in, int $id = 0): array
	{
		$e = [];

		if ($in['mhsw_nim'] === '') {
			$e['mhsw_nim'] = 'NIM wajib diisi.';
		} elseif (panjang($in['mhsw_nim']) > 25) {
			$e['mhsw_nim'] = 'NIM maksimal 25 karakter.';
		} elseif (!preg_match('/^[A-Za-z0-9.\-]+$/', $in['mhsw_nim'])) {
			$e['mhsw_nim'] = 'NIM hanya boleh berisi huruf, angka, titik, dan tanda hubung.';
		} elseif ($this->model->unikTerpakai($in['mhsw_nim'], $id)) {
			$e['mhsw_nim'] = 'NIM sudah terdaftar pada mahasiswa lain.';
		}

		if ($in['mhsw_nama'] === '') {
			$e['mhsw_nama'] = 'Nama wajib diisi.';
		} elseif (panjang($in['mhsw_nama']) > 100) {
			$e['mhsw_nama'] = 'Nama maksimal 100 karakter.';
		} elseif (!preg_match('/^[\p{L}\p{M}][\p{L}\p{M}\s.,\'’\-]*$/u', $in['mhsw_nama'])) {
			$e['mhsw_nama'] = 'Nama hanya boleh berisi huruf, spasi, dan tanda baca . , \' -';
		}

		if (panjang($in['mhsw_alamat']) > 500) {
			$e['mhsw_alamat'] = 'Alamat maksimal 500 karakter.';
		}

		return $e;
	}
}
