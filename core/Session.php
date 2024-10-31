<?php

namespace Core;

class Session
{
    public static function setKey($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function getKey($key)
    {
        return $_SESSION[$key];
    }
    public static function flash($key, $value)
    {
        $_SESSION["_flash"][$key] = $value;
    }

    public static function with($key, $value)
    {
        $_SESSION["_flash"]["_with"] = [$key => $value];
    }

    public static function getWith()
    {
        return $_SESSION["_flash"]["_with"];
    }

    public static function addError($key, $value)
    {
        $value = isset($_SESSION["_flash"]["errors"][$key]) ? $_SESSION["_flash"]["errors"][$key] . " " . $value : $value;
        $_SESSION["_flash"]["errors"][$key] = $value;
    }

    public static function getError($key)
    {
        return $_SESSION['_flash']['errors'][$key] ?? null;
    }

    public static function addOlds($data)
    {
        foreach ($data as $key => $value) {
            $_SESSION["_flash"]["_old"][$key] = $value;
        }
    }

    public static function getOld($key)
    {
        return $_SESSION['_flash']['_old'][$key] ?? null;
    }

    public static function unflash()
    {
        unset($_SESSION['_flash']);
    }
}
