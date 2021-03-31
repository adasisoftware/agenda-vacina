<?php

namespace App\Database\Seeds;

class InitSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {

        // Usuário administrador padrão
        $data = [
            'nome' => 'Admin',
            'senha' => password_hash("102030", PASSWORD_DEFAULT),
            'email' => 'admin@admin.com',
        ];
    
        $this->db->table('usuario')->insert($data);
    }
}