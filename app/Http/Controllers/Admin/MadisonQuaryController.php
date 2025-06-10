<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MadisonQuary;

class MadisonQuaryController extends Controller
{
    public function index(Request $request)
    {
        // You can add your filter/query logic here and pass data to the view
        // Example: $madisonQuaries = MadisonQuary::filter($request)->paginate(10);

        return view('admin.madison-quary');
    }

    public function add()
    {
        // Show the add form for Madison Quary
        return view('admin.madison-quary-add');
    }

    public function store(Request $request)
    {
        $request->validate([
            // ...other validation rules...
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            // ...other validation rules...
        ]);

        MadisonQuary::create([
            // ...other fields...
            'state' => $request->state,
            'city' => $request->city,
            'district' => $request->district,
            // ...other fields...
        ]);

        // Handle the store logic for a new Madison Quary
        // Validate and save the record here
        // return redirect()->route('admin.madison-quary')->with('success', 'Added successfully!');
    }

    public function edit($id)
    {
        // Just pass the ID for UI, no model fetching
        return view('admin.madison-quary-edit', [
            'id' => $id
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            // ...other validation rules...
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            // ...other validation rules...
        ]);

        $madisonQuary = MadisonQuary::findOrFail($id);
        $madisonQuary->update([
            // ...other fields...
            'state' => $request->state,
            'city' => $request->city,
            'district' => $request->district,
            // ...other fields...
        ]);

        // Handle the update logic for a specific Madison Quary
        // Validate and update the record here
        // return redirect()->route('admin.madison-quary')->with('success', 'Updated successfully!');
    }
}
