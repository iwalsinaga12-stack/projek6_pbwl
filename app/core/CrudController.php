<?php

namespace App\Core;

/**
 * Alur CRUD yang sama untuk Mahasiswa, Dosen, dan Matakuliah.
 * Controller turunan cukup mengisi properti dan dua method:
 * ambil() untuk membaca isi form dan validasi() untuk memeriksanya.
 */
abstract class CrudController extends Controller
{
	protected object $model;

	protected string $route;      // nama route, contoh: mahasiswa
	protected string $judul;      // dipakai di pesan, contoh: mahasiswa
	protected string $kolomId;    // contoh: mhsw_id
	protected string $kolomNama;  // kolom yang disebut pada pesan hapus
	protected string $kolomUnik;  // kolom yang tidak boleh kembar, contoh: mhsw_nim
	protected string $labelUnik;  // contoh: NIM

	abstract protected function ambil(): array;

	abstract protected function validasi(array $in, int $id = 0): array;

	// Daftar data + pencarian (?q=kata)
	public function index()
	{
		$cari = $_GET['q'] ?? '';
		$cari = is_string($cari) ? trim($cari) : '';
		$cari = function_exists('mb_substr') ? mb_substr($cari, 0, 100, 'UTF-8') : substr($cari, 0, 100);

		$data['rows'] = $this->model->tampil($cari);
		$data['cari'] = $cari;
		$this->dashboard($this->route . '/index', $data);
	}

	// Form tambah
	public function input()
	{
		$this->dashboard($this->route . '/input', ['old' => [], 'errors' => []]);
	}

	// Proses tambah
	public function simpan()
	{
		$this->wajibPost($this->route . '/input');

		$in = $this->ambil();
		$errors = $this->validasi($in);

		if (!$errors) {
			try {
				$this->model->simpan($in);
			} catch (\PDOException $e) {
				$errors = $this->errorUnik($e);
			}
		}

		if ($errors) {
			http_response_code(422);
			$this->dashboard($this->route . '/input', ['old' => $in, 'errors' => $errors]);
			return;
		}

		$this->flash('success', 'Data ' . $this->judul . ' berhasil ditambahkan.');
		$this->redirect($this->route);
	}

	// Form edit
	public function edit($id)
	{
		$row = ctype_digit((string) $id) ? $this->model->edit((int) $id) : false;

		if (!$row) {
			$this->notFound();
			return;
		}

		$this->dashboard($this->route . '/edit', ['id' => (int) $id, 'old' => $row, 'errors' => []]);
	}

	// Proses edit
	public function update()
	{
		$this->wajibPost($this->route);

		$id = $_POST[$this->kolomId] ?? '';

		if (!is_string($id) || !ctype_digit($id) || !$this->model->edit((int) $id)) {
			$this->flash('danger', 'Data ' . $this->judul . ' tidak ditemukan.');
			$this->redirect($this->route);
		}

		$id = (int) $id;
		$in = $this->ambil();
		$errors = $this->validasi($in, $id);

		if (!$errors) {
			try {
				$this->model->update($id, $in);
			} catch (\PDOException $e) {
				$errors = $this->errorUnik($e);
			}
		}

		if ($errors) {
			http_response_code(422);
			$this->dashboard($this->route . '/edit', ['id' => $id, 'old' => $in, 'errors' => $errors]);
			return;
		}

		$this->flash('success', 'Data ' . $this->judul . ' berhasil diperbarui.');
		$this->redirect($this->route);
	}

	// Proses hapus (hanya lewat POST + CSRF)
	public function delete($id)
	{
		$this->wajibPost($this->route);

		$row = ctype_digit((string) $id) ? $this->model->edit((int) $id) : false;

		if (!$row) {
			$this->flash('danger', 'Data ' . $this->judul . ' tidak ditemukan atau sudah dihapus.');
			$this->redirect($this->route);
		}

		$this->model->delete((int) $id);

		$this->flash('success', 'Data ' . $this->judul . ' "' . $row[$this->kolomNama] . '" berhasil dihapus.');
		$this->redirect($this->route);
	}

	// Kode 23000 = pelanggaran UNIQUE (dua orang mengirim data kembar bersamaan)
	private function errorUnik(\PDOException $e): array
	{
		if ($e->getCode() !== '23000') {
			throw $e;
		}

		return [$this->kolomUnik => $this->labelUnik . ' sudah digunakan.'];
	}
}
