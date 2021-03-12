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

use App\Models\PacienteModel;

class DashboardController extends BaseController
{

	protected $pacienteModel;

	public function __construct(){
        $this->pacienteModel = new PacienteModel();
    }
	
	public function index()
	{
		$pacienteTotal = $this->pacienteModel->count();
		
		return $this->twig->render('dashboard/index.html.twig',[
			'pacienteTotal' => $pacienteTotal
		]);
	}

}