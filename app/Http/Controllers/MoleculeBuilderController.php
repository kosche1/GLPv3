<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class MoleculeBuilderController extends Controller
{
    /**
     * Display the molecule builder index page.
     */
    public function index(): View
    {
        // You can pass data to the view here if needed, e.g., initial molecule challenge
        $data = [
            'trackName' => 'STEM', // Or dynamically get this if needed
            'pageTitle' => 'Molecule Builder'
        ];
        return view('molecule-builder.index', $data);
    }
} 