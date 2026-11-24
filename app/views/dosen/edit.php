<div class="mb-4">
	<h1 class="page-title">Edit dosen</h1>
	<p class="text-secondary mb-0">Perbarui data dosen. Kolom bertanda * wajib diisi.</p>
</div>

<div class="row">
	<div class="col-12 col-xl-8">
		<div class="panel p-4">
			<?php
			$action = url('dosen/update');
			$tombol = 'Simpan perubahan';
			$val = $data['old'];
			$errors = $data['errors'];
			$hidden = ['dosen_id' => $data['id']];
			require ROOT . "app/views/dosen/_form.php";
			?>
		</div>
	</div>
</div>
