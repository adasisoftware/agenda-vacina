<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use Twig\Node\Expression\FunctionExpression;

class Auth extends BaseController
{

    protected $session;
    protected $UsuarioModel;

    public function __construct()
	{
		// start session
        $this->session = \Config\Services::session();
        $this->UsuarioModel = new UsuarioModel();
    }

    /**
     * Traz a view de login
     *
     * @return void
     */
    public function index()
    {
        return $this->twig->render('auth/login.html.twig');
    }

    /**
     * Efetua verificação de login e redireciona para o dashboard
     *
     * @return void
     */
    public function logar()
    {
        $data = $this->request->getPost();

        $user = $this->UsuarioModel->where('email', $data['email'])
            ->first();    

        if (!$user || !password_verify($data['senha'], $user->senha)) {
            echo "<script>alert('E-mail e Senha Incorretos!');</script>";
            return $this->twig->render('auth/login.html.twig');
        } else {
            $this->session->set([
                'email' => $this->request->getPost('email'),
                'nome' => $user->nome,
                'id' => $user->id
            ]);

            $ip = [
                'id' => $user->id,
                'dt_ultimo_acesso' => date('Y-m-d H:i:s'),
                'ip_ultimo_acesso' => $this->request->getIPAddress()
            ];

            $this->UsuarioModel->save($ip);

            return redirect()->to('/dashboard');
        }
    }

    /**
     * Destroi a seção e desloga o usuario
     *
     * @return void
     */
    public function logout(){
        session()->destroy();
        return redirect()->to('/');
    }


}
