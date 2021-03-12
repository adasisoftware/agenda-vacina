<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class Auth extends BaseController
{
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
            return redirect()->to('/dashboard');
        }
    }
}
