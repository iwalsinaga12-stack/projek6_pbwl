<?php

namespace App\Controllers;

use App\Core\CrudController;

class Dosen extends CrudController
{
	protected string $route     = 'dosen';
	protected string $judul     = 'dosen';
	protected string $kolomId   = 'dosen_id';
	protected string $kolomNama = 'dosen_nama';
	protected string $kolomUnik = 'dosen_nip';
	protected string $labelUnik = 'NIP';

	public function __construct()
	{
		$this->model = new \App\Models\Dosen();
	}

	protected function ambil(): array
	{
		return [
			'dosen_nip'      => $this->masukan('dosen_nip'),
			'dosen_nama'     => $this->masukan('dosen_nama'),
			'dosen_golongan' => $this->masukan('dosen_golongan'),
		];
	}

	protected function validasi(array $in, int $id = 0): array
	{
		$e = [];

		if ($in['dosen_nip'] === '') {
			$e['dosen_nip'] = 'NIP wajib diisi.';
		} elseif (panjang($in['dosen_nip']) > 25) {
			$e['dosen_nip'] = 'NIP maksimal 25 karakter.';
		} elseif (!preg_match('/^[A-Za-z0-9.\-]+$/', $in['dosen_nip'])) {
			$e['dosen_nip'] = 'NIP hanya boleh berisi huruf, angka, titik, dan tanda hubung.';
		} elseif ($this->model->unikTerpakai($in['dosen_nip'], $id)) {
			$e['dosen_nip'] = 'NIP sudah terdaftar pada dosen lain.';
		}

		if ($in['dosen_nama'] === '') {
			$e['dosen_nama'] = 'Nama wajib diisi.';
		} elseif (panjang($in['dosen_nama']) > 100) {
			$e['dosen_nama'] = 'Nama maksimal 100 karakter.';
		} elseif (!preg_match('/^[\p{L}\p{M}][\p{L}\p{M}\s.,\'’\-]*$/u', $in['dosen_nama'])) {
			$e['dosen_nama'] = 'Nama hanya boleh berisi huruf, spasi, dan tanda baca . , \' -';
		}

		if (panjang($in['dosen_golongan']) > 100) {
			$e['dosen_golongan'] = 'Golongan maksimal 100 karakter.';
		} elseif ($in['dosen_golongan'] !== '' && !preg_match('/^[\p{L}\p{N}\s.,\/()\-]+$/u', $in['dosen_golongan'])) {
			$e['dosen_golongan'] = 'Golongan hanya boleh berisi huruf, angka, spasi, dan tanda baca . , / ( ) -';
		}

		return $e;
	}
}
