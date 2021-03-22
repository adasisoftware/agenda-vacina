<?php 
namespace App\Models;

use CodeIgniter\Model;

class AgendamentoModel extends Model{

    protected $table = 'agendamento';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'agenda_id',
        'grupo_id',
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

    public function getListAllData()
    {
        return $this->db->table($this->table)
                        ->select("agendamento.id, agendamento.paciente_id, paciente.nome NomePaciente, agendamento.grupo_id, grupo.nome GrupoNome, agendamento.agenda_id, agenda.data_hora agendaDataHora")  
                        ->join("paciente", "agendamento.paciente_id = paciente.id")
                        ->join("grupo", "agendamento.grupo_id = grupo.id")
                        ->join("agenda", "agendamento.agenda_id = agenda.id")
                        ->get()
                        ->getResult();
    }
}