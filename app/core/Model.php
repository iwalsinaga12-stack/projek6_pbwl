<?php

namespace App\Core;

use PDO;

class Model
{

	protected PDO $db;

	public function __construct()
	{
		$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";

		$this->db = new PDO($dsn, DB_USER, DB_PASS, [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES   => false,
		]);
	}

	public function select($stmt)
	{
		//Menampilkan satu data
		return $stmt->fetch();
	}

	public function selects($stmt)
	{
		//Menampilkan semua data
		$data = [];

		while ($rows = $stmt->fetch()) {
			$data[] = $rows;
		}

		return $data;
	}

	// Karakter % dan _ pada kata kunci pencarian dianggap teks biasa
	protected function escapeLike(string $teks): string
	{
		return addcslashes($teks, '\\%_');
	}
}
