<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use Twig\Node\Expression\FunctionExpression;

class Auth extends BaseController
{

    protected $session;

    public function __construct()
	{
		// start session
        $this->session = \Config\Services::session();
    }
    public function index()
    {
        return $this->twig->render('auth/login.html.twig');

        

    }

    public function logar()
    {
        $loginModel = new UsuarioModel();
        $data = $this->request->getPost();

        $user = $loginModel->where('email', $data['email'])
            ->first();
        // dd($user);
        //
        if (!$user || !password_verify($data['senha'], $user->senha)) {
            echo "<script>alert('E-mail e Senha Incorretos!');</script>";
            return $this->twig->render('auth/login.html.twig');
        } else {
            $this->session->set([
                'email' => $this->request->getPost('email'),
                'nome' => $user->nome,
                'id' => $user->id
            ]);
            return redirect()->to('/dashboard');
        }
    }

    public function mostrar(){
        print_r(session()->get());
    }

    public function usuario(){
        if(session()->has('email')){
            echo 'Existe Usuario logado';
        }else {
            echo 'Não existe usuario logado';
        }
    }

    public function logout(){
        session()->destroy();
        return redirect()->to('/');
    }


}
