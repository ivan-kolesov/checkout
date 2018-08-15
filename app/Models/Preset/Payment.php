<?php declare(strict_types=1);

namespace Models\Preset;

use Models\Basket3;

class Payment implements Contract
{
    private $type;

    public function __construct(Basket3 $basketContainer)
    {
        $this->type = (string)$basketContainer->getPaymentTypeId();
    }

    public function getType(): string
    {
        return $this->type;
    }
}