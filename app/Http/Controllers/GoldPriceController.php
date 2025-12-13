<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

/**
 * Contoh Controller untuk menggunakan data emas yang sudah di-scrape
 */
class GoldPriceController extends Controller
{
    /**
     * Get harga emas untuk semua brand
     * GET /api/gold/prices
     */
    public function getAllPrices()
    {
        $brands = Brand::with(['products.latestSellPrice', 'products.latestBuyPrice'])
            ->get()
            ->map(function ($brand) {
                return [
                    'brand' => $brand->name,
                    'products' => $brand->products->map(function ($product) {
                        return [
                            'name' => $product->name,
                            'weight_g' => $product->weight_g,
                            'sell_price_per_gram' => $product->latestSellPrice?->sell_price_per_gram,
                            'buy_price_per_gram' => $product->latestBuyPrice?->buy_price_per_gram,
                        ];
                    })->toArray(),
                ];
            });

        return response()->json($brands);
    }

    /**
     * Get harga untuk brand tertentu
     * GET /api/gold/prices/{brand}
     */
    public function getPricesByBrand($brandName)
    {
        $brand = Brand::where('name', $brandName)
            ->with(['products.latestSellPrice', 'products.latestBuyPrice'])
            ->firstOrFail();

        return response()->json([
            'brand' => $brand->name,
            'products' => $brand->products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'weight_g' => $product->weight_g,
                    'purity_pct' => $product->purity_pct,
                    'sell_price_per_gram' => $product->latestSellPrice?->sell_price_per_gram,
                    'buy_price_per_gram' => $product->latestBuyPrice?->buy_price_per_gram,
                    'sell_price_total' => $product->weight_g * ($product->latestSellPrice?->sell_price_per_gram ?? 0),
                    'buy_price_total' => $product->weight_g * ($product->latestBuyPrice?->buy_price_per_gram ?? 0),
                ];
            })->toArray(),
        ]);
    }

    /**
     * Bandingkan harga antar brand untuk berat yang sama
     * GET /api/gold/compare?weight=1
     */
    public function comparePrice(Request $request)
    {
        $weight = $request->query('weight', 1);

        $products = Product::where('weight_g', $weight)
            ->with('brand', 'latestSellPrice', 'latestBuyPrice')
            ->orderBy('latestSellPrice.sell_price_per_gram')
            ->get()
            ->map(function ($product) {
                return [
                    'brand' => $product->brand->name,
                    'weight_g' => $product->weight_g,
                    'sell_price_per_gram' => $product->latestSellPrice?->sell_price_per_gram,
                    'buy_price_per_gram' => $product->latestBuyPrice?->buy_price_per_gram,
                    'spread' => ($product->latestSellPrice?->sell_price_per_gram ?? 0) - ($product->latestBuyPrice?->buy_price_per_gram ?? 0),
                ];
            });

        return response()->json([
            'weight_g' => $weight,
            'brands' => $products->toArray(),
            'cheapest' => $products->first(),
            'most_expensive' => $products->last(),
        ]);
    }

    /**
     * Hitung total harga untuk membeli sejumlah emas
     * GET /api/gold/calculate?brand=Galeri24&weight=1&quantity=10
     */
    public function calculatePrice(Request $request)
    {
        $brandName = $request->query('brand');
        $weight = $request->query('weight');
        $quantity = $request->query('quantity', 1);

        $product = Product::whereHas('brand', function ($query) use ($brandName) {
            $query->where('name', $brandName);
        })
            ->where('weight_g', $weight)
            ->with('brand', 'latestSellPrice')
            ->firstOrFail();

        $pricePerItem = $product->weight_g * ($product->latestSellPrice?->sell_price_per_gram ?? 0);
        $totalPrice = $pricePerItem * $quantity;

        return response()->json([
            'brand' => $product->brand->name,
            'product' => $product->name,
            'weight_g' => $product->weight_g,
            'price_per_gram' => $product->latestSellPrice?->sell_price_per_gram,
            'price_per_item' => $pricePerItem,
            'quantity' => $quantity,
            'total_price' => $totalPrice,
            'recorded_at' => $product->latestSellPrice?->recorded_at,
        ]);
    }

    /**
     * Get statistik harga
     * GET /api/gold/stats
     */
    public function getStats()
    {
        $brands = Brand::with('products.latestSellPrice')->get();

        $stats = $brands->map(function ($brand) {
            $prices = $brand->products
                ->pluck('latestSellPrice.sell_price_per_gram')
                ->filter()
                ->toArray();

            return [
                'brand' => $brand->name,
                'product_count' => $brand->products->count(),
                'avg_price_per_gram' => count($prices) > 0 ? array_sum($prices) / count($prices) : 0,
                'min_price_per_gram' => count($prices) > 0 ? min($prices) : 0,
                'max_price_per_gram' => count($prices) > 0 ? max($prices) : 0,
            ];
        });

        return response()->json($stats);
    }
}

/**
 * ROUTES UNTUK MENAMBAHKAN KE routes/api.php:
 *
 * Route::prefix('gold')->group(function () {
 *     Route::get('/prices', [GoldPriceController::class, 'getAllPrices']);
 *     Route::get('/prices/{brand}', [GoldPriceController::class, 'getPricesByBrand']);
 *     Route::get('/compare', [GoldPriceController::class, 'comparePrice']);
 *     Route::get('/calculate', [GoldPriceController::class, 'calculatePrice']);
 *     Route::get('/stats', [GoldPriceController::class, 'getStats']);
 * });
 */
