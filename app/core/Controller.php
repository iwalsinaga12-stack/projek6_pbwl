<?php

namespace App\Core;

class Controller
{
	// Layout home
	public function guest($view, $data = [])
	{
		require_once ROOT . "layouts/guest.php";
	}

	// layout dashboard
	public function dashboard($view, $data = [])
	{
		require_once ROOT . "layouts/dashboard.php";
	}

	// Pindah halaman lalu hentikan proses
	protected function redirect(string $path): void
	{
		header('Location: ' . url($path));
		exit;
	}

	// Simpan pesan notifikasi untuk ditampilkan di halaman berikutnya
	protected function flash(string $tipe, string $pesan): void
	{
		$_SESSION['flash'] = ['type' => $tipe, 'message' => $pesan];
	}

	// Ambil isi form (POST) sebagai teks yang sudah di-trim
	protected function masukan(string $nama): string
	{
		$nilai = $_POST[$nama] ?? '';
		return is_string($nilai) ? trim($nilai) : '';
	}

	// Perubahan data wajib lewat POST dan membawa token CSRF yang benar
	protected function wajibPost(string $kembali): void
	{
		if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
			$this->flash('danger', 'Aksi ditolak. Perubahan data hanya dapat dilakukan melalui form.');
			$this->redirect($kembali);
		}

		if (!csrf_valid($_POST['_token'] ?? null)) {
			$this->flash('danger', 'Sesi form sudah kedaluwarsa. Muat ulang halaman lalu coba lagi.');
			$this->redirect($kembali);
		}
	}

	protected function notFound(): void
	{
		(new Error())->fileNotFound();
	}
}
