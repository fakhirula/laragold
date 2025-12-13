<?php

namespace App\Services;

use App\Services\GaleriGold\Contracts\PriceFetcherInterface;
use App\Services\GaleriGold\Contracts\PriceParserInterface;
use App\Services\GaleriGold\Contracts\PricePersisterInterface;
use Illuminate\Support\Facades\Log;

class GaleriGoldScraper
{
    public function __construct(
        private readonly PriceFetcherInterface $fetcher,
        private readonly PriceParserInterface $parser,
        private readonly PricePersisterInterface $persister
    ) {
    }

    public function scrape(): array
    {
        try {
            $html = $this->fetcher->fetch();
            if (!$html) {
                throw new \RuntimeException('Failed to fetch webpage');
            }

            $snapshots = $this->parser->parse($html);
            if (empty($snapshots)) {
                throw new \RuntimeException('No prices parsed from page');
            }

            $this->persister->persist($snapshots);

            return [
                'success' => true,
                'message' => 'Scraping completed successfully',
                'total_records' => count($snapshots),
            ];
        } catch (\Throwable $e) {
            Log::error('GaleriGoldScraper error: '.$e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
