<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Psgh extends Model
{
    protected $table = 'psgh';
    protected $primaryKey = 'psgh_hash';
    public $timestamps = false;
}
