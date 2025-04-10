<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        // Redirect to the Filament admin panel
        return redirect('/admin');
    }
}
