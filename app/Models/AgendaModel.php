<?php

namespace App\Models;

use CodeIgniter\Model;

class AgendaModel extends Model
{

    protected $table = 'agenda';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'data_hora',
        'vagas',
        'grupo_id'
    ];

    protected $returnType = 'object';

    public function getAll()
    {

        $grupoQuery = $this->db->table('agenda a')
            ->select('a.*, g.nome as grupo_nome')
            ->join('grupo g', 'g.id = a.grupo_id')
            ->get()
            ->getResult();

        return $grupoQuery;
    }
}
