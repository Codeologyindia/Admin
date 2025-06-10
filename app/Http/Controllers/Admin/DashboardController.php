<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Replace with your actual logic to get counts
        $madisonQuaryCount = 0; // Example: Model::count();
        $ausramCardCount = 0;   // Example: Model::count();

        return view('admin.dashboard', compact('madisonQuaryCount', 'ausramCardCount'));
    }
}
