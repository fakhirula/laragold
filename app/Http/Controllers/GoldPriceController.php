<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Price;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

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
        $brands = Brand::with('products')->orderBy('name')->get();

        $results = $brands->map(function ($brand) {
            return [
                'brand' => $brand->name,
                'products' => $brand->products->map(function ($product) {
                    $sell = Price::where('product_id', $product->id)
                        ->where('price_type', 'sell')
                        ->orderByDesc('recorded_at')
                        ->first();

                    $buy = Price::where('product_id', $product->id)
                        ->where('price_type', 'buy')
                        ->orderByDesc('recorded_at')
                        ->first();

                    return [
                        'name' => $product->name,
                        'weight_g' => $product->weight_g,
                        'sell_price_per_gram' => $sell?->price_per_gram,
                        'buy_price_per_gram' => $buy?->price_per_gram,
                    ];
                })->toArray(),
            ];
        });

        return response()->json($results);
    }

    /**
     * Get harga untuk brand tertentu
     * GET /api/gold/prices/{brand}
     */
    public function getPricesByBrand($brandName)
    {
        $brand = Brand::where('name', $brandName)
            ->with('products')
            ->firstOrFail();

        return response()->json([
            'brand' => $brand->name,
            'products' => $brand->products->map(function ($product) {
                $sell = Price::where('product_id', $product->id)
                    ->where('price_type', 'sell')
                    ->orderByDesc('recorded_at')
                    ->first();

                $buy = Price::where('product_id', $product->id)
                    ->where('price_type', 'buy')
                    ->orderByDesc('recorded_at')
                    ->first();

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'weight_g' => $product->weight_g,
                    'purity_pct' => $product->purity_pct,
                    'sell_price_per_gram' => $sell?->price_per_gram,
                    'buy_price_per_gram' => $buy?->price_per_gram,
                    'sell_price_total' => $product->weight_g * ($sell?->price_per_gram ?? 0),
                    'buy_price_total' => $product->weight_g * ($buy?->price_per_gram ?? 0),
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
            ->with('brand')
            ->orderBy('id')
            ->get()
            ->map(function ($product) {
                $sell = Price::where('product_id', $product->id)
                    ->where('price_type', 'sell')
                    ->orderByDesc('recorded_at')
                    ->first();

                $buy = Price::where('product_id', $product->id)
                    ->where('price_type', 'buy')
                    ->orderByDesc('recorded_at')
                    ->first();

                return [
                    'brand' => $product->brand->name,
                    'weight_g' => $product->weight_g,
                    'sell_price_per_gram' => $sell?->price_per_gram,
                    'buy_price_per_gram' => $buy?->price_per_gram,
                    'spread' => ($sell?->price_per_gram ?? 0) - ($buy?->price_per_gram ?? 0),
                ];
            });

        return response()->json([
            'weight_g' => $weight,
            'brands' => $products->toArray(),
            'cheapest' => $products->sortBy('sell_price_per_gram')->first(),
            'most_expensive' => $products->sortByDesc('sell_price_per_gram')->first(),
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
            ->with('brand')
            ->firstOrFail();

        $sell = Price::where('product_id', $product->id)
            ->where('price_type', 'sell')
            ->orderByDesc('recorded_at')
            ->first();

        $pricePerItem = $product->weight_g * ($sell?->price_per_gram ?? 0);
        $totalPrice = $pricePerItem * $quantity;

        return response()->json([
            'brand' => $product->brand->name,
            'product' => $product->name,
            'weight_g' => $product->weight_g,
            'price_per_gram' => $sell?->price_per_gram,
            'price_per_item' => $pricePerItem,
            'quantity' => $quantity,
            'total_price' => $totalPrice,
            'recorded_at' => $sell?->recorded_at,
        ]);
    }

    /**
     * Get statistik harga
     * GET /api/gold/stats
     */
    public function getStats()
    {
        $brands = Brand::with('products')->get();

        $stats = $brands->map(function ($brand) {
            $prices = $brand->products->map(function ($product) {
                return Price::where('product_id', $product->id)
                    ->where('price_type', 'sell')
                    ->orderByDesc('recorded_at')
                    ->first();
            })
            ->filter()
            ->pluck('price_per_gram')
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

    /**
     * Get today's 1g prices per brand (Asia/Jakarta)
     * GET /api/gold/today
     */
    public function today(): JsonResponse
    {
        $now = Carbon::now('Asia/Jakarta');
        $start = $now->copy()->startOfDay();
        $end = $now->copy()->endOfDay();

        $brands = Brand::orderBy('name')->get();
        $out = [];

        foreach ($brands as $brand) {
            $product = Product::where('brand_id', $brand->id)->where('weight_g', 1.0)->first();
            if (!$product) {
                continue;
            }

            $sell = Price::where('product_id', $product->id)
                ->where('price_type', 'sell')
                ->whereBetween('recorded_at', [$start, $end])
                ->orderByDesc('recorded_at')
                ->first();

            $buy = Price::where('product_id', $product->id)
                ->where('price_type', 'buy')
                ->whereBetween('recorded_at', [$start, $end])
                ->orderByDesc('recorded_at')
                ->first();

            if ($sell || $buy) {
                $out[] = [
                    'brand' => $brand->name,
                    'product' => [
                        'id' => $product->id,
                        'name' => $product->name,
                        'weight_g' => $product->weight_g,
                    ],
                    'sell' => $sell ? [
                        'price_per_gram' => (float) $sell->price_per_gram,
                        'recorded_at' => $sell->recorded_at->timezone('Asia/Jakarta')->toDateTimeString(),
                    ] : null,
                    'buy' => $buy ? [
                        'price_per_gram' => (float) $buy->price_per_gram,
                        'recorded_at' => $buy->recorded_at->timezone('Asia/Jakarta')->toDateTimeString(),
                    ] : null,
                ];
            }
        }

        return response()->json([
            'date' => $now->toDateString(),
            'timezone' => 'Asia/Jakarta',
            'data' => $out,
        ]);
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
 *     Route::get('/today', [GoldPriceController::class, 'today']);
 * });
 */
