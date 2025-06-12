<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;
use App\Models\District;
use Illuminate\Support\Facades\DB;

class AjaxLocationController extends Controller
{
    public function states(Request $request)
    {
        $q = $request->input('q');
        $selectedId = $request->input('selected_id');
        $query = State::query();

        // Always include selected option if present
        $states = collect();
        if ($selectedId) {
            $selected = State::where('id', $selectedId)->select('id', 'name')->first();
            if ($selected) {
                $states->push($selected);
            }
        }

        if ($q && strlen($q) >= 3) {
            $query->where('name', 'like', '%' . $q . '%');
            if ($selectedId) {
                $query->where('id', '!=', $selectedId);
            }
            $results = $query->select('id', 'name')->orderBy('name')->limit(10)->get();
            $states = $states->concat($results);
        }

        return response()->json($states->values());
    }

    public function cities(Request $request)
    {
        $q = $request->input('q');
        $selectedId = $request->input('selected_id');
        $query = City::query();

        $cities = collect();
        if ($selectedId) {
            $selected = City::where('id', $selectedId)->select('id', 'name')->first();
            if ($selected) {
                $cities->push($selected);
            }
        }

        if ($q && strlen($q) >= 3) {
            $query->where('name', 'like', '%' . $q . '%');
            if ($selectedId) {
                $query->where('id', '!=', $selectedId);
            }
            $results = $query->select('id', 'name')->orderBy('name')->limit(10)->get();
            $cities = $cities->concat($results);
        }

        return response()->json($cities->values());
    }

    public function districts(Request $request)
    {
        $q = $request->input('q');
        $selectedId = $request->input('selected_id');
        $query = District::query();

        $districts = collect();
        if ($selectedId) {
            $selected = District::where('id', $selectedId)->select('id', 'name')->first();
            if ($selected) {
                $districts->push($selected);
            }
        }

        if ($q && strlen($q) >= 3) {
            $query->where('name', 'like', '%' . $q . '%');
            if ($selectedId) {
                $query->where('id', '!=', $selectedId);
            }
            $results = $query->select('id', 'name')->orderBy('name')->limit(10)->get();
            $districts = $districts->concat($results);
        }

        return response()->json($districts->values());
    }

    public function doctors(Request $request)
    {
        $q = $request->input('q');
        $query = DB::table('doctors');
        if ($q && strlen($q) >= 3) {
            $query->where('name', 'like', '%' . $q . '%');
        }
        $doctors = $query->select('id', 'name')->orderBy('name')->limit(10)->get();
        return response()->json($doctors);
    }

    public function hospitals(Request $request)
    {
        $q = $request->input('q');
        $query = DB::table('hospitals');
        if ($q && strlen($q) >= 3) {
            $query->where('hospital_name', 'like', '%' . $q . '%');
        }
        // You can add more filters if needed
        $hospitals = $query->select('id', 'hospital_name as name')->orderBy('hospital_name')->limit(10)->get();
        return response()->json($hospitals);
    }

    public function departments(Request $request)
    {
        $q = $request->input('q');
        $query = DB::table('departments');
        if ($q && strlen($q) >= 3) {
            $query->where('name', 'like', '%' . $q . '%');
        }
        $departments = $query->select('id', 'name')->orderBy('name')->limit(10)->get();
        return response()->json($departments);
    }
}
