<?php

class StringTools
{
    public function capitalize($str)
    {
        if (!is_scalar($str) || is_numeric($str)) {
            throw new InvalidArgumentException('Capitalize only accepts strings!');
        }

        return ucwords(strtolower($str));
    }
}