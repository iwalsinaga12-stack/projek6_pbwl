<?php

// Laporan error
error_reporting(E_ALL);

// Mode debug: true = tampilkan detail error (Whoops) saat belajar/pengembangan.
// Ubah ke false jika aplikasi dipasang di server sungguhan.
define("APP_DEBUG", true);

// Koneksi database (sesuaikan dengan MySQL di XAMPP)
define("DB_HOST", "localhost");
define("DB_NAME", "db_project6_si2");
define("DB_USER", "root");
define("DB_PASS", "");

// Url - dideteksi otomatis dari alamat yang dibuka di browser,
// contoh: http://localhost/project6
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
$base   = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
define("URL", $scheme . "://" . $host . $base);
define("AST", URL . "/layouts/assets");

// Path root
define("ROOT", dirname(__DIR__) . DIRECTORY_SEPARATOR);

// Session (dipakai untuk pesan notifikasi dan token CSRF)
if (session_status() === PHP_SESSION_NONE) {
	session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax']);
	session_start();
}

// Autoload
require_once ROOT . "vendor/autoload.php";

// Fungsi bantu (e, url, csrf, form_input)
require_once ROOT . "app/core/helpers.php";

if (APP_DEBUG) {
	// Whoops
	$whoops = new \Whoops\Run;
	$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
	$whoops->register();
} else {
	// Mode produksi: jangan tampilkan detail error ke pengguna
	ini_set('display_errors', '0');
	set_exception_handler(function ($e) {
		error_log((string) $e);
		(new \App\Core\Error())->serverError();
	});
}
