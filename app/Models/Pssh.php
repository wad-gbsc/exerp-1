<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pssh extends Model
{
    protected $table = 'pssh';
    protected $primaryKey = 'pssh_hash';
    public $timestamps = false;
}
