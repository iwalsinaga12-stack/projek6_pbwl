<?php

namespace App\Controllers;

use App\Core\Controller;

class Dashboard extends Controller
{

	public function index()
	{
		$model = new \App\Models\Dashboard();
		$data['ringkasan'] = $model->ringkasan();
		$this->dashboard('dashboard/index', $data);
	}
}
