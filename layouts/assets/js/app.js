document.addEventListener('DOMContentLoaded', function () {
	// Tombol buka/tutup sidebar
	const wrapper = document.getElementById('wrapper');
	const buttons = document.querySelectorAll('.menu-toggle');

	buttons.forEach(function (button) {
		button.addEventListener('click', function () {
			wrapper.classList.toggle('toggled');
		});
	});

	// Modal konfirmasi hapus: isi alamat form dan nama data dari tombol yang diklik
	const modalHapus = document.getElementById('modalHapus');

	if (modalHapus) {
		modalHapus.addEventListener('show.bs.modal', function (event) {
			const tombol = event.relatedTarget;

			if (!tombol) {
				return;
			}

			document.getElementById('formHapus').action = tombol.getAttribute('data-hapus-url');
			document.getElementById('hapusNama').textContent = tombol.getAttribute('data-hapus-nama');
		});
	}

	// Notifikasi sukses hilang sendiri
	document.querySelectorAll('[data-auto-dismiss]').forEach(function (alertEl) {
		const waktu = parseInt(alertEl.getAttribute('data-auto-dismiss'), 10);

		if (waktu > 0) {
			setTimeout(function () {
				bootstrap.Alert.getOrCreateInstance(alertEl).close();
			}, waktu);
		}
	});

	// Cegah klik ganda pada tombol simpan
	document.querySelectorAll('form[data-cegah-ganda]').forEach(function (form) {
		form.addEventListener('submit', function () {
			const tombol = form.querySelector('button[type="submit"]');

			if (tombol) {
				tombol.disabled = true;
			}
		});
	});
});
