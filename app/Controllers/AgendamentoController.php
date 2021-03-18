<?php 
/**
 * Agenda Vacina
 * Sistema de vacinas
 * 
 * Controller responsável pelo controle de pacientes
 * 
 * @author Adasi Software <ricardo@adasi.com.br>
 * @link https://www.adasi.com.br
 */

namespace App\Controllers;

use App\Models\AgendamentoModel;
use App\Models\AgendaModel;
use App\Models\PacienteModel;
use App\Models\UsuarioModel;
use App\Models\GrupoModel;

class AgendamentoController extends BaseController
{

    protected $AgendamentoModel;
    protected $AgendaModel;
    protected $PacienteModel;
    protected $UsuarioModel;
    protected $GrupoModel;
    protected $baseRoute = 'agendamento/';

    public function __construct(){
        $this->AgendamentoModel = new AgendamentoModel();
        $this->AgendaModel = new AgendaModel();
        $this->PacienteModel = new PacienteModel();
        $this->UsuarioModel = new UsuarioModel();
        $this->GrupoModel = new GrupoModel();
    }
	
    /**
     * carrega a lista de pacientes
     *
     * @return void
     */
	public function index()
	{
        $agendamentos = $this->AgendamentoModel->findAll();
        $agenda = $this->AgendaModel->findAll();
        $pacientes = $this->PacienteModel->findAll();
        
		return $this->twig->render('agendamento/index.html.twig',[
            'title' => 'Agendamento',
            'agenda' => $agendamentos,
            'baseRoute' => $this->baseRoute
        ]);
	}

    /**
     * chama a view para cadastrar um novo agendamento
     *
     * @return void
     */
    public function create(){
        $agendamentos = $this->AgendamentoModel->findAll();
        $agenda = $this->AgendaModel->findAll();
        $grupo = $this->GrupoModel->findAll();
        $pacientes = $this->PacienteModel->findAll();

        return $this->twig->render('agendamento/form.html.twig',[
            'title' => 'Crie um novo agendamento aqui!',
            'agenda' => $agenda,
            'grupo' => $grupo,
            'pacientes' => $pacientes
        ]);
    }

    /**
     * editar agendamento
     *
     * @param string $id
     * @return void
     */
    public function update(string $id)
    {

    }

    /**
     * excluir agendamento
     *
     * @param [type] $id
     * @return void
     */
    public function delete($id)
    {

    }

    /**
     * salva agendamento
     *
     * @return void
     */
    public function save()
    {
        
    }



}