<?php


namespace App\Identity\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Identity\Models\Connection
 *
 * @property int $id
 * @property int $userId
 * @property string $provider
 * @property string $providerId
 * @property string $token
 * @property array $profile
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Identity\Models\Connection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Identity\Models\Connection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Identity\Models\Connection query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Identity\Models\Connection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Identity\Models\Connection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Identity\Models\Connection whereProfile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Identity\Models\Connection whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Identity\Models\Connection whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Identity\Models\Connection whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Identity\Models\Connection whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Identity\Models\Connection whereUserId($value)
 * @mixin \Eloquent
 */
class Connection extends Model
{
    protected $fillable = ['provider', 'providerId'];

    protected $casts = [
        "profile" => 'array',
    ];

    const PROVIDER_VKONTAKTE = 'vkontakte';
    const PROVIDER_VKONTAKTE_GROUP = 'vkontakte_group';
}
