<?php 
namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model{

    protected $table = 'usuario';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nome',
        'email',
        'senha',
        'dt_ultimo_acesso',
        'ip_ultimo_acesso'
    ];

    protected $returnType = 'object';
}