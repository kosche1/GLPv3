<?php

namespace App\Http\Controllers;

use App\Models\InvestSmartMarketData;
use App\Models\InvestSmartPortfolio;
use App\Models\InvestSmartStock;
use App\Models\InvestSmartTransaction;
use App\Models\UserInvestmentChallenge;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class InvestSmartController extends Controller
{
    /**
     * Display the InvestSmart game view.
     */
    public function index(): View
    {
        return view('investsmart');
    }

    /**
     * Get the user's portfolio data.
     */
    public function getPortfolio(): JsonResponse
    {
        $user = Auth::user();

        // Get or create portfolio for the user
        $portfolio = InvestSmartPortfolio::firstOrCreate(
            ['user_id' => $user->id],
            ['balance' => 100000.00]
        );

        // Load portfolio stocks
        $stocks = $portfolio->stocks;

        // Update challenge progress based on portfolio
        $this->updateChallengeProgress($user, $stocks);

        return response()->json([
            'balance' => $portfolio->balance,
            'portfolio' => $stocks,
        ]);
    }

    /**
     * Get market data for available stocks.
     */
    public function getMarketData(): JsonResponse
    {
        // If no market data exists, seed it with sample data
        if (InvestSmartMarketData::count() === 0) {
            $this->seedMarketData();
        }

        $stocks = InvestSmartMarketData::all();

        return response()->json($stocks);
    }

    /**
     * Buy a stock.
     */
    public function buyStock(Request $request): JsonResponse
    {
        $request->validate([
            'symbol' => 'required|string|max:10',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $symbol = $request->input('symbol');
        $quantity = $request->input('quantity');

        // Get the portfolio
        $portfolio = InvestSmartPortfolio::where('user_id', $user->id)->firstOrFail();

        // Get the stock market data
        $marketData = InvestSmartMarketData::where('symbol', $symbol)->firstOrFail();

        // Calculate total cost
        $totalCost = $marketData->price * $quantity;

        // Check if user has enough balance
        if ($portfolio->balance < $totalCost) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient funds to complete this purchase.'
            ], 400);
        }

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Update portfolio balance
            $portfolio->balance -= $totalCost;
            $portfolio->save();

            // Check if stock already exists in portfolio
            $stock = InvestSmartStock::where('portfolio_id', $portfolio->id)
                ->where('symbol', $symbol)
                ->first();

            if ($stock) {
                // Update existing position
                $totalShares = $stock->quantity + $quantity;
                $totalInvestment = $stock->total_cost + $totalCost;

                $stock->quantity = $totalShares;
                $stock->total_cost = $totalInvestment;
                $stock->average_price = $totalInvestment / $totalShares;
                $stock->current_price = $marketData->price;
                $stock->save();
            } else {
                // Add new position
                InvestSmartStock::create([
                    'portfolio_id' => $portfolio->id,
                    'symbol' => $marketData->symbol,
                    'name' => $marketData->name,
                    'quantity' => $quantity,
                    'average_price' => $marketData->price,
                    'total_cost' => $totalCost,
                    'current_price' => $marketData->price,
                ]);
            }

            // Record transaction
            InvestSmartTransaction::create([
                'portfolio_id' => $portfolio->id,
                'type' => 'buy',
                'symbol' => $marketData->symbol,
                'name' => $marketData->name,
                'quantity' => $quantity,
                'price' => $marketData->price,
                'total' => $totalCost,
                'transaction_date' => now(),
            ]);

            DB::commit();

            // Update challenge progress
            $this->updateChallengeProgress($user, $portfolio->stocks);

            return response()->json([
                'success' => true,
                'message' => "Successfully purchased {$quantity} shares of {$marketData->symbol}.",
                'balance' => $portfolio->balance,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your purchase.'
            ], 500);
        }
    }

    /**
     * Sell a stock.
     */
    public function sellStock(Request $request): JsonResponse
    {
        $request->validate([
            'symbol' => 'required|string|max:10',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $symbol = $request->input('symbol');
        $quantity = $request->input('quantity');

        // Get the portfolio
        $portfolio = InvestSmartPortfolio::where('user_id', $user->id)->firstOrFail();

        // Get the stock from portfolio
        $stock = InvestSmartStock::where('portfolio_id', $portfolio->id)
            ->where('symbol', $symbol)
            ->firstOrFail();

        // Check if user has enough shares
        if ($stock->quantity < $quantity) {
            return response()->json([
                'success' => false,
                'message' => 'You do not own enough shares to complete this sale.'
            ], 400);
        }

        // Get current market price
        $marketData = InvestSmartMarketData::where('symbol', $symbol)->firstOrFail();
        $saleValue = $marketData->price * $quantity;

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Update portfolio balance
            $portfolio->balance += $saleValue;
            $portfolio->save();

            // Update stock quantity
            $stock->quantity -= $quantity;

            // If all shares sold, remove from portfolio
            if ($stock->quantity === 0) {
                $stock->delete();
            } else {
                $stock->save();
            }

            // Record transaction
            InvestSmartTransaction::create([
                'portfolio_id' => $portfolio->id,
                'type' => 'sell',
                'symbol' => $marketData->symbol,
                'name' => $marketData->name,
                'quantity' => $quantity,
                'price' => $marketData->price,
                'total' => $saleValue,
                'transaction_date' => now(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Successfully sold {$quantity} shares of {$marketData->symbol}.",
                'balance' => $portfolio->balance,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your sale.'
            ], 500);
        }
    }

    /**
     * Get transaction history.
     */
    public function getTransactions(): JsonResponse
    {
        $user = Auth::user();

        // Get the portfolio
        $portfolio = InvestSmartPortfolio::where('user_id', $user->id)->first();

        if (!$portfolio) {
            return response()->json([]);
        }

        // Get transactions ordered by date (newest first)
        $transactions = $portfolio->transactions()
            ->orderBy('transaction_date', 'desc')
            ->get();

        return response()->json($transactions);
    }

    /**
     * Update stock prices (simulating market changes).
     */
    public function updatePrices(): JsonResponse
    {
        // Get all market data
        $stocks = InvestSmartMarketData::all();

        foreach ($stocks as $stock) {
            // Generate random price change between -2% and +2%
            $changePercent = (mt_rand(-200, 200) / 10000);
            $oldPrice = $stock->price;
            $newPrice = round($oldPrice * (1 + $changePercent), 2);

            // Update price and change values
            $stock->change = round($newPrice - $oldPrice, 2);
            $stock->change_percent = round($changePercent * 100, 2);
            $stock->price = $newPrice;
            $stock->save();

            // Update all portfolio stocks with this symbol
            InvestSmartStock::where('symbol', $stock->symbol)
                ->update(['current_price' => $newPrice]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Stock prices updated successfully.'
        ]);
    }

    /**
     * Update challenge progress based on portfolio
     */
    private function updateChallengeProgress($user, $stocks): void
    {
        // Log user authentication status
        \Illuminate\Support\Facades\Log::info('User authentication status in updateChallengeProgress:', [
            'user_id' => $user ? $user->id : null,
            'stocks_count' => count($stocks),
        ]);

        // If no user is provided, return early
        if (!$user) {
            \Illuminate\Support\Facades\Log::warning('No authenticated user for updateChallengeProgress');
            return;
        }

        // Get user's active challenges
        $userChallenges = UserInvestmentChallenge::with('challenge')
            ->where('user_id', $user->id)
            ->where('status', 'in-progress')
            ->get();

        \Illuminate\Support\Facades\Log::info('User challenges found:', [
            'count' => $userChallenges->count(),
            'challenges' => $userChallenges->pluck('id')->toArray(),
        ]);

        $completedChallenges = [];

        foreach ($userChallenges as $userChallenge) {
            $challenge = $userChallenge->challenge;
            $previousStatus = $userChallenge->status;

            // Check if this is the "Beginner Portfolio Builder" challenge
            if ($challenge->title === 'Beginner Portfolio Builder') {
                // The requirement is to have at least 5 different stocks
                $uniqueStocksCount = count($stocks);

                if ($uniqueStocksCount >= 5) {
                    // Challenge completed
                    $userChallenge->progress = 100;
                    $userChallenge->status = 'completed';

                    // If status changed to completed, add to completed challenges
                    if ($previousStatus !== 'completed') {
                        $completedChallenges[] = $challenge->title;
                    }
                } else {
                    // Calculate progress (20% per stock)
                    $userChallenge->progress = min(($uniqueStocksCount * 20), 99);
                }

                $userChallenge->save();
            }

            // Add more challenge types here as needed
        }

        // Also update temporary challenges in localStorage (handled by frontend)
    }

    /**
     * Seed the market data with sample stocks.
     */
    private function seedMarketData(): void
    {
        $stocks = [
            [
                'symbol' => 'SM',
                'name' => 'SM Investments Corporation',
                'price' => 952.50,
                'change' => 15.50,
                'change_percent' => 1.65,
                'volume' => 1245678,
                'industry' => 'Conglomerate',
                'market_cap' => 1142500000000,
                'pe' => 18.75,
                'high_52_week' => 1050.00,
                'low_52_week' => 850.00,
                'dividend_yield' => 1.2,
                'description' => 'SM Investments Corporation is one of the largest conglomerates in the Philippines, with interests in retail, banking, and property development.'
            ],
            [
                'symbol' => 'ALI',
                'name' => 'Ayala Land, Inc.',
                'price' => 32.80,
                'change' => -0.45,
                'change_percent' => -1.35,
                'volume' => 3567890,
                'industry' => 'Property',
                'market_cap' => 482500000000,
                'pe' => 15.20,
                'high_52_week' => 38.50,
                'low_52_week' => 28.60,
                'dividend_yield' => 1.8,
                'description' => 'Ayala Land, Inc. is the real estate arm of the Ayala Corporation, one of the Philippines\'s oldest and largest conglomerates. It develops residential, commercial, and industrial properties.'
            ],
            [
                'symbol' => 'BDO',
                'name' => 'BDO Unibank, Inc.',
                'price' => 128.70,
                'change' => 2.30,
                'change_percent' => 1.82,
                'volume' => 987654,
                'industry' => 'Banking',
                'market_cap' => 563200000000,
                'pe' => 12.45,
                'high_52_week' => 135.00,
                'low_52_week' => 110.50,
                'dividend_yield' => 2.5,
                'description' => 'BDO Unibank, Inc. is the largest bank in the Philippines by assets, offering a wide range of banking services including retail, corporate, and investment banking.'
            ],
            [
                'symbol' => 'JFC',
                'name' => 'Jollibee Foods Corporation',
                'price' => 215.40,
                'change' => 5.60,
                'change_percent' => 2.67,
                'volume' => 456789,
                'industry' => 'Food & Beverage',
                'market_cap' => 235600000000,
                'pe' => 22.80,
                'high_52_week' => 240.00,
                'low_52_week' => 180.00,
                'dividend_yield' => 1.1,
                'description' => 'Jollibee Foods Corporation is the largest fast food chain in the Philippines, operating multiple brands including Jollibee, Chowking, Greenwich, Red Ribbon, and Mang Inasal.'
            ],
            [
                'symbol' => 'TEL',
                'name' => 'PLDT Inc.',
                'price' => 1275.00,
                'change' => -18.50,
                'change_percent' => -1.43,
                'volume' => 123456,
                'industry' => 'Telecommunications',
                'market_cap' => 275800000000,
                'pe' => 14.30,
                'high_52_week' => 1450.00,
                'low_52_week' => 1150.00,
                'dividend_yield' => 4.2,
                'description' => 'PLDT Inc. is the largest telecommunications and digital services company in the Philippines, offering mobile, fixed-line, and internet services.'
            ],
            [
                'symbol' => 'AC',
                'name' => 'Ayala Corporation',
                'price' => 845.00,
                'change' => 12.50,
                'change_percent' => 1.50,
                'volume' => 234567,
                'industry' => 'Conglomerate',
                'market_cap' => 528100000000,
                'pe' => 16.80,
                'high_52_week' => 900.00,
                'low_52_week' => 750.00,
                'dividend_yield' => 1.5,
                'description' => 'Ayala Corporation is one of the oldest and largest conglomerates in the Philippines, with businesses in real estate, banking, telecommunications, water, power, and more.'
            ],
            [
                'symbol' => 'MER',
                'name' => 'Manila Electric Company',
                'price' => 325.60,
                'change' => 4.20,
                'change_percent' => 1.31,
                'volume' => 345678,
                'industry' => 'Utilities',
                'market_cap' => 366700000000,
                'pe' => 13.50,
                'high_52_week' => 350.00,
                'low_52_week' => 280.00,
                'dividend_yield' => 3.8,
                'description' => 'Manila Electric Company (Meralco) is the largest electric distribution company in the Philippines, serving Metro Manila and nearby provinces.'
            ],
            [
                'symbol' => 'SECB',
                'name' => 'Security Bank Corporation',
                'price' => 145.80,
                'change' => -2.70,
                'change_percent' => -1.82,
                'volume' => 567890,
                'industry' => 'Banking',
                'market_cap' => 110500000000,
                'pe' => 10.20,
                'high_52_week' => 165.00,
                'low_52_week' => 130.00,
                'dividend_yield' => 3.2,
                'description' => 'Security Bank Corporation is one of the leading universal banks in the Philippines, offering retail, wholesale, and investment banking services.'
            ],
            [
                'symbol' => 'URC',
                'name' => 'Universal Robina Corporation',
                'price' => 142.50,
                'change' => 3.80,
                'change_percent' => 2.74,
                'volume' => 678901,
                'industry' => 'Food & Beverage',
                'market_cap' => 310200000000,
                'pe' => 19.60,
                'high_52_week' => 160.00,
                'low_52_week' => 125.00,
                'dividend_yield' => 1.7,
                'description' => 'Universal Robina Corporation is one of the largest food and beverage companies in the Philippines, with operations across the Asia-Pacific region.'
            ],
            [
                'symbol' => 'GLO',
                'name' => 'Globe Telecom, Inc.',
                'price' => 1980.00,
                'change' => 25.00,
                'change_percent' => 1.28,
                'volume' => 89012,
                'industry' => 'Telecommunications',
                'market_cap' => 264300000000,
                'pe' => 15.70,
                'high_52_week' => 2100.00,
                'low_52_week' => 1800.00,
                'dividend_yield' => 5.1,
                'description' => 'Globe Telecom, Inc. is a major telecommunications provider in the Philippines, offering mobile, broadband, and fixed-line services.'
            ]
        ];

        foreach ($stocks as $stockData) {
            InvestSmartMarketData::create($stockData);
        }
    }
}
