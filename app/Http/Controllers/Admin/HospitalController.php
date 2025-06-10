<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hospital;

class HospitalController extends Controller
{
    public function index(Request $request)
    {
        // Simple filter logic (expand as needed)
        $query = Hospital::query();
        if ($request->filled('name')) {
            $query->where('hospital_name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }
        if ($request->filled('state')) {
            $query->where('state', 'like', '%' . $request->state . '%');
        }
        if ($request->filled('contact')) {
            $query->where('contact', 'like', '%' . $request->contact . '%');
        }
        $hospitals = $query->orderBy('id', 'desc')->paginate(50);

        // Custom pagination window logic
        $currentPage = $hospitals->currentPage();
        $lastPage = $hospitals->lastPage();
        $window = 3;
        $start = max(1, $currentPage - 1);
        $end = min($lastPage, $start + $window - 1);
        if ($end - $start < $window - 1) {
            $start = max(1, $end - $window + 1);
        }
        $pages = range($start, $end);

        return view('admin.hospital', compact('hospitals', 'pages', 'currentPage', 'lastPage'));
    }

    public function create()
    {
        return view('admin.hospital-add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'hospital_name' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'contact' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
        ]);

        Hospital::create($request->only(['hospital_name', 'type', 'city', 'state', 'contact', 'address']));

        return redirect()->route('admin.hospital')->with('success', 'Hospital added successfully!');
    }

    public function edit($id)
    {
        $hospital = Hospital::findOrFail($id);
        return view('admin.hospital-edit', compact('hospital'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'hospital_name' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'contact' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
        ]);

        $hospital = Hospital::findOrFail($id);
        $hospital->update($request->only(['hospital_name', 'type', 'city', 'state', 'contact', 'address']));

        return redirect()->route('admin.hospital')->with('success', 'Hospital updated successfully!');
    }
}
