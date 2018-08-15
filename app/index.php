<?php declare(strict_types=1);

use Basket\Presetting\Repositories\RepositoryFactory;
use Basket\Presetting\StoredPreset;

$basketContainer = new \Models\Basket3();
$request = new Illuminate\Http\Request();

try {
    $repository = RepositoryFactory::create($basketContainer, $request);
    $preset = $repository->store();

    // store preset
    app('BasketPresetService')->store($preset);

    // restore preset
    $preset = new StoredPreset($repository);
    $preset->populate();
} catch (RuntimeException $exception) {
}