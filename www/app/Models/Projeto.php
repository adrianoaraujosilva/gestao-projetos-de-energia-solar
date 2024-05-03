<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Projeto extends Model
{
    use HasFactory, Filterable;

    public const UF  = [
        'AC',
        'AL',
        'AP',
        'AM',
        'BA',
        'CE',
        'DF',
        'ES',
        'GO',
        'MA',
        'MT',
        'MS',
        'MG',
        'PA',
        'PB',
        'PR',
        'PE',
        'PI',
        'RJ',
        'RN',
        'RS',
        'RO',
        'RR',
        'SC',
        'SP',
        'SE',
        'TO'
    ];
    public $access = self::UF;

    protected $fillable = ['nome', 'cliente_id', 'uf', 'instalacao_id'];

    public static  function boot()
    {
        parent::boot();

        // Se não for ADM, Injeta ID do usuário como código do integrador para filtrar
        if (auth()->hasUser() && !auth()->user()->isAdmin()) {
            static::addGlobalScope(function (Builder $builder) {
                $builder->whereHas('cliente', function ($query) {
                    $query->where("integrador_id", auth()->user()->id);
                });
            });
        }
    }

    public function equipamentos()
    {
        return $this->belongsToMany(Equipamento::class, 'equipamentos_projetos', 'projeto_id', 'equipamento_id')
            ->withPivot(["id", "quantidade", "descricao"])
            ->withTimestamps();
    }

    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'id', 'cliente_id');
    }

    public function instalacao()
    {
        return $this->hasOne(Instalacao::class, 'id', 'instalacao_id');
    }
}
