<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Integrador extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Filterable;

    public const ACCESS_ADMIN       = 'ADMIN';
    public const ACCESS_INTEGRATOR  = 'INTEGRADOR';
    public $access = self::ACCESS_ADMIN | self::ACCESS_INTEGRATOR;

    protected $table = 'integradores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'email',
        'tipo',
        'ativo',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function cliente()
    {
        return $this->hasMany(Cliente::class, 'integrador_id', 'id');
    }

    public function scopeProjeto($query)
    {
        return $query->join('clientes', 'integradores.id', '=', 'clientes.integrador_id')
            ->join('projetos', 'clientes.id', '=', 'projetos.cliente_id')
            ->select(['projetos.*', 'integradores.id as integrador_id']);
    }

    public function scopeIsAdmin($query)
    {
        return $this->tipo === $this::ACCESS_ADMIN;
    }

    public function scopeIsActive($query)
    {
        return $this->ativo === 1;
    }
}
