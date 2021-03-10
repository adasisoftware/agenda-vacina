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

class UsuarioController extends BaseController
{

    protected $baseRoute = 'usuario/';
	
    /**
     * carrega a lista de usuarios
     *
     * @return void
     */
	public function index()
	{
		return $this->twig->render('usuario/index.html.twig',[
            'title' => 'Usuarios do sistema',
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
        $user = $this->UsuarioModel->find(hashDecode($hashid));

        if(!$user){
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Usuario não existe');
        }

        return $this->twig->render('usuario/form.html.twig', [
            'baseRoute' => $this->baseRoute,
            'title' => 'Editar Usuario',
            'user' => $user
        ]);
    }

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

}