<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefPerson extends Model
{
    protected $table = 'ref_persons';

    // Only include fields that are fillable by your form or code
    protected $fillable = [
        'name',
        'number',
        'address',
        'referral_system',
        'id_set'
    ];

    // No need to include created_at and updated_at in $fillable, Eloquent handles them automatically
}
