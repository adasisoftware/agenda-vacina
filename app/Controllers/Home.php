<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		return $this->twig->render('index.html.twig');
	}
}
