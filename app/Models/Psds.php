<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Psds extends Model
{
    protected $table = 'psds';
    protected $primaryKey = 'psds_hash';
    public $timestamps = false;
}
