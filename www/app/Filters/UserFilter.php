<?php

namespace App\Filters;

use Illuminate\Http\Request;

class UserFilter extends QueryFilter
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function name($name)
    {
        return $this->builder->where('users.name', 'LIKE', "%$name%");
    }

    public function email($email)
    {
        return $this->builder->where('users.email', 'LIKE', "%$email%");
    }

    public function type($type)
    {
        return $this->builder->where('users.type', 'LIKE', "%$type%");
    }

    public function active($active)
    {
        return $this->builder->where('users.active', $active);
    }

    public function ordenar_id($type = null)
    {
        return $this->builder->orderBy('users.id', (!$type || $type == 'asc') ? 'desc' : 'asc');
    }

    public function ordenar_name($type = null)
    {
        return $this->builder->orderBy('users.name', (!$type || $type == 'asc') ? 'desc' : 'asc');
    }
}
