<?php

// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;
use App\Models\Application;

class DashboardController extends Controller
{
    public function index()
    {
        $advertisements = Advertisement::where('status', 'published')
            // ->where('application_end', '>', now())
            ->with('programs')
            ->get();

            $applications = Application::where('student_id', auth()->id())
            ->with('advertisement')
            ->get();

        return view('dashboard', compact('advertisements', 'applications'));
    }
}