<?php 
/**
 * Agenda Vacina
 * Sistema de controle de chamados
 * 
 * Controller responsável pelo dashboard
 * 
 * @author Adasi Software <ricardo@adasi.com.br>
 * @link https://www.adasi.com.br
 */

namespace App\Controllers;

class DashboardController extends BaseController
{
	
	public function index()
	{
		return $this->twig->render('dashboard/index.html.twig');
	}

}