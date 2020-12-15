<?php

namespace App\Identity\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Identity\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $avatar
 * @property string $username
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Identity\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Identity\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Identity\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Identity\Models\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Identity\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Identity\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Identity\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Identity\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Identity\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Identity\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Identity\Models\User whereUsername($value)
 * @mixin \Eloquent
 */
class User extends Model implements Authenticatable
{
    use \Illuminate\Auth\Authenticatable;

    protected $hidden = [
        'password', 'remember_token'
    ];
}
