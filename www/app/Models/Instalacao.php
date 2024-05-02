<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instalacao extends Model
{
    use HasFactory, Filterable;

    protected $table = 'instalacoes';
    protected $fillable = ['nome'];
}
