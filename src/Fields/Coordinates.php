<?php

declare(strict_types=1);

namespace GianTiaga\MoonshineCoordinates\Fields;

use Closure;
use GianTiaga\MoonshineCoordinates\Dto\CoordinatesDto;
use MoonShine\Contracts\Fields\HasDefaultValue;
use MoonShine\Fields\Field;
use MoonShine\Traits\Fields\WithDefaultValue;

class Coordinates extends Field implements HasDefaultValue
{
    use WithDefaultValue;

    /**
     * @var string
     */
    protected string $view = 'gt-moonshine-coordinates::coordinates';

    /**
     * @var string[]
     */
    protected array $assets = [
        'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css',
        'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js',
    ];

    protected CoordinatesDto $center;

    /**
     * @var int
     */
    protected int $zoom = 4;

    public function __construct(
        Closure|string|null $label = null,
        ?string $column = null,
        ?Closure $formatted = null
    ) {
        parent::__construct($label, $column, $formatted);

        $this->center(
            new CoordinatesDto(
                latitude: 55.751244,
                longitude: 37.618423,
            ),
        );
    }

    /**
     * @param ?CoordinatesDto $center
     * @return static|CoordinatesDto
     */
    public function center(?CoordinatesDto $center = null): static|CoordinatesDto
    {
        if (!$center) {
            return $this->center;
        }

        $this->center = $center;

        return $this;
    }

    /**
     * @param  ?int  $zoom
     * @return $this|int
     */
    public function zoom(?int $zoom = null): static|int
    {
        if (!$zoom) {
            return $this->zoom;
        }

        $this->zoom = $zoom;

        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function resolvePreview(): string
    {
        /** @var CoordinatesDto $value */
        $value = $this->toFormattedValue();

        return $value->toJson();
    }

    /**
     * @param  int|string|null  $index
     * @return mixed
     */
    public function requestValue(int|string|null $index = null): mixed
    {
        /** @var string $result */
        $result = parent::requestValue($index);

        return CoordinatesDto::fromArray(
            json_decode($result, true)
        );
    }
}
