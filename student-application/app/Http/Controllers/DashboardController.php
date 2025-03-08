<?php

// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $advertisements = Advertisement::where('status', 'published')
            // ->where('application_end', '>', now())
            ->with('programs')
            ->get();

        return view('dashboard', compact('advertisements'));
    }
}