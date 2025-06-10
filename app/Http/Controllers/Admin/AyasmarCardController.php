<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AyasmarCardController extends Controller
{
    public function index()
    {
        return view('admin.ayasmar-card');
    }

    public function edit($id)
    {
        // Show the edit form for a specific Ayushman Card Query
        // $data = Model::find($id);
        return view('admin.madison-quary-edit', ['id' => $id]);
    }


    public function update($id)
    {
        // Handle the update logic for a specific Ayushman Card Query
        // Validate and update the record here
        // return redirect()->route('admin.ayushman-card-query')->with('success', 'Updated successfully!');
    }

    public function add()
    {
        // Show the add form for Ayushman Card Query
        return view('admin.ayushman-card-add');
    }

    public function store()
    {
        // Handle the store logic for a new Ayushman Card Query
        // Validate and save the record here
        // return redirect()->route('admin.ayushman-card-query')->with('success', 'Added successfully!');
    }
}
