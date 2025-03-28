<?php

namespace App\Http\Controllers;

use App\Models\LearningMaterial;
use Illuminate\Http\Request;

class LearningMaterialController extends Controller
{
    public function index()
    {
        $materials = LearningMaterial::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('learning-materials', compact('materials'));
    }
}