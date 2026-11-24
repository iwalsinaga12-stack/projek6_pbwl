<?php

namespace App\Models;

use App\Core\Model;

class Mahasiswa extends Model
{
	public function tampil(string $cari = ''): array
	{
		$sql = "SELECT * FROM tb_mhsw";
		$param = [];

		if ($cari !== '') {
			$sql .= " WHERE mhsw_nim LIKE :q1 OR mhsw_nama LIKE :q2 OR mhsw_alamat LIKE :q3";
			$like = '%' . $this->escapeLike($cari) . '%';
			$param = [':q1' => $like, ':q2' => $like, ':q3' => $like];
		}

		$sql .= " ORDER BY mhsw_nim ASC";
		$stmt = $this->db->prepare($sql);
		$stmt->execute($param);

		return $this->selects($stmt);
	}

	public function simpan(array $in): void
	{
		$sql = "INSERT INTO tb_mhsw (mhsw_nim, mhsw_nama, mhsw_alamat) VALUES (:mhsw_nim, :mhsw_nama, :mhsw_alamat)";
		$stmt = $this->db->prepare($sql);
		$stmt->execute([
			':mhsw_nim'    => $in['mhsw_nim'],
			':mhsw_nama'   => $in['mhsw_nama'],
			':mhsw_alamat' => $in['mhsw_alamat'] === '' ? null : $in['mhsw_alamat'],
		]);
	}

	public function edit(int $id)
	{
		$sql = "SELECT * FROM tb_mhsw WHERE mhsw_id=:mhsw_id";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":mhsw_id", $id, \PDO::PARAM_INT);
		$stmt->execute();

		return $this->select($stmt);
	}

	public function update(int $id, array $in): void
	{
		$sql = "UPDATE tb_mhsw SET mhsw_nim=:mhsw_nim, mhsw_nama=:mhsw_nama, mhsw_alamat=:mhsw_alamat WHERE mhsw_id=:mhsw_id";
		$stmt = $this->db->prepare($sql);
		$stmt->execute([
			':mhsw_nim'    => $in['mhsw_nim'],
			':mhsw_nama'   => $in['mhsw_nama'],
			':mhsw_alamat' => $in['mhsw_alamat'] === '' ? null : $in['mhsw_alamat'],
			':mhsw_id'     => $id,
		]);
	}

	public function delete(int $id): void
	{
		$sql = "DELETE FROM tb_mhsw WHERE mhsw_id=:mhsw_id";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":mhsw_id", $id, \PDO::PARAM_INT);
		$stmt->execute();
	}

	// Apakah NIM sudah dipakai mahasiswa lain? (id sendiri dikecualikan saat edit)
	public function unikTerpakai(string $nim, int $kecualiId = 0): bool
	{
		$stmt = $this->db->prepare("SELECT COUNT(*) FROM tb_mhsw WHERE mhsw_nim=:nim AND mhsw_id<>:id");
		$stmt->execute([':nim' => $nim, ':id' => $kecualiId]);

		return (int) $stmt->fetchColumn() > 0;
	}
}
