<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $table = 'hospitals';
    protected $fillable = [
        'hospital_name', 'type', 'city', 'state', 'contact', 'address'
    ];
}
