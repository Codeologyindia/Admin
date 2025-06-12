<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MadisonQuary;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Department;
use App\Models\State;
use App\Models\City;
use App\Models\District;
use App\Models\RefPerson;
use App\Models\OtherDocument;
use App\Models\PaymentLog;
use Illuminate\Support\Facades\View;

class MadisonQuaryController extends Controller
{
    public function index(Request $request)
    {
        $query = MadisonQuary::query();

        // Filtering
        if ($request->filled('mobile')) {
            $query->where('mobile', 'like', '%' . $request->mobile . '%');
        }
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }
        if ($request->filled('payment_status')) {
            if ($request->payment_status == 'done') {
                $query->whereRaw('amount = paid_amount');
            } elseif ($request->payment_status == 'pending') {
                $query->whereRaw('amount > paid_amount');
            }
        }
        if ($request->filled('doctor')) {
            $query->whereJsonContains('doctor_ids', (int)$request->doctor);
        }
        if ($request->filled('hospital')) {
            $query->whereJsonContains('hospital_ids', (int)$request->hospital);
        }

        $madisonQuaries = $query->latest()->paginate(30)->withQueryString();

        return view('admin.madison-quary', compact('madisonQuaries'));
    }

    public function add()
    {
        // Show the add form for Madison Quary
        return view('admin.madison-quary-add');
    }

    public function store(Request $request)
    {
        // 1. Handle "Other" for Doctor
        $doctorIds = $request->input('doctor_name', []);
        if (in_array('Other', $doctorIds) && $request->filled('doctor_other')) {
            $hospitalIdForDoctor = null;
            $selectedHospitals = $request->input('hospital_name', []);
            if (!empty($selectedHospitals) && $selectedHospitals[0] !== 'Other') {
                $hospitalIdForDoctor = $selectedHospitals[0];
            } elseif ($request->filled('hospital_other')) {
                $hospital = Hospital::create([
                    'hospital_name' => $request->hospital_other,
                    'type' => 'Other',
                    'city' => '',
                    'state' => ''
                ]);
                $hospitalIdForDoctor = $hospital->id;
                $hospitalIds = array_diff($selectedHospitals, ['Other']);
                $hospitalIds[] = $hospitalIdForDoctor;
            }
            if ($hospitalIdForDoctor) {
                $doctor = Doctor::create(['name' => $request->doctor_other, 'hospital_id' => $hospitalIdForDoctor]);
                $doctorIds = array_diff($doctorIds, ['Other']);
                $doctorIds[] = $doctor->id;
            }
        }

        // 2. Handle "Other" for Hospital
        $hospitalIds = $request->input('hospital_name', []);
        if (in_array('Other', $hospitalIds) && $request->filled('hospital_other')) {
            $hospital = Hospital::create([
                'hospital_name' => $request->hospital_other,
                'type' => 'Other',
                'city' => '',
                'state' => ''
            ]);
            $hospitalIds = array_diff($hospitalIds, ['Other']);
            $hospitalIds[] = $hospital->id;
        }

        // 3. Handle "Other" for Department
        $departmentIds = $request->input('department', []);
        if (in_array('Other', $departmentIds) && $request->filled('department_other')) {
            $department = Department::create(['name' => $request->department_other]);
            $departmentIds = array_diff($departmentIds, ['Other']);
            $departmentIds[] = $department->id;
        }

        // 4. Handle "Other" for State
        $stateId = $request->state;
        if ($stateId === 'Other' && $request->filled('state_other')) {
            $state = State::create(['name' => $request->state_other]);
            $stateId = $state->id;
        }

        // 5. Handle "Other" for City
        $cityId = $request->city;
        if ($cityId === 'Other' && $request->filled('city_other')) {
            $city = City::create(['name' => $request->city_other]);
            $cityId = $city->id;
        }

        // 6. Handle "Other" for District
        $districtId = $request->district;
        if ($districtId === 'Other' && $request->filled('district_other')) {
            $district = District::create(['name' => $request->district_other]);
            $districtId = $district->id;
        }

        // 7. Insert Reference Person and get its ID
        $refPersonId = null;
        if ($request->filled('ref_person_name')) {
            $refPerson = RefPerson::create([
                'name' => $request->ref_person_name,
                'number' => $request->ref_person_number,
                'address' => $request->ref_person_address,
                'referral_system' => $request->referral_system,
                'id_set' => json_encode(['Madison' => null]) // set to null for now, update after MadisonQuary is created
            ]);
            $refPersonId = $refPerson->id;
        }

        // 8. Save the MadisonQuary first (without file uploads)
        $data = [
            'ref_person_id'    => $refPersonId ?? null,
            'patient_title'    => $request->title ?? '',
            'patient_name'     => $request->patient_name ?? '',
            'gender'           => $request->gender ?? '',
            'dob'              => $request->dob ?? null,
            'guardian_name'    => $request->guardian_name ?? '',
            'mobile'           => $request->mobile ?? '',
            'alternate_number' => $request->alternate_number ?? '',
            'problam'          => $request->problam ?? '',
            'doctor_ids'       => json_encode(array_values($doctorIds ?? [])),
            'hospital_ids'     => json_encode(array_values($hospitalIds ?? [])),
            'department_ids'   => json_encode(array_values($departmentIds ?? [])),
            'state_id'         => $stateId ?? null,
            'city_id'          => $cityId ?? null,
            'district_id'      => $districtId ?? null,
            'village'          => $request->village ?? '',
            'block'            => $request->block ?? '',
            'pin_code'         => $request->pin_code ?? '',
            'aadhaar_number'   => $request->aadhaar_number ?? '',
            'madison_upload'   => '', // will update after upload
            'amount'           => $request->amount ?? 0,
            'paid_amount'      => $request->paid_amount ?? 0,
            'payment_id'       => $request->payment_id ?? '',
        ];

        // Validate required fields before insert
        if (empty($data['patient_name'])) {
            return back()->withErrors(['patient_name' => 'Patient name is required.'])->withInput();
        }

        $madisonQuary = MadisonQuary::create($data);

        // --- Update id_set for RefPerson with MadisonQuary ID ---
        if (isset($refPerson) && $refPersonId) {
            $refPerson->id_set = json_encode(['Madison' => $madisonQuary->id]);
            $refPerson->save();
        }

        // --- Core PHP file upload for madison_upload ---
        $madisonUploadPath = '';
        if (isset($_FILES['madison_upload']) && $_FILES['madison_upload']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = public_path('storage/madison_uploads');
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $filename = uniqid() . '_' . basename($_FILES['madison_upload']['name']);
            $targetPath = $uploadDir . DIRECTORY_SEPARATOR . $filename;
            if (move_uploaded_file($_FILES['madison_upload']['tmp_name'], $targetPath)) {
                $madisonUploadPath = 'madison_uploads/' . $filename;
                // Update madison_upload path in the record
                $madisonQuary->madison_upload = $madisonUploadPath;
                $madisonQuary->save();
            }
        }

        // --- Core PHP file upload for other_documents[] ---
        $otherDocumentNames = $request->input('other_document_names', []);
        $otherDocumentIds = [];
        if (isset($_FILES['other_documents']) && is_array($_FILES['other_documents']['name'])) {
            $otherDocDir = public_path('storage/other_documents');
            if (!is_dir($otherDocDir)) {
                mkdir($otherDocDir, 0777, true);
            }
            foreach ($_FILES['other_documents']['name'] as $idx => $originalName) {
                if ($_FILES['other_documents']['error'][$idx] === UPLOAD_ERR_OK) {
                    $filename = uniqid() . '_' . basename($originalName);
                    $targetPath = $otherDocDir . DIRECTORY_SEPARATOR . $filename;
                    if (move_uploaded_file($_FILES['other_documents']['tmp_name'][$idx], $targetPath)) {
                        $name = isset($otherDocumentNames[$idx]) ? $otherDocumentNames[$idx] : '';
                        $doc = \App\Models\OtherDocument::create([
                            'name' => $name,
                            'file_path' => 'other_documents/' . $filename,
                            'id_set' => json_encode(['Madison' => $madisonQuary->id])
                        ]);
                        $otherDocumentIds[] = $doc->id;
                    }
                }
            }
        }

        return redirect()->route('admin.madison-quary')->with('success', 'Added successfully!');
    }

    public function edit($id)
    {
        $madisonQuary = MadisonQuary::findOrFail($id);

        // Use Eloquent relationships to get the names directly
        $stateName = $madisonQuary->state ? $madisonQuary->state->name : '';
        $cityName = $madisonQuary->city ? $madisonQuary->city->name : '';
        $districtName = $madisonQuary->district ? $madisonQuary->district->name : '';

        $selectedDoctorIds = json_decode($madisonQuary->doctor_ids, true) ?? [];
        $selectedHospitalIds = json_decode($madisonQuary->hospital_ids, true) ?? [];
        $selectedDepartmentIds = json_decode($madisonQuary->department_ids, true) ?? [];
        $otherDocuments = \App\Models\OtherDocument::whereJsonContains('id_set->Madison', $madisonQuary->id)->get();

        // Fetch the RefPerson model (if any) for the edit view
        $refPerson = null;
        if ($madisonQuary->ref_person_id) {
            $refPerson = \App\Models\RefPerson::find($madisonQuary->ref_person_id);
        }

        // Pass names (not IDs) and refPerson to the view
        return view('admin.madison-quary-edit', [
            'madisonQuary' => $madisonQuary,
            'selectedDoctorIds' => $selectedDoctorIds,
            'selectedHospitalIds' => $selectedHospitalIds,
            'selectedDepartmentIds' => $selectedDepartmentIds,
            'stateName' => $stateName,
            'cityName' => $cityName,
            'districtName' => $districtName,
            'otherDocuments' => $otherDocuments,
            'refPerson' => $refPerson, // <-- pass to view
        ]);
    }

    public function update(Request $request, $id)
    {
        $madisonQuary = MadisonQuary::findOrFail($id);

        // 1. Handle "Other" for Doctor
        $doctorIds = $request->input('doctor_name', []);
        if (in_array('Other', $doctorIds) && $request->filled('doctor_other')) {
            $hospitalIdForDoctor = null;
            $selectedHospitals = $request->input('hospital_name', []);
            if (!empty($selectedHospitals) && $selectedHospitals[0] !== 'Other') {
                $hospitalIdForDoctor = $selectedHospitals[0];
            } elseif ($request->filled('hospital_other')) {
                $hospital = Hospital::create([
                    'hospital_name' => $request->hospital_other,
                    'type' => 'Other',
                    'city' => '',
                    'state' => ''
                ]);
                $hospitalIdForDoctor = $hospital->id;
                $hospitalIds = array_diff($selectedHospitals, ['Other']);
                $hospitalIds[] = $hospitalIdForDoctor;
            }
            if ($hospitalIdForDoctor) {
                $doctor = Doctor::create(['name' => $request->doctor_other, 'hospital_id' => $hospitalIdForDoctor]);
                $doctorIds = array_diff($doctorIds, ['Other']);
                $doctorIds[] = $doctor->id;
            }
        }

        // 2. Handle "Other" for Hospital
        $hospitalIds = $request->input('hospital_name', []);
        if (in_array('Other', $hospitalIds) && $request->filled('hospital_other')) {
            $hospital = Hospital::create([
                'hospital_name' => $request->hospital_other,
                'type' => 'Other',
                'city' => '',
                'state' => ''
            ]);
            $hospitalIds = array_diff($hospitalIds, ['Other']);
            $hospitalIds[] = $hospital->id;
        }

        // 3. Handle "Other" for Department
        $departmentIds = $request->input('department', []);
        if (in_array('Other', $departmentIds) && $request->filled('department_other')) {
            $department = Department::create(['name' => $request->department_other]);
            $departmentIds = array_diff($departmentIds, ['Other']);
            $departmentIds[] = $department->id;
        }

        // 4. Handle "Other" for State
        $stateId = $request->state;
        if ($stateId === 'Other' && $request->filled('state_other')) {
            $state = State::create(['name' => $request->state_other]);
            $stateId = $state->id;
        } elseif (!$stateId) {
            // If not changed, keep the old value
            $stateId = $madisonQuary->state_id;
        }

        // 5. Handle "Other" for City
        $cityId = $request->city;
        if ($cityId === 'Other' && $request->filled('city_other')) {
            $city = City::create(['name' => $request->city_other]);
            $cityId = $city->id;
        } elseif (!$cityId) {
            // If not changed, keep the old value
            $cityId = $madisonQuary->city_id;
        }

        // 6. Handle "Other" for District
        $districtId = $request->district;
        if ($districtId === 'Other' && $request->filled('district_other')) {
            $district = District::create(['name' => $request->district_other]);
            $districtId = $district->id;
        } elseif (!$districtId) {
            // If not changed, keep the old value
            $districtId = $madisonQuary->district_id;
        }

        // 7. Update Reference Person
        $refPersonId = $madisonQuary->ref_person_id;
        if ($request->filled('ref_person_name')) {
            if ($refPersonId) {
                $refPerson = RefPerson::find($refPersonId);
                if ($refPerson) {
                    $refPerson->update([
                        'name' => $request->ref_person_name,
                        'number' => $request->ref_person_number,
                        'address' => $request->ref_person_address,
                        'referral_system' => $request->referral_system,
                    ]);
                }
            } else {
                $refPerson = RefPerson::create([
                    'name' => $request->ref_person_name,
                    'number' => $request->ref_person_number,
                    'address' => $request->ref_person_address,
                    'referral_system' => $request->referral_system,
                ]);
                $refPersonId = $refPerson->id;
            }
        }

        $madisonQuary->update([
            'ref_person_id'    => $refPersonId ?? null,
            'patient_title'    => $request->title ?? '',
            'patient_name'     => $request->patient_name ?? '',
            'gender'           => $request->gender ?? '',
            'dob'              => $request->dob ?? null,
            'guardian_name'    => $request->guardian_name ?? '',
            'mobile'           => $request->mobile ?? '',
            'alternate_number' => $request->alternate_number ?? '',
            'problam'          => $request->problam ?? '',
            'doctor_ids'       => json_encode(array_values($doctorIds ?? [])),
            'hospital_ids'     => json_encode(array_values($hospitalIds ?? [])),
            'department_ids'   => json_encode(array_values($departmentIds ?? [])),
            'state_id'         => $stateId ?? null,
            'city_id'          => $cityId ?? null,
            'district_id'      => $districtId ?? null,
            'village'          => $request->village ?? '',
            'block'            => $request->block ?? '',
            'pin_code'         => $request->pin_code ?? '',
            'aadhaar_number'   => $request->aadhaar_number ?? '',
            'amount'           => $request->amount ?? 0,
            'paid_amount'      => $request->paid_amount ?? 0,
            'payment_id'       => $request->payment_id ?? '',
        ]);

        // --- Core PHP file upload for madison_upload ---
        if (isset($_FILES['madison_upload']) && $_FILES['madison_upload']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = public_path('storage/madison_uploads');
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $filename = uniqid() . '_' . basename($_FILES['madison_upload']['name']);
            $targetPath = $uploadDir . DIRECTORY_SEPARATOR . $filename;
            if (move_uploaded_file($_FILES['madison_upload']['tmp_name'], $targetPath)) {
                $madisonUploadPath = 'madison_uploads/' . $filename;
                $madisonQuary->madison_upload = $madisonUploadPath;
                $madisonQuary->save();
            }
        }

        // --- Handle removal of deleted documents ---
        $existingDocIds = $request->input('existing_document_ids', []); // array of doc IDs to keep
        if (is_array($existingDocIds)) {
            \App\Models\OtherDocument::whereJsonContains('id_set->Madison', $madisonQuary->id)
                ->whereNotIn('id', $existingDocIds)
                ->delete();
        }

        // --- Core PHP file upload for other_documents[] ---
        $otherDocumentNames = $request->input('other_document_names', []);
        if (isset($_FILES['other_documents']) && is_array($_FILES['other_documents']['name'])) {
            $otherDocDir = public_path('storage/other_documents');
            if (!is_dir($otherDocDir)) {
                mkdir($otherDocDir, 0777, true);
            }
            foreach ($_FILES['other_documents']['name'] as $idx => $originalName) {
                if ($_FILES['other_documents']['error'][$idx] === UPLOAD_ERR_OK) {
                    $filename = uniqid() . '_' . basename($originalName);
                    $targetPath = $otherDocDir . DIRECTORY_SEPARATOR . $filename;
                    if (move_uploaded_file($_FILES['other_documents']['tmp_name'][$idx], $targetPath)) {
                        $name = isset($otherDocumentNames[$idx]) ? $otherDocumentNames[$idx] : '';
                        \App\Models\OtherDocument::create([
                            'name' => $name,
                            'file_path' => 'other_documents/' . $filename,
                            'id_set' => json_encode(['Madison' => $madisonQuary->id])
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin.madison-quary')->with('success', 'Updated successfully!');
    }

    public function prescriptionFiles($id)
    {
        $quary = MadisonQuary::findOrFail($id);
        $otherDocs = OtherDocument::whereJsonContains('id_set->Madison', $quary->id)->get();

        // Use Blade rendering for AJAX modal content
        $html = view('admin.partials.prescription-files', [
            'quary' => $quary,
            'otherDocs' => $otherDocs
        ])->render();

        return response($html);
    }

    public function paymentLogs($id)
    {
        $logs = \App\Models\PaymentLog::where('madison_quary_id', $id)->orderBy('created_at', 'desc')->get();
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
                . '<td class="text-nowrap">' . ($log->created_at ? $log->created_at->format('Y-m-d') : '') . '</td>'
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

    public function viewMore($id)
    {
        $quary = MadisonQuary::findOrFail($id);
        // You can add more related data if needed
        $doctorNames = [];
        if ($quary->doctor_ids) {
            $ids = json_decode($quary->doctor_ids, true);
            $doctorNames = \App\Models\Doctor::whereIn('id', $ids)->pluck('name')->toArray();
        }
        $hospitalNames = [];
        if ($quary->hospital_ids) {
            $ids = json_decode($quary->hospital_ids, true);
            $hospitalNames = \App\Models\Hospital::whereIn('id', $ids)->pluck('hospital_name')->toArray();
        }
        $departmentNames = [];
        if ($quary->department_ids) {
            $ids = json_decode($quary->department_ids, true);
            $departmentNames = \App\Models\Department::whereIn('id', $ids)->pluck('name')->toArray();
        }
        $state = $quary->state_id ? \App\Models\State::find($quary->state_id) : null;
        $city = $quary->city_id ? \App\Models\City::find($quary->city_id) : null;
        $district = $quary->district_id ? \App\Models\District::find($quary->district_id) : null;

        $html = view('admin.partials.view-more', [
            'quary' => $quary,
            'doctorNames' => $doctorNames,
            'hospitalNames' => $hospitalNames,
            'departmentNames' => $departmentNames,
            'state' => $state,
            'city' => $city,
            'district' => $district,
        ])->render();

        return response($html);
    }

    public function getRefPersonNumber(Request $request)
    {
        $number = '';
        // You can search by ID or name, depending on your frontend
        if ($request->filled('id')) {
            $refPerson = \App\Models\RefPerson::find($request->id);
            $number = $refPerson ? $refPerson->number : '';
        } elseif ($request->filled('name')) {
            $refPerson = \App\Models\RefPerson::where('name', $request->name)->first();
            $number = $refPerson ? $refPerson->number : '';
        }
        return response()->json(['number' => $number]);
    }
}
