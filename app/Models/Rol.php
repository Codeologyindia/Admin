<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'rol';
    protected $fillable = ['name'];
    public $timestamps = true;

    public function logins()
    {
        return $this->hasMany(Login::class, 'rol_id');
    }
}
