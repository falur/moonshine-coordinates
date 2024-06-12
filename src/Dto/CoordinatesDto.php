<?php

declare(strict_types=1);

namespace GianTiaga\MoonshineCoordinates\Dto;

readonly class CoordinatesDto
{
    public function __construct(
        public ?float $latitude = null,
        public ?float $longitude = null,
    ) {
    }

    /**
     * @return array{latitude: ?float, longitude: ?float}
     */
    public function toArray(): array
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }

    /**
     * @throws \Exception
     */
    public function toJson(): string
    {
        $json = json_encode($this->toArray());

        if (!$json) {
            throw new \Exception(
                'Can\'t encode json, error: ' . json_last_error_msg()
            );
        }

        return $json;
    }

    /**
     * @param array{latitude?: ?float, longitude?: ?float} $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        if (!isset($data['latitude']) || !isset($data['longitude'])) {
            throw new \InvalidArgumentException('Missing "latitude" or "longitude" property provided');
        }

        return new self(
            latitude: $data['latitude'],
            longitude: $data['longitude'],
        );
    }
}
