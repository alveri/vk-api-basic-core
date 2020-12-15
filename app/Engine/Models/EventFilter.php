<?php


namespace App\Engine\Models;

use Illuminate\Database\Eloquent\Model;

class EventFilter extends Model
{
    protected $table = 'event_filters';
    protected $fillable = ['projectId', 'sectionId', 'data'];
    protected $casts = [
        'data' => 'array',
    ];
}
