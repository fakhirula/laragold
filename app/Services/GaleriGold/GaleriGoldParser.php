<?php

namespace App\Services\GaleriGold;

use App\Services\GaleriGold\Contracts\PriceParserInterface;
use App\Services\GaleriGold\DTO\PriceSnapshot;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

class GaleriGoldParser implements PriceParserInterface
{
    private const BRAND_MAPPING = [
        'GALERI 24' => 'Galeri24',
        'UBS' => 'UBS',
        'ANTAM' => 'Antam',
        'LOTUS ARCHI' => 'Lotus Archi',
    ];

    public function parse(string $html): array
    {
        $crawler = new Crawler($html);
        $snapshots = [];

        try {
            $sections = $crawler->filter('div[id]');
            $sections->each(function (Crawler $section) use (&$snapshots) {
                $sectionId = $section->attr('id');
                $brand = $this->extractBrandFromId($sectionId);
                if (!$brand) {
                    return;
                }

                $rows = $section->filter('div.grid.grid-cols-5');
                $isFirstRow = true;
                $rows->each(function (Crawler $row) use (&$snapshots, $brand, &$isFirstRow) {
                    if ($isFirstRow) {
                        $isFirstRow = false;
                        return;
                    }

                    $columns = $row->filter('div.p-3');
                    if ($columns->count() < 3) {
                        return;
                    }

                    $weight = $this->parseWeight($columns->eq(0)->text());
                    $sellPrice = $this->parsePrice($columns->eq(1)->text());
                    $buyPrice = $this->parsePrice($columns->eq(2)->text());

                    if ($weight && $sellPrice && $buyPrice) {
                        $snapshots[] = new PriceSnapshot(
                            brand: $brand,
                            weight: $weight,
                            sellPrice: $sellPrice,
                            buyPrice: $buyPrice,
                            recordedAt: Carbon::now()->startOfDay()
                        );
                    }
                });
            });
        } catch (\Throwable $e) {
            Log::error('GaleriGoldParser error: '.$e->getMessage());
        }

        return $snapshots;
    }

    private function extractBrandFromId(?string $id): ?string
    {
        if (!$id) {
            return null;
        }

        $idMappings = [
            'GALERI 24' => 'Galeri24',
            'ANTAM' => 'Antam',
            'UBS' => 'UBS',
            'LOTUS' => 'Lotus Archi',
        ];

        foreach ($idMappings as $pattern => $brandName) {
            if (stripos($id, $pattern) !== false) {
                if ($pattern === 'GALERI 24' && stripos($id, 'BABY') === false && stripos($id, 'DINAR') === false) {
                    return $brandName;
                }
                if ($pattern !== 'GALERI 24') {
                    return $brandName;
                }
            }
        }

        return null;
    }

    private function parseWeight(string $text): ?float
    {
        $cleaned = trim($text);
        $weight = (float) $cleaned;
        return $weight > 0 ? $weight : null;
    }

    private function parsePrice(string $text): ?float
    {
        $cleaned = preg_replace('/[^0-9]/', '', $text);
        $price = (float) $cleaned;
        return $price > 0 ? $price : null;
    }
}
