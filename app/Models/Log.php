<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'admin_id',
        'loggable_id',
        'loggable_type',
        'done_at',
        'description',
    ];
}
