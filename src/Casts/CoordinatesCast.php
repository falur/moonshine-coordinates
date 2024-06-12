<?php

declare(strict_types=1);

namespace GianTiaga\MoonshineCoordinates\Casts;

use GianTiaga\MoonshineCoordinates\Dto\CoordinatesDto;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class CoordinatesCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return CoordinatesDto::fromArray(json_decode($value, true));
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        /** @var CoordinatesDto $value */

        return $value->toJson();
    }
}
