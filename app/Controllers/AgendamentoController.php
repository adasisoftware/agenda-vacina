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
     * Carrega a lista de pacientes
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
     * Chama a view para cadastrar um novo agendamento
     *
     * @return void
     */
    public function create(){
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
     * Editar agendamento
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
     * Excluir agendamento
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
     * trasa view para imprimir os dados de agendamento
     *
     * @param string $id
     * @return void
     */
    public function printScreen(string $id ) {

        $agendamento = $this->AgendamentoModel->find($id);
        
        $agenda = $this->AgendaModel->find($agendamento->agenda_id);
        $grupo = $this->GrupoModel->find($agendamento->grupo_id);
        $paciente = $this->PacienteModel->find($agendamento->paciente_id);

        $idade = $this->calculoIdade($paciente->data_nascimento);

        $paciente->idade = $idade ; 

        return  $this->twig->render('agendamento/print.html.twig', [
            'agendamento' => $agendamento,
            'agenda' => $agenda,
            'grupo' => $grupo,
            'paciente' => $paciente,
            'title' => 'Comprovante de Agendamento'
        ]);

    }

    /**
     * Salva agendamento
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

            $data = [
                'usuario_id' => $this->session->id,
                'protocolo' => $this->GerandoProtocolo(),
                'paciente_id'  => trim($this->request->getPost('paciente_id')),
                'grupo_id' => trim($this->request->getPost('grupo_id')),
                'agenda_id' => trim($this->request->getPost('agenda')),
            ];

            if (\key_exists('agendamento_id', $this->request->getPost()))
                $data['id'] = $this->request->getPost('agendamento_id');
            
            //$this->PacienteModel->save($paciente);
            $this->AgendamentoModel->save($data);

            $pacienteId = $this->AgendamentoModel->insertId();
        
            if (\key_exists('agendamento_id', $this->request->getPost()))
                $this->session->setFlashdata('success_notice', 'Agendamento atualizado com sucesso!');
            else
                $this->session->setFlashdata('success_notice', 'Agendamento cadastrado com sucesso!');

            return redirect()->to('/agendamento/print-screen/'. $pacienteId);
        }

    }

    /**
     * Verificar se há algum registro do paciente na tabela de agendamento
     *
     * @param string $paciente
     * @return void
     */
    public function getByPaciente( string $paciente ){

        $pacientes = $this->AgendamentoModel->where([
            'paciente_id' => $paciente 
        ])->findAll();

        return $this->response->setJSON($pacientes);
    }

    
    function GerandoProtocolo($length = 9) {
        $palavras = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numeros = '0123456789';
        $palavrasLength = strlen($palavras);
        $numerosLength = strlen($numeros);
        // $numerosAleatorio = '';
        // $palavrasAleatoria = '';

        for ($i = 0; $i < $length; $i++) {
            $palavrasAleatoria1 = $palavras[rand(0, $palavrasLength - 1)];
            $numerosAleatorio1 = $numeros[rand(0, $numerosLength - 1)];
            $numerosAleatorio2 = $numeros[rand(0, $numerosLength - 1)];
            $numerosAleatorio3= $numeros[rand(0, $numerosLength - 1)];
            $palavrasAleatoria2 = $palavras[rand(0, $palavrasLength - 1)];
            $palavrasAleatoria3 = $palavras[rand(0, $palavrasLength - 1)];
            $numerosAleatorio4= $numeros[rand(0, $numerosLength - 1)];            
        }
        
        $protocolo = $palavrasAleatoria1 . $numerosAleatorio1 . $numerosAleatorio2 . $numerosAleatorio3 . $palavrasAleatoria2 . $palavrasAleatoria3 . $numerosAleatorio4;
        
        return $protocolo;
    }

    public function calculoIdade($date_nascimento){

        $data = explode("-", $date_nascimento);
        
        $anoNasc = $data[0];
        $mesNasc = $data[1];
        $diaNasc = $data[2];

        $anoAtual   = date("Y");
        $mesAtual   = date("m");
        $diaAtual   = date("d");

        $idade = $anoAtual - $anoNasc;

        if($mesAtual < $mesNasc){
            $idade -= 1;
        }else if( ($mesAtual == $mesNasc) && ($diaAtual <= $diaNasc)){
            $idade -= 1;
        }
        return $idade;
    }
    
}