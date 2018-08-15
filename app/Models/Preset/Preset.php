<?php declare(strict_types=1);

namespace Models\Preset;

class Preset
{
    private $contacts;
    private $delivery;
    private $payment;

    public function isEmpty(): bool
    {
        return empty($this->contacts) && empty($this->delivery) && empty($this->payment);
    }

    public function getContacts(): ?Contacts
    {
        return $this->contacts;
    }

    public function setContacts(Contacts $contacts): self
    {
        $this->contacts = $contacts;
        return $this;
    }

    public function getDelivery(): ?Delivery
    {
        return $this->delivery;
    }

    public function setDelivery(Delivery $delivery): self
    {
        $this->delivery = $delivery;
        return $this;
    }

    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    public function setPayment(Payment $payment): self
    {
        $this->payment = $payment;
        return $this;
    }
}