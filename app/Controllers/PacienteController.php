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
        $paciente = $this->PacienteModel->find($id);
        
        if(!$paciente){
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Paciente não existe');
        }

        return $this->twig->render('paciente/form.html.twig', [
            'baseRoute' => $this->baseRoute,
            'title' => 'Editar Paciente',
            'paciente' => $paciente
        ]);
    }

    /**
     * exclusão de um registro
     *
     * @param int $id
     * @return void
     */
    public function delete($id){
        $record = $this->PacienteModel->find($id);
            if (!$record)
            return $this->response->setStatusCode(404, 'Paciente não existe!');
            
            $this->PacienteModel->delete($id);
            
            return redirect()->to('/paciente');
    }

    public function save(){
        if ($this->request->getMethod() === 'post') {
    
            $form = $this->request->getPost();

            $data = [
                'nome' => trim($this->request->getPost('nome')),
                'cpf' => unmaskString($this->request->getPost('cpf')),
                'data_nascimento' => trim($this->request->getPost('data_nascimento')),
                'nome_mae' => trim($this->request->getPost('nome_mae')),
                'telefone' => trim($this->request->getPost('telefone'))
            ];
            
            if (\key_exists('id', $this->request->getPost()))
                $data['id'] = $this->request->getPost('id');

            $this->PacienteModel->save($data);

            if (\key_exists('id', $this->request->getPost()))
                $this->session->setFlashdata('success_notice', 'Paciente atualizado com sucesso!');
            else
                $this->session->setFlashdata('success_notice', 'Paciente cadastrado com sucesso!');

            return redirect()->to('/paciente');
        }
    }

    public function getByCpf(){
        $cpf = unmaskString($this->request->getPost());

        $paciente = $this->PacienteModel->where([
            'cpf' => $cpf
        ])->first();
        //o first tras so a linha da consulta

        return $this->response->setJSON($paciente);
    }
}