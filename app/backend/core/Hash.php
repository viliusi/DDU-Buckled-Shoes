<?php

class Hash
{
    public static function make($string, $salt = null)
    {
        if ($salt === null) {
            $salt = self::salt();
        }

        return hash(Config::get('hash/algo_name'), $string . $salt);
    }

    public static function salt($length = 32)
    {
        return bin2hex(random_bytes($length));
    }

    public static function unique()
    {
        return self::make(uniqid());
    }
}
