<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipamentoProjeto extends Model
{
    use HasFactory;

    protected $table = 'equipamentos_projetos';
    protected $fillable = ['projeto_id', 'equipamento_id', 'quantidade', 'descricao'];
}
