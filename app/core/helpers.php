<?php

/**
 * Fungsi bantu global untuk controller dan view.
 */

// Escape output agar aman dari XSS
function e($nilai): string
{
	return htmlspecialchars((string) $nilai, ENT_QUOTES, 'UTF-8');
}

// Buat alamat lengkap dari path, contoh: url('mahasiswa/input')
function url(string $path = ''): string
{
	return URL . '/' . ltrim($path, '/');
}

// Panjang teks (hitungan karakter, bukan byte)
function panjang(string $teks): int
{
	return function_exists('mb_strlen') ? mb_strlen($teks, 'UTF-8') : strlen(utf8_decode($teks));
}

// ---------- CSRF ----------

function csrf_token(): string
{
	if (empty($_SESSION['csrf_token'])) {
		$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
	}
	return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
	return '<input type="hidden" name="_token" value="' . e(csrf_token()) . '">';
}

function csrf_valid($token): bool
{
	return is_string($token)
		&& !empty($_SESSION['csrf_token'])
		&& hash_equals($_SESSION['csrf_token'], $token);
}

// ---------- Form ----------

/**
 * Membuat satu kolom form Bootstrap lengkap dengan label dan pesan error.
 *
 * $opt: type (text|number|textarea), required, maxlength, min, max, rows,
 *       hint, placeholder, inputmode, autofocus
 */
function form_input(string $name, string $label, array $val, array $errors, array $opt = []): string
{
	$id       = 'f_' . $name;
	$type     = $opt['type'] ?? 'text';
	$nilai    = e($val[$name] ?? '');
	$invalid  = isset($errors[$name]);
	$required = !empty($opt['required']);
	$kelas    = 'form-control' . ($invalid ? ' is-invalid' : '');

	$attr = ' class="' . $kelas . '" id="' . $id . '" name="' . e($name) . '"';
	foreach (['maxlength', 'min', 'max', 'placeholder', 'inputmode', 'rows'] as $k) {
		if (isset($opt[$k])) {
			$attr .= ' ' . $k . '="' . e($opt[$k]) . '"';
		}
	}
	if ($required) {
		$attr .= ' required';
	}
	if (!empty($opt['autofocus'])) {
		$attr .= ' autofocus';
	}
	if ($invalid) {
		$attr .= ' aria-invalid="true" aria-describedby="' . $id . '_err"';
	}

	$html  = '<div class="mb-3">';
	$html .= '<label for="' . $id . '" class="form-label">' . e($label);
	$html .= $required ? ' <span class="text-danger" aria-hidden="true">*</span>' : '';
	$html .= '</label>';

	if ($type === 'textarea') {
		$html .= '<textarea' . $attr . '>' . $nilai . '</textarea>';
	} else {
		$html .= '<input type="' . e($type) . '"' . $attr . ' value="' . $nilai . '">';
	}

	if ($invalid) {
		$html .= '<div class="invalid-feedback" id="' . $id . '_err">' . e($errors[$name]) . '</div>';
	}
	if (!empty($opt['hint'])) {
		$html .= '<div class="form-text">' . e($opt['hint']) . '</div>';
	}

	return $html . '</div>';
}
