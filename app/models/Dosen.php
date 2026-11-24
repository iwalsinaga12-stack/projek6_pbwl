<?php

namespace App\Models;

use App\Core\Model;

class Dosen extends Model
{
	public function tampil(string $cari = ''): array
	{
		$sql = "SELECT * FROM tb_dosen";
		$param = [];

		if ($cari !== '') {
			$sql .= " WHERE dosen_nip LIKE :q1 OR dosen_nama LIKE :q2 OR dosen_golongan LIKE :q3";
			$like = '%' . $this->escapeLike($cari) . '%';
			$param = [':q1' => $like, ':q2' => $like, ':q3' => $like];
		}

		$sql .= " ORDER BY dosen_nama ASC";
		$stmt = $this->db->prepare($sql);
		$stmt->execute($param);

		return $this->selects($stmt);
	}

	public function simpan(array $in): void
	{
		$sql = "INSERT INTO tb_dosen (dosen_nip, dosen_nama, dosen_golongan) VALUES (:dosen_nip, :dosen_nama, :dosen_golongan)";
		$stmt = $this->db->prepare($sql);
		$stmt->execute([
			':dosen_nip'      => $in['dosen_nip'],
			':dosen_nama'     => $in['dosen_nama'],
			':dosen_golongan' => $in['dosen_golongan'] === '' ? null : $in['dosen_golongan'],
		]);
	}

	public function edit(int $id)
	{
		$stmt = $this->db->prepare("SELECT * FROM tb_dosen WHERE dosen_id=:dosen_id");
		$stmt->bindValue(":dosen_id", $id, \PDO::PARAM_INT);
		$stmt->execute();

		return $this->select($stmt);
	}

	public function update(int $id, array $in): void
	{
		$sql = "UPDATE tb_dosen SET dosen_nip=:dosen_nip, dosen_nama=:dosen_nama, dosen_golongan=:dosen_golongan WHERE dosen_id=:dosen_id";
		$stmt = $this->db->prepare($sql);
		$stmt->execute([
			':dosen_nip'      => $in['dosen_nip'],
			':dosen_nama'     => $in['dosen_nama'],
			':dosen_golongan' => $in['dosen_golongan'] === '' ? null : $in['dosen_golongan'],
			':dosen_id'       => $id,
		]);
	}

	public function delete(int $id): void
	{
		$stmt = $this->db->prepare("DELETE FROM tb_dosen WHERE dosen_id=:dosen_id");
		$stmt->bindValue(":dosen_id", $id, \PDO::PARAM_INT);
		$stmt->execute();
	}

	public function unikTerpakai(string $nip, int $kecualiId = 0): bool
	{
		$stmt = $this->db->prepare("SELECT COUNT(*) FROM tb_dosen WHERE dosen_nip=:nip AND dosen_id<>:id");
		$stmt->execute([':nip' => $nip, ':id' => $kecualiId]);

		return (int) $stmt->fetchColumn() > 0;
	}
}
