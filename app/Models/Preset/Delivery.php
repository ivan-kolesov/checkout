<?php declare(strict_types=1);

namespace Models\Preset;

use Models\Basket3;

class Delivery implements Contract
{
    private $type;
    private $offerId;
    private $pickupLocationId;
    private $address;

    public function __construct(Basket3 $basketContainer)
    {
        $this->type = (string)$basketContainer->getDeliveryType();
        $this->offerId = $basketContainer->getDeliveryOfferId();
        $this->pickupLocationId = $basketContainer->getPickupLocationId();
        $this->address = $basketContainer->getDeliveryAddress();
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getOfferId(): ?string
    {
        return $this->offerId;
    }

    public function getPickupLocationId(): ?string
    {
        return $this->pickupLocationId;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }
}