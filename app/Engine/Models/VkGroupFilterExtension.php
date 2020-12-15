<?php

namespace App\Engine\Models;

use Illuminate\Database\Eloquent\Model;

class VkGroupFilterExtension extends Model
{
    protected $table = 'vk_group_filters_extension';
    protected $fillable = ['projectId', 'eventFilterId', 'groupId'];
}
