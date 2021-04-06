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
    protected $usuariosModel;

    public function __construct(){
        $this->UsuarioModel = new UsuarioModel();
    }
	
    /**
     * Carrega a lista de usuarios
     *
     * @return void
     */
	public function index()
	{
        $usuarios = $this->UsuarioModel->findAll();

		return $this->twig->render('usuario/index.html.twig',[
            'title' => 'Usuarios do sistema',
            'usuarios' => $usuarios,
            'baseRoute' => $this->baseRoute
        ]);
	}

    /**
     * Chama a view para cadastro de um novo usuario do sistema
     *
     * @return void
     */
    public function create(){
        return $this->twig->render('usuario/form.html.twig',[
            'title' => 'Crie um novo usuario aqui!',
        ]);
    }

    /**
     * Carrega o formulario para alterar o usuario
     *
     * @param string $id
     * @return void
     */
    public function update(string $id){
        $usuario = $this->UsuarioModel->find($id);
        
        if(!$usuario){
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Usuario não existe');
        }

        return $this->twig->render('usuario/form.html.twig', [
            'baseRoute' => $this->baseRoute,
            'title' => 'Editar Usuario',
            'usuario' => $usuario
        ]);
    }

    /**
     * Exclusão de um registro
     *
     * @param int $id
     * @return void
     */
    public function delete($id){
            
            $record = $this->UsuarioModel->find($id);
            if (!$record)
            return $this->response->setStatusCode(404, 'Usuario não existe!');
            
            $this->UsuarioModel->delete($id);
            
            return redirect()->to('/usuario');
    }

    /**
     * salva um novo usuario
     *
     * @return void
     */
    public function save(){
        if ($this->request->getMethod() === 'post') {
    
            $form = $this->request->getPost();

            $data = [
                'nome' => trim($this->request->getPost('nome')),
                'email' => trim($this->request->getPost('email')),
            ];

            if($this->request->getPost('senha')){
                $senha = password_hash(trim($this->request->getPost('senha')), PASSWORD_DEFAULT);
                $data['senha'] = $senha;
            }

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

    /**
     * verifica se o email ja esta cadastrado
     *
     * @return void
     */
    public function getByEmail(){

        $email = $this->request->getPost('email');

        $emailUsuario = $this->UsuarioModel->where([
            'email' => $email
        ])->first();

        return $this->response->setJSON($emailUsuario);

    }
}