<?php

namespace App\Http\Controllers;

use App\Models\SkinType;
use Illuminate\Http\Request;

class SkinTypeController extends Controller
{
    public function index()
    {
        $skinTypes = SkinType::all();
        return response()->json($skinTypes);
    }
}
