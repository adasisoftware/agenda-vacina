<?php 
namespace App\Models;

use CodeIgniter\Model;

class AgendamentoModel extends Model{

    protected $table = 'agendamento';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'agenda_id',
        'paciente_id',
        'usuario_id',
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