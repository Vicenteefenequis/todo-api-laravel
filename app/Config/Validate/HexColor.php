<?php

namespace App\Config\Validate;

class HexColor
{
    private const VALID_HEX_COLOR_PATTERN = '/^#([A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})$/';

    public static function is_valid(string $color): bool
    {
        return preg_match(self::VALID_HEX_COLOR_PATTERN, $color);
    }
}
