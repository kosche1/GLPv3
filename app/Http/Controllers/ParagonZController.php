<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ParagonZController extends Controller
{
    /**
     * Display the ParagonZ page.
     */
    public function index(): View
    {
        return view('paragonz');
    }
}
