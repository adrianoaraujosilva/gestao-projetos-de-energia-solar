<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ClienteFilter extends QueryFilter
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

    public function email($email)
    {
        return $this->builder->where('clientes.email', 'LIKE', "%$email%");
    }

    public function telefone($telefone)
    {
        return $this->builder->where('clientes.telefone', 'LIKE', "%$telefone%");
    }

    public function cpf_cnpj($cpfCnpj)
    {
        return $this->builder->where('clientes.cpf_cnpj', 'LIKE', "%$cpfCnpj%");
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
