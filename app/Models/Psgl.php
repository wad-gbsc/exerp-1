<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Psgl extends Model
{
    protected $table = 'psgl';
    protected $primaryKey = 'psgl_hash';
    public $timestamps = false;
}
