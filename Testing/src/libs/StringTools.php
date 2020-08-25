<?php

declare(strict_types=1);

namespace App\libs;

class StringTools
{
    public function capitalize($str): string
    {
        if (!is_scalar($str) || is_numeric($str)) {
            throw new \InvalidArgumentException('Capitalize only accepts strings!');
        }

        return ucwords(strtolower($str));
    }
}