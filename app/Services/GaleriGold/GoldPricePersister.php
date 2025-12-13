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
        // Group snapshots by brand
        $byBrand = [];
        foreach ($snapshots as $s) {
            if ($s instanceof PriceSnapshot) {
                $byBrand[$s->brand][] = $s;
            }
        }

        foreach ($byBrand as $brandName => $items) {
            try {
                // Prefer exact 1g snapshot
                $exact = null;
                foreach ($items as $it) {
                    if (abs($it->weight - 1.0) < 0.0001) {
                        $exact = $it;
                        break;
                    }
                }

                // If not found, pick the first available and compute 1g using per-gram
                $source = $exact ?? $items[0];

                $brand = Brand::firstOrCreate(
                    ['name' => $brandName],
                    ['metal_type' => 'Gold']
                );

                // Ensure product is 1g only
                $product = Product::firstOrCreate(
                    [
                        'brand_id' => $brand->id,
                        'weight_g' => 1.0,
                    ],
                    [
                        'name' => sprintf('%s - 1.0 gram', $brand->name),
                        'purity_pct' => 99.99,
                        'is_physical' => true,
                        'is_active' => true,
                    ]
                );

                // Compute per-gram from source snapshot
                $sellPerGram = $source->sellPrice / $source->weight;
                $buyPerGram = $source->buyPrice / $source->weight;

                // Persist prices for 1g product
                Price::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'price_type' => 'sell',
                        'recorded_at' => $source->recordedAt,
                    ],
                    [
                        'price_per_gram' => $sellPerGram,
                    ]
                );

                Price::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'price_type' => 'buy',
                        'recorded_at' => $source->recordedAt,
                    ],
                    [
                        'price_per_gram' => $buyPerGram,
                    ]
                );

                Log::info(sprintf(
                    'Saved 1g price for %s (source %.2fg): sell Rp%.0f/gram, buy Rp%.0f/gram',
                    $brand->name,
                    $source->weight,
                    $sellPerGram,
                    $buyPerGram
                ));
            } catch (\Throwable $e) {
                Log::error('GoldPricePersister error: '.$e->getMessage());
            }
        }
    }
}
