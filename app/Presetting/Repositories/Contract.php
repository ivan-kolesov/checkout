<?php declare(strict_types=1);

namespace Basket\Presetting\Repositories;

use Models\Preset\Preset;

interface Contract
{
    public function store(): Preset;

    public function restore(Preset $preset): void;
}