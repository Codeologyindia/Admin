<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingOnline extends Model
{
    protected $table = 'booking_online';

    protected $fillable = [
        'person_name',
        'phone',
        'alternate_number',
        'dob',
        'gender',
        'state_id',
        'city_id',
        'district_id',
        'new_state',
        'new_city',
        'new_district',
        'hospital_id',
        'new_hospital',
        'department_id',
        'new_department',
        'problem',
        'appointment_date',
        'appointment',
        'amount',
        'paid_amount',
        'payment_id',
    ];

    public function state() {
        return $this->belongsTo(\App\Models\State::class, 'state_id');
    }
    public function city() {
        return $this->belongsTo(\App\Models\City::class, 'city_id');
    }
    public function hospital() {
        return $this->belongsTo(\App\Models\Hospital::class, 'hospital_id');
    }
    public function department() {
        return $this->belongsTo(\App\Models\Department::class, 'department_id');
    }
}
