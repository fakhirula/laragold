<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Price;
use App\Models\Product;
use App\Models\Brand;

class VerifyPrices extends Command
{
    protected $signature = 'prices:verify';
    protected $description = 'Show counts of brands, products, and prices by type';

    public function handle(): int
    {
        $brandCount = Brand::count();
        $productCount = Product::count();
        $priceCount = Price::count();

        $this->info("Brands: $brandCount");
        $this->info("Products: $productCount");
        $this->info("Prices: $priceCount");

        $byType = Price::selectRaw('price_type, COUNT(*) as c')->groupBy('price_type')->get();
        foreach ($byType as $row) {
            $this->info("Price type {$row->price_type}: {$row->c}");
        }

        return self::SUCCESS;
    }
}
