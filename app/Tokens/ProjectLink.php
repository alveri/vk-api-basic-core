<?php


namespace App\Tokens;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class ProjectLink extends Model
{
    protected $table = 'project_links';
    protected $fillable = ['projectId', 'tokenId'];
}
