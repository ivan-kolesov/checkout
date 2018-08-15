<?php declare(strict_types=1);

namespace Basket\Presetting\Repositories;

use App\Providers\BasketPresetService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Models\Preset\Preset;
use Models\Basket3;

abstract class Base implements Contract
{
    private $ttlSecondsCookie = 2628000;
    protected $request;
    protected $errors = [];
    protected $basketContainer;
    protected $affectedPresets;

    public function __construct(Basket3 $basketContainer, Request $request)
    {
        $this->basketContainer = $basketContainer;
        $this->request = $request;
        $this->affectedPresets = collect();
    }

    public function getAffectedPresets(): Collection
    {
        return $this->affectedPresets;
    }

    final protected function addAffectedPreset(\Models\Preset\Contract $preset): void
    {
        $this->affectedPresets->push(get_class($preset));
    }

    protected function hasErrors(): bool
    {
        return count($this->getErrors()) > 0;
    }

    protected function getErrors(): array
    {
        return $this->errors;
    }

    public function store(): Preset
    {
        app('BasketPresetService')->removeAffectedPresets();

        return new Preset();
    }

    abstract public function restore(Preset $preset): void;

    protected function storePickupLocationAtCookie(): void
    {
        if ($this->basketContainer->getPickupLocationId() !== null) {
            setcookie(BasketPresetService::PICKUP_LOCATION_COOKIE, $this->basketContainer->getPickupLocationId(), time() + $this->ttlSecondsCookie, '/');
        }
    }

    protected function storePaymentAtCookie(): void
    {
        if ($this->basketContainer->getPaymentTypeId() !== null) {
            setcookie(BasketPresetService::PAYMENT_TYPE_COOKIE, $this->basketContainer->getPaymentTypeId(), time() + $this->ttlSecondsCookie, '/');
        }
    }
}