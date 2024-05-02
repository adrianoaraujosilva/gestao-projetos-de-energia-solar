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
        return $this->builder->where('instalacoes.id', $id);
    }

    public function nome($nome)
    {
        return $this->builder->where('instalacoes.nome', 'LIKE', "%$nome%");
    }

    public function ordenar_id($type = null)
    {
        return $this->builder->orderBy('instalacoes.id', (!$type || $type == 'asc') ? 'desc' : 'asc');
    }

    public function ordenar_nome($type = null)
    {
        return $this->builder->orderBy('instalacoes.nome', (!$type || $type == 'asc') ? 'desc' : 'asc');
    }
}
