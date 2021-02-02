<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lpwd extends Model
{
    protected $table = 'lpwd';
    protected $primaryKey = 'username';
    public $timestamps = false;
}
