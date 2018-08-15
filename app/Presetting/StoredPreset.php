<?php declare(strict_types=1);

namespace Basket\Presetting;

use Basket\Presetting\Repositories;

class StoredPreset
{
    private $repository;

    public function __construct(Repositories\Base $repository)
    {
        $this->repository = $repository;
    }

    public function populate(): StoredPreset
    {
        $preset = app('BasketPresetService')->get();
        $this->repository->restore($preset);

        app('BasketPresetService')->remove();
        app('BasketPresetService')->storeAffectedPresets($this->repository->getAffectedPresets());

        return $this;
    }
}