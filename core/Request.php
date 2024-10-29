<?php

namespace Core;

class Request
{
    protected array $data;

    public function __construct($request, $rules = [])
    {
        $this->data = $request;
    }

    public function __get($key)
    {
        return $this->data[$key] ?? null;
    }

    public function all()
    {
        return $this->data;
    }
}
