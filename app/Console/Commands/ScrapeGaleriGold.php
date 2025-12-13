<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GaleriGoldScraper;

class ScrapeGaleriGold extends Command
{
    protected $signature = 'scrape:galeri-gold {--force : Force update even if recently scraped}';

    protected $description = 'Scrape gold prices from galeri24.co.id and save to database';

    public function handle(GaleriGoldScraper $scraper): int
    {
        $this->info('Starting Galeri24 gold price scraping...');
        
        $result = $scraper->scrape();
        
        if ($result['success']) {
            $this->info($result['message']);
            $this->info("Total records saved: {$result['total_records']}");
            return self::SUCCESS;
        } else {
            $this->error('Scraping failed: ' . $result['message']);
            return self::FAILURE;
        }
    }
}
