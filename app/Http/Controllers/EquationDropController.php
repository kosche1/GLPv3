<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class EquationDropController extends Controller // Renamed class
{
    /**
     * Display the equation drop game page.
     */
    public function index(): View
    {
        // Data for the Equation Drop game
        $data = [
            'trackName' => 'STEM',
            'pageTitle' => 'Equation Drop' // Updated page title
        ];
        return view('equation-drop.index', $data); // Updated view path
    }
} 