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
        $query = State::query();
        if ($q && strlen($q) >= 3) {
            $query->where('name', 'like', '%' . $q . '%');
        }
        $states = $query->select('id', 'name')->orderBy('name')->limit(10)->get();
        return response()->json($states);
    }

    public function cities(Request $request)
    {
        $q = $request->input('q');
        $query = City::query();
        if ($q && strlen($q) >= 3) {
            $query->where('name', 'like', '%' . $q . '%');
        }
        $cities = $query->select('id', 'name')->orderBy('name')->limit(10)->get();
        return response()->json($cities);
    }

    public function districts(Request $request)
    {
        $q = $request->input('q');
        $query = District::query();
        if ($q && strlen($q) >= 3) {
            $query->where('name', 'like', '%' . $q . '%');
        }
        $districts = $query->select('id', 'name')->orderBy('name')->limit(10)->get();
        return response()->json($districts);
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
