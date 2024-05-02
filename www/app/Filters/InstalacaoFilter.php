<?php

namespace App\Filters;

use Illuminate\Http\Request;

class InstalacaoFilter extends QueryFilter
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
        return $this->builder->where('clientes.nome', 'LIKE', "%$nome%");
    }

    public function ordenar_id($type = null)
    {
        return $this->builder->orderBy('clientes.id', (!$type || $type == 'asc') ? 'desc' : 'asc');
    }

    public function ordenar_nome($type = null)
    {
        return $this->builder->orderBy('clientes.nome', (!$type || $type == 'asc') ? 'desc' : 'asc');
    }
}
