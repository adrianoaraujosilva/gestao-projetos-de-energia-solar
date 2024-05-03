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
        static::creating(function ($model) {
            if (auth()->hasUser()) {
                $model->integrador_id = auth()->user()->id;
            }
        });

        // Se não for ADM, Injeta ID do usuário como código do integrador para filtrar
        static::addGlobalScope('integrador_id', function (Builder $builder) {
            if (auth()->hasUser() && !auth()->user()->isAdmin()) {
                $builder->where('integrador_id', auth()->user()->id);
            }
        });
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
