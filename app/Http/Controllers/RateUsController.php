<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class RateUsController extends Controller
{
    /**
     * Display the Rate Us page.
     */
    public function index(): View
    {
        // Check if user has already rated
        $existingRating = Rating::where('user_id', Auth::id())->first();

        // Data for the Rate Us page
        $data = [
            'pageTitle' => 'Rate Us',
            'user' => Auth::user(),
            'existingRating' => $existingRating
        ];

        return view('rate-us', $data);
    }

    /**
     * Store a new rating.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:1000',
        ]);

        // Check if user has already rated
        $existingRating = Rating::where('user_id', Auth::id())->first();

        if ($existingRating) {
            // Update existing rating
            $existingRating->update([
                'rating' => $validated['rating'],
                'feedback' => $validated['feedback'],
                'updated_at' => now()
            ]);

            return redirect()->route('rate-us')->with('success', 'Thank you for updating your feedback!');
        } else {
            // Create new rating
            Rating::create([
                'user_id' => Auth::id(),
                'rating' => $validated['rating'],
                'feedback' => $validated['feedback']
            ]);

            return redirect()->route('rate-us')->with('success', 'Thank you for your feedback!');
        }
    }
}
