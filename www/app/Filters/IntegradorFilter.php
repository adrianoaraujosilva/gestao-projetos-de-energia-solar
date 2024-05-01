<?php

namespace App\Filters;

use Illuminate\Http\Request;

class IntegradorFilter extends QueryFilter
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function id($id)
    {
        return $this->builder->where('integradores.id', $id);
    }

    public function nome($nome)
    {
        return $this->builder->where('integradores.nome', 'LIKE', "%$nome%");
    }

    public function email($email)
    {
        return $this->builder->where('integradores.email', 'LIKE', "%$email%");
    }

    public function tipo($tipo)
    {
        return $this->builder->where('integradores.tipo', 'LIKE', "%$tipo%");
    }

    public function ativo($ativo)
    {
        return $this->builder->where('integradores.ativo', $ativo);
    }

    public function ordenar_id($type = null)
    {
        return $this->builder->orderBy('integradores.id', (!$type || $type == 'asc') ? 'desc' : 'asc');
    }

    public function ordenar_nome($type = null)
    {
        return $this->builder->orderBy('integradores.nome', (!$type || $type == 'asc') ? 'desc' : 'asc');
    }
}
