<?php declare(strict_types=1);

namespace Models\Preset;

use Models\Basket3;

interface Contract
{
    public function __construct(Basket3 $basketContainer);
}