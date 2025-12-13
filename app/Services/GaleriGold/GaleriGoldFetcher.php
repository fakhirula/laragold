<?php

namespace App\Services\GaleriGold;

use App\Services\GaleriGold\Contracts\PriceFetcherInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GaleriGoldFetcher implements PriceFetcherInterface
{
    public function __construct(private readonly string $url)
    {
    }

    public function fetch(): ?string
    {
        try {
            $response = Http::timeout(30)->get($this->url);
            if ($response->failed()) {
                Log::error('GaleriGoldFetcher failed: HTTP '.$response->status());
                return null;
            }
            return $response->body();
        } catch (\Throwable $e) {
            Log::error('GaleriGoldFetcher exception: '.$e->getMessage());
            return null;
        }
    }
}
