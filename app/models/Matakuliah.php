<?php

namespace App\Models;

use App\Core\Model;

class Matakuliah extends Model
{
	public function tampil(string $cari = ''): array
	{
		$sql = "SELECT * FROM tb_matakuliah";
		$param = [];

		if ($cari !== '') {
			$sql .= " WHERE matkul_kode LIKE :q1 OR matkul_nama LIKE :q2";
			$like = '%' . $this->escapeLike($cari) . '%';
			$param = [':q1' => $like, ':q2' => $like];
		}

		$sql .= " ORDER BY matkul_semester ASC, matkul_kode ASC";
		$stmt = $this->db->prepare($sql);
		$stmt->execute($param);

		return $this->selects($stmt);
	}

	public function simpan(array $in): void
	{
		$sql = "INSERT INTO tb_matakuliah (matkul_kode, matkul_nama, matkul_sks, matkul_semester) VALUES (:matkul_kode, :matkul_nama, :matkul_sks, :matkul_semester)";
		$stmt = $this->db->prepare($sql);
		$stmt->execute([
			':matkul_kode'     => $in['matkul_kode'],
			':matkul_nama'     => $in['matkul_nama'],
			':matkul_sks'      => (int) $in['matkul_sks'],
			':matkul_semester' => (int) $in['matkul_semester'],
		]);
	}

	public function edit(int $id)
	{
		$stmt = $this->db->prepare("SELECT * FROM tb_matakuliah WHERE matkul_id=:matkul_id");
		$stmt->bindValue(":matkul_id", $id, \PDO::PARAM_INT);
		$stmt->execute();

		return $this->select($stmt);
	}

	public function update(int $id, array $in): void
	{
		$sql = "UPDATE tb_matakuliah SET matkul_kode=:matkul_kode, matkul_nama=:matkul_nama, matkul_sks=:matkul_sks, matkul_semester=:matkul_semester WHERE matkul_id=:matkul_id";
		$stmt = $this->db->prepare($sql);
		$stmt->execute([
			':matkul_kode'     => $in['matkul_kode'],
			':matkul_nama'     => $in['matkul_nama'],
			':matkul_sks'      => (int) $in['matkul_sks'],
			':matkul_semester' => (int) $in['matkul_semester'],
			':matkul_id'       => $id,
		]);
	}

	public function delete(int $id): void
	{
		$stmt = $this->db->prepare("DELETE FROM tb_matakuliah WHERE matkul_id=:matkul_id");
		$stmt->bindValue(":matkul_id", $id, \PDO::PARAM_INT);
		$stmt->execute();
	}

	public function unikTerpakai(string $kode, int $kecualiId = 0): bool
	{
		$stmt = $this->db->prepare("SELECT COUNT(*) FROM tb_matakuliah WHERE matkul_kode=:kode AND matkul_id<>:id");
		$stmt->execute([':kode' => $kode, ':id' => $kecualiId]);

		return (int) $stmt->fetchColumn() > 0;
	}
}
