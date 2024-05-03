<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipamento extends Model
{
    use HasFactory, Filterable;

    protected $fillable = ['nome'];

    public function projetos()
    {
        return $this->belongsToMany(Projeto::class, 'equipamentos_projetos', 'equipamento_id', 'projeto_id');
    }
}
