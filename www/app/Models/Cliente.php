<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory, Filterable;

    protected $fillable = ['integrador_id', 'nome', 'email', 'telefone', 'cpf_cnpj'];

    public static  function boot()
    {
        parent::boot();

        // Injeta ID do usuário como código do integrador para o cliente
        if (auth()->hasUser()) {
            static::creating(function ($model) {
                $model->integrador_id = auth()->user()->id;
            });
        }

        // Se não for ADM, Injeta ID do usuário como código do integrador para filtrar
        if (auth()->hasUser() && !auth()->user()->isAdmin()) {
            static::addGlobalScope('integrador_id', function (Builder $builder) {
                $builder->where('integrador_id', auth()->user()->id);
            });
        }
    }

    public function integrador()
    {
        return $this->hasOne(Integrador::class, 'id', 'integrador_id');
    }

    protected function cpfCnpj(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => preg_replace('/\D/', '', ($value)),
        );
    }
}
