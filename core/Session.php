<?php

namespace Core;

class Session
{
    public static function flash($key, $value)
    {
        $_SESSION["_flash"][$key] = $value;
    }

    public static function flashError($key, $value)
    {
        $_SESSION["_flash"]["errors"][$key] = $value;
    }

    public static function unflash()
    {
        unset($_SESSION['_flash']);
    }
}
