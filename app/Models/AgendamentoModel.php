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
        'protocolo',
    ];

    protected $returnType = 'object';

    public function getAgendamentoData(){
        return $this->db->table($this->table)
                        ->select("count(*) qtde, extract(day from date(created_at)) dia")
                        ->where(" EXTRACT( MONTH from created_at ) = EXTRACT( MONTH from CURRENT_DATE ) and EXTRACT( YEAR from created_at ) = EXTRACT( YEAR from CURRENT_DATE )")
                        ->groupBy("created_at")
                        ->orderBy("created_at")
                        ->get()
                        ->getResult();
    }

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
                        ->select("agendamento.id, agendamento.paciente_id, paciente.nome NomePaciente, agendamento.grupo_id, grupo.nome GrupoNome, agendamento.agenda_id, agenda.data_hora agendaDataHora, agendamento.created_at DataCriacao")  
                        ->join("paciente", "agendamento.paciente_id = paciente.id")
                        ->join("grupo", "agendamento.grupo_id = grupo.id")
                        ->join("agenda", "agendamento.agenda_id = agenda.id")
                        ->get()
                        ->getResult();
    }

    public function getListAllDashboard()
    {
        return $this->db->table($this->table)
                        ->select("agendamento.id, agendamento.paciente_id, paciente.nome NomePaciente, agendamento.grupo_id, grupo.nome GrupoNome, agendamento.agenda_id, agenda.data_hora agendaDataHora, agendamento.created_at DataCriacao")  
                        ->join("paciente", "agendamento.paciente_id = paciente.id")
                        ->join("grupo", "agendamento.grupo_id = grupo.id")
                        ->join("agenda", "agendamento.agenda_id = agenda.id")
                        ->orderBy('agendamento.created_at')
                        ->limit(5)
                        ->get()
                        ->getResult();
    }

    public function getListById($id)
    {
        return $this->db->table($this->table)
                        ->select("agendamento.id, agendamento.paciente_id, paciente.nome NomePaciente, paciente.nome_mae, paciente.data_nascimento, paciente.telefone, paciente.cpf, agendamento.grupo_id, grupo.nome GrupoNome, agendamento.agenda_id, agenda.data_hora AgendaDataHora")
                        ->where("agendamento.id = $id" )  
                        ->join("paciente", "agendamento.paciente_id = paciente.id")
                        ->join("grupo", "agendamento.grupo_id = grupo.id")
                        ->join("agenda", "agendamento.agenda_id = agenda.id")
                        ->get()
                        ->getRow();
    }

    public function countAgendados($agenda_id){
        return $this->db->table($this->table)
                    ->select("count(*) agendados")
                    ->where("agenda_id = $agenda_id")
                    ->get()
                    ->getRow()
                    ->agendados;
    }
}