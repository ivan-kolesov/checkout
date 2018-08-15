<?php declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Models\Preset\Preset;

class BasketPresetService extends ServiceProvider
{
    protected $defer = true;

    public const PICKUP_LOCATION_COOKIE = 'lastPickupLocationId';
    public const PAYMENT_TYPE_COOKIE = 'lastPaymentTypeId';

    private const BASKET_SESSION = 'basket.preset.session';
    private const AFFECTED_PRESETS_SESSION = 'basket.presets.affected';

    public function register(): void
    {
        $this->app->bind('BasketPresetService', function () {
            return new self($this->app);
        });
    }

    public function provides(): array
    {
        return ['BasketPresetService'];
    }

    public function get(): Preset
    {
        return session(self::BASKET_SESSION, new Preset());
    }

    public function store(Preset $preset): void
    {
        if (!$preset->isEmpty()) {
            session([self::BASKET_SESSION => $preset]);
        }
    }

    public function remove(): void
    {
        setcookie(self::PICKUP_LOCATION_COOKIE, "", -1, '/');
        setcookie(self::PAYMENT_TYPE_COOKIE, "", -1, '/');

        session()->forget(self::BASKET_SESSION);
    }

    public function getAffectedPresets(): Collection
    {
        return session(self::AFFECTED_PRESETS_SESSION, collect());
    }

    public function storeAffectedPresets(Collection $collection): void
    {
        session([self::AFFECTED_PRESETS_SESSION => $collection]);
    }

    public function removeAffectedPresets(): void
    {
        session()->forget(self::AFFECTED_PRESETS_SESSION);
    }
}