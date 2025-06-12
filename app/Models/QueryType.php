<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QueryType extends Model
{
    protected $table = 'query_types';
    protected $fillable = ['name', 'slug'];
}
