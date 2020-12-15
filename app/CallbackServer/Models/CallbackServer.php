<?php

namespace App\CallbackServer\Models;

use Illuminate\Database\Eloquent\Model;

class CallbackServer extends Model
{
    protected $fillable = ['projectId', 'code', 'data'];

    protected $casts = [
        'data' => 'array',
    ];
}
