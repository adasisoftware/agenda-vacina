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
        $agendamentos = $this->AgendamentoModel->getListAllData();
        
		return $this->twig->render('agendamento/index.html.twig',[
            'title' => 'Agendamento',
            'agendamentos' => $agendamentos,
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
        $grupos = $this->GrupoModel->findAll();
        $pacientes = $this->PacienteModel->findAll();

        return $this->twig->render('agendamento/form.html.twig',[
            'title' => 'Crie um novo agendamento aqui!',
            'agenda' => $agenda,
            'grupos' => $grupos,
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
        $agendamento = $this->AgendamentoModel->getListById($id);
        $grupos = $this->GrupoModel->findAll();
        $agendas = $this->AgendaModel->findAll();
        
        if(!$agendamento){
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Agendamento não existe');
        }

        return $this->twig->render('agendamento/form.html.twig', [
            'baseRoute' => $this->baseRoute,
            'title' => 'Editar Agendamento',
            'agendamento' => $agendamento,
            'grupos' => $grupos,
            'agendas' => $agendas
        ]);
    }

    /**
     * excluir agendamento
     *
     * @param [type] $id
     * @return void
     */
    public function delete($id)
    {
        $record = $this->AgendamentoModel->find($id);

        if(!$record)
        return $this->response->setStatusCode(404, 'Agendamento não existe!');

        $this->AgendamentoModel->delete($id);

        return redirect()->to('/agendamento');
    }

    /**
     * salva agendamento
     *
     * @return void
     */
    public function save()
    {
        if ($this->request->getMethod() === 'post') {

            $paciente = [
                'cpf' => unmaskString($this->request->getPost('cpf')),
                'nome' => trim($this->request->getPost('nome')),
                'nome_mae' => trim($this->request->getPost('nome_mae')),
                'data_nascimento' => trim($this->request->getPost('data_nascimento')),
                'telefone' => unmaskString($this->request->getPost('telefone')),
            ];
            //dd($paciente);

            $data = [
                'usuario_id' => $this->session->id,
                'paciente_id'  => trim($this->request->getPost('paciente_id')),
                'grupo_id' => trim($this->request->getPost('grupo_id')),
                'agenda_id' => trim($this->request->getPost('agenda')),
            ];
            //dd($data);

            if (\key_exists('agendamento_id', $this->request->getPost()))
                $data['id'] = $this->request->getPost('agendamento_id');

            $verificacao_vagas = $this->verificar_vagas($data['agenda_id']);

            if($verificacao_vagas == true){
                //$this->PacienteModel->save($paciente);
                $this->AgendamentoModel->save($data);
            }else{
                $this->session->setFlashdata('success_notice', 'Agenda cheia!');
            }

            if (\key_exists('id', $this->request->getPost()))
                $this->session->setFlashdata('success_notice', 'Agenda atualizado com sucesso!');
            else
                $this->session->setFlashdata('success_notice', 'Agenda cadastrado com sucesso!');

            return redirect()->to('/agendamento');
        }

    }

    public function verificar_vagas($agenda_id){
        //valor de quantas pessoas estao cadastradas em uma unica agenda
        $check_vagas = $this->AgendamentoModel->getVagasCheck($agenda_id);
        $vagas_agenda = $this->AgendaModel->where([
            'id' => $agenda_id
        ])->first();

        

        if($check_vagas->vagas_restantes < $vagas_agenda->vagas){
            return true;
        }else{
            return false;
        }

    }

}