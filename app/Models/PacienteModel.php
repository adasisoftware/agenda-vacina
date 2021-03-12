<?php 
namespace App\Models;

use CodeIgniter\Model;

class PacienteModel extends Model{

    protected $table = 'paciente';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'cpf',
        'nome',
        'nome_mae',
        'data_nascimento',
        'telefone'
    ];

    protected $returnType = 'object';

    public function count()
    {
        return $this->db->table($this->table)
                        ->select("count(*) qtde")
                        ->get()
                        ->getRow();
    }
}