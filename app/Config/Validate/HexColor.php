<?php

namespace App\Config\Validate;

class HexColor
{
    protected string $color;

    private const VALID_HEX_COLOR_PATTERN = '/^#([A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})$/';

    public function __construct(
        string $color
    )
    {
        $this->color = $color;
    }

    public static function make(string $color): self
    {
        return new self($color);
    }


    public function is_valid(): bool
    {
        return preg_match(self::VALID_HEX_COLOR_PATTERN, $this->color);
    }
}
