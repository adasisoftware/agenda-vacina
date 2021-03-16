<?php

namespace App\Models;

use CodeIgniter\Model;

class GrupoModel extends Model
{

    protected $table = 'grupo';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nome'];

    protected $returnType = 'object';
}