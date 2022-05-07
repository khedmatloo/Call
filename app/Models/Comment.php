<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'call_id',
        'admin_id',
        'order_id',
        'description',
    ];
}
