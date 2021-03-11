<?php 
namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model{

    protected $table = 'usuario';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nome',
        'email',
        'senha'
    ];

    protected $returnType = 'object';
}