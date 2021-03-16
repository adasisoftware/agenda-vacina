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

class AgendaController extends BaseController
{

    protected $baseRoute = 'agenda/';

    public function __construct(){
        $this->AgendaModel = new AgendaModel();
        $this->GrupoModel = new GrupoModel();
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
        
        //dd($grupo);
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

            $data = [
                'grupo_id' => trim($this->request->getPost('grupo_id')),
                'data_hora' => trim($this->request->getPost('data_hora')),
                'vagas' => trim($this->request->getPost('vagas')),
            ];

            //dd($data);
            if (\key_exists('id', $this->request->getPost()))
                $data['id'] = $this->request->getPost('id');

            $this->AgendaModel->save($data);

            if (\key_exists('id', $this->request->getPost()))
                $this->session->setFlashdata('success_notice', 'Agenda atualizado com sucesso!');
            else
                $this->session->setFlashdata('success_notice', 'Agenda cadastrado com sucesso!');

            return redirect()->to('/agenda');
        }
    }



}