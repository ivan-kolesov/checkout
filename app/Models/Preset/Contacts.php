<?php declare(strict_types=1);

namespace Models\Preset;

use Models\Basket3;

class Contacts implements Contract
{
    private $name;
    private $phone;
    private $email;

    public function __construct(Basket3 $basketContainer)
    {
        $this->name = $basketContainer->getName();
        $this->phone = $basketContainer->getPhone();
        $this->email = $basketContainer->getEmail();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}