<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inct extends Model
{
    protected $table = 'inct';
    protected $primaryKey = 'inct_hash';
    public $timestamps = false;
}
