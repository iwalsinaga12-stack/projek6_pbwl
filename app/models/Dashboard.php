<?php

namespace App\Models;

use App\Core\Model;

class Dashboard extends Model
{
	// Semua angka dihitung langsung dari database
	public function ringkasan(): array
	{
		$hitung = function (string $sql): int {
			return (int) $this->db->query($sql)->fetchColumn();
		};

		return [
			'mahasiswa'  => $hitung("SELECT COUNT(*) FROM tb_mhsw"),
			'dosen'      => $hitung("SELECT COUNT(*) FROM tb_dosen"),
			'matakuliah' => $hitung("SELECT COUNT(*) FROM tb_matakuliah"),
			'sks'        => $hitung("SELECT COALESCE(SUM(matkul_sks), 0) FROM tb_matakuliah"),

			'per_semester' => $this->selects($this->db->query(
				"SELECT matkul_semester AS semester, COUNT(*) AS jumlah, SUM(matkul_sks) AS sks
				 FROM tb_matakuliah GROUP BY matkul_semester ORDER BY matkul_semester ASC"
			)),

			'per_golongan' => $this->selects($this->db->query(
				"SELECT COALESCE(NULLIF(dosen_golongan, ''), 'Belum diisi') AS golongan, COUNT(*) AS jumlah
				 FROM tb_dosen GROUP BY golongan ORDER BY golongan = 'Belum diisi', jumlah DESC, golongan ASC"
			)),

			'mhs_terbaru' => $this->selects($this->db->query(
				"SELECT mhsw_id, mhsw_nim, mhsw_nama, mhsw_alamat FROM tb_mhsw ORDER BY mhsw_id DESC LIMIT 5"
			)),
		];
	}
}
