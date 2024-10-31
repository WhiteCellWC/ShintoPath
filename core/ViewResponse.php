<?php

namespace Core;

class ViewResponse
{
    protected $path = __DIR__ . '/../resources/views/';

    protected $attributes;

    public function __construct($view, $attributes)
    {
        $this->path .= $view;
        $this->attributes = $attributes;
    }

    public function view()
    {
        extract($this->attributes);
        $with = Session::getWith();
        if (boolval($with)) extract($with);
        return require $this->path;
    }

    public function with(array | string $data, $value = null)
    {
        if (gettype($data) === "array") {
            foreach ($data as $key => $value) {
                Session::with($key, $value);
            }
        } else {
            Session::with($data, $value);
        }
        return $this;
    }
}
