<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MadisonQuary extends Model
{
    protected $fillable = [
        'ref_person_id',
        'patient_title',
        'patient_name',
        'gender',
        'dob',
        'guardian_name',
        'mobile',
        'alternate_number',
        'problam',
        'doctor_ids',
        'hospital_ids',
        'department_ids',
        'state_id',
        'city_id',
        'district_id',
        'village',
        'block',
        'pin_code',
        'aadhaar_number',
        'madison_upload',
        'amount',
        'paid_amount',
        'payment_id',
        'created_at',
        'updated_at'
    ];

    // Add this if you want to use pagination with query string
    protected $appends = [];

    // No changes needed for pagination in the model itself

    // Add relationships for state, city, district
    public function state()
    {
        return $this->belongsTo(\App\Models\State::class, 'state_id');
    }

    public function city()
    {
        return $this->belongsTo(\App\Models\City::class, 'city_id');
    }

    public function district()
    {
        return $this->belongsTo(\App\Models\District::class, 'district_id');
    }
}
