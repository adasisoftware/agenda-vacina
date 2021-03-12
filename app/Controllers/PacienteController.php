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

use App\Models\PacienteModel;

class PacienteController extends BaseController
{

    protected $baseRoute = 'paciente/';
    protected $pacienteModel;

    public function __construct(){
        $this->PacienteModel = new PacienteModel();
    }
	
    /**
     * carrega a lista de pacientes
     *
     * @return void
     */
	public function index()
	{
        $paciente = $this->PacienteModel->findAll();

		return $this->twig->render('paciente/index.html.twig',[
            'title' => 'Pacientes do sistema',
            'paciente' => $paciente,
            'baseRoute' => $this->baseRoute
        ]);
	}

    /**
     * chama a view para cadastro de um novo paciente do sistema
     *
     * @return void
     */
    public function create(){
        return $this->twig->render('paciente/form.html.twig',[
            'title' => 'Crie um novo paciente aqui!',
        ]);
    }

    /**
     * carrega o formulario para alterar o paciente
     *
     * @param string $id
     * @return void
     */
    public function update(string $id){
    
    }

    /**
     * exclusão de um registro
     *
     * @param int $id
     * @return void
     */
    public function delete($id){
        
    }

    public function save(){

    }

}