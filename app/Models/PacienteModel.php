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
        'idade',
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

    public function count_week()
    {
        return $this->db->table($this->table)
                        ->select("count(*) qtde")
                        ->where("created_at between CURRENT_DATE -7 and CURRENT_DATE")
                        ->get()
                        ->getRow();
    }
}