<?php


namespace App\Projects;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Projects\ProjectMember
 *
 * @property int $id
 * @property int $userId
 * @property int $projectId
 * @property string $role
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Projects\ProjectMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Projects\ProjectMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Projects\ProjectMember query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Projects\ProjectMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Projects\ProjectMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Projects\ProjectMember whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Projects\ProjectMember whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Projects\ProjectMember whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Projects\ProjectMember whereUserId($value)
 * @mixin \Eloquent
 */
class ProjectMember extends Model
{
    protected $fillable = ['userId', 'projectId', 'role'];
}
