<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PriceController extends Controller
{
    protected $goldPriceService;

    public function __construct($goldPriceService)
    {
        $this->goldPriceService = $goldPriceService;
    }

    /**
     * Display gold prices page
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $days = $request->input('days', 0); // Default: today only
        
        $currentPrice = $this->goldPriceService->getFormattedCurrentPrice();
        $historicalPrices = $this->goldPriceService->getFormattedHistoricalPrices($days);

        return Inertia::render('Prices', [
            'currentPrice' => $currentPrice,
            'historicalPrices' => $historicalPrices,
            'selectedDays' => (int) $days,
        ]);
    }

    /**
     * Get current prices as JSON (for API endpoint)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function current()
    {
        $prices = $this->goldPriceService->getFormattedCurrentPrice();
        
        return response()->json([
            'success' => true,
            'data' => $prices,
        ]);
    }

    /**
     * Get historical prices as JSON
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function history(Request $request)
    {
        $daysLimit = $request->input('days', 30);
        $prices = $this->goldPriceService->getFormattedHistoricalPrices($daysLimit);
        
        return response()->json([
            'success' => true,
            'data' => $prices,
        ]);
    }
}
