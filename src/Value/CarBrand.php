<?php
declare(strict_types=1);

namespace App\Value;

final class CarBrand
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
