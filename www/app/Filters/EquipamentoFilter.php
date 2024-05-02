<?php

namespace App\Filters;

use Illuminate\Http\Request;

class EquipamentoFilter extends QueryFilter
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function id($id)
    {
        return $this->builder->where('equipamentos.id', $id);
    }

    public function nome($nome)
    {
        return $this->builder->where('equipamentos.nome', 'LIKE', "%$nome%");
    }

    public function ordenar_id($type = null)
    {
        return $this->builder->orderBy('equipamentos.id', (!$type || $type == 'asc') ? 'desc' : 'asc');
    }

    public function ordenar_nome($type = null)
    {
        return $this->builder->orderBy('equipamentos.nome', (!$type || $type == 'asc') ? 'desc' : 'asc');
    }
}
