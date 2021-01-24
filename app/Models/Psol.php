<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Psol extends Model
{
    protected $table = 'psol';
    protected $primaryKey = 'psol_hash';
    public $timestamps = false;
}
