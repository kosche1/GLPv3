<?php

namespace App\Http\Controllers;

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
        // Data for the Rate Us page
        $data = [
            'pageTitle' => 'Rate Us',
            'user' => Auth::user()
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

        // Here you would typically store the rating in your database
        // For now, we'll just return a success message

        return redirect()->route('rate-us')->with('success', 'Thank you for your feedback!');
    }
}
