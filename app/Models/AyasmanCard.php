<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AyasmanCard extends Model
{
    protected $table = 'ayasman_card';

    protected $fillable = [
        'ref_person_name',
        'ref_person_number',
        'ref_person_address',
        'referral_system',
        'patient_name',
        'title',
        'guardian_name',
        'dob',
        'gender',
        'mobile',
        'problam',
        'doctor_names',
        'hospital_names',
        'department_names',
        'state',
        'city',
        'district',
        'village',
        'block',
        'pin_code',
        'aadhaar_number',
        'ayushman_number',
        'other_documents',
        'ayushman_upload',
        'amount',
        'paid_amount',
        'payment_id',
    ];
}
