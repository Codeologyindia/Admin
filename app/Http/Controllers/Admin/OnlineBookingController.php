<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hospital;
use App\Models\Department;
use App\Models\State;
use App\Models\City;
use App\Models\District;
use App\Models\BookingOnline;
use Illuminate\Support\Facades\Storage;
use App\Models\OtherDocument;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel; // Add this if using Laravel Excel

class OnlineBookingController extends Controller
{
    public function showForm()
    {
        $hospitals = Hospital::all();
        $departments = Department::all();
        $queryTypes = \App\Models\QueryType::orderBy('id')->get();
        return view('admin.online-booking', compact('hospitals', 'departments', 'queryTypes'));
    }

    public function store(Request $request)
    {
        // Validate input (add more rules as needed)
        $validated = $request->validate([
            'person_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string|max:10',
            'appointment_date' => 'required|date',
            'appointment' => 'required',
            // ...add more validation as needed...
        ]);

        // Insert new state/city/district if provided and not empty
        $state_id = null;
        $city_id = null;
        $district_id = null;
        $hospital_id = null;
        $department_id = null;

        // State
        if ($request->state_id === 'other' && $request->new_state) {
            $state_id = \DB::table('states')->insertGetId([
                'name' => $request->new_state,
                'created_at' => now(),
            ]);
        } elseif ($request->state_id !== 'other' && $request->state_id !== 'all' && $request->state_id) {
            $state_id = (int)$request->state_id;
        }

        // City
        if ($request->city_id === 'other' && $request->new_city) {
            $city_id = \DB::table('cities')->insertGetId([
                'name' => $request->new_city,
                'created_at' => now(),
            ]);
        } elseif ($request->city_id !== 'other' && $request->city_id !== 'all' && $request->city_id) {
            $city_id = (int)$request->city_id;
        }

        // District
        if ($request->district_id === 'other' && $request->new_district) {
            $district_id = \DB::table('districts')->insertGetId([
                'name' => $request->new_district,
                'created_at' => now(),
            ]);
        } elseif ($request->district_id !== 'other' && $request->district_id !== 'all' && $request->district_id) {
            $district_id = (int)$request->district_id;
        }

        // Hospital
        if ($request->hospital_id === 'other' && $request->new_hospital) {
            $hospital_id = \DB::table('hospitals')->insertGetId([
                'hospital_name' => $request->new_hospital,
                'type' => $request->new_hospital_type ?? '', // Use selected type
                'city' => '', // Set default or get from form if needed
                'state' => '', // Set default or get from form if needed
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } elseif ($request->hospital_id !== 'other' && $request->hospital_id !== 'all' && $request->hospital_id) {
            $hospital_id = (int)$request->hospital_id;
        }

        // Department
        if ($request->department_id === 'other' && $request->new_department) {
            $department_id = \DB::table('departments')->insertGetId([
                'name' => $request->new_department,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } elseif ($request->department_id !== 'other' && $request->department_id !== 'all' && $request->department_id) {
            $department_id = (int)$request->department_id;
        }

        // Payment fields (force numeric or null)
        $amount = $request->has('amount') && $request->amount !== '' ? floatval($request->amount) : null;
        $paid_amount = $request->has('paid_amount') && $request->paid_amount !== '' ? floatval($request->paid_amount) : null;
        $payment_id = $request->input('payment_id') ?? null;

        $booking = BookingOnline::create([
            'person_name' => $request->person_name,
            'phone' => $request->phone,
            'alternate_number' => $request->alternate_number,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'state_id' => $state_id,
            'city_id' => $city_id,
            'district_id' => $district_id,
            'new_state' => $request->new_state,
            'new_city' => $request->new_city,
            'new_district' => $request->new_district,
            'hospital_id' => $hospital_id,
            'new_hospital' => $request->new_hospital,
            'department_id' => $department_id,
            'new_department' => $request->new_department,
            'problem' => $request->problem,
            'appointment_date' => $request->appointment_date,
            'appointment' => $request->appointment,
            'amount' => $amount,
            'paid_amount' => $paid_amount,
            'payment_id' => $payment_id,
        ]);

        // Handle document uploads (core PHP, create folder if not exists)
        if (!empty($_FILES['documents']['name'][0])) {
            $uploadDir = public_path('uploads/other_documents');
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            foreach ($_FILES['documents']['name'] as $idx => $filename) {
                if ($filename && $_FILES['documents']['error'][$idx] === UPLOAD_ERR_OK) {
                    $tmpName = $_FILES['documents']['tmp_name'][$idx];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    $newName = uniqid('doc_') . '.' . $ext;
                    $destination = $uploadDir . DIRECTORY_SEPARATOR . $newName;
                    if (move_uploaded_file($tmpName, $destination)) {
                        \App\Models\OtherDocument::create([
                            'name' => $request->document_names[$idx] ?? 'Document',
                            'file_path' => 'uploads/other_documents/' . $newName,
                            'id_set' => json_encode(['booking_online' => $booking->id]),
                        ]);
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Booking submitted successfully!');
    }

    // AJAX: Search hospitals by name (for select2 or similar plugin)
    public function searchHospitals(Request $request)
    {
        $term = $request->input('term');
        $results = Hospital::where('hospital_name', 'like', '%' . $term . '%')
            ->select('id', 'hospital_name as text')
            ->limit(10)
            ->get();
        return response()->json(['results' => $results]);
    }

    // AJAX: Search departments by name (for Choices.js plugin)
    public function searchDepartments(Request $request)
    {
        $term = $request->input('term');
        $results = \App\Models\Department::where('name', 'like', '%' . $term . '%')
            ->select('id', 'name as text')
            ->limit(10)
            ->get();
        return response()->json(['results' => $results]);
    }

    // AJAX: Search states by name
    public function searchStates(Request $request)
    {
        $term = $request->input('term');
        $results = State::where('name', 'like', '%' . $term . '%')
            ->select('id', 'name')
            ->limit(10)
            ->get();
        return response()->json($results);
    }

    // AJAX: Search cities by name (no state_id)
    public function searchCities(Request $request)
    {
        $term = $request->input('term');
        $query = City::query();
        if ($term) {
            $query->where('name', 'like', '%' . $term . '%');
        }
        $results = $query->select('id', 'name')->limit(10)->get();
        return response()->json($results);
    }

    // AJAX: Search districts by name (no state_id)
    public function searchDistricts(Request $request)
    {
        $term = $request->input('term');
        $query = District::query();
        if ($term) {
            $query->where('name', 'like', '%' . $term . '%');
        }
        $results = $query->select('id', 'name')->limit(10)->get();
        return response()->json($results);
    }

    public function index(Request $request)
    {
        $query = \App\Models\BookingOnline::query()->orderBy('id', 'desc');

        if ($request->filled('person_name')) {
            $query->where('person_name', 'like', '%' . $request->person_name . '%');
        }
        if ($request->filled('phone')) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }
        if ($request->filled('state')) {
            $query->where(function($q) use ($request) {
                $q->whereHas('state', function($q2) use ($request) {
                    $q2->where('name', 'like', '%' . $request->state . '%');
                })
                ->orWhere('new_state', 'like', '%' . $request->state . '%');
            });
        }
        if ($request->filled('city')) {
            $query->where(function($q) use ($request) {
                $q->whereHas('city', function($q2) use ($request) {
                    $q2->where('name', 'like', '%' . $request->city . '%');
                })
                ->orWhere('new_city', 'like', '%' . $request->city . '%');
            });
        }
        if ($request->filled('hospital')) {
            $query->where(function($q) use ($request) {
                $q->whereHas('hospital', function($q2) use ($request) {
                    $q2->where('hospital_name', 'like', '%' . $request->hospital . '%');
                })
                ->orWhere('new_hospital', 'like', '%' . $request->hospital . '%');
            });
        }
        if ($request->filled('department')) {
            $query->where(function($q) use ($request) {
                $q->whereHas('department', function($q2) use ($request) {
                    $q2->where('name', 'like', '%' . $request->department . '%');
                })
                ->orWhere('new_department', 'like', '%' . $request->department . '%');
            });
        }
        if ($request->filled('problem')) {
            $query->where('problem', 'like', '%' . $request->problem . '%');
        }
        if ($request->filled('appointment_date')) {
            $query->where('appointment_date', $request->appointment_date);
        }

        // Eager load relationships for display
        $query->with(['state', 'city', 'hospital', 'department']);

        // Pagination and per page
        $perPage = $request->input('per_page', 10);
        $perPage = in_array($perPage, [10, 50, 100]) ? $perPage : 10;
        $bookings = $query->paginate($perPage)->appends($request->all());

        return view('admin.booking-list', compact('bookings', 'perPage'));
    }

    public function view($id)
    {
        $booking = BookingOnline::with(['state', 'city', 'hospital', 'department'])->findOrFail($id);
        return view('admin.booking-view', compact('booking'));
    }

    public function paymentUpdate(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|integer|exists:booking_online,id',
            'paid_amount' => 'required|numeric|min:0',
            'payment_id' => 'required|string|max:100',
        ]);
        $booking = BookingOnline::findOrFail($request->booking_id);

        // Save payment log
        DB::table('booking_payment_logs')->insert([
            'booking_online_id' => $booking->id,
            'paid_amount' => $request->paid_amount,
            'payment_id' => $request->payment_id,
            'created_at' => now(),
        ]);

        // Update booking's paid_amount and payment_id
        $booking->paid_amount = $request->paid_amount;
        $booking->payment_id = $request->payment_id;
        $booking->save();

        return redirect()->back()->with('success', 'Payment updated successfully!');
    }

    public function paymentHistory($id)
    {
        $history = DB::table('booking_payment_logs')
            ->where('booking_online_id', $id)
            ->orderBy('created_at', 'desc')
            ->get(['paid_amount', 'payment_id', 'created_at']);
        return response()->json($history);
    }

    public function bookingListExcel(Request $request)
    {
        // Export all columns from booking_online table
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
        ]);

        $bookings = BookingOnline::whereDate('created_at', '>=', $request->from_date)
            ->whereDate('created_at', '<=', $request->to_date)
            ->orderBy('id', 'desc')
            ->get();

        // Get all columns dynamically
        $columns = \Schema::getColumnListing('booking_online');
        $data = [];
        $data[] = $columns;
        foreach ($bookings as $booking) {
            $row = [];
            foreach ($columns as $col) {
                $row[] = $booking->$col;
            }
            $data[] = $row;
        }

        if (class_exists('\Maatwebsite\Excel\Facades\Excel')) {
            return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\ArrayExport($data), 'booking_list.xlsx');
        } else {
            $filename = 'booking_list_' . date('Ymd_His') . '.csv';
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            $f = fopen('php://output', 'w');
            foreach ($data as $row) {
                fputcsv($f, $row);
            }
            fclose($f);
            exit;
        }
    }

    public function edit($id)
    {
        $booking = BookingOnline::with(['state', 'city', 'hospital', 'department'])->findOrFail($id);
        $hospitals = Hospital::all();
        $departments = Department::all();
        $states = State::all();
        $cities = City::all();
        $districts = District::all();
        return view('admin.booking-edit', compact('booking', 'hospitals', 'departments', 'states', 'cities', 'districts'));
    }

    public function update(Request $request, $id)
    {
        $booking = BookingOnline::findOrFail($id);

        $validated = $request->validate([
            'person_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string|max:10',
            'appointment_date' => 'required|date',
            'appointment' => 'required',
            // ...add more validation as needed...
        ]);

        // State
        $state_id = null;
        if ($request->state_id === 'other' && $request->new_state) {
            $state_id = \DB::table('states')->insertGetId([
                'name' => $request->new_state,
                'created_at' => now(),
            ]);
        } elseif ($request->state_id !== 'other' && $request->state_id !== 'all' && $request->state_id) {
            $state_id = (int)$request->state_id;
        }

        // City
        $city_id = null;
        if ($request->city_id === 'other' && $request->new_city) {
            $city_id = \DB::table('cities')->insertGetId([
                'name' => $request->new_city,
                'created_at' => now(),
            ]);
        } elseif ($request->city_id !== 'other' && $request->city_id !== 'all' && $request->city_id) {
            $city_id = (int)$request->city_id;
        }

        // District
        $district_id = null;
        if ($request->district_id === 'other' && $request->new_district) {
            $district_id = \DB::table('districts')->insertGetId([
                'name' => $request->new_district,
                'created_at' => now(),
            ]);
        } elseif ($request->district_id !== 'other' && $request->district_id !== 'all' && $request->district_id) {
            $district_id = (int)$request->district_id;
        }

        // Hospital
        $hospital_id = null;
        if ($request->hospital_id === 'other' && $request->new_hospital) {
            $hospital_id = \DB::table('hospitals')->insertGetId([
                'hospital_name' => $request->new_hospital,
                'type' => $request->new_hospital_type ?? '',
                'city' => '',
                'state' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } elseif ($request->hospital_id !== 'other' && $request->hospital_id !== 'all' && $request->hospital_id) {
            $hospital_id = (int)$request->hospital_id;
        }

        // Department
        $department_id = null;
        if ($request->department_id === 'other' && $request->new_department) {
            $department_id = \DB::table('departments')->insertGetId([
                'name' => $request->new_department,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } elseif ($request->department_id !== 'other' && $request->department_id !== 'all' && $request->department_id) {
            $department_id = (int)$request->department_id;
        }

        // Payment fields
        $amount = $request->has('amount') && $request->amount !== '' ? floatval($request->amount) : null;
        $paid_amount = $request->has('paid_amount') && $request->paid_amount !== '' ? floatval($request->paid_amount) : null;
        $payment_id = $request->input('payment_id') ?? null;

        $booking->update([
            'person_name' => $request->person_name,
            'phone' => $request->phone,
            'alternate_number' => $request->alternate_number,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'state_id' => $state_id,
            'city_id' => $city_id,
            'district_id' => $district_id,
            'new_state' => $request->new_state,
            'new_city' => $request->new_city,
            'new_district' => $request->new_district,
            'hospital_id' => $hospital_id,
            'new_hospital' => $request->new_hospital,
            'department_id' => $department_id,
            'new_department' => $request->new_department,
            'problem' => $request->problem,
            'appointment_date' => $request->appointment_date,
            'appointment' => $request->appointment,
            'amount' => $amount,
            'paid_amount' => $paid_amount,
            'payment_id' => $payment_id,
        ]);

        // Optionally handle document uploads if you want to allow updating documents

        return redirect()->route('admin.booking-list')->with('success', 'Booking updated successfully!');
    }
}
