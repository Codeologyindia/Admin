<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtherDocument extends Model
{
    protected $table = 'other_documents';

    protected $fillable = [
        'name',
        'file_path',
        'id_set',
    ];
}
