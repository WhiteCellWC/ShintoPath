<?php

namespace Core;

class RedirectResponse
{
    protected string $url;
    protected $data;
    public function __construct(string $url = null)
    {
        if ($url) {
            $this->url = $url;
        }
    }

    public function route($name)
    {
        $route = Router::matchWithName($name);
        if ($route) $this->url = $route['url'];
        return $this;
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

    public function redirect()
    {
        header("location: {$this->url}");
        exit();
    }
}
