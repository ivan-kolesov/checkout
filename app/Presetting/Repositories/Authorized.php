<?php declare(strict_types=1);

namespace Basket\Presetting\Repositories;

use Models\Preset\Contacts;
use Models\Preset\Delivery;
use Models\Preset\Payment;
use Models\Preset\Preset;

class Authorized extends Base
{
    public function store(): Preset
    {
        $preset = parent::store()
            ->setContacts(new Contacts($this->basketContainer));

        parent::storePickupLocationAtCookie();
        parent::storePaymentAtCookie();

        return $preset
            ->setDelivery(new Delivery($this->basketContainer))
            ->setPayment(new Payment($this->basketContainer));
    }

    public function restore(Preset $preset): void
    {
        if ($preset->isEmpty()) {
            return;
        }

        if ($preset->getContacts() !== null) {
            $this->restoreContacts($preset->getContacts());
        }

        if ($preset->getDelivery() !== null) {
            $this->restoreDelivery($preset->getDelivery());
        }

        if ($preset->getPayment() !== null) {
            $this->restorePayment($preset->getPayment());
        }
    }

    private function restoreContacts(Contacts $contacts): void
    {
        // some logic restore contact  data

        parent::addAffectedPreset($contacts);
    }

    private function restoreDelivery(Delivery $delivery): void
    {
        // some logic restore delivery data

        if (!parent::hasErrors()) {
            parent::addAffectedPreset($delivery);
        }
    }

    private function restorePayment(Payment $payment): void
    {
        // some logic restore payment data

        parent::addAffectedPreset($payment);
    }
}