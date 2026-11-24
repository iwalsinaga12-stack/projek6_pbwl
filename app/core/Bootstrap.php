<?php

namespace App\Core;

class Bootstrap
{
    public function __construct()
    {
        // Ambil URL dari REQUEST_URI jika tidak ada parameter 'page'
        $url = $_GET['page'] ?? $this->getRequestUri();
        $url = is_string($url) ? $url : '';

        // Jika ada URL yang diakses
        if ($url) {
            // Filter dan bersihkan URL
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = trim((string) $url, '/');
            $url = explode('/', $url);

            // Uppercase huruf pertama dan ambil bagian pertama sebagai nama controller
            $page = ucfirst(array_shift($url));

            // Cek apakah file controller ada (hanya huruf, angka, underscore)
            if (preg_match('/^[A-Za-z0-9_]+$/', $page) && file_exists(ROOT . "app/controllers/" . $page . ".php")) {
                $class = "App\\Controllers\\" . $page;
                $controller = new $class;

                // Method yang dipanggil, default index
                $action = $url ? array_shift($url) : 'index';

                // Parameters = controller/method/params
                $params = array_values($url);

                // Cek apakah method boleh diakses lewat URL
                if ($this->bisaDiakses($controller, $action, count($params))) {
                    call_user_func_array([$controller, $action], $params);
                } else {
                    $controller = new \App\Core\Error();
                    $controller->fileNotFound();
                }
            } else {
                // Jika controller tidak ditemukan, tampilkan halaman error
                $class = "App\\Core\\Error";
                $controller = new $class();
                $controller->fileNotFound();
            }
        } else {
            // Jika tidak ada URL, panggil controller Index secara default
            $class = "App\\Controllers\\Index";
            $controller = new $class();
            $controller->index();
        }
    }

    /**
     * Method hanya boleh diakses jika public, bukan bawaan Controller dasar
     * (guest, dashboard), dan jumlah parameter URL sesuai.
     */
    private function bisaDiakses($controller, $action, $jumlahParam)
    {
        if (!preg_match('/^[A-Za-z][A-Za-z0-9_]*$/', $action) || !method_exists($controller, $action)) {
            return false;
        }

        $method = new \ReflectionMethod($controller, $action);

        if (!$method->isPublic() || $method->isStatic() || $method->isConstructor()) {
            return false;
        }

        if ($method->getDeclaringClass()->getName() === Controller::class) {
            return false;
        }

        return $jumlahParam >= $method->getNumberOfRequiredParameters()
            && $jumlahParam <= $method->getNumberOfParameters();
    }

    /**
     * Mendapatkan request URI untuk Nginx
     */
    private function getRequestUri()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = parse_url($uri, PHP_URL_PATH);

        // Hilangkan nama folder project dari URL
        $basePath = dirname($_SERVER['SCRIPT_NAME']);
        if ($basePath !== '/' && strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }

        return trim($uri, '/');
    }
}
