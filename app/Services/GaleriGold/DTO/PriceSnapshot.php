<?php

namespace App\Services\GaleriGold\DTO;

use Carbon\Carbon;

class PriceSnapshot
{
    public function __construct(
        public readonly string $brand,
        public readonly float $weight,
        public readonly float $sellPrice,
        public readonly float $buyPrice,
        public readonly Carbon $recordedAt
    ) {
    }
}
