<?php

namespace App\Models;

use CodeIgniter\Model;

class FolhaPagamentoModel extends Model
{
    protected $table = 'folha_pagamento';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nome', 'cpf', 'cargo', 'data_admissao', 'salario',
        'proventos', 'descontos', 'liquido', 'base_inss',
        'base_fgts', 'base_irrf'
    ];
}