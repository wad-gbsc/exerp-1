<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inlo extends Model
{
    protected $table = 'inlo';
    protected $primaryKey = 'inlo_hash';
    public $timestamps = false;
}
