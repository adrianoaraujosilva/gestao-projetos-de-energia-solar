<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ProjetoFilter extends QueryFilter
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function id($id)
    {
        return $this->builder->where('projetos.id', $id);
    }

    public function nome($nome)
    {
        return $this->builder->where('projetos.nome', 'LIKE', "%$nome%");
    }

    public function cliente_nome($clienteNome)
    {
        return $this->builder->whereHas('cliente', fn ($query) => $query->where('nome', 'LIKE', "%$clienteNome%"));
    }

    public function uf($uf)
    {
        return $this->builder->where('projetos.uf', $uf);
    }

    public function instalacao_nome($instalacaoNome)
    {
        return $this->builder->whereHas('instalacao', fn ($query) => $query->where('nome', 'LIKE', "%$instalacaoNome%"));
    }

    public function equipamento_nome($equipamentoNome)
    {
        return $this->builder->whereHas('equipamentos', fn ($query) => $query->where('nome', 'LIKE', "%$equipamentoNome%"));
    }

    public function ordenar_id($type = null)
    {
        return $this->builder->orderBy('projetos.id', (!$type || $type == 'asc') ? 'desc' : 'asc');
    }

    public function ordenar_nome($type = null)
    {
        return $this->builder->orderBy('projetos.nome', (!$type || $type == 'asc') ? 'desc' : 'asc');
    }
}
