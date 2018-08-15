<?php declare(strict_types=1);

namespace Basket\Presetting\Repositories;

use App\Providers\BasketPresetService;
use Models\Preset\Delivery;
use Models\Preset\Payment;
use Models\Preset\Preset;

class Unauthorized extends Base
{
    public function store(): Preset
    {
        $preset = parent::store();

        parent::storePickupLocationAtCookie();
        parent::storePaymentAtCookie();

        return $preset;
    }

    public function restore(Preset $preset): void
    {
        if ($this->isEmptyBasketPickupLocation()) {
            $this->restorePickupLocation();
        }

        if ($this->isEmptyBasketPayment() && parent::getAffectedPresets()->contains(Delivery::class)) {
            $this->restorePayment();
        }
    }

    private function restorePickupLocation(): void
    {
        $pickupLocationId = (string)$this->request->cookies->get(BasketPresetService::PICKUP_LOCATION_COOKIE);
        if (!empty($pickupLocationId)) {
            // some logic restore pickup location

            if (!parent::hasErrors()) {
                parent::addAffectedPreset(new Delivery($this->basketContainer));
            }
        }
    }

    private function restorePayment(): void
    {
        $paymentTypeId = (string)$this->request->cookies->get(BasketPresetService::PAYMENT_TYPE_COOKIE);
        if (!empty($paymentTypeId)) {
            // some logic restore payment

            parent::addAffectedPreset(new Payment($this->basketContainer));
        }
    }

    private function isEmptyBasketPickupLocation(): bool
    {
        return $this->basketContainer->getPickupLocationId() === null;
    }

    private function isEmptyBasketPayment(): bool
    {
        return $this->basketContainer->getPaymentTypeId() === null;
    }
}