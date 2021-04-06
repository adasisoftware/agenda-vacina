<?php

/**
 * Agenda Vacina
 * Sistema de vacinas
 * 
 * Controller responsável pelo cadastro de usuarios
 * 
 * @author Adasi Software <ricardo@adasi.com.br>
 * @link https://www.adasi.com.br
 */

namespace App\Controllers;

use App\Models\GrupoModel;

class GrupoController extends BaseController
{

    protected $baseRoute = 'grupo/';

    public function __construct()
    {
        $this->GrupoModel = new GrupoModel();
    }

    /**
     * View de lista de grupos
     *
     * @return void
     */
    public function index()
    {
        $grupo = $this->GrupoModel->findAll();

        return $this->twig->render('grupo/index.html.twig', [
            'title' => 'Grupos',
            'baseRoute' => $this->baseRoute,
            'grupo' => $grupo,
        ]);
    }

    /**
     * View de novo grupo
     *
     * @return void
     */
    public function create()
    {
        return $this->twig->render('grupo/form.html.twig', [
            'title' => 'Adicionar novo Grupo',
            'baseRoute' => $this->baseRoute,
            
        ]);
    }

    /**
     * Editar grupo
     *
     * @param string $id
     * @return void
     */
    public function update(string $id)
    {
        $grupo = $this->GrupoModel->find($id);

        if (!$grupo) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Usuario não existe');
        }

        return $this->twig->render('grupo/form.html.twig', [
            'baseRoute' => $this->baseRoute,
            'title' => 'Editar Grupo',
            'grupo' => $grupo
        ]);
    }

    /**
     * Excluir grupo
     *
     * @param string $id
     * @return void
     */
    public function delete(string $id)
    {

        $record = $this->GrupoModel->find($id);
        if (!$record)
            return $this->response->setStatusCode(404, 'Grupo não existe!');

        $this->GrupoModel->delete($id);

        return redirect()->to('/grupo');
    }

    /**
     * Salva um grupo
     *
     * @return void
     */
    public function save()
    {
        if ($this->request->getMethod() === 'post') {

            $data = [
                'nome' => trim($this->request->getPost('nome')),
                'idade_min' => trim($this->request->getPost('idade_min')),
                'idade_max' => trim($this->request->getPost('idade_max')),
            ];
           // dd($data);
            if (\key_exists('id', $this->request->getPost()))
                $data['id'] = $this->request->getPost('id');

            $this->GrupoModel->save($data);

            if (\key_exists('id', $this->request->getPost()))
                $this->session->setFlashdata('success_notice', 'Grupo atualizado com sucesso!');
                
            else
                $this->session->setFlashdata('success_notice', 'Grupo cadastrado com sucesso!');

            return redirect()->to('/grupo');
        }
    }
}
