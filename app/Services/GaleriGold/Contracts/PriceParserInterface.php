<?php

namespace App\Services\GaleriGold\Contracts;

use App\Services\GaleriGold\DTO\PriceSnapshot;

interface PriceParserInterface
{
    /**
     * Parse HTML into price snapshots.
     * @return PriceSnapshot[]
     */
    public function parse(string $html): array;
}
