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

use App\Models\UsuarioModel;

class UsuarioController extends BaseController
{

    protected $baseRoute = 'usuario/';

    public function __construct(){
        $this->UsuarioModel = new UsuarioModel();
    }
	
    /**
     * carrega a lista de usuarios
     *
     * @return void
     */
	public function index()
	{
        $usuarios = $this->UsuarioModel->findAll();

		return $this->twig->render('usuario/index.html.twig',[
            'title' => 'Usuarios do sistema',
            'usuarios' => $usuarios,
            'baseRout' => $this->baseRoute
        ]);
	}

    /**
     * chama a view para cadastro de um novo usuario do sistema
     *
     * @return void
     */
    public function create(){
        return $this->twig->render('usuario/form.html.twig',[
            'title' => 'Cadastro de Usuario',
        ]);
    }

    /**
     * carrega o formulario para alterar o usuario
     *
     * @param string $hashid
     * @return void
     */
    public function update(string $hashid){
        $usuarios = $this->UsuarioModel->find(hashDecode($hashid));

        if(!$usuarios){
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Usuario não existe');
        }

        return $this->twig->render('usuario/form.html.twig', [
            'baseRoute' => $this->baseRoute,
            'title' => 'Editar Usuario',
            'usuarios' => $usuarios
        ]);
    }

    /**
     * exclusão de um registro
     *
     * @return void
     */
    public function delete(){
        if ($this->request->getMethod() === 'post') {
            $id = hashDecode($this->request->getPost('id'));
            
            $record = $this->UsuarioModel->find($id);
            if (!$record)
            return $this->response->setStatusCode(404, 'Usuario não existe!');
            
            $this->UsuarioModel->delete($id);
            $this->session->setFlashdata('warning_notice','Usuario excluído com sucesso!');
            
            return $this->response->setJSON(true);
        }
    }

    public function save(){
        if ($this->request->getMethod() === 'post') {
    
            $form = $this->request->getPost();

            $data = [
                'nome' => trim($this->request->getPost('nome')),
                'email' => trim($this->request->getPost('email')),
                'senha' => password_hash(trim($this->request->getPost('senha')), PASSWORD_DEFAULT)
            ];
            
            if (\key_exists('id', $this->request->getPost()))
                $data['id'] = $this->request->getPost('id');

            $this->UsuarioModel->save($data);

            if (\key_exists('id', $this->request->getPost()))
                $this->session->setFlashdata('success_notice', 'Usuario atualizado com sucesso!');
            else
                $this->session->setFlashdata('success_notice', 'Usuario cadastrado com sucesso!');

            return redirect()->to('/usuario');
        }
    }

}