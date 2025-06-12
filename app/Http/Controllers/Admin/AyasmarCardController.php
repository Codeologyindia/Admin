<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AyasmanCard;
use App\Models\OtherDocument;
use App\Models\PaymentLog;

class AyasmarCardController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\AyasmanCard::query();

        // Filtering
        if ($request->filled('mobile')) {
            $query->where('mobile', 'like', '%' . $request->mobile . '%');
        }
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }
        if ($request->filled('patient_name')) {
            $query->where('patient_name', 'like', '%' . $request->patient_name . '%');
        }
        if ($request->filled('doctor')) {
            $doctor = $request->doctor;
            $query->where(function($q) use ($doctor) {
                $q->whereJsonContains('doctor_names', (int)$doctor)
                  ->orWhereJsonContains('doctor_names', (string)$doctor);
            });
        }
        if ($request->filled('hospital')) {
            $hospital = $request->hospital;
            $query->where(function($q) use ($hospital) {
                $q->whereJsonContains('hospital_names', (int)$hospital)
                  ->orWhereJsonContains('hospital_names', (string)$hospital);
            });
        }

        $cards = $query->latest()->paginate(30)->withQueryString();

        // Fetch all state/city/district names for the IDs in the result set
        $stateIds = $cards->pluck('state')->filter()->unique()->toArray();
        $cityIds = $cards->pluck('city')->filter()->unique()->toArray();
        $districtIds = $cards->pluck('district')->filter()->unique()->toArray();

        $states = \App\Models\State::whereIn('id', $stateIds)->pluck('name', 'id');
        $cities = \App\Models\City::whereIn('id', $cityIds)->pluck('name', 'id');
        $districts = \App\Models\District::whereIn('id', $districtIds)->pluck('name', 'id');

        return view('admin.ayushman-card-list', compact('cards', 'states', 'cities', 'districts'));
    }

    public function add()
    {
        return view('admin.ayushman-card-add');
    }

    public function store(Request $request)
    {
        // Validate required fields as needed
        $request->validate([
            'patient_name' => 'required|string|max:255',
            // Add more validation rules as needed
        ]);

        // Handle "Other" for Doctor, Hospital, Department
        $doctorNames = $request->input('doctor_name', []);
        if (in_array('Other', $doctorNames) && $request->filled('doctor_other')) {
            $doctorNames = array_diff($doctorNames, ['Other']);
            $doctorNames[] = $request->doctor_other;
        }
        $hospitalNames = $request->input('hospital_name', []);
        if (in_array('Other', $hospitalNames) && $request->filled('hospital_other')) {
            $hospitalNames = array_diff($hospitalNames, ['Other']);
            $hospitalNames[] = $request->hospital_other;
        }
        $departmentNames = $request->input('department', []);
        if (in_array('Other', $departmentNames) && $request->filled('department_other')) {
            $departmentNames = array_diff($departmentNames, ['Other']);
            $departmentNames[] = $request->department_other;
        }

        // --- Insert Reference Person and get its ID ---
        $refPersonId = null;
        if ($request->filled('ref_person_name')) {
            $refPerson = \App\Models\RefPerson::create([
                'name' => $request->ref_person_name,
                'number' => $request->ref_person_number,
                'address' => $request->ref_person_address,
                'referral_system' => $request->referral_system,
                'id_set' => json_encode(['Ayushman' => null]) // set to null for now, update after AyasmanCard is created
            ]);
            $refPersonId = $refPerson->id;
        }

        // Handle Ayushman document upload
        $ayushmanUploadPath = '';
        if ($request->hasFile('ayushman_upload') && $request->file('ayushman_upload')->isValid()) {
            $file = $request->file('ayushman_upload');
            $filename = uniqid() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/ayushman_uploads'), $filename);
            $ayushmanUploadPath = 'ayushman_uploads/' . $filename;
        }

        // Save to database first (without other documents)
        $ayasmanCard = \App\Models\AyasmanCard::create([
            'ref_person_name' => $request->ref_person_name,
            'ref_person_number' => $request->ref_person_number,
            'ref_person_address' => $request->ref_person_address,
            'referral_system' => $request->referral_system,
            'patient_name' => $request->patient_name,
            'title' => $request->title,
            'guardian_name' => $request->guardian_name,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'mobile' => $request->mobile,
            'problam' => $request->problam,
            'doctor_names' => json_encode(array_values($doctorNames)),
            'hospital_names' => json_encode(array_values($hospitalNames)),
            'department_names' => json_encode(array_values($departmentNames)),
            'state' => $request->state,
            'city' => $request->city,
            'district' => $request->district,
            'village' => $request->village,
            'block' => $request->block,
            'pin_code' => $request->pin_code,
            'aadhaar_number' => $request->aadhaar_number,
            'ayushman_number' => $request->ayushman_number,
            'ayushman_upload' => $ayushmanUploadPath,
            'amount' => $request->amount ?? 0,
            'paid_amount' => $request->paid_amount ?? 0,
            'payment_id' => $request->payment_id,
        ]);

        // --- Update id_set for RefPerson with AyasmanCard ID ---
        if (isset($refPerson) && $refPersonId) {
            $refPerson->id_set = json_encode(['Ayushman' => $ayasmanCard->id]);
            $refPerson->save();
        }

        // --- Store other documents in other_documents table with id_set {"Ayushman": id} ---
        $otherDocumentNames = $request->input('other_document_names', []);
        if ($request->hasFile('other_documents')) {
            foreach ($request->file('other_documents') as $idx => $file) {
                if ($file && $file->isValid()) {
                    $filename = uniqid() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('storage/other_documents'), $filename);
                    \App\Models\OtherDocument::create([
                        'name' => $otherDocumentNames[$idx] ?? '',
                        'file_path' => 'other_documents/' . $filename,
                        'id_set' => json_encode(['Ayushman' => $ayasmanCard->id])
                    ]);
                }
            }
        }

        return redirect()->route('admin.ayushman-card-query')->with('success', 'Ayushman Card Query added successfully!');
    }

    public function view($id, Request $request)
    {
        $card = AyasmanCard::findOrFail($id);

        // For view more modal
        if ($request->has('viewmore')) {
            $doctorNames = [];
            if ($card->doctor_names) {
                $ids = json_decode($card->doctor_names, true);
                $doctorNames = \App\Models\Doctor::whereIn('id', $ids)->pluck('name')->toArray();
                if (empty($doctorNames)) $doctorNames = $ids;
            }
            $hospitalNames = [];
            if ($card->hospital_names) {
                $ids = json_decode($card->hospital_names, true);
                $hospitalNames = \App\Models\Hospital::whereIn('id', $ids)->pluck('hospital_name')->toArray();
                if (empty($hospitalNames)) $hospitalNames = $ids;
            }
            $departmentNames = [];
            if ($card->department_names) {
                $ids = json_decode($card->department_names, true);
                $departmentNames = \App\Models\Department::whereIn('id', $ids)->pluck('name')->toArray();
                if (empty($departmentNames)) $departmentNames = $ids;
            }
            $state = $card->state ? \App\Models\State::find($card->state) : null;
            $city = $card->city ? \App\Models\City::find($card->city) : null;
            $district = $card->district ? \App\Models\District::find($card->district) : null;

            $html = view('admin.partials.ayushman-view-more', [
                'card' => $card,
                'doctorNames' => $doctorNames,
                'hospitalNames' => $hospitalNames,
                'departmentNames' => $departmentNames,
                'state' => $state,
                'city' => $city,
                'district' => $district,
            ])->render();

            return response($html);
        }

        // ...existing code for normal view...
        return view('admin.ayushman-card-view', compact('card'));
    }

    public function edit($id)
    {
        $card = \App\Models\AyasmanCard::findOrFail($id);

        // Doctor options
        $doctorOptions = \App\Models\Doctor::pluck('name', 'id')->toArray();
        $selectedDoctorIds = is_array(json_decode($card->doctor_names, true)) ? json_decode($card->doctor_names, true) : [];

        // Hospital options
        $hospitalOptions = \App\Models\Hospital::pluck('hospital_name', 'id')->toArray();
        $selectedHospitalIds = is_array(json_decode($card->hospital_names, true)) ? json_decode($card->hospital_names, true) : [];

        // Department options
        $departmentOptions = \App\Models\Department::pluck('name', 'id')->toArray();
        $selectedDepartmentIds = is_array(json_decode($card->department_names, true)) ? json_decode($card->department_names, true) : [];

        // State options
        $stateOptions = \App\Models\State::pluck('name', 'id')->toArray();
        $selectedStateId = $card->state;

        // City options
        $cityOptions = \App\Models\City::pluck('name', 'id')->toArray();
        $selectedCityId = $card->city;

        // District options
        $districtOptions = \App\Models\District::pluck('name', 'id')->toArray();
        $selectedDistrictId = $card->district;

        // Fetch all other documents for this Ayushman card (for table view)
        $otherDocuments = \App\Models\OtherDocument::whereJsonContains('id_set->Ayushman', $card->id)->get();

        return view('admin.ayushman-card-edit', compact(
            'card',
            'doctorOptions', 'selectedDoctorIds',
            'hospitalOptions', 'selectedHospitalIds',
            'departmentOptions', 'selectedDepartmentIds',
            'stateOptions', 'selectedStateId',
            'cityOptions', 'selectedCityId',
            'districtOptions', 'selectedDistrictId',
            'otherDocuments'
        ));
    }

    public function documents($id)
    {
        // Fetch only documents for this Ayushman card
        $docs = \App\Models\OtherDocument::whereJsonContains('id_set->Ayushman', intval($id))->get();
        return view('admin.partials.ayushman-documents', compact('docs'))->render();
    }

    public function payment($id)
    {
        $card = \App\Models\AyasmanCard::findOrFail($id);
        $logs = \App\Models\PaymentLog::where('ayasman_card_id', $id)->orderBy('created_at', 'desc')->get();
        return view('admin.ayushman-card-payment', compact('card', 'logs'));
    }

    // New: Ayaman Payment Log page
    public function paymentLog($id)
    {
        // Fetch payment logs for this Ayushman card
        $logs = \DB::table('ayasman_payment_logs')
            ->where('ayasman_card_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($logs->isEmpty()) {
            return '<div class="text-muted">No payment history found.</div>';
        }

        $html = '<div class="table-responsive"><table class="table table-sm table-bordered mb-0">';
        $html .= '<thead class="table-light"><tr>
            <th style="width:90px;">Date</th>
            <th style="width:80px;">Amount</th>
            <th style="width:120px;">Txn ID</th>
        </tr></thead><tbody>';
        foreach ($logs as $log) {
            $txn = $log->payment_id ? mb_strimwidth(htmlspecialchars($log->payment_id), 0, 12, '...') : '';
            $html .= '<tr>'
                . '<td class="text-nowrap">' . ($log->created_at ? date('Y-m-d', strtotime($log->created_at)) : '') . '</td>'
                . '<td><i class="bi bi-currency-rupee"></i> ' . number_format($log->amount, 2) . '</td>'
                . '<td>'
                    . ($txn
                        ? '<span class="badge bg-primary" title="' . htmlspecialchars($log->payment_id) . '">' . $txn . '</span>'
                        : '<span class="text-muted">-</span>')
                . '</td>'
                . '</tr>';
        }
        $html .= '</tbody></table></div>';
        return $html;
    }

    public function update(Request $request, $id)
    {
        $card = AyasmanCard::findOrFail($id);

        // Update payment info
        if ($request->has('paid_amount')) {
            $paidAmount = floatval($request->input('paid_amount'));
            $paymentId = $request->input('payment_id');

            // Update paid_amount and payment_id on the card
            $card->paid_amount = $card->paid_amount + $paidAmount;
            $card->payment_id = $paymentId;
            $card->save();

            // Insert into ayasman_payment_logs (not payment_logs)
            \DB::table('ayasman_payment_logs')->insert([
                'ayasman_card_id' => $card->id,
                'amount' => $paidAmount,
                'payment_id' => $paymentId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Return updated payment info for AJAX
            return response()->json([
                'success' => true,
                'paid_amount' => $card->paid_amount,
                'left_amount' => max(0, $card->amount - $card->paid_amount),
                'total_amount' => $card->amount,
            ]);
        }

        // ...other update logic if needed...

        return redirect()->route('admin.ayushman-card-query')->with('success', 'Updated successfully!');
    }
}
