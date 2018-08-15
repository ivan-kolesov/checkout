<?php declare(strict_types=1);

namespace Basket\Presetting\Repositories;

use App\Providers\BasketPresetService;
use Illuminate\Http\Request;
use Models\Basket3;

class RepositoryFactory
{
    /**
     * @param Basket3 $basketContainer
     * @param Request $request
     * @return Base
     * @throws \RuntimeException
     */
    public static function create(Basket3 $basketContainer, Request $request): Base
    {
        if ((bool)$request->get('isAuthorized') && !app('BasketPresetService')->get()->isEmpty()) {
            return new Authorized($basketContainer, $request);
        }

        if ($request->cookies->has(BasketPresetService::PICKUP_LOCATION_COOKIE)) {
            return new Unauthorized($basketContainer, $request);
        }

        throw new \RuntimeException('Repository does not match');
    }
}