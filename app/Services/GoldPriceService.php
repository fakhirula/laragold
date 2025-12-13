<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class GoldPriceService
{
    private const API_URL = 'https://pluang.com/api/asset/gold/pricing';
    private const CACHE_KEY = 'gold_prices';
    private const CACHE_DURATION = 300; // 5 minutes

    /**
     * Get current gold prices from API
     *
     * @return array|null
     */
    public function getCurrentPrices(): ?array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_DURATION, function () {
            return $this->fetchPrices(0);
        });
    }

    /**
     * Get historical prices
     *
     * @param int $daysLimit
     * @return array|null
     */
    public function getHistoricalPrices(int $daysLimit = 30): ?array
    {
        return $this->fetchPrices($daysLimit);
    }

    /**
     * Fetch prices from Pluang API
     *
     * @param int $daysLimit
     * @return array|null
     */
    private function fetchPrices(int $daysLimit): ?array
    {
        try {
            $response = Http::timeout(10)->get(self::API_URL, [
                'daysLimit' => $daysLimit,
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if ($data['statusCode'] === 200 && isset($data['data'])) {
                    return $data['data'];
                }
            }

            Log::warning('Failed to fetch gold prices from Pluang API', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Error fetching gold prices from Pluang API', [
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Get formatted current price for display
     *
     * @return array
     */
    public function getFormattedCurrentPrice(): array
    {
        $prices = $this->getCurrentPrices();

        if (!$prices || !isset($prices['current'])) {
            return [
                'buy_price' => 0,
                'sell_price' => 0,
                'spread' => 0,
                'last_updated' => now(),
            ];
        }

        $current = $prices['current'];
        $buyPrice = (float) ($current['buy'] ?? 0);
        $sellPrice = (float) ($current['sell'] ?? 0);

        return [
            'buy_price' => $buyPrice,
            'sell_price' => $sellPrice,
            'spread' => $sellPrice - $buyPrice,
            'spread_percentage' => $buyPrice > 0 ? (($sellPrice - $buyPrice) / $buyPrice) * 100 : 0,
            'last_updated' => $current['updated_at'] ?? now(),
        ];
    }

    /**
     * Get formatted historical prices for chart/table
     *
     * @param int $daysLimit
     * @return array
     */
    public function getFormattedHistoricalPrices(int $daysLimit = 30): array
    {
        $prices = $this->getHistoricalPrices($daysLimit);

        if (!$prices || !isset($prices['history'])) {
            return [];
        }

        return collect($prices['history'])->map(function ($item) {
            return [
                'date' => $item['updated_at'],
                'buy_price' => (float) ($item['buy'] ?? 0),
                'sell_price' => (float) ($item['sell'] ?? 0),
                'spread' => (float) ($item['sell'] ?? 0) - (float) ($item['buy'] ?? 0),
            ];
        })->toArray();
    }

    /**
     * Clear cache manually
     *
     * @return void
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
