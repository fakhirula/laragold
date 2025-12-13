<?php

namespace App\Services\GaleriGold;

use App\Models\Brand;
use App\Models\Price;
use App\Models\Product;
use App\Services\GaleriGold\Contracts\PricePersisterInterface;
use App\Services\GaleriGold\DTO\PriceSnapshot;
use Illuminate\Support\Facades\Log;

class GoldPricePersister implements PricePersisterInterface
{
    /**
     * @param PriceSnapshot[] $snapshots
     */
    public function persist(array $snapshots): void
    {
        foreach ($snapshots as $snapshot) {
            if (!($snapshot instanceof PriceSnapshot)) {
                continue;
            }

            try {
                $brand = Brand::firstOrCreate(
                    ['name' => $snapshot->brand],
                    ['metal_type' => 'Gold']
                );

                $product = Product::firstOrCreate(
                    [
                        'brand_id' => $brand->id,
                        'weight_g' => $snapshot->weight,
                    ],
                    [
                        'name' => sprintf('%s - %.1f gram', $brand->name, $snapshot->weight),
                        'purity_pct' => 99.99,
                        'is_physical' => true,
                        'is_active' => true,
                    ]
                );

                // Upsert sell
                Price::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'price_type' => 'sell',
                        'recorded_at' => $snapshot->recordedAt,
                    ],
                    [
                        'price_per_gram' => $snapshot->sellPrice / $snapshot->weight,
                    ]
                );

                // Upsert buy
                Price::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'price_type' => 'buy',
                        'recorded_at' => $snapshot->recordedAt,
                    ],
                    [
                        'price_per_gram' => $snapshot->buyPrice / $snapshot->weight,
                    ]
                );

                Log::info(sprintf(
                    'Saved price: %s - %.1fg (sell: Rp%.0f, buy: Rp%.0f)',
                    $brand->name,
                    $snapshot->weight,
                    $snapshot->sellPrice,
                    $snapshot->buyPrice
                ));
            } catch (\Throwable $e) {
                Log::error('GoldPricePersister error: '.$e->getMessage());
            }
        }
    }
}
