<?php

declare(strict_types=1);

namespace GianTiaga\MoonshineCoordinates\Casts;

use GianTiaga\MoonshineCoordinates\Dto\CoordinatesDto;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * @implements CastsAttributes<CoordinatesDto, ?string>
 */
class CoordinatesCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        /** @var ?string $value */
        if (!$value) {
            return new CoordinatesDto();
        }

        $value = json_decode($value, true);
        if (!$value) {
            throw new \Exception(
                'Can\'t encode json, error: ' . json_last_error_msg()
            );
        }

        /** @var array{latitude: ?float, longitude: ?float} $value */
        return CoordinatesDto::fromArray($value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (!$value) {
            return null;
        }

        /** @var CoordinatesDto $value */

        return $value->toJson();
    }
}
