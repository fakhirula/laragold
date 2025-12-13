<?php

namespace App\Services\GaleriGold\Contracts;

use App\Services\GaleriGold\DTO\PriceSnapshot;

interface PricePersisterInterface
{
    /**
     * @param PriceSnapshot[] $snapshots
     */
    public function persist(array $snapshots): void;
}
