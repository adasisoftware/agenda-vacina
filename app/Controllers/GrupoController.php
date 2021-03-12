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

    public function index()
    {

        return $this->twig->render('grupo/index.html.twig', [
            'title' => 'Grupos',
            'baseRout' => $this->baseRoute
        ]);
    }

    public function create($hashid)
    {
        $usuarios = $this->UsuarioModel->find(hashDecode($hashid));
        return $this->twig->render('grupo/form.html.twig', [
            'title' => 'Adicionar novo Grupo'
        ]);
    }

    public function save()
    {
        if ($this->request->getMethod() === 'post') {

            $data = [
                'nome' => trim($this->request->getPost('nome')),
            ];

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
