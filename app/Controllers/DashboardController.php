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
use App\Models\AgendamentoModel;

class DashboardController extends BaseController
{

	protected $pacienteModel;
	protected $agendamentoModel;

	public function __construct(){
        $this->pacienteModel = new PacienteModel();
		$this->agendamentoModel = new AgendamentoModel();
    }
	
	/**
	 * Traz a view de dashboard
	 *
	 * @return void
	 */
	public function index()
	{
		$pacienteTotal = $this->pacienteModel->count();
		$pacienteSemana = $this->pacienteModel->count_week();
		$agendamentoTotal = $this->agendamentoModel->count();
		$agendamentoSemana = $this->agendamentoModel->count_week();

		$ListaDeAgendamentos = $this->agendamentoModel->getListAllDashboard();

		// dd($ListaDeAgendamentos);

		return $this->twig->render('dashboard/index.html.twig',[
			'pacienteTotal' => $pacienteTotal,
			'pacienteSemana' => $pacienteSemana,
			'agendamentoTotal' => $agendamentoTotal,
			'agendamentoSemana' => $agendamentoSemana,
			'ListaDeAgendamentos' => $ListaDeAgendamentos
		]);
	}

}