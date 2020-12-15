<?php


namespace App\Projects;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Projects\Project
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Projects\Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Projects\Project newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Projects\Project query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Projects\Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Projects\Project whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Projects\Project whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Projects\Project whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Project extends Model
{
    protected $fillable = ['name', 'isArchived'];
}
