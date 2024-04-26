<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = ['nome', 'email', 'telefone', 'cpf_cnpj'];

    protected function cpfCnpj(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => preg_replace('/\D/', '', ($value)),
        );
    }
}
