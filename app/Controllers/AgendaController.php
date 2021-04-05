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

use App\Models\AgendaModel;
use App\Models\GrupoModel;
use App\Models\AgendamentoModel;

class AgendaController extends BaseController
{

    protected $baseRoute = 'agenda/';

    public function __construct(){
        $this->AgendaModel = new AgendaModel();
        $this->GrupoModel = new GrupoModel();
        $this->AgendamentoModel = new AgendamentoModel();
    }
	
    /**
     * carrega a lista de pacientes
     *
     * @return void
     */
	public function index()
	{

        $agendaQuerry = $this->AgendaModel->getAll();
        //dd($agendaQuerry);
		return $this->twig->render('agenda/index.html.twig',[
            'title' => 'Agenda',
            'agenda' => $agendaQuerry,
            'baseRoute' => $this->baseRoute
        ]);
	}

    public function create(){
        $grupo = $this->GrupoModel->findAll();
        return $this->twig->render('agenda/form.html.twig',[
            'title' => 'Adicionar uma nova agenda',
            'grupos' => $grupo
        ]);
    }

    public function update(string $id)
    {
        $agenda = $this->AgendaModel->find($id);
        $grupo = $this->GrupoModel->findAll();


        if (!$agenda) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Agenda não existe');
        }

        return $this->twig->render('agenda/form.html.twig', [
            'baseRoute' => $this->baseRoute,
            'title' => 'Editar Agenda',
            'agenda' => $agenda,
            'grupos' => $grupo

        ]);
    }


    public function delete($id)
    {

        $record = $this->AgendaModel->find($id);
        if (!$record)
            return $this->response->setStatusCode(404, 'Agenda não existe!');

        $this->AgendaModel->delete($id);

        return redirect()->to('/agenda');
    }


    public function save()
    {
        if ($this->request->getMethod() === 'post') {

            $data_time = [
                'data' => trim($this->request->getPost('data')),
                'hora' => trim($this->request->getPost('hora'))
            ];

            $data = [
                'grupo_id' => trim($this->request->getPost('grupo_id')),
                'data_hora' => trim($this->request->getPost('data_hora')),
                'vagas' => trim($this->request->getPost('vagas')),
                'data_hora' => $data_time['data'].' '.$data_time['hora'],
            ];

            //dd($data);
            if (\key_exists('id', $this->request->getPost()))
                $data['id'] = $this->request->getPost('id');
            // dd($this->request->getPost('id'));
            $this->AgendaModel->save($data);

            if (\key_exists('id', $this->request->getPost()))
                $this->session->setFlashdata('success_notice', 'Agenda atualizado com sucesso!');
            else
                $this->session->setFlashdata('success_notice', 'Agenda cadastrado com sucesso!');

            return redirect()->to('/agenda');
        }
    }

    public function getByGrupo( $grupo ){

        $agendas = $this->AgendaModel->where([
            'grupo_id' => $grupo
        ])->findAll();

        return $this->response->setJSON($agendas);
    }

    public function getByGrupoVerification( $grupo ){

        $agendas = $this->AgendaModel->where([
            'grupo_id' => $grupo
        ])->findAll();

        $agendas_result = [];

        foreach ($agendas as $agenda){
            $agendados = $this->AgendamentoModel->countAgendados($agenda->id);

            if($agenda->vagas - $agendados > 0 ){
                $agenda->data_hora = date('d/m/Y H:i',strtotime($agenda->data_hora));
                $agendas_result[] = $agenda;
            }
        }

        return $this->response->setJSON($agendas_result);
    }

}