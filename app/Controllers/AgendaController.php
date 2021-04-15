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
     * Carrega a lista de pacientes
     *
     * @return void
     */
	public function index()
	{

        $agendaQuerry = $this->AgendaModel->getAll();
        
		return $this->twig->render('agenda/index.html.twig',[
            'title' => 'Agenda',
            'agenda' => $agendaQuerry,
            'baseRoute' => $this->baseRoute
        ]);
	}

    /**
     * Criar uma nova agenda
     *
     * @return void
     */
    public function create(){
        $grupo = $this->GrupoModel->findAll();
        return $this->twig->render('agenda/form.html.twig',[
            'title' => 'Adicionar uma nova agenda',
            'grupos' => $grupo
        ]);
    }

    /**
     * Editar uma agenda
     *
     * @param string $id
     * @return void
     */
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


    /**
     * Copiar agenda
     *
     * @param string $id
     * @return void
     */
    public function copy(string $id){
        $agenda = $this->AgendaModel->find($id);
        unset($agenda->id);
        $grupo = $this->GrupoModel->findAll();

        if (!$agenda) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Agenda não existe');
        }

        return $this->twig->render('agenda/form.html.twig', [
            'baseRoute' => $this->baseRoute,
            'title' => 'Copiar Agenda',
            'agenda' => $agenda,
            'grupos' => $grupo

        ]);
    }

    /**
     * Excluir agenda
     *
     * @param string $id
     * @return void
     */
    public function delete($id)
    {

        $record = $this->AgendaModel->find($id);
        if (!$record)
            return $this->response->setStatusCode(404, 'Agenda não existe!');

        $this->AgendaModel->delete($id);

        return redirect()->to('/agenda');
    }

    /**
     * Salvar agenda
     *
     * @return void
     */
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

            if (\key_exists('id', $this->request->getPost())){

                $data['id'] = $this->request->getPost('id');

                $agendaAntiga = $this->AgendaModel->find($data['id']);
                $agendados = $this->AgendamentoModel->countAgendados($agendaAntiga->id);

                if($agendados > $data['vagas']){
                    $this->session->setFlashdata('error_notice', 'O numero de vagas tem q ser maior ou igual há'. $agendados);

                    return redirect()->to('editar/'. $data['id']);
                }else{
                    $this->AgendaModel->save($data);
                }
            }

            if (\key_exists('id', $this->request->getPost())){
                $this->session->setFlashdata('success_notice', 'Agenda atualizado com sucesso!');
            }else{
                $this->session->setFlashdata('success_notice', 'Agenda cadastrado com sucesso!');
            }

            return redirect()->to('/agenda');
        }
    }

    /**
     * Pegar a agenda pelo id do grupo
     *
     * @param string $grupo
     * @return void
     */
    public function getByGrupo(string $grupo ){

        $agendas = $this->AgendaModel->where([
            'grupo_id' => $grupo
        ])->findAll();

        return $this->response->setJSON($agendas);
    }


    /**
     * Pegar a agenda pelo id do grupo e verificar se ela tem vaga ou nao
     *
     * @param string $grupo
     * @return void
     */
    public function getByGrupoVerification(string $grupo ){

        $agendas = $this->AgendaModel->where([
            'grupo_id' => $grupo, 
        ])
        ->where('data_hora >= CURRENT_TIMESTAMP', null, false)
        ->findAll();

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

    // /**
    //  * tras os dados da agenda atual e o count dos agendados naquela agenda
    //  *
    //  * @param string $id_agenda
    //  * @return void
    //  */
    // public function verificationEditVagas(string $id_agenda){
        
    //     $agendaAntiga = $this->AgendaModel->find($id_agenda);
    //     $agendados = $this->AgendamentoModel->countAgendados($agendaAntiga->id);
        
    //     return $this->response->setJSON([
    //         'agendaAntiga' => $agendaAntiga,
    //         'agendados' => $agendados
    //     ]);

    // }

}