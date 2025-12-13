<?php

namespace App\Services\GaleriGold\Contracts;

interface PriceFetcherInterface
{
    public function fetch(): ?string;
}
